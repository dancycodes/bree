@extends('layouts.public')

@section('title', __('contact.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('contact.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 35vw, 420px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('contact.hero_heading') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.78);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

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
                    <li style="color: #ffffff;" aria-current="page">{{ __('contact.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('contact.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('contact.hero_heading') }}
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.75);"
               data-animate="fade-up">
                {{ __('contact.hero_sub') }}
            </p>

            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

        </div>
    </section>

    {{-- ================================================================
         CONTACT SECTION — Two columns
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 items-start">

                {{-- ── Left: Contact Info Panel ── --}}
                <div class="lg:col-span-2 rounded-2xl overflow-hidden contact-info-panel"
                     style="background-color: #143c64;">

                    <div class="p-8 lg:p-10">

                        <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                              style="color: #c8a03c;">
                            {{ __('contact.hero_label') }}
                        </span>

                        <h2 class="bree-subsection-h3 mb-2"
                            style="color: #ffffff;">
                            {{ __('contact.info_heading') }}
                        </h2>

                        <div class="mb-8 h-0.5 w-10 rounded-full" style="background-color: #c8a03c;"></div>

                        <ul class="space-y-6">

                            {{-- Email --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.18);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                       style="color: #c8a03c;">{{ __('contact.info_email_label') }}</p>
                                    <a href="mailto:{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}"
                                       class="text-sm font-medium transition-opacity hover:opacity-80"
                                       style="color: #ffffff;">
                                        {{ $siteSettings['contact_email'] ?? config('mail.from.address') }}
                                    </a>
                                </div>
                            </li>

                            {{-- Phone --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.18);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                       style="color: #c8a03c;">{{ __('contact.info_phone_label') }}</p>
                                    <a href="tel:{{ preg_replace('/\s/', '', $siteSettings['contact_phone'] ?? '') }}"
                                       class="text-sm font-medium transition-opacity hover:opacity-80"
                                       style="color: #ffffff;">
                                        {{ $siteSettings['contact_phone'] ?? '' }}
                                    </a>
                                </div>
                            </li>

                            {{-- Address --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.18);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                       style="color: #c8a03c;">{{ __('contact.info_address_label') }}</p>
                                    <p class="text-sm font-medium" style="color: #ffffff; line-height: 1.5;">
                                        {{ $siteSettings['contact_address'] ?? '' }}
                                    </p>
                                </div>
                            </li>

                            {{-- Hours --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.18);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1"
                                       style="color: #c8a03c;">{{ __('contact.info_hours_label') }}</p>
                                    <p class="text-sm font-medium" style="color: #ffffff;">
                                        {{ __('contact.info_hours') }}
                                    </p>
                                </div>
                            </li>

                        </ul>

                        {{-- Social links — URLs read from $siteSettings --}}
                        @php
                            $contactSocials = [
                                ['key' => 'social_facebook',  'label' => 'Facebook',  'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                                ['key' => 'social_instagram', 'label' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                                ['key' => 'social_linkedin',  'label' => 'LinkedIn',  'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
                                ['key' => 'social_youtube',   'label' => 'YouTube',   'icon' => 'M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z'],
                                ['key' => 'social_twitter',   'label' => 'X',         'icon' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                            ];
                            $activeContactSocials = array_filter($contactSocials, fn($s) => !empty($siteSettings[$s['key']] ?? ''));
                        @endphp
                        @if(count($activeContactSocials) > 0)
                        <div class="mt-10 pt-8" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <p class="text-xs font-bold uppercase tracking-wider mb-4"
                               style="color: #c8a03c;">{{ __('contact.social_heading') }}</p>
                            <div class="flex items-center gap-3">
                                @foreach($activeContactSocials as $social)
                                    <a href="{{ $siteSettings[$social['key']] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="{{ $social['label'] }}"
                                       class="contact-social-icon w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200"
                                       style="background-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8);">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="{{ $social['icon'] }}"/>
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                {{-- ── Right: Contact Form ── --}}
                <div class="lg:col-span-3 contact-form-panel">

                    <div
                        x-data="{
                            contactName: '',
                            contactEmail: '',
                            contactSubject: '',
                            contactMessage: '',
                            contactSubmitted: false,
                        }"
                        x-sync="['contactName','contactEmail','contactSubject','contactMessage','contactSubmitted']"
                        class="bg-white rounded-2xl"
                        style="border: 1px solid #e8e4de; padding: 40px; box-shadow: 0 4px 24px rgba(20,60,100,0.08);">

                        {{-- Success state --}}
                        <div x-show="contactSubmitted" x-cloak class="text-center py-10">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6"
                                 style="background-color: rgba(200,0,120,0.08);">
                                <svg class="w-10 h-10" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="bree-subsection-h3 mb-3"
                                style="color: #143c64;">
                                {{ __('contact.form_success_heading') }}
                            </h3>
                            <p class="text-sm leading-relaxed mb-8 max-w-sm mx-auto"
                               style="color: #64748b;">
                                {{ __('contact.form_success_sub') }}
                            </p>
                            <button @click="contactSubmitted = false"
                                    class="btn-outline text-sm px-6 py-3 rounded-xl">
                                {{ __('contact.form_new_btn') }}
                            </button>
                        </div>

                        {{-- Form --}}
                        <div x-show="!contactSubmitted">

                            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                                  style="color: #c80078;">
                                {{ __('contact.hero_label') }}
                            </span>

                            <h2 class="bree-subsection-h3 mb-2"
                                style="color: #002850;">
                                {{ __('contact.form_heading') }}
                            </h2>

                            <div class="mb-8 h-0.5 w-10 rounded-full" style="background-color: #c80078;"></div>

                            <form @submit.prevent="$action('{{ route('public.contact.store') }}', { include: ['contactName','contactEmail','contactSubject','contactMessage'] })"
                                  class="space-y-6">

                                @honeypot

                                {{-- Name --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider mb-2"
                                           style="color: #143c64;">
                                        {{ __('contact.form_name_label') }}
                                    </label>
                                    <input type="text"
                                           x-name="contactName"
                                           x-model="contactName"
                                           placeholder="{{ __('contact.form_name_placeholder') }}"
                                           class="contact-field w-full rounded-xl text-sm px-4 transition-all"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b; height: 52px;"
                                           autocomplete="name">
                                    <p x-message="contactName" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider mb-2"
                                           style="color: #143c64;">
                                        {{ __('contact.form_email_label') }}
                                    </label>
                                    <input type="email"
                                           x-name="contactEmail"
                                           x-model="contactEmail"
                                           placeholder="{{ __('contact.form_email_placeholder') }}"
                                           class="contact-field w-full rounded-xl text-sm px-4 transition-all"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b; height: 52px;"
                                           autocomplete="email">
                                    <p x-message="contactEmail" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                                </div>

                                {{-- Subject --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider mb-2"
                                           style="color: #143c64;">
                                        {{ __('contact.form_subject_label') }}
                                    </label>
                                    <input type="text"
                                           x-name="contactSubject"
                                           x-model="contactSubject"
                                           placeholder="{{ __('contact.form_subject_placeholder') }}"
                                           class="contact-field w-full rounded-xl text-sm px-4 transition-all"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b; height: 52px;">
                                    <p x-message="contactSubject" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                                </div>

                                {{-- Message --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider mb-2"
                                           style="color: #143c64;">
                                        {{ __('contact.form_message_label') }}
                                    </label>
                                    <textarea x-name="contactMessage"
                                              x-model="contactMessage"
                                              rows="6"
                                              placeholder="{{ __('contact.form_message_placeholder') }}"
                                              class="contact-field w-full rounded-xl text-sm px-4 py-3 transition-all resize-y"
                                              style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b; min-height: 160px;"></textarea>
                                    <p x-message="contactMessage" class="mt-1.5 text-xs font-medium" style="color: #dc2626; min-height: 1rem;"></p>
                                </div>

                                <button type="submit"
                                        :disabled="$fetching()"
                                        class="btn-primary w-full rounded-xl font-semibold text-sm gap-2"
                                        style="height: 52px; letter-spacing: 0.04em;"
                                        :style="$fetching() ? 'opacity: 0.7; cursor: not-allowed;' : 'opacity: 1;'">
                                    <span x-show="!$fetching()" class="flex items-center justify-center gap-2">
                                        {{ __('contact.form_submit_btn') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </span>
                                    <span x-show="$fetching()" x-cloak class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        {{ __('contact.form_submitting_btn') }}
                                    </span>
                                </button>

                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@push('head')
<style>
    /* ── Contact field focus ring (magenta) ── */
    .contact-field:focus {
        outline: none;
        border-color: #c80078 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(200, 0, 120, 0.12);
    }

    /* ── Social icon hover (navy default → magenta on hover) ── */
    .contact-social-icon {
        color: rgba(255, 255, 255, 0.75);
    }

    .contact-social-icon:hover {
        background-color: #c80078 !important;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* ── GSAP entrance: info panel and form panel ── */
    .contact-info-panel,
    .contact-form-panel {
        opacity: 0;
        transform: translateY(20px);
    }

    /* ── Reduced motion: skip animations ── */
    @media (prefers-reduced-motion: reduce) {
        .contact-info-panel,
        .contact-form-panel {
            opacity: 1 !important;
            transform: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function initContactAnimations() {
        if (reduced) { return; }

        var infoPanel = document.querySelector('.contact-info-panel');
        var formPanel = document.querySelector('.contact-form-panel');

        if (!infoPanel || !formPanel) { return; }

        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') { return; }

        gsap.fromTo(infoPanel, {
            opacity: 0,
            y: 24,
        }, {
            opacity: 1,
            y: 0,
            duration: 0.75,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: infoPanel,
                start: 'top 88%',
                once: true,
            },
        });

        gsap.fromTo(formPanel, {
            opacity: 0,
            y: 24,
        }, {
            opacity: 1,
            y: 0,
            duration: 0.75,
            ease: 'power2.out',
            delay: 0.12,
            scrollTrigger: {
                trigger: formPanel,
                start: 'top 88%',
                once: true,
            },
        });
    }

    document.addEventListener('DOMContentLoaded', initContactAnimations);
    document.addEventListener('gale:navigated', initContactAnimations);
})();
</script>
@endpush

@endsection
