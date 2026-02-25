<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationPledge;
use App\Models\InKindDonation;
use App\Models\RecurringDonation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminDonationsController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('donations.view');

        $type = $request->state('type', 'all') ?? 'all';
        $status = $request->state('status', '') ?? '';
        $search = $request->state('search', '') ?? '';

        $donations = $this->buildUnified($type, $status, $search);

        $page = (int) $request->input('page', 1);
        $perPage = 30;
        $paginated = new LengthAwarePaginator(
            $donations->forPage($page, $perPage)->values(),
            $donations->count(),
            $perPage,
            $page,
            ['path' => route('admin.donations.index')]
        );

        if ($request->isGale()) {
            return gale()->fragment('admin.donations.index', 'donations-list', ['donations' => $paginated]);
        }

        return gale()->view('admin.donations.index', ['donations' => $paginated], web: true);
    }

    /** @return Collection<int, array<string, mixed>> */
    private function buildUnified(string $type, string $status, string $search): Collection
    {
        $results = collect();

        if ($type === 'all' || $type === 'direct') {
            $query = Donation::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('donor_email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (Donation $d) => [
                'type' => 'direct',
                'donor_name' => $d->donor_name,
                'donor_email' => $d->donor_email,
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
            ]));
        }

        if ($type === 'all' || $type === 'recurring') {
            $query = RecurringDonation::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('donor_email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (RecurringDonation $d) => [
                'type' => 'recurring',
                'donor_name' => $d->donor_name,
                'donor_email' => $d->donor_email,
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
            ]));
        }

        if ($type === 'all' || $type === 'pledge') {
            $query = DonationPledge::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'ilike', "%{$search}%")
                        ->orWhere('last_name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (DonationPledge $d) => [
                'type' => 'pledge',
                'donor_name' => $d->first_name.' '.$d->last_name,
                'donor_email' => $d->email,
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
            ]));
        }

        if ($type === 'all' || $type === 'inkind') {
            $query = InKindDonation::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (InKindDonation $d) => [
                'type' => 'inkind',
                'donor_name' => $d->donor_name,
                'donor_email' => $d->email,
                'amount' => $d->estimated_value,
                'currency' => 'XAF',
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
            ]));
        }

        return $results->sortByDesc('date');
    }
}
