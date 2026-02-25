@extends('layouts.admin')

@section('title', 'Jalons — À Propos')
@section('page_title', 'Jalons de la fondation')
@section('breadcrumb', 'À Propos › Jalons')

@section('content')

    <div
        x-data="{
            year: '',
            title_fr: '',
            title_en: '',
            description_fr: '',
            description_en: '',
            editingId: null,
            editYear: '',
            editTitleFr: '',
            editTitleEn: '',
            editDescFr: '',
            editDescEn: '',
            activeLang: 'fr',
            startEdit(id, year, titleFr, titleEn, descFr, descEn) {
                this.editingId = id;
                this.editYear = year;
                this.editTitleFr = titleFr;
                this.editTitleEn = titleEn;
                this.editDescFr = descFr;
                this.editDescEn = descEn;
            }
        }"
        x-sync="['year','title_fr','title_en','description_fr','description_en','editingId','editYear','editTitleFr','editTitleEn','editDescFr','editDescEn']">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Milestones list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <h2 class="text-sm font-semibold" style="color: #143c64;">
                            Jalons ({{ $milestones->count() }})
                        </h2>
                        <a href="{{ route('public.about') }}" target="_blank"
                           class="flex items-center gap-1.5 text-xs transition-colors"
                           style="color: #94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Voir le site
                        </a>
                    </div>

                    @fragment('milestones-list')
                    <div id="milestones-list">
                        @if ($milestones->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucun jalon configuré.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez le premier jalon →</p>
                            </div>
                        @else
                            <ul class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($milestones as $milestone)
                                    <li id="milestone-{{ $milestone->id }}" class="px-6 py-4">

                                        <template x-if="editingId !== {{ $milestone->id }}">
                                            <div class="flex items-start gap-4">
                                                {{-- Year badge --}}
                                                <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center font-bold text-sm"
                                                     style="background-color: #c8a03c15; color: #c8a03c;">
                                                    {{ $milestone->year }}
                                                </div>
                                                {{-- Content --}}
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold leading-snug" style="color: #1e293b;">
                                                        {{ $milestone->title_fr }}
                                                    </p>
                                                    <p class="text-xs mt-0.5 mb-1" style="color: #94a3b8;">
                                                        {{ $milestone->title_en }}
                                                    </p>
                                                    @if ($milestone->description_fr)
                                                        <p class="text-xs leading-relaxed" style="color: #64748b;">
                                                            {{ Str::limit($milestone->description_fr, 100) }}
                                                        </p>
                                                    @endif
                                                </div>
                                                {{-- Actions --}}
                                                <div class="flex items-center gap-1 flex-shrink-0">
                                                    <button
                                                        @click="startEdit({{ $milestone->id }}, {{ $milestone->year }}, {{ json_encode($milestone->title_fr) }}, {{ json_encode($milestone->title_en) }}, {{ json_encode($milestone->description_fr ?? '') }}, {{ json_encode($milestone->description_en ?? '') }})"
                                                        class="p-1.5 rounded-lg transition-colors hover:bg-slate-50"
                                                        style="color: #64748b;"
                                                        title="Modifier">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="if (confirm('Supprimer ce jalon ?')) $action.delete('{{ route('admin.about.milestones.destroy', $milestone) }}')"
                                                        class="p-1.5 rounded-lg transition-colors hover:bg-red-50"
                                                        style="color: #ef4444;"
                                                        title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="editingId === {{ $milestone->id }}">
                                            <div class="space-y-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-24">
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Année *</label>
                                                        <input x-model="editYear" x-name="editYear" type="number" min="1900" max="2100"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editYear" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                    <div class="flex-1">
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Titre (FR) *</label>
                                                        <input x-model="editTitleFr" x-name="editTitleFr" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editTitleFr" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Titre (EN) *</label>
                                                    <input x-model="editTitleEn" x-name="editTitleEn" type="text"
                                                           class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                           style="border-color: #e2e8f0; color: #1e293b;">
                                                    <p x-message="editTitleEn" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Description (FR)</label>
                                                    <textarea x-model="editDescFr" x-name="editDescFr" rows="2"
                                                              class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none"
                                                              style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                                                    <p x-message="editDescFr" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Description (EN)</label>
                                                    <textarea x-model="editDescEn" x-name="editDescEn" rows="2"
                                                              class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none"
                                                              style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                                                    <p x-message="editDescEn" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button
                                                        @click="$action.patch('{{ route('admin.about.milestones.update', $milestone) }}')"
                                                        :disabled="$fetching()"
                                                        class="px-4 py-2 rounded-lg text-xs font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                                                        style="background-color: #c80078;">
                                                        <span x-show="!$fetching()">Enregistrer</span>
                                                        <span x-show="$fetching()">…</span>
                                                    </button>
                                                    <button
                                                        @click="editingId = null"
                                                        class="px-4 py-2 rounded-lg text-xs font-semibold transition-colors"
                                                        style="color: #64748b; border: 1px solid #e2e8f0;">
                                                        Annuler
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    @endfragment

                </div>
            </div>

            {{-- Right: Add milestone form --}}
            <div>
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Ajouter une étape
                    </h3>

                    <div class="space-y-3">

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Année <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="year" x-name="year" type="number" min="1900" max="2100"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="2025">
                            <p x-message="year" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_fr" x-name="title_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Ex: Lancement du programme...">
                            <p x-message="title_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_en" x-name="title_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Ex: Programme launch...">
                            <p x-message="title_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description (FR)
                            </label>
                            <textarea x-model="description_fr" x-name="description_fr" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="description_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description (EN)
                            </label>
                            <textarea x-model="description_en" x-name="description_en" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="description_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <button
                            @click="$action('{{ route('admin.about.milestones.store') }}')"
                            :disabled="$fetching()"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Ajouter l'étape</span>
                            <span x-show="$fetching()">Ajout en cours…</span>
                        </button>

                    </div>
                </div>

                {{-- About sub-nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 mt-5">
                    <h3 class="text-xs font-semibold mb-3" style="color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                        Section À Propos
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.about.founder.edit') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Fondatrice
                        </a>
                        <a href="{{ route('admin.about.patron.edit') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Marraine
                        </a>
                        <a href="{{ route('admin.about.milestones.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium"
                           style="color: #c80078; background-color: #c8007808;">
                            Jalons
                        </a>
                        <a href="{{ route('admin.about.team.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Équipe
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
