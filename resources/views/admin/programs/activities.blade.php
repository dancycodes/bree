@extends('layouts.admin')

@section('title', 'Activités — ' . $program->name_fr)
@section('page_title', $program->name_fr . ' — Activités')
@section('breadcrumb', 'Programmes › ' . $program->name_fr)

@section('content')

    <div
        x-data="{
            activities: @json($activities->pluck('id')),
            name_fr: '',
            name_en: '',
            draggingId: null,
            editingId: null,
            editNameFr: '',
            editNameEn: '',
            startEdit(id, nameFr, nameEn) {
                this.editingId = id;
                this.editNameFr = nameFr;
                this.editNameEn = nameEn;
            }
        }"
        x-sync="['name_fr','name_en','activities','editingId','editNameFr','editNameEn']">

        {{-- Back link --}}
        <div class="mb-5">
            <a href="{{ route('admin.programs.index') }}"
               class="inline-flex items-center gap-1.5 text-sm transition-colors"
               style="color: #64748b;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Tous les programmes
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Activities list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-5 rounded-full flex-shrink-0"
                                 style="background-color: {{ $program->color }};"></div>
                            <h2 class="text-sm font-semibold" style="color: #143c64;">
                                Activités ({{ $activities->count() }})
                            </h2>
                        </div>
                        <p class="text-xs" style="color: #94a3b8;">Glissez pour réordonner</p>
                    </div>

                    @fragment('activities-list')
                    <div id="activities-list">
                        @if ($activities->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucune activité pour ce programme.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez la première activité →</p>
                            </div>
                        @else
                            <ul
                                @dragover.prevent
                                class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($activities as $activity)
                                    <li
                                        id="activity-{{ $activity->id }}"
                                        draggable="true"
                                        @dragstart="draggingId = {{ $activity->id }}"
                                        @dragover.prevent
                                        @drop.prevent="
                                            const fromIdx = activities.indexOf(draggingId);
                                            const toIdx = activities.indexOf({{ $activity->id }});
                                            if (fromIdx !== -1 && toIdx !== -1 && fromIdx !== toIdx) {
                                                activities.splice(fromIdx, 1);
                                                activities.splice(toIdx, 0, draggingId);
                                                $action('{{ route('admin.programs.activities.reorder', $program) }}', { include: ['activities'] });
                                            }
                                            draggingId = null;
                                        "
                                        class="px-6 py-4 flex items-center gap-3 cursor-grab active:cursor-grabbing"
                                        :style="draggingId === {{ $activity->id }} ? 'opacity:0.5;background-color:#f8fafc' : ''">

                                        {{-- Drag handle --}}
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="1.5" style="color: #cbd5e1;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                                        </svg>

                                        {{-- Activity content --}}
                                        <div class="flex-1 min-w-0">
                                            <template x-if="editingId !== {{ $activity->id }}">
                                                <div>
                                                    <p class="text-sm font-medium leading-snug" style="color: #1e293b;">
                                                        {{ $activity->name_fr }}
                                                    </p>
                                                    <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                                        {{ $activity->name_en }}
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="editingId === {{ $activity->id }}">
                                                <div class="space-y-2">
                                                    <input
                                                        x-model="editNameFr"
                                                        x-name="editNameFr"
                                                        type="text"
                                                        placeholder="Nom FR"
                                                        class="w-full text-sm px-3 py-1.5 rounded-lg border focus:outline-none"
                                                        style="border-color: #e2e8f0; color: #1e293b;">
                                                    <p x-message="editNameFr" class="text-xs" style="color: #ef4444;"></p>
                                                    <input
                                                        x-model="editNameEn"
                                                        x-name="editNameEn"
                                                        type="text"
                                                        placeholder="Nom EN"
                                                        class="w-full text-sm px-3 py-1.5 rounded-lg border focus:outline-none"
                                                        style="border-color: #e2e8f0; color: #1e293b;">
                                                    <p x-message="editNameEn" class="text-xs" style="color: #ef4444;"></p>
                                                </div>
                                            </template>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-1 flex-shrink-0">
                                            <template x-if="editingId !== {{ $activity->id }}">
                                                <button
                                                    @click="startEdit({{ $activity->id }}, {{ json_encode($activity->name_fr) }}, {{ json_encode($activity->name_en) }})"
                                                    class="p-1.5 rounded-lg transition-colors"
                                                    style="color: #64748b;"
                                                    title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                    </svg>
                                                </button>
                                            </template>
                                            <template x-if="editingId === {{ $activity->id }}">
                                                <button
                                                    @click="$action('{{ route('admin.programs.activities.update', $activity) }}')"
                                                    class="p-1.5 rounded-lg transition-colors"
                                                    style="color: #10b981;"
                                                    title="Enregistrer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </button>
                                            </template>
                                            <button
                                                @click="if (confirm('Supprimer cette activité ?')) $action('{{ route('admin.programs.activities.destroy', $activity) }}', { method: 'DELETE' })"
                                                class="p-1.5 rounded-lg transition-colors"
                                                style="color: #ef4444;"
                                                title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    @endfragment

                </div>
            </div>

            {{-- Right: Add activity form --}}
            <div>
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Ajouter une activité
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input
                                x-model="name_fr"
                                x-name="name_fr"
                                type="text"
                                placeholder="Ex: Aide juridique gratuite"
                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none transition-colors"
                                style="border-color: #e2e8f0; color: #1e293b;"
                                @focus="$el.style.borderColor='{{ $program->color }}'"
                                @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="name_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input
                                x-model="name_en"
                                x-name="name_en"
                                type="text"
                                placeholder="Ex: Free legal aid"
                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none transition-colors"
                                style="border-color: #e2e8f0; color: #1e293b;"
                                @focus="$el.style.borderColor='{{ $program->color }}'"
                                @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="name_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <button
                            @click="$action('{{ route('admin.programs.activities.store', $program) }}')"
                            :disabled="$fetching()"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: {{ $program->color }};">
                            <span x-show="!$fetching()">Ajouter l'activité</span>
                            <span x-show="$fetching()">Ajout en cours…</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
