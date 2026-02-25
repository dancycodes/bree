@extends('layouts.public')

@section('title', __('donation.merci_heading') . ' — ' . config('app.name'))

@section('content')

@php
    $isFailed  = $donation && $donation->status === 'failed';
    $isPending  = $donation && $donation->status === 'pending';
    $isSuccess  = $donation && $donation->isCompleted();
    $shareText  = urlencode(__('donation.merci_share_text') . ' ' . config('app.url'));
    $shareUrl   = urlencode(config('app.url'));
@endphp

{{-- Confetti trigger (only on completed donations) --}}
@if ($isSuccess)
    <span data-confetti aria-hidden="true" style="display:none;"></span>
@endif

<section class="min-h-screen flex items-center justify-center py-24" style="background-color: #f8f5f0;">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        @if ($isFailed)

            {{-- ── Failed Payment ──────────────────────────────────────── --}}

            <div class="w-20 h-20 rounded-full mx-auto mb-8 flex items-center justify-center"
                 style="background-color: #fff5f5; border: 3px solid #ef4444;" data-animate="scale-in">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                     style="color: #ef4444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            <h1 class="text-3xl lg:text-4xl font-bold mb-4"
                style="color: #143c64; font-family: 'Playfair Display', serif;" data-animate="fade-up" data-delay="0.1">
                {{ __('donation.merci_failed_heading') }}
            </h1>

            <p class="text-base mb-10" style="color: #64748b; line-height: 1.8;" data-animate="fade-up" data-delay="0.2">
                {{ __('donation.merci_failed_sub') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-animate="fade-up" data-delay="0.3">
                <a href="{{ route('public.donate') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #c80078; color: #ffffff;">
                    {{ __('donation.merci_failed_retry') }}
                </a>
                <a href="{{ route('public.donate') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #143c64; color: #ffffff;">
                    {{ __('donation.merci_failed_pledge') }}
                </a>
            </div>

        @else

            {{-- ── Success / Generic ───────────────────────────────────── --}}

            {{-- Gold checkmark icon --}}
            <div class="w-24 h-24 rounded-full mx-auto mb-8 flex items-center justify-center"
                 style="background-color: #fdf8ec; border: 3px solid #c8a03c;" data-animate="scale-in">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                     style="color: #c8a03c;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>

            {{-- Heading --}}
            @if ($donation)
                <h1 class="text-3xl lg:text-4xl font-bold mb-4"
                    style="color: #143c64; font-family: 'Playfair Display', serif;" data-animate="fade-up" data-delay="0.1">
                    {{ __('donation.merci_heading_personalized', ['name' => $donation->donor_name]) }}
                </h1>
                <p class="text-base mb-10" style="color: #64748b; line-height: 1.8;" data-animate="fade-up" data-delay="0.2">
                    {{ __('donation.merci_sub_personalized', [
                        'amount' => number_format((float) $donation->amount, 0, ',', ' '),
                        'programme' => $programmeLabel,
                    ]) }}
                </p>
            @else
                <h1 class="text-3xl lg:text-4xl font-bold mb-4"
                    style="color: #143c64; font-family: 'Playfair Display', serif;" data-animate="fade-up" data-delay="0.1">
                    {{ __('donation.merci_heading') }}
                </h1>
                <p class="text-base mb-10" style="color: #64748b; line-height: 1.8;" data-animate="fade-up" data-delay="0.2">
                    {{ __('donation.merci_sub') }}
                </p>
            @endif

            {{-- Receipt card --}}
            @if ($donation)
            <div class="rounded-2xl p-6 mb-8 text-left"
                 style="background-color: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 24px rgba(20,60,100,0.06);"
                 data-animate="fade-up" data-delay="0.25">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_amount') }}
                        </p>
                        <p class="text-2xl font-bold" style="color: #c80078; font-family:'Playfair Display',serif;">
                            {{ number_format((float) $donation->amount, 2, ',', ' ') }} €
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                            {{ __('donation.merci_status_label') }}
                        </p>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold"
                             style="{{ $isSuccess ? 'background-color:#f0fdf4; color:#16a34a;' : 'background-color:#fef3c7; color:#d97706;' }}">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                            {{ $isSuccess ? __('donation.merci_status_completed') : __('donation.merci_status_pending') }}
                        </div>
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
                        <p class="text-sm font-mono" style="color: #143c64;">{{ $donation->tx_ref }}</p>
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

            {{-- Social share (only for completed) --}}
            @if ($isSuccess)
            <div class="mb-10" data-animate="fade-up" data-delay="0.35">
                <p class="text-xs font-bold tracking-widest uppercase mb-4" style="color: #94a3b8;">
                    {{ __('donation.merci_share_heading') }}
                </p>
                <div class="flex items-center justify-center gap-3">

                    {{-- Twitter/X --}}
                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                       style="background-color: #000000; color: #ffffff;"
                       aria-label="Partager sur X (Twitter)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.258 5.63 5.906-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        <span class="hidden sm:inline">Twitter / X</span>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                       style="background-color: #1877f2; color: #ffffff;"
                       aria-label="Partager sur Facebook">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="hidden sm:inline">Facebook</span>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ $shareText }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                       style="background-color: #25d366; color: #ffffff;"
                       aria-label="Partager sur WhatsApp">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="hidden sm:inline">WhatsApp</span>
                    </a>

                </div>
            </div>
            @endif

            {{-- CTA buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-animate="fade-up" data-delay="0.4">
                <a href="{{ route('public.home') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #143c64; color: #ffffff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    {{ __('donation.merci_back_home') }}
                </a>
                <a href="{{ route('public.programs') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
                   style="background-color: #c80078; color: #ffffff;">
                    {{ __('donation.merci_see_programmes') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

        @endif

    </div>
</section>

@endsection
