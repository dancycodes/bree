<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class AdminNewsletterController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('newsletter.view');

        $subscribers = NewsletterSubscriber::query()
            ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
            ->orderBy('subscribed_at', 'desc')
            ->paginate(50);

        $activeCount = NewsletterSubscriber::where('status', 'active')->count();
        $totalCount = NewsletterSubscriber::count();

        return gale()->view('admin.newsletter.index', compact('subscribers', 'activeCount', 'totalCount'), web: true);
    }

    public function destroy(Request $request, NewsletterSubscriber $subscriber): mixed
    {
        $this->authorize('newsletter.view');

        $subscriber->update(['status' => 'unsubscribed']);

        $subscribers = NewsletterSubscriber::query()
            ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
            ->orderBy('subscribed_at', 'desc')
            ->paginate(50);

        $activeCount = NewsletterSubscriber::where('status', 'active')->count();
        $totalCount = NewsletterSubscriber::count();

        return gale()
            ->fragment('admin.newsletter.index', 'subscribers-list', compact('subscribers', 'activeCount', 'totalCount'))
            ->dispatch('toast', ['message' => 'Abonné désactivé', 'type' => 'success']);
    }

    public function exportCsv(): mixed
    {
        $this->authorize('newsletter.export');

        $subscribers = NewsletterSubscriber::where('status', 'active')
            ->orderBy('subscribed_at', 'desc')
            ->get();

        $filename = 'newsletter-abonnes-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['Email', 'Langue', 'Date d\'inscription'], ';');

            foreach ($subscribers as $subscriber) {
                fputcsv($handle, [
                    $subscriber->email,
                    strtoupper($subscriber->locale),
                    $subscriber->subscribed_at?->format('d/m/Y H:i') ?? $subscriber->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
