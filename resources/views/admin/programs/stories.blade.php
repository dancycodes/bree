@extends('layouts.admin')

@section('title', 'Témoignages — ' . $program->name_fr)
@section('page_title', $program->name_fr . ' — Témoignages')
@section('breadcrumb', 'Programmes › ' . $program->name_fr)

@section('content')

    <div
        x-data="{
            quote_fr: '',
            quote_en: '',
            author_name: 'Bénéficiaire anonyme',
            is_published: false,
            editingId: null,
            editQuoteFr: '',
            editQuoteEn: '',
            editAuthor: '',
            editPublished: false,
            startEdit(id, qFr, qEn, author, published) {
                this.editingId = id;
                this.editQuoteFr = qFr;
                this.editQuoteEn = qEn;
                this.editAuthor = author;
                this.editPublished = published;
            }
        }"
        x-sync="['quote_fr','quote_en','author_name','is_published','editingId','editQuoteFr','editQuoteEn','editAuthor','editPublished']">

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

            {{-- Left: Stories list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-5 rounded-full flex-shrink-0"
                                 style="background-color: {{ $program->color }};"></div>
                            <h2 class="text-sm font-semibold" style="color: #143c64;">
                                Témoignages ({{ $stories->count() }})
                            </h2>
                        </div>
                    </div>

                    @fragment('stories-list')
                    <div id="stories-list">
                        @if ($stories->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucun témoignage pour ce programme.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez le premier témoignage →</p>
                            </div>
                        @else
                            <ul class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($stories as $story)
                                    <li class="px-6 py-4">

                                        {{-- Display mode --}}
                                        <template x-if="editingId !== {{ $story->id }}">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm leading-relaxed line-clamp-2" style="color: #1e293b;">
                                                        "{{ $story->quote_fr }}"
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-1.5">
                                                        <p class="text-xs font-medium" style="color: #475569;">
                                                            — {{ $story->author_name }}
                                                        </p>
                                                        @if ($story->is_published)
                                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                                                                  style="background-color: #dcfce7; color: #16a34a;">
                                                                Publié
                                                            </span>
                                                        @else
                                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                                                                  style="background-color: #f1f5f9; color: #94a3b8;">
                                                                Brouillon
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-1 flex-shrink-0">
                                                    <button
                                                        @click="startEdit({{ $story->id }}, {{ json_encode($story->quote_fr) }}, {{ json_encode($story->quote_en) }}, {{ json_encode($story->author_name) }}, {{ $story->is_published ? 'true' : 'false' }})"
                                                        class="p-1.5 rounded-lg transition-colors"
                                                        style="color: #64748b;"
                                                        title="Modifier">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="if (confirm('Supprimer ce témoignage ?')) $action('{{ route('admin.programs.stories.destroy', $story) }}', { method: 'DELETE' })"
                                                        class="p-1.5 rounded-lg transition-colors"
                                                        style="color: #ef4444;"
                                                        title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        {{-- Edit mode --}}
                                        <template x-if="editingId === {{ $story->id }}">
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Citation (FR)</label>
                                                    <textarea
                                                        x-model="editQuoteFr"
                                                        x-name="editQuoteFr"
                                                        rows="3"
                                                        placeholder="Citation en français…"
                                                        class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none"
                                                        style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                                                    <p x-message="editQuoteFr" class="text-xs mt-0.5" style="color: #ef4444;"></p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Citation (EN)</label>
                                                    <textarea
                                                        x-model="editQuoteEn"
                                                        x-name="editQuoteEn"
                                                        rows="3"
                                                        placeholder="Quote in English…"
                                                        class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none"
                                                        style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                                                    <p x-message="editQuoteEn" class="text-xs mt-0.5" style="color: #ef4444;"></p>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium mb-1" style="color: #475569;">Auteur</label>
                                                    <input
                                                        x-model="editAuthor"
                                                        x-name="editAuthor"
                                                        type="text"
                                                        placeholder="Nom de l'auteur"
                                                        class="w-full text-sm px-3 py-1.5 rounded-lg border focus:outline-none"
                                                        style="border-color: #e2e8f0; color: #1e293b;">
                                                    <p x-message="editAuthor" class="text-xs mt-0.5" style="color: #ef4444;"></p>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <input
                                                        x-model="editPublished"
                                                        x-name="editPublished"
                                                        type="checkbox"
                                                        id="edit-published-{{ $story->id }}"
                                                        class="rounded">
                                                    <label for="edit-published-{{ $story->id }}" class="text-xs" style="color: #475569;">
                                                        Publier ce témoignage
                                                    </label>
                                                </div>
                                                <div class="flex items-center gap-2 pt-1">
                                                    <button
                                                        @click="$action.patch('{{ route('admin.programs.stories.update', $story) }}')"
                                                        class="px-4 py-1.5 rounded-lg text-xs font-semibold text-white transition-opacity hover:opacity-90"
                                                        style="background-color: #10b981;">
                                                        Enregistrer
                                                    </button>
                                                    <button
                                                        @click="editingId = null"
                                                        class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-colors"
                                                        style="color: #64748b; background-color: #f1f5f9;">
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

            {{-- Right: Add story form --}}
            <div>
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Ajouter un témoignage
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Citation (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea
                                x-model="quote_fr"
                                x-name="quote_fr"
                                rows="4"
                                placeholder="Témoignage en français…"
                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none transition-colors"
                                style="border-color: #e2e8f0; color: #1e293b;"
                                @focus="$el.style.borderColor='{{ $program->color }}'"
                                @blur="$el.style.borderColor='#e2e8f0'"></textarea>
                            <p x-message="quote_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Citation (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea
                                x-model="quote_en"
                                x-name="quote_en"
                                rows="4"
                                placeholder="Testimonial in English…"
                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none resize-none transition-colors"
                                style="border-color: #e2e8f0; color: #1e293b;"
                                @focus="$el.style.borderColor='{{ $program->color }}'"
                                @blur="$el.style.borderColor='#e2e8f0'"></textarea>
                            <p x-message="quote_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Auteur <span style="color: #ef4444;">*</span>
                            </label>
                            <input
                                x-model="author_name"
                                x-name="author_name"
                                type="text"
                                placeholder="Bénéficiaire anonyme"
                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none transition-colors"
                                style="border-color: #e2e8f0; color: #1e293b;"
                                @focus="$el.style.borderColor='{{ $program->color }}'"
                                @blur="$el.style.borderColor='#e2e8f0'">
                            <p x-message="author_name" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div class="flex items-center gap-2">
                            <input
                                x-model="is_published"
                                x-name="is_published"
                                type="checkbox"
                                id="is-published-new"
                                class="rounded">
                            <label for="is-published-new" class="text-xs" style="color: #475569;">
                                Publier immédiatement
                            </label>
                        </div>

                        <button
                            @click="$action('{{ route('admin.programs.stories.store', $program) }}')"
                            :disabled="$fetching()"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: {{ $program->color }};">
                            <span x-show="!$fetching()">Ajouter le témoignage</span>
                            <span x-show="$fetching()">Ajout en cours…</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
