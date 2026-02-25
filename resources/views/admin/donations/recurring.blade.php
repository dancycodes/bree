@extends('layouts.admin')

@section('title', 'Dons récurrents')
@section('page_title', 'Dons récurrents')
@section('breadcrumb', 'Dons › Récurrents')

@section('content')

    <div x-data="{ status: '', search: '', confirmId: null }" x-sync="['status','search']">

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-4 flex flex-wrap items-center gap-3" style="border: 1px solid #e2e8f0;">
            <div class="flex-1 min-w-48">
                <input type="text" x-model="search"
                       @input.debounce.400ms="$action.post('{{ route('admin.donations.recurring.index') }}', { include: ['status','search'] })"
                       placeholder="Rechercher par nom ou email…"
                       class="w-full px-3.5 py-2 rounded-xl text-sm"
                       style="border: 1px solid #e2e8f0; outline: none;">
            </div>
            <select x-model="status"
                    @change="$action.post('{{ route('admin.donations.recurring.index') }}', { include: ['status','search'] })"
                    class="px-3.5 py-2 rounded-xl text-sm"
                    style="border: 1px solid #e2e8f0; outline: none; color: #374151;">
                <option value="">Tous les statuts</option>
                <option value="active">Actif</option>
                <option value="cancelled">Annulé</option>
            </select>
        </div>

        {{-- Confirm cancellation modal --}}
        <div x-show="confirmId !== null"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="background-color: rgba(0,0,0,0.5);">
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full" style="border: 1px solid #e2e8f0;">
                <h3 class="text-base font-semibold mb-2" style="color: #1e293b;">Confirmer l'annulation</h3>
                <p class="text-sm mb-5" style="color: #64748b;">Cette action est irréversible. L'abonnement Flutterwave sera annulé et le donateur sera notifié.</p>
                <div class="flex gap-2">
                    <button @click="$action.post(`/admin/dons/recurrants/${confirmId}/annuler`, { include: [] }); confirmId = null"
                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                            style="background-color: #dc2626;">
                        Confirmer l'annulation
                    </button>
                    <button @click="confirmId = null"
                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                            style="background-color: #f1f5f9; color: #475569;">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        @fragment('recurring-list')
        <div id="recurring-list">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                @if ($donations->isEmpty())
                    <div class="py-16 text-center">
                        <p class="text-sm" style="color: #94a3b8;">Aucun don récurrent pour le moment</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Donateur</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Montant</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide hidden sm:table-cell" style="color: #94a3b8;">Fréquence</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide hidden md:table-cell" style="color: #94a3b8;">Programme</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide hidden lg:table-cell" style="color: #94a3b8;">Depuis</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $donation)
                                    @php
                                        $statusMeta = match ($donation->status) {
                                            'active' => ['label' => 'Actif', 'bg' => 'rgba(20,60,100,0.1)', 'color' => '#143c64'],
                                            'cancelled' => ['label' => 'Annulé', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b'],
                                            default => ['label' => $donation->status, 'bg' => '#f1f5f9', 'color' => '#94a3b8'],
                                        };
                                    @endphp
                                    <tr style="border-bottom: 1px solid #f8fafc;">
                                        <td class="px-4 py-3">
                                            <p class="font-medium" style="color: #1e293b;">{{ $donation->donor_name ?: '—' }}</p>
                                            <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $donation->donor_email ?: '—' }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold" style="color: #1e293b;">
                                            {{ number_format((float) $donation->amount, 0, ',', ' ') }}
                                            <span class="text-xs font-normal" style="color: #94a3b8;">{{ $donation->currency }}</span>
                                        </td>
                                        <td class="px-4 py-3 hidden sm:table-cell" style="color: #64748b;">{{ $donation->frequency ?: '—' }}</td>
                                        <td class="px-4 py-3 hidden md:table-cell" style="color: #64748b;">{{ $donation->programme ?: '—' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                  style="background-color: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }};">
                                                {{ $statusMeta['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-xs hidden lg:table-cell" style="color: #94a3b8;">
                                            {{ $donation->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            @can('donations.edit')
                                                @if ($donation->status !== 'cancelled')
                                                    <button @click="confirmId = {{ $donation->id }}"
                                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors hover:bg-red-50"
                                                            style="color: #dc2626; border: 1px solid rgba(220,38,38,0.2);">
                                                        Annuler
                                                    </button>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($donations->hasPages())
                        <div class="px-4 py-3 flex items-center justify-between" style="border-top: 1px solid #f1f5f9;">
                            <p class="text-xs" style="color: #94a3b8;">
                                {{ $donations->firstItem() }}–{{ $donations->lastItem() }} sur {{ $donations->total() }}
                            </p>
                            <div class="flex items-center gap-1">
                                @if ($donations->onFirstPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-sm" style="color: #cbd5e1;">‹</span>
                                @else
                                    <a href="{{ $donations->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm hover:bg-slate-100" style="color: #64748b;">‹</a>
                                @endif
                                @if ($donations->hasMorePages())
                                    <a href="{{ $donations->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm hover:bg-slate-100" style="color: #64748b;">›</a>
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
