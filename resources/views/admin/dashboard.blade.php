@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')
    <div class="space-y-6">
        {{-- Welcome banner --}}
        <div class="rounded-2xl p-6 text-white relative overflow-hidden" style="background-color: #143c64;">
            <div class="relative z-10">
                <h2 class="text-xl font-bold mb-1" style="font-family: 'Playfair Display', serif;">
                    Bienvenue, {{ auth()->user()?->name }} 👋
                </h2>
                <p class="text-sm" style="color: rgba(255,255,255,0.7);">
                    Panneau d'administration — Fondation BREE
                </p>
            </div>
            <div class="absolute right-6 top-1/2 -translate-y-1/2 opacity-10">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-24 w-24 object-contain">
            </div>
        </div>

        {{-- Placeholder stats grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Total des dons', 'value' => '–', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => '#c80078', 'bg' => '#fdf2f8'],
                ['label' => 'Promesses en attente', 'value' => '–', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#c8a03c', 'bg' => '#fffbeb'],
                ['label' => 'Messages non lus', 'value' => '–', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                ['label' => 'Événements à venir', 'value' => '–', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => '#10b981', 'bg' => '#ecfdf5'],
            ] as $stat)
                <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background-color: {{ $stat['bg'] }};">
                        <svg class="w-5 h-5" fill="none" stroke="{{ $stat['color'] }}" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold" style="color: #1e293b;">{{ $stat['value'] }}</p>
                        <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Quick actions --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <h3 class="text-sm font-semibold mb-4" style="color: #64748b;">Actions rapides</h3>
            <div class="flex flex-wrap gap-2">
                @if (Route::has('admin.news.create') && auth()->user()?->can('news.create'))
                    <a href="{{ route('admin.news.create') }}" class="btn-primary text-xs py-2 px-4 rounded-lg">+ Nouvel article</a>
                @endif
                @if (Route::has('admin.events.create') && auth()->user()?->can('events.create'))
                    <a href="{{ route('admin.events.create') }}" class="btn-outline text-xs py-2 px-4 rounded-lg">+ Nouvel événement</a>
                @endif
                @if (Route::has('admin.donations.index') && auth()->user()?->can('donations.view'))
                    <a href="{{ route('admin.donations.index') }}" class="btn-outline text-xs py-2 px-4 rounded-lg">Voir les dons</a>
                @endif
            </div>
        </div>
    </div>
@endsection
