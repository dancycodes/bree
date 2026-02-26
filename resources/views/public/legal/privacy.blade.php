@extends('layouts.public')

@section('title', __('footer.privacy_policy') . ' — ' . config('app.name'))
@section('meta_description', config('app.name') . ' — ' . __('footer.privacy_policy'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(220px, 28vw, 320px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('footer.privacy_policy') }}"
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
                    <li style="color: #ffffff;">{{ __('footer.privacy_policy') }}</li>
                </ol>
            </nav>

            <h1 class="font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 2.75rem);
                       color: #ffffff;
                       line-height: 1.1;">
                {{ __('footer.privacy_policy') }}
            </h1>

        </div>
    </section>

    {{-- Placeholder — F-024 will replace this content --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-base leading-relaxed" style="color: #4a5568;">
                Cette page est en cours de rédaction. / This page is being drafted.
            </p>
        </div>
    </section>

@endsection
