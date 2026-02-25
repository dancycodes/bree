<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundationEvent;
use App\Models\ProgramCard;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('events.view');

        $status = $request->input('status', 'all');
        $search = trim((string) $request->input('search', ''));

        $query = FoundationEvent::withCount('registrations')->orderByDesc('event_date');

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title_fr', 'ilike', "%{$search}%")
                    ->orWhere('title_en', 'ilike', "%{$search}%");
            });
        }

        $events = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => FoundationEvent::count(),
            'published' => FoundationEvent::where('is_published', true)->count(),
            'draft' => FoundationEvent::where('is_published', false)->count(),
        ];

        if ($request->isGaleNavigate('events-table')) {
            return gale()->fragment('admin.events.index', 'events-table', compact('events', 'status', 'search', 'counts'));
        }

        return gale()->view('admin.events.index', compact('events', 'status', 'search', 'counts'), web: true);
    }

    public function create(): mixed
    {
        $this->authorize('events.create');

        $programs = ProgramCard::active()->get();

        return gale()->view('admin.events.create', compact('programs'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('events.create');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:foundation_events,slug',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'location_fr' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'end_time' => 'nullable|date_format:H:i',
            'program_slug' => 'nullable|string|max:100',
            'registration_required' => 'boolean',
            'max_capacity' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $event = FoundationEvent::create([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'location_fr' => $request->input('location_fr') ? strip_tags($request->input('location_fr')) : null,
            'location_en' => $request->input('location_en') ? strip_tags($request->input('location_en')) : null,
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time') ? $request->input('event_time').':00' : null,
            'end_date' => $request->input('end_date') ?: null,
            'end_time' => $request->input('end_time') ? $request->input('end_time').':00' : null,
            'program_slug' => $request->input('program_slug') ?: null,
            'registration_required' => (bool) $request->input('registration_required', false),
            'max_capacity' => $request->input('max_capacity') ?: null,
            'is_published' => (bool) $request->input('is_published', false),
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('events', 'public');
            $event->update(['thumbnail_path' => 'storage/'.$path]);
        }

        return gale()->redirect(route('admin.events.edit', $event));
    }

    public function edit(FoundationEvent $event): mixed
    {
        $this->authorize('events.edit');

        $programs = ProgramCard::active()->get();

        return gale()->view('admin.events.edit', compact('event', 'programs'), web: true);
    }

    public function update(Request $request, FoundationEvent $event): mixed
    {
        $this->authorize('events.edit');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:foundation_events,slug,'.$event->id,
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'location_fr' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'end_time' => 'nullable|date_format:H:i',
            'program_slug' => 'nullable|string|max:100',
            'registration_required' => 'boolean',
            'max_capacity' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $thumbnailPath = $event->thumbnail_path;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('events', 'public');
            $thumbnailPath = 'storage/'.$path;
        }

        $event->update([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'location_fr' => $request->input('location_fr') ? strip_tags($request->input('location_fr')) : null,
            'location_en' => $request->input('location_en') ? strip_tags($request->input('location_en')) : null,
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time') ? $request->input('event_time').':00' : null,
            'end_date' => $request->input('end_date') ?: null,
            'end_time' => $request->input('end_time') ? $request->input('end_time').':00' : null,
            'program_slug' => $request->input('program_slug') ?: null,
            'registration_required' => (bool) $request->input('registration_required', false),
            'max_capacity' => $request->input('max_capacity') ?: null,
            'is_published' => (bool) $request->input('is_published', false),
            'thumbnail_path' => $thumbnailPath,
        ]);

        return gale()->dispatch('toast', ['message' => 'Événement sauvegardé', 'type' => 'success']);
    }

    public function destroy(FoundationEvent $event): mixed
    {
        $this->authorize('events.delete');

        $event->delete();

        $status = 'all';
        $search = '';
        $events = FoundationEvent::withCount('registrations')->orderByDesc('event_date')->paginate(20)->withQueryString();
        $counts = [
            'all' => FoundationEvent::count(),
            'published' => FoundationEvent::where('is_published', true)->count(),
            'draft' => FoundationEvent::where('is_published', false)->count(),
        ];

        return gale()
            ->fragment('admin.events.index', 'events-table', compact('events', 'status', 'search', 'counts'))
            ->dispatch('toast', ['message' => 'Événement supprimé', 'type' => 'success']);
    }
}
