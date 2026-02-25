@extends('layouts.admin')

@section('title', 'Modifier — ' . $album->title_fr . ' — Galerie')
@section('page_title', 'Modifier l\'album')
@section('breadcrumb', 'Galerie › Albums › ' . $album->title_fr)

@section('content')

    <div
        x-data="{
            title_fr: {{ Js::from($album->title_fr) }},
            title_en: {{ Js::from($album->title_en) }},
            slug: {{ Js::from($album->slug) }},
            description_fr: {{ Js::from($album->description_fr ?? '') }},
            description_en: {{ Js::from($album->description_en ?? '') }},
            is_published: {{ $album->is_published ? 'true' : 'false' }},
            activeLang: 'fr'
        }"
        x-sync>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main form (2/3) --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Titles --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex border-b mb-5" style="border-color: #e2e8f0;">
                        <button @click="activeLang = 'fr'" class="flex-1 py-3 text-xs font-semibold transition-colors"
                                :style="activeLang === 'fr' ? 'color: #c80078; border-bottom: 2px solid #c80078;' : 'color: #94a3b8;'">
                            Français
                        </button>
                        <button @click="activeLang = 'en'" class="flex-1 py-3 text-xs font-semibold transition-colors"
                                :style="activeLang === 'en' ? 'color: #c80078; border-bottom: 2px solid #c80078;' : 'color: #94a3b8;'">
                            English
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_fr" x-name="title_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Title (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_en" x-name="title_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Slug <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="slug" x-name="slug" type="text"
                                   class="w-full text-xs px-3 py-2.5 rounded-lg border focus:outline-none font-mono"
                                   style="border-color: #e2e8f0; color: #475569;">
                            <p x-message="slug" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="space-y-4">
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Description (FR)</label>
                            <textarea x-model="description_fr" x-name="description_fr" rows="5"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Description (EN)</label>
                            <textarea x-model="description_en" x-name="description_en" rows="5"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Photo count info --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold" style="color: #1e293b;">
                                {{ $album->photos()->count() }} photo(s) dans cet album
                            </p>
                            <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                Ajoutez, réordonnez et légendez les photos.
                            </p>
                        </div>
                        <a href="{{ route('admin.gallery.albums.photos.index', $album) }}"
                           class="text-xs font-semibold px-3 py-2 rounded-lg transition-colors hover:bg-slate-50"
                           style="color: #c80078;">
                            Gérer les photos →
                        </a>
                    </div>
                </div>

            </div>

            {{-- Sidebar (1/3) --}}
            <div class="space-y-5">

                {{-- Publication + Save --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">Publication</h3>
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium" style="color: #475569;">Publié</label>
                        <button
                            @click="is_published = !is_published"
                            :style="is_published ? 'background-color: #c80078;' : 'background-color: #e2e8f0;'"
                            class="relative w-10 h-5 rounded-full transition-colors focus:outline-none">
                            <span class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"
                                  :style="is_published ? 'transform: translateX(1.25rem)' : 'transform: translateX(0.125rem)'">
                            </span>
                        </button>
                        <input type="hidden" x-name="is_published" :value="is_published ? '1' : '0'">
                    </div>

                    <button
                        @click="$action.patch('{{ route('admin.gallery.albums.update', $album) }}')"
                        :disabled="$fetching()"
                        class="w-full mt-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                        style="background-color: #c80078;">
                        <span x-show="!$fetching()">Sauvegarder</span>
                        <span x-show="$fetching()">Sauvegarde…</span>
                    </button>

                    @if ($album->is_published)
                        <a href="{{ route('public.gallery.show', $album) }}" target="_blank"
                           class="flex items-center justify-center gap-1.5 mt-2 py-2 rounded-xl text-xs font-medium transition-colors hover:bg-slate-50"
                           style="color: #64748b; border: 1px solid #e2e8f0;">
                            Voir en ligne
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Cover photo --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Photo de couverture</h3>
                    <div class="rounded-xl mb-3 overflow-hidden flex items-center justify-center"
                         style="height: 130px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                        <template x-if="$files('cover') && $files('cover').length > 0">
                            <img :src="$filePreview('cover', 0)" alt="" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!$files('cover') || $files('cover').length === 0">
                            @if ($album->cover_photo_path)
                                <img src="{{ asset($album->cover_photo_path) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs" style="color: #94a3b8;">Aucune image sélectionnée</span>
                            @endif
                        </template>
                    </div>
                    <input type="file" name="cover" x-files accept="image/*"
                           class="w-full text-xs"
                           style="color: #64748b;">
                    <p class="text-xs mt-2" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 MB</p>
                </div>

                {{-- Danger zone --}}
                <div class="bg-white rounded-2xl shadow-sm p-5" style="border: 1px solid #fee2e2;">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #ef4444;">Zone de danger</h3>
                    <button
                        @click="if (confirm('Supprimer cet album et toutes ses photos ? Cette action est irréversible.')) $action.delete('{{ route('admin.gallery.albums.destroy', $album) }}')"
                        class="w-full py-2.5 rounded-xl text-sm font-semibold transition-colors hover:bg-red-600 text-white"
                        style="background-color: #ef4444;">
                        Supprimer l'album
                    </button>
                </div>

            </div>

        </div>

    </div>

@endsection
