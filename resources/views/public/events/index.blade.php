@extends('layouts.public')

@section('title', __('events.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('events.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 35vw, 420px);">

        <img src="{{ asset('images/sections/events-placeholder.jpg') }}"
             alt="{{ __('events.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.78);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            <nav class="mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.6);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">{{ __('events.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('events.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('events.hero_heading') }}
            </h1>

            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

        </div>

    </section>

    {{-- ================================================================
         UPCOMING EVENTS
         ================================================================ --}}
    <section class="py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="font-heading font-bold mb-10"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.5rem, 3vw, 2.25rem);
                       color: #002850;"
                data-animate="fade-up">
                {{ __('events.upcoming_title') }}
            </h2>

            @if ($upcoming->isEmpty())
                <div class="py-16 text-center rounded-2xl bg-white shadow-sm" data-animate="fade-up">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-full flex items-center justify-center"
                         style="background-color: rgba(200,0,120,0.08);">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c80078;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <p class="text-base font-medium mb-1" style="color: #143c64;">{{ __('events.no_upcoming') }}</p>
                    <p class="text-sm" style="color: #94a3b8;">{{ __('events.no_upcoming_sub') }}</p>
                </div>
            @else
                <div class="space-y-6" data-stagger="0.07">
                    @foreach ($upcoming as $event)
                        <article class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all hover:shadow-md"
                                 style="border: 1px solid rgba(0,0,0,0.04);"
                                 data-animate="fade-up">
                            <div class="flex flex-col sm:flex-row">

                                {{-- Date block --}}
                                <div class="sm:w-32 flex-shrink-0 flex flex-row sm:flex-col items-center justify-center gap-3 sm:gap-0 p-5 sm:p-0"
                                     style="background-color: #c80078;">
                                    <span class="font-bold leading-none text-white"
                                          style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 3.5rem);">
                                        {{ $event->event_date->format('d') }}
                                    </span>
                                    <span class="text-sm font-semibold uppercase tracking-widest"
                                          style="color: rgba(255,255,255,0.85);">
                                        {{ $event->event_date->translatedFormat('M Y') }}
                                    </span>
                                </div>

                                {{-- Thumbnail --}}
                                <div class="hidden md:block sm:w-52 flex-shrink-0 overflow-hidden"
                                     style="height: 160px;">
                                    <img src="{{ asset($event->thumbnail_path ?? 'images/sections/events-placeholder.jpg') }}"
                                         alt="{{ $event->title() }}"
                                         class="w-full h-full object-cover">
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-heading font-bold mb-2"
                                            style="font-family: 'Playfair Display', serif;
                                                   font-size: 1.2rem;
                                                   color: #002850;
                                                   line-height: 1.3;">
                                            {{ $event->title() }}
                                        </h3>

                                        {{-- Location + time --}}
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mb-3">
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

                                        @if ($event->description_fr || $event->description_en)
                                            <p class="text-sm leading-relaxed line-clamp-2" style="color: #5a6a7a;">
                                                {{ app()->getLocale() === 'fr' ? $event->description_fr : $event->description_en }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('public.events.show', $event) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold transition-opacity hover:opacity-75"
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

                <h2 class="font-heading font-bold mb-10"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(1.5rem, 3vw, 2.25rem);
                           color: #002850;"
                    data-animate="fade-up">
                    {{ __('events.past_title') }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger="0.06">
                    @foreach ($past as $event)
                        <article class="rounded-2xl overflow-hidden transition-all hover:-translate-y-0.5 hover:shadow-md"
                                 style="border: 1px solid #e2e8f0;"
                                 data-animate="fade-up">

                            {{-- Thumbnail --}}
                            <div class="overflow-hidden relative" style="height: 160px;">
                                <img src="{{ asset($event->thumbnail_path ?? 'images/sections/events-placeholder.jpg') }}"
                                     alt="{{ $event->title() }}"
                                     class="w-full h-full object-cover opacity-70">
                                {{-- Date badge --}}
                                <div class="absolute top-3 left-3 px-3 py-1.5 rounded-lg"
                                     style="background-color: rgba(0,40,80,0.88);">
                                    <span class="text-xs font-bold text-white">
                                        {{ $event->event_date->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5" style="background-color: #f8f5f0;">
                                <h3 class="font-semibold mb-2 leading-snug"
                                    style="font-size: 0.95rem; color: #002850;">
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
                                   style="color: #143c64;">
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
