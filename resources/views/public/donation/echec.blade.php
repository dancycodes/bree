@extends('layouts.public')

@section('title', __('donation.echec_page_title') . ' — ' . config('app.name'))

@push('head')
<style>
    @keyframes bree-fade-up {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes bree-scale-in {
        from { opacity: 0; transform: scale(0.80); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes bree-logo-drop {
        from { opacity: 0; transform: translateY(-16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @media (prefers-reduced-motion: reduce) {
        .bree-animate-logo,
        .bree-animate-icon,
        .bree-animate-heading,
        .bree-animate-sub,
        .bree-animate-reason,
        .bree-animate-support,
        .bree-animate-cta {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }

    .bree-animate-logo    { animation: bree-logo-drop  0.55s cubic-bezier(0.34,1.56,0.64,1) both; }
    .bree-animate-icon    { animation: bree-scale-in   0.60s cubic-bezier(0.34,1.56,0.64,1) 0.15s both; }
    .bree-animate-heading { animation: bree-fade-up    0.55s ease-out 0.28s both; }
    .bree-animate-sub     { animation: bree-fade-up    0.50s ease-out 0.38s both; }
    .bree-animate-reason  { animation: bree-scale-in   0.50s cubic-bezier(0.34,1.56,0.64,1) 0.45s both; }
    .bree-animate-support { animation: bree-fade-up    0.50s ease-out 0.55s both; }
    .bree-animate-cta     { animation: bree-fade-up    0.45s ease-out 0.65s both; }

    .bree-divider-gold {
        height: 2px;
        width: 3rem;
        background-color: #c8a03c;
        margin: 0 auto 2rem;
    }

    .bree-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.75rem;
        border-radius: 0.75rem;
        font-size: 0.9375rem;
        font-weight: 600;
        transition: opacity 150ms ease, transform 150ms ease;
    }
    .bree-cta-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .bree-support-card {
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #ffffff;
        border: 1px solid rgba(20,60,100,0.10);
        box-shadow: 0 2px 20px rgba(20,60,100,0.06);
    }
</style>
@endpush

<section class="min-h-screen flex items-center justify-center py-20 sm:py-28" style="background-color: #f8f5f0;">
    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 text-center">

        {{-- Logo --}}
        <div class="bree-animate-logo mb-8 sm:mb-10">
            <a href="{{ route('public.home') }}" aria-label="{{ config('app.name') }}">
                <img src="{{ vasset('images/logo.png') }}"
                     alt="{{ config('app.name') }}"
                     class="h-12 sm:h-14 w-auto mx-auto object-contain"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="hidden font-heading text-xl font-bold" style="color: #143c64;">Fondation BREE</span>
            </a>
        </div>

        {{-- Gold warning icon — reassuring, not alarming --}}
        <div class="bree-animate-icon w-20 h-20 sm:w-24 sm:h-24 rounded-full mx-auto mb-6 flex items-center justify-center"
             style="background-color: #fdf8ec; border: 3px solid #c8a03c;">
            <svg class="w-9 h-9 sm:w-11 sm:h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                 style="color: #c8a03c;" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>

        <div class="bree-divider-gold"></div>

        {{-- Heading --}}
        <h1 class="bree-animate-heading text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
            style="font-family: 'Playfair Display', serif; color: #143c64;">
            {{ __('donation.echec_heading') }}
        </h1>

        {{-- Empathetic body text --}}
        <p class="bree-animate-sub text-base sm:text-lg mb-8" style="color: #64748b; line-height: 1.8;">
            {{ __('donation.echec_sub') }}
        </p>

        {{-- Error reason & reference (if available) --}}
        @if ($reason || ($txRef && $donation))
        <div class="bree-animate-reason mb-8">
            <div class="rounded-xl p-4 text-left"
                 style="background-color: #fffbeb; border: 1.5px solid rgba(200,160,60,0.30);">
                @if ($reason)
                    <div class="flex items-start gap-3 {{ $txRef ? 'mb-3 pb-3' : '' }}"
                         style="{{ $txRef ? 'border-bottom: 1px solid rgba(200,160,60,0.20);' : '' }}">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                                {{ __('donation.echec_reason_label') }}
                            </p>
                            <p class="text-sm font-medium" style="color: #6b4a00;">{{ $reason }}</p>
                        </div>
                    </div>
                @endif
                @if ($txRef)
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                                {{ __('donation.echec_ref_label') }}
                            </p>
                            <p class="text-xs font-mono" style="color: #143c64;">{{ $txRef }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Primary action buttons --}}
        <div class="bree-animate-cta flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
            <a href="{{ route('public.donate') }}"
               class="bree-cta-btn"
               style="background-color: #c80078; color: #ffffff;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('donation.echec_retry_btn') }}
            </a>
            <a href="{{ route('public.home') }}"
               class="bree-cta-btn"
               style="background-color: #143c64; color: #ffffff;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                {{ __('donation.echec_home_btn') }}
            </a>
        </div>

        {{-- Support contact card --}}
        <div class="bree-animate-support bree-support-card">
            <div class="flex items-center justify-center gap-2 mb-3">
                <svg class="w-5 h-5" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h2 class="text-base font-bold" style="font-family: 'Playfair Display', serif; color: #143c64;">
                    {{ __('donation.echec_support_heading') }}
                </h2>
            </div>
            <p class="text-sm mb-4" style="color: #64748b; line-height: 1.7;">
                {{ __('donation.echec_support_sub') }}
            </p>
            @php
                $supportEmail = config('mail.from.address');
                $supportPhone = $siteSettings['contact_phone'] ?? null;
            @endphp
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                @if ($supportEmail)
                    <a href="mailto:{{ $supportEmail }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold transition-colors hover:opacity-80"
                       style="color: #c80078;">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $supportEmail }}
                    </a>
                @endif
                @if ($supportPhone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $supportPhone) }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold transition-colors hover:opacity-80"
                       style="color: #143c64;">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $supportPhone }}
                    </a>
                @endif
                @if (!$supportEmail && !$supportPhone)
                    <a href="{{ route('public.contact') }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold"
                       style="color: #c80078;">
                        {{ __('nav.contact') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

    </div>
</section>
