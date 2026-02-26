<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\DonationPledge;
use App\Models\FoundationEvent;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index(): mixed
    {
        return gale()->view('admin.dashboard', $this->metrics(), web: true);
    }

    public function refresh(): mixed
    {
        return gale()->fragment('admin.dashboard', 'metrics', $this->metrics());
    }

    /** @return array<string, mixed> */
    private function metrics(): array
    {
        $user = auth()->user();
        $canViewDonations = $user?->can('donations.view') ?? false;

        return [
            'canViewDonations' => $canViewDonations,
            'donationsTotalMonth' => $canViewDonations
                ? (float) Donation::where('status', 'completed')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('amount')
                : null,
            'donationsTotalAllTime' => $canViewDonations
                ? (float) Donation::where('status', 'completed')->sum('amount')
                : null,
            'pledgesPending' => $canViewDonations
                ? DonationPledge::where('status', 'pending')->count()
                : null,
            'unreadMessages' => ContactMessage::where('status', 'new')->count(),
            'upcomingEvents' => FoundationEvent::upcoming()->count(),
            'recentActivity' => Activity::latest()->limit(10)->get(),
        ];
    }
}
