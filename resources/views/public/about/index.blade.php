@extends('layouts.public')

@section('title', __('about.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('about.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(380px, 52vw, 580px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('about.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">

        {{-- Solid dark overlay — NO gradient per BR-001 --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.72);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           x-navigate
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('about.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('about.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('about.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-lg"
               style="color: rgba(255,255,255,0.75); line-height: 1.7;"
               data-animate="fade-up">
                {{ __('about.hero_tagline') }}
            </p>

            <div class="mt-6 h-0.5 w-16 rounded-full" style="background-color: #c8a03c;"></div>
        </div>

    </section>

    {{-- ================================================================
         ORIGIN STORY
         White background — two-column layout on desktop
         ================================================================ --}}
    <section class="py-24 lg:py-32" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                {{-- Image with decorative accents --}}
                <div class="relative" data-animate="fade-right">
                    <div class="overflow-hidden rounded-2xl" style="aspect-ratio: 4/3;">
                        <img src="{{ asset('images/sections/about.jpg') }}"
                             alt="{{ __('about.story_heading') }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>
                    {{-- Decorative corner blocks --}}
                    <div class="absolute -bottom-5 -right-5 w-36 h-36 rounded-2xl -z-10"
                         style="background-color: rgba(200,160,60,0.12);"></div>
                    <div class="absolute -top-5 -left-5 w-20 h-20 rounded-xl -z-10"
                         style="background-color: rgba(200,0,120,0.10);"></div>
                    {{-- Gold accent line along left edge --}}
                    <div class="absolute left-0 top-1/4 bottom-1/4 w-0.5 -ml-4 rounded-full"
                         style="background-color: #c8a03c;"></div>
                </div>

                {{-- Story text --}}
                <div data-animate="fade-left">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                          style="color: #c80078;">
                        {{ __('about.story_label') }}
                    </span>
                    <h2 class="bree-section-h2 mb-7">
                        {{ __('about.story_heading') }}
                    </h2>

                    <div class="space-y-5">
                        <p style="font-size: 1.0625rem; line-height: 1.8; color: #4a5568; font-family: 'Inter', sans-serif;">
                            {{ __('about.story_p1') }}
                        </p>
                        <p style="font-size: 1.0625rem; line-height: 1.8; color: #4a5568; font-family: 'Inter', sans-serif;">
                            {{ __('about.story_p2') }}
                        </p>
                        <p style="font-size: 1.0625rem; line-height: 1.8; color: #143c64; font-family: 'Inter', sans-serif; font-weight: 600;">
                            {{ __('about.story_p3') }}
                        </p>
                    </div>

                    {{-- Magenta accent rule --}}
                    <div class="mt-8 h-0.5 w-12 rounded-full" style="background-color: #c80078;"></div>
                </div>

            </div>

        </div>
    </section>

    {{-- ================================================================
         FOUNDER PROFILE
         Deep navy background — prestigious treatment
         ================================================================ --}}
    @if ($founder)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                    {{-- Portrait — left side --}}
                    <div class="flex justify-center lg:justify-end order-1 lg:order-1" data-animate="fade-right">
                        <div class="relative">
                            @if ($founder->photo_path)
                                {{-- Prestige portrait treatment: square clip with gold frame --}}
                                <div class="about-founder-portrait relative overflow-hidden rounded-2xl"
                                     style="width: clamp(260px, 38vw, 420px); height: clamp(300px, 44vw, 480px);">
                                    <img src="{{ asset($founder->photo_path) }}"
                                         alt="{{ $founder->name }}"
                                         class="w-full h-full object-cover object-top"
                                         loading="lazy">
                                    {{-- Subtle gold bottom gradient for text legibility if needed --}}
                                    <div class="absolute bottom-0 left-0 right-0 h-32"
                                         style="background-color: rgba(0,40,80,0.45);"></div>
                                </div>
                                {{-- Gold decorative frame corner --}}
                                <div class="absolute -top-3 -left-3 w-14 h-14 rounded-tl-2xl border-t-2 border-l-2"
                                     style="border-color: #c8a03c;"></div>
                                <div class="absolute -bottom-3 -right-3 w-14 h-14 rounded-br-2xl border-b-2 border-r-2"
                                     style="border-color: #c8a03c;"></div>
                            @else
                                {{-- Elegant monogram placeholder --}}
                                <div class="relative overflow-hidden rounded-2xl flex items-center justify-center"
                                     style="width: clamp(260px, 38vw, 380px); height: clamp(300px, 44vw, 440px);
                                            background-color: rgba(200,160,60,0.08); border: 2px solid rgba(200,160,60,0.25);">
                                    <div class="text-center">
                                        <div style="font-family: 'Playfair Display', serif; font-size: 5rem; font-weight: 700; color: #c8a03c; line-height: 1;">
                                            {{ mb_strtoupper(mb_substr($founder->name, 0, 2)) }}
                                        </div>
                                        <div class="w-12 h-0.5 mx-auto mt-3 rounded-full" style="background-color: #c8a03c;"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Bio — right side --}}
                    <div class="order-2 lg:order-2" data-animate="fade-left">

                        <span class="block text-xs font-bold tracking-widest uppercase mb-5"
                              style="color: #c8a03c; letter-spacing: 0.2em;">
                            {{ __('about.founder_label') }}
                        </span>

                        <h2 class="bree-section-h2 mb-2"
                            style="color: #ffffff;">
                            {{ $founder->name }}
                        </h2>

                        <p style="font-size: 0.9375rem; font-weight: 600; color: #c80078; margin-bottom: 0.25rem; font-family: 'Inter', sans-serif;">
                            {{ $founder->title() }}
                        </p>

                        {{-- Gold divider --}}
                        <div class="my-6 h-px w-16" style="background-color: rgba(200,160,60,0.4);"></div>

                        <div class="space-y-4 mb-8">
                            @foreach (array_filter(explode("\n\n", $founder->bio() ?? '')) as $paragraph)
                                <p style="font-size: 0.9375rem; line-height: 1.85; color: rgba(255,255,255,0.75); font-family: 'Inter', sans-serif;">
                                    {{ $paragraph }}
                                </p>
                            @endforeach
                        </div>

                        @if ($founder->message())
                            <blockquote style="border-left: 2px solid #c8a03c;
                                               padding-left: 1.5rem;
                                               font-family: 'Playfair Display', serif;
                                               font-style: italic;
                                               font-size: 1.075rem;
                                               color: rgba(255,255,255,0.92);
                                               line-height: 1.7;">
                                &ldquo;{{ $founder->message() }}&rdquo;
                            </blockquote>
                        @endif

                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         MILESTONES TIMELINE
         Off-white background — alternating left/right desktop, single-column mobile
         ================================================================ --}}
    @if ($milestones->count() > 0)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #f8f5f0;">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c; letter-spacing: 0.2em;">
                        {{ __('about.timeline_label') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('about.timeline_heading') }}
                    </h2>
                </div>

                {{-- Timeline container --}}
                <div class="relative" data-stagger="0.1">

                    {{-- Vertical connecting line — desktop centered, mobile left-aligned --}}
                    <div class="absolute hidden md:block top-0 bottom-0 w-0.5 left-1/2 -translate-x-px"
                         style="background-color: rgba(20,60,100,0.15);"></div>
                    <div class="absolute md:hidden top-0 bottom-0 w-0.5 left-5"
                         style="background-color: rgba(20,60,100,0.15);"></div>

                    <div class="space-y-10 md:space-y-0">
                        @foreach ($milestones as $index => $milestone)
                            @php $isEven = $index % 2 === 0; @endphp

                            {{-- Mobile: simple left-side layout --}}
                            <div class="md:hidden relative pl-14" data-animate="fade-up">
                                {{-- Year dot --}}
                                <div class="absolute left-3 top-1.5 w-4 h-4 rounded-full border-2"
                                     style="background-color: #c8a03c; border-color: #f8f5f0;
                                            box-shadow: 0 0 0 4px rgba(200,160,60,0.25);"></div>

                                <div class="timeline-card bg-white rounded-2xl p-6 shadow-sm"
                                     style="border: 1px solid rgba(20,60,100,0.07);">
                                    <div style="font-family: 'Playfair Display', serif;
                                                font-size: 2rem;
                                                font-weight: 700;
                                                color: #c8a03c;
                                                line-height: 1;
                                                margin-bottom: 0.5rem;">
                                        {{ $milestone->year }}
                                    </div>
                                    <h3 style="font-weight: 600;
                                               font-size: 1.0625rem;
                                               color: #002850;
                                               margin-bottom: 0.5rem;
                                               font-family: 'Inter', sans-serif;">
                                        {{ $milestone->title() }}
                                    </h3>
                                    @if ($milestone->description())
                                        <p style="font-size: 0.9rem; line-height: 1.75; color: #5a6a7a; font-family: 'Inter', sans-serif;">
                                            {{ $milestone->description() }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Desktop: alternating left/right --}}
                            <div class="hidden md:grid md:grid-cols-2 md:gap-0 md:relative mb-10" data-animate="fade-up">

                                {{-- Left column content (even items) --}}
                                <div class="pr-12 text-right @if(!$isEven) opacity-0 pointer-events-none @endif">
                                    @if ($isEven)
                                        <div class="timeline-card inline-block bg-white rounded-2xl p-7 shadow-sm text-left"
                                             style="border: 1px solid rgba(20,60,100,0.07); max-width: 340px; margin-left: auto;">
                                            <div style="font-family: 'Playfair Display', serif;
                                                        font-size: 2.5rem;
                                                        font-weight: 700;
                                                        color: #c8a03c;
                                                        line-height: 1;
                                                        margin-bottom: 0.5rem;">
                                                {{ $milestone->year }}
                                            </div>
                                            <h3 style="font-weight: 600;
                                                       font-size: 1.0625rem;
                                                       color: #002850;
                                                       margin-bottom: 0.625rem;
                                                       font-family: 'Inter', sans-serif;">
                                                {{ $milestone->title() }}
                                            </h3>
                                            @if ($milestone->description())
                                                <p style="font-size: 0.9rem; line-height: 1.75; color: #5a6a7a; font-family: 'Inter', sans-serif;">
                                                    {{ $milestone->description() }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Center dot --}}
                                <div class="absolute left-1/2 top-8 -translate-x-1/2 z-10">
                                    <div class="w-5 h-5 rounded-full border-2"
                                         style="background-color: #c8a03c; border-color: #f8f5f0;
                                                box-shadow: 0 0 0 5px rgba(200,160,60,0.25);"></div>
                                </div>

                                {{-- Right column content (odd items) --}}
                                <div class="pl-12 @if($isEven) opacity-0 pointer-events-none @endif">
                                    @if (!$isEven)
                                        <div class="timeline-card inline-block bg-white rounded-2xl p-7 shadow-sm"
                                             style="border: 1px solid rgba(20,60,100,0.07); max-width: 340px;">
                                            <div style="font-family: 'Playfair Display', serif;
                                                        font-size: 2.5rem;
                                                        font-weight: 700;
                                                        color: #c8a03c;
                                                        line-height: 1;
                                                        margin-bottom: 0.5rem;">
                                                {{ $milestone->year }}
                                            </div>
                                            <h3 style="font-weight: 600;
                                                       font-size: 1.0625rem;
                                                       color: #002850;
                                                       margin-bottom: 0.625rem;
                                                       font-family: 'Inter', sans-serif;">
                                                {{ $milestone->title() }}
                                            </h3>
                                            @if ($milestone->description())
                                                <p style="font-size: 0.9rem; line-height: 1.75; color: #5a6a7a; font-family: 'Inter', sans-serif;">
                                                    {{ $milestone->description() }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            </div>

                        @endforeach
                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         PATRON (MARRAINE) PROFILE
         White background — gold accent treatment (differentiated from founder)
         Renders only if patron data exists
         ================================================================ --}}
    @if ($patron)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                    {{-- Bio — left side --}}
                    <div data-animate="fade-right">

                        <span class="block text-xs font-bold tracking-widest uppercase mb-5"
                              style="color: #c8a03c; letter-spacing: 0.2em;">
                            {{ __('about.patron_label') }}
                        </span>

                        <h2 class="bree-section-h2 mb-2">
                            {{ $patron->name }}
                        </h2>

                        <p style="font-size: 0.9375rem; font-weight: 600; color: #c80078; margin-bottom: 0.25rem; font-family: 'Inter', sans-serif;">
                            {{ $patron->title() }}
                        </p>
                        <p style="font-size: 0.8125rem; font-weight: 500; color: #c8a03c; margin-bottom: 0; font-family: 'Inter', sans-serif; letter-spacing: 0.05em; text-transform: uppercase;">
                            {{ $patron->role() }}
                        </p>

                        {{-- Gold divider --}}
                        <div class="my-6 h-px w-16" style="background-color: rgba(200,160,60,0.35);"></div>

                        @if ($patron->description())
                            <div class="space-y-4 mb-8">
                                @foreach (array_filter(explode("\n\n", $patron->description())) as $paragraph)
                                    <p style="font-size: 0.9375rem; line-height: 1.85; color: #4a5568; font-family: 'Inter', sans-serif;">
                                        {{ $paragraph }}
                                    </p>
                                @endforeach
                            </div>
                        @endif

                        @if ($patron->quote())
                            <blockquote style="border-left: 2px solid #c8a03c;
                                               padding-left: 1.5rem;
                                               font-family: 'Playfair Display', serif;
                                               font-style: italic;
                                               font-size: 1.075rem;
                                               color: #002850;
                                               line-height: 1.7;">
                                &ldquo;{{ $patron->quote() }}&rdquo;
                            </blockquote>
                        @endif

                    </div>

                    {{-- Portrait — right side --}}
                    <div class="flex justify-center lg:justify-start" data-animate="fade-left">
                        <div class="relative">
                            @if ($patron->photo_path)
                                <div class="about-patron-portrait relative overflow-hidden rounded-2xl"
                                     style="width: clamp(260px, 38vw, 420px); height: clamp(300px, 44vw, 480px);">
                                    <img src="{{ asset($patron->photo_path) }}"
                                         alt="{{ $patron->name }}"
                                         class="w-full h-full object-cover object-top"
                                         loading="lazy">
                                    <div class="absolute bottom-0 left-0 right-0 h-32"
                                         style="background-color: rgba(200,160,60,0.18);"></div>
                                </div>
                                {{-- Gold decorative frame corners (mirrored from founder) --}}
                                <div class="absolute -top-3 -right-3 w-14 h-14 rounded-tr-2xl border-t-2 border-r-2"
                                     style="border-color: #c8a03c;"></div>
                                <div class="absolute -bottom-3 -left-3 w-14 h-14 rounded-bl-2xl border-b-2 border-l-2"
                                     style="border-color: #c8a03c;"></div>
                            @else
                                <div class="relative overflow-hidden rounded-2xl flex items-center justify-center"
                                     style="width: clamp(260px, 38vw, 380px); height: clamp(300px, 44vw, 440px);
                                            background-color: rgba(200,160,60,0.06); border: 2px solid rgba(200,160,60,0.2);">
                                    <div class="text-center">
                                        <div style="font-family: 'Playfair Display', serif; font-size: 5rem; font-weight: 700; color: #c8a03c; line-height: 1;">
                                            {{ mb_strtoupper(mb_substr($patron->name, 0, 2)) }}
                                        </div>
                                        <div class="w-12 h-0.5 mx-auto mt-3 rounded-full" style="background-color: #c8a03c;"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         5 MISSION COMMITMENTS (Values)
         Deep navy background
         ================================================================ --}}
    <section class="py-24 lg:py-32" style="background-color: #002850;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16" data-animate="fade-up">
                <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                      style="color: #c8a03c; letter-spacing: 0.2em;">
                    {{ __('about.values_label') }}
                </span>
                <h2 class="bree-section-h2"
                    style="color: #ffffff;">
                    {{ __('about.values_heading') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5" data-stagger="0.08">
                @foreach ([1,2,3,4,5] as $i)
                    <div class="rounded-2xl p-6 flex flex-col items-start transition-all duration-300"
                         style="background-color: rgba(255,255,255,0.05);
                                border: 1px solid rgba(255,255,255,0.08);"
                         data-animate="fade-up"
                         @mouseover="$el.style.backgroundColor='rgba(255,255,255,0.09)'; $el.style.borderColor='rgba(200,160,60,0.3)';"
                         @mouseout="$el.style.backgroundColor='rgba(255,255,255,0.05)'; $el.style.borderColor='rgba(255,255,255,0.08)';">

                        {{-- Number badge --}}
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mb-5 font-bold text-sm shrink-0"
                             style="background-color: rgba(200,160,60,0.15); color: #c8a03c;
                                    border: 1px solid rgba(200,160,60,0.35); font-family: 'Inter', sans-serif;">
                            {{ $i }}
                        </div>

                        <h3 style="font-family: 'Playfair Display', serif;
                                   font-size: 1.125rem;
                                   color: #ffffff;
                                   font-weight: 600;
                                   margin-bottom: 0.75rem;
                                   line-height: 1.3;">
                            {{ __('about.value_' . $i . '_title') }}
                        </h3>
                        <p style="font-size: 0.875rem; line-height: 1.75; color: rgba(255,255,255,0.62); font-family: 'Inter', sans-serif;">
                            {{ __('about.value_' . $i . '_desc') }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ================================================================
         TEAM MEMBERS GRID
         Off-white background — only renders if team list is not empty
         ================================================================ --}}
    @if ($teamMembers->isNotEmpty())
        <section class="py-24 lg:py-32" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c80078; letter-spacing: 0.2em;">
                        {{ __('about.team_label') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('about.team_heading') }}
                    </h2>
                </div>

                {{-- Team grid: 4 cols desktop, 2 cols tablet, 2 cols mobile min --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" data-stagger="0.07">
                    @foreach ($teamMembers as $member)
                        <div class="team-card group relative" data-animate="fade-up">

                            {{-- Card --}}
                            <div class="bg-white rounded-2xl overflow-hidden transition-all duration-300"
                                 style="border: 1px solid rgba(20,60,100,0.07);"
                                 @mouseover="$el.style.boxShadow='0 12px 40px rgba(0,40,100,0.12)'; $el.style.transform='translateY(-4px)'"
                                 @mouseout="$el.style.boxShadow='none'; $el.style.transform='translateY(0)'">

                                {{-- Photo — consistent 1:1 aspect ratio --}}
                                <div class="relative overflow-hidden" style="aspect-ratio: 1 / 1;">
                                    @if ($member->photo_path)
                                        <img src="{{ asset($member->photo_path) }}"
                                             alt="{{ $member->name }}"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                             loading="lazy">
                                    @else
                                        {{-- Navy monogram avatar per spec edge case --}}
                                        <div class="w-full h-full flex items-center justify-center"
                                             style="background-color: #002850;">
                                            <span style="font-family: 'Playfair Display', serif;
                                                         font-size: 2.5rem;
                                                         font-weight: 700;
                                                         color: rgba(200,160,60,0.9);">
                                                {{ $member->initials() }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Bio overlay on hover --}}
                                    @if ($member->bio())
                                        <div class="absolute inset-0 flex items-end p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                             style="background-color: rgba(0,20,50,0.82);">
                                            <p style="font-size: 0.8125rem; line-height: 1.65; color: rgba(255,255,255,0.88); font-family: 'Inter', sans-serif;">
                                                {{ mb_strimwidth($member->bio(), 0, 120, '…') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Name & title --}}
                                <div class="p-5">
                                    <h3 style="font-weight: 600;
                                               font-size: 1rem;
                                               color: #002850;
                                               margin-bottom: 0.25rem;
                                               font-family: 'Inter', sans-serif;
                                               line-height: 1.3;">
                                        {{ $member->name }}
                                    </h3>
                                    <p style="font-size: 0.8125rem; font-weight: 500; color: #c80078; font-family: 'Inter', sans-serif; line-height: 1.4;">
                                        {{ $member->title() }}
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
         CALL TO ACTION
         White background — centered layout
         ================================================================ --}}
    <section class="py-24" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="fade-up">

            {{-- Magenta accent rule --}}
            <div class="h-0.5 w-16 mx-auto mb-10" style="background-color: #c80078;"></div>

            <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                  style="color: #c80078; letter-spacing: 0.2em;">
                {{ __('about.cta_label') }}
            </span>

            <h2 class="bree-section-h2 mb-5">
                {{ __('about.cta_heading') }}
            </h2>

            <p style="font-size: 1.0625rem; line-height: 1.8; color: #4a5568; margin-bottom: 2.5rem; font-family: 'Inter', sans-serif;">
                {{ __('about.cta_text') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">

                <a href="{{ route('public.donate') }}"
                   x-navigate
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-sm font-semibold rounded-full text-white transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-4"
                   style="background-color: #c80078; min-width: 200px;">
                    {{ __('about.cta_donate') }}
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                    </svg>
                </a>

                @if (Route::has('public.volunteers'))
                    <a href="{{ route('public.volunteers') }}"
                       x-navigate
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 text-sm font-semibold rounded-full transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 hover:text-white"
                       style="color: #002850; border: 2px solid #002850;"
                       @mouseover="$el.style.backgroundColor='#002850'; $el.style.color='#ffffff';"
                       @mouseout="$el.style.backgroundColor='transparent'; $el.style.color='#002850';">
                        {{ __('about.cta_volunteer') }}
                    </a>
                @endif

            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
/**
 * About page — additional GSAP animations beyond the global initAnimations().
 * Timeline items: sequential fade-up with stagger.
 * Section headings: subtle y-shift on scroll.
 */
(function () {
    'use strict';

    const REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function initAboutAnimations() {
        if (REDUCED) { return; }
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') { return; }

        // Founder portrait clip-path reveal
        const founderPortrait = document.querySelector('.about-founder-portrait');
        if (founderPortrait) {
            gsap.from(founderPortrait, {
                clipPath: 'inset(100% 0% 0% 0%)',
                duration: 1.1,
                ease: 'power4.inOut',
                scrollTrigger: {
                    trigger: founderPortrait,
                    start: 'top 82%',
                    once: true,
                },
            });
        }

        // Patron portrait clip-path reveal (mirrored direction)
        const patronPortrait = document.querySelector('.about-patron-portrait');
        if (patronPortrait) {
            gsap.from(patronPortrait, {
                clipPath: 'inset(0% 0% 100% 0%)',
                duration: 1.1,
                ease: 'power4.inOut',
                scrollTrigger: {
                    trigger: patronPortrait,
                    start: 'top 82%',
                    once: true,
                },
            });
        }

        // Timeline milestone cards: sequential fade-up with stagger
        const timelineCards = document.querySelectorAll('.timeline-card');
        if (timelineCards.length) {
            gsap.from(timelineCards, {
                y: 30,
                opacity: 0,
                duration: 0.6,
                ease: 'power2.out',
                stagger: 0.12,
                scrollTrigger: {
                    trigger: timelineCards[0].closest('section') || timelineCards[0],
                    start: 'top 80%',
                    once: true,
                },
            });
        }

        // Team cards: stagger reveal
        const teamCards = document.querySelectorAll('.team-card');
        if (teamCards.length) {
            gsap.from(teamCards, {
                y: 24,
                opacity: 0,
                duration: 0.55,
                ease: 'power2.out',
                stagger: 0.07,
                scrollTrigger: {
                    trigger: teamCards[0].closest('section') || teamCards[0],
                    start: 'top 82%',
                    once: true,
                },
            });
        }
    }

    // Run on first load
    document.addEventListener('DOMContentLoaded', initAboutAnimations);

    // Re-run on Gale navigation back to this page
    document.addEventListener('gale:navigated', function () {
        // Small delay so DOM is fully settled
        setTimeout(initAboutAnimations, 80);
    });
}());
</script>
@endpush
