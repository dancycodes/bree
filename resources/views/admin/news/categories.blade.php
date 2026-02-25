@extends('layouts.admin')

@section('title', 'Catégories — Actualités')
@section('page_title', 'Catégories d\'actualités')
@section('breadcrumb', 'Actualités › Catégories')

@section('content')

    <div
        x-data="{
            name_fr: '',
            name_en: '',
            slug: '',
            color: '#c80078',
            editingId: null,
            editNameFr: '',
            editNameEn: '',
            editSlug: '',
            editColor: '#c80078',
            startEdit(id, nameFr, nameEn, catSlug, catColor) {
                this.editingId = id;
                this.editNameFr = nameFr;
                this.editNameEn = nameEn;
                this.editSlug = catSlug;
                this.editColor = catColor;
            },
            autoSlug(val) {
                this.slug = val
                    .toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-');
            }
        }"
        x-sync="['name_fr','name_en','slug','color','editingId','editNameFr','editNameEn','editSlug','editColor']">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Categories list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <h2 class="text-sm font-semibold" style="color: #143c64;">
                            Catégories ({{ $categories->count() }})
                        </h2>
                        <a href="{{ route('public.news') }}" target="_blank"
                           class="flex items-center gap-1.5 text-xs transition-colors"
                           style="color: #94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Voir le site
                        </a>
                    </div>

                    @fragment('categories-list')
                    <div id="categories-list">
                        @if ($categories->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucune catégorie configurée.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez la première catégorie →</p>
                            </div>
                        @else
                            <ul class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($categories as $category)
                                    <li id="category-{{ $category->id }}" class="px-6 py-4">

                                        <template x-if="editingId !== {{ $category->id }}">
                                            <div class="flex items-center gap-4">
                                                {{-- Color swatch + name --}}
                                                <div class="w-8 h-8 rounded-lg flex-shrink-0"
                                                     style="background-color: {{ $category->color }};"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold" style="color: #1e293b;">
                                                        {{ $category->name_fr }}
                                                        <span class="font-normal ml-1" style="color: #94a3b8;">/ {{ $category->name_en }}</span>
                                                    </p>
                                                    <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                                        Slug: <code class="font-mono">{{ $category->slug }}</code>
                                                        &nbsp;·&nbsp;
                                                        {{ $category->articlesCount() }} article{{ $category->articlesCount() !== 1 ? 's' : '' }}
                                                    </p>
                                                </div>
                                                {{-- Actions --}}
                                                <div class="flex items-center gap-1 flex-shrink-0">
                                                    <button
                                                        @click="startEdit({{ $category->id }}, {{ json_encode($category->name_fr) }}, {{ json_encode($category->name_en) }}, {{ json_encode($category->slug) }}, {{ json_encode($category->color) }})"
                                                        class="p-1.5 rounded-lg transition-colors hover:bg-slate-50"
                                                        style="color: #64748b;"
                                                        title="Modifier">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="$action.delete('{{ route('admin.news.categories.destroy', $category) }}')"
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

                                        <template x-if="editingId === {{ $category->id }}">
                                            <div class="space-y-3">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Nom (FR) *</label>
                                                        <input x-model="editNameFr" x-name="editNameFr" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editNameFr" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Nom (EN) *</label>
                                                        <input x-model="editNameEn" x-name="editNameEn" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editNameEn" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Slug *</label>
                                                        <input x-model="editSlug" x-name="editSlug" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none font-mono"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editSlug" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Couleur *</label>
                                                        <div class="flex items-center gap-2">
                                                            <input x-model="editColor" x-name="editColor" type="color"
                                                                   class="w-10 h-9 rounded-lg border cursor-pointer"
                                                                   style="border-color: #e2e8f0; padding: 2px;">
                                                            <input x-model="editColor" type="text"
                                                                   class="flex-1 text-sm px-3 py-2 rounded-lg border focus:outline-none font-mono"
                                                                   style="border-color: #e2e8f0; color: #1e293b;"
                                                                   placeholder="#c80078">
                                                        </div>
                                                        <p x-message="editColor" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button
                                                        @click="$action.patch('{{ route('admin.news.categories.update', $category) }}')"
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

            {{-- Right: Add category form --}}
            <div>
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Nouvelle catégorie
                    </h3>

                    <div class="space-y-3">

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="name_fr" x-name="name_fr" type="text"
                                   @input="autoSlug($event.target.value)"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Ex: Santé">
                            <p x-message="name_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="name_en" x-name="name_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="Ex: Health">
                            <p x-message="name_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Slug <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="slug" x-name="slug" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none font-mono"
                                   style="border-color: #e2e8f0; color: #1e293b;"
                                   placeholder="sante">
                            <p x-message="slug" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Couleur <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input x-model="color" x-name="color" type="color"
                                       class="w-10 h-10 rounded-lg border cursor-pointer flex-shrink-0"
                                       style="border-color: #e2e8f0; padding: 2px;">
                                <input x-model="color" type="text"
                                       class="flex-1 text-sm px-3 py-2.5 rounded-lg border focus:outline-none font-mono"
                                       style="border-color: #e2e8f0; color: #1e293b;"
                                       placeholder="#c80078">
                            </div>
                            <p x-message="color" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <button
                            @click="$action('{{ route('admin.news.categories.store') }}')"
                            :disabled="$fetching()"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Créer la catégorie</span>
                            <span x-show="$fetching()">Création…</span>
                        </button>

                    </div>
                </div>

                {{-- News sub-nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 mt-5">
                    <h3 class="text-xs font-semibold mb-3" style="color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                        Section Actualités
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.news.categories.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium"
                           style="color: #c80078; background-color: #c8007808;">
                            Catégories
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
