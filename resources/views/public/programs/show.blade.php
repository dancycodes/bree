@extends('layouts.public')

@section('title', $program->name() . ' — ' . config('app.name'))
@section('meta_description', $program->description())

@section('content')

    {{-- ================================================================
         PAGE HERO
         Program banner with image + solid overlay + program name
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(320px, 45vw, 520px);">

        {{-- Background image --}}
        <img
            src="{{ asset($program->image_path) }}"
            alt="{{ $program->name() }}"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- Solid navy overlay --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.72);"></div>

        {{-- Content --}}
        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            {{-- Breadcrumb --}}
            <nav class="mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.6);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors duration-200"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li>
                        <a href="{{ route('public.programs') }}"
                           class="hover:text-white transition-colors duration-200"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('programs.page_title') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">{{ $program->name() }}</li>
                </ol>
            </nav>

            {{-- Program name --}}
            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5vw, 3.75rem);
                       color: {{ $program->color }};"
                data-animate="fade-up">
                {{ $program->name() }}
            </h1>

            {{-- Color underline --}}
            <div class="mt-4 h-1 w-16 rounded-full" style="background-color: {{ $program->color }};"></div>
        </div>

    </section>

    {{-- ================================================================
         DESCRIPTION + ACTIVITIES
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
                    <h2 class="font-heading font-bold mb-6"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.5rem, 3vw, 2.25rem);
                               color: #002850;">
                        {{ __('programs.what_we_do') }}
                    </h2>
                    <p class="text-base leading-relaxed"
                       style="color: #5a6a7a;">
                        {{ $program->longDescription() ?: $program->description() }}
                    </p>
                </div>

                {{-- Right: Activities list --}}
                <div data-animate="fade-left">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-6"
                          style="color: {{ $program->color }};">
                        {{ __('programs.our_actions') }}
                    </span>

                    @if (count($program->activities()) > 0)
                        <ul class="space-y-4" data-stagger="0.08">
                            @foreach ($program->activities() as $activity)
                                <li class="flex items-start gap-4" data-animate="fade-left">
                                    <span class="flex-shrink-0 mt-0.5 w-6 h-6 rounded-full flex items-center justify-center"
                                          style="background-color: {{ $program->color }}1a;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2.5"
                                             style="color: {{ $program->color }};" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm leading-relaxed font-medium"
                                          style="color: #143c64;">
                                        {{ $activity }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>

        </div>
    </section>

    {{-- ================================================================
         IMPACT HIGHLIGHT
         Big number / quote block with program color accent
         ================================================================ --}}
    <section class="py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto text-center" data-animate="fade-up">
                <div class="h-1 w-16 mx-auto mb-10 rounded-full"
                     style="background-color: {{ $program->color }};"></div>

                <blockquote class="font-heading font-bold italic"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.5rem, 3.5vw, 2.5rem);
                                   color: #002850;
                                   line-height: 1.35;">
                    "{{ $program->description() }}"
                </blockquote>

                <div class="mt-8">
                    <a href="/dons?programme={{ $program->slug }}"
                       class="inline-flex items-center gap-3 px-8 py-4 text-sm font-semibold rounded-full text-white transition-opacity duration-200 hover:opacity-90"
                       style="background-color: {{ $program->color }};">
                        {{ __('programs.donate_for_program', ['name' => $program->name()]) }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ================================================================
         UPCOMING PROGRAM EVENTS (only when tagged events exist)
         ================================================================ --}}
    @if ($programEvents->count() > 0)
        <section class="py-20" style="background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="mb-12" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: {{ $program->color }};">
                        {{ __('programs.program_events_label') }}
                    </span>
                    <h2 class="font-heading font-bold"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.5rem, 3vw, 2rem);
                               color: #002850;">
                        {{ __('programs.upcoming_events') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($programEvents as $event)
                        <div class="rounded-2xl overflow-hidden border"
                             style="border-color: {{ $program->color }}26;"
                             data-animate="fade-up">

                            {{-- Date strip --}}
                            <div class="px-6 py-4 flex items-center gap-4"
                                 style="background-color: {{ $program->color }}0d;">
                                <div class="text-center leading-none">
                                    <span class="block text-2xl font-bold"
                                          style="color: {{ $program->color }};">
                                        {{ $event->event_date->format('d') }}
                                    </span>
                                    <span class="block text-xs font-semibold uppercase mt-0.5"
                                          style="color: {{ $program->color }};">
                                        {{ $event->event_date->translatedFormat('M') }}
                                    </span>
                                    <span class="block text-xs mt-0.5" style="color: #5a6a7a;">
                                        {{ $event->event_date->format('Y') }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm leading-snug truncate"
                                       style="color: #002850;">
                                        {{ $event->title() }}
                                    </p>
                                    @if ($event->event_time)
                                        <p class="text-xs mt-1" style="color: #5a6a7a;">
                                            {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="px-6 py-4 flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24" stroke-width="1.5"
                                     style="color: {{ $program->color }};" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                <span class="text-sm" style="color: #5a6a7a;">{{ $event->location() }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         OTHER PROGRAMS
         Compact cards to discover the other two programs
         ================================================================ --}}
    @if ($otherPrograms->count() > 0)
        <section class="py-20 lg:py-24" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ config('app.name') }}
                    </span>
                    <h2 class="font-heading font-bold"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.5rem, 3vw, 2rem);
                               color: #ffffff;">
                        {{ __('programs.other_programs') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8" data-stagger="0.1">
                    @foreach ($otherPrograms as $other)
                        <a href="{{ route('public.programs.show', $other) }}"
                           class="group block rounded-2xl overflow-hidden relative"
                           style="min-height: 240px;"
                           data-animate="fade-up">

                            <img src="{{ asset($other->image_path) }}"
                                 alt="{{ $other->name() }}"
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                            <div class="absolute inset-0"
                                 style="background-color: rgba(0,20,60,0.60);"></div>

                            <div class="relative z-10 p-8 flex flex-col justify-end h-full">
                                <div class="h-0.5 w-10 mb-4 rounded-full"
                                     style="background-color: {{ $other->color }};"></div>
                                <h3 class="font-heading font-bold text-white mb-2"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: clamp(1.25rem, 2.5vw, 1.625rem);
                                           color: {{ $other->color }};">
                                    {{ $other->name() }}
                                </h3>
                                <p class="text-sm leading-relaxed mb-4"
                                   style="color: rgba(255,255,255,0.75);">
                                    {{ Str::limit($other->description(), 100) }}
                                </p>
                                <span class="inline-flex items-center gap-2 text-xs font-semibold"
                                      style="color: {{ $other->color }};">
                                    {{ __('programs.discover_program') }}
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
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
