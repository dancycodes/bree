@extends('layouts.admin')

@section('title', 'Candidatures bénévoles')
@section('page_title', 'Candidatures bénévoles')
@section('breadcrumb', 'Candidatures › Bénévoles')

@section('content')

    {{-- Sub-navigation --}}
    <div class="flex items-center gap-1 mb-6 bg-white rounded-2xl shadow-sm p-1.5" style="border: 1px solid #e2e8f0; width: fit-content;">
        <a href="{{ route('admin.applications.volunteers.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold"
           style="background-color: #143c64; color: #ffffff;">
            Bénévoles
        </a>
        <a href="{{ route('admin.partnerships.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold"
           style="color: #64748b;">
            Partenariats
        </a>
    </div>

    <div x-data class="flex gap-6 items-start">

        {{-- ── Left: Applications List ── --}}
        @fragment('applications-list')
        <div id="applications-list" class="flex-1 min-w-0">

            {{-- Header with filters + export --}}
            <div class="flex items-center justify-between mb-4 gap-3 flex-wrap">
                <div x-data="{ status: '', search: '' }" x-sync="['status','search']" class="flex flex-wrap items-center gap-3 flex-1">
                    <div class="flex-1 min-w-48">
                        <input type="text" x-model="search"
                               @input.debounce.400ms="$action.post('{{ route('admin.applications.volunteers.index') }}', { include: ['status','search'] })"
                               placeholder="Rechercher par nom ou email…"
                               class="w-full px-3.5 py-2 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;">
                    </div>
                    <select x-model="status"
                            @change="$action.post('{{ route('admin.applications.volunteers.index') }}', { include: ['status','search'] })"
                            class="px-3.5 py-2 rounded-xl text-sm"
                            style="border: 1px solid #e2e8f0; outline: none; color: #374151;">
                        <option value="">Tous les statuts</option>
                        <option value="pending">Nouveau</option>
                        <option value="reviewed">En cours</option>
                        <option value="accepted">Accepté</option>
                        <option value="rejected">Rejeté</option>
                    </select>
                </div>
                <a href="{{ route('admin.applications.export') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold flex-shrink-0"
                   style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exporter CSV
                </a>
            </div>

            {{-- Stats bar --}}
            <div class="flex items-center gap-3 mb-4">
                <p class="text-sm" style="color: #64748b;">
                    {{ $applications->total() }} candidature{{ $applications->total() !== 1 ? 's' : '' }}
                    @if ($pendingCount > 0)
                        <span class="ml-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold"
                              style="background-color: rgba(200,0,120,0.1); color: #c80078;">
                            {{ $pendingCount }} nouvelle{{ $pendingCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

                @if ($applications->isEmpty())
                    <div class="py-16 text-center">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="text-sm" style="color: #94a3b8;">Aucune candidature reçue</p>
                    </div>
                @else
                    <div class="divide-y" style="border-color: #f1f5f9;">
                        @foreach ($applications as $application)
                            @php
                                $statusMeta = match ($application->status) {
                                    'pending'  => ['label' => 'Nouveau', 'bg' => 'rgba(200,0,120,0.1)', 'color' => '#c80078'],
                                    'reviewed' => ['label' => 'En cours', 'bg' => 'rgba(20,60,100,0.1)', 'color' => '#143c64'],
                                    'accepted' => ['label' => 'Accepté', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#16a34a'],
                                    'rejected' => ['label' => 'Rejeté', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b'],
                                    default    => ['label' => $application->status, 'bg' => '#f1f5f9', 'color' => '#94a3b8'],
                                };
                                $areas = collect($application->areas_of_interest)
                                    ->map(fn($a) => match($a) { 'protege' => 'Protège', 'eleve' => 'Élève', 'respire' => 'Respire', default => $a })
                                    ->implode(', ');
                            @endphp
                            <div class="flex items-start gap-4 px-5 py-4 cursor-pointer transition-colors hover:bg-slate-50"
                                 @click="$action.post('{{ route('admin.applications.show', $application) }}', { include: [] })">

                                {{-- New dot --}}
                                <div class="flex-shrink-0 mt-1.5">
                                    @if ($application->status === 'pending')
                                        <span class="block w-2 h-2 rounded-full" style="background-color: #c80078;"></span>
                                    @else
                                        <span class="block w-2 h-2 rounded-full opacity-0"></span>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-baseline justify-between gap-2">
                                        <p class="text-sm truncate {{ $application->status === 'pending' ? 'font-bold' : 'font-medium' }}"
                                           style="color: {{ $application->status === 'pending' ? '#1e293b' : '#475569' }};">
                                            {{ $application->fullName() }}
                                        </p>
                                        <time class="text-xs flex-shrink-0" style="color: #94a3b8;">
                                            {{ $application->created_at->format('d/m/Y') }}
                                        </time>
                                    </div>
                                    <p class="text-xs truncate mt-0.5" style="color: #64748b;">
                                        {{ $application->email }}
                                        @if ($application->city_country)
                                            · {{ $application->city_country }}
                                        @endif
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs" style="color: #94a3b8;">{{ $areas }}</span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium"
                                              style="background-color: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }};">
                                            {{ $statusMeta['label'] }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    @if ($applications->hasPages())
                        <div class="px-5 py-4" style="border-top: 1px solid #f1f5f9;">
                            <div class="flex items-center justify-between">
                                <p class="text-xs" style="color: #94a3b8;">
                                    {{ $applications->firstItem() }}–{{ $applications->lastItem() }} sur {{ $applications->total() }}
                                </p>
                                <div class="flex items-center gap-1">
                                    @if ($applications->onFirstPage())
                                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-sm" style="color: #cbd5e1;">‹</span>
                                    @else
                                        <a href="{{ $applications->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm hover:bg-slate-100" style="color: #64748b;">‹</a>
                                    @endif
                                    @if ($applications->hasMorePages())
                                        <a href="{{ $applications->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm hover:bg-slate-100" style="color: #64748b;">›</a>
                                    @else
                                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-sm" style="color: #cbd5e1;">›</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>

        </div>
        @endfragment

        {{-- ── Right: Application Detail Panel ── --}}
        @fragment('application-detail')
        @php $showPanel = isset($application) && $application; @endphp
        <div id="application-detail"
             class="w-96 flex-shrink-0 sticky top-6"
             style="{{ $showPanel ? '' : 'display: none;' }}">

            @if ($showPanel)
                @php
                    $areaLabels = ['protege' => 'Protège', 'eleve' => 'Élève', 'respire' => 'Respire'];
                @endphp
                <div x-data="{
                        status: '{{ $application->status }}',
                        adminNotes: {{ Js::from($application->admin_notes ?? '') }}
                     }"
                     class="bg-white rounded-2xl shadow-sm overflow-hidden"
                     style="border: 1px solid #e2e8f0;">

                    {{-- Panel Header --}}
                    <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="font-semibold text-sm truncate" style="color: #1e293b;">{{ $application->fullName() }}</p>
                                <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $application->email }}</p>
                                @if ($application->phone)
                                    <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $application->phone }}</p>
                                @endif
                            </div>
                            <time class="text-xs flex-shrink-0 mt-0.5" style="color: #94a3b8;">
                                {{ $application->created_at->format('d/m/Y') }}
                            </time>
                        </div>
                        @if ($application->city_country)
                            <p class="mt-2 text-xs" style="color: #64748b;">
                                <svg class="inline w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $application->city_country }}
                            </p>
                        @endif
                    </div>

                    {{-- Application Details --}}
                    <div class="px-6 py-4 space-y-4" style="border-bottom: 1px solid #f1f5f9;">

                        {{-- Domains --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide mb-2" style="color: #94a3b8;">Domaines d'intérêt</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($application->areas_of_interest as $area)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                                          style="background-color: rgba(20,60,100,0.1); color: #143c64;">
                                        {{ $areaLabels[$area] ?? $area }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Availability --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color: #94a3b8;">Disponibilité</p>
                            <p class="text-sm" style="color: #475569;">
                                {{ match($application->availability) {
                                    'weekends' => 'Week-ends',
                                    'weekdays' => 'Jours de semaine',
                                    'flexible' => 'Flexible',
                                    default => $application->availability
                                } }}
                            </p>
                        </div>

                        {{-- Motivation --}}
                        @if ($application->motivation)
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color: #94a3b8;">Motivation</p>
                                <p class="text-sm leading-relaxed whitespace-pre-line" style="color: #475569;">{{ $application->motivation }}</p>
                            </div>
                        @endif

                        {{-- Admin Notes --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color: #94a3b8;">Notes internes</p>
                            <textarea x-model="adminNotes"
                                      rows="3"
                                      placeholder="Ajouter une note…"
                                      class="w-full px-3 py-2 rounded-xl text-sm resize-none"
                                      style="border: 1px solid #e2e8f0; outline: none; color: #374151;"></textarea>
                        </div>

                    </div>

                    {{-- Status Actions --}}
                    @can('applications.edit')
                        <div class="px-6 py-4 space-y-2">

                            <p class="text-xs font-semibold uppercase tracking-wide mb-2" style="color: #94a3b8;">Statut de la candidature</p>

                            {{-- Accept --}}
                            <button x-show="status !== 'accepted'"
                                    @click="status = 'accepted'; $action.patch('{{ route('admin.applications.status', $application) }}', { include: ['status', 'adminNotes'] })"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                                    style="background-color: #16a34a;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Accepter la candidature
                            </button>

                            <div x-show="status === 'accepted'"
                                 class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold"
                                 style="background-color: rgba(22,163,74,0.1); color: #16a34a;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Candidature acceptée
                            </div>

                            {{-- Reject --}}
                            <button x-show="status !== 'rejected'"
                                    @click="status = 'rejected'; $action.patch('{{ route('admin.applications.status', $application) }}', { include: ['status', 'adminNotes'] })"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold"
                                    style="background-color: #fef2f2; color: #dc2626;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Rejeter la candidature
                            </button>

                            <div x-show="status === 'rejected'"
                                 class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold"
                                 style="background-color: rgba(100,116,139,0.1); color: #64748b;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Candidature rejetée
                            </div>

                            {{-- Save notes only (if no status change) --}}
                            <button @click="$action.patch('{{ route('admin.applications.status', $application) }}', { include: ['status', 'adminNotes'] })"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold"
                                    style="background-color: #f1f5f9; color: #475569;">
                                Enregistrer les notes
                            </button>

                        </div>
                    @endcan

                </div>
            @endif

        </div>
        @endfragment

    </div>

@endsection
