@extends('layouts.admin')

@section('title', __('Candidatures'))
@section('page_title', __('Candidatures'))
@section('breadcrumb', __('Candidatures'))

@section('content')

    <div class="max-w-4xl">

        {{-- Page description --}}
        <p class="text-sm mb-6" style="color: #64748b;">
            {{ __('Retrouvez ici toutes les candidatures de benevoles et de partenariats recues.') }}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Volunteer Applications Card --}}
            <a href="{{ route('admin.applications.volunteers.index') }}"
               class="block bg-white rounded-2xl shadow-sm overflow-hidden transition-shadow hover:shadow-md"
               style="border: 1px solid #e2e8f0;">
                <div class="px-6 py-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                 style="background-color: rgba(200,0,120,0.1);">
                                <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold" style="color: #1e293b;">{{ __('Benevoles') }}</h3>
                                <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ __('Candidatures de benevoles') }}</p>
                            </div>
                        </div>
                        @if ($volunteerPending > 0)
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full text-xs font-bold"
                                  style="background-color: #c80078; color: #ffffff;">
                                {{ $volunteerPending }}
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-2xl font-bold" style="color: #143c64; font-family: 'Playfair Display', serif;">{{ $volunteerTotal }}</span>
                        <span class="text-xs" style="color: #94a3b8;">{{ __('candidature(s) au total') }}</span>
                    </div>
                    @if ($volunteerPending > 0)
                        <p class="mt-2 text-xs font-medium" style="color: #c80078;">
                            {{ $volunteerPending }} {{ __('en attente de traitement') }}
                        </p>
                    @else
                        <p class="mt-2 text-xs" style="color: #94a3b8;">
                            {{ __('Aucune candidature en attente') }}
                        </p>
                    @endif
                </div>
                <div class="px-6 py-3 flex items-center justify-between" style="background-color: #f8fafc; border-top: 1px solid #f1f5f9;">
                    <span class="text-xs font-medium" style="color: #c80078;">{{ __('Voir les candidatures') }}</span>
                    <svg class="w-4 h-4" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Partnership Applications Card --}}
            <a href="{{ route('admin.partnerships.index') }}"
               class="block bg-white rounded-2xl shadow-sm overflow-hidden transition-shadow hover:shadow-md"
               style="border: 1px solid #e2e8f0;">
                <div class="px-6 py-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                 style="background-color: rgba(20,60,100,0.1);">
                                <svg class="w-5 h-5" style="color: #143c64;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold" style="color: #1e293b;">{{ __('Partenariats') }}</h3>
                                <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ __('Demandes de partenariat') }}</p>
                            </div>
                        </div>
                        @if ($partnershipPending > 0)
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full text-xs font-bold"
                                  style="background-color: #c80078; color: #ffffff;">
                                {{ $partnershipPending }}
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex items-baseline gap-2">
                        <span class="text-2xl font-bold" style="color: #143c64; font-family: 'Playfair Display', serif;">{{ $partnershipTotal }}</span>
                        <span class="text-xs" style="color: #94a3b8;">{{ __('demande(s) au total') }}</span>
                    </div>
                    @if ($partnershipPending > 0)
                        <p class="mt-2 text-xs font-medium" style="color: #c80078;">
                            {{ $partnershipPending }} {{ __('en attente de traitement') }}
                        </p>
                    @else
                        <p class="mt-2 text-xs" style="color: #94a3b8;">
                            {{ __('Aucune demande en attente') }}
                        </p>
                    @endif
                </div>
                <div class="px-6 py-3 flex items-center justify-between" style="background-color: #f8fafc; border-top: 1px solid #f1f5f9;">
                    <span class="text-xs font-medium" style="color: #143c64;">{{ __('Voir les demandes') }}</span>
                    <svg class="w-4 h-4" style="color: #143c64;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>

    </div>

@endsection
