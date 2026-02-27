@extends('layouts.public')

@section('title', __('donation.merci_heading') . ' — ' . config('app.name'))

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
    @keyframes bree-checkmark-draw {
        from { opacity: 0; transform: scale(0.6) rotate(-12deg); }
        to   { opacity: 1; transform: scale(1) rotate(0deg); }
    }
    @media (prefers-reduced-motion: reduce) {
        .bree-animate-logo,
        .bree-animate-icon,
        .bree-animate-heading,
        .bree-animate-sub,
        .bree-animate-card,
        .bree-animate-impact,
        .bree-animate-share,
        .bree-animate-cta {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }

    .bree-animate-logo    { animation: bree-logo-drop  0.55s cubic-bezier(0.34,1.56,0.64,1) both; }
    .bree-animate-icon    { animation: bree-checkmark-draw 0.60s cubic-bezier(0.34,1.56,0.64,1) 0.15s both; }
    .bree-animate-heading { animation: bree-fade-up 0.55s ease-out 0.30s both; }
    .bree-animate-sub     { animation: bree-fade-up 0.50s ease-out 0.42s both; }
    .bree-animate-card    { animation: bree-scale-in 0.55s cubic-bezier(0.34,1.56,0.64,1) 0.50s both; }
    .bree-animate-impact  { animation: bree-fade-up 0.50s ease-out 0.62s both; }
    .bree-animate-share   { animation: bree-fade-up 0.45s ease-out 0.72s both; }
    .bree-animate-cta     { animation: bree-fade-up 0.45s ease-out 0.80s both; }

    .bree-receipt-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem 1.5rem;
    }
    @media (max-width: 480px) {
        .bree-receipt-row {
            grid-template-columns: 1fr;
        }
    }

    .bree-divider-gold {
        height: 2px;
        width: 3rem;
        background-color: #c8a03c;
        margin: 0 auto 2rem;
    }

    .bree-share-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.1rem;
        border-radius: 0.625rem;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: opacity 150ms ease, transform 150ms ease;
    }
    .bree-share-btn:hover {
        opacity: 0.88;
        transform: translateY(-1px);
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

    .bree-impact-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 9999px;
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 1.5;
        background-color: #fdf8ec;
        border: 1.5px solid rgba(200, 160, 60, 0.35);
        color: #6b4a00;
    }
</style>
@endpush

@php
    $isFailed  = $donation && $donation->status === 'failed';
    $isPending  = $donation && $donation->status === 'pending';
    $isSuccess  = $donation && $donation->isCompleted();
    $shareText  = urlencode(__('donation.merci_share_text') . ' ' . config('app.url'));
    $shareUrl   = urlencode(config('app.url'));
    $donationDate = $donation ? $donation->updated_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY') : now()->locale(app()->getLocale())->isoFormat('D MMMM YYYY');
@endphp

{{-- Confetti trigger (only on completed donations) --}}
@if ($isSuccess)
    <span data-confetti aria-hidden="true" style="display:none;"></span>
