@extends('layouts.public')

@section('title', __('donation.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('donation.meta_description'))

@push('head')
<style>
    @keyframes donFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes donFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes impactSlide {
        from { opacity: 0; transform: translateX(-12px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .don-hero-content > * { animation: donFadeUp 0.65s ease both; }
    .don-hero-content > *:nth-child(1) { animation-delay: 0.05s; }
    .don-hero-content > *:nth-child(2) { animation-delay: 0.15s; }
    .don-hero-content > *:nth-child(3) { animation-delay: 0.25s; }
    .don-hero-content > *:nth-child(4) { animation-delay: 0.35s; }
    .don-hero-content > *:nth-child(5) { animation-delay: 0.42s; }
    .don-impact-card { animation: donFadeUp 0.55s ease both; }
    .don-impact-card:nth-child(1) { animation-delay: 0.05s; }
    .don-impact-card:nth-child(2) { animation-delay: 0.12s; }
    .don-impact-card:nth-child(3) { animation-delay: 0.19s; }
    .don-impact-card:nth-child(4) { animation-delay: 0.26s; }
    .don-impact-card:nth-child(5) { animation-delay: 0.33s; }
    .don-tab-panel { animation: donFadeIn 0.3s ease both; }
    .don-impact-stmt { animation: impactSlide 0.35s ease both; }
    .don-amount-sel-ring:focus { outline: 2px solid #c80078; outline-offset: 2px; }
</style>
@endpush

@section('content')

<div x-data="{
    activeTab: 'direct',
    programme: '{{ $programme }}',
    donationType: '',
    frequency: 'monthly',
    selectorVisible: false,
    selectedAmount: 0,
    customAmount: '',
    showCustom: false,
    amountConfirmed: false,
    confirmedAmount: 0,
    confirmedType: '',
    confirmedFrequency: 'monthly',
    donorName: '',
    donorEmail: '',
    donorPhone: '',
    donorCountry: 'CM',
    cardStep: false,
    txRef: '',
    cardNumber: '',
    cardExpiry: '',
    cardCvv: '',
    authMode: '',
    pinValue: '',
    otpValue: '',
    flwRef: '',
    redirectUrl: '',
    selectPreset(amount) {
        this.selectedAmount = amount;
        this.showCustom = false;
        this.customAmount = '';
    },
    selectCustom() {
        this.selectedAmount = 0;
        this.showCustom = true;
    },
    switchTab(tab) {
        this.activeTab = tab;
        this.selectorVisible = false;
        this.amountConfirmed = false;
        this.cardStep = false;
        this.authMode = '';
        this.selectedAmount = 0;
        this.customAmount = '';
        this.showCustom = false;
        if (tab === 'direct' || tab === 'recurring') {
            this.donationType = tab;
        }
    },
    formatCardNumber() {
        let v = this.cardNumber.replace(/\D/g, '').substring(0, 16);
        this.cardNumber = v.replace(/(\d{4})(?=\d)/g, '$1 ');
    },
    formatExpiry() {
        let v = this.cardExpiry.replace(/\D/g, '').substring(0, 4);
        if (v.length >= 3) { v = v.substring(0, 2) + '/' + v.substring(2); }
        this.cardExpiry = v;
    }
}">

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(340px, 48vw, 520px);">

        <img src="{{ asset('images/sections/donate.jpg') }}"
             alt="{{ __('donation.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(200,0,120,0.82);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 don-hero-content">

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
                    <li style="color: #ffffff;" aria-current="page">{{ __('donation.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.85);"
                  data-animate="fade-up">
                {{ __('donation.hero_label') }}
            </span>

            <h1 class="bree-hero-h1"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('donation.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-2xl"
               style="color: rgba(255,255,255,0.85); line-height: 1.7;">
                {{ __('donation.hero_sub') }}
            </p>

            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: rgba(255,255,255,0.5);"></div>

        </div>
    </section>

    {{-- ================================================================
         IMPACT EXAMPLES
         ================================================================ --}}
    @if ($impactExamples->isNotEmpty())
    <section class="py-12 lg:py-16" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-10" data-animate="fade-up">
                <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: #c8a03c;">
                    {{ __('donation.impact_heading') }}
                </p>
                <p class="text-sm" style="color: #64748b;">{{ __('donation.impact_sub') }}</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach ($impactExamples as $example)
                    <div class="don-impact-card text-center p-4 rounded-2xl"
                         style="background-color: #f8f5f0; border: 1px solid #e8ddf0;">

                        {{-- Icon --}}
                        <div class="w-10 h-10 rounded-xl mx-auto mb-3 flex items-center justify-center"
                             style="background-color: #fff0f8;">
                            @if ($example->icon === 'book')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            @elseif ($example->icon === 'shield')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            @elseif ($example->icon === 'leaf')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color: #c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="text-base font-bold mb-1" style="color: #c80078; font-family: 'Playfair Display', serif;">
                            {{ number_format($example->amount) }} <span class="text-xs">FCFA</span>
                        </div>
                        <p class="text-xs leading-relaxed" style="color: #64748b; line-height: 1.6;">
                            {{ $example->description() }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    @endif

    {{-- ================================================================
         DONATION TABS
         ================================================================ --}}
    <section id="donation-types" class="py-12 lg:py-20" style="background-color: #f8f5f0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-8">
                <h2 class="text-2xl lg:text-3xl font-bold"
                    style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.types_heading') }}
                </h2>
                @if ($programme !== 'general')
                    <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold"
                         style="background-color: #fff0f8; color: #c80078; border: 1px solid #fce7f3;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('donation.programme_label') }} :
                        <strong>{{ __('donation.programme_'.str_replace('-', '_', $programme)) }}</strong>
                    </div>
                @endif
            </div>

            {{-- Tab bar --}}
            <div class="flex overflow-x-auto rounded-2xl mb-6"
                 style="background-color: #ffffff; border: 2px solid #e8ddf0;">
                <button type="button"
                        @click="switchTab('direct')"
                        :style="activeTab === 'direct'
                            ? 'background-color:#c80078; color:#ffffff;'
                            : 'background-color:transparent; color:#143c64;'"
                        class="flex-1 min-w-0 flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap focus:outline-none rounded-l-2xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                    </svg>
                    <span>{{ __('donation.tab_direct') }}</span>
                </button>
                <div style="width:2px; flex-shrink:0; background-color:#e8ddf0;"></div>
                <button type="button"
                        @click="switchTab('recurring')"
                        :style="activeTab === 'recurring'
                            ? 'background-color:#143c64; color:#ffffff;'
                            : 'background-color:transparent; color:#143c64;'"
                        class="flex-1 min-w-0 flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap focus:outline-none">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    <span>{{ __('donation.tab_recurring') }}</span>
                </button>
                <div style="width:2px; flex-shrink:0; background-color:#e8ddf0;"></div>
                <button type="button"
                        @click="switchTab('pledge')"
                        :style="activeTab === 'pledge'
                            ? 'background-color:#c8a03c; color:#143c64;'
                            : 'background-color:transparent; color:#143c64;'"
                        class="flex-1 min-w-0 flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap focus:outline-none rounded-r-2xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span>{{ __('donation.tab_pledge') }}</span>
                </button>
            </div>

            {{-- ======================================================
                 TAB PANEL: DON DIRECT
                 ====================================================== --}}
            <div x-show="activeTab === 'direct'" class="don-tab-panel"
                 style="background-color:#ffffff; border:2px solid #e8ddf0; border-radius:1.5rem; overflow:hidden;">

                {{-- Panel header --}}
                <div style="padding:2rem 2rem 1.5rem; border-bottom:2px solid #f8f5f0;">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                             style="background-color:#fff0f8;">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:#c80078;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 text-xs font-bold tracking-widest uppercase mb-2 px-3 py-1 rounded-full"
                                 style="background-color:#fff0f8; color:#c80078;">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                {{ __('donation.amount_recommended') }}
                            </div>
                            <h3 class="text-xl font-bold" style="color:#143c64; font-family:'Playfair Display',serif;">
                                {{ __('donation.type_direct_title') }}
                            </h3>
                            <p class="mt-1 text-sm" style="color:#64748b;">{{ __('donation.direct_tab_sub') }}</p>
                        </div>
                    </div>
                </div>

                <div style="padding:1.5rem 2rem;">

                    {{-- Initial CTA (before amount selected) --}}
                    <div x-show="!selectorVisible && !amountConfirmed && !cardStep">
                        <p class="text-sm mb-5" style="color:#64748b;">{{ __('donation.type_direct_sub') }}</p>
                        <button type="button"
                                @click="donationType = 'direct'; $action('{{ route('public.donate.selectAmount') }}', { include: ['donationType'] })"
                                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-sm font-bold cursor-pointer"
                                style="background-color:#c80078; color:#ffffff;">
                            <span x-show="!(donationType === 'direct' && $fetching())">{{ __('donation.type_direct_btn') }}</span>
                            <span x-show="donationType === 'direct' && $fetching()">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                 x-show="!(donationType === 'direct' && $fetching())">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Amount selector (Gale fragment injects here) --}}
                    <div x-show="selectorVisible && !amountConfirmed && !cardStep" style="display:none;">
                        @fragment('amount-selector')
                        <div id="amount-selector">
                            @isset($amountSelectorType)
                            <div style="animation:donFadeIn 0.35s ease both;">
                                {{-- Frequency toggle (recurring only) --}}
                                @if ($amountSelectorType === 'recurring')
                                <div class="mb-5 p-4 rounded-xl" style="background-color:#f0f4ff; border:1px solid #dbeafe;">
                                    <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color:#143c64;">
                                        {{ __('donation.recurring_frequency_label') }}
                                    </p>
                                    <div class="inline-flex rounded-xl overflow-hidden" style="border:2px solid #143c64;">
                                        <button type="button" @click="frequency = 'monthly'"
                                                :style="frequency === 'monthly' ? 'background-color:#143c64;color:#ffffff;' : 'background-color:#ffffff;color:#143c64;'"
                                                class="px-5 py-2 text-sm font-bold transition-all cursor-pointer">
                                            {{ __('donation.recurring_monthly') }}
                                            <span class="text-xs font-normal ml-1 opacity-70">{{ __('donation.recurring_min_note_monthly') }}</span>
                                        </button>
                                        <button type="button" @click="frequency = 'yearly'"
                                                :style="frequency === 'yearly' ? 'background-color:#143c64;color:#ffffff;' : 'background-color:#ffffff;color:#143c64;'"
                                                class="px-5 py-2 text-sm font-bold transition-all cursor-pointer">
                                            {{ __('donation.recurring_yearly') }}
                                            <span class="text-xs font-normal ml-1 opacity-70">{{ __('donation.recurring_min_note_yearly') }}</span>
                                        </button>
                                    </div>
                                </div>
                                @endif

                                {{-- Header --}}
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-xs font-bold tracking-widest uppercase mb-0.5" style="color:#c8a03c;">
                                            {{ $amountSelectorType === 'recurring' ? __('donation.amount_type_label_recurring') : __('donation.amount_type_label_direct') }}
                                        </p>
                                        <h4 class="text-lg font-bold" style="color:#143c64; font-family:'Playfair Display',serif;">{{ __('donation.amount_heading') }}</h4>
                                        <p class="text-xs mt-0.5" style="color:#94a3b8;">{{ __('donation.amount_sub') }}</p>
                                    </div>
                                    <button type="button" @click="selectorVisible = false; donationType = ''"
                                            class="shrink-0 ml-4 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 hover:bg-pink-50"
                                            style="color:#c80078;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        {{ __('donation.amount_change_type') }}
                                    </button>
                                </div>

                                {{-- Preset amount buttons --}}
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2.5 mb-3">
                                    @foreach ($impactExamples as $example)
                                    <button type="button"
                                            @click="selectPreset({{ $example->amount }})"
                                            :style="selectedAmount === {{ $example->amount }} && !showCustom
                                                ? 'background-color:#c80078; color:#ffffff; border-color:#c80078; box-shadow:0 0 0 3px rgba(200,0,120,0.25);'
                                                : 'background-color:#ffffff; color:#143c64; border-color:#e2e8f0;'"
                                            class="p-3 rounded-xl border-2 text-center transition-all duration-200 cursor-pointer hover:border-pink-300 focus:outline-none">
                                        <div class="text-base font-bold" style="font-family:'Playfair Display',serif;">
                                            {{ number_format($example->amount) }}
                                        </div>
                                        <div class="text-xs mt-0.5 font-medium"
                                             :style="selectedAmount === {{ $example->amount }} && !showCustom ? 'opacity:0.8' : 'color:#94a3b8'">
                                            FCFA
                                        </div>
                                    </button>
                                    @endforeach
                                    <button type="button" @click="selectCustom()"
                                            :style="showCustom
                                                ? 'background-color:#c80078; color:#ffffff; border-color:#c80078;'
                                                : 'background-color:#ffffff; color:#143c64; border-color:#e2e8f0;'"
                                            class="p-3 rounded-xl border-2 text-center transition-all duration-200 cursor-pointer hover:border-pink-300 focus:outline-none">
                                        <div class="text-base font-bold">✏</div>
                                        <div class="text-xs mt-0.5"
                                             :style="showCustom ? 'opacity:0.85' : 'color:#64748b'">
                                            {{ __('donation.amount_custom_label') }}
                                        </div>
                                    </button>
                                </div>

                                {{-- Impact statements --}}
                                @foreach ($impactExamples as $example)
                                <div x-show="selectedAmount === {{ $example->amount }} && !showCustom"
                                     style="display:none;"
                                     class="don-impact-stmt mb-3 px-4 py-3 rounded-xl text-sm flex items-start gap-3"
                                     style="background-color:rgba(200,0,120,0.05); border:1px solid rgba(200,0,120,0.12);">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#c80078;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                    </svg>
                                    <span style="color:#7c1048;">
                                        <strong>{{ number_format($example->amount) }} FCFA</strong> = {{ $example->description() }}
                                    </span>
                                </div>
                                @endforeach

                                {{-- Custom amount input --}}
                                <div x-show="showCustom" style="display:none;" class="mb-3">
                                    <label class="block text-xs font-semibold mb-1.5" style="color:#143c64;">
                                        {{ __('donation.amount_custom_label') }} (FCFA)
                                    </label>
                                    <div class="relative max-w-xs">
                                        <input type="text"
                                               x-model="customAmount"
                                               @input="customAmount = $el.value.replace(/[^0-9,\.]/g, '')"
                                               placeholder="{{ __('donation.amount_custom_placeholder') }}"
                                               class="w-full px-4 py-3 pr-16 rounded-xl border-2 text-xl font-bold transition-colors focus:outline-none"
                                               style="border-color:#e2e8f0; color:#143c64;"
                                               @focus="$el.style.borderColor='#c80078'"
                                               @blur="$el.style.borderColor='#e2e8f0'">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:#94a3b8;">FCFA</span>
                                    </div>
                                    <p class="text-xs mt-1" style="color:#94a3b8;">{{ __('donation.amount_custom_hint') }}</p>
                                </div>

                                <p x-message="amount" class="text-sm mb-3 font-medium" style="color:#dc2626;"></p>

                                {{-- Continue button --}}
                                <div class="flex items-center justify-end pt-4" style="border-top:1px solid #f0e8f0;">
                                    <button type="button"
                                            @click="$action('{{ route('public.donate.validateAmount') }}', { include: ['donationType', 'frequency', 'selectedAmount', 'customAmount', 'showCustom'] })"
                                            :disabled="!showCustom ? selectedAmount <= 0 : (parseFloat(customAmount.replace(',','.')) || 0) < 1"
                                            :style="(!showCustom ? selectedAmount > 0 : (parseFloat(customAmount.replace(',','.')) || 0) >= 1)
                                                ? 'background-color:#c80078; opacity:1; cursor:pointer;'
                                                : 'background-color:#c80078; opacity:0.4; cursor:not-allowed;'"
                                            class="inline-flex items-center gap-3 px-7 py-3.5 rounded-xl text-sm font-bold text-white">
                                        <span x-show="!$fetching()">{{ __('donation.amount_continue_btn') }}</span>
                                        <span x-show="$fetching()">
                                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                             x-show="!$fetching()">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                            @endisset
                        </div>
                        @endfragment
                    </div>

                    {{-- Donor info form (after amount confirmed) --}}
                    <div x-show="amountConfirmed && !cardStep && donationType !== 'recurring'" style="display:none;"
                         x-effect="if (amountConfirmed && !cardStep && donationType !== 'recurring') $nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'nearest' }))">

                        <div class="flex items-center justify-between mb-5 p-4 rounded-xl"
                             style="background-color:#143c64;">
                            <div>
                                <p class="text-xs font-bold tracking-widest uppercase mb-0.5" style="color:rgba(255,255,255,0.6);">{{ __('donation.donor_amount_summary') }}</p>
                                <p class="text-2xl font-bold" style="color:#c8a03c; font-family:'Playfair Display',serif;">
                                    <span x-text="Number(confirmedAmount).toLocaleString('fr-FR')"></span> FCFA
                                </p>
                            </div>
                            <button type="button" @click="amountConfirmed = false; cardStep = false; authMode = ''"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg"
                                    style="color:rgba(255,255,255,0.7); background-color:rgba(255,255,255,0.12);">
                                {{ __('donation.donor_change_amount') }}
                            </button>
                        </div>

                        <h4 class="text-base font-bold mb-1" style="color:#143c64; font-family:'Playfair Display',serif;">{{ __('donation.donor_heading') }}</h4>
                        <p class="text-xs mb-4" style="color:#94a3b8;">{{ __('donation.donor_sub') }}</p>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_name_label') }} *</label>
                            <input type="text" x-model="donorName" placeholder="{{ __('donation.donor_name_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                   style="border-color:#e2e8f0; color:#143c64;"
                                   @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="donorName" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_email_label') }} *</label>
                            <input type="email" x-model="donorEmail" placeholder="{{ __('donation.donor_email_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                   style="border-color:#e2e8f0; color:#143c64;"
                                   @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="donorEmail" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_phone_label') }}</label>
                                <input type="tel" x-model="donorPhone" placeholder="{{ __('donation.donor_phone_placeholder') }}"
                                       class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                       style="border-color:#e2e8f0; color:#143c64;"
                                       @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_country_label') }}</label>
                                <select x-model="donorCountry"
                                        class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none appearance-none"
                                        style="border-color:#e2e8f0; color:#143c64;"
                                        @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                    <option value="CM">Cameroun</option>
                                    <option value="FR">France</option>
                                    <option value="BE">Belgique</option>
                                    <option value="CH">Suisse</option>
                                    <option value="CA">Canada</option>
                                    <option value="US">États-Unis</option>
                                    <option value="GB">Royaume-Uni</option>
                                    <option value="DE">Allemagne</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="SN">Sénégal</option>
                                    <option value="OTHER">Autre</option>
                                </select>
                            </div>
                        </div>

                        {{-- Trust signals --}}
                        <div class="mb-4 px-4 py-3 rounded-xl flex flex-wrap items-center gap-x-5 gap-y-2"
                             style="background-color:#f0fdf4; border:1px solid #bbf7d0;">
                            <div class="flex items-center gap-1.5 text-xs font-medium" style="color:#065f46;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                                {{ __('donation.trust_flutterwave') }}
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-medium" style="color:#065f46;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('donation.secure_payment_badge') }}
                            </div>
                        </div>

                        <button type="button"
                                @click="$action('{{ route('public.donate.initPayment') }}', { include: ['programme', 'donationType', 'frequency', 'confirmedAmount', 'confirmedType', 'confirmedFrequency', 'donorName', 'donorEmail', 'donorPhone', 'donorCountry'] })"
                                :disabled="!donorName.trim() || !donorEmail.trim()"
                                :style="(donorName.trim() && donorEmail.trim())
                                    ? 'background-color:#c80078; opacity:1; cursor:pointer;'
                                    : 'background-color:#c80078; opacity:0.5; cursor:not-allowed;'"
                                class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" x-show="!$fetching()">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <span x-show="!$fetching()">{{ __('donation.donor_pay_btn') }}</span>
                            <span x-show="$fetching()" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                {{ __('donation.donor_paying_btn') }}
                            </span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" x-show="!$fetching()">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75l4.5 4.5-4.5 4.5M3.75 12h16.5"/>
                            </svg>
                        </button>

                    </div>

                    {{-- Card payment step (shows after initPayment succeeds) --}}
                    <div x-show="cardStep" style="display:none;"
                         x-effect="if (cardStep) $nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'nearest' }))">

                        {{-- Amount + back button --}}
                        <div class="flex items-center justify-between mb-5 p-4 rounded-xl"
                             style="background-color:#0a1f3a;">
                            <div>
                                <p class="text-xs font-bold tracking-widest uppercase mb-0.5" style="color:rgba(255,255,255,0.5);">{{ __('donation.donor_amount_summary') }}</p>
                                <p class="text-2xl font-bold" style="color:#c8a03c; font-family:'Playfair Display',serif;">
                                    <span x-text="Number(confirmedAmount).toLocaleString('fr-FR')"></span> FCFA
                                </p>
                            </div>
                            <button type="button" @click="cardStep = false; authMode = ''"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg"
                                    style="color:rgba(255,255,255,0.7); background-color:rgba(255,255,255,0.12);">
                                {{ __('donation.card_back_btn') }}
                            </button>
                        </div>

                        {{-- Card entry step --}}
                        <div x-show="authMode === ''" style="display:none;"
                             class="p-5 rounded-2xl" style="background-color:#0a1f3a;">
                            <h4 class="text-base font-bold mb-1 text-white" style="font-family:'Playfair Display',serif;">{{ __('donation.card_heading') }}</h4>
                            <p class="text-xs mb-4" style="color:rgba(255,255,255,0.6);">{{ __('donation.card_sub') }}</p>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold mb-1.5" style="color:rgba(255,255,255,0.85);">{{ __('donation.card_number_label') }}</label>
                                <div class="relative">
                                    <input type="text" x-model="cardNumber" @input="formatCardNumber()"
                                           inputmode="numeric" placeholder="{{ __('donation.card_number_placeholder') }}"
                                           maxlength="19" autocomplete="cc-number"
                                           class="w-full px-4 py-3 pr-12 rounded-xl border-2 text-sm font-mono tracking-wider focus:outline-none"
                                           style="border-color:rgba(255,255,255,0.2); background-color:rgba(255,255,255,0.08); color:#ffffff;"
                                           @focus="$el.style.borderColor='#c8a03c'" @blur="$el.style.borderColor='rgba(255,255,255,0.2)'">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:rgba(255,255,255,0.35);">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                    </svg>
                                </div>
                                <p x-message="cardNumber" class="text-xs mt-1 font-medium" style="color:#fca5a5;"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color:rgba(255,255,255,0.85);">{{ __('donation.card_expiry_label') }}</label>
                                    <input type="text" x-model="cardExpiry" @input="formatExpiry()"
                                           inputmode="numeric" placeholder="{{ __('donation.card_expiry_placeholder') }}"
                                           maxlength="5" autocomplete="cc-exp"
                                           class="w-full px-4 py-3 rounded-xl border-2 text-sm font-mono focus:outline-none"
                                           style="border-color:rgba(255,255,255,0.2); background-color:rgba(255,255,255,0.08); color:#ffffff;"
                                           @focus="$el.style.borderColor='#c8a03c'" @blur="$el.style.borderColor='rgba(255,255,255,0.2)'">
                                    <p x-message="cardExpiry" class="text-xs mt-1 font-medium" style="color:#fca5a5;"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color:rgba(255,255,255,0.85);">{{ __('donation.card_cvv_label') }}</label>
                                    <input type="password" x-model="cardCvv"
                                           @input="cardCvv = cardCvv.replace(/\D/g, '').substring(0, 4)"
                                           inputmode="numeric" placeholder="{{ __('donation.card_cvv_placeholder') }}"
                                           maxlength="4" autocomplete="cc-csc"
                                           class="w-full px-4 py-3 rounded-xl border-2 text-sm font-mono focus:outline-none"
                                           style="border-color:rgba(255,255,255,0.2); background-color:rgba(255,255,255,0.08); color:#ffffff;"
                                           @focus="$el.style.borderColor='#c8a03c'" @blur="$el.style.borderColor='rgba(255,255,255,0.2)'">
                                    <p x-message="cardCvv" class="text-xs mt-1 font-medium" style="color:#fca5a5;"></p>
                                </div>
                            </div>

                            <button type="button"
                                    @click="$action('{{ route('public.donate.chargeCard') }}', { include: ['txRef', 'cardNumber', 'cardExpiry', 'cardCvv', 'confirmedType'] })"
                                    :disabled="cardNumber.replace(/\D/g,'').length < 13 || cardExpiry.length < 5 || cardCvv.replace(/\D/g,'').length < 3"
                                    :style="(cardNumber.replace(/\D/g,'').length >= 13 && cardExpiry.length >= 5 && cardCvv.replace(/\D/g,'').length >= 3)
                                        ? 'background-color:#c8a03c; color:#143c64; opacity:1; cursor:pointer;'
                                        : 'background-color:#c8a03c; color:#143c64; opacity:0.4; cursor:not-allowed;'"
                                    class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold">
                                <span x-show="!$fetching()">{{ __('donation.card_pay_btn') }} — <span x-text="Number(confirmedAmount).toLocaleString('fr-FR') + ' FCFA'"></span></span>
                                <span x-show="$fetching()" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    {{ __('donation.card_paying_btn') }}
                                </span>
                            </button>
                        </div>

                        {{-- PIN step --}}
                        <div x-show="authMode === 'pin'" style="display:none;"
                             class="p-5 rounded-2xl" style="background-color:#0a1f3a;">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background-color:rgba(200,160,60,0.15);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:#c8a03c;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold mb-1 text-white" style="font-family:'Playfair Display',serif;">{{ __('donation.card_pin_heading') }}</h4>
                            <p class="text-xs mb-4" style="color:rgba(255,255,255,0.6);">{{ __('donation.card_pin_sub') }}</p>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold mb-1.5" style="color:rgba(255,255,255,0.85);">{{ __('donation.card_pin_label') }}</label>
                                <input type="password" x-model="pinValue"
                                       @input="pinValue = pinValue.replace(/\D/g, '').substring(0, 6)"
                                       inputmode="numeric" placeholder="{{ __('donation.card_pin_placeholder') }}"
                                       maxlength="6"
                                       class="w-full max-w-xs px-4 py-3 rounded-xl border-2 text-xl tracking-widest font-mono focus:outline-none"
                                       style="border-color:rgba(255,255,255,0.2); background-color:rgba(255,255,255,0.08); color:#ffffff;"
                                       @focus="$el.style.borderColor='#c8a03c'" @blur="$el.style.borderColor='rgba(255,255,255,0.2)'">
                                <p x-message="pinValue" class="text-xs mt-1 font-medium" style="color:#fca5a5;"></p>
                            </div>
                            <button type="button"
                                    @click="$action('{{ route('public.donate.authenticateCharge') }}', { include: ['authMode', 'pinValue', 'txRef', 'confirmedType'] })"
                                    :disabled="pinValue.replace(/\D/g,'').length < 4"
                                    :style="pinValue.replace(/\D/g,'').length >= 4 ? 'background-color:#c8a03c; color:#143c64; opacity:1; cursor:pointer;' : 'background-color:#c8a03c; color:#143c64; opacity:0.4; cursor:not-allowed;'"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold">
                                <span x-show="!$fetching()">{{ __('donation.card_confirm_btn') }}</span>
                                <span x-show="$fetching()">{{ __('donation.card_confirming_btn') }}</span>
                            </button>
                        </div>

                        {{-- OTP step --}}
                        <div x-show="authMode === 'otp'" style="display:none;"
                             class="p-5 rounded-2xl" style="background-color:#0a1f3a;">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background-color:rgba(200,0,120,0.15);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:#c80078;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold mb-1 text-white" style="font-family:'Playfair Display',serif;">{{ __('donation.card_otp_heading') }}</h4>
                            <p class="text-xs mb-4" style="color:rgba(255,255,255,0.6);">{{ __('donation.card_otp_sub') }}</p>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold mb-1.5" style="color:rgba(255,255,255,0.85);">{{ __('donation.card_otp_label') }}</label>
                                <input type="text" x-model="otpValue"
                                       inputmode="numeric" placeholder="{{ __('donation.card_otp_placeholder') }}"
                                       maxlength="8"
                                       class="w-full max-w-xs px-4 py-3 rounded-xl border-2 text-xl tracking-widest font-mono focus:outline-none"
                                       style="border-color:rgba(255,255,255,0.2); background-color:rgba(255,255,255,0.08); color:#ffffff;"
                                       @focus="$el.style.borderColor='#c8a03c'" @blur="$el.style.borderColor='rgba(255,255,255,0.2)'">
                                <p x-message="otpValue" class="text-xs mt-1 font-medium" style="color:#fca5a5;"></p>
                            </div>
                            <button type="button"
                                    @click="$action('{{ route('public.donate.authenticateCharge') }}', { include: ['authMode', 'otpValue', 'flwRef', 'txRef', 'confirmedType'] })"
                                    :disabled="!otpValue.trim()"
                                    :style="otpValue.trim() ? 'background-color:#c8a03c; color:#143c64; opacity:1; cursor:pointer;' : 'background-color:#c8a03c; color:#143c64; opacity:0.4; cursor:not-allowed;'"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold">
                                <span x-show="!$fetching()">{{ __('donation.card_validate_btn') }}</span>
                                <span x-show="$fetching()">{{ __('donation.card_validating_btn') }}</span>
                            </button>
                        </div>

                        {{-- 3DS redirect step --}}
                        <div x-show="authMode === 'redirect'" style="display:none;"
                             x-effect="if (redirectUrl) window.location.href = redirectUrl">
                            <div class="text-center py-8 p-5 rounded-2xl" style="background-color:#0a1f3a;">
                                <svg class="w-10 h-10 animate-spin mx-auto mb-3" fill="none" viewBox="0 0 24 24" style="color:#c8a03c;">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <p class="text-base font-semibold text-white mb-1">{{ __('donation.card_redirect_heading') }}</p>
                                <p class="text-xs" style="color:rgba(255,255,255,0.55);">{{ __('donation.card_redirect_sub') }}</p>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Panel footer: security --}}
                <div class="px-8 py-3 flex flex-wrap items-center gap-4"
                     style="background-color:#f8f5f0; border-top:1px solid #e8ddf0;">
                    <div class="flex items-center gap-1.5 text-xs" style="color:#94a3b8;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        {{ __('donation.security_note') }}
                    </div>
                    <div class="flex items-center gap-1.5 text-xs" style="color:#94a3b8;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('donation.tax_note') }}
                    </div>
                </div>

            </div>

            {{-- ======================================================
                 TAB PANEL: DON RÉCURRENT
                 ====================================================== --}}
            <div x-show="activeTab === 'recurring'" class="don-tab-panel" style="display:none;
                 background-color:#ffffff; border:2px solid #e8ddf0; border-radius:1.5rem; overflow:hidden;">

                <div style="background-color:#143c64; padding:2rem 2rem 1.5rem;">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                             style="background-color:rgba(200,160,60,0.2);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:#c8a03c;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white" style="font-family:'Playfair Display',serif;">
                                {{ __('donation.recurring_tab_heading') }}
                            </h3>
                            <p class="mt-1 text-sm" style="color:rgba(255,255,255,0.7);">{{ __('donation.recurring_tab_sub') }}</p>
                        </div>
                    </div>
                </div>

                <div style="padding:1.5rem 2rem;">
                    <div x-show="!selectorVisible && !amountConfirmed && !cardStep">
                        <p class="text-sm mb-5" style="color:#64748b;">{{ __('donation.type_recurring_sub') }}</p>
                        <button type="button"
                                @click="donationType = 'recurring'; $action('{{ route('public.donate.selectAmount') }}', { include: ['donationType'] })"
                                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-sm font-bold cursor-pointer"
                                style="background-color:#c8a03c; color:#143c64;">
                            <span x-show="!(donationType === 'recurring' && $fetching())">{{ __('donation.type_recurring_btn') }}</span>
                            <span x-show="donationType === 'recurring' && $fetching()">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                 x-show="!(donationType === 'recurring' && $fetching())">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>

                    {{-- The amount selector fragment is shared — same id="amount-selector". When recurring tab is active and selectorVisible, the fragment renders here too since this panel is visible --}}
                    <div x-show="selectorVisible && !amountConfirmed && !cardStep && donationType === 'recurring'" style="display:none;">
                        <p class="text-xs text-center py-4" style="color:#94a3b8;">
                            <svg class="w-4 h-4 inline animate-spin mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Chargement…
                        </p>
                    </div>

                    <div x-show="amountConfirmed && !cardStep && donationType === 'recurring'" style="display:none;"
                         x-effect="if (amountConfirmed && !cardStep && donationType === 'recurring') $nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'nearest' }))">

                        <div class="flex items-center justify-between mb-5 p-4 rounded-xl"
                             style="background-color:#143c64;">
                            <div>
                                <p class="text-xs font-bold tracking-widest uppercase mb-0.5" style="color:rgba(255,255,255,0.6);">{{ __('donation.donor_amount_summary') }}</p>
                                <p class="text-2xl font-bold" style="color:#c8a03c; font-family:'Playfair Display',serif;">
                                    <span x-text="Number(confirmedAmount).toLocaleString('fr-FR')"></span> FCFA
                                </p>
                                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">
                                    <span x-show="confirmedFrequency === 'monthly'">{{ __('donation.recurring_monthly') }}</span>
                                    <span x-show="confirmedFrequency === 'yearly'">{{ __('donation.recurring_yearly') }}</span>
                                </p>
                            </div>
                            <button type="button" @click="amountConfirmed = false; cardStep = false; authMode = ''"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg"
                                    style="color:rgba(255,255,255,0.7); background-color:rgba(255,255,255,0.12);">
                                {{ __('donation.donor_change_amount') }}
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_name_label') }} *</label>
                            <input type="text" x-model="donorName" placeholder="{{ __('donation.donor_name_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                   style="border-color:#e2e8f0; color:#143c64;"
                                   @focus="$el.style.borderColor='#143c64'" @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="donorName" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.donor_email_label') }} *</label>
                            <input type="email" x-model="donorEmail" placeholder="{{ __('donation.donor_email_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                   style="border-color:#e2e8f0; color:#143c64;"
                                   @focus="$el.style.borderColor='#143c64'" @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="donorEmail" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                        </div>

                        <button type="button"
                                @click="$action('{{ route('public.donate.initPayment') }}', { include: ['programme', 'donationType', 'frequency', 'confirmedAmount', 'confirmedType', 'confirmedFrequency', 'donorName', 'donorEmail', 'donorPhone', 'donorCountry'] })"
                                :disabled="!donorName.trim() || !donorEmail.trim()"
                                :style="(donorName.trim() && donorEmail.trim()) ? 'background-color:#143c64; opacity:1; cursor:pointer;' : 'background-color:#143c64; opacity:0.5; cursor:not-allowed;'"
                                class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold text-white">
                            <span x-show="!$fetching()">{{ __('donation.recurring_confirm_btn') }}</span>
                            <span x-show="$fetching()" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                {{ __('donation.recurring_confirming_btn') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-3" style="background-color:#f8f5f0; border-top:1px solid #e8ddf0;">
                    <div class="flex items-center gap-1.5 text-xs" style="color:#94a3b8;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        {{ __('donation.security_note') }}
                    </div>
                </div>

            </div>

            {{-- ======================================================
                 TAB PANEL: PROMESSE DE DON (inline)
                 ====================================================== --}}
            <div x-show="activeTab === 'pledge'" class="don-tab-panel" style="display:none;"
                 x-data="{
                     pledgeFirstName: '',
                     pledgeLastName: '',
                     pledgeAddress: '',
                     pledgePhone: '',
                     pledgeEmail: '',
                     pledgeAmount: '',
                     pledgeNature: 'monetary',
                     pledgeProgramme: '',
                     pledgeMessage: '',
                     pledgeSubmitted: false
                 }"
                 x-sync="['pledgeFirstName','pledgeLastName','pledgeAddress','pledgePhone','pledgeEmail','pledgeAmount','pledgeNature','pledgeProgramme','pledgeMessage','pledgeSubmitted']">

                <div style="background-color:#ffffff; border:2px solid #e8ddf0; border-radius:1.5rem; overflow:hidden;">
                    <div style="padding:2rem 2rem 1.5rem; border-bottom:2px solid #f8f5f0;">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                                 style="background-color:#fefce8;">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" style="color:#c8a03c;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold tracking-widest uppercase mb-1.5" style="color:#c8a03c;">{{ __('donation.type_pledge_title') }}</p>
                                <h3 class="text-xl font-bold" style="color:#143c64; font-family:'Playfair Display',serif;">{{ __('donation.pledge_tab_heading') }}</h3>
                                <p class="mt-1 text-sm" style="color:#64748b;">{{ __('donation.pledge_tab_sub') }}</p>
                            </div>
                        </div>
                    </div>

                    <div style="padding:1.5rem 2rem;" id="promesse-don-tab">

                        {{-- Success state --}}
                        <div x-show="pledgeSubmitted" style="display:none;" class="text-center py-8">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4"
                                 style="background-color:#f0fdf4;">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#16a34a;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2" style="color:#143c64; font-family:'Playfair Display',serif;">{{ __('donation.pledge_success_heading') }}</h3>
                            <p class="text-sm mb-5" style="color:#64748b;">{{ __('donation.pledge_success_sub') }}</p>
                            <button type="button" @click="pledgeSubmitted = false"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold"
                                    style="background-color:#143c64; color:#ffffff;">
                                {{ __('donation.pledge_new_btn') }}
                            </button>
                        </div>

                        {{-- Pledge form --}}
                        <div x-show="!pledgeSubmitted" style="display:block;">
                            <form @submit.prevent="$action('{{ route('public.donate.pledge') }}', { include: ['pledgeFirstName','pledgeLastName','pledgeAddress','pledgePhone','pledgeEmail','pledgeAmount','pledgeNature','pledgeProgramme','pledgeMessage'] })">
                                @honeypot
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_firstname_label') }} *</label>
                                        <input type="text" x-model="pledgeFirstName" placeholder="{{ __('donation.pledge_firstname_placeholder') }}"
                                               class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                               style="border-color:#e2e8f0; color:#143c64;"
                                               @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                        <p x-message="pledgeFirstName" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_lastname_label') }} *</label>
                                        <input type="text" x-model="pledgeLastName" placeholder="{{ __('donation.pledge_lastname_placeholder') }}"
                                               class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                               style="border-color:#e2e8f0; color:#143c64;"
                                               @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                        <p x-message="pledgeLastName" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_email_label') }} *</label>
                                        <input type="email" x-model="pledgeEmail" placeholder="{{ __('donation.pledge_email_placeholder') }}"
                                               class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                               style="border-color:#e2e8f0; color:#143c64;"
                                               @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                        <p x-message="pledgeEmail" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_phone_label') }}</label>
                                        <input type="tel" x-model="pledgePhone" placeholder="{{ __('donation.pledge_phone_placeholder') }}"
                                               class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                               style="border-color:#e2e8f0; color:#143c64;"
                                               @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_address_label') }}</label>
                                    <input type="text" x-model="pledgeAddress" placeholder="{{ __('donation.pledge_address_placeholder') }}"
                                           class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none"
                                           style="border-color:#e2e8f0; color:#143c64;"
                                           @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_nature_label') }}</label>
                                        <select x-model="pledgeNature"
                                                class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none appearance-none"
                                                style="border-color:#e2e8f0; color:#143c64;"
                                                @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                            <option value="monetary">{{ __('donation.pledge_nature_monetary') }}</option>
                                            <option value="in_kind">{{ __('donation.pledge_nature_inkind') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_amount_label') }}</label>
                                        <div class="relative">
                                            <input type="text" x-model="pledgeAmount"
                                                   @input="pledgeAmount = $el.value.replace(/[^0-9,\.]/g, '')"
                                                   placeholder="{{ __('donation.pledge_amount_placeholder') }}"
                                                   class="w-full px-4 py-3 pr-16 rounded-xl border-2 text-sm focus:outline-none"
                                                   style="border-color:#e2e8f0; color:#143c64;"
                                                   @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:#94a3b8;">FCFA</span>
                                        </div>
                                        <p class="text-xs mt-1" style="color:#94a3b8;">{{ __('donation.pledge_amount_hint') }}</p>
                                        <p x-message="pledgeAmount" class="text-xs mt-1 font-medium" style="color:#dc2626;"></p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_programme_label') }}</label>
                                    <select x-model="pledgeProgramme"
                                            class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none appearance-none"
                                            style="border-color:#e2e8f0; color:#143c64;"
                                            @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'">
                                        <option value="">{{ __('donation.pledge_programme_none') }}</option>
                                        <option value="bree-protege">{{ __('donation.programme_protege') }}</option>
                                        <option value="bree-eleve">{{ __('donation.programme_eleve') }}</option>
                                        <option value="bree-respire">{{ __('donation.programme_respire') }}</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold mb-1.5" style="color:#143c64;">{{ __('donation.pledge_message_label') }}</label>
                                    <textarea x-model="pledgeMessage" rows="3"
                                              placeholder="{{ __('donation.pledge_message_placeholder') }}"
                                              class="w-full px-4 py-3 rounded-xl border-2 text-sm focus:outline-none resize-none"
                                              style="border-color:#e2e8f0; color:#143c64;"
                                              @focus="$el.style.borderColor='#c80078'" @blur="$el.style.borderColor='#e2e8f0'"></textarea>
                                </div>
                                <button type="submit"
                                        :disabled="!pledgeFirstName.trim() || !pledgeLastName.trim() || !pledgeEmail.trim()"
                                        :style="(pledgeFirstName.trim() && pledgeLastName.trim() && pledgeEmail.trim())
                                            ? 'background-color:#c8a03c; opacity:1; cursor:pointer;'
                                            : 'background-color:#c8a03c; opacity:0.4; cursor:not-allowed;'"
                                        class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold"
                                        style="color:#143c64;">
                                    <span x-show="!$fetching()">{{ __('donation.pledge_submit_btn') }}</span>
                                    <span x-show="$fetching()" class="flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        {{ __('donation.pledge_submitting_btn') }}
                                    </span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" x-show="!$fetching()">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75l4.5 4.5-4.5 4.5M3.75 12h16.5"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="px-8 py-3" style="background-color:#f8f5f0; border-top:1px solid #e8ddf0;">
                        <p class="text-xs" style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            {{ __('donation.security_note') }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section id="promesse-don" class="py-16 lg:py-24" style="background-color: #f8f5f0;"
             x-data="{
                 pledgeFirstName: '',
                 pledgeLastName: '',
                 pledgeAddress: '',
                 pledgePhone: '',
                 pledgeEmail: '',
                 pledgeAmount: '',
                 pledgeNature: 'monetary',
                 pledgeProgramme: '',
                 pledgeMessage: '',
                 pledgeSubmitted: false
             }"
             x-sync="['pledgeFirstName','pledgeLastName','pledgeAddress','pledgePhone','pledgeEmail','pledgeAmount','pledgeNature','pledgeProgramme','pledgeMessage','pledgeSubmitted']">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section header --}}
            <div class="text-center mb-10" data-animate="fade-up">
                <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: #c8a03c;">
                    {{ __('donation.type_pledge_title') }}
                </p>
                <h2 class="text-2xl lg:text-3xl font-bold mb-3"
                    style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.pledge_section_heading') }}
                </h2>
                <p class="text-sm max-w-xl mx-auto" style="color: #64748b; line-height: 1.7;">
                    {{ __('donation.pledge_section_sub') }}
                </p>
            </div>

            {{-- Success state --}}
            <div x-show="pledgeSubmitted" style="display:none;" class="text-center py-12" data-animate="fade-up">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"
                     style="background-color: #f0fdf4;">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #16a34a;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2" style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.pledge_success_heading') }}
                </h3>
                <p class="text-sm mb-6" style="color: #64748b;">{{ __('donation.pledge_success_sub') }}</p>
                <button type="button"
                        @click="pledgeSubmitted = false"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                        style="background-color: #143c64; color: #ffffff;">
                    {{ __('donation.pledge_new_btn') }}
                </button>
            </div>

            {{-- Form --}}
            <div x-show="!pledgeSubmitted" style="display:block;"
                 class="rounded-3xl p-8 lg:p-10"
                 style="background-color: #ffffff; border: 1px solid #e2e8f0;">

                <form @submit.prevent="$action('{{ route('public.donate.pledge') }}', { include: ['pledgeFirstName','pledgeLastName','pledgeAddress','pledgePhone','pledgeEmail','pledgeAmount','pledgeNature','pledgeProgramme','pledgeMessage'] })">
                    @honeypot

                    {{-- Name row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_firstname_label') }} *
                            </label>
                            <input type="text"
                                   x-model="pledgeFirstName"
                                   placeholder="{{ __('donation.pledge_firstname_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#c80078'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="pledgeFirstName" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_lastname_label') }} *
                            </label>
                            <input type="text"
                                   x-model="pledgeLastName"
                                   placeholder="{{ __('donation.pledge_lastname_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#c80078'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="pledgeLastName" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                        </div>
                    </div>

                    {{-- Email + Phone row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_email_label') }} *
                            </label>
                            <input type="email"
                                   x-model="pledgeEmail"
                                   placeholder="{{ __('donation.pledge_email_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#c80078'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="pledgeEmail" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_phone_label') }}
                            </label>
                            <input type="tel"
                                   x-model="pledgePhone"
                                   placeholder="{{ __('donation.pledge_phone_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#c80078'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                            {{ __('donation.pledge_address_label') }}
                        </label>
                        <input type="text"
                               x-model="pledgeAddress"
                               placeholder="{{ __('donation.pledge_address_placeholder') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                               style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                               @focus="$el.style.borderColor='#c80078'"
                               @blur="$el.style.borderColor='#e2e8f0'">
                    </div>

                    {{-- Nature + Amount row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_nature_label') }}
                            </label>
                            <select x-model="pledgeNature"
                                    class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none appearance-none"
                                    style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                    @focus="$el.style.borderColor='#c80078'"
                                    @blur="$el.style.borderColor='#e2e8f0'">
                                <option value="monetary">{{ __('donation.pledge_nature_monetary') }}</option>
                                <option value="in_kind">{{ __('donation.pledge_nature_inkind') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.pledge_amount_label') }}
                            </label>
                            <div class="relative">
                                <input type="text"
                                       x-model="pledgeAmount"
                                       @input="pledgeAmount = $el.value.replace(/[^0-9,\.]/g, '')"
                                       placeholder="{{ __('donation.pledge_amount_placeholder') }}"
                                       class="w-full px-4 py-3 pr-10 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                       style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                       @focus="$el.style.borderColor='#c80078'"
                                       @blur="$el.style.borderColor='#e2e8f0'">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold" style="color: #94a3b8;">€</span>
                            </div>
                            <p class="text-xs mt-1" style="color: #94a3b8;">{{ __('donation.pledge_amount_hint') }}</p>
                            <p x-message="pledgeAmount" class="text-xs mt-1 font-medium" style="color: #dc2626;"></p>
                        </div>
                    </div>

                    {{-- Programme --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                            {{ __('donation.pledge_programme_label') }}
                        </label>
                        <select x-model="pledgeProgramme"
                                class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none appearance-none"
                                style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                @focus="$el.style.borderColor='#c80078'"
                                @blur="$el.style.borderColor='#e2e8f0'">
                            <option value="">{{ __('donation.pledge_programme_none') }}</option>
                            <option value="bree-protege">{{ __('donation.programme_protege') }}</option>
                            <option value="bree-eleve">{{ __('donation.programme_eleve') }}</option>
                            <option value="bree-respire">{{ __('donation.programme_respire') }}</option>
                        </select>
                    </div>

                    {{-- Message --}}
                    <div class="mb-8">
                        <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                            {{ __('donation.pledge_message_label') }}
                        </label>
                        <textarea x-model="pledgeMessage"
                                  rows="3"
                                  placeholder="{{ __('donation.pledge_message_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none resize-none"
                                  style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                  @focus="$el.style.borderColor='#c80078'"
                                  @blur="$el.style.borderColor='#e2e8f0'"></textarea>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            :disabled="!pledgeFirstName.trim() || !pledgeLastName.trim() || !pledgeEmail.trim()"
                            :style="(pledgeFirstName.trim() && pledgeLastName.trim() && pledgeEmail.trim())
                                ? 'background-color:#c80078; opacity:1; cursor:pointer;'
                                : 'background-color:#c80078; opacity:0.4; cursor:not-allowed;'"
                            class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold text-white transition-all"
                            style="background-color:#c80078;">
                        <span x-show="!$fetching()">{{ __('donation.pledge_submit_btn') }}</span>
                        <span x-show="$fetching()">{{ __('donation.pledge_submitting_btn') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             x-show="!$fetching()">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75l4.5 4.5-4.5 4.5M3.75 12h16.5"/>
                        </svg>
                    </button>

                </form>
            </div>

        </div>
    </section>

    {{-- ================================================================
         IN-KIND DONATION FORM
         ================================================================ --}}
    <section id="don-nature" class="py-16 lg:py-24" style="background-color: #f0fdf4;"
             x-data="{
                 inkindDonorName: '',
                 inkindOrganization: '',
                 inkindEmail: '',
                 inkindPhone: '',
                 inkindType: 'goods',
                 inkindDescription: '',
                 inkindEstimatedValue: '',
                 inkindProgramme: '',
                 inkindAvailability: '',
                 inkindSubmitted: false
             }"
             x-sync="['inkindDonorName','inkindOrganization','inkindEmail','inkindPhone','inkindType','inkindDescription','inkindEstimatedValue','inkindProgramme','inkindAvailability','inkindSubmitted']">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Heading --}}
            <div class="text-center mb-10" data-animate="fade-up">
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: #16a34a;">
                    {{ __('donation.type_inkind_title') }}
                </p>
                <h2 class="text-2xl lg:text-3xl font-bold mb-3"
                    style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.inkind_section_heading') }}
                </h2>
                <p class="text-sm max-w-lg mx-auto" style="color: #64748b; line-height: 1.7;">
                    {{ __('donation.inkind_section_sub') }}
                </p>
            </div>

            {{-- Success state --}}
            <div x-show="inkindSubmitted" style="display:none;" class="text-center py-12" data-animate="fade-up">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"
                     style="background-color: #dcfce7;">
                    <svg class="w-8 h-8" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.inkind_success_heading') }}
                </h3>
                <p class="text-sm mb-6" style="color: #64748b;">{{ __('donation.inkind_success_sub') }}</p>
                <button type="button"
                        @click="inkindSubmitted = false"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                        style="background-color: #16a34a; color: #ffffff;">
                    {{ __('donation.inkind_new_btn') }}
                </button>
            </div>

            {{-- Form --}}
            <div x-show="!inkindSubmitted" style="display:block;"
                 class="rounded-3xl p-8 lg:p-10"
                 style="background-color: #ffffff; border: 1px solid #bbf7d0;">

                <form @submit.prevent="$action('{{ route('public.donate.inkind') }}', { include: ['inkindDonorName','inkindOrganization','inkindEmail','inkindPhone','inkindType','inkindDescription','inkindEstimatedValue','inkindProgramme','inkindAvailability'] })">
                    @honeypot

                    {{-- Name + Organisation --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_name_label') }}
                            </label>
                            <input type="text"
                                   x-model="inkindDonorName"
                                   placeholder="{{ __('donation.inkind_name_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#16a34a'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="inkindDonorName" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_org_label') }}
                            </label>
                            <input type="text"
                                   x-model="inkindOrganization"
                                   placeholder="{{ __('donation.inkind_org_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#16a34a'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                        </div>
                    </div>

                    {{-- Email + Phone --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_email_label') }}
                            </label>
                            <input type="email"
                                   x-model="inkindEmail"
                                   placeholder="{{ __('donation.inkind_email_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#16a34a'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="inkindEmail" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_phone_label') }}
                            </label>
                            <input type="tel"
                                   x-model="inkindPhone"
                                   placeholder="{{ __('donation.inkind_phone_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                   style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                   @focus="$el.style.borderColor='#16a34a'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                        </div>
                    </div>

                    {{-- Type of contribution — card-based --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-3" style="color: #143c64;">
                            {{ __('donation.inkind_type_label') }}
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ([
                                ['goods', 'donation.inkind_type_goods', 'donation.inkind_type_goods_desc', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                                ['services', 'donation.inkind_type_services', 'donation.inkind_type_services_desc', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                ['expertise', 'donation.inkind_type_expertise', 'donation.inkind_type_expertise_desc', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                                ['other', 'donation.inkind_type_other', 'donation.inkind_type_other_desc', 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                            ] as [$value, $titleKey, $descKey, $iconPath])
                            <button type="button"
                                    @click="inkindType = '{{ $value }}'"
                                    :style="inkindType === '{{ $value }}'
                                        ? 'border-color:#16a34a; background-color:#f0fdf4;'
                                        : 'border-color:#e2e8f0; background-color:#ffffff;'"
                                    class="flex flex-col items-center text-center p-4 rounded-2xl border-2 transition-all cursor-pointer">
                                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                                     :style="inkindType === '{{ $value }}' ? 'color:#16a34a' : 'color:#94a3b8'">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                                </svg>
                                <span class="text-xs font-bold mb-0.5"
                                      :style="inkindType === '{{ $value }}' ? 'color:#143c64' : 'color:#64748b'">
                                    {{ __($titleKey) }}
                                </span>
                                <span class="text-xs leading-tight" style="color: #94a3b8;">
                                    {{ __($descKey) }}
                                </span>
                            </button>
                            @endforeach
                        </div>
                        <p x-message="inkindType" class="text-xs mt-2 font-medium" style="color: #dc2626;"></p>
                    </div>

                    {{-- Description --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                            {{ __('donation.inkind_description_label') }}
                        </label>
                        <textarea x-model="inkindDescription"
                                  rows="4"
                                  placeholder="{{ __('donation.inkind_description_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none resize-none"
                                  style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                  @focus="$el.style.borderColor='#16a34a'"
                                  @blur="$el.style.borderColor='#e2e8f0'"></textarea>
                        <p x-message="inkindDescription" class="text-xs mt-1.5 font-medium" style="color: #dc2626;"></p>
                    </div>

                    {{-- Estimated value + Programme --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_value_label') }}
                            </label>
                            <div class="relative">
                                <input type="number"
                                       x-model="inkindEstimatedValue"
                                       min="0"
                                       step="0.01"
                                       placeholder="{{ __('donation.inkind_value_placeholder') }}"
                                       class="w-full px-4 py-3 pr-10 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                                       style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                       @focus="$el.style.borderColor='#16a34a'"
                                       @blur="$el.style.borderColor='#e2e8f0'">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold" style="color: #94a3b8;">€</span>
                            </div>
                            <p class="text-xs mt-1" style="color: #94a3b8;">{{ __('donation.inkind_value_hint') }}</p>
                            <p x-message="inkindEstimatedValue" class="text-xs mt-1 font-medium" style="color: #dc2626;"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                                {{ __('donation.inkind_programme_label') }}
                            </label>
                            <select x-model="inkindProgramme"
                                    class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none appearance-none"
                                    style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                                    @focus="$el.style.borderColor='#16a34a'"
                                    @blur="$el.style.borderColor='#e2e8f0'">
                                <option value="">{{ __('donation.pledge_programme_none') }}</option>
                                <option value="bree-protege">{{ __('donation.programme_protege') }}</option>
                                <option value="bree-eleve">{{ __('donation.programme_eleve') }}</option>
                                <option value="bree-respire">{{ __('donation.programme_respire') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Availability --}}
                    <div class="mb-8">
                        <label class="block text-sm font-semibold mb-2" style="color: #143c64;">
                            {{ __('donation.inkind_availability_label') }}
                        </label>
                        <input type="text"
                               x-model="inkindAvailability"
                               placeholder="{{ __('donation.inkind_availability_placeholder') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 text-sm transition-colors focus:outline-none"
                               style="border-color: #e2e8f0; color: #143c64; background-color: #ffffff;"
                               @focus="$el.style.borderColor='#16a34a'"
                               @blur="$el.style.borderColor='#e2e8f0'">
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            :disabled="!inkindDonorName.trim() || !inkindEmail.trim() || !inkindDescription.trim()"
                            :style="(inkindDonorName.trim() && inkindEmail.trim() && inkindDescription.trim())
                                ? 'background-color:#16a34a; opacity:1; cursor:pointer;'
                                : 'background-color:#16a34a; opacity:0.4; cursor:not-allowed;'"
                            class="w-full flex items-center justify-center gap-3 py-4 rounded-xl text-sm font-bold text-white transition-all"
                            style="background-color:#16a34a;">
                        <span x-show="!$fetching()">{{ __('donation.inkind_submit_btn') }}</span>
                        <span x-show="$fetching()">{{ __('donation.inkind_submitting_btn') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             x-show="!$fetching()">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75l4.5 4.5-4.5 4.5M3.75 12h16.5"/>
                        </svg>
                    </button>

                </form>
            </div>

        </div>
    </section>

    {{-- ================================================================
         SECONDARY CTA — VOLUNTEER / PARTNER
         ================================================================ --}}
    <section class="py-12 lg:py-16" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-xl font-bold mb-3"
                style="color: #143c64; font-family: 'Playfair Display', serif;"
                data-animate="fade-up">
                {{ __('donation.cta_secondary_heading') }}
            </h2>
            <p class="text-sm mb-6" style="color: #64748b;" data-animate="fade-up">
                {{ __('donation.cta_secondary_sub') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3" data-animate="fade-up">
                <a href="{{ route('public.volunteers') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #c80078; color: #ffffff;">
                    {{ __('donation.cta_volunteer_btn') }}
                </a>
                <a href="{{ route('public.partners') }}#partenariat"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #143c64; color: #ffffff;">
                    {{ __('donation.cta_partner_btn') }}
                </a>
            </div>
        </div>
    </section>

</div>

@endsection

