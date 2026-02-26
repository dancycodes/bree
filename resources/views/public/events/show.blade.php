@extends('layouts.public')

@section('title', $event->title() . ' — ' . config('app.name'))
@section('meta_description', app()->getLocale() === 'fr' ? ($event->description_fr ?? '') : ($event->description_en ?? ''))
@section('og_image', $event->thumbnail_path ? asset($event->thumbnail_path) : asset('images/logo.png'))

@section('content')

    {{-- ================================================================
         HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(300px, 38vw, 440px);">

        @if ($event->thumbnail_path)
            <img src="{{ asset($event->thumbnail_path) }}"
                 alt="{{ $event->title() }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="eager">
        @else
            <div class="absolute inset-0" style="background-color: #002850;"></div>
        @endif

        {{-- Solid dark overlay — NO gradient per brand rules --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.80);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        {{-- Past event tint: add a subtle desaturating overlay if past --}}
        @if ($isPast)
            <div class="absolute inset-0" style="background-color: rgba(0,0,0,0.18); mix-blend-mode: saturation;"></div>
        @endif

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium flex-wrap"
                    style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           x-navigate
                           class="hover:text-white transition-colors focus-visible:outline-white"
                           style="color: rgba(255,255,255,0.55);">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li>
                        <a href="{{ route('public.events') }}"
                           x-navigate
                           class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.55);">
                            {{ __('events.page_title') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li class="truncate max-w-xs" style="color: #ffffff;" aria-current="page">
                        {{ $event->title() }}
                    </li>
                </ol>
            </nav>

            {{-- Date badge --}}
            <div class="flex items-center gap-3 mb-4" data-animate="fade-up">
                <div class="flex-shrink-0 flex flex-col items-center justify-center w-14 h-14 rounded-xl"
                     style="background-color: {{ $isPast ? '#475569' : '#c80078' }};">
                    <span class="font-bold text-white leading-none text-xl">
                        {{ $event->event_date->format('d') }}
                    </span>
                    <span class="text-white text-xs uppercase tracking-wide">
                        {{ $event->event_date->translatedFormat('M') }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest"
                       style="color: {{ $isPast ? 'rgba(255,255,255,0.5)' : '#c8a03c' }};">
                        {{ $event->event_date->translatedFormat('Y') }}
                    </p>
                    @if ($event->event_time)
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">
                            {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                        </p>
                    @endif
                </div>
                @if ($isPast)
                    <span class="ml-2 px-3 py-1 rounded-full text-xs font-bold"
                          style="background-color: rgba(255,255,255,0.12); color: rgba(255,255,255,0.72);">
                        {{ __('events.past_badge') }}
                    </span>
                @endif
            </div>

            <h1 class="font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.15;
                       max-width: 800px;"
                data-animate="fade-up">
                {{ $event->title() }}
            </h1>

            <div class="mt-5 h-0.5 w-16" style="background-color: {{ $isPast ? 'rgba(255,255,255,0.3)' : '#c8a03c' }};"></div>

        </div>

    </section>

    {{-- ================================================================
         MAIN CONTENT + SIDEBAR
         Gale x-data: reg_submitted drives inline success state
         ================================================================ --}}
    <section class="py-16" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                x-data="{ reg_name: '', reg_email: '', reg_submitted: false }"
                x-sync="['reg_name', 'reg_email', 'reg_submitted']"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ===================================================
                     Main content (2/3)
                     =================================================== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ── Structured metadata info block ── --}}
                    <div class="bg-white rounded-2xl p-6" data-animate="fade-up"
                         style="border: 1px solid rgba(0,0,0,0.06);">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            {{-- Date + time --}}
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                     style="background-color: rgba(200,0,120,0.08);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         stroke-width="1.75" style="color: #c80078;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                       style="color: #94a3b8;">{{ __('ui.date') ?? 'Date' }}</p>
                                    <p class="text-sm font-semibold" style="color: #002850;">
                                        {{ ucfirst($event->event_date->translatedFormat('l d F Y')) }}
                                    </p>
                                    @if ($event->event_time)
                                        <p class="text-xs mt-0.5" style="color: #64748b;">
                                            {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Location --}}
                            @if ($event->location())
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                         style="background-color: rgba(200,0,120,0.08);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.75" style="color: #c80078;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                           style="color: #94a3b8;">
                                            {{ app()->getLocale() === 'fr' ? 'Lieu' : 'Location' }}
                                        </p>
                                        <p class="text-sm font-semibold" style="color: #002850;">
                                            {{ $event->location() }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Capacity --}}
                            @if ($event->registration_required && $event->max_capacity)
                                @php
                                    $isFull = $registrationsCount >= $event->max_capacity;
                                    $isLastFew = !$isFull && ($event->max_capacity - $registrationsCount) <= max(1, intval($event->max_capacity * 0.15));
                                @endphp
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                         style="background-color: rgba(200,0,120,0.08);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.75" style="color: #c80078;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider mb-1.5"
                                           style="color: #94a3b8;">{{ __('events.capacity_label') }}</p>
                                        @if ($isFull)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                  style="background-color: rgba(239,68,68,0.10); color: #dc2626;">
                                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #dc2626;"></span>
                                                {{ __('events.capacity_full') }}
                                            </span>
                                        @elseif ($isLastFew)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                  style="background-color: rgba(200,160,60,0.12); color: #a07020;">
                                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #c8a03c;"></span>
                                                {{ __('events.capacity_last') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                                  style="background-color: rgba(22,163,74,0.10); color: #15803d;">
                                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background-color: #16a34a;"></span>
                                                {{ __('events.capacity_available') }}
                                            </span>
                                        @endif
                                        <p class="text-xs mt-1" style="color: #94a3b8;">
                                            {{ $registrationsCount }} / {{ $event->max_capacity }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Program badge --}}
                            @if ($program)
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                         style="background-color: {{ $program->color }}18;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.75" style="color: {{ $program->color }};">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider mb-1.5"
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

                    {{-- ── Description body ── --}}
                    @php
                        $description = app()->getLocale() === 'fr' ? $event->description_fr : $event->description_en;
                        $paragraphs = $description ? array_filter(explode("\n\n", trim($description))) : [];
                    @endphp
                    @if ($paragraphs)
                        <div class="bg-white rounded-2xl p-6" data-animate="fade-up"
                             style="border: 1px solid rgba(0,0,0,0.06);">
                            <div class="space-y-4" style="line-height: 1.8;">
                                @foreach ($paragraphs as $paragraph)
                                    <p style="color: #334155; font-size: 0.95rem;">{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ── Back link ── --}}
                    <div data-animate="fade-up">
                        <a href="{{ route('public.events') }}"
                           x-navigate
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

                {{-- ===================================================
                     Sidebar (1/3)
                     =================================================== --}}
                <div class="space-y-5">

                    @if ($isPast)
                        {{-- Past event notice --}}
                        <div class="bg-white rounded-2xl p-6 text-center" data-animate="fade-up"
                             style="border: 1px solid #e2e8f0;">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                 style="background-color: #f1f5f9;">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" style="color: #64748b;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold mb-2" style="color: #475569;">
                                {{ __('events.event_past') }}
                            </p>
                            <p class="text-xs leading-relaxed mb-4" style="color: #94a3b8;">
                                {{ __('events.event_past_sub') }}
                            </p>
                            <a href="{{ route('public.events') }}"
                               x-navigate
                               class="inline-flex items-center gap-1.5 text-xs font-bold transition-opacity hover:opacity-75"
                               style="color: #c80078;">
                                {{ __('events.back_to_events') }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                </svg>
                            </a>
                        </div>

                    @elseif ($isFull)
                        {{-- Event full --}}
                        <div class="bg-white rounded-2xl p-6 text-center" data-animate="fade-up"
                             style="border: 1px solid #e2e8f0;">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                 style="background-color: rgba(239,68,68,0.08);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" style="color: #dc2626;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mb-3"
                                  style="background-color: rgba(239,68,68,0.10); color: #dc2626;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: #dc2626;"></span>
                                {{ __('events.capacity_full') }}
                            </span>
                            <p class="text-sm leading-relaxed" style="color: #64748b;">
                                {{ __('events.event_full_body') }}
                            </p>
                        </div>

                    @elseif ($event->registration_required)
                        {{-- ── Registration Form / Success State ── --}}
                        <div class="bg-white rounded-2xl p-6" data-animate="fade-up"
                             style="border: 1px solid rgba(0,0,0,0.06);">

                            {{-- Success state (inline, no reload) --}}
                            <div x-show="reg_submitted"
                                 x-transition:enter="transition-opacity duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="text-center py-4"
                                 style="display: none;">
                                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(22,163,74,0.10);">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         stroke-width="1.75" style="color: #16a34a;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold mb-2" style="color: #002850;">
                                    {{ __('events.registration_success_heading') }}
                                </h3>
                                <p class="text-xs leading-relaxed" style="color: #64748b;">
                                    {{ __('events.registration_success_body') }}
                                </p>
                            </div>

                            {{-- Registration form (hidden after success) --}}
                            <div x-show="!reg_submitted">
                                {{-- Invitation header --}}
                                <div class="mb-5 pb-4" style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                    <div class="w-8 h-0.5 mb-3 rounded-full" style="background-color: #c80078;"></div>
                                    <h3 class="font-bold text-base mb-1"
                                        style="font-family: 'Playfair Display', serif; color: #002850;">
                                        {{ __('events.registration_title_invitation') }}
                                    </h3>
                                    <p class="text-xs" style="color: #64748b;">
                                        {{ __('events.registration_subtitle') }}
                                    </p>
                                </div>

                                <div class="space-y-4">

                                    {{-- Honeypot --}}
                                    @honeypot

                                    {{-- Name --}}
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                                               style="color: #475569;">
                                            {{ __('events.register_name') }}
                                            <span style="color: #c80078;" aria-hidden="true">*</span>
                                        </label>
                                        <input x-model="reg_name"
                                               x-name="reg_name"
                                               type="text"
                                               autocomplete="name"
                                               placeholder="{{ __('events.register_name') }}"
                                               class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                               style="border-color: #e2e8f0; color: #1e293b; background-color: #fafafa;"
                                               @focus="$el.style.borderColor='#c80078'; $el.style.backgroundColor='#ffffff'"
                                               @blur="$el.style.borderColor='#e2e8f0'; $el.style.backgroundColor='#fafafa'">
                                        <p x-message="reg_name" class="text-xs mt-1" style="color: #ef4444;"></p>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5"
                                               style="color: #475569;">
                                            {{ __('events.register_email') }}
                                            <span style="color: #c80078;" aria-hidden="true">*</span>
                                        </label>
                                        <input x-model="reg_email"
                                               x-name="reg_email"
                                               type="email"
                                               autocomplete="email"
                                               placeholder="{{ __('events.register_email') }}"
                                               class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                               style="border-color: #e2e8f0; color: #1e293b; background-color: #fafafa;"
                                               @focus="$el.style.borderColor='#c80078'; $el.style.backgroundColor='#ffffff'"
                                               @blur="$el.style.borderColor='#e2e8f0'; $el.style.backgroundColor='#fafafa'">
                                        <p x-message="reg_email" class="text-xs mt-1" style="color: #ef4444;"></p>
                                    </div>

                                </div>

                                <button
                                    @click="$action('{{ route('public.events.register', $event) }}')"
                                    :disabled="$fetching()"
                                    class="w-full mt-5 py-3.5 rounded-xl text-sm font-bold text-white transition-opacity disabled:opacity-50"
                                    style="background-color: #c80078; letter-spacing: 0.03em;"
                                    @mouseover="if (!$el.disabled) $el.style.backgroundColor='#a8006a'"
                                    @mouseout="$el.style.backgroundColor='#c80078'">
                                    <span x-show="!$fetching()">{{ __('events.register_submit') }}</span>
                                    <span x-show="$fetching()" class="inline-flex items-center gap-2 justify-center">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Envoi…' : 'Sending…' }}</span>
                                    </span>
                                </button>

                                <p class="mt-3 text-xs text-center" style="color: #94a3b8;">
                                    {{ app()->getLocale() === 'fr' ? 'Vos données sont traitées conformément à notre politique de confidentialité.' : 'Your data is processed in accordance with our privacy policy.' }}
                                </p>
                            </div>

                        </div>

                    @else
                        {{-- Upcoming, no registration — date reminder card --}}
                        <div class="bg-white rounded-2xl p-6 text-center" data-animate="fade-up"
                             style="border: 1px solid rgba(0,0,0,0.06);">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center"
                                 style="background-color: rgba(200,0,120,0.08);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <p class="font-bold text-2xl mb-0.5"
                               style="font-family: 'Playfair Display', serif; color: #c80078;">
                                {{ $event->event_date->format('d') }}
                            </p>
                            <p class="text-sm font-semibold uppercase tracking-wide mb-1" style="color: #002850;">
                                {{ $event->event_date->translatedFormat('F Y') }}
                            </p>
                            @if ($event->event_time)
                                <p class="text-xs" style="color: #64748b;">
                                    {{ __('events.at') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}
                                </p>
                            @endif
                            @if ($event->location())
                                <div class="flex items-center justify-center gap-1.5 mt-3">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2" style="color: #c8a03c;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                    <p class="text-xs" style="color: #64748b;">{{ $event->location() }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Share --}}
                    <div class="bg-white rounded-2xl p-5" data-animate="fade-up"
                         style="border: 1px solid rgba(0,0,0,0.06);">
                        <h4 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: #94a3b8;">
                            {{ __('events.share') }}
                        </h4>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #3b5998;"
                               aria-label="Partager sur Facebook"
                               @mouseover="$el.style.backgroundColor='#3b5998'; $el.style.color='#ffffff'"
                               @mouseout="$el.style.backgroundColor='#f1f5f9'; $el.style.color='#3b5998'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($event->title()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #1a1a1a;"
                               aria-label="Partager sur X"
                               @mouseover="$el.style.backgroundColor='#1a1a1a'; $el.style.color='#ffffff'"
                               @mouseout="$el.style.backgroundColor='#f1f5f9'; $el.style.color='#1a1a1a'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                               style="background-color: #f1f5f9; color: #0a66c2;"
                               aria-label="Partager sur LinkedIn"
                               @mouseover="$el.style.backgroundColor='#0a66c2'; $el.style.color='#ffffff'"
                               @mouseout="$el.style.backgroundColor='#f1f5f9'; $el.style.color='#0a66c2'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
