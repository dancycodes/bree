@extends('layouts.admin')

@section('title', $article->title_fr . ' — Actualités')
@section('page_title', 'Modifier l\'article')
@section('breadcrumb', 'Actualités › Modifier')

@section('content')

    <div
        x-data="{
            title_fr: {{ Js::from($article->title_fr) }},
            title_en: {{ Js::from($article->title_en) }},
            slug: {{ Js::from($article->slug) }},
            excerpt_fr: {{ Js::from($article->excerpt_fr ?? '') }},
            excerpt_en: {{ Js::from($article->excerpt_en ?? '') }},
            content_fr: {{ Js::from($article->content_fr ?? '') }},
            content_en: {{ Js::from($article->content_en ?? '') }},
            category_slug: {{ Js::from($article->category_slug ?? '') }},
            status: {{ Js::from($article->status) }},
            published_at: {{ Js::from($article->published_at?->format('Y-m-d\TH:i') ?? '') }},
            activeLang: 'fr',
            categories: {{ Js::from($categories->map(fn($c) => ['slug' => $c->slug, 'name_fr' => $c->name_fr, 'name_en' => $c->name_en])) }}
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

                        {{-- Slug --}}
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Slug <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="slug" x-name="slug" type="text"
                                   class="w-full text-xs px-3 py-2.5 rounded-lg border focus:outline-none font-mono"
                                   style="border-color: #e2e8f0; color: #475569;">
                            <p x-message="slug" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Excerpt --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Extrait (FR)</label>
                            <textarea x-model="excerpt_fr" x-name="excerpt_fr" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="excerpt_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Excerpt (EN)</label>
                            <textarea x-model="excerpt_en" x-name="excerpt_en" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="excerpt_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                    </div>
                </div>

                {{-- Article body --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="space-y-4">
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Corps de l'article (FR)</label>
                            <textarea x-model="content_fr" x-name="content_fr" rows="14"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                            <p class="text-xs mt-1" style="color: #cbd5e1;">Séparez les paragraphes par une ligne vide.</p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Article body (EN)</label>
                            <textarea x-model="content_en" x-name="content_en" rows="14"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                            <p class="text-xs mt-1" style="color: #cbd5e1;">Separate paragraphs with a blank line.</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar (1/3) --}}
            <div class="space-y-5">

                {{-- Publish settings --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">Publication</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Statut</label>
                            <select x-model="status" x-name="status"
                                    class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                    style="border-color: #e2e8f0; color: #1e293b;">
                                <option value="draft">Brouillon</option>
                                <option value="published">Publié</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Date de publication</label>
                            <input x-model="published_at" x-name="published_at" type="datetime-local"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>
                    </div>

                    <div class="flex gap-2 mt-5">
                        <button
                            @click="$action.patch('{{ route('admin.news.update', $article) }}')"
                            :disabled="$fetching()"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Sauvegarder</span>
                            <span x-show="$fetching()">…</span>
                        </button>
                        @if ($article->status === 'published')
                            <a href="{{ route('public.news.show', $article) }}"
                               target="_blank"
                               class="flex items-center justify-center px-3 py-2.5 rounded-xl transition-colors"
                               style="border: 1px solid #e2e8f0; color: #64748b;"
                               title="Voir en ligne">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Catégorie</h3>
                    @if ($categories->isEmpty())
                        <p class="text-xs" style="color: #94a3b8;">
                            <a href="{{ route('admin.news.categories.index') }}" class="underline" style="color: #c80078;">Créer une catégorie</a>
                        </p>
                    @else
                        <select x-model="category_slug" x-name="category_slug"
                                class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                style="border-color: #e2e8f0; color: #1e293b;">
                            <option value="">— Aucune —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->name_fr }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Image --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Image à la une</h3>

                    {{-- Current image or new preview --}}
                    <div class="rounded-xl mb-3 overflow-hidden" style="height: 130px; background-color: #f8f5f0;">
                        <template x-if="$files('thumbnail') && $files('thumbnail').length > 0">
                            <img :src="$filePreview('thumbnail', 0)" alt="" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!$files('thumbnail') || $files('thumbnail').length === 0">
                            @if ($article->thumbnail_path)
                                <img src="{{ asset($article->thumbnail_path) }}"
                                     alt="{{ $article->title_fr }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center"
                                     style="border: 2px dashed #c8a03c40;">
                                    <span class="text-xs" style="color: #94a3b8;">Aucune image</span>
                                </div>
                            @endif
                        </template>
                    </div>

                    <input type="file" name="thumbnail" x-files accept="image/*"
                           class="w-full text-xs"
                           style="color: #64748b;">
                    <p class="text-xs mt-2" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 MB. Laissez vide pour conserver l'image actuelle.</p>
                </div>

                {{-- Danger zone --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #ef4444;">Zone critique</h3>
                    <button
                        @click="if (confirm('Supprimer définitivement cet article ?')) $action.delete('{{ route('admin.news.destroy', $article) }}')"
                        class="w-full py-2 rounded-xl text-xs font-semibold transition-colors"
                        style="border: 1px solid #fecaca; color: #ef4444;">
                        Supprimer l'article
                    </button>
                </div>

                {{-- Nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Actualités</h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.news.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            ← Liste des articles
                        </a>
                        <a href="{{ route('admin.news.create') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Nouvel article
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
