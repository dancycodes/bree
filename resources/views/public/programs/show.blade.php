@extends('layouts.public')

@section('title', $program->name() . ' — ' . config('app.name'))
@section('meta_description', $program->description())

@section('content')

    {{-- ================================================================
         PAGE HERO
         Large image with flat navy overlay, program color accent on name.
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(340px, 50vw, 560px);">

        {{-- Background image --}}
        <img
            src="{{ asset($program->image_path) }}"
            alt="{{ $program->name() }}"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- Flat dark overlay (NO gradient — solid rgba only) --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.75);"></div>

        {{-- Content pinned to bottom --}}
        <div class="relative z-10 h-full flex flex-col justify-end
                    max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            {{-- Breadcrumb --}}
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium flex-wrap"
                    style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors duration-200">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li>
                        <a href="{{ route('public.programs') }}"
                           class="hover:text-white transition-colors duration-200">
                            {{ __('programs.page_title') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;">{{ $program->name() }}</li>
                </ol>
            </nav>

            {{-- Program identity tag --}}
            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: {{ $program->color }};"
                  data-animate="fade-up">
                {{ __('programs.impact_label') }}
            </span>

            {{-- Program name --}}
            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2.25rem, 6vw, 4rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ $program->name() }}
            </h1>

            {{-- Color underline --}}
            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: {{ $program->color }};"></div>

        </div>

    </section>

    {{-- ================================================================
         IMPACT STATS
         Four oversized numbers animated from 0 on scroll-entry (GSAP counter).
         Wraps: 2x2 on tablet, 4-col on desktop, 1-col on mobile.
         ================================================================ --}}
    @php $stats = $program->stats(); @endphp
    @if (count($stats) > 0)
        <section class="py-14 lg:py-20" style="background-color: {{ $program->color }};">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(count($stats), 4) }} gap-0">
                    @foreach ($stats as $i => $stat)
                        @php
                            // Extract numeric part for GSAP counter
                            preg_match('/(\d[\d\s,.]*)/', $stat['number'], $m);
                            $numericPart = isset($m[1]) ? (int) preg_replace('/\D/', '', $m[1]) : 0;
                            // Detect suffix like "+", "k" etc.
                            $suffix = preg_replace('/[\d\s,.]+/', '', $stat['number']);
                        @endphp
                        <div class="stat-item text-center py-10 px-6 relative"
                             data-animate="fade-up"
                             style="{{ $i > 0 ? 'border-left: 1px solid rgba(255,255,255,0.2);' : '' }}">

                            {{-- Large animated number --}}
                            <div class="font-heading font-bold leading-none"
                                 style="font-family: 'Playfair Display', serif;
                                        font-size: clamp(3rem, 7vw, 5.5rem);
                                        color: #ffffff;">
                                <span data-counter="{{ $numericPart }}"
                                      class="prog-counter">{{ $numericPart }}</span><span
                                      class="text-3xl lg:text-4xl align-top mt-2 inline-block"
                                      style="color: rgba(255,255,255,0.7);">{{ $suffix }}</span>
                            </div>

                            {{-- Label --}}
                            <div class="mt-3 text-sm font-semibold tracking-wide uppercase"
                                 style="color: rgba(255,255,255,0.75);">
                                {{ $stat['label'] }}
                            </div>

                            {{-- Separator line on mobile --}}
                            @if (! $loop->last)
                                <div class="sm:hidden absolute bottom-0 left-8 right-8 h-px"
                                     style="background-color: rgba(255,255,255,0.2);"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         DESCRIPTION + ACTIVITIES
         Two-column: long description left, activities as styled cards right.
         ================================================================ --}}
    <section class="py-20 lg:py-28" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-start">

                {{-- Left: Full description --}}
                <div data-animate="fade-right">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                          style="color: {{ $program->color }};">
                        {{ __('programs.our_mission') }}
                    </span>
                    <h2 class="bree-section-h2 mb-6">
                        {{ __('programs.what_we_do') }}
                    </h2>
                    <p class="text-base leading-relaxed mb-8" style="color: #5a6a7a;">
                        {{ $program->longDescription() ?: $program->description() }}
                    </p>

                    {{-- Donate CTA --}}
                    @if (Route::has('public.donate'))
                        <a href="{{ route('public.donate') }}?programme={{ $program->slug }}"
                           class="btn-primary rounded-full px-7 py-3.5 text-sm">
                            {{ __('programs.donate_for_program', ['name' => $program->name()]) }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Right: Activities as styled cards (NOT a plain <ul>) --}}
                <div data-animate="fade-left">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-6"
                          style="color: {{ $program->color }};">
                        {{ __('programs.our_actions') }}
                    </span>

                    @php $activities = $program->activities(); @endphp
                    @if (count($activities) > 0)
                        <div class="flex flex-col gap-3" data-stagger="0.08">
                            @foreach ($activities as $idx => $activity)
                                <div class="activity-card flex items-start gap-4 rounded-xl p-4
                                            transition-all duration-200 hover:shadow-sm"
                                     style="background-color: #f8f5f0;
                                            border-left: 3px solid {{ $program->color }};"
                                     data-animate="fade-up">

                                    {{-- Number badge --}}
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full
                                                flex items-center justify-center text-xs font-bold text-white"
                                         style="background-color: {{ $program->color }};">
                                        {{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    {{-- Activity name --}}
                                    <span class="text-sm leading-relaxed font-medium pt-1"
                                          style="color: #143c64;">
                                        {{ $activity }}
                                    </span>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </section>

    {{-- ================================================================
         TESTIMONIAL / BENEFICIARY STORIES
         Only shown when stories exist. Quote in italic Playfair,
         left border in program color, clear attribution below.
         ================================================================ --}}
    @if ($program->stories->isNotEmpty())
        <section class="py-20 lg:py-24" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section header --}}
                <div class="text-center mb-14" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: {{ $program->color }};">
                        {{ __('programs.testimonials_label') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('programs.testimonials_title') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-stagger="0.1">
                    @foreach ($program->stories as $story)
                        <div class="rounded-xl bg-white p-8 relative"
                             style="border-left: 4px solid {{ $program->color }};
                                    box-shadow: 0 2px 16px rgba(0,0,0,0.06);"
                             data-animate="fade-up">

                            {{-- Large quotation mark --}}
                            <div class="absolute top-5 right-6 text-6xl font-bold leading-none select-none"
                                 style="color: {{ $program->color }}1a;
                                        font-family: 'Playfair Display', serif;">
                                &ldquo;
                            </div>

                            {{-- Quote body --}}
                            <blockquote class="font-heading italic mb-6 relative z-10"
                                        style="font-family: 'Playfair Display', serif;
                                               font-size: clamp(0.9rem, 1.8vw, 1.05rem);
                                               color: #002850;
                                               line-height: 1.65;">
                                &ldquo;{{ $story->quote() }}&rdquo;
                            </blockquote>

                            {{-- Attribution --}}
                            <div class="flex items-center gap-3 pt-4"
                                 style="border-top: 1px solid {{ $program->color }}20;">
                                @if ($story->photo_path)
                                    <img src="{{ asset($story->photo_path) }}"
                                         alt="{{ $story->author_name }}"
                                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    {{-- Monogram fallback --}}
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                flex-shrink-0 text-sm font-bold text-white"
                                         style="background-color: {{ $program->color }};">
                                        {{ strtoupper(substr($story->author_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold" style="color: #002850;">
                                        {{ $story->author_name }}
                                    </p>
                                    <p class="text-xs" style="color: #5a6a7a;">
                                        {{ $program->name() }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         UPCOMING PROGRAM EVENTS
         Lighter visual than main content; hidden when no events.
         All links use (Gale).
         ================================================================ --}}
    @if ($programEvents->count() > 0)
        <section class="py-20 lg:py-24" style="background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section header --}}
                <div class="mb-12" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: {{ $program->color }};">
                        {{ __('programs.program_events_label') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('programs.upcoming_events') }}
                    </h2>
                    <div class="mt-4 h-0.5 w-12" style="background-color: {{ $program->color }};"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger="0.08">
                    @foreach ($programEvents as $event)
                        <a href="{{ route('public.events.show', $event) }}"
                           class="group block rounded-xl overflow-hidden transition-shadow duration-200
                                  hover:shadow-md"
                           style="border: 1px solid {{ $program->color }}20;"
                           data-animate="fade-up">

                            {{-- Date strip --}}
                            <div class="flex items-center gap-5 px-6 py-5"
                                 style="background-color: {{ $program->color }}0a;">

                                {{-- Calendar box --}}
                                <div class="flex-shrink-0 w-14 h-14 rounded-lg flex flex-col
                                            items-center justify-center text-center"
                                     style="background-color: {{ $program->color }};">
                                    <span class="block text-xl font-bold leading-none text-white"
                                          style="font-family: 'Playfair Display', serif;">
                                        {{ $event->event_date->format('d') }}
                                    </span>
                                    <span class="block text-xs font-bold uppercase tracking-wider mt-0.5"
                                          style="color: rgba(255,255,255,0.85);">
                                        {{ $event->event_date->translatedFormat('M') }}
                                    </span>
                                </div>

                                {{-- Event title + time --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm leading-snug line-clamp-2"
                                       style="color: #002850;">
                                        {{ $event->title() }}
                                    </p>
                                    @if ($event->event_time)
                                        <p class="text-xs mt-1.5" style="color: #5a6a7a;">
                                            {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Location row --}}
                            <div class="flex items-center gap-2.5 px-6 py-3.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24" stroke-width="1.5"
                                     style="color: {{ $program->color }};" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                <span class="text-xs font-medium line-clamp-1" style="color: #5a6a7a;">
                                    {{ $event->location() }}
                                </span>
                            </div>

                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         OTHER PROGRAMS
         Dark navy section; image cards with flat overlay.
         All navigation via (Gale).
         ================================================================ --}}
    @if ($otherPrograms->count() > 0)
        <section class="py-20 lg:py-24" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ config('app.name') }}
                    </span>
                    <h2 class="bree-section-h2"
                        style="color: #ffffff;">
                        {{ __('programs.other_programs') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8" data-stagger="0.1">
                    @foreach ($otherPrograms as $other)

                        <a href="{{ route('public.programs.show', $other) }}"
                           class="group block rounded-2xl overflow-hidden relative"
                           style="min-height: 260px;"
                           data-animate="fade-up">

                            {{-- Background image --}}
                            <img src="{{ asset($other->image_path) }}"
                                 alt="{{ $other->name() }}"
                                 class="absolute inset-0 w-full h-full object-cover
                                        transition-transform duration-700 group-hover:scale-105">

                            {{-- Flat dark overlay --}}
                            <div class="absolute inset-0"
                                 style="background-color: rgba(0,20,60,0.65);"></div>

                            {{-- Color top border --}}
                            <div class="absolute top-0 left-0 right-0 h-1"
                                 style="background-color: {{ $other->color }};"></div>

                            {{-- Content --}}
                            <div class="relative z-10 p-8 flex flex-col justify-end h-full">
                                <div class="h-0.5 w-10 mb-4 rounded-full"
                                     style="background-color: {{ $other->color }};"></div>
                                <h3 class="font-heading font-bold mb-2"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: clamp(1.25rem, 2.5vw, 1.625rem);
                                           color: #ffffff;">
                                    {{ $other->name() }}
                                </h3>
                                <p class="text-sm leading-relaxed mb-5"
                                   style="color: rgba(255,255,255,0.75);">
                                    {{ Str::limit($other->description(), 100) }}
                                </p>
                                <span class="inline-flex items-center gap-2 text-xs font-bold"
                                      style="color: {{ $other->color }};">
                                    {{ __('programs.discover_program') }}
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1"
                                         fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </span>
                            </div>

                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

@endsection
