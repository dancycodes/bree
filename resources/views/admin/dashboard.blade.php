@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')
    <div x-data class="space-y-6">

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

        {{-- Metrics (auto-refreshed every 60s) --}}
        @fragment('metrics')
        <div id="metrics"
             x-interval.60s.visible="$action.post('{{ route('admin.dashboard.refresh') }}', { include: [] })">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Donations this month --}}
                @if ($canViewDonations)
                    <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm" style="border: 1px solid #fce7f3;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background-color: rgba(200,0,120,0.08);">
                            <svg class="w-5 h-5" fill="none" stroke="#c80078" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-2xl font-bold truncate" style="color: #1e293b;">
                                {{ number_format($donationsTotalMonth, 0, ',', ' ') }}
                                <span class="text-sm font-medium" style="color: #94a3b8;">XAF</span>
                            </p>
                            <p class="text-xs mt-0.5" style="color: #94a3b8;">Dons ce mois</p>
                        </div>
                    </div>

                    {{-- All-time donations --}}
                    <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm" style="border: 1px solid #fce7f3;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background-color: rgba(200,0,120,0.05);">
                            <svg class="w-5 h-5" fill="none" stroke="#c80078" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-2xl font-bold truncate" style="color: #1e293b;">
                                {{ number_format($donationsTotalAllTime, 0, ',', ' ') }}
                                <span class="text-sm font-medium" style="color: #94a3b8;">XAF</span>
                            </p>
                            <p class="text-xs mt-0.5" style="color: #94a3b8;">Total des dons</p>
                        </div>
                    </div>

                    {{-- Pledges pending --}}
                    <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm" style="border: 1px solid #fef9ec;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background-color: rgba(200,160,60,0.1);">
                            <svg class="w-5 h-5" fill="none" stroke="#c8a03c" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold" style="color: #1e293b;">{{ $pledgesPending }}</p>
                            <p class="text-xs mt-0.5" style="color: #94a3b8;">Promesses en attente</p>
                        </div>
                    </div>
                @endif

                {{-- Unread messages --}}
                <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm" style="border: 1px solid #eff6ff;">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background-color: rgba(59,130,246,0.08);">
                        <svg class="w-5 h-5" fill="none" stroke="#3b82f6" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold" style="color: #1e293b;">{{ $unreadMessages }}</p>
                        <p class="text-xs mt-0.5" style="color: #94a3b8;">Messages non lus</p>
                    </div>
                </div>

                {{-- Upcoming events --}}
                <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm" style="border: 1px solid #ecfdf5;">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background-color: rgba(16,185,129,0.08);">
                        <svg class="w-5 h-5" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold" style="color: #1e293b;">{{ $upcomingEvents }}</p>
                        <p class="text-xs mt-0.5" style="color: #94a3b8;">Événements à venir</p>
                    </div>
                </div>

            </div>
        </div>
        @endfragment

        {{-- Bottom row: Activity + Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Recent activity --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                <div class="px-5 py-4" style="border-bottom: 1px solid #f1f5f9;">
                    <h3 class="text-sm font-semibold" style="color: #1e293b;">Activité récente</h3>
                </div>
                @if ($recentActivity->isEmpty())
                    <div class="py-10 text-center">
                        <p class="text-sm" style="color: #94a3b8;">Aucune activité pour le moment.</p>
                    </div>
                @else
                    <ul class="divide-y" style="border-color: #f8fafc;">
                        @foreach ($recentActivity as $activity)
                            <li class="px-5 py-3.5 flex items-start gap-3">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                                     style="background-color: rgba(20,60,100,0.08);">
                                    <span class="text-xs font-bold" style="color: #143c64;">
                                        {{ strtoupper(substr($activity->causer?->name ?? 'S', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm truncate" style="color: #374151;">
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                        {{ $activity->causer?->name ?? 'Système' }}
                                        · {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Quick actions --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                <div class="px-5 py-4" style="border-bottom: 1px solid #f1f5f9;">
                    <h3 class="text-sm font-semibold" style="color: #1e293b;">Actions rapides</h3>
                </div>
                <div class="p-4 flex flex-col gap-2">
                    @can('news.create')
                        <a href="{{ route('admin.news.create') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                           style="background-color: #c80078;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nouvel article
                        </a>
                    @endcan
                    @can('events.create')
                        <a href="{{ route('admin.events.create') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold"
                           style="background-color: rgba(20,60,100,0.06); color: #143c64;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nouvel événement
                        </a>
                    @endcan
                    @can('messages.view')
                        <a href="{{ route('admin.messages.index') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold"
                           style="background-color: rgba(59,130,246,0.06); color: #1d4ed8;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Voir les messages
                            @if ($unreadMessages > 0)
                                <span class="ml-auto inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold text-white"
                                      style="background-color: #c80078;">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    @endcan
                    @can('newsletter.view')
                        <a href="{{ route('admin.newsletter.index') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold"
                           style="background-color: rgba(16,185,129,0.06); color: #065f46;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            Newsletter
                        </a>
                    @endcan
                </div>
            </div>

        </div>

    </div>
@endsection
