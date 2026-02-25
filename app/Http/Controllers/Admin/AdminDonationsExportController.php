<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationPledge;
use App\Models\InKindDonation;
use App\Models\RecurringDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminDonationsExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $this->authorize('donations.export');

        $type = $request->query('type', 'all') ?: 'all';
        $status = $request->query('status', '') ?: '';
        $search = $request->query('search', '') ?: '';

        $donations = $this->buildUnified($type, $status, $search);

        $filename = 'dons-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($donations): void {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Nom',
                'Email',
                'Type',
                'Montant',
                'Devise',
                'Programme',
                'Statut',
                'Date',
                'Référence',
            ], ';');

            foreach ($donations as $row) {
                fputcsv($handle, [
                    $row['donor_name'] ?? '',
                    $row['donor_email'] ?? '',
                    $row['type'] ?? '',
                    $row['amount'] ?? '',
                    $row['currency'] ?? '',
                    $row['programme'] ?? '',
                    $row['status'] ?? '',
                    $row['date']?->toIso8601String() ?? '',
                    $row['reference'] ?? '',
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
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
                $query->where(function ($q) use ($search): void {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('donor_email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (Donation $d) => [
                'donor_name' => $d->donor_name,
                'donor_email' => $d->donor_email,
                'type' => 'Ponctuel',
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
                'reference' => $d->tx_ref ?? '',
            ]));
        }

        if ($type === 'all' || $type === 'recurring') {
            $query = RecurringDonation::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search): void {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('donor_email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (RecurringDonation $d) => [
                'donor_name' => $d->donor_name,
                'donor_email' => $d->donor_email,
                'type' => 'Récurrent',
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
                'reference' => '',
            ]));
        }

        if ($type === 'all' || $type === 'pledge') {
            $query = DonationPledge::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search): void {
                    $q->where('first_name', 'ilike', "%{$search}%")
                        ->orWhere('last_name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (DonationPledge $d) => [
                'donor_name' => $d->first_name.' '.$d->last_name,
                'donor_email' => $d->email,
                'type' => 'Promesse',
                'amount' => $d->amount,
                'currency' => $d->currency,
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
                'reference' => '',
            ]));
        }

        if ($type === 'all' || $type === 'inkind') {
            $query = InKindDonation::query()->latest();
            if ($status) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function ($q) use ($search): void {
                    $q->where('donor_name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            }
            $results = $results->merge($query->get()->map(fn (InKindDonation $d) => [
                'donor_name' => $d->donor_name,
                'donor_email' => $d->email,
                'type' => 'Don en nature',
                'amount' => $d->estimated_value,
                'currency' => 'XAF',
                'programme' => $d->programme,
                'status' => $d->status,
                'date' => $d->created_at,
                'reference' => '',
            ]));
        }

        return $results->sortByDesc('date');
    }
}
