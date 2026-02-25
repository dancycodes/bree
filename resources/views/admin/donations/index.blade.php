@extends('layouts.admin')

@section('title', 'Dons')
@section('page_title', 'Dons')
@section('breadcrumb', 'Dons')

@section('content')

    <div x-data="{ type: 'all', status: '', search: '' }" x-sync="['type','status','search']">

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-4 flex flex-wrap items-center gap-3" style="border: 1px solid #e2e8f0;">

            {{-- Search --}}
            <div class="flex-1 min-w-48">
                <input type="text" x-model="search"
                       @input.debounce.400ms="$action('{{ route('admin.donations.index') }}', { include: ['type','status','search'] })"
                       placeholder="Rechercher par nom ou email…"
                       class="w-full px-3.5 py-2 rounded-xl text-sm"
                       style="border: 1px solid #e2e8f0; outline: none;">
            </div>

            {{-- Type filter --}}
            <select x-model="type"
                    @change="$action('{{ route('admin.donations.index') }}', { include: ['type','status','search'] })"
                    class="px-3.5 py-2 rounded-xl text-sm"
                    style="border: 1px solid #e2e8f0; outline: none; color: #374151;">
                <option value="all">Tous les types</option>
                <option value="direct">Ponctuel</option>
                <option value="recurring">Récurrent</option>
                <option value="pledge">Promesse de don</option>
                <option value="inkind">Don en nature</option>
            </select>

            {{-- Status filter --}}
            <select x-model="status"
                    @change="$action('{{ route('admin.donations.index') }}', { include: ['type','status','search'] })"
                    class="px-3.5 py-2 rounded-xl text-sm"
                    style="border: 1px solid #e2e8f0; outline: none; color: #374151;">
                <option value="">Tous les statuts</option>
                <option value="completed">Complété</option>
                <option value="pending">En attente</option>
                <option value="failed">Échoué</option>
                <option value="active">Actif</option>
                <option value="cancelled">Annulé</option>
            </select>

            {{-- Export --}}
            @can('donations.export')
                @if (Route::has('admin.donations.export'))
                    <a href="{{ route('admin.donations.export') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-sm font-semibold text-white"
                       style="background-color: #143c64;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Exporter CSV
                    </a>
                @endif
            @endcan
        </div>

        {{-- Table --}}
        @fragment('donations-list')
        <div id="donations-list">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                @if ($donations->isEmpty())
                    <div class="py-16 text-center">
                        <p class="text-sm" style="color: #94a3b8;">Aucun don reçu pour le moment</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Donateur</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Type</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Montant</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide hidden sm:table-cell" style="color: #94a3b8;">Programme</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide hidden md:table-cell" style="color: #94a3b8;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $donation)
                                    @php
                                        $typeLabels = [
                                            'direct' => ['label' => 'Ponctuel', 'bg' => 'rgba(200,0,120,0.1)', 'color' => '#c80078'],
                                            'recurring' => ['label' => 'Récurrent', 'bg' => 'rgba(20,60,100,0.1)', 'color' => '#143c64'],
                                            'pledge' => ['label' => 'Promesse', 'bg' => 'rgba(200,160,60,0.15)', 'color' => '#b8900a'],
                                            'inkind' => ['label' => 'Nature', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#15803d'],
                                        ];
                                        $statusLabels = [
                                            'completed' => ['label' => 'Complété', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#15803d'],
                                            'pending' => ['label' => 'En attente', 'bg' => 'rgba(234,179,8,0.12)', 'color' => '#854d0e'],
                                            'pending_review' => ['label' => 'En révision', 'bg' => 'rgba(234,179,8,0.12)', 'color' => '#854d0e'],
                                            'failed' => ['label' => 'Échoué', 'bg' => 'rgba(220,38,38,0.1)', 'color' => '#dc2626'],
                                            'active' => ['label' => 'Actif', 'bg' => 'rgba(20,60,100,0.1)', 'color' => '#143c64'],
                                            'cancelled' => ['label' => 'Annulé', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b'],
                                        ];
                                        $typeMeta = $typeLabels[$donation['type']] ?? ['label' => $donation['type'], 'bg' => '#f1f5f9', 'color' => '#64748b'];
                                        $statusMeta = $statusLabels[$donation['status']] ?? ['label' => $donation['status'], 'bg' => '#f1f5f9', 'color' => '#64748b'];
                                    @endphp
                                    <tr style="border-bottom: 1px solid #f8fafc;">
                                        <td class="px-4 py-3">
                                            <p class="font-medium" style="color: #1e293b;">{{ $donation['donor_name'] ?: '—' }}</p>
                                            <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $donation['donor_email'] ?: '—' }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                  style="background-color: {{ $typeMeta['bg'] }}; color: {{ $typeMeta['color'] }};">
                                                {{ $typeMeta['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold" style="color: #1e293b;">
                                            @if ($donation['amount'])
                                                {{ number_format((float) $donation['amount'], 0, ',', ' ') }}
                                                <span class="text-xs font-normal" style="color: #94a3b8;">{{ $donation['currency'] }}</span>
                                            @else
                                                <span style="color: #94a3b8;">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 hidden sm:table-cell" style="color: #64748b;">
                                            {{ $donation['programme'] ?: '—' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                  style="background-color: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }};">
                                                {{ $statusMeta['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-xs hidden md:table-cell" style="color: #94a3b8;">
                                            {{ $donation['date']?->format('d/m/Y') ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($donations->hasPages())
                        <div class="px-4 py-3 flex items-center justify-between" style="border-top: 1px solid #f1f5f9;">
                            <p class="text-xs" style="color: #94a3b8;">
                                {{ $donations->firstItem() }}–{{ $donations->lastItem() }} sur {{ $donations->total() }}
                            </p>
                            <div class="flex items-center gap-1">
                                @if ($donations->onFirstPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-sm" style="color: #cbd5e1;">‹</span>
                                @else
                                    <a href="{{ $donations->previousPageUrl() }}"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-sm transition-colors hover:bg-slate-100"
                                       style="color: #64748b;">‹</a>
                                @endif
                                @if ($donations->hasMorePages())
                                    <a href="{{ $donations->nextPageUrl() }}"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-sm transition-colors hover:bg-slate-100"
                                       style="color: #64748b;">›</a>
                                @else
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-sm" style="color: #cbd5e1;">›</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endfragment

    </div>

@endsection
