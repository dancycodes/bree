@extends('layouts.public')

@section('title', __('donation.merci_heading') . ' — ' . config('app.name'))

@section('content')

<section class="min-h-screen flex items-center justify-center py-24" style="background-color: #f8f5f0;">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- Success icon --}}
        <div class="w-20 h-20 rounded-full mx-auto mb-8 flex items-center justify-center"
             style="background-color: #fff0f8; border: 3px solid #c80078;">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                 style="color: #c80078;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>

        <h1 class="text-3xl lg:text-4xl font-bold mb-4"
            style="color: #143c64; font-family: 'Playfair Display', serif;">
            {{ __('donation.merci_heading') }}
        </h1>

        <p class="text-base mb-10" style="color: #64748b; line-height: 1.8;">
            {{ __('donation.merci_sub') }}
        </p>

        @if ($donation)
        <div class="rounded-2xl p-6 mb-8 text-left"
             style="background-color: #ffffff; border: 1px solid #e2e8f0;">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

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
                        Statut
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold"
                         style="{{ $donation->isCompleted() ? 'background-color:#f0fdf4; color:#16a34a;' : 'background-color:#fef3c7; color:#d97706;' }}">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                        {{ $donation->isCompleted() ? __('donation.merci_status_completed') : __('donation.merci_status_pending') }}
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                        {{ __('donation.merci_reference') }}
                    </p>
                    <p class="text-sm font-mono" style="color: #143c64;">{{ $donation->tx_ref }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color: #94a3b8;">
                        Email
                    </p>
                    <p class="text-sm" style="color: #143c64;">{{ $donation->donor_email }}</p>
                </div>

            </div>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('public.home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
               style="background-color: #143c64; color: #ffffff;">
                {{ __('donation.merci_back_home') }}
            </a>
            <a href="{{ route('public.programs') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-opacity hover:opacity-90"
               style="background-color: #c80078; color: #ffffff;">
                {{ __('donation.merci_see_programmes') }}
            </a>
        </div>

    </div>
</section>

@endsection
