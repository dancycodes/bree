@extends('layouts.public')

@section('title', $event->title() . ' — ' . config('app.name'))
@section('meta_description', app()->getLocale() === 'fr' ? ($event->description_fr ?? '') : ($event->description_en ?? ''))

@section('content')

    {{-- ================================================================
         HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 35vw, 420px);">

        <img src="{{ asset($event->thumbnail_path ?? 'images/sections/events-placeholder.jpg') }}"
             alt="{{ $event->title() }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.80);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            <nav class="mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium flex-wrap" style="color: rgba(255,255,255,0.6);">
                    <li>
                        <a href="{{ route('public.home') }}" class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li>
                        <a href="{{ route('public.events') }}" class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('events.page_title') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li class="truncate max-w-xs" style="color: #ffffff;">{{ $event->title() }}</li>
                </ol>
            </nav>

            {{-- Date badge --}}
            <div class="flex items-center gap-3 mb-4" data-animate="fade-up">
                <div class="flex-shrink-0 flex flex-col items-center justify-center w-14 h-14 rounded-xl"
                     style="background-color: #c80078;">
                    <span class="font-bold text-white leading-none text-xl">
                        {{ $event->event_date->format('d') }}
                    </span>
                    <span class="text-white text-xs uppercase tracking-wide">
                        {{ $event->event_date->translatedFormat('M') }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest" style="color: #c8a03c;">
                        {{ $event->event_date->translatedFormat('Y') }}
                    </p>
                    @if ($event->event_time)
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">
                            {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                        </p>
                    @endif
                </div>
            </div>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.5rem, 4vw, 2.75rem);
                       color: #ffffff;
                       line-height: 1.15;
                       max-width: 800px;"
                data-animate="fade-up">
                {{ $event->title() }}
            </h1>

            <div class="mt-4 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

        </div>

    </section>

    {{-- ================================================================
         MAIN CONTENT + SIDEBAR
         ================================================================ --}}
    <section class="py-16" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                x-data="{ reg_name: '', reg_email: '' }"
                x-sync="['reg_name', 'reg_email']"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main content (2/3) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Meta info card --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6" data-animate="fade-up">
                        <div class="flex flex-wrap gap-x-8 gap-y-4">

                            {{-- Date --}}
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                     style="background-color: #c8007812;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         stroke-width="1.75" style="color: #c80078;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide mb-0.5"
                                       style="color: #94a3b8;">Date</p>
                                    <p class="text-sm font-semibold" style="color: #002850;">
                                        {{ $event->event_date->translatedFormat('l d F Y') }}
                                    </p>
                                    @if ($event->event_time)
                                        <p class="text-xs" style="color: #64748b;">
                                            {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Location --}}
                            @if ($event->location())
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background-color: #c8007812;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.75" style="color: #c80078;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide mb-0.5"
                                           style="color: #94a3b8;">{{ app()->getLocale() === 'fr' ? 'Lieu' : 'Location' }}</p>
                                        <p class="text-sm font-semibold" style="color: #002850;">
                                            {{ $event->location() }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Program badge --}}
                            @if ($program)
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background-color: {{ $program->color }}18;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.75" style="color: {{ $program->color }};">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide mb-0.5"
                                           style="color: #94a3b8;">Programme</p>
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                              style="background-color: {{ $program->color }}18; color: {{ $program->color }};">
                                            {{ $program->name() }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- Description --}}
                    @php
                        $description = app()->getLocale() === 'fr' ? $event->description_fr : $event->description_en;
                        $paragraphs = $description ? array_filter(explode("\n\n", trim($description))) : [];
                    @endphp
                    @if ($paragraphs)
                        <div class="bg-white rounded-2xl shadow-sm p-6" data-animate="fade-up">
                            <div class="prose prose-slate max-w-none" style="line-height: 1.8;">
                                @foreach ($paragraphs as $paragraph)
                                    <p style="color: #334155; margin-bottom: 1rem;">{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Back link --}}
                    <div data-animate="fade-up">
                        <a href="{{ route('public.events') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold transition-opacity hover:opacity-75"
                           style="color: #143c64;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            {{ __('events.back_to_events') }}
                        </a>
                    </div>

                </div>

                {{-- Sidebar (1/3) --}}
                <div class="space-y-5">

                    @if ($isPast)
                        {{-- Past event notice --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 text-center" data-animate="fade-up">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                 style="background-color: #f1f5f9;">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" style="color: #64748b;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold mb-1" style="color: #475569;">
                                {{ __('events.event_past') }}
                            </p>
                            <p class="text-xs" style="color: #94a3b8;">{{ __('events.event_past_sub') }}</p>
                            <a href="{{ route('public.events') }}"
                               class="inline-flex items-center gap-1.5 mt-4 text-xs font-semibold transition-opacity hover:opacity-75"
                               style="color: #c80078;">
                                {{ __('events.back_to_events') }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                </svg>
                            </a>
                        </div>

                    @elseif ($event->registration_required)
                        {{-- Registration form --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6" data-animate="fade-up">
                            <h3 class="text-sm font-bold mb-5" style="color: #002850;">
                                {{ __('events.register_title') }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                        {{ __('events.register_name') }} <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input x-model="reg_name" x-name="reg_name" type="text"
                                           class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                           style="border-color: #e2e8f0; color: #1e293b;">
                                    <p x-message="reg_name" class="text-xs mt-1" style="color: #ef4444;"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                        {{ __('events.register_email') }} <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input x-model="reg_email" x-name="reg_email" type="email"
                                           class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                           style="border-color: #e2e8f0; color: #1e293b;">
                                    <p x-message="reg_email" class="text-xs mt-1" style="color: #ef4444;"></p>
                                </div>
                            </div>

                            <button
                                @click="$action('{{ route('public.events.register', $event) }}')"
                                :disabled="$fetching()"
                                class="w-full mt-5 py-3 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                                style="background-color: #c80078;">
                                <span x-show="!$fetching()">{{ __('events.register_submit') }}</span>
                                <span x-show="$fetching()">…</span>
                            </button>
                        </div>

                    @else
                        {{-- Upcoming, no registration —  date reminder card --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 text-center" data-animate="fade-up">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                 style="background-color: rgba(200,0,120,0.08);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <p class="font-bold text-xl mb-0.5" style="color: #c80078;">
                                {{ $event->event_date->format('d') }}
                            </p>
                            <p class="text-sm font-semibold uppercase tracking-wide" style="color: #002850;">
                                {{ $event->event_date->translatedFormat('F Y') }}
                            </p>
                            @if ($event->location())
                                <p class="text-xs mt-3" style="color: #64748b;">
                                    📍 {{ $event->location() }}
                                </p>
                            @endif
                        </div>
                    @endif

                    {{-- Share --}}
                    <div class="bg-white rounded-2xl shadow-sm p-5" data-animate="fade-up">
                        <h4 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">
                            {{ __('events.share') }}
                        </h4>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #3b5998;"
                               aria-label="Partager sur Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($event->title()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #1da1f2;"
                               aria-label="Partager sur X (Twitter)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #0a66c2;"
                               aria-label="Partager sur LinkedIn">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
