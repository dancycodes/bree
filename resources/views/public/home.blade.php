@extends('layouts.public')

@section('title', config('app.name') . ' — ' . __('meta.tagline'))
@section('meta_description', __('meta.default_description'))

@section('content')

    {{-- ================================================================
         HERO SECTION
         Full-viewport cinematic entrance with GSAP animation.
         Background: hero.jpg + solid dark overlay (no gradient per BR-001)
         ================================================================ --}}
    @if ($hero)
        <section
            data-hero
            class="relative w-full overflow-hidden min-h-screen flex items-center">

            {{-- Background Image — GSAP scales this for Ken Burns entrance --}}
            <div
                data-hero-image
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('{{ asset($hero->bg_image_path) }}'); background-color: #002850;">
            </div>

            {{-- Solid Dark Overlay — NO gradient (brand rule BR-001) --}}
            <div class="absolute inset-0" style="background-color: rgba(0, 20, 60, 0.68);"></div>

            {{-- Left accent bar — visual refinement --}}
            <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

            {{-- Hero Content — vertically centered --}}
            <div
                class="relative z-10 w-full flex flex-col items-center justify-center text-center px-6 sm:px-8 lg:px-12 py-24">

                {{-- Foundation Badge --}}
                <div
                    data-hero-badge
                    class="mb-8 inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-bold tracking-widest uppercase"
                    style="background-color: rgba(200,160,60,0.15); color: #c8a03c; border: 1px solid rgba(200,160,60,0.35);">
                    <span class="w-1.5 h-1.5 rounded-full inline-block" style="background-color: #c8a03c;"></span>
                    {{ config('app.name') }}
                </div>

                {{-- Main Tagline (Playfair Display, fluid size) --}}
                <h1
                    data-hero-tagline
                    class="font-heading mb-6 font-bold leading-tight"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(2.5rem, 6.5vw, 5.5rem);
                           color: #ffffff;
                           max-width: 860px;
                           letter-spacing: -0.01em;
                           text-shadow: 0 4px 40px rgba(0,0,0,0.4);">
                    {{ $hero->tagline() }}
                </h1>

                {{-- Gold accent line below title --}}
                <div data-hero-subtitle class="w-20 h-0.5 mb-6 mx-auto" style="background-color: #c8a03c;"></div>

                {{-- Subtitle --}}
                <p
                    data-hero-subtitle
                    class="text-base sm:text-lg lg:text-xl leading-relaxed mb-12 font-light"
                    style="color: rgba(255,255,255,0.82); max-width: 580px; font-family: 'Inter', sans-serif;">
                    {{ $hero->subtitle() }}
                </p>

                {{-- CTAs: filled Magenta + White outline --}}
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <a
                        data-hero-cta
                        href="{{ $hero->cta1_url }}"
                        class="btn-primary text-base font-semibold px-8 py-4 rounded-xl w-full sm:w-auto text-center"
                        style="min-width: 220px;">
                        {{ $hero->cta1Label() }}
                    </a>
                    <a
                        data-hero-cta
                        href="{{ $hero->cta2_url }}"
                        class="btn-secondary text-base font-semibold px-8 py-4 rounded-xl w-full sm:w-auto text-center"
                        style="min-width: 220px;">
                        {{ $hero->cta2Label() }}
                    </a>
                </div>

            </div>

            {{-- Scroll Indicator — bouncing chevron at bottom center --}}
            <div
                data-hero-scroll
                class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2"
                aria-hidden="true">
                <span
                    class="block text-center uppercase tracking-widest"
                    style="font-size: 0.6rem; letter-spacing: 0.2em; color: rgba(255,255,255,0.45);">
                    {{ __('ui.scroll') }}
                </span>
                <svg
                    class="w-5 h-5 animate-bounce"
                    style="color: rgba(200,160,60,0.75);"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

        </section>

    @else

        {{-- Fallback: Navy background when no active hero section exists --}}
        <section
            class="relative flex items-center justify-center min-h-screen"
            style="background-color: #002850;">
            <div class="text-center px-6">
                <p class="font-heading text-2xl mb-4" style="color: rgba(255,255,255,0.6); font-family: 'Playfair Display', serif;">
                    {{ config('app.name') }}
                </p>
                <p class="text-sm" style="color: rgba(255,255,255,0.4);">
                    {{ __('ui.content_coming_soon') }}
                </p>
            </div>
        </section>

    @endif


    {{-- ================================================================
         IMPACT STATISTICS SECTION
         Animated counters: scroll-triggered GSAP number counting.
         Off-white background, 4-col desktop / 2x2 mobile grid.
         ================================================================ --}}
    @if ($counters->isNotEmpty())
        <section class="py-20 lg:py-28" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section Label --}}
                <div class="text-center mb-4" data-animate="fade-up">
                    <span class="text-xs font-bold tracking-widest uppercase" style="color: #c8a03c;">
                        {{ __('home.our_impact') }}
                    </span>
                </div>
                <div class="text-center mb-14" data-animate="fade-up">
                    <h2 class="bree-section-h2">
                        {{ __('home.section_impact_intro') }}
                    </h2>
                </div>

                {{-- Counters Grid: 2-col mobile, 4-col desktop --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8" data-stagger="0.1">
                    @foreach ($counters as $counter)
                        <div class="text-center" data-animate="fade-up">

                            {{-- Gold SVG Icon --}}
                            <div class="flex justify-center mb-5">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,160,60,0.12); border: 1px solid rgba(200,160,60,0.2);">
                                    <svg
                                        class="w-7 h-7"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        style="color: #c8a03c;"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $counter->icon_svg }}"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Animated Number --}}
                            <div
                                class="font-heading font-bold leading-none mb-3"
                                style="font-family: 'Playfair Display', serif;
                                       font-size: clamp(2.5rem, 5vw, 3.75rem);
                                       color: #c80078;"
                                data-counter="{{ $counter->number }}">
                                0
                            </div>

                            {{-- Label --}}
                            <p class="text-sm lg:text-base font-medium leading-snug"
                               style="color: #143c64;">
                                {{ $counter->label() }}
                            </p>

                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
         MISSION & VISION SECTION
         Navy background. Left: vision pullquote (Playfair italic).
         Right: mission items with gold icons, stagger animation.
         ================================================================ --}}
    @if ($mission)
        <section class="py-20 lg:py-28" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section header --}}
                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="text-xs font-bold tracking-widest uppercase block mb-3" style="color: #c8a03c;">
                        {{ __('home.our_vision') }}
                    </span>
                    <h2 class="bree-section-h2"
                        style="color: #ffffff;">
                        {{ __('home.section_mission_heading') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-start">

                    {{-- Left: Vision Pullquote --}}
                    <div data-animate="fade-right" class="relative">

                        {{-- Decorative opening quote mark --}}
                        <div class="absolute -top-4 -left-2 select-none"
                             aria-hidden="true"
                             style="font-family: 'Playfair Display', serif; font-size: 8rem; line-height: 1; color: rgba(200,160,60,0.18); font-style: italic;">
                            &ldquo;
                        </div>

                        {{-- Vision Text --}}
                        <blockquote
                            class="font-heading relative z-10"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.25rem, 2.5vw, 1.75rem);
                                   font-style: italic;
                                   line-height: 1.65;
                                   color: rgba(255,255,255,0.92);">
                            {{ $mission->vision() }}
                        </blockquote>

                        {{-- Gold divider line --}}
                        <div class="mt-8 h-0.5 w-20" style="background-color: #c8a03c;"></div>

                    </div>

                    {{-- Right: Mission Items --}}
                    <div>

                        {{-- Section Label --}}
                        <span class="block text-xs font-bold tracking-widest uppercase mb-8"
                              style="color: #c8a03c;">
                            {{ __('home.our_missions') }}
                        </span>

                        <ul class="space-y-6" data-stagger="0.1">
                            @foreach ($mission->missions() as $item)
                                <li class="flex items-start gap-4" data-animate="fade-left">

                                    {{-- Gold Icon Circle --}}
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mt-0.5"
                                         style="background-color: rgba(200,160,60,0.12); border: 1px solid rgba(200,160,60,0.2);">
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            style="color: #c8a03c;"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                        </svg>
                                    </div>

                                    {{-- Mission Text --}}
                                    <p class="text-base leading-relaxed pt-1.5"
                                       style="color: rgba(255,255,255,0.85);">
                                        {{ $item['text'] }}
                                    </p>

                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
         PROGRAMS PREVIEW SECTION
         3 signature programs. Off-white background, 3-col desktop.
         Each card: colored top border, image, name, description, CTA.
         Colors: PROTÈGE=Magenta, ÉLÈVE=Navy, RESPIRE=Gold
         ================================================================ --}}
    @if ($programs->isNotEmpty())
        <section class="py-20 lg:py-28" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section Header --}}
                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                          style="color: #c8a03c;">
                        {{ __('home.our_programs') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('home.section_programs_title') }}
                    </h2>
                </div>

                {{-- Programs Grid: 1-col mobile, 3-col desktop --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-stagger="0.15">
                    @foreach ($programs as $program)
                        <article
                            class="group rounded-2xl overflow-hidden flex flex-col card-lift"
                            style="background-color: #ffffff;
                                   box-shadow: 0 2px 16px rgba(0,0,0,0.07);
                                   border-top: 4px solid {{ $program->color }};"
                            data-animate="fade-up">

                            {{-- Program Image --}}
                            <div class="overflow-hidden relative" style="height: 220px;">
                                <img
                                    src="{{ asset($program->image_path) }}"
                                    alt="{{ $program->name() }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                {{-- Fallback color block if image missing --}}
                                <div class="w-full h-full items-center justify-center hidden"
                                     style="background-color: {{ $program->color }}20;">
                                    <span class="font-heading font-bold text-2xl" style="color: {{ $program->color }}; font-family: 'Playfair Display', serif;">
                                        {{ $program->name() }}
                                    </span>
                                </div>
                                {{-- Color accent overlay strip at bottom --}}
                                <div class="absolute bottom-0 left-0 right-0 h-1" style="background-color: {{ $program->color }};"></div>
                            </div>

                            {{-- Card Body --}}
                            <div class="flex flex-col flex-1 p-7">

                                {{-- Program Name --}}
                                <h3 class="font-heading font-bold mb-3"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 1.3rem;
                                           color: {{ $program->color }};">
                                    {{ $program->name() }}
                                </h3>

                                {{-- Accent divider --}}
                                <div class="w-10 h-0.5 mb-4" style="background-color: {{ $program->color }}40;"></div>

                                {{-- Description --}}
                                <p class="text-sm leading-relaxed flex-1 mb-6"
                                   style="color: #5a6a7a;">
                                    {{ $program->description() }}
                                </p>

                                {{-- CTA Link --}}
                                <a
                                    href="{{ $program->url }}"
                                    class="inline-flex items-center gap-2 text-sm font-bold"
                                    style="color: {{ $program->color }};">
                                    {{ __('home.learn_more') }}
                                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2"
                                         aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>

                            </div>

                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
         LATEST NEWS PREVIEW SECTION
         3 most recent published articles. White background.
         Card: thumbnail, category badge (Magenta), date, title (Navy).
         ================================================================ --}}
    <section class="py-20 lg:py-28" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-14 gap-4">
                <div data-animate="fade-right">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ __('home.latest_news') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('home.section_news_title') }}
                    </h2>
                </div>
                @if (Route::has('public.news'))
                    <a
                        href="{{ route('public.news') }}"
                        class="btn-outline text-sm font-semibold px-6 py-3 rounded-xl self-start sm:self-auto whitespace-nowrap"
                        data-animate="fade-left">
                        {{ __('home.all_news') }}
                    </a>
                @endif
            </div>

            @if ($latestNews->isNotEmpty())

                {{-- 3 Article Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-stagger="0.12">
                    @foreach ($latestNews as $article)
                        <article
                            class="rounded-2xl overflow-hidden flex flex-col card-lift"
                            style="background-color: #ffffff; box-shadow: 0 2px 16px rgba(0,0,0,0.07);"
                            data-animate="fade-up">

                            {{-- Thumbnail --}}
                            @if (Route::has('public.news.show'))
                                <a href="{{ route('public.news.show', $article->slug) }}" class="block overflow-hidden" style="height: 200px;">
                            @else
                                <div class="block overflow-hidden" style="height: 200px;">
                            @endif
                                @if ($article->thumbnail_path)
                                    <img
                                        src="{{ asset($article->thumbnail_path) }}"
                                        alt="{{ $article->title() }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.parentElement.style.backgroundColor='rgba(200,0,120,0.06)'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background-color: rgba(200,0,120,0.06);">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="1.5"
                                             style="color: rgba(200,0,120,0.25);" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9H3.375A1.125 1.125 0 002.25 8.25v8.625c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V7.5a1.125 1.125 0 00-1.125-1.125H15"/>
                                        </svg>
                                    </div>
                                @endif
                            @if (Route::has('public.news.show'))
                                </a>
                            @else
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div class="flex flex-col flex-1 p-6">

                                {{-- Category + Date --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="inline-block text-xs font-bold tracking-wider uppercase px-2.5 py-1 rounded-full"
                                          style="background-color: rgba(200,0,120,0.1); color: #c80078;">
                                        {{ $article->categoryLabel() }}
                                    </span>
                                    <time class="text-xs" style="color: #9aacbb;"
                                          datetime="{{ $article->published_at->format('Y-m-d') }}">
                                        {{ $article->published_at->translatedFormat('d M Y') }}
                                    </time>
                                </div>

                                {{-- Title --}}
                                <h3 class="font-heading font-bold leading-snug mb-4 flex-1"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 1.1rem;
                                           color: #002850;">
                                    @if (Route::has('public.news.show'))
                                        <a href="{{ route('public.news.show', $article->slug) }}"
                                           class="hover:underline underline-offset-2">
                                            {{ $article->title() }}
                                        </a>
                                    @else
                                        {{ $article->title() }}
                                    @endif
                                </h3>

                                {{-- Read more --}}
                                @if (Route::has('public.news.show'))
                                    <a
                                        href="{{ route('public.news.show', $article->slug) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold mt-auto"
                                        style="color: #c80078;">
                                        {{ __('home.read_more') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </a>
                                @endif

                            </div>

                        </article>
                    @endforeach
                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-20" data-animate="fade-up">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1" style="color: rgba(0,40,80,0.2);" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9H3.375A1.125 1.125 0 002.25 8.25v8.625c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V7.5a1.125 1.125 0 00-1.125-1.125H15"/>
                    </svg>
                    <p class="text-base" style="color: #9aacbb;">
                        {{ __('home.no_news') }}
                    </p>
                </div>

            @endif

        </div>
    </section>


    {{-- ================================================================
         UPCOMING EVENTS PREVIEW SECTION
         Off-white background. Max 3 future events, soonest first.
         Card: large day (Magenta) + month (Navy) + title + location.
         ================================================================ --}}
    <section class="py-20 lg:py-28" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-14 gap-4">
                <div data-animate="fade-right">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ __('home.upcoming_events') }}
                    </span>
                    <h2 class="bree-section-h2">
                        {{ __('home.section_events_title') }}
                    </h2>
                </div>
                @if (Route::has('public.events'))
                    <a
                        href="{{ route('public.events') }}"
                        class="btn-outline text-sm font-semibold px-6 py-3 rounded-xl self-start sm:self-auto whitespace-nowrap"
                        data-animate="fade-left">
                        {{ __('home.all_events') }}
                    </a>
                @endif
            </div>

            @if ($upcomingEvents->isNotEmpty())

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-stagger="0.12">
                    @foreach ($upcomingEvents as $event)
                        <article
                            class="rounded-2xl overflow-hidden flex gap-5 items-start p-6 card-lift"
                            style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.06);"
                            data-animate="fade-up">

                            {{-- Date Block --}}
                            <div class="flex-shrink-0 flex flex-col items-center justify-center rounded-xl w-16 py-3 text-center"
                                 style="background-color: #f8f5f0; border: 1px solid rgba(0,40,80,0.08);">
                                <span class="font-heading font-bold leading-none"
                                      style="font-family: 'Playfair Display', serif;
                                             font-size: 2rem;
                                             color: #c80078;">
                                    {{ $event->event_date->format('d') }}
                                </span>
                                <span class="text-xs font-bold tracking-widest uppercase mt-1"
                                      style="color: #143c64;">
                                    {{ $event->event_date->translatedFormat('M') }}
                                </span>
                                <span class="text-xs mt-0.5" style="color: #9aacbb;">
                                    {{ $event->event_date->format('Y') }}
                                </span>
                            </div>

                            {{-- Event Info --}}
                            <div class="flex flex-col flex-1 min-w-0">

                                {{-- Title --}}
                                <h3 class="font-heading font-bold leading-snug mb-2"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 1rem;
                                           color: #002850;">
                                    @if (Route::has('public.events.show'))
                                        <a href="{{ route('public.events.show', $event->slug) }}"
                                           class="hover:underline underline-offset-2">
                                            {{ $event->title() }}
                                        </a>
                                    @else
                                        {{ $event->title() }}
                                    @endif
                                </h3>

                                {{-- Location --}}
                                @if ($event->location())
                                    <div class="flex items-center gap-1.5 mb-4">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2"
                                             style="color: #c8a03c;" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        <span class="text-xs truncate" style="color: #5a6a7a;">
                                            {{ $event->location() }}
                                        </span>
                                    </div>
                                @endif

                                {{-- CTA --}}
                                @if (Route::has('public.events.show'))
                                    <a
                                        href="{{ route('public.events.show', $event->slug) }}"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold mt-auto"
                                        style="color: #c80078;">
                                        {{ __('home.see_event') }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </a>
                                @endif

                            </div>

                        </article>
                    @endforeach
                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-20" data-animate="fade-up">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1" style="color: rgba(0,40,80,0.2);" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                    </svg>
                    <p class="text-base" style="color: #9aacbb;">
                        {{ __('home.no_events') }}
                    </p>
                </div>

            @endif

        </div>
    </section>


    {{-- ================================================================
         GALLERY PREVIEW SECTION
         White background. 4x2 grid desktop, 2-col mobile.
         Hover: caption overlay fades in (solid, NO gradient per BR-001).
         ================================================================ --}}
    @php
        $galleryItems = $galleryPhotos->map(fn ($p) => [
            'src'     => asset($p->path),
            'caption' => app()->getLocale() === 'fr' ? $p->caption_fr : $p->caption_en,
        ])->values()->all();
    @endphp

    <section class="py-20 lg:py-28" style="background-color: #ffffff;"
        x-data="{
            open: false,
            idx: 0,
            photos: {{ Js::from($galleryItems) }},
            openAt(i) { this.idx = i; this.open = true; },
            prev() { this.idx = (this.idx - 1 + this.photos.length) % this.photos.length; },
            next() { this.idx = (this.idx + 1) % this.photos.length; }
        }"
        @keydown.escape.window="open = false"
        @keydown.arrow-left.window="if (open) prev()"
        @keydown.arrow-right.window="if (open) next()">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center mb-12" data-animate="fade-up">
                <p class="text-xs font-bold tracking-widest uppercase mb-3" style="color: #c80078;">
                    {{ __('home.gallery_eyebrow') }}
                </p>
                <h2 class="bree-section-h2 mb-2">
                    {{ __('home.gallery_title') }}
                </h2>
            </div>

            @if ($galleryPhotos->isEmpty())
                {{-- Empty state --}}
                <div class="text-center py-16" data-animate="fade-up">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1" style="color: rgba(0,40,80,0.2);" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                    <p class="text-sm" style="color: #94a3b8;">{{ __('home.gallery_empty') }}</p>
                </div>
            @else
                {{-- Photo Grid: 4-col desktop, 2-col mobile --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:gap-4" data-animate="fade-up">
                    @foreach ($galleryPhotos as $idx => $photo)
                        @php
                            $caption = app()->getLocale() === 'fr' ? $photo->caption_fr : $photo->caption_en;
                        @endphp
                        <div
                            class="relative overflow-hidden rounded-xl cursor-pointer group focus-visible:ring-2 focus-visible:ring-offset-2"
                            style="aspect-ratio: 1 / 1; --tw-ring-color: #c80078;"
                            @click="openAt({{ $idx }})"
                            role="button"
                            tabindex="0"
                            @keydown.enter="openAt({{ $idx }})"
                            aria-label="{{ $caption ?: __('home.gallery_photo_alt') }}">

                            {{-- Photo --}}
                            <img
                                src="{{ asset($photo->path) }}"
                                alt="{{ $caption }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                                onerror="this.src='{{ asset('images/sections/gallery-placeholder.jpg') }}'">

                            {{-- Hover overlay — solid color, NO gradient (BR-001) --}}
                            <div
                                class="absolute inset-0 flex items-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                style="background-color: rgba(0,20,50,0.6);"
                                aria-hidden="true">
                                @if ($caption)
                                    <p class="text-white text-xs font-medium leading-tight line-clamp-2">
                                        {{ $caption }}
                                    </p>
                                @endif
                            </div>

                            {{-- Zoom icon on hover --}}
                            <div class="absolute top-2 right-2 w-7 h-7 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                 style="background-color: rgba(200,160,60,0.9);"
                                 aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6"/>
                                </svg>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <div class="text-center mt-10" data-animate="fade-up">
                    @if (Route::has('public.gallery'))
                        <a href="{{ route('public.gallery') }}"
                           class="btn-outline text-sm font-semibold px-8 py-3 rounded-xl inline-flex items-center gap-2">
                            {{ __('home.gallery_cta') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endif

        </div>

        {{-- ================================================================
             ALPINE.JS LIGHTBOX
             Full-screen overlay, arrow navigation, escape to close.
             Dark backdrop — solid color (NO gradient per BR-001).
        ================================================================ --}}
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center"
            style="background-color: rgba(0, 0, 0, 0.93);"
            @click.self="open = false"
            role="dialog"
            aria-modal="true"
            :aria-label="photos[idx]?.caption || '{{ __('home.gallery_photo_alt') }}'">

            {{-- Close button --}}
            <button
                @click="open = false"
                class="absolute top-4 right-4 z-10 w-11 h-11 flex items-center justify-center rounded-full transition-colors"
                style="background-color: rgba(255,255,255,0.12); color: white;"
                aria-label="{{ __('ui.close') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Prev arrow --}}
            <button
                @click.stop="prev()"
                class="absolute left-4 z-10 w-11 h-11 flex items-center justify-center rounded-full transition-colors"
                style="background-color: rgba(255,255,255,0.12); color: white;"
                aria-label="{{ __('ui.previous') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Image + Caption --}}
            <div class="flex flex-col items-center max-w-4xl w-full px-16">
                <img
                    :src="photos[idx]?.src"
                    :alt="photos[idx]?.caption"
                    class="max-h-[75vh] max-w-full rounded-lg object-contain"
                    style="box-shadow: 0 25px 60px rgba(0,0,0,0.7);">
                <p
                    x-show="photos[idx]?.caption"
                    x-text="photos[idx]?.caption"
                    class="mt-4 text-sm text-center"
                    style="color: rgba(255,255,255,0.75);">
                </p>
                {{-- Counter --}}
                <p class="mt-2 text-xs" style="color: rgba(255,255,255,0.4);">
                    <span x-text="idx + 1"></span> / <span x-text="photos.length"></span>
                </p>
            </div>

            {{-- Next arrow --}}
            <button
                @click.stop="next()"
                class="absolute right-4 z-10 w-11 h-11 flex items-center justify-center rounded-full transition-colors"
                style="background-color: rgba(255,255,255,0.12); color: white;"
                aria-label="{{ __('ui.next') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

        </div>

    </section>


    {{-- ================================================================
         FOUNDER & PATRON SPOTLIGHT SECTION
         Navy background. Two-column: Founder (left) + Patron (right).
         Circular portrait with gold ring. Prestigious Playfair typography.
         ================================================================ --}}
    @if ($founder || $patron)
        <section class="py-20 lg:py-28" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section Label --}}
                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="text-xs font-bold tracking-widest uppercase block mb-3"
                          style="color: #c8a03c;">
                        {{ __('home.our_leadership') }}
                    </span>
                    <h2 class="bree-section-h2"
                        style="color: #ffffff;">
                        {{ __('home.section_founder_intro') }}
                    </h2>
                </div>

                {{-- Two-column split: Founder | Patron --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">

                    {{-- ── Founder ── --}}
                    @if ($founder)
                    <div class="flex flex-col items-center text-center" data-animate="fade-right">

                        {{-- Portrait Circle with double-ring effect --}}
                        <div class="relative mb-10">
                            {{-- Outer decorative ring --}}
                            <div class="absolute -inset-3 rounded-full"
                                 style="border: 1px solid rgba(200,160,60,0.25);"></div>
                            <div class="w-48 h-48 rounded-full overflow-hidden"
                                 style="border: 3px solid #c8a03c;">
                                @if ($founder->photo_path)
                                    <img
                                        src="{{ asset($founder->photo_path) }}"
                                        alt="{{ $founder->name }}"
                                        class="w-full h-full rounded-full object-cover object-top"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                    <div class="w-full h-full rounded-full items-center justify-center hidden"
                                         style="background-color: rgba(200,0,120,0.15); display: none;">
                                        <span class="font-heading font-bold select-none"
                                              style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #c80078;">
                                            {{ \App\Models\FounderProfile::initials($founder->name) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="w-full h-full rounded-full flex items-center justify-center"
                                         style="background-color: rgba(200,0,120,0.15);">
                                        <span class="font-heading font-bold select-none"
                                              style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #c80078;">
                                            {{ \App\Models\FounderProfile::initials($founder->name) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            {{-- Magenta role badge --}}
                            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 whitespace-nowrap
                                        text-xs font-bold tracking-widest uppercase px-4 py-1.5 rounded-full"
                                 style="background-color: #c80078; color: #ffffff;">
                                {{ __('home.founder_label') }}
                            </div>
                        </div>

                        {{-- Name --}}
                        <h3 class="font-heading font-bold mt-4 mb-1"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: 1.5rem;
                                   color: #ffffff;">
                            {{ $founder->name }}
                        </h3>

                        {{-- Title --}}
                        <p class="text-xs font-semibold tracking-wider uppercase mb-7"
                           style="color: #c8a03c;">
                            {{ $founder->title() }}
                        </p>

                        {{-- Quote / Message --}}
                        <blockquote
                            class="font-heading relative"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: 1.05rem;
                                   font-style: italic;
                                   line-height: 1.75;
                                   color: rgba(255,255,255,0.75);
                                   max-width: 400px;">
                            <span class="absolute -top-8 -left-2 text-6xl leading-none select-none"
                                  aria-hidden="true"
                                  style="color: rgba(200,160,60,0.25); font-family: 'Playfair Display', serif;">&ldquo;</span>
                            {{ $founder->message() }}
                        </blockquote>

                        {{-- Gold divider --}}
                        <div class="mt-8 h-px w-16 mx-auto" style="background-color: rgba(200,160,60,0.4);"></div>

                    </div>
                    @endif

                    {{-- ── Patron ── --}}
                    @if ($patron)
                    <div class="flex flex-col items-center text-center" data-animate="fade-left">

                        {{-- Portrait Circle with double-ring effect --}}
                        <div class="relative mb-10">
                            {{-- Outer decorative ring --}}
                            <div class="absolute -inset-3 rounded-full"
                                 style="border: 1px solid rgba(200,160,60,0.25);"></div>
                            <div class="w-48 h-48 rounded-full overflow-hidden"
                                 style="border: 3px solid #c8a03c;">
                                @if ($patron->photo_path)
                                    <img
                                        src="{{ asset($patron->photo_path) }}"
                                        alt="{{ $patron->name }}"
                                        class="w-full h-full rounded-full object-cover object-top"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                    <div class="w-full h-full rounded-full items-center justify-center hidden"
                                         style="background-color: rgba(200,160,60,0.12); display: none;">
                                        <span class="font-heading font-bold select-none"
                                              style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #c8a03c;">
                                            {{ \App\Models\PatronProfile::initials($patron->name) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="w-full h-full rounded-full flex items-center justify-center"
                                         style="background-color: rgba(200,160,60,0.12);">
                                        <span class="font-heading font-bold select-none"
                                              style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #c8a03c;">
                                            {{ \App\Models\PatronProfile::initials($patron->name) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            {{-- Gold role badge --}}
                            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 whitespace-nowrap
                                        text-xs font-bold tracking-widest uppercase px-4 py-1.5 rounded-full"
                                 style="background-color: #c8a03c; color: #002850;">
                                {{ __('home.patron_label') }}
                            </div>
                        </div>

                        {{-- Name --}}
                        <h3 class="font-heading font-bold mt-4 mb-1"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: 1.5rem;
                                   color: #ffffff;">
                            {{ $patron->name }}
                        </h3>

                        {{-- Title --}}
                        <p class="text-xs font-semibold tracking-wider uppercase mb-7"
                           style="color: #c8a03c;">
                            {{ $patron->title() }}
                        </p>

                        {{-- Quote --}}
                        <blockquote
                            class="font-heading relative"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: 1.05rem;
                                   font-style: italic;
                                   line-height: 1.75;
                                   color: rgba(255,255,255,0.75);
                                   max-width: 400px;">
                            <span class="absolute -top-8 -left-2 text-6xl leading-none select-none"
                                  aria-hidden="true"
                                  style="color: rgba(200,160,60,0.25); font-family: 'Playfair Display', serif;">&ldquo;</span>
                            {{ $patron->quote() }}
                        </blockquote>

                        {{-- Gold divider --}}
                        <div class="mt-8 h-px w-16 mx-auto" style="background-color: rgba(200,160,60,0.4);"></div>

                    </div>
                    @endif

                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
         PARTNERS LOGO STRIP
         Off-white background. Greyscale logos, full color on hover.
         Normalized to uniform display size.
         ================================================================ --}}
    @if ($partners->isNotEmpty())
        <section class="py-16" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-10" data-animate="fade-up">
                    <p class="text-xs font-bold tracking-widest uppercase" style="color: #143c64;">
                        {{ __('home.our_partners') }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-14" data-animate="fade-up">
                    @foreach ($partners as $partner)
                        @php $logoSrc = $partner->logo_path ? asset($partner->logo_path) : null; @endphp

                        @if ($partner->website_url)
                            <a href="{{ $partner->website_url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               title="{{ $partner->name }}"
                               aria-label="{{ $partner->name }}"
                               class="flex items-center justify-center rounded transition-all duration-300 focus-visible:outline focus-visible:outline-2"
                               style="filter: grayscale(100%); opacity: 0.55; width: 140px; height: 56px; --tw-outline-color: #c80078;"
                               onmouseover="this.style.filter='grayscale(0%)'; this.style.opacity='1';"
                               onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.55';">
                                @if ($logoSrc)
                                    <img src="{{ $logoSrc }}"
                                         alt="{{ $partner->name }}"
                                         class="max-h-12 w-auto max-w-[130px] object-contain"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                                    <span class="hidden text-sm font-semibold text-center" style="color: #143c64;">{{ $partner->name }}</span>
                                @else
                                    <span class="text-sm font-semibold text-center" style="color: #143c64;">{{ $partner->name }}</span>
                                @endif
                            </a>
                        @else
                            <div class="flex items-center justify-center rounded transition-all duration-300"
                                 style="filter: grayscale(100%); opacity: 0.55; width: 140px; height: 56px;"
                                 title="{{ $partner->name }}"
                                 onmouseover="this.style.filter='grayscale(0%)'; this.style.opacity='1';"
                                 onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.55';">
                                @if ($logoSrc)
                                    <img src="{{ $logoSrc }}"
                                         alt="{{ $partner->name }}"
                                         class="max-h-12 w-auto max-w-[130px] object-contain"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                                    <span class="hidden text-sm font-semibold text-center" style="color: #143c64;">{{ $partner->name }}</span>
                                @else
                                    <span class="text-sm font-semibold text-center" style="color: #143c64;">{{ $partner->name }}</span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
         NEWSLETTER SUBSCRIPTION SECTION
         Off-white background. Single email field + subscribe button.
         Gale-powered. Honeypot protected.
         ================================================================ --}}
    <section class="py-20 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <div data-animate="fade-up"
                 x-data="{ newsletter_email: '' }">

                {{-- Decorative Gold icon --}}
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center"
                         style="background-color: rgba(200,160,60,0.1); border: 1px solid rgba(200,160,60,0.2);">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             stroke-width="1.5" style="color: #c8a03c;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                </div>

                {{-- Headline --}}
                <h2 class="bree-section-h2 mb-4">
                    {{ __('home.newsletter_headline') }}
                </h2>

                {{-- Subtitle --}}
                <p class="text-base leading-relaxed mb-8 mx-auto"
                   style="color: #5a6a7a; max-width: 480px;">
                    {{ __('home.newsletter_subtitle') }}
                </p>

                {{-- Form --}}
                <form
                    @submit.prevent="$action('{{ route('newsletter.subscribe') }}')"
                    x-sync="['newsletter_email']"
                    class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                    @csrf
                    @honeypot

                    <div class="flex-1">
                        <input
                            type="email"
                            x-name="newsletter_email"
                            x-model="newsletter_email"
                            placeholder="{{ __('home.newsletter_placeholder') }}"
                            aria-label="{{ __('home.newsletter_placeholder') }}"
                            autocomplete="email"
                            class="bree-form-field">
                        <p x-message="newsletter_email" class="bree-form-error text-left"></p>
                    </div>

                    <button
                        type="submit"
                        class="btn-primary px-7 py-3.5 rounded-xl text-sm font-semibold whitespace-nowrap flex-shrink-0">
                        <span x-show="!$fetching()">{{ __('home.newsletter_subscribe') }}</span>
                        <span x-show="$fetching()" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                    </button>

                </form>

                {{-- GDPR note --}}
                <p class="mt-4 text-xs" style="color: #9aacbb;">
                    {{ __('home.newsletter_no_spam') }}
                </p>

            </div>

        </div>
    </section>


    {{-- ================================================================
         DONATION CALL-TO-ACTION SECTION
         Full-width Magenta background (#c80078) — spec AC requires it.
         Admin-managed headline + copy. Two CTAs.
         ================================================================ --}}
    @if ($donationCta)
        <section
            class="relative py-24 lg:py-32 overflow-hidden"
            style="background-color: #c80078;">

            {{-- Subtle texture: overlapping large circles — solid, NO gradient --}}
            <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full opacity-10" style="background-color: #a8006a;"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full opacity-10" style="background-color: #a8006a;"></div>

            {{-- Content --}}
            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

                {{-- Eyebrow label --}}
                <div class="flex justify-center mb-6" data-animate="fade-up">
                    <span class="text-xs font-bold tracking-widest uppercase px-4 py-1.5 rounded-full"
                          style="background-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9);">
                        {{ __('home.section_donate_cta_label') }}
                    </span>
                </div>

                {{-- Gold accent line --}}
                <div class="flex justify-center mb-8" data-animate="fade-up">
                    <div class="h-0.5 w-16" style="background-color: #c8a03c;"></div>
                </div>

                {{-- Headline --}}
                <h2
                    class="bree-section-h2 mb-6"
                    style="color: #ffffff;"
                    data-animate="fade-up">
                    {{ $donationCta->headline() }}
                </h2>

                {{-- Copy --}}
                <p
                    class="text-base sm:text-lg leading-relaxed mb-12 mx-auto"
                    style="color: rgba(255,255,255,0.88); max-width: 560px;"
                    data-animate="fade-up">
                    {{ $donationCta->copy() }}
                </p>

                {{-- CTAs --}}
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center" data-animate="fade-up">

                    {{-- Primary: white filled button --}}
                    @if (Route::has('public.donate'))
                        <a
                            href="{{ route('public.donate') }}"
                            class="inline-flex items-center justify-center text-base font-semibold px-10 py-4 rounded-xl w-full sm:w-auto text-center transition-all duration-150"
                            style="background-color: #ffffff; color: #c80078; min-width: 220px;"
                            onmouseover="this.style.backgroundColor='#f8f5f0'"
                            onmouseout="this.style.backgroundColor='#ffffff'">
                            {{ __('home.donate_now') }}
                        </a>

                        {{-- Secondary: white outline --}}
                        <a
                            href="{{ route('public.donate') }}#promesse"
                            class="inline-flex items-center justify-center text-base font-semibold px-10 py-4 rounded-xl w-full sm:w-auto text-center transition-all duration-150"
                            style="background-color: transparent; color: #ffffff; border: 2px solid rgba(255,255,255,0.75); min-width: 220px;"
                            onmouseover="this.style.borderColor='#ffffff'; this.style.backgroundColor='rgba(255,255,255,0.1)'"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.75)'; this.style.backgroundColor='transparent'">
                            {{ __('home.pledge_donation') }}
                        </a>
                    @endif

                </div>

            </div>

        </section>
    @endif

@endsection
