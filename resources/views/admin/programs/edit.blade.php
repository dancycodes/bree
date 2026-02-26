@extends('layouts.admin')

@section('title', 'Modifier — ' . $program->name_fr)
@section('page_title', 'Modifier : ' . $program->name_fr)
@section('breadcrumb', 'Programmes › ' . $program->name_fr)

@section('content')

    <div
        x-data="{
            name_fr: {{ json_encode($program->name_fr) }},
            name_en: {{ json_encode($program->name_en) }},
            description_fr: {{ json_encode($program->description_fr) }},
            description_en: {{ json_encode($program->description_en) }},
            long_description_fr: {{ json_encode($program->long_description_fr ?? '') }},
            long_description_en: {{ json_encode($program->long_description_en ?? '') }},
            color: {{ json_encode($program->color) }},
            stats_fr: @json($program->stats_fr ?? []),
            stats_en: @json($program->stats_en ?? []),
            activeLang: 'fr',
            imageFileName: null,
            addStat() {
                if (this.stats_fr.length < 6) {
                    this.stats_fr.push({ number: '', label: '' });
                    this.stats_en.push({ number: '', label: '' });
                }
            },
            removeStat(i) {
                if (this.stats_fr.length > 2) {
                    this.stats_fr.splice(i, 1);
                    this.stats_en.splice(i, 1);
                }
            }
        }"
        x-sync="['name_fr','name_en','description_fr','description_en','long_description_fr','long_description_en','color','stats_fr','stats_en']">

        {{-- Back link --}}
        <div class="mb-5 flex items-center justify-between">
            <a href="{{ route('admin.programs.index') }}"
               class="inline-flex items-center gap-1.5 text-sm transition-colors"
               style="color: #64748b;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Tous les programmes
            </a>

            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $program->color }};"></div>
                <span class="text-xs font-medium" style="color: #94a3b8;">{{ $program->slug }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main form --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Language tabs --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="flex border-b" style="border-color: #e2e8f0;">
                        <button
                            @click="activeLang = 'fr'"
                            class="flex-1 py-3 text-xs font-semibold transition-colors"
                            :style="activeLang === 'fr' ? 'color: {{ $program->color }}; border-bottom: 2px solid {{ $program->color }};' : 'color: #94a3b8;'">
                            Français
                        </button>
                        <button
                            @click="activeLang = 'en'"
                            class="flex-1 py-3 text-xs font-semibold transition-colors"
                            :style="activeLang === 'en' ? 'color: {{ $program->color }}; border-bottom: 2px solid {{ $program->color }};' : 'color: #94a3b8;'">
                            English
                        </button>
                    </div>

                    <div class="p-6 space-y-5">

                        {{-- Name --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom du programme (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="name_fr" x-name="name_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="name_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Program Name (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="name_en" x-name="name_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="name_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Short Description --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description courte (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea x-model="description_fr" x-name="description_fr" rows="3"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="description_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Short Description (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea x-model="description_en" x-name="description_en" rows="3"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="description_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Long Description --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description complète (FR)
                            </label>
                            <textarea x-model="long_description_fr" x-name="long_description_fr" rows="6"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="long_description_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Full Description (EN)
                            </label>
                            <textarea x-model="long_description_en" x-name="long_description_en" rows="6"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="long_description_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                    </div>
                </div>

                {{-- Program Stats --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <h3 class="text-sm font-semibold" style="color: #143c64;">Statistiques d'impact</h3>
                        <button
                            @click="addStat()"
                            :disabled="stats_fr.length >= 6"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-opacity disabled:opacity-40"
                            style="background-color: {{ $program->color }}1a; color: {{ $program->color }};">
                            + Ajouter
                        </button>
                    </div>

                    <div class="p-6">
                        <template x-if="stats_fr.length === 0">
                            <p class="text-xs text-center py-4" style="color: #94a3b8;">
                                Aucune statistique. Cliquez sur "+ Ajouter" pour en créer.
                            </p>
                        </template>

                        <div class="space-y-4">
                            <template x-for="(stat, i) in stats_fr" :key="i">
                                <div class="rounded-xl p-4 border" style="border-color: #e2e8f0;">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-medium" style="color: #94a3b8;" x-text="'Stat #' + (i + 1)"></span>
                                        <button @click="removeStat(i)"
                                                :disabled="stats_fr.length <= 2"
                                                class="text-xs transition-opacity disabled:opacity-30"
                                                style="color: #ef4444;">Supprimer</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs mb-1" style="color: #64748b;">Nombre</label>
                                            <input x-model="stats_fr[i].number"
                                                   type="text" placeholder="Ex: 1500+"
                                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                   style="border-color: #e2e8f0; color: #1e293b;">
                                        </div>
                                        <div>
                                            <label class="block text-xs mb-1" style="color: #64748b;">Label FR</label>
                                            <input x-model="stats_fr[i].label"
                                                   type="text" placeholder="Ex: Bénéficiaires"
                                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                   style="border-color: #e2e8f0; color: #1e293b;">
                                        </div>
                                        <div x-show="stats_en[i] !== undefined" class="col-span-2">
                                            <label class="block text-xs mb-1" style="color: #64748b;">Label EN</label>
                                            <input x-model="stats_en[i].label"
                                                   type="text" placeholder="Ex: Beneficiaries"
                                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                   style="border-color: #e2e8f0; color: #1e293b;">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar: image + color + save --}}
            <div class="space-y-5">

                {{-- Program image upload --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">Image du programme</h3>

                    @if ($program->image_path)
                        <div class="rounded-xl overflow-hidden mb-3" style="height: 140px;">
                            <img src="{{ asset($program->image_path) }}"
                                 alt="Image actuelle"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="rounded-xl mb-3 flex items-center justify-center"
                             style="height: 140px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                            <span class="text-xs" style="color: #94a3b8;">Aucune image configurée</span>
                        </div>
                    @endif

                    <label class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold cursor-pointer transition-opacity hover:opacity-80"
                           style="background-color: #f1f5f9; color: #475569;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-text="imageFileName ?? 'Choisir une image'" class="truncate" style="max-width: 140px;"></span>
                        <input type="file" name="image" x-files accept="image/jpeg,image/png,image/webp"
                               @change="imageFileName = $event.target.files[0]?.name ?? null"
                               class="hidden">
                    </label>
                    <p class="text-xs mt-1.5" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 Mo</p>
                    <button type="button"
                            @click="$action.post('{{ route('admin.programs.uploadImage', $program) }}')"
                            :disabled="$fetching() || !imageFileName"
                            class="w-full mt-3 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-40"
                            style="background-color: {{ $program->color }};">
                        <span x-show="!$fetching()">Téléverser l'image</span>
                        <span x-show="$fetching()">Téléversement…</span>
                    </button>
                </div>

                {{-- Color accent --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">Couleur d'accent</h3>
                    <div class="flex items-center gap-3">
                        <input x-model="color" type="color"
                               class="w-12 h-10 rounded-lg border cursor-pointer"
                               style="border-color: #e2e8f0;">
                        <input x-model="color" x-name="color" type="text"
                               class="flex-1 text-sm px-3 py-2 rounded-lg border focus:outline-none font-mono"
                               style="border-color: #e2e8f0; color: #1e293b;">
                    </div>
                    <p x-message="color" class="text-xs mt-1" style="color: #ef4444;"></p>
                </div>

                {{-- Save button --}}
                <button
                    @click="$action.patch('{{ route('admin.programs.update', $program) }}')"
                    :disabled="$fetching()"
                    class="w-full py-3 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                    style="background-color: {{ $program->color }};">
                    <span x-show="!$fetching()">Enregistrer les modifications</span>
                    <span x-show="$fetching()">Enregistrement…</span>
                </button>

                {{-- Quick links --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 space-y-2">
                    <h3 class="text-xs font-semibold mb-3" style="color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Accès rapide</h3>
                    <a href="{{ route('admin.programs.activities.index', $program) }}"
                       class="flex items-center gap-2 text-sm transition-colors"
                       style="color: #475569;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Gérer les activités
                    </a>
                    <a href="{{ route('public.programs.show', $program) }}" target="_blank"
                       class="flex items-center gap-2 text-sm transition-colors"
                       style="color: #475569;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Voir la page publique
                    </a>
                </div>

            </div>

        </div>

    </div>

@endsection
