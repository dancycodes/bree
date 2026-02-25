@extends('layouts.public')

@section('title', __('partners.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('partners.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(320px, 45vw, 500px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('partners.page_title') }}"
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
                    <li style="color: #ffffff;">{{ __('partners.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('partners.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5vw, 3.5rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('partners.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-2xl"
               style="color: rgba(255,255,255,0.75); line-height: 1.7;"
               data-animate="fade-up">
                {{ __('partners.hero_subtitle') }}
            </p>

        </div>
    </section>

    {{-- ================================================================
         PARTNERS BY GROUP
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($partners->isEmpty())
                {{-- Empty state --}}
                <div class="py-24 text-center">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center"
                         style="background-color: #f8f5f0;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.25"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2" style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('partners.empty_heading') }}
                    </h2>
                    <p class="text-base" style="color: #64748b;">{{ __('partners.empty_sub') }}</p>
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
                        <div class="{{ !$loop->first ? 'mt-16 lg:mt-24' : '' }}">

                            {{-- Group header --}}
                            <div class="flex items-center gap-4 mb-10" data-animate="fade-up">
                                <div class="h-px flex-1" style="background-color: #e2e8f0;"></div>
                                <span class="text-xs font-bold tracking-widest uppercase px-4"
                                      style="color: #143c64;">
                                    {{ $groupLabel }}
                                </span>
                                <div class="h-px flex-1" style="background-color: #e2e8f0;"></div>
                            </div>

                            {{-- Partners grid --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($partners[$type] as $partner)
                                    <div class="group rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1"
                                         style="border: 1px solid #e2e8f0; background-color: #ffffff;"
                                         data-animate="fade-up">

                                        {{-- Logo or name badge --}}
                                        <div class="flex items-center gap-4 mb-4">
                                            @if ($partner->logo_path)
                                                <div class="w-16 h-16 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0"
                                                     style="background-color: #f8fafc;">
                                                    <img src="{{ asset($partner->logo_path) }}"
                                                         alt="{{ $partner->name }}"
                                                         class="w-full h-full object-contain transition-all duration-300"
                                                         style="filter: grayscale(100%);"
                                                         onmouseover="this.style.filter='grayscale(0%)'"
                                                         onmouseout="this.style.filter='grayscale(100%)'">
                                                </div>
                                            @else
                                                <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0"
                                                     style="background-color: #f0f4ff;">
                                                    <span class="text-lg font-bold"
                                                          style="color: #143c64;">
                                                        {{ mb_substr($partner->name, 0, 2) }}
                                                    </span>
                                                </div>
                                            @endif

                                            <div class="min-w-0">
                                                <h3 class="text-sm font-bold leading-tight"
                                                    style="color: #143c64; font-family: 'Playfair Display', serif;">
                                                    {{ $partner->name }}
                                                </h3>
                                                <span class="text-xs font-medium mt-1 inline-block"
                                                      style="color: #c8a03c;">
                                                    {{ $partner->typeLabel() }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        @if ($partner->description())
                                            <p class="text-sm leading-relaxed"
                                               style="color: #475569; line-height: 1.7;">
                                                {{ $partner->description() }}
                                            </p>
                                        @endif

                                        {{-- Website link --}}
                                        @if ($partner->website_url)
                                            <a href="{{ $partner->website_url }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1.5 mt-4 text-xs font-semibold transition-colors"
                                               style="color: #c80078;">
                                                {{ __('partners.visit_website') }}
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif

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
                <div class="rounded-3xl p-8 lg:p-10" style="background-color: #143c64;">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: rgba(200,160,60,0.2);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-3"
                        style="color: #ffffff; font-family: 'Playfair Display', serif;">
                        {{ __('partners.cta_partner_heading') }}
                    </h2>
                    <p class="text-sm mb-6" style="color: rgba(255,255,255,0.7); line-height: 1.7;">
                        {{ __('partners.cta_partner_sub') }}
                    </p>
                    <a href="#partenariat"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                       style="background-color: #c80078; color: #ffffff;">
                        {{ __('partners.cta_partner_btn') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                {{-- Become a volunteer --}}
                <div class="rounded-3xl p-8 lg:p-10" style="background-color: #ffffff; border: 2px solid #e2e8f0;">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: #fff0f8;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c80078;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('partners.cta_volunteer_heading') }}
                    </h2>
                    <p class="text-sm mb-6" style="color: #64748b; line-height: 1.7;">
                        {{ __('partners.cta_volunteer_sub') }}
                    </p>
                    <a href="{{ route('public.volunteers') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                       style="background-color: #c80078; color: #ffffff;">
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
                    orgType: '',
                    proposal: '',
                    heardAbout: '',
                    partnershipSubmitted: false
                }"
                x-sync>

                {{-- Success state --}}
                <div x-show="partnershipSubmitted"
                     class="text-center py-16" style="display: none;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"
                         style="background-color: #dcfce7;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             style="color: #16a34a;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('partners.form_success_heading') }}
                    </h2>
                    <p class="text-base mb-8" style="color: #64748b;">
                        {{ __('partners.form_success_sub') }}
                    </p>
                    <button @click="partnershipSubmitted = false"
                            class="text-sm font-semibold transition-opacity hover:opacity-80"
                            style="color: #c80078;">
                        {{ __('partners.form_success_reset') }}
                    </button>
                </div>

                {{-- Form --}}
                <div x-show="!partnershipSubmitted">
                    <div class="text-center mb-10">
                        <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                              style="color: #c8a03c;"
                              data-animate="fade-up">
                            {{ __('partners.hero_label') }}
                        </span>
                        <h2 class="text-2xl font-bold mb-3"
                            style="color: #143c64; font-family: 'Playfair Display', serif;"
                            data-animate="fade-up">
                            {{ __('partners.form_heading') }}
                        </h2>
                        <p class="text-base max-w-xl mx-auto" style="color: #64748b;" data-animate="fade-up">
                            {{ __('partners.form_subtitle') }}
                        </p>
                    </div>

                    <div class="rounded-3xl shadow-sm p-8 lg:p-10 space-y-6"
                         style="background-color: #ffffff; border: 1px solid #e2e8f0;">

                        {{-- Organization & Contact --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    {{ __('partners.field_org_name') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="orgName" x-name="orgName" type="text"
                                       placeholder="Nom de votre organisation"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="orgName" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    {{ __('partners.field_contact_name') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="contactName" x-name="contactName" type="text"
                                       placeholder="Votre nom et prénom"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="contactName" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                        </div>

                        {{-- Email & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    {{ __('partners.field_email') }} <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="email" x-name="email" type="email"
                                       placeholder="contact@organisation.org"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="email" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    {{ __('partners.field_phone') }}
                                </label>
                                <input x-model="phone" x-name="phone" type="tel"
                                       placeholder="+237 6XX XXX XXX"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                            </div>
                        </div>

                        {{-- Organization type --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                {{ __('partners.field_org_type') }} <span style="color: #c80078;">*</span>
                            </label>
                            <select x-model="orgType" x-name="orgType"
                                    class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none appearance-none"
                                    style="border-color: #e2e8f0; color: #1e293b; background-color: #ffffff;">
                                <option value="">— Sélectionner un type —</option>
                                <option value="ngo">{{ __('partners.org_type_ngo') }}</option>
                                <option value="government">{{ __('partners.org_type_government') }}</option>
                                <option value="private">{{ __('partners.org_type_private') }}</option>
                                <option value="other">{{ __('partners.org_type_other') }}</option>
                            </select>
                            <p x-message="orgType" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                        </div>

                        {{-- Partnership proposal --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                {{ __('partners.field_proposal') }} <span style="color: #c80078;">*</span>
                            </label>
                            <textarea x-model="proposal" x-name="proposal" rows="6"
                                      placeholder="{{ __('partners.proposal_hint') }}"
                                      class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                            <p x-message="proposal" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                        </div>

                        {{-- How heard --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                {{ __('partners.field_heard') }}
                            </label>
                            <input x-model="heardAbout" x-name="heardAbout" type="text"
                                   placeholder="Réseaux sociaux, recommandation, presse…"
                                   class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>

                        {{-- Honeypot --}}
                        @honeypot

                        {{-- Submit --}}
                        <button
                            @click="$action('{{ route('public.partners.store') }}')"
                            :disabled="$fetching()"
                            class="w-full py-4 rounded-2xl text-sm font-bold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #143c64;">
                            <span x-show="!$fetching()">{{ __('partners.form_submit') }}</span>
                            <span x-show="$fetching()">{{ __('partners.form_submitting') }}</span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
