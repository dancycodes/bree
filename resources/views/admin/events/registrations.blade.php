@extends('layouts.admin')

@section('title', 'Inscriptions — ' . $event->title_fr)
@section('page_title', 'Inscriptions')
@section('breadcrumb', 'Événements › ' . $event->title_fr . ' › Inscriptions')

@section('content')

    <div x-data>

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold" style="color: #1e293b;">{{ $event->title_fr }}</h2>
                <p class="text-xs mt-0.5" style="color: #94a3b8;">
                    {{ $registrations->count() }} inscription(s)
                    @if ($event->max_capacity)
                        · capacité {{ $event->max_capacity }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                @if ($registrations->isNotEmpty())
                    <a href="{{ route('admin.events.registrations.export', $event) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                       style="background-color: #f1f5f9; color: #475569;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Exporter CSV
                    </a>
                @endif
                <a href="{{ route('admin.events.edit', $event) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                   style="background-color: #c80078;">
                    Modifier l'événement
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            @if ($registrations->isEmpty())
                <div class="py-16 text-center">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4"
                         style="background-color: #f8f5f0;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium" style="color: #1e293b;">Aucune inscription pour le moment</p>
                    <p class="text-xs mt-1" style="color: #94a3b8;">Les inscriptions apparaîtront ici une fois soumises.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider"
                                style="color: #94a3b8;">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider"
                                style="color: #94a3b8;">Nom</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider"
                                style="color: #94a3b8;">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden sm:table-cell"
                                style="color: #94a3b8;">Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #f8fafc;">
                        @foreach ($registrations as $i => $reg)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-xs font-mono" style="color: #94a3b8;">
                                    {{ $i + 1 }}
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-medium" style="color: #1e293b;">{{ $reg->name }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="mailto:{{ $reg->email }}"
                                       class="text-sm hover:underline" style="color: #475569;">
                                        {{ $reg->email }}
                                    </a>
                                </td>
                                <td class="px-4 py-4 text-xs hidden sm:table-cell" style="color: #64748b;">
                                    {{ $reg->created_at->format('d/m/Y à H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-3 border-t flex items-center justify-between" style="border-color: #f1f5f9;">
                    <p class="text-xs" style="color: #94a3b8;">
                        {{ $registrations->count() }} inscrit(s) au total
                    </p>
                    @if ($event->max_capacity)
                        @php
                            $pct = min(100, round($registrations->count() / $event->max_capacity * 100));
                        @endphp
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-1.5 rounded-full overflow-hidden" style="background-color: #f1f5f9;">
                                <div class="h-full rounded-full transition-all"
                                     style="width: {{ $pct }}%; background-color: {{ $pct >= 100 ? '#ef4444' : '#c80078' }};"></div>
                            </div>
                            <span class="text-xs" style="color: #64748b;">
                                {{ $registrations->count() }}/{{ $event->max_capacity }}
                            </span>
                        </div>
                    @endif
                </div>
            @endif

        </div>

        {{-- Nav --}}
        <div class="mt-4">
            <a href="{{ route('admin.events.index') }}"
               class="text-xs font-semibold" style="color: #94a3b8;">
                ← Liste des événements
            </a>
        </div>

    </div>

@endsection
