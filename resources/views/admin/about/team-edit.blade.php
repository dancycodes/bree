@extends('layouts.admin')

@section('title', 'Modifier — ' . $member->name)
@section('page_title', 'Modifier le membre')
@section('breadcrumb', "À Propos › Équipe › " . $member->name)

@section('content')

    <div
        x-data="{
            name: {{ json_encode($member->name) }},
            title_fr: {{ json_encode($member->title_fr) }},
            title_en: {{ json_encode($member->title_en) }},
            bio_fr: {{ json_encode($member->bio_fr ?? '') }},
            bio_en: {{ json_encode($member->bio_en ?? '') }},
            is_published: {{ $member->is_published ? 'true' : 'false' }},
            activeLang: 'fr',
            photoFileName: null
        }"
        x-sync="['name','title_fr','title_en','bio_fr','bio_en','is_published']">

        {{-- Back link --}}
        <div class="mb-5">
            <a href="{{ route('admin.about.team.index') }}"
               class="inline-flex items-center gap-1.5 text-sm transition-colors"
               style="color: #64748b;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Retour à l'équipe
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main form --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Name --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                        Nom complet <span style="color: #ef4444;">*</span>
                    </label>
                    <input x-model="name" x-name="name" type="text"
                           class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                           style="border-color: #e2e8f0; color: #1e293b;">
                    <p x-message="name" class="text-xs mt-1" style="color: #ef4444;"></p>
                </div>

                {{-- Bilingual fields --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="flex border-b" style="border-color: #e2e8f0;">
                        <button
                            @click="activeLang = 'fr'"
                            class="flex-1 py-3 text-xs font-semibold transition-colors"
                            :style="activeLang === 'fr' ? 'color: #c80078; border-bottom: 2px solid #c80078;' : 'color: #94a3b8;'">
                            Français
                        </button>
                        <button
                            @click="activeLang = 'en'"
                            class="flex-1 py-3 text-xs font-semibold transition-colors"
                            :style="activeLang === 'en' ? 'color: #c80078; border-bottom: 2px solid #c80078;' : 'color: #94a3b8;'">
                            English
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        {{-- Title FR --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre / Fonction (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_fr" x-name="title_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        {{-- Title EN --}}
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Title / Role (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_en" x-name="title_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Bio FR --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Biographie (FR)
                            </label>
                            <textarea x-model="bio_fr" x-name="bio_fr" rows="5"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="bio_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        {{-- Bio EN --}}
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Biography (EN)
                            </label>
                            <textarea x-model="bio_en" x-name="bio_en" rows="5"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="bio_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                {{-- Photo upload --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">Photo</h3>

                    @if ($member->photo_path)
                        <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-3">
                            <img src="{{ vasset($member->photo_path) }}" alt="Photo actuelle" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-full mx-auto mb-3 flex items-center justify-center"
                             style="background-color: rgba(200,0,120,0.08); border: 2px dashed rgba(200,0,120,0.3);">
                            <span class="text-xs font-bold" style="color: #c80078;">
                                {{ $member->initials() }}
                            </span>
                        </div>
                    @endif

                    <label class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold cursor-pointer transition-opacity hover:opacity-80"
                           style="background-color: #f1f5f9; color: #475569;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-text="photoFileName ?? 'Choisir une photo'" class="truncate" style="max-width: 140px;"></span>
                        <input type="file" name="photo" x-files accept="image/jpeg,image/png,image/webp"
                               @change="photoFileName = $event.target.files[0]?.name ?? null"
                               class="hidden">
                    </label>
                    <p class="text-xs mt-1.5" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 Mo</p>
                    <button type="button"
                            @click="$action.post('{{ route('admin.about.team.uploadPhoto', $member) }}')"
                            :disabled="$fetching() || !photoFileName"
                            class="w-full mt-3 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-40"
                            style="background-color: #143c64;">
                        <span x-show="!$fetching()">Téléverser la photo</span>
                        <span x-show="$fetching()">Téléversement…</span>
                    </button>
                </div>

                {{-- Published --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold mb-3" style="color: #143c64;">Visibilité</h3>
                    <div class="flex items-center gap-2">
                        <input x-model="is_published" x-name="is_published" type="checkbox"
                               id="is-published" class="rounded">
                        <label for="is-published" class="text-sm" style="color: #475569;">
                            Publié sur le site
                        </label>
                    </div>
                </div>

                {{-- Save --}}
                <button
                    @click="$action.patch('{{ route('admin.about.team.update', $member) }}')"
                    :disabled="$fetching()"
                    class="w-full py-3 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                    style="background-color: #c80078;">
                    <span x-show="!$fetching()">Enregistrer</span>
                    <span x-show="$fetching()">Enregistrement…</span>
                </button>

                {{-- View public --}}
                <a href="{{ route('public.about') }}" target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm transition-colors"
                   style="color: #64748b; border: 1px solid #e2e8f0;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir la page À Propos
                </a>

            </div>

        </div>

    </div>

@endsection
