@extends('layouts.admin')

@section('title', $event->title_fr . ' — Événements')
@section('page_title', 'Modifier l\'événement')
@section('breadcrumb', 'Événements › Modifier')

@section('content')

    <div
        x-data="{
            title_fr: {{ Js::from($event->title_fr) }},
            title_en: {{ Js::from($event->title_en) }},
            slug: {{ Js::from($event->slug) }},
            description_fr: {{ Js::from($event->description_fr ?? '') }},
            description_en: {{ Js::from($event->description_en ?? '') }},
            location_fr: {{ Js::from($event->location_fr ?? '') }},
            location_en: {{ Js::from($event->location_en ?? '') }},
            event_date: {{ Js::from($event->event_date->format('Y-m-d')) }},
            event_time: {{ Js::from($event->event_time ? \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') : '') }},
            end_date: {{ Js::from($event->end_date?->format('Y-m-d') ?? '') }},
            end_time: {{ Js::from($event->end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $event->end_time)->format('H:i') : '') }},
            program_slug: {{ Js::from($event->program_slug ?? '') }},
            registration_required: {{ Js::from($event->registration_required) }},
            max_capacity: {{ Js::from($event->max_capacity ? (string) $event->max_capacity : '') }},
            is_published: {{ Js::from($event->is_published) }},
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

                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Lieu (FR)</label>
                            <input x-model="location_fr" x-name="location_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="location_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Location (EN)</label>
                            <input x-model="location_en" x-name="location_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="location_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="space-y-4">
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Description (FR)</label>
                            <textarea x-model="description_fr" x-name="description_fr" rows="10"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Description (EN)</label>
                            <textarea x-model="description_en" x-name="description_en" rows="10"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar (1/3) --}}
            <div class="space-y-5">

                {{-- Dates --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">Date & Heure</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Date de début <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="event_date" x-name="event_date" type="date"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="event_date" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Heure de début</label>
                            <input x-model="event_time" x-name="event_time" type="time"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Date de fin</label>
                            <input x-model="end_date" x-name="end_date" type="date"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="end_date" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Heure de fin</label>
                            <input x-model="end_time" x-name="end_time" type="time"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>
                    </div>
                </div>

                {{-- Publication --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">Publication</h3>
                    <div class="flex items-center justify-between mb-4">
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
                    <div class="flex gap-2">
                        <button
                            @click="$action.patch('{{ route('admin.events.update', $event) }}')"
                            :disabled="$fetching()"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Sauvegarder</span>
                            <span x-show="$fetching()">…</span>
                        </button>
                        @if ($event->is_published)
                            <a href="{{ route('public.events.show', $event) }}" target="_blank"
                               class="flex items-center justify-center px-3 py-2.5 rounded-xl transition-colors"
                               style="border: 1px solid #e2e8f0; color: #64748b;" title="Voir en ligne">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Registration --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">Inscriptions</h3>
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-sm font-medium" style="color: #475569;">Inscriptions requises</label>
                        <button
                            @click="registration_required = !registration_required; if (!registration_required) max_capacity = ''"
                            :style="registration_required ? 'background-color: #c80078;' : 'background-color: #e2e8f0;'"
                            class="relative w-10 h-5 rounded-full transition-colors focus:outline-none">
                            <span class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"
                                  :style="registration_required ? 'transform: translateX(1.25rem)' : 'transform: translateX(0.125rem)'">
                            </span>
                        </button>
                        <input type="hidden" x-name="registration_required" :value="registration_required ? '1' : '0'">
                    </div>
                    <div x-show="registration_required">
                        <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                            Capacité maximale <span class="font-normal" style="color: #94a3b8;">(optionnel)</span>
                        </label>
                        <input x-model="max_capacity" x-name="max_capacity" type="number" min="1"
                               class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                               style="border-color: #e2e8f0; color: #1e293b;"
                               placeholder="Illimitée">
                        <p x-message="max_capacity" class="text-xs mt-1" style="color: #ef4444;"></p>
                        @if ($event->registrations()->count() > 0)
                            <p class="text-xs mt-2 font-medium" style="color: #475569;">
                                {{ $event->registrations()->count() }} inscription(s) actuellement.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Program --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Programme associé</h3>
                    @if ($programs->isEmpty())
                        <p class="text-xs" style="color: #94a3b8;">Aucun programme actif.</p>
                    @else
                        <select x-model="program_slug" x-name="program_slug"
                                class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                style="border-color: #e2e8f0; color: #1e293b;">
                            <option value="">— Aucun —</option>
                            @foreach ($programs as $prog)
                                <option value="{{ $prog->slug }}">{{ $prog->name_fr }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Image --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Image à la une</h3>
                    <div class="rounded-xl mb-3 overflow-hidden" style="height: 130px; background-color: #f8f5f0;">
                        <template x-if="$files('thumbnail') && $files('thumbnail').length > 0">
                            <img :src="$filePreview('thumbnail', 0)" alt="" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!$files('thumbnail') || $files('thumbnail').length === 0">
                            @if ($event->thumbnail_path)
                                <img src="{{ asset($event->thumbnail_path) }}" alt="{{ $event->title_fr }}"
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
                    <p class="text-xs mt-2" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 MB.</p>
                </div>

                {{-- Danger zone --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #ef4444;">Zone critique</h3>
                    <button
                        @click="if (confirm('Supprimer définitivement cet événement ?')) $action.delete('{{ route('admin.events.destroy', $event) }}')"
                        class="w-full py-2 rounded-xl text-xs font-semibold transition-colors"
                        style="border: 1px solid #fecaca; color: #ef4444;">
                        Supprimer l'événement
                    </button>
                </div>

                {{-- Nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="space-y-1">
                        <a href="{{ route('admin.events.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            ← Liste des événements
                        </a>
                        <a href="{{ route('admin.events.create') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Nouvel événement
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
