<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnershipApplication;
use Illuminate\Http\Request;

class AdminPartnershipApplicationsController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('applications.view');

        $status = $request->state('status', '') ?? '';
        $search = $request->state('search', '') ?? '';

        $query = PartnershipApplication::query()
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'ilike', "%{$search}%")
                    ->orWhere('contact_name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $applications = $query->paginate(30);
        $pendingCount = PartnershipApplication::where('status', 'pending')->count();

        if ($request->isGale()) {
            return gale()->fragment('admin.applications.partnerships', 'applications-list', compact('applications', 'pendingCount'));
        }

        return gale()->view('admin.applications.partnerships', compact('applications', 'pendingCount'), web: true);
    }

    public function show(Request $request, PartnershipApplication $application): mixed
    {
        $this->authorize('applications.view');

        if ($application->status === 'pending') {
            $application->update(['status' => 'reviewed']);
        }

        $pendingCount = PartnershipApplication::where('status', 'pending')->count();
        $applications = PartnershipApplication::query()
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return gale()
            ->fragment('admin.applications.partnerships', 'application-detail', compact('application'))
            ->fragment('admin.applications.partnerships', 'applications-list', compact('applications', 'pendingCount'));
    }

    public function updateStatus(Request $request, PartnershipApplication $application): mixed
    {
        $this->authorize('applications.edit');

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $application->update($validated);

        activity('admin')->causedBy(auth()->user())
            ->performedOn($application)
            ->log("Statut mis à jour : {$validated['status']}");

        $message = match ($validated['status']) {
            'accepted' => 'Partenariat accepté',
            'rejected' => 'Partenariat rejeté',
            default => 'Statut mis à jour',
        };

        return gale()
            ->state('status', $application->status)
            ->dispatch('toast', ['message' => $message, 'type' => 'success']);
    }

    public function exportCsv(): mixed
    {
        $this->authorize('applications.view');

        $applications = PartnershipApplication::query()
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'partenariats-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $typeLabels = [
            'ngo' => 'ONG',
            'government' => 'Gouvernement',
            'private' => 'Secteur privé',
            'other' => 'Autre',
        ];

        $statusLabels = [
            'pending' => 'Nouveau',
            'reviewed' => 'En cours',
            'accepted' => 'Accepté',
            'rejected' => 'Rejeté',
        ];

        $callback = function () use ($applications, $typeLabels, $statusLabels) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['Organisation', 'Contact', 'Email', 'Téléphone', 'Type', 'Statut', 'Date'], ';');

            foreach ($applications as $app) {
                fputcsv($handle, [
                    $app->organization_name,
                    $app->contact_name,
                    $app->email,
                    $app->phone ?? '',
                    $typeLabels[$app->organization_type] ?? $app->organization_type,
                    $statusLabels[$app->status] ?? $app->status,
                    $app->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
