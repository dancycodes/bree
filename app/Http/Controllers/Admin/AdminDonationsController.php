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

    public function showPledge(DonationPledge $pledge): mixed
    {
        $this->authorize('donations.view');

        $activity = \Spatie\Activitylog\Models\Activity::where('subject_type', DonationPledge::class)
            ->where('subject_id', $pledge->id)
            ->latest()
            ->get();

        return gale()->view('admin.donations.pledge', compact('pledge', 'activity'), web: true);
    }

    public function updatePledgeStatus(Request $request, DonationPledge $pledge): mixed
    {
        $this->authorize('donations.edit');

        $request->validate([
            'status' => 'required|in:pending,confirmed,fulfilled',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $pledge->status;
        $pledge->update([
            'status' => $request->input('status'),
            'admin_notes' => $request->input('admin_notes', $pledge->admin_notes),
        ]);

        activity('admin')
            ->causedBy(auth()->user())
            ->performedOn($pledge)
            ->log("Statut changé de {$oldStatus} à {$pledge->status}");

        $statusLabels = [
            'confirmed' => 'Promesse confirmée',
            'fulfilled' => 'Promesse honorée',
            'pending' => 'Remis en attente',
        ];

        return gale()
            ->state('status', $pledge->status)
            ->dispatch('toast', [
                'message' => $statusLabels[$pledge->status] ?? 'Statut mis à jour',
                'type' => 'success',
            ]);
    }

    public function showInKind(InKindDonation $inkind): mixed
    {
        $this->authorize('donations.view');

        $activity = \Spatie\Activitylog\Models\Activity::where('subject_type', InKindDonation::class)
            ->where('subject_id', $inkind->id)
            ->latest()
            ->get();

        return gale()->view('admin.donations.inkind', compact('inkind', 'activity'), web: true);
    }

    public function updateInKindStatus(Request $request, InKindDonation $inkind): mixed
    {
        $this->authorize('donations.edit');

        $request->validate([
            'status' => 'required|in:pending_review,accepted,declined',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $inkind->status;
        $inkind->update([
            'status' => $request->input('status'),
            'admin_notes' => $request->input('admin_notes', $inkind->admin_notes),
        ]);

        activity('admin')
            ->causedBy(auth()->user())
            ->performedOn($inkind)
            ->log("Statut changé de {$oldStatus} à {$inkind->status}");

        $statusLabels = [
            'accepted' => 'Don en nature accepté',
            'declined' => 'Don en nature refusé',
            'pending_review' => 'Remis en révision',
        ];

        return gale()
            ->state('status', $inkind->status)
            ->dispatch('toast', [
                'message' => $statusLabels[$inkind->status] ?? 'Statut mis à jour',
                'type' => 'success',
            ]);
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
                'id' => $d->id,
                'type' => 'direct',
                'detail_url' => null,
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
                'id' => $d->id,
                'type' => 'recurring',
                'detail_url' => null,
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
                'id' => $d->id,
                'type' => 'pledge',
                'detail_url' => route('admin.donations.pledge.show', $d),
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
                'id' => $d->id,
                'type' => 'inkind',
                'detail_url' => route('admin.donations.inkind.show', $d),
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
