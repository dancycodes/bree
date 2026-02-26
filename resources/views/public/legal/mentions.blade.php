@extends('layouts.public')

@section('title', __('legal.mentions_title') . ' — ' . config('app.name'))
@section('meta_description', __('legal.mentions_meta_desc'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(220px, 28vw, 320px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('legal.mentions_hero_heading') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,40,80,0.82);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">

            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.7);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           x-navigate
                           class="hover:text-white transition-colors">{{ __('nav.home') }}</a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">{{ __('legal.mentions_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.8);"
                  data-animate="fade-up">
                {{ __('legal.mentions_hero_label') }}
            </span>

            <h1 class="font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 2.75rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('legal.mentions_hero_heading') }}
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.7);"
               data-animate="fade-up">
                {{ __('legal.mentions_hero_sub') }}
            </p>

        </div>
    </section>

    {{-- ================================================================
         LEGAL CONTENT
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Intro --}}
            <p class="text-base leading-relaxed mb-12"
               style="color: #4a5568; border-left: 3px solid #c80078; padding-left: 1.25rem;">
                {{ __('legal.mentions_intro') }}
            </p>

            {{-- Section 1 — Publisher --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-6"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.publisher_heading') }}
                </h2>
                <div class="bg-white rounded-xl overflow-hidden"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(20,60,100,0.07);">
                                <td class="px-6 py-4 font-semibold w-1/3" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.publisher_name_label') }}
                                </td>
                                <td class="px-6 py-4" style="color: #4a5568;">
                                    {{ __('legal.publisher_name_value') }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(20,60,100,0.07);">
                                <td class="px-6 py-4 font-semibold" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.publisher_address_label') }}
                                </td>
                                <td class="px-6 py-4" style="color: #4a5568;">
                                    {{ __('legal.publisher_address_value') }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(20,60,100,0.07);">
                                <td class="px-6 py-4 font-semibold" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.publisher_legal_label') }}
                                </td>
                                <td class="px-6 py-4" style="color: #4a5568;">
                                    {{ __('legal.publisher_legal_value') }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(20,60,100,0.07);">
                                <td class="px-6 py-4 font-semibold" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.publisher_email_label') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="mailto:contact@breefondation.org"
                                       class="font-medium transition-colors hover:underline"
                                       style="color: #c80078;">
                                        contact@breefondation.org
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-semibold" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.publisher_phone_label') }}
                                </td>
                                <td class="px-6 py-4" style="color: #4a5568;">
                                    <a href="tel:+41223456989"
                                       class="hover:underline transition-colors"
                                       style="color: #4a5568;">
                                        {{ __('legal.publisher_phone_value') }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Section 2 — Hosting --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-6"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.hosting_heading') }}
                </h2>
                <div class="bg-white rounded-xl overflow-hidden"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(20,60,100,0.07);">
                                <td class="px-6 py-4 font-semibold w-1/3" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.hosting_name_label') }}
                                </td>
                                <td class="px-6 py-4 italic" style="color: #9ca3af;">
                                    {{ __('legal.hosting_name_value') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-semibold" style="color: #143c64; background-color: rgba(20,60,100,0.03);">
                                    {{ __('legal.hosting_address_label') }}
                                </td>
                                <td class="px-6 py-4 italic" style="color: #9ca3af;">
                                    {{ __('legal.hosting_address_value') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Section 3 — Intellectual Property --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.ip_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed" style="color: #4a5568;">
                        {{ __('legal.ip_text') }}
                    </p>
                </div>
            </div>

            {{-- Section 4 — Liability --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.liability_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed" style="color: #4a5568;">
                        {{ __('legal.liability_text') }}
                    </p>
                </div>
            </div>

            {{-- Section 5 — Hyperlinks --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.links_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed" style="color: #4a5568;">
                        {{ __('legal.links_text') }}
                    </p>
                </div>
            </div>

            {{-- Section 6 — Applicable Law --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.law_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed" style="color: #4a5568;">
                        {{ __('legal.law_text') }}
                    </p>
                </div>
            </div>

            {{-- Section 7 — Contact --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-5"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    <span class="inline-block w-8 h-0.5 mr-3 align-middle" style="background-color: #c80078;"></span>
                    {{ __('legal.contact_heading') }}
                </h2>
                <div class="bg-white rounded-xl px-8 py-6"
                     style="border: 1px solid rgba(20,60,100,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <p class="text-sm leading-relaxed mb-5" style="color: #4a5568;">
                        {{ __('legal.contact_text') }}
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span style="color: #4a5568;">
                                {{ __('legal.contact_by_email') }}
                                <a href="mailto:contact@breefondation.org"
                                   class="font-medium hover:underline transition-colors"
                                   style="color: #c80078;">
                                    contact@breefondation.org
                                </a>
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span style="color: #4a5568;">
                                {{ __('legal.contact_by_phone') }}
                                <a href="tel:+41223456989"
                                   class="hover:underline transition-colors"
                                   style="color: #4a5568;">
                                    +41 22 345 69 89
                                </a>
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span style="color: #4a5568;">
                                {{ __('legal.contact_by_post') }}
                                Fondation BREE, Rue de Lausanne 42, 1201 Genève, Suisse
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Last Updated --}}
            <p class="text-xs text-center" style="color: rgba(74,85,104,0.5);">
                {{ __('legal.last_updated', ['date' => '26 février 2026']) }}
            </p>

        </div>
    </section>

@endsection