@endif

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

        @if ($isFailed)

            {{-- ── Failed Payment ───────────────────────────────────────────────── --}}

            {{-- Warning icon — gold, not alarming red --}}
            <div class="bree-animate-icon w-20 h-20 sm:w-24 sm:h-24 rounded-full mx-auto mb-6 flex items-center justify-center"
                 style="background-color: #fdf8ec; border: 3px solid #c8a03c;">
                <svg class="w-9 h-9 sm:w-11 sm:h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                     style="color: #c8a03c;" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <div class="bree-divider-gold"></div>

            <h1 class="bree-animate-heading text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
                style="font-family: 'Playfair Display', serif; color: #143c64;">
                {{ __('donation.merci_failed_heading') }}
            </h1>

            <p class="bree-animate-sub text-base sm:text-lg mb-10" style="color: #64748b; line-height: 1.8;">
                {{ __('donation.merci_failed_sub') }}
            </p>

            <div class="bree-animate-cta flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.donate') }}"
                   class="bree-cta-btn"
                   style="background-color: #c80078; color: #ffffff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('donation.merci_failed_retry') }}
                </a>
                <a href="{{ route('public.home') }}"
                   class="bree-cta-btn"
                   style="background-color: #143c64; color: #ffffff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    {{ __('donation.merci_back_home') }}
                </a>
            </div>

        @else

            {{-- ── Success / Pending ────────────────────────────────────────────── --}}

            {{-- Magenta checkmark icon --}}
            <div class="bree-animate-icon w-20 h-20 sm:w-24 sm:h-24 rounded-full mx-auto mb-6 flex items-center justify-center"
                 style="background-color: rgba(200,0,120,0.08); border: 3px solid #c80078;">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                     style="color: #c80078;" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>

            <div class="bree-divider-gold"></div>

            {{-- Heading --}}
            @if ($donation)
                <h1 class="bree-animate-heading text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    {{ __('donation.merci_heading_personalized', ['name' => $donation->donor_name]) }}
                </h1>
                <p class="bree-animate-sub text-base sm:text-lg mb-8" style="color: #64748b; line-height: 1.8;">
                    {{ __('donation.merci_sub_personalized', [
                        'amount' => number_format((float) $donation->amount, 0, ',', "\u{202F}"),
                        'programme' => $programmeLabel,
                    ]) }}
                </p>
            @else
                <h1 class="bree-animate-heading text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
                    style="font-family: 'Playfair Display', serif; color: #143c64;">
                    {{ __('donation.merci_heading') }}
                </h1>
                <p class="bree-animate-sub text-base sm:text-lg mb-8" style="color: #64748b; line-height: 1.8;">
                    {{ __('donation.merci_sub') }}
                </p>
            @endif

            {{-- Receipt card --}}
            @if ($donation)
            <div class="bree-animate-card rounded-2xl p-5 sm:p-7 mb-6 text-left"
                 style="background-color: #ffffff; border: 1px solid rgba(20,60,100,0.10); box-shadow: 0 4px 28px rgba(20,60,100,0.07);">

                {{-- Amount — full-width prominent display --}}
                <div class="mb-5 pb-5" style="border-bottom: 1px solid rgba(20,60,100,0.08);">
                    <p class="text-xs font-bold tracking-widest uppercase mb-1.5" style="color: #94a3b8;">
                        {{ __('donation.merci_amount') }}
                    </p>
                    <p class="text-3xl font-bold" style="font-family: 'Playfair Display', serif; color: #c80078;">
                        {{ number_format((float) $donation->amount, 0, ',', "\u{202F}") }}
                        <span class="text-xl" style="color: #94a3b8;">{{ $donation->currency }}</span>
                    </p>
                </div>

                <div class="bree-receipt-row">

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_status_label') }}
                        </p>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                             style="{{ $isSuccess ? 'background-color: rgba(22,163,74,0.1); color: #16a34a;' : 'background-color: rgba(200,160,60,0.12); color: #a07828;' }}">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8" aria-hidden="true"><circle cx="4" cy="4" r="3"/></svg>
                            {{ $isSuccess ? __('donation.merci_status_completed') : __('donation.merci_status_pending') }}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_date_label') }}
                        </p>
                        <p class="text-sm font-medium" style="color: #143c64;">{{ $donationDate }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_programme') }}
                        </p>
                        <p class="text-sm font-semibold" style="color: #143c64;">{{ $programmeLabel }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_reference') }}
                        </p>
                        <p class="text-xs font-mono break-all" style="color: #143c64;">{{ $donation->tx_ref }}</p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_email_label') }}
                        </p>
                        <p class="text-sm" style="color: #143c64;">{{ $donation->donor_email }}</p>
                    </div>

                </div>
            </div>
            @endif

            {{-- Impact statement --}}
            @if (!empty($impactStatement))
            <div class="bree-animate-impact mb-8 flex justify-center">
                <div class="bree-impact-pill">
                    <svg class="w-4 h-4 shrink-0" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span>{{ __('donation.merci_impact_statement', ['impact' => $impactStatement]) }}</span>
                </div>
            </div>
            @endif

            {{-- Social share (only for completed donations) --}}
            @if ($isSuccess)
            <div class="bree-animate-share mb-8">
                <p class="text-xs font-bold tracking-widest uppercase mb-4" style="color: #94a3b8;">
                    {{ __('donation.merci_share_heading') }}
                </p>
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3">

                    {{-- Twitter/X --}}
                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}"
                       target="_blank" rel="noopener"
                       class="bree-share-btn"
                       style="background-color: #000000; color: #ffffff;"
                       aria-label="{{ __('donation.merci_share_heading') }} — X (Twitter)">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.258 5.63 5.906-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        <span class="hidden sm:inline">Twitter / X</span>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                       target="_blank" rel="noopener"
                       class="bree-share-btn"
                       style="background-color: #1877f2; color: #ffffff;"
                       aria-label="{{ __('donation.merci_share_heading') }} — Facebook">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="hidden sm:inline">Facebook</span>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ $shareText }}"
                       target="_blank" rel="noopener"
                       class="bree-share-btn"
                       style="background-color: #25d366; color: #ffffff;"
                       aria-label="{{ __('donation.merci_share_heading') }} — WhatsApp">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="hidden sm:inline">WhatsApp</span>
                    </a>

                </div>
            </div>
            @endif

            {{-- CTA buttons --}}
            <div class="bree-animate-cta flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.home') }}"
                   class="bree-cta-btn"
                   style="background-color: #143c64; color: #ffffff;">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    {{ __('donation.merci_back_home') }}
                </a>
                <a href="{{ route('public.programs') }}"
                   class="bree-cta-btn"
                   style="background-color: #c80078; color: #ffffff;">
                    {{ __('donation.merci_see_programmes') }}
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

        @endif

    </div>
</section>
