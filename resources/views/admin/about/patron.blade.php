@extends('layouts.admin')

@section('title', 'Marraine — À Propos')
@section('page_title', 'Profil de la marraine')
@section('breadcrumb', 'À Propos › Marraine')

@section('content')

    <div
        x-data="{
            name: {{ json_encode($patron->name ?? '') }},
            title_fr: {{ json_encode($patron->title_fr ?? '') }},
            title_en: {{ json_encode($patron->title_en ?? '') }},
            role_fr: {{ json_encode($patron->role_fr ?? '') }},
            role_en: {{ json_encode($patron->role_en ?? '') }},
            description_fr: {{ json_encode($patron->description_fr ?? '') }},
            description_en: {{ json_encode($patron->description_en ?? '') }},
            quote_fr: {{ json_encode($patron->quote_fr ?? '') }},
            quote_en: {{ json_encode($patron->quote_en ?? '') }},
            photo_path: {{ json_encode($patron->photo_path ?? '') }},
            activeLang: 'fr'
        }"
        x-sync="['name','title_fr','title_en','role_fr','role_en','description_fr','description_en','quote_fr','quote_en','photo_path']">

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

                {{-- Language tabs --}}
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

                    <div class="p-6 space-y-5">

                        {{-- Title --}}
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

                        {{-- Role --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Rôle (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="role_fr" x-name="role_fr" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="role_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Role (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="role_en" x-name="role_en" type="text"
                                   class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="role_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Description --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description (FR)
                            </label>
                            <textarea x-model="description_fr" x-name="description_fr" rows="8"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p class="text-xs mt-1" style="color: #cbd5e1;">Séparez les paragraphes par une ligne vide.</p>
                            <p x-message="description_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Description (EN)
                            </label>
                            <textarea x-model="description_en" x-name="description_en" rows="8"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p class="text-xs mt-1" style="color: #cbd5e1;">Separate paragraphs with a blank line.</p>
                            <p x-message="description_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        {{-- Quote --}}
                        <div x-show="activeLang === 'fr'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Citation (FR)
                            </label>
                            <textarea x-model="quote_fr" x-name="quote_fr" rows="3"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="quote_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>
                        <div x-show="activeLang === 'en'">
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Quote (EN)
                            </label>
                            <textarea x-model="quote_en" x-name="quote_en" rows="3"
                                      class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none resize-none"
                                      style="border-color: #e2e8f0; color: #1e293b;"></textarea>
                            <p x-message="quote_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                {{-- Photo path --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">Photo</h3>

                    <template x-if="photo_path">
                        <div class="rounded-xl overflow-hidden mb-3" style="height: 160px;">
                            <img :src="'/' + photo_path"
                                 alt="Preview"
                                 class="w-full h-full object-cover">
                        </div>
                    </template>

                    <template x-if="!photo_path">
                        <div class="rounded-xl mb-3 flex items-center justify-center"
                             style="height: 160px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                            <span class="text-xs" style="color: #94a3b8;">Aucune photo configurée</span>
                        </div>
                    </template>

                    <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                        Chemin de l'image
                    </label>
                    <input x-model="photo_path" x-name="photo_path" type="text"
                           class="w-full text-xs px-3 py-2 rounded-lg border focus:outline-none font-mono"
                           style="border-color: #e2e8f0; color: #1e293b;"
                           placeholder="images/sections/marraine.jpg">
                    <p x-message="photo_path" class="text-xs mt-1" style="color: #ef4444;"></p>
                </div>

                {{-- Save button --}}
                <button
                    @click="$action.patch('{{ route('admin.about.patron.update') }}')"
                    :disabled="$fetching()"
                    class="w-full py-3 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                    style="background-color: #c80078;">
                    <span x-show="!$fetching()">Enregistrer</span>
                    <span x-show="$fetching()">Enregistrement…</span>
                </button>

                {{-- Quick link --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold mb-3" style="color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Accès rapide</h3>
                    <a href="{{ route('public.about') }}" target="_blank"
                       class="flex items-center gap-2 text-sm transition-colors"
                       style="color: #475569;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Voir la page À Propos
                    </a>
                </div>

            </div>

        </div>

    </div>

@endsection
