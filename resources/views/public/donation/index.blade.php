@extends('layouts.public')

@section('title', __('donation.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('donation.meta_description'))

@section('content')

<div x-data="{
    donationType: '',
    selectorVisible: false,
    selectedAmount: 0,
    customAmount: '',
    showCustom: false,
    amountConfirmed: false,
    confirmedAmount: 0,
    confirmedType: '',
    selectPreset(amount) {
        this.selectedAmount = amount;
        this.showCustom = false;
        this.customAmount = '';
    },
    selectCustom() {
        this.selectedAmount = 0;
        this.showCustom = true;
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
                    <li style="color: #ffffff;">{{ __('donation.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.85);"
                  data-animate="fade-up">
                {{ __('donation.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5.5vw, 3.75rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('donation.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-2xl"
               style="color: rgba(255,255,255,0.85); line-height: 1.7;"
               data-animate="fade-up">
                {{ __('donation.hero_sub') }}
            </p>

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

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($impactExamples as $example)
                    <div class="text-center p-5 rounded-2xl"
                         style="background-color: #f8f5f0; border: 1px solid #e2e8f0;"
                         data-animate="fade-up">

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

                        <div class="text-xl font-bold mb-1" style="color: #c80078; font-family: 'Playfair Display', serif;">
                            {{ $example->amount }}€
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
         DONATION TYPE CARDS
         ================================================================ --}}
    <section id="donation-types" class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12" data-animate="fade-up">
                <h2 class="text-2xl lg:text-3xl font-bold"
                    style="color: #143c64; font-family: 'Playfair Display', serif;">
                    {{ __('donation.types_heading') }}
                </h2>
                @if ($programme !== 'general')
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold"
                         style="background-color: #fff0f8; color: #c80078; border: 1px solid #fce7f3;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('donation.programme_label') }} :
                        <strong>{{ __('donation.programme_'.str_replace('-', '_', $programme)) }}</strong>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Direct Donation --}}
                <div class="rounded-3xl p-8 lg:p-10 transition-all duration-300 hover:-translate-y-1"
                     style="background-color: #c80078;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: rgba(255,255,255,0.2);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                        </svg>
                    </div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold tracking-widest uppercase mb-3 px-3 py-1 rounded-full"
                         style="background-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9);">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                        {{ __('donation.amount_recommended') }}
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white"
                        style="font-family: 'Playfair Display', serif;">
                        {{ __('donation.type_direct_title') }}
                    </h3>
                    <p class="text-sm mb-6" style="color: rgba(255,255,255,0.8); line-height: 1.7;">
                        {{ __('donation.type_direct_sub') }}
                    </p>
                    <button type="button"
                            @click="donationType = 'direct'; $action('{{ route('public.donate.selectAmount') }}', { include: ['donationType'] })"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold transition-opacity hover:opacity-90 cursor-pointer"
                            style="background-color: #ffffff; color: #c80078;">
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

                {{-- Recurring Donation --}}
                <div class="rounded-3xl p-8 lg:p-10 transition-all duration-300 hover:-translate-y-1"
                     style="background-color: #143c64;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: rgba(200,160,60,0.2);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white"
                        style="font-family: 'Playfair Display', serif;">
                        {{ __('donation.type_recurring_title') }}
                    </h3>
                    <p class="text-sm mb-6" style="color: rgba(255,255,255,0.7); line-height: 1.7;">
                        {{ __('donation.type_recurring_sub') }}
                    </p>
                    <button type="button"
                            @click="donationType = 'recurring'; $action('{{ route('public.donate.selectAmount') }}', { include: ['donationType'] })"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold transition-opacity hover:opacity-90 cursor-pointer"
                            style="background-color: #c8a03c; color: #ffffff;">
                        <span x-show="!(donationType === 'recurring' && $fetching())">{{ __('donation.type_recurring_btn') }}</span>
                        <span x-show="donationType === 'recurring' && $fetching()">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             x-show="!(donationType === 'recurring' && $fetching())">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>

                {{-- Pledge --}}
                <div class="rounded-3xl p-8 lg:p-10 transition-all duration-300 hover:-translate-y-1"
                     style="background-color: #ffffff; border: 2px solid #e2e8f0;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: #f0f4ff;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"
                             style="color: #143c64;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('donation.type_pledge_title') }}
                    </h3>
                    <p class="text-sm mb-6" style="color: #64748b; line-height: 1.7;">
                        {{ __('donation.type_pledge_sub') }}
                    </p>
                    <a href="{{ route('public.donate') }}?programme={{ $programme }}#promesse-don"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold transition-opacity hover:opacity-90"
                       style="background-color: #143c64; color: #ffffff;">
                        {{ __('donation.type_pledge_btn') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                {{-- In-Kind --}}
                <div class="rounded-3xl p-8 lg:p-10 transition-all duration-300 hover:-translate-y-1"
                     style="background-color: #ffffff; border: 2px solid #e2e8f0;"
                     data-animate="fade-up">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6"
                         style="background-color: #f0fdf4;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"
                             style="color: #16a34a;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        {{ __('donation.type_inkind_title') }}
                    </h3>
                    <p class="text-sm mb-6" style="color: #64748b; line-height: 1.7;">
                        {{ __('donation.type_inkind_sub') }}
                    </p>
                    <a href="{{ route('public.donate') }}?programme={{ $programme }}#don-nature"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold transition-opacity hover:opacity-90"
                       style="background-color: #16a34a; color: #ffffff;">
                        {{ __('donation.type_inkind_btn') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

            </div>

            {{-- Security note --}}
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 text-xs"
                 style="color: #94a3b8;">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    {{ __('donation.security_note') }}
                </div>
                <div class="hidden sm:block w-1 h-1 rounded-full" style="background-color: #cbd5e1;"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('donation.tax_note') }}
                </div>
            </div>

        </div>
    </section>

    {{-- ================================================================
         AMOUNT SELECTOR (loaded via Gale fragment)
         ================================================================ --}}
    <div x-show="selectorVisible"
         style="display:none;"
         x-effect="if (selectorVisible) $nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))">

        @fragment('amount-selector')
        <div id="amount-selector">
            @isset($amountSelectorType)
            <section class="py-16 lg:py-20" style="background-color: #ffffff; border-top: 3px solid #c80078;">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-10">
                        <div>
                            <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: #c8a03c;">
                                {{ $amountSelectorType === 'recurring' ? __('donation.amount_type_label_recurring') : __('donation.amount_type_label_direct') }}
                            </p>
                            <h2 class="text-2xl lg:text-3xl font-bold"
                                style="color: #143c64; font-family: 'Playfair Display', serif;">
                                {{ __('donation.amount_heading') }}
                            </h2>
                            <p class="mt-2 text-sm" style="color: #64748b;">
                                {{ __('donation.amount_sub') }}
                            </p>
                        </div>
                        <button type="button"
                                @click="selectorVisible = false; donationType = ''"
                                class="shrink-0 ml-4 text-xs font-semibold px-4 py-2 rounded-lg transition-colors hover:bg-pink-50 flex items-center gap-1.5"
                                style="color: #c80078;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            {{ __('donation.amount_change_type') }}
                        </button>
                    </div>

                    {{-- Preset amount tiles --}}
                    <div class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-3">
                        @foreach ($impactExamples as $example)
                        <button type="button"
                                @click="selectPreset({{ $example->amount }})"
                                :style="selectedAmount === {{ $example->amount }} && !showCustom
                                    ? 'background-color:#c80078; color:#ffffff; border-color:#c80078;'
                                    : 'background-color:#ffffff; color:#143c64; border-color:#e2e8f0;'"
                                class="p-4 rounded-2xl border-2 text-center transition-all duration-200 cursor-pointer hover:border-pink-300 focus:outline-none focus:ring-2"
                                style="--tw-ring-color: #c80078;">
                            <div class="text-2xl font-bold mb-1" style="font-family:'Playfair Display',serif;">
                                {{ $example->amount }}€
                            </div>
                            <div class="text-xs leading-tight"
                                 :style="selectedAmount === {{ $example->amount }} && !showCustom ? 'opacity:0.85' : 'color:#64748b'">
                                {{ \Illuminate\Support\Str::limit($example->description(), 32) }}
                            </div>
                        </button>
                        @endforeach

                        {{-- Custom amount tile --}}
                        <button type="button"
                                @click="selectCustom()"
                                :style="showCustom
                                    ? 'background-color:#c80078; color:#ffffff; border-color:#c80078;'
                                    : 'background-color:#ffffff; color:#143c64; border-color:#e2e8f0;'"
                                class="p-4 rounded-2xl border-2 text-center transition-all duration-200 cursor-pointer hover:border-pink-300 focus:outline-none focus:ring-2"
                                style="--tw-ring-color: #c80078;">
                            <div class="text-2xl font-bold mb-1" style="font-family:'Playfair Display',serif;">
                                ✏️
                            </div>
                            <div class="text-xs leading-tight"
                                 :style="showCustom ? 'opacity:0.85' : 'color:#64748b'">
                                {{ __('donation.amount_custom_label') }}
                            </div>
                        </button>
                    </div>

                    {{-- Selected impact detail --}}
                    @foreach ($impactExamples as $example)
                    <div x-show="selectedAmount === {{ $example->amount }} && !showCustom"
                         style="display:none;"
                         class="mb-6 px-5 py-4 rounded-xl text-sm flex items-start gap-3"
                         style="background-color:rgba(200,0,120,0.06); border:1px solid rgba(200,0,120,0.15);">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#c80078;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        <span style="color:#7c1048;">
                            <strong>{{ $example->amount }}€</strong> {{ $example->description() }}
                        </span>
                    </div>
                    @endforeach

                    {{-- Custom amount input --}}
                    <div x-show="showCustom" style="display:none;" class="mb-6">
                        <label class="block text-sm font-semibold mb-2" style="color:#143c64;">
                            {{ __('donation.amount_custom_label') }}
                        </label>
                        <div class="relative max-w-xs">
                            <input type="text"
                                   x-model="customAmount"
                                   @input="customAmount = $el.value.replace(/[^0-9,\.]/g, '')"
                                   placeholder="{{ __('donation.amount_custom_placeholder') }}"
                                   class="w-full px-4 py-3 pr-10 rounded-xl border-2 text-xl font-bold transition-colors focus:outline-none"
                                   style="border-color:#e2e8f0; color:#143c64; background-color:#ffffff;"
                                   @focus="$el.style.borderColor='#c80078'"
                                   @blur="$el.style.borderColor='#e2e8f0'">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-lg font-bold" style="color:#94a3b8;">€</span>
                        </div>
                        <p class="text-xs mt-1.5" style="color:#94a3b8;">{{ __('donation.amount_custom_hint') }}</p>
                    </div>

                    {{-- Validation error --}}
                    <p x-message="amount" class="text-sm mb-4 font-medium" style="color:#dc2626;"></p>

                    {{-- Continue button --}}
                    <div class="flex items-center justify-end pt-4" style="border-top:1px solid #f0e8f0;">
                        <button type="button"
                                @click="$action('{{ route('public.donate.validateAmount') }}', { include: ['donationType', 'selectedAmount', 'customAmount', 'showCustom'] })"
                                :disabled="!showCustom ? selectedAmount <= 0 : (parseFloat(customAmount.replace(',','.')) || 0) < 1"
                                :style="(!showCustom ? selectedAmount > 0 : (parseFloat(customAmount.replace(',','.')) || 0) >= 1)
                                    ? 'background-color:#c80078; opacity:1; cursor:pointer;'
                                    : 'background-color:#c80078; opacity:0.4; cursor:not-allowed;'"
                                class="inline-flex items-center gap-3 px-8 py-4 rounded-xl text-sm font-bold text-white transition-opacity"
                                style="background-color:#c80078; color:#ffffff;">
                            <span x-show="!$fetching()">{{ __('donation.amount_continue_btn') }}</span>
                            <span x-show="$fetching()">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                 x-show="!$fetching()">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </section>
            @endisset
        </div>
        @endfragment

    </div>

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
