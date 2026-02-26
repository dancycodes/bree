@extends('layouts.public')

@section('title', __('partners.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('partners.meta_description'))

@push('head')
<style>
    .partner-logo-img {
        filter: grayscale(100%);
        transition: filter 300ms ease;
    }
    .partner-logo-wrap:hover .partner-logo-img,
    .partner-logo-wrap:focus-within .partner-logo-img {
        filter: grayscale(0%);
    }
</style>
@endpush

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(340px, 48vw, 520px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('partners.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">

        {{-- Solid dark overlay — NO gradient per BR-001 --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.76);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('partners.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('partners.hero_label') }}
            </span>

            <h1 class="bree-hero-h1"
                style="color: #ffffff; max-width: 680px;"
                data-animate="fade-up">
                {{ __('partners.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-xl"
               style="color: rgba(255,255,255,0.75); line-height: 1.7;"
               data-animate="fade-up">
                {{ __('partners.hero_subtitle') }}
            </p>

        </div>
    </section>

    {{-- ================================================================
         PARTNERS BY GROUP
         Logo grid: 6-col desktop / 4-col tablet / 3-col mobile
         Logos: grayscale default, full-color on hover (CSS transition)
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($partners->isEmpty())
                {{-- All partner types empty — placeholder message --}}
                <div class="py-28 text-center">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-6 flex items-center justify-center"
                         style="background-color: #f8f5f0;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.25"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('partners.empty_heading') }}
                    </h2>
                    <p class="text-base" style="color: #64748b;">
                        {{ __('partners.empty_sub') }}
                    </p>
                </div>

            @else
                @php
                    $groups = [
                        'institutional' => __('partners.group_institutional'),
                        'financial'     => __('partners.group_financial'),
                        'technical'     => __('partners.group_technical'),
                    ];
                @endphp

                @foreach ($groups as $type => $groupLabel)
                    @if ($partners->has($type))
                        <div class="{{ !$loop->first ? 'mt-20 lg:mt-28' : '' }}">

                            {{-- Group heading with gold accent rule --}}
                            <div class="mb-10" data-animate="fade-up">
                                <div class="flex items-center gap-4">
                                    <div class="h-px flex-1" style="background-color: #e2e8f0;"></div>
                                    <h2 class="text-xs font-bold tracking-widest uppercase px-2 whitespace-nowrap"
                                        style="color: #143c64;">
                                        {{ $groupLabel }}
                                    </h2>
                                    <div class="h-px flex-1" style="background-color: #e2e8f0;"></div>
                                </div>
                                <div class="mt-3 flex justify-center">
                                    <div class="h-0.5 w-12" style="background-color: #c8a03c;"></div>
                                </div>
                            </div>

                            {{-- Logo grid: 6-col desktop / 4-col tablet / 3-col mobile --}}
                            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-6"
                                 data-stagger="0.06">
                                @foreach ($partners[$type] as $partner)
                                    <div data-animate="fade-up">
                                        @if ($partner->website_url)
                                            <a href="{{ $partner->website_url }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               title="{{ $partner->name }}"
                                               class="partner-logo-wrap flex items-center justify-center rounded-xl p-3 transition-shadow duration-300 focus-visible:outline-2 focus-visible:outline-offset-2"
                                               style="background-color: #f8f5f0;
                                                      height: 100px;
                                                      border: 1px solid #e2e8f0;
                                                      outline-color: #c80078;">
                                                @if ($partner->logo_path)
                                                    <img src="{{ asset($partner->logo_path) }}"
                                                         alt="{{ $partner->name }}"
                                                         class="partner-logo-img w-full object-contain"
                                                         style="height: 80px; max-width: 100%;">
                                                @else
                                                    <span class="text-sm font-bold text-center leading-tight px-1"
                                                          style="color: #143c64; font-family: 'Playfair Display', serif;">
                                                        {{ mb_substr($partner->name, 0, 3) }}
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            <div class="partner-logo-wrap flex items-center justify-center rounded-xl p-3"
                                                 title="{{ $partner->name }}"
                                                 style="background-color: #f8f5f0;
                                                        height: 100px;
                                                        border: 1px solid #e2e8f0;">
                                                @if ($partner->logo_path)
                                                    <img src="{{ asset($partner->logo_path) }}"
                                                         alt="{{ $partner->name }}"
                                                         class="partner-logo-img w-full object-contain"
                                                         style="height: 80px; max-width: 100%;">
                                                @else
                                                    <span class="text-sm font-bold text-center leading-tight px-1"
                                                          style="color: #143c64; font-family: 'Playfair Display', serif;">
                                                        {{ mb_substr($partner->name, 0, 3) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Partner name below logo --}}
                                        <p class="mt-2 text-center text-xs font-medium leading-tight px-1"
                                           style="color: #64748b;">
                                            {{ $partner->name }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                @endforeach

            @endif

        </div>
    </section>

    {{-- ================================================================
         APPLICATION CTAs
         ================================================================ --}}
    <section class="py-16 lg:py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Become a partner --}}
                <div class="rounded-3xl p-8 lg:p-10" style="background-color: #143c64;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: rgba(200,160,60,0.18);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                        </svg>
                    </div>
                    <h2 class="bree-subsection-h3 mb-3"
                        style="color: #ffffff;">
                        {{ __('partners.cta_partner_heading') }}
                    </h2>
                    <p class="text-sm mb-6" style="color: rgba(255,255,255,0.7); line-height: 1.7;">
                        {{ __('partners.cta_partner_sub') }}
                    </p>
                    <a href="#partenariat"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                       style="background-color: #c80078; color: #ffffff;">
                        {{ __('partners.cta_partner_btn') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                {{-- Become a volunteer --}}
                <div class="rounded-3xl p-8 lg:p-10"
                     style="background-color: #ffffff; border: 2px solid #e2e8f0;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: #fff0f8;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c80078;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <h2 class="bree-subsection-h3 mb-3"
                        style="color: #143c64;">
                        {{ __('partners.cta_volunteer_heading') }}
                    </h2>
                    <p class="text-sm mb-6" style="color: #64748b; line-height: 1.7;">
                        {{ __('partners.cta_volunteer_sub') }}
                    </p>
                    <a href="{{ route('public.volunteers') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-2"
                       style="background-color: #c80078; color: #ffffff; outline-color: #c80078;">
                        {{ __('partners.cta_volunteer_btn') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================
         PARTNERSHIP APPLICATION FORM
         ================================================================ --}}
    <section id="partenariat" class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                x-data="{
                    orgName: '',
                    contactName: '',
                    email: '',
                    phone: '',
                    partnershipType: '',
                    motivation: '',
                    partnershipSubmitted: false
                }"
                x-sync="['orgName','contactName','email','phone','partnershipType','motivation','partnershipSubmitted']">

                {{-- Success state --}}
                <div x-show="partnershipSubmitted"
                     x-transition:enter="transition duration-400"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="text-center py-16"
                     style="display: none;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"
                         style="background-color: #dcfce7;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             style="color: #16a34a;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="bree-subsection-h3 mb-3"
                        style="color: #143c64;">
                        {{ __('partners.form_success_heading') }}
                    </h2>
                    <p class="text-base mb-8" style="color: #64748b; max-width: 420px; margin-left: auto; margin-right: auto;">
                        {{ __('partners.form_success_sub') }}
                    </p>
                    <button @click="partnershipSubmitted = false"
                            class="text-sm font-semibold transition-opacity hover:opacity-80 focus-visible:outline-2 focus-visible:outline-offset-2"
                            style="color: #c80078; outline-color: #c80078;">
                        {{ __('partners.form_success_reset') }}
                    </button>
                </div>

                {{-- Form --}}
                <div x-show="!partnershipSubmitted">

                    {{-- Form header --}}
                    <div class="text-center mb-10">
                        <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                              style="color: #c8a03c;"
                              data-animate="fade-up">
                            {{ __('partners.hero_label') }}
                        </span>
                        <h2 class="bree-subsection-h3 mb-4"
                            style="color: #143c64;"
                            data-animate="fade-up">
                            {{ __('partners.form_heading') }}
                        </h2>
                        <p class="text-base max-w-xl mx-auto" style="color: #64748b; line-height: 1.7;"
                           data-animate="fade-up">
                            {{ __('partners.form_subtitle') }}
                        </p>
                        <p class="mt-2 text-xs" style="color: #94a3b8;" data-animate="fade-up">
                            {{ __('partners.form_required') }}
                        </p>
                    </div>

                    <div class="rounded-3xl p-8 lg:p-10 space-y-6"
                         style="background-color: #f8f5f0; border: 1px solid #e2e8f0;"
                         data-animate="fade-up">

                        {{-- Organization & Contact --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="field-org-name" class="bree-form-label">
                                    {{ __('partners.field_org_name') }}
                                    <span aria-hidden="true" style="color: #c80078;">*</span>
                                </label>
                                <input id="field-org-name"
                                       x-model="orgName"
                                       x-name="orgName"
                                       type="text"
                                       autocomplete="organization"
                                       class="bree-form-field">
                                <p x-message="orgName" class="bree-form-error"></p>
                            </div>
                            <div>
                                <label for="field-contact-name" class="bree-form-label">
                                    {{ __('partners.field_contact_name') }}
                                    <span aria-hidden="true" style="color: #c80078;">*</span>
                                </label>
                                <input id="field-contact-name"
                                       x-model="contactName"
                                       x-name="contactName"
                                       type="text"
                                       autocomplete="name"
                                       class="bree-form-field">
                                <p x-message="contactName" class="bree-form-error"></p>
                            </div>
                        </div>

                        {{-- Email & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="field-email" class="bree-form-label">
                                    {{ __('partners.field_email') }}
                                    <span aria-hidden="true" style="color: #c80078;">*</span>
                                </label>
                                <input id="field-email"
                                       x-model="email"
                                       x-name="email"
                                       type="email"
                                       autocomplete="email"
                                       class="bree-form-field">
                                <p x-message="email" class="bree-form-error"></p>
                            </div>
                            <div>
                                <label for="field-phone" class="bree-form-label">
                                    {{ __('partners.field_phone') }}
                                </label>
                                <input id="field-phone"
                                       x-model="phone"
                                       x-name="phone"
                                       type="tel"
                                       autocomplete="tel"
                                       class="bree-form-field">
                            </div>
                        </div>

                        {{-- Partnership type --}}
                        <div>
                            <label for="field-partnership-type" class="bree-form-label">
                                {{ __('partners.field_partnership_type') }}
                                <span aria-hidden="true" style="color: #c80078;">*</span>
                            </label>
                            <div class="relative">
                                <select id="field-partnership-type"
                                        x-model="partnershipType"
                                        x-name="partnershipType"
                                        class="bree-form-field select-bree-field">
                                    <option value="">— {{ __('partners.partnership_type_placeholder') }} —</option>
                                    <option value="financial">{{ __('partners.partnership_type_financial') }}</option>
                                    <option value="technical">{{ __('partners.partnership_type_technical') }}</option>
                                    <option value="institutional">{{ __('partners.partnership_type_institutional') }}</option>
                                    <option value="other">{{ __('partners.partnership_type_other') }}</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                         style="color: #94a3b8;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            <p x-message="partnershipType" class="bree-form-error"></p>
                        </div>

                        {{-- Motivation / proposal --}}
                        <div>
                            <label for="field-motivation" class="bree-form-label">
                                {{ __('partners.field_motivation') }}
                                <span aria-hidden="true" style="color: #c80078;">*</span>
                            </label>
                            <textarea id="field-motivation"
                                      x-model="motivation"
                                      x-name="motivation"
                                      rows="6"
                                      placeholder="{{ __('partners.motivation_hint') }}"
                                      class="bree-form-field"
                                      style="min-height: 160px;"></textarea>
                            <p x-message="motivation" class="bree-form-error"></p>
                        </div>

                        {{-- Honeypot --}}
                        @honeypot

                        {{-- Submit --}}
                        <button
                            @click="$action('{{ route('public.partners.store') }}')"
                            :disabled="$fetching()"
                            class="btn-primary w-full rounded-xl"
                            style="height: 48px;"
                            :class="$fetching() ? 'opacity-65 cursor-not-allowed' : ''">
                            <span x-show="!$fetching()">{{ __('partners.form_submit') }}</span>
                            <span x-show="$fetching()" class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                {{ __('partners.form_submitting') }}
                            </span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
