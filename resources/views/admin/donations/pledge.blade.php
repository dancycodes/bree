@extends('layouts.admin')

@section('title', 'Promesse de don')
@section('page_title', 'Promesse de don')
@section('breadcrumb', 'Dons › Promesses › ' . $pledge->fullName())

@section('content')

    @php
        $statusLabels = [
            'pending' => ['label' => 'En attente', 'bg' => 'rgba(234,179,8,0.12)', 'color' => '#854d0e'],
            'confirmed' => ['label' => 'Confirmée', 'bg' => 'rgba(20,60,100,0.1)', 'color' => '#143c64'],
            'fulfilled' => ['label' => 'Honorée', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#15803d'],
        ];
        $statusMeta = $statusLabels[$pledge->status] ?? ['label' => $pledge->status, 'bg' => '#f1f5f9', 'color' => '#64748b'];
    @endphp

    <div x-data="{ status: '{{ $pledge->status }}', adminNotes: {{ Js::from($pledge->admin_notes ?? '') }} }">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: donor info + details --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Donor info --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Informations du donateur</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Nom complet</dt>
                            <dd class="text-sm font-medium" style="color: #1e293b;">{{ $pledge->fullName() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Email</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->email ?: '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Téléphone</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->phone ?: '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Adresse</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->address ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Donation details --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Détails de la promesse</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Montant promis</dt>
                            <dd class="text-lg font-bold" style="color: #c80078;">
                                @if ($pledge->amount)
                                    {{ number_format((float) $pledge->amount, 0, ',', ' ') }} {{ $pledge->currency }}
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Nature du don</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->nature ?: '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Programme</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->programme ?: '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Date de soumission</dt>
                            <dd class="text-sm" style="color: #374151;">{{ $pledge->created_at->format('d/m/Y à H:i') }}</dd>
                        </div>
                        @if ($pledge->message)
                            <div class="sm:col-span-2">
                                <dt class="text-xs font-medium uppercase tracking-wide mb-1" style="color: #94a3b8;">Message</dt>
                                <dd class="text-sm" style="color: #374151;">{{ $pledge->message }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Internal notes --}}
                @can('donations.edit')
                    <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                        <h3 class="text-sm font-semibold mb-3" style="color: #1e293b;">Notes internes</h3>
                        <textarea x-model="adminNotes"
                                  rows="4"
                                  placeholder="Ajouter des notes internes (non visibles par le donateur)…"
                                  class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                                  style="border: 1px solid #e2e8f0; outline: none; color: #374151;"></textarea>
                    </div>
                @endcan

                {{-- Activity log --}}
                @if ($activity->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                        <h3 class="text-sm font-semibold mb-3" style="color: #1e293b;">Historique</h3>
                        <ul class="space-y-3">
                            @foreach ($activity as $entry)
                                <li class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold text-white mt-0.5"
                                         style="background-color: #143c64;">
                                        {{ substr($entry->causer?->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm" style="color: #374151;">{{ $entry->description }}</p>
                                        <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                            {{ $entry->causer?->name ?? 'Système' }} · {{ $entry->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Right: status actions --}}
            <div class="space-y-4">

                {{-- Current status --}}
                <div class="bg-white rounded-2xl shadow-sm p-5" style="border: 1px solid #e2e8f0;">
                    <p class="text-xs font-semibold uppercase tracking-wide mb-3" style="color: #94a3b8;">Statut actuel</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                          style="background-color: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }};">
                        {{ $statusMeta['label'] }}
                    </span>
                </div>

                {{-- Status actions --}}
                @can('donations.edit')
                    <div class="bg-white rounded-2xl shadow-sm p-5 space-y-2" style="border: 1px solid #e2e8f0;">
                        <p class="text-xs font-semibold uppercase tracking-wide mb-3" style="color: #94a3b8;">Actions</p>

                        <button x-show="status === 'pending'"
                                @click="status='confirmed'; $action.patch('{{ route('admin.donations.pledge.status', $pledge) }}', { include: ['status','adminNotes'] })"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                                style="background-color: #143c64;">
                            <span x-show="!$fetching()">Confirmer la promesse</span>
                            <span x-show="$fetching()">En cours…</span>
                        </button>

                        <button x-show="status === 'confirmed'"
                                @click="status='fulfilled'; $action.patch('{{ route('admin.donations.pledge.status', $pledge) }}', { include: ['status','adminNotes'] })"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                                style="background-color: #15803d;">
                            <span x-show="!$fetching()">Marquer comme honorée</span>
                            <span x-show="$fetching()">En cours…</span>
                        </button>

                        <button x-show="status !== 'pending'"
                                @click="status='pending'; $action.patch('{{ route('admin.donations.pledge.status', $pledge) }}', { include: ['status','adminNotes'] })"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                                style="background-color: #f1f5f9; color: #64748b;">
                            Remettre en attente
                        </button>

                        <button @click="$action.patch('{{ route('admin.donations.pledge.status', $pledge) }}', { include: ['status','adminNotes'] })"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                                style="background-color: #f1f5f9; color: #475569;">
                            <span x-show="!$fetching()">Enregistrer les notes</span>
                            <span x-show="$fetching()">…</span>
                        </button>
                    </div>
                @endcan

                {{-- Back --}}
                <a href="{{ route('admin.donations.index') }}"
                   class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                   style="background-color: #f1f5f9; color: #475569;">
                    ← Retour aux dons
                </a>
            </div>
        </div>
    </div>

@endsection
