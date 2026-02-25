@extends('layouts.public')

@section('title', config('app.name') . ' — ' . __('meta.tagline'))
@section('meta_description', __('meta.default_description'))

@section('content')

    {{-- ================================================================
         HERO SECTION (F-016)
         Full-viewport cinematic entrance with GSAP animation.
         Background: hero.jpg + solid dark overlay (no gradient per BR-003)
         ================================================================ --}}
    @if ($hero)
        <section
            data-hero
            class="relative w-full overflow-hidden"
            style="min-height: calc(100vh - 4.5rem);">

            {{-- Background Image — GSAP scales this for Ken Burns entrance --}}
            <div
                data-hero-image
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('{{ asset($hero->bg_image_path) }}'); background-color: #002850;">
            </div>

            {{-- Solid Dark Overlay — NO gradient (brand rule BR-003) --}}
            <div class="absolute inset-0" style="background-color: rgba(0, 20, 60, 0.65);"></div>

            {{-- Hero Content — vertically centered --}}
            <div
                class="relative z-10 flex flex-col items-center justify-center text-center px-6 sm:px-8 lg:px-12"
                style="min-height: calc(100vh - 4.5rem); padding-bottom: 6rem;">

                {{-- Foundation Badge --}}
                <div
                    data-hero-badge
                    class="mb-6 inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase"
                    style="background-color: rgba(200,160,60,0.15); color: #c8a03c; border: 1px solid rgba(200,160,60,0.3);">
                    <span class="w-1.5 h-1.5 rounded-full inline-block" style="background-color: #c8a03c;"></span>
                    {{ config('app.name') }}
                </div>

                {{-- Main Tagline (Playfair Display, fluid size) --}}
                <h1
                    data-hero-tagline
                    class="font-heading mb-6 font-bold leading-none tracking-tight"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(2.5rem, 7vw, 5.5rem);
                           color: #ffffff;
                           max-width: 900px;
                           text-shadow: 0 4px 30px rgba(0,0,0,0.3);">
                    {{ $hero->tagline() }}
                </h1>

                {{-- Subtitle --}}
                <p
                    data-hero-subtitle
                    class="text-base sm:text-lg lg:text-xl leading-relaxed mb-10 font-light"
                    style="color: rgba(255,255,255,0.8); max-width: 640px;">
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
                    style="font-size: 0.6rem; letter-spacing: 0.2em; color: rgba(255,255,255,0.4);">
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
            class="relative flex items-center justify-center"
            style="min-height: calc(100vh - 4.5rem); background-color: #002850;">
            <p class="text-sm" style="color: rgba(255,255,255,0.4);">
                {{ __('ui.content_coming_soon') }}
            </p>
        </section>

    @endif


    {{-- ================================================================
         IMPACT STATISTICS SECTION (F-017)
         Animated counters: scroll-triggered GSAP number counting.
         Off-white background, 4-col desktop / 2x2 mobile grid.
         ================================================================ --}}
    @if ($counters->isNotEmpty())
        <section class="py-20 lg:py-28" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section Label --}}
                <div class="text-center mb-14" data-animate="fade-up">
                    <span class="text-xs font-bold tracking-widest uppercase" style="color: #c8a03c;">
                        {{ __('home.our_impact') }}
                    </span>
                </div>

                {{-- Counters Grid: 2-col mobile, 4-col desktop --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8" data-stagger="0.1">
                    @foreach ($counters as $counter)
                        <div class="text-center" data-animate="fade-up">

                            {{-- Gold SVG Icon --}}
                            <div class="flex justify-center mb-5">
                                <div class="w-14 h-14 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,160,60,0.1);">
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
         MISSION & VISION SECTION (F-018)
         Navy background. Left: vision pullquote (Playfair italic).
         Right: 5 mission items with gold icons, stagger animation.
         ================================================================ --}}
    @if ($mission)
        <section class="py-20 lg:py-28" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-start">

                    {{-- Left: Vision Pullquote --}}
                    <div data-animate="fade-right" class="relative">

                        {{-- Decorative opening quote mark --}}
                        <div class="absolute -top-4 -left-2 select-none"
                             aria-hidden="true"
                             style="font-family: 'Playfair Display', serif; font-size: 8rem; line-height: 1; color: rgba(200,160,60,0.2); font-style: italic;">
                            "
                        </div>

                        {{-- Section Label --}}
                        <span class="block text-xs font-bold tracking-widest uppercase mb-6 relative z-10"
                              style="color: #c8a03c;">
                            {{ __('home.our_vision') }}
                        </span>

                        {{-- Vision Text --}}
                        <blockquote
                            class="font-heading relative z-10"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.25rem, 2.5vw, 1.75rem);
                                   font-style: italic;
                                   line-height: 1.6;
                                   color: rgba(255,255,255,0.92);">
                            {{ $mission->vision() }}
                        </blockquote>

                        {{-- Gold divider line --}}
                        <div class="mt-8 h-0.5 w-16" style="background-color: #c8a03c;"></div>

                    </div>

                    {{-- Right: 5 Mission Items --}}
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
                                         style="background-color: rgba(200,160,60,0.12);">
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
         PROGRAMS PREVIEW SECTION (F-019)
         3 signature programs: BREE PROTÈGE / ÉLÈVE / RESPIRE.
         White background, 3-col desktop / 1-col mobile.
         Each card: colored top border, image, name, description, CTA.
         Hover: translateY(-4px) + deeper shadow.
         ================================================================ --}}
    {{-- ================================================================
         LATEST NEWS PREVIEW SECTION (F-020)
         3 most recent published articles. White background.
         Card: thumbnail, category badge (Magenta), date, title (Navy).
         Empty state if no published articles.
         ================================================================ --}}
    <section class="py-20 lg:py-28" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-14 gap-4">
                <div data-animate="fade-right">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ __('home.latest_news') }}
                    </span>
                    <h2 class="font-heading"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.75rem, 4vw, 2.75rem);
                               color: #002850;
                               font-weight: 700;">
                        {{ config('app.name') }}
                    </h2>
                </div>
                <a
                    href="/actualites"
                    class="btn-outline text-sm font-semibold px-6 py-3 rounded-xl self-start sm:self-auto whitespace-nowrap"
                    data-animate="fade-left">
                    {{ __('home.all_news') }}
                </a>
            </div>

            @if ($latestNews->isNotEmpty())

                {{-- 3 Article Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-stagger="0.12">
                    @foreach ($latestNews as $article)
                        <article
                            class="rounded-2xl overflow-hidden flex flex-col"
                            style="background-color: #ffffff; box-shadow: 0 2px 16px rgba(0,0,0,0.06);"
                            data-animate="fade-up">

                            {{-- Thumbnail --}}
                            <a href="/actualites/{{ $article->slug }}" class="block overflow-hidden" style="height: 200px;">
                                @if ($article->thumbnail_path)
                                    <img
                                        src="{{ asset($article->thumbnail_path) }}"
                                        alt="{{ $article->title() }}"
                                        class="w-full h-full object-cover"
                                        style="transition: transform 0.5s ease;"
                                        loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background-color: rgba(200,0,120,0.08);">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="1.5"
                                             style="color: rgba(200,0,120,0.3);" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9H3.375A1.125 1.125 0 002.25 8.25v8.625c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V7.5a1.125 1.125 0 00-1.125-1.125H15"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Card Body --}}
                            <div class="flex flex-col flex-1 p-6">

                                {{-- Category + Date --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="inline-block text-xs font-bold tracking-wider uppercase px-2.5 py-1 rounded-full"
                                          style="background-color: rgba(200,0,120,0.1); color: #c80078;">
                                        {{ $article->category() }}
                                    </span>
                                    <span class="text-xs" style="color: #9aacbb;">
                                        {{ $article->published_at->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 class="font-heading font-bold leading-snug mb-4 flex-1"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 1.1rem;
                                           color: #002850;">
                                    <a href="/actualites/{{ $article->slug }}"
                                       class="hover:underline underline-offset-2">
                                        {{ $article->title() }}
                                    </a>
                                </h3>

                                {{-- Read more --}}
                                <a
                                    href="/actualites/{{ $article->slug }}"
                                    class="inline-flex items-center gap-2 text-sm font-semibold mt-auto"
                                    style="color: #c80078;">
                                    {{ __('home.read_more') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>

                            </div>

                        </article>
                    @endforeach
                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-20" data-animate="fade-up">
                    <p class="text-base" style="color: #9aacbb;">
                        {{ __('home.no_news') }}
                    </p>
                </div>

            @endif

        </div>
    </section>

    @if ($programs->isNotEmpty())
        <section class="py-20 lg:py-28" style="background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section Header --}}
                <div class="text-center mb-14" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                          style="color: #c8a03c;">
                        {{ __('home.our_programs') }}
                    </span>
                    <h2 class="font-heading"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.75rem, 4vw, 2.75rem);
                               color: #002850;
                               font-weight: 700;">
                        {{ config('app.name') }}
                    </h2>
                </div>

                {{-- Programs Grid: 1-col mobile, 3-col desktop --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-stagger="0.15">
                    @foreach ($programs as $program)
                        <article
                            class="group rounded-2xl overflow-hidden flex flex-col program-card"
                            style="background-color: #ffffff;
                                   box-shadow: 0 2px 16px rgba(0,0,0,0.07);
                                   transition: transform 0.3s ease, box-shadow 0.3s ease;
                                   border-top: 4px solid {{ $program->color }};"
                            data-animate="fade-up">

                            {{-- Program Image --}}
                            <div class="overflow-hidden" style="height: 220px;">
                                <img
                                    src="{{ asset($program->image_path) }}"
                                    alt="{{ $program->name() }}"
                                    class="w-full h-full object-cover"
                                    style="transition: transform 0.5s ease;"
                                    loading="lazy">
                            </div>

                            {{-- Card Body --}}
                            <div class="flex flex-col flex-1 p-7">

                                {{-- Program Name --}}
                                <h3 class="font-heading font-bold mb-3"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 1.25rem;
                                           color: {{ $program->color }};">
                                    {{ $program->name() }}
                                </h3>

                                {{-- Description --}}
                                <p class="text-sm leading-relaxed flex-1 mb-6"
                                   style="color: #5a6a7a;">
                                    {{ $program->description() }}
                                </p>

                                {{-- CTA Link --}}
                                <a
                                    href="{{ $program->url }}"
                                    class="inline-flex items-center gap-2 text-sm font-semibold"
                                    style="color: {{ $program->color }};">
                                    {{ __('home.learn_more') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2"
                                         style="transition: transform 0.2s ease;"
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

@endsection
