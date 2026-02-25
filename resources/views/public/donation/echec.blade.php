@extends('layouts.public')

@section('title', 'Paiement échoué — ' . config('app.name'))

@section('content')

<section class="min-h-screen flex items-center justify-center py-24" style="background-color: #f8f5f0;">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- X icon --}}
        <div class="w-20 h-20 rounded-full mx-auto mb-8 flex items-center justify-center"
             style="background-color: #fff5f5; border: 3px solid #ef4444;" data-animate="scale-in">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                 style="color: #ef4444;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>

        {{-- Heading --}}
        <h1 class="text-3xl lg:text-4xl font-bold mb-4"
            style="color: #c80078; font-family: 'Playfair Display', serif;"
            data-animate="fade-up" data-delay="0.1">
            Paiement non effectué
        </h1>

        {{-- Reason --}}
        @if ($reason)
            <p class="text-sm mb-4 px-4 py-3 rounded-xl inline-block"
               style="background-color: #fff5f5; color: #b91c1c; border: 1px solid #fecaca;"
               data-animate="fade-up" data-delay="0.15">
                {{ $reason }}
            </p>
        @endif

        <p class="text-base mb-8" style="color: #64748b; line-height: 1.8;"
           data-animate="fade-up" data-delay="0.2">
            Votre paiement n'a pas pu être traité. Aucun montant n'a été débité de votre compte.
            Vous pouvez réessayer ou choisir une autre façon de soutenir notre mission.
        </p>

        {{-- Reference --}}
        @if ($txRef)
            <p class="text-xs mb-8" style="color: #94a3b8;" data-animate="fade-up" data-delay="0.25">
                Référence de transaction : <span class="font-mono" style="color: #143c64;">{{ $txRef }}</span>
            </p>
        @endif

        {{-- 3 action buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4"
             data-animate="fade-up" data-delay="0.3">

            {{-- Retry --}}
            <a href="{{ route('public.donate') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
               style="background-color: #c80078; color: #ffffff;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Réessayer
            </a>

            {{-- Pledge --}}
            <a href="{{ route('public.donate') }}#promesse"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
               style="background-color: #143c64; color: #ffffff;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Faire une Promesse de Don
            </a>

            {{-- Home --}}
            <a href="{{ route('public.home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
               style="background-color: #f1f5f9; color: #475569;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Retour à l'accueil
            </a>

        </div>

    </div>
</section>

@endsection
