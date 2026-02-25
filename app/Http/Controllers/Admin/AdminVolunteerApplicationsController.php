<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnershipApplication;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;

class AdminVolunteerApplicationsController extends Controller
{
    public function hub(): mixed
    {
        $this->authorize('applications.view');

        $volunteerPending = VolunteerApplication::where('status', 'pending')->count();
        $volunteerTotal = VolunteerApplication::count();
        $partnershipPending = PartnershipApplication::where('status', 'pending')->count();
        $partnershipTotal = PartnershipApplication::count();

        return gale()->view('admin.applications.index', compact(
            'volunteerPending',
            'volunteerTotal',
            'partnershipPending',
            'partnershipTotal',
        ), web: true);
    }

    public function index(Request $request): mixed
    {
        $this->authorize('applications.view');

        $status = $request->state('status', '') ?? '';
        $search = $request->state('search', '') ?? '';

        $query = VolunteerApplication::query()
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

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

        $applications = $query->paginate(30);
        $pendingCount = VolunteerApplication::where('status', 'pending')->count();

        if ($request->isGale()) {
            return gale()->fragment('admin.applications.volunteers', 'applications-list', compact('applications', 'pendingCount'));
        }

        return gale()->view('admin.applications.volunteers', compact('applications', 'pendingCount'), web: true);
    }

    public function show(Request $request, VolunteerApplication $application): mixed
    {
        $this->authorize('applications.view');

        if ($application->status === 'pending') {
            $application->update(['status' => 'reviewed']);
        }

        $pendingCount = VolunteerApplication::where('status', 'pending')->count();
        $applications = VolunteerApplication::query()
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return gale()
            ->fragment('admin.applications.volunteers', 'application-detail', compact('application'))
            ->fragment('admin.applications.volunteers', 'applications-list', compact('applications', 'pendingCount'));
    }

    public function updateStatus(Request $request, VolunteerApplication $application): mixed
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
            'accepted' => 'Candidature acceptée',
            'rejected' => 'Candidature rejetée',
            default => 'Statut mis à jour',
        };

        return gale()
            ->state('status', $application->status)
            ->dispatch('toast', ['message' => $message, 'type' => 'success']);
    }

    public function exportCsv(): mixed
    {
        $this->authorize('applications.view');

        $applications = VolunteerApplication::query()
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'benevoles-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $areaLabels = [
            'protege' => 'Protège',
            'eleve' => 'Élève',
            'respire' => 'Respire',
        ];

        $availabilityLabels = [
            'weekends' => 'Week-ends',
            'weekdays' => 'Jours de semaine',
            'flexible' => 'Flexible',
        ];

        $statusLabels = [
            'pending' => 'Nouveau',
            'reviewed' => 'En cours',
            'accepted' => 'Accepté',
            'rejected' => 'Rejeté',
        ];

        $callback = function () use ($applications, $areaLabels, $availabilityLabels, $statusLabels) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['Prénom', 'Nom', 'Email', 'Téléphone', 'Ville/Pays', 'Domaines', 'Disponibilité', 'Statut', 'Date'], ';');

            foreach ($applications as $app) {
                $areas = collect($app->areas_of_interest)
                    ->map(fn ($a) => $areaLabels[$a] ?? $a)
                    ->implode(', ');

                fputcsv($handle, [
                    $app->first_name,
                    $app->last_name,
                    $app->email,
                    $app->phone ?? '',
                    $app->city_country ?? '',
                    $areas,
                    $availabilityLabels[$app->availability] ?? $app->availability,
                    $statusLabels[$app->status] ?? $app->status,
                    $app->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
