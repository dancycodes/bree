@extends('layouts.public')

@section('title', __('programs.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('programs.page_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         Deep navy background, title centred, gold accent rule.
         ================================================================ --}}
    <section class="py-20 lg:py-28" style="background-color: #002850;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                  style="color: #c8a03c;">
                {{ config('app.name') }}
            </span>
            <h1 class="bree-hero-h1"
                style="color: #ffffff;">
                {{ __('programs.page_title') }}
            </h1>
            <div class="mt-6 h-0.5 w-16 mx-auto" style="background-color: #c8a03c;"></div>
            <p class="mt-6 max-w-2xl mx-auto text-base leading-relaxed"
               style="color: rgba(255,255,255,0.7);">
                {{ __('programs.page_description') }}
            </p>
        </div>
    </section>

    {{-- ================================================================
         PROGRAM CARDS — 3 distinctive cards, each with strong color identity.
         Layout: vertical stack of wide cards on desktop; single column mobile.
         Each card: large color band on left (desktop) or top (mobile),
         program name in Playfair, short description, stat snippet, CTA.
         ================================================================ --}}
    <section class="py-20 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($programs->isEmpty())

                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center"
                         style="background-color: rgba(200,0,120,0.08);">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             stroke-width="1.5" style="color: #c80078;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold mb-2"
                        style="color: #475569; font-family: 'Playfair Display', serif;">
                        {{ __('programs.no_programs') }}
                    </h2>
                    <p class="text-sm" style="color: #94a3b8;">{{ __('programs.no_programs_sub') }}</p>
                </div>

            @else

            <div class="flex flex-col gap-10 lg:gap-12" id="programs-listing" data-stagger="0.12">

                @foreach ($programs as $index => $program)
                    @php
                        /**
                         * Each program gets its own icon SVG path based on its color / identity.
                         * BREE PROTÈGE (#c80078) = shield/heart
                         * BREE ÉLÈVE  (#143c64) = academic cap
                         * BREE RESPIRE (#c8a03c) = leaf/wind
                         */
                        $programIcons = [
                            'bree-protege' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                            'bree-eleve'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>',
                            'bree-respire' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3C9 7 4 9.5 4 14a8 8 0 0016 0c0-4.5-5-7-8-11z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7"/>',
                        ];
                        $icon = $programIcons[$program->slug] ?? '<path stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/>';
                        $stats = $program->stats();
                        $firstStat = $stats[0] ?? null;
                    @endphp

                    <article
                        class="group relative overflow-hidden rounded-2xl"
                        style="box-shadow: 0 4px 24px rgba(0,0,0,0.08);"
                        data-animate="fade-up">

                        {{-- Card inner: flex row on desktop, column on mobile --}}
                        <div class="flex flex-col lg:flex-row min-h-[280px] lg:min-h-[300px]">

                            {{-- COLOR IDENTITY PANEL
                                 Left band (desktop) / top strip (mobile) using program color.
                                 Contains: large number, icon, vertical label --}}
                            <div class="relative flex-shrink-0 flex flex-col items-center justify-center
                                        lg:w-64 xl:w-72
                                        py-10 px-8 lg:py-12"
                                 style="background-color: {{ $program->color }};">

                                {{-- Large icon --}}
                                <div class="mb-4 opacity-20 absolute top-6 right-6">
                                    <svg class="w-16 h-16" fill="none" stroke="white"
                                         viewBox="0 0 24 24" stroke-width="1" aria-hidden="true">
                                        {!! $icon !!}
                                    </svg>
                                </div>

                                {{-- Program number --}}
                                <span class="text-8xl font-bold leading-none select-none"
                                      style="color: rgba(255,255,255,0.15);
                                             font-family: 'Playfair Display', serif;">
                                    0{{ $index + 1 }}
                                </span>

                                {{-- First stat pill --}}
                                @if ($firstStat)
                                    <div class="mt-4 text-center">
                                        <span class="block text-2xl font-bold text-white"
                                              style="font-family: 'Playfair Display', serif;">
                                            {{ $firstStat['number'] }}
                                        </span>
                                        <span class="block text-xs font-semibold tracking-wide uppercase mt-1"
                                              style="color: rgba(255,255,255,0.75);">
                                            {{ $firstStat['label'] }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Vertical decorative rule --}}
                                <div class="hidden lg:block absolute left-0 top-8 bottom-8 w-0.5"
                                     style="background-color: rgba(255,255,255,0.2);"></div>
                            </div>

                            {{-- MAIN CONTENT PANEL --}}
                            <div class="flex-1 flex flex-col justify-between bg-white px-8 py-10 lg:px-10 xl:px-12">

                                {{-- Top: Name + description --}}
                                <div>
                                    {{-- Program name --}}
                                    <h2 class="bree-subsection-h3 mb-4"
                                        style="color: {{ $program->color }};">
                                        {{ $program->name() }}
                                    </h2>

                                    {{-- Description --}}
                                    <p class="text-sm leading-relaxed mb-6 max-w-xl"
                                       style="color: #5a6a7a;">
                                        {{ $program->longDescription() ?: $program->description() }}
                                    </p>

                                    {{-- Activities preview — top 3 as pills --}}
                                    @php $activities = $program->activities(); @endphp
                                    @if (count($activities) > 0)
                                        <div class="flex flex-wrap gap-2 mb-6">
                                            @foreach (array_slice($activities, 0, 3) as $activity)
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full"
                                                      style="background-color: {{ $program->color }}12;
                                                             color: {{ $program->color }};
                                                             border: 1px solid {{ $program->color }}30;">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                    {{ $activity }}
                                                </span>
                                            @endforeach
                                            @if (count($activities) > 3)
                                                <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 rounded-full"
                                                      style="background-color: #f0f0f0; color: #5a6a7a;">
                                                    +{{ count($activities) - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Bottom: CTA --}}
                                <div class="flex items-center justify-between flex-wrap gap-4">
                                    <a href="{{ route('public.programs.show', $program) }}"
                                       class="inline-flex items-center gap-2 text-sm font-bold transition-opacity duration-200 hover:opacity-75"
                                       style="color: {{ $program->color }};">
                                        {{ __('programs.discover_program') }}
                                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="2.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </a>

                                    {{-- Left border accent bar for visual interest --}}
                                    <div class="hidden lg:block h-10 w-0.5 rounded-full opacity-20"
                                         style="background-color: {{ $program->color }};"></div>
                                </div>

                            </div>

                            {{-- PROGRAM IMAGE PANEL (desktop right side) --}}
                            <div class="hidden xl:block relative flex-shrink-0 w-64 overflow-hidden">
                                <img src="{{ asset($program->image_path) }}"
                                     alt="{{ $program->name() }}"
                                     class="absolute inset-0 w-full h-full object-cover
                                            transition-transform duration-700 group-hover:scale-105"
                                     loading="lazy">
                                {{-- Flat color overlay on image --}}
                                <div class="absolute inset-0"
                                     style="background-color: {{ $program->color }}1a;"></div>
                            </div>

                        </div>

                        {{-- Left accent border --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl"
                             style="background-color: {{ $program->color }};"></div>

                    </article>

                @endforeach

            </div>

            @endif

        </div>
    </section>

@endsection
