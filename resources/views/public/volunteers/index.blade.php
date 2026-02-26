@extends('layouts.public')

@section('title', __('volunteers.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('volunteers.meta_description'))

@push('head')
<style>
    /* ── Volunteer form field focus (magenta ring) ── */
    .vol-field:focus {
        outline: none;
        border-color: #c80078 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(200, 0, 120, 0.12);
    }

    /* ── Benefit card hover ── */
    .vol-benefit-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        opacity: 0;
        transform: translateY(20px);
    }
    .vol-benefit-card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 36px rgba(0, 20, 50, 0.10);
    }

    /* ── Program area card transition ── */
    .vol-area-btn {
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .vol-area-btn:hover {
        box-shadow: 0 4px 16px rgba(0, 20, 50, 0.08);
    }

    /* ── Availability pill transition ── */
    .vol-avail-btn {
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .vol-avail-btn:hover {
        box-shadow: 0 2px 8px rgba(200, 0, 120, 0.15);
    }

    /* ── Appeal section headline GSAP: start hidden ── */
    .vol-hero-label,
    .vol-hero-heading,
    .vol-hero-sub,
    .vol-hero-cta {
        opacity: 0;
        transform: translateY(22px);
    }

    /* ── Form panel entrance ── */
    .vol-form-panel {
        opacity: 0;
        transform: translateY(20px);
    }

    /* ── Reduced motion: skip all custom animation states ── */
    @media (prefers-reduced-motion: reduce) {
        .vol-hero-label,
        .vol-hero-heading,
        .vol-hero-sub,
        .vol-hero-cta,
        .vol-benefit-card,
        .vol-form-panel {
            opacity: 1 !important;
            transform: none !important;
        }
        .vol-benefit-card:hover {
            transform: none !important;
        }
    }
</style>
@endpush

@section('content')

    {{-- ================================================================
         APPEAL / HERO SECTION  (navy background, no gradient)
         ================================================================ --}}
    <section id="vol-appeal"
             class="relative overflow-hidden"
             style="background-color: #002850; min-height: clamp(420px, 55vw, 620px);">

        {{-- Background image with flat dark overlay ── NO gradient --}}
        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('volunteers.hero_heading') }}"
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.82);"></div>

        {{-- Left accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        {{-- Content --}}
        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 pt-28">

            {{-- Breadcrumb --}}
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
                    <li style="color: #ffffff;" aria-current="page">{{ __('volunteers.page_title') }}</li>
                </ol>
            </nav>

            {{-- Label --}}
            <span class="vol-hero-label block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;">
                {{ __('volunteers.hero_label') }}
            </span>

            {{-- Main headline --}}
            <h1 class="vol-hero-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5vw, 3.5rem);
                       color: #ffffff;
                       line-height: 1.1;
                       max-width: 720px;">
                {{ __('volunteers.hero_heading') }}
            </h1>

            {{-- Gold rule --}}
            <div class="mt-5 mb-5 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

            {{-- Sub copy --}}
            <p class="vol-hero-sub max-w-lg text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.80);">
                {{ __('volunteers.hero_sub') }}
            </p>

            {{-- CTA button — scrolls to form --}}
            <div class="vol-hero-cta mt-8">
                <a href="#vol-form"
                   onclick="document.getElementById('vol-form').scrollIntoView({behavior:'smooth'}); return false;"
                   class="inline-flex items-center gap-2 rounded-xl px-7 py-3.5 text-sm font-bold transition-opacity hover:opacity-90 focus-visible:outline-white"
                   style="background-color: #c80078; color: #ffffff;">
                    {{ __('volunteers.hero_cta') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ================================================================
         "POURQUOI S'ENGAGER" — Benefits section
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section heading --}}
            <div class="text-center mb-12">
                <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                      style="color: #c80078;">
                    {{ __('volunteers.benefits_label') }}
                </span>
                <h2 class="font-bold"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(1.5rem, 3.5vw, 2.25rem);
                           color: #002850;
                           line-height: 1.15;">
                    {{ __('volunteers.benefits_heading') }}
                </h2>
                <div class="mt-4 mx-auto h-0.5 w-12 rounded-full" style="background-color: #c8a03c;"></div>
            </div>

            {{-- Benefits grid — 4 cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Benefit 1: Field experience --}}
                <div class="vol-benefit-card bg-white rounded-2xl p-7"
                     style="border: 1px solid #e8e4de;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
                         style="background-color: rgba(0,40,80,0.08);">
                        <svg class="w-6 h-6" style="color: #002850;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2" style="color: #002850;">
                        {{ __('volunteers.benefit_1_title') }}
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: #64748b;">
                        {{ __('volunteers.benefit_1_desc') }}
                    </p>
                </div>

                {{-- Benefit 2: Real impact --}}
                <div class="vol-benefit-card bg-white rounded-2xl p-7"
                     style="border: 1px solid #e8e4de;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
                         style="background-color: rgba(200,0,120,0.08);">
                        <svg class="w-6 h-6" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2" style="color: #002850;">
                        {{ __('volunteers.benefit_2_title') }}
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: #64748b;">
                        {{ __('volunteers.benefit_2_desc') }}
                    </p>
                </div>

                {{-- Benefit 3: Community --}}
                <div class="vol-benefit-card bg-white rounded-2xl p-7"
                     style="border: 1px solid #e8e4de;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
                         style="background-color: rgba(200,160,60,0.12);">
                        <svg class="w-6 h-6" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2" style="color: #002850;">
                        {{ __('volunteers.benefit_3_title') }}
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: #64748b;">
                        {{ __('volunteers.benefit_3_desc') }}
                    </p>
                </div>

                {{-- Benefit 4: Recognition --}}
                <div class="vol-benefit-card bg-white rounded-2xl p-7"
                     style="border: 1px solid #e8e4de;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
                         style="background-color: rgba(0,40,80,0.08);">
                        <svg class="w-6 h-6" style="color: #143c64;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2" style="color: #002850;">
                        {{ __('volunteers.benefit_4_title') }}
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: #64748b;">
                        {{ __('volunteers.benefit_4_desc') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================
         APPLICATION FORM SECTION
         ================================================================ --}}
    <section id="vol-form" class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                x-data="{
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    cityCountry: '',
                    areas: [],
                    availability: 'flexible',
                    motivation: '',
                    submitted: false,
                    toggleArea(area) {
                        const idx = this.areas.indexOf(area);
                        if (idx === -1) {
                            this.areas.push(area);
                        } else {
                            this.areas.splice(idx, 1);
                        }
                    }
                }"
                x-sync>

                {{-- ── Success state ── --}}
                <div x-show="submitted"
                     x-transition:enter="transition ease-out duration-400"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="text-center py-16"
                     style="display: none;">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6"
                         style="background-color: rgba(200,0,120,0.08);">
                        <svg class="w-10 h-10" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-2xl mb-3"
                        style="font-family: 'Playfair Display', serif; color: #002850;">
                        {{ __('volunteers.success_heading') }}
                    </h2>
                    <p class="text-sm leading-relaxed mb-8 max-w-sm mx-auto" style="color: #64748b;">
                        {{ __('volunteers.success_sub') }}
                    </p>
                    <button @click="submitted = false"
                            class="text-sm font-semibold transition-opacity hover:opacity-75"
                            style="color: #c80078;">
                        {{ __('volunteers.success_reset') }}
                    </button>
                </div>

                {{-- ── Form ── --}}
                <div x-show="!submitted">

                    {{-- Form section heading --}}
                    <div class="text-center mb-10 vol-form-panel">
                        <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                              style="color: #c80078;">
                            {{ __('volunteers.form_label') }}
                        </span>
                        <h2 class="font-bold"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.4rem, 3vw, 2rem);
                                   color: #002850;
                                   line-height: 1.15;">
                            {{ __('volunteers.form_heading') }}
                        </h2>
                        <div class="mt-4 mx-auto h-0.5 w-10 rounded-full" style="background-color: #c80078;"></div>
                        <p class="mt-4 text-sm" style="color: #64748b;">
                            {{ __('volunteers.form_sub') }}
                        </p>
                    </div>

                    <form @submit.prevent="$action('{{ route('public.volunteers.store') }}')"
                          class="vol-form-panel rounded-2xl p-8 lg:p-10 space-y-6"
                          style="background-color: #fafafa; border: 1px solid #e8e4de; box-shadow: 0 4px 24px rgba(20,60,100,0.07);">

                        {{-- Honeypot --}}
                        @honeypot

                        {{-- Name row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="vol-first-name"
                                       class="block text-xs font-bold uppercase tracking-wider mb-2"
                                       style="color: #143c64;">
                                    {{ __('volunteers.field_first_name') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input id="vol-first-name"
                                       x-model="firstName"
                                       x-name="firstName"
                                       type="text"
                                       autocomplete="given-name"
                                       placeholder="{{ __('volunteers.placeholder_first_name') }}"
                                       class="vol-field w-full rounded-xl text-sm px-4 transition-all"
                                       style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; height: 52px;">
                                <p x-message="firstName" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                            </div>
                            <div>
                                <label for="vol-last-name"
                                       class="block text-xs font-bold uppercase tracking-wider mb-2"
                                       style="color: #143c64;">
                                    {{ __('volunteers.field_last_name') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input id="vol-last-name"
                                       x-model="lastName"
                                       x-name="lastName"
                                       type="text"
                                       autocomplete="family-name"
                                       placeholder="{{ __('volunteers.placeholder_last_name') }}"
                                       class="vol-field w-full rounded-xl text-sm px-4 transition-all"
                                       style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; height: 52px;">
                                <p x-message="lastName" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                            </div>
                        </div>

                        {{-- Email & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="vol-email"
                                       class="block text-xs font-bold uppercase tracking-wider mb-2"
                                       style="color: #143c64;">
                                    {{ __('volunteers.field_email') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input id="vol-email"
                                       x-model="email"
                                       x-name="email"
                                       type="email"
                                       autocomplete="email"
                                       placeholder="{{ __('volunteers.placeholder_email') }}"
                                       class="vol-field w-full rounded-xl text-sm px-4 transition-all"
                                       style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; height: 52px;">
                                <p x-message="email" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                            </div>
                            <div>
                                <label for="vol-phone"
                                       class="block text-xs font-bold uppercase tracking-wider mb-2"
                                       style="color: #143c64;">
                                    {{ __('volunteers.field_phone') }}
                                </label>
                                <input id="vol-phone"
                                       x-model="phone"
                                       x-name="phone"
                                       type="tel"
                                       autocomplete="tel"
                                       placeholder="{{ __('volunteers.placeholder_phone') }}"
                                       class="vol-field w-full rounded-xl text-sm px-4 transition-all"
                                       style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; height: 52px;">
                                <p x-message="phone" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                            </div>
                        </div>

                        {{-- City / Country --}}
                        <div>
                            <label for="vol-city"
                                   class="block text-xs font-bold uppercase tracking-wider mb-2"
                                   style="color: #143c64;">
                                {{ __('volunteers.field_city') }}
                            </label>
                            <input id="vol-city"
                                   x-model="cityCountry"
                                   x-name="cityCountry"
                                   type="text"
                                   placeholder="{{ __('volunteers.placeholder_city') }}"
                                   class="vol-field w-full rounded-xl text-sm px-4 transition-all"
                                   style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; height: 52px;">
                        </div>

                        {{-- Areas of interest (program checkbox cards) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider mb-3"
                                   style="color: #143c64;">
                                {{ __('volunteers.field_areas') }} <span style="color: #c80078;">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ([
                                    'protege' => ['color' => '#143c64', 'bg' => 'rgba(20,60,100,0.07)', 'label_key' => 'volunteers.area_protege', 'desc_key' => 'volunteers.area_protege_desc'],
                                    'eleve'   => ['color' => '#c80078', 'bg' => 'rgba(200,0,120,0.07)', 'label_key' => 'volunteers.area_eleve',   'desc_key' => 'volunteers.area_eleve_desc'],
                                    'respire' => ['color' => '#16a34a', 'bg' => 'rgba(22,163,74,0.07)',  'label_key' => 'volunteers.area_respire', 'desc_key' => 'volunteers.area_respire_desc'],
                                ] as $key => $prog)
                                <button
                                    type="button"
                                    @click="toggleArea('{{ $key }}')"
                                    :style="areas.includes('{{ $key }}')
                                        ? 'border-color: {{ $prog['color'] }}; background-color: {{ $prog['bg'] }};'
                                        : 'border-color: #e2e8f0; background-color: #ffffff;'"
                                    class="vol-area-btn text-left p-4 rounded-xl border-2"
                                    :aria-pressed="areas.includes('{{ $key }}').toString()">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded flex items-center justify-center flex-shrink-0 mt-0.5 transition-colors"
                                             :style="areas.includes('{{ $key }}')
                                                 ? 'background-color: {{ $prog['color'] }};'
                                                 : 'background-color: #e2e8f0;'">
                                            <svg x-show="areas.includes('{{ $key }}')"
                                                 class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold" style="color: #002850;">{{ __($prog['label_key']) }}</p>
                                            <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ __($prog['desc_key']) }}</p>
                                        </div>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            <p x-message="areas" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                        </div>

                        {{-- Availability (pill select) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider mb-3"
                                   style="color: #143c64;">
                                {{ __('volunteers.field_availability') }} <span style="color: #c80078;">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach ([
                                    'weekends'  => 'volunteers.avail_weekends',
                                    'weekdays'  => 'volunteers.avail_weekdays',
                                    'flexible'  => 'volunteers.avail_flexible',
                                ] as $val => $labelKey)
                                <button
                                    type="button"
                                    @click="availability = '{{ $val }}'"
                                    :style="availability === '{{ $val }}'
                                        ? 'background-color: #c80078; color: #ffffff; border-color: #c80078; box-shadow: 0 2px 8px rgba(200,0,120,0.25);'
                                        : 'background-color: #ffffff; color: #475569; border-color: #e2e8f0;'"
                                    class="vol-avail-btn px-5 py-2.5 rounded-xl text-sm font-semibold border-2"
                                    :aria-pressed="(availability === '{{ $val }}').toString()">
                                    {{ __($labelKey) }}
                                </button>
                                @endforeach
                            </div>
                            <input type="hidden" x-name="availability" :value="availability">
                        </div>

                        {{-- Motivation textarea --}}
                        <div>
                            <label for="vol-motivation"
                                   class="block text-xs font-bold uppercase tracking-wider mb-2"
                                   style="color: #143c64;">
                                {{ __('volunteers.field_motivation') }}
                            </label>
                            <textarea id="vol-motivation"
                                      x-model="motivation"
                                      x-name="motivation"
                                      rows="6"
                                      placeholder="{{ __('volunteers.placeholder_motivation') }}"
                                      class="vol-field w-full rounded-xl text-sm px-4 py-3 resize-y transition-all"
                                      style="border: 1.5px solid #e2e8f0; background-color: #ffffff; color: #1e293b; min-height: 200px; line-height: 1.7;"></textarea>
                        </div>

                        {{-- Submit button --}}
                        <button type="submit"
                                :disabled="$fetching()"
                                class="w-full rounded-xl font-bold text-sm text-white transition-all"
                                style="background-color: #c80078; height: 54px; letter-spacing: 0.04em;"
                                :style="$fetching() ? 'opacity: 0.65; cursor: not-allowed;' : 'opacity: 1;'">
                            <span x-show="!$fetching()" class="flex items-center justify-center gap-2">
                                {{ __('volunteers.form_submit') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </span>
                            <span x-show="$fetching()" x-cloak class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                {{ __('volunteers.form_submitting') }}
                            </span>
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function initVolunteerAnimations() {
        if (reduced) { return; }

        if (typeof gsap === 'undefined') { return; }

        /* ── Hero headline stagger ── */
        var heroElements = [
            document.querySelector('.vol-hero-label'),
            document.querySelector('.vol-hero-heading'),
            document.querySelector('.vol-hero-sub'),
            document.querySelector('.vol-hero-cta'),
        ].filter(Boolean);

        if (heroElements.length) {
            gsap.to(heroElements, {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power2.out',
                stagger: 0.12,
            });
        }

        /* ── Benefit cards stagger in on scroll ── */
        if (typeof ScrollTrigger !== 'undefined') {
            var benefitCards = document.querySelectorAll('.vol-benefit-card');
            if (benefitCards.length) {
                gsap.to(benefitCards, {
                    opacity: 1,
                    y: 0,
                    duration: 0.65,
                    ease: 'power2.out',
                    stagger: 0.09,
                    scrollTrigger: {
                        trigger: benefitCards[0],
                        start: 'top 88%',
                        once: true,
                    },
                });
            }

            /* ── Form panel entrance on scroll ── */
            var formPanels = document.querySelectorAll('.vol-form-panel');
            if (formPanels.length) {
                gsap.to(formPanels, {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    ease: 'power2.out',
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: formPanels[0],
                        start: 'top 88%',
                        once: true,
                    },
                });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', initVolunteerAnimations);
    document.addEventListener('gale:navigated', initVolunteerAnimations);
})();
</script>
@endpush
