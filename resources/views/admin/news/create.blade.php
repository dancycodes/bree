@extends('layouts.admin')

@section('title', 'Nouvel article — Actualités')
@section('page_title', 'Nouvel article')
@section('breadcrumb', 'Actualités › Nouvel article')

@section('content')

    <div
        x-data="{
            title_fr: '',
            title_en: '',
            slug: '',
            excerpt_fr: '',
            excerpt_en: '',
            content_fr: '',
            content_en: '',
            category_slug: '',
            status: 'draft',
            published_at: '',
            activeLang: 'fr',
            categories: {{ Js::from($categories->map(fn($c) => ['slug' => $c->slug, 'name_fr' => $c->name_fr, 'name_en' => $c->name_en])) }},
            autoSlug(val) {
                if (!this.slug) {
                    this.slug = val
                        .toLowerCase()
                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-');
                }
            }
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
                                   @input="autoSlug($event.target.value)"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Titre en français">
                            <p x-message="title_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Title (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_en" x-name="title_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Title in English">
                            <p x-message="title_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Slug <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="slug" x-name="slug" type="text"
                                   class="w-full text-xs px-3 py-2.5 rounded-lg border focus:outline-none font-mono"
                                   style="border-color: #e2e8f0; color: #475569;"
                                   placeholder="mon-article-slug">
                            <p x-message="slug" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Excerpt --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Extrait (FR)</label>
                            <textarea x-model="excerpt_fr" x-name="excerpt_fr" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"
                                      placeholder="Court résumé visible dans la liste…"></textarea>
                            <p x-message="excerpt_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Excerpt (EN)</label>
                            <textarea x-model="excerpt_en" x-name="excerpt_en" rows="2"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"
                                      placeholder="Short summary visible in the list…"></textarea>
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
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"
                                      placeholder="Contenu complet de l'article…&#10;&#10;Séparez les paragraphes par une ligne vide."></textarea>
                            <p class="text-xs mt-1" style="color: #cbd5e1;">Séparez les paragraphes par une ligne vide.</p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Article body (EN)</label>
                            <textarea x-model="content_en" x-name="content_en" rows="14"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"
                                      placeholder="Full article content…&#10;&#10;Separate paragraphs with a blank line."></textarea>
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
                        <div x-show="status === 'published'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Date de publication</label>
                            <input x-model="published_at" x-name="published_at" type="datetime-local"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>
                    </div>

                    <button
                        @click="$action('{{ route('admin.news.store') }}')"
                        :disabled="$fetching()"
                        class="w-full mt-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                        style="background-color: #c80078;">
                        <span x-show="!$fetching()">Créer l'article</span>
                        <span x-show="$fetching()">Création…</span>
                    </button>
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Catégorie</h3>
                    @if ($categories->isEmpty())
                        <p class="text-xs" style="color: #94a3b8;">
                            Aucune catégorie.
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
                    <div class="rounded-xl mb-3 overflow-hidden flex items-center justify-center"
                         style="height: 130px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                        <template x-if="$files('thumbnail') && $files('thumbnail').length > 0">
                            <img :src="$filePreview('thumbnail', 0)" alt="" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!$files('thumbnail') || $files('thumbnail').length === 0">
                            <span class="text-xs" style="color: #94a3b8;">Aucune image sélectionnée</span>
                        </template>
                    </div>
                    <input type="file" name="thumbnail" x-files accept="image/*"
                           class="w-full text-xs"
                           style="color: #64748b;">
                    <p class="text-xs mt-2" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 MB</p>
                </div>

                {{-- Nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Actualités</h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.news.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Liste des articles
                        </a>
                        <a href="{{ route('admin.news.categories.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Catégories
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
