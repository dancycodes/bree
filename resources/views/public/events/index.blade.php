@extends('layouts.public')

@section('title', __('events.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('events.meta_description'))

@push('head')
<style>
@keyframes pastFadeIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
/* Past event card grayscale + muted treatment */
.event-card-past {
    opacity: 0.72;
    filter: grayscale(0.55);
    transition: opacity 0.25s ease, filter 0.25s ease, box-shadow 0.25s ease;
}
.event-card-past:hover {
    opacity: 0.88;
    filter: grayscale(0.25);
    box-shadow: 0 6px 28px rgba(0,20,50,0.12);
}
/* Upcoming card hover */
.event-card-upcoming {
    transition: box-shadow 0.25s ease, border-color 0.25s ease;
}
.event-card-upcoming:hover {
    box-shadow: 0 8px 32px rgba(0,20,50,0.10);
    border-color: rgba(200,0,120,0.18) !important;
}
/* Thumbnail placeholder when no image */
.event-thumb-placeholder {
    background-color: #002850;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(300px, 38vw, 440px);">

        <img src="{{ vasset('images/sections/events-placeholder.jpg') }}"
             alt="{{ __('events.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">

        {{-- Solid dark overlay — NO gradient per brand rules --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.78);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('events.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('events.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('events.hero_heading') }}
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.68);"
               data-animate="fade-up">
                {{ __('events.meta_description') }}
            </p>

            <div class="mt-6 h-0.5 w-16" style="background-color: #c8a03c;"></div>

        </div>

    </section>

    {{-- ================================================================
         UPCOMING EVENTS
         ================================================================ --}}
    <section class="py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section heading --}}
            <div class="flex items-center gap-4 mb-10" data-animate="fade-up">
                <div class="w-1 h-10 rounded-full flex-shrink-0" style="background-color: #c80078;"></div>
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #c80078;">
                        {{ __('events.hero_label') }}
                    </p>
                    <h2 class="bree-section-h2">
                        {{ __('events.upcoming_title') }}
                    </h2>
                </div>
            </div>

            @if ($upcoming->isEmpty())
                {{-- Empty state --}}
                <div class="py-16 text-center rounded-2xl bg-white" data-animate="fade-up"
                     style="border: 1px solid rgba(0,0,0,0.06);">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-full flex items-center justify-center"
                         style="background-color: rgba(200,0,120,0.08);">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c80078;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold mb-1" style="color: #143c64;">{{ __('events.no_upcoming') }}</p>
                    <p class="text-sm" style="color: #94a3b8;">{{ __('events.no_upcoming_sub') }}</p>
                </div>
            @else
                <div class="space-y-5" data-stagger="0.07">
                    @foreach ($upcoming as $event)
                        @php
                            $regCount = $event->registrations_count ?? 0;
                            $hasCapacity = $event->registration_required && $event->max_capacity;
                            $isFull = $hasCapacity && $regCount >= $event->max_capacity;
                            $isLastFew = $hasCapacity && !$isFull && ($event->max_capacity - $regCount) <= max(1, intval($event->max_capacity * 0.15));
                        @endphp
                        <article class="event-card-upcoming bg-white rounded-2xl overflow-hidden"
                                 style="border: 1px solid rgba(0,0,0,0.06);"
                                 data-animate="fade-up">
                            <div class="flex flex-col sm:flex-row">

                                {{-- Date block --}}
                                <div class="sm:w-28 flex-shrink-0 flex flex-row sm:flex-col items-center justify-center gap-3 sm:gap-0 p-4 sm:p-0"
                                     style="background-color: #c80078; min-height: 140px;">
                                    <span class="font-bold leading-none text-white"
                                          style="font-family: 'Playfair Display', serif; font-size: clamp(2.25rem, 4.5vw, 3rem);">
                                        {{ $event->event_date->format('d') }}
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-widest"
                                          style="color: rgba(255,255,255,0.82);">
                                        {{ $event->event_date->translatedFormat('M') }}
                                    </span>
                                    <span class="text-xs font-medium"
                                          style="color: rgba(255,255,255,0.65);">
                                        {{ $event->event_date->format('Y') }}
                                    </span>
                                </div>

                                {{-- Thumbnail --}}
                                <div class="hidden md:block sm:w-48 flex-shrink-0 overflow-hidden" style="min-height: 140px;">
                                    @if ($event->thumbnail_path)
                                        <img src="{{ vasset($event->thumbnail_path) }}"
                                             alt="{{ $event->title() }}"
                                             class="w-full h-full object-cover"
                                             style="min-height: 140px;">
                                    @else
                                        <div class="event-thumb-placeholder w-full h-full" style="min-height: 140px;">
                                            <span class="text-white text-center px-4 text-xs font-semibold leading-snug opacity-60">
                                                {{ $event->title() }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 p-5 sm:p-6 flex flex-col justify-between">
                                    <div>

                                        {{-- Capacity badge --}}
                                        @if ($event->registration_required)
                                            <div class="mb-3">
                                                @if ($isFull)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                          style="background-color: rgba(239,68,68,0.10); color: #dc2626;">
                                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #dc2626;"></span>
                                                        {{ __('events.capacity_full') }}
                                                    </span>
                                                @elseif ($isLastFew)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                          style="background-color: rgba(200,160,60,0.12); color: #a07020;">
                                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #c8a03c;"></span>
                                                        {{ __('events.capacity_last') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                          style="background-color: rgba(22,163,74,0.10); color: #15803d;">
                                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #16a34a;"></span>
                                                        {{ __('events.capacity_available') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <h3 class="font-bold mb-2 leading-snug"
                                            style="font-family: 'Playfair Display', serif;
                                                   font-size: clamp(1rem, 2vw, 1.2rem);
                                                   color: #002850;
                                                   line-height: 1.3;">
                                            {{ $event->title() }}
                                        </h3>

                                        {{-- Location + time --}}
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mb-3">
                                            @if ($event->location())
                                                <span class="flex items-center gap-1.5 text-xs font-medium"
                                                      style="color: #475569;">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" stroke-width="2" style="color: #c80078;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                                    </svg>
                                                    {{ $event->location() }}
                                                </span>
                                            @endif
                                            @if ($event->event_time)
                                                <span class="flex items-center gap-1.5 text-xs font-medium"
                                                      style="color: #475569;">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" stroke-width="2" style="color: #c80078;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                                                </span>
                                            @endif
                                        </div>

                                        @php
                                            $desc = app()->getLocale() === 'fr' ? $event->description_fr : $event->description_en;
                                        @endphp
                                        @if ($desc)
                                            <p class="text-sm leading-relaxed line-clamp-2" style="color: #5a6a7a;">
                                                {{ $desc }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('public.events.show', $event) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-bold transition-opacity hover:opacity-75"
                                           style="color: #c80078;">
                                            {{ __('events.view_event') }}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    {{-- ================================================================
         PAST EVENTS
         ================================================================ --}}
    @if ($past->isNotEmpty())
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section heading --}}
                <div class="flex items-center gap-4 mb-10" data-animate="fade-up">
                    <div class="w-1 h-10 rounded-full flex-shrink-0" style="background-color: #94a3b8;"></div>
                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('events.hero_label') }}
                        </p>
                        <h2 class="bree-section-h2"
                            style="color: #475569;">
                            {{ __('events.past_title') }}
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($past as $event)
                        <article class="event-card-past rounded-2xl overflow-hidden bg-white"
                                 style="animation: pastFadeIn 0.55s ease both; animation-delay: {{ $loop->index * 0.07 }}s;
                                        border: 1px solid #e2e8f0;">

                            {{-- Thumbnail with past badge overlay --}}
                            <div class="overflow-hidden relative" style="height: 168px;">
                                @if ($event->thumbnail_path)
                                    <img src="{{ vasset($event->thumbnail_path) }}"
                                         alt="{{ $event->title() }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="event-thumb-placeholder w-full h-full">
                                        <span class="text-white text-center px-4 text-xs font-semibold leading-snug opacity-50">
                                            {{ $event->title() }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Date badge top-left --}}
                                <div class="absolute top-3 left-3 px-2.5 py-1.5 rounded-lg"
                                     style="background-color: rgba(0,40,80,0.85);">
                                    <span class="text-xs font-bold text-white">
                                        {{ $event->event_date->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                {{-- Past event badge top-right --}}
                                <div class="absolute top-3 right-3 px-2 py-1 rounded-md"
                                     style="background-color: rgba(0,0,0,0.55);">
                                    <span class="text-xs font-semibold" style="color: rgba(255,255,255,0.8);">
                                        {{ __('events.past_badge') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5" style="background-color: #f8f5f0;">
                                <h3 class="font-semibold mb-2 leading-snug line-clamp-2"
                                    style="font-size: 0.95rem; color: #334155; line-height: 1.4;">
                                    {{ $event->title() }}
                                </h3>

                                @if ($event->location())
                                    <p class="flex items-center gap-1.5 text-xs mb-3" style="color: #64748b;">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2" style="color: #c8a03c;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        {{ $event->location() }}
                                    </p>
                                @endif

                                <a href="{{ route('public.events.show', $event) }}"
                                   class="inline-flex items-center gap-1 text-xs font-semibold transition-opacity hover:opacity-75"
                                   style="color: #475569;">
                                    {{ __('events.view_event') }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                    </svg>
                                </a>
                            </div>

                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

@endsection
