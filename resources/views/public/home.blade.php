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

@endsection
