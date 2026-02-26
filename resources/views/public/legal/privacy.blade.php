@extends('layouts.public')

@section('title', __('privacy.title') . ' — ' . config('app.name'))
@section('meta_description', __('privacy.meta_desc'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(220px, 28vw, 320px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('privacy.hero_heading') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,40,80,0.82);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">

            <nav class="mb-4" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors focus-visible:outline-white">{{ __('nav.home') }}</a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('privacy.title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.8);"
                  data-animate="fade-up">
                {{ __('privacy.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('privacy.hero_heading') }}
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.7);"
               data-animate="fade-up">
                {{ __('privacy.hero_sub') }}
            </p>

        </div>
    </section>

    {{-- ================================================================
         PRIVACY CONTENT
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Intro --}}
            <p class="text-base leading-relaxed mb-12"
               style="color: #4a5568; border-left: 3px solid #c80078; padding-left: 1.25rem;">
                {{ __('privacy.intro') }}
            </p>

            {{-- Section 1 — Data Collected --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-6"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.data_heading') }}
                </h2>
                <p class="text-sm mb-5" style="color: #4a5568;">{{ __('privacy.data_intro') }}</p>
                <div class="space-y-4">
                    @foreach ([
                        ['title' => __('privacy.data_contact_title'),    'items' => __('privacy.data_contact_items')],
                        ['title' => __('privacy.data_donation_title'),   'items' => __('privacy.data_donation_items')],
                        ['title' => __('privacy.data_newsletter_title'), 'items' => __('privacy.data_newsletter_items')],
                        ['title' => __('privacy.data_cookies_title'),    'items' => __('privacy.data_cookies_items')],
                        ['title' => __('privacy.data_logs_title'),       'items' => __('privacy.data_logs_items')],
                    ] as $row)
                        <div class="bg-white rounded-xl overflow-hidden"
                             style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                            <div class="flex flex-col sm:flex-row">
                                <div class="px-6 py-4 sm:w-1/3 font-semibold text-sm shrink-0"
                                     style="color: #143c64; background-color: rgba(20,60,100,0.03); border-bottom: 1px solid rgba(20,60,100,0.07);">
                                    {{ $row['title'] }}
                                </div>
                                <div class="px-6 py-4 text-sm leading-relaxed" style="color: #4a5568;">
                                    {{ $row['items'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Section 2 — Purposes --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.purposes_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm mb-4" style="color: #4a5568;">{{ __('privacy.purposes_intro') }}</p>
                    <ul class="space-y-2">
                        @foreach (__('privacy.purposes_items') as $item)
                            <li class="flex items-start gap-3 text-sm" style="color: #4a5568;">
                                <span class="mt-1.5 shrink-0 w-1.5 h-1.5 rounded-full" style="background-color: #c80078;"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Section 3 — Data Sharing --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.sharing_heading') }}
                </h2>
                <p class="text-sm mb-5" style="color: #4a5568;">{{ __('privacy.sharing_intro') }}</p>
                <div class="space-y-4">

                    {{-- Flutterwave --}}
                    <div class="bg-white rounded-xl px-8 py-6"
                         style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h3 class="font-semibold text-sm mb-2" style="color: #143c64;">
                            {{ __('privacy.sharing_flutterwave_title') }}
                        </h3>
                        <p class="text-sm leading-relaxed mb-3" style="color: #4a5568;">
                            {{ __('privacy.sharing_flutterwave_text') }}
                        </p>
                        <a href="https://flutterwave.com/us/privacy-policy"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 text-xs font-medium hover:underline transition-colors"
                           style="color: #c80078;">
                            {{ __('privacy.sharing_flutterwave_link') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Legal obligations --}}
                    <div class="bg-white rounded-xl px-8 py-6"
                         style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h3 class="font-semibold text-sm mb-2" style="color: #143c64;">
                            {{ __('privacy.sharing_legal_title') }}
                        </h3>
                        <p class="text-sm leading-relaxed" style="color: #4a5568;">
                            {{ __('privacy.sharing_legal_text') }}
                        </p>
                    </div>

                    {{-- International transfers --}}
                    <div class="bg-white rounded-xl px-8 py-6"
                         style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h3 class="font-semibold text-sm mb-2" style="color: #143c64;">
                            {{ __('privacy.sharing_no_transfer_title') }}
                        </h3>
                        <p class="text-sm leading-relaxed" style="color: #4a5568;">
                            {{ __('privacy.sharing_no_transfer_text') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Section 4 — Retention --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.retention_heading') }}
                </h2>
                <div class="bg-white rounded-xl overflow-hidden"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm px-8 pt-6 pb-4" style="color: #4a5568;">{{ __('privacy.retention_intro') }}</p>
                    <ul class="divide-y text-sm" style="border-color: rgba(20,60,100,0.07);">
                        @foreach ([
                            __('privacy.retention_contact'),
                            __('privacy.retention_donations'),
                            __('privacy.retention_newsletter'),
                            __('privacy.retention_logs'),
                        ] as $item)
                            <li class="flex items-start gap-3 px-8 py-4" style="color: #4a5568;">
                                <span class="mt-1.5 shrink-0 w-1.5 h-1.5 rounded-full" style="background-color: #c8a03c;"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Section 5 — User Rights --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.rights_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm mb-5" style="color: #4a5568;">{{ __('privacy.rights_intro') }}</p>
                    <ul class="space-y-2 mb-6">
                        @foreach (__('privacy.rights_items') as $item)
                            <li class="flex items-start gap-3 text-sm" style="color: #4a5568;">
                                <span class="mt-1.5 shrink-0 w-1.5 h-1.5 rounded-full" style="background-color: #c80078;"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- Contact for rights --}}
                    <div class="pt-5" style="border-top: 1px solid rgba(20,60,100,0.07);">
                        <p class="text-sm mb-2" style="color: #4a5568;">{{ __('privacy.rights_contact') }}</p>
                        <a href="mailto:contact@breefondation.org"
                           class="inline-flex items-center gap-2 text-sm font-medium hover:underline transition-colors"
                           style="color: #c80078;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            contact@breefondation.org
                        </a>
                    </div>

                    {{-- PFPDT --}}
                    <div class="pt-5 mt-5" style="border-top: 1px solid rgba(20,60,100,0.07);">
                        <p class="text-sm mb-2" style="color: #4a5568;">{{ __('privacy.rights_pfpdt') }}</p>
                        <a href="https://www.edoeb.admin.ch"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sm font-medium hover:underline transition-colors"
                           style="color: #143c64;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ __('privacy.rights_pfpdt_link') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Section 6 — Cookies --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.cookies_heading') }}
                </h2>
                <div class="space-y-4">
                    <div class="bg-white rounded-xl px-8 py-6"
                         style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h3 class="font-semibold text-sm mb-2" style="color: #143c64;">
                            {{ __('privacy.cookies_session_title') }}
                        </h3>
                        <p class="text-sm leading-relaxed" style="color: #4a5568;">
                            {{ __('privacy.cookies_session_text') }}
                        </p>
                    </div>
                    <div class="bg-white rounded-xl px-8 py-6"
                         style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <p class="text-sm leading-relaxed" style="color: #4a5568;">
                            {{ __('privacy.cookies_tracking') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Section 7 — Updates --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('privacy.updates_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed" style="color: #4a5568;">
                        {{ __('privacy.updates_text') }}
                    </p>
                </div>
            </div>

            {{-- Last Updated --}}
            <p class="text-xs text-center" style="color: rgba(74,85,104,0.5);">
                {{ __('privacy.last_updated', ['date' => '1er mars 2026']) }}
            </p>

        </div>
    </section>

@endsection
