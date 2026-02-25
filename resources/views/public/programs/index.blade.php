@extends('layouts.public')

@section('title', __('programs.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('programs.page_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO (F-028)
         Navy background, page title, breadcrumb.
         ================================================================ --}}
    <section class="py-20 lg:py-24" style="background-color: #002850;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                  style="color: #c8a03c;">
                {{ config('app.name') }}
            </span>
            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5vw, 3.5rem);
                       color: #ffffff;">
                {{ __('programs.page_title') }}
            </h1>
            <div class="mt-6 h-px w-16 mx-auto" style="background-color: #c8a03c;"></div>
        </div>
    </section>

    {{-- ================================================================
         PROGRAM SECTIONS (alternating white / off-white backgrounds)
         Each program: large name, colored border, image, description,
         activities list with colored check icons.
         ================================================================ --}}
    @foreach ($programs as $index => $program)
        @php
            $isEven = $index % 2 === 0;
            $bg     = $isEven ? '#ffffff' : '#f8f5f0';
        @endphp

        <section
            id="{{ $program->slug }}"
            class="py-20 lg:py-28"
            style="background-color: {{ $bg }};">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Program Color Strip --}}
                <div class="h-1 w-20 mb-10 rounded-full" style="background-color: {{ $program->color }};"
                     data-animate="fade-up"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-start">

                    {{-- Left: Text Content --}}
                    <div data-animate="fade-right">

                        {{-- Program Name --}}
                        <h2 class="font-heading font-bold mb-6"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.75rem, 4vw, 2.75rem);
                                   color: {{ $program->color }};">
                            {{ $program->name() }}
                        </h2>

                        {{-- Long Description --}}
                        <p class="text-base leading-relaxed mb-8"
                           style="color: #5a6a7a;">
                            {{ $program->longDescription() ?: $program->description() }}
                        </p>

                        {{-- Activities List --}}
                        @if (count($program->activities()) > 0)
                            <ul class="space-y-3" data-stagger="0.08">
                                @foreach ($program->activities() as $activity)
                                    <li class="flex items-start gap-3" data-animate="fade-left">
                                        {{-- Colored check icon --}}
                                        <span class="flex-shrink-0 mt-0.5 w-5 h-5 rounded-full flex items-center justify-center"
                                              style="background-color: {{ $program->color }}1a;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" stroke-width="2.5"
                                                 style="color: {{ $program->color }};" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                        </span>
                                        <span class="text-sm leading-relaxed" style="color: #143c64;">
                                            {{ $activity }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- CTA --}}
                        <div class="mt-10">
                            <a
                                href="{{ $program->url }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold"
                                style="color: {{ $program->color }};">
                                {{ __('programs.discover_program') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                    {{-- Right: Program Image --}}
                    <div data-animate="fade-left">
                        <div class="rounded-2xl overflow-hidden"
                             style="border-top: 4px solid {{ $program->color }};
                                    box-shadow: 0 8px 40px rgba(0,0,0,0.10);">
                            <img
                                src="{{ asset($program->image_path) }}"
                                alt="{{ $program->name() }}"
                                class="w-full object-cover"
                                style="height: 400px;"
                                loading="lazy">
                        </div>
                    </div>

                </div>

            </div>

        </section>

    @endforeach

@endsection
