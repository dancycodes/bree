@extends('layouts.admin')

@section('title', 'Hero & Section Don')
@section('page_title', 'Contenu de la page d\'accueil')
@section('breadcrumb', 'Hero / CTA')

@section('content')

    <div class="max-w-3xl space-y-6">

        {{-- ================================================================
             HERO SECTION
        ================================================================ --}}
        <div
            x-data="{
                tagline_fr:    {{ Js::from($hero->tagline_fr) }},
                tagline_en:    {{ Js::from($hero->tagline_en) }},
                subtitle_fr:   {{ Js::from($hero->subtitle_fr) }},
                subtitle_en:   {{ Js::from($hero->subtitle_en) }},
                cta1_label_fr: {{ Js::from($hero->cta1_label_fr) }},
                cta1_label_en: {{ Js::from($hero->cta1_label_en) }},
                cta1_url:      {{ Js::from($hero->cta1_url) }},
                cta2_label_fr: {{ Js::from($hero->cta2_label_fr) }},
                cta2_label_en: {{ Js::from($hero->cta2_label_en) }},
                cta2_url:      {{ Js::from($hero->cta2_url) }},
                activeLang: 'fr',
                heroImageFileName: null
            }"

            x-sync="['tagline_fr','tagline_en','subtitle_fr','subtitle_en','cta1_label_fr','cta1_label_en','cta1_url','cta2_label_fr','cta2_label_en','cta2_url']">

            {{-- Card header --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom: 1px solid #f1f5f9;">
                    <div>
                        <h2 class="text-sm font-semibold" style="color: #1e293b;">Section Hero</h2>
                        <p class="text-xs mt-0.5" style="color: #94a3b8;">Bandeau principal visible en haut de la page d'accueil</p>
                    </div>
                    <a href="{{ route('public.home') }}" target="_blank"
                       class="flex items-center gap-1.5 text-xs transition-colors"
                       style="color: #94a3b8;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Voir
                    </a>
                </div>

                <div class="px-6 py-5 space-y-5">

                    {{-- Lang tab switcher --}}
                    <div class="flex gap-1 p-1 rounded-lg w-fit" style="background-color: #f1f5f9;">
                        <button type="button" @click="activeLang = 'fr'"
                                :style="activeLang === 'fr' ? 'background-color: white; color: #c80078; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #64748b;'"
                                class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">
                            FR
                        </button>
                        <button type="button" @click="activeLang = 'en'"
                                :style="activeLang === 'en' ? 'background-color: white; color: #c80078; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #64748b;'"
                                class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">
                            EN
                        </button>
                    </div>

                    {{-- Tagline --}}
                    <div x-show="activeLang === 'fr'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Accroche (FR) <span style="color: #ef4444;">*</span>
                        </label>
                        <input x-model="tagline_fr" x-name="tagline_fr" type="text"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;"
                               placeholder="Protéger. Élever. Inspirer.">
                        <p x-message="tagline_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>
                    <div x-show="activeLang === 'en'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Tagline (EN) <span style="color: #ef4444;">*</span>
                        </label>
                        <input x-model="tagline_en" x-name="tagline_en" type="text"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;"
                               placeholder="Protect. Elevate. Inspire.">
                        <p x-message="tagline_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>

                    {{-- Subtitle --}}
                    <div x-show="activeLang === 'fr'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Sous-titre (FR) <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea x-model="subtitle_fr" x-name="subtitle_fr" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                                  style="border: 1px solid #e2e8f0; outline: none;"
                                  placeholder="La Fondation BREE œuvre pour…"></textarea>
                        <p x-message="subtitle_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>
                    <div x-show="activeLang === 'en'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Subtitle (EN) <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea x-model="subtitle_en" x-name="subtitle_en" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                                  style="border: 1px solid #e2e8f0; outline: none;"
                                  placeholder="The BREE Foundation works for…"></textarea>
                        <p x-message="subtitle_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>

                    {{-- CTA 1 --}}
                    <div class="rounded-xl p-4 space-y-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: #94a3b8;">Bouton principal (CTA 1)</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div x-show="activeLang === 'fr'">
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">Libellé FR *</label>
                                <input x-model="cta1_label_fr" x-name="cta1_label_fr" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Découvrir nos programmes">
                                <p x-message="cta1_label_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                            <div x-show="activeLang === 'en'">
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">Label EN *</label>
                                <input x-model="cta1_label_en" x-name="cta1_label_en" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Discover our programmes">
                                <p x-message="cta1_label_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">URL *</label>
                                <input x-model="cta1_url" x-name="cta1_url" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm font-mono"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="/programmes">
                                <p x-message="cta1_url" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                        </div>
                    </div>

                    {{-- CTA 2 --}}
                    <div class="rounded-xl p-4 space-y-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: #94a3b8;">Bouton secondaire (CTA 2)</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div x-show="activeLang === 'fr'">
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">Libellé FR *</label>
                                <input x-model="cta2_label_fr" x-name="cta2_label_fr" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Faire un Don">
                                <p x-message="cta2_label_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                            <div x-show="activeLang === 'en'">
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">Label EN *</label>
                                <input x-model="cta2_label_en" x-name="cta2_label_en" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Make a Donation">
                                <p x-message="cta2_label_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: #374151;">URL *</label>
                                <input x-model="cta2_url" x-name="cta2_url" type="text"
                                       class="w-full px-3 py-2 rounded-lg text-sm font-mono"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="/faire-un-don">
                                <p x-message="cta2_url" class="mt-1 text-xs" style="color: #ef4444;"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Background image upload --}}
                    <div>
                        <label class="block text-xs font-semibold mb-2" style="color: #374151;">Image de fond</label>
                        @if ($hero->bg_image_path)
                            <div class="rounded-xl overflow-hidden mb-3" style="height: 120px;">
                                <img src="{{ asset($hero->bg_image_path) }}"
                                     alt="Aperçu hero"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="rounded-xl mb-3 flex items-center justify-center"
                                 style="height: 120px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                                <span class="text-xs" style="color: #94a3b8;">Aucune image configurée</span>
                            </div>
                        @endif
                        <label class="flex items-center justify-center gap-2 w-full py-2 rounded-xl text-xs font-semibold cursor-pointer transition-opacity hover:opacity-80"
                               style="background-color: #f1f5f9; color: #475569;">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="heroImageFileName ?? 'Choisir une image'" class="truncate" style="max-width: 180px;"></span>
                            <input type="file" name="hero_image" x-files accept="image/jpeg,image/png,image/webp"
                                   @change="heroImageFileName = $event.target.files[0]?.name ?? null"
                                   class="hidden">
                        </label>
                        <p class="mt-1 text-xs" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 Mo</p>
                        <button type="button"
                                @click="$action.post('{{ route('admin.hero.uploadImage') }}')"
                                :disabled="$fetching() || !heroImageFileName"
                                class="w-full mt-3 py-2 rounded-xl text-xs font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-40"
                                style="background-color: #143c64;">
                            <span x-show="!$fetching()">Téléverser l'image</span>
                            <span x-show="$fetching()">Téléversement…</span>
                        </button>
                    </div>

                    {{-- Save --}}
                    <div class="flex justify-end pt-1">
                        <button
                            @click="$action.patch('{{ route('admin.hero.update') }}')"
                            :disabled="$fetching()"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Enregistrer le hero</span>
                            <span x-show="$fetching()">Enregistrement…</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================================================================
             DONATION CTA SECTION
        ================================================================ --}}
        <div
            x-data="{
                cta_headline_fr: {{ Js::from($cta->headline_fr) }},
                cta_headline_en: {{ Js::from($cta->headline_en) }},
                cta_copy_fr:     {{ Js::from($cta->copy_fr) }},
                cta_copy_en:     {{ Js::from($cta->copy_en) }},
                ctaLang: 'fr',
                ctaImageFileName: null
            }"
            x-sync="['cta_headline_fr','cta_headline_en','cta_copy_fr','cta_copy_en']">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                    <h2 class="text-sm font-semibold" style="color: #1e293b;">Section Don (CTA)</h2>
                    <p class="text-xs mt-0.5" style="color: #94a3b8;">Bandeau d'appel au don affiché sur la page d'accueil</p>
                </div>

                <div class="px-6 py-5 space-y-5">

                    {{-- Lang tabs --}}
                    <div class="flex gap-1 p-1 rounded-lg w-fit" style="background-color: #f1f5f9;">
                        <button type="button" @click="ctaLang = 'fr'"
                                :style="ctaLang === 'fr' ? 'background-color: white; color: #c80078; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #64748b;'"
                                class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">
                            FR
                        </button>
                        <button type="button" @click="ctaLang = 'en'"
                                :style="ctaLang === 'en' ? 'background-color: white; color: #c80078; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #64748b;'"
                                class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">
                            EN
                        </button>
                    </div>

                    {{-- Headline --}}
                    <div x-show="ctaLang === 'fr'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Titre (FR) <span style="color: #ef4444;">*</span>
                        </label>
                        <input x-model="cta_headline_fr" x-name="cta_headline_fr" type="text"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;"
                               placeholder="Votre Générosité Change des Vies">
                        <p x-message="cta_headline_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>
                    <div x-show="ctaLang === 'en'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Headline (EN) <span style="color: #ef4444;">*</span>
                        </label>
                        <input x-model="cta_headline_en" x-name="cta_headline_en" type="text"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;"
                               placeholder="Your Generosity Changes Lives">
                        <p x-message="cta_headline_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>

                    {{-- Copy --}}
                    <div x-show="ctaLang === 'fr'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Texte (FR) <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea x-model="cta_copy_fr" x-name="cta_copy_fr" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                                  style="border: 1px solid #e2e8f0; outline: none;"
                                  placeholder="Chaque don, grand ou petit, permet à la Fondation BREE…"></textarea>
                        <p x-message="cta_copy_fr" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>
                    <div x-show="ctaLang === 'en'">
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">
                            Copy (EN) <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea x-model="cta_copy_en" x-name="cta_copy_en" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                                  style="border: 1px solid #e2e8f0; outline: none;"
                                  placeholder="Every donation, big or small, enables Fondation BREE…"></textarea>
                        <p x-message="cta_copy_en" class="mt-1 text-xs" style="color: #ef4444;"></p>
                    </div>

                    {{-- Background image upload --}}
                    <div>
                        <label class="block text-xs font-semibold mb-2" style="color: #374151;">Image de fond</label>
                        @if ($cta->bg_image_path)
                            <div class="rounded-xl overflow-hidden mb-3" style="height: 100px;">
                                <img src="{{ asset($cta->bg_image_path) }}"
                                     alt="Aperçu section don"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="rounded-xl mb-3 flex items-center justify-center"
                                 style="height: 100px; background-color: #f8f5f0; border: 2px dashed #c8a03c40;">
                                <span class="text-xs" style="color: #94a3b8;">Aucune image configurée</span>
                            </div>
                        @endif
                        <label class="flex items-center justify-center gap-2 w-full py-2 rounded-xl text-xs font-semibold cursor-pointer transition-opacity hover:opacity-80"
                               style="background-color: #f1f5f9; color: #475569;">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="ctaImageFileName ?? 'Choisir une image'" class="truncate" style="max-width: 180px;"></span>
                            <input type="file" name="cta_image" x-files accept="image/jpeg,image/png,image/webp"
                                   @change="ctaImageFileName = $event.target.files[0]?.name ?? null"
                                   class="hidden">
                        </label>
                        <p class="mt-1 text-xs" style="color: #cbd5e1;">JPEG, PNG, WebP — max 5 Mo</p>
                        <button type="button"
                                @click="$action.post('{{ route('admin.hero.cta.uploadImage') }}')"
                                :disabled="$fetching() || !ctaImageFileName"
                                class="w-full mt-3 py-2 rounded-xl text-xs font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-40"
                                style="background-color: #143c64;">
                            <span x-show="!$fetching()">Téléverser l'image</span>
                            <span x-show="$fetching()">Téléversement…</span>
                        </button>
                    </div>

                    {{-- Save --}}
                    <div class="flex justify-end pt-1">
                        <button
                            @click="$action.patch('{{ route('admin.hero.cta.update') }}')"
                            :disabled="$fetching()"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #143c64;">
                            <span x-show="!$fetching()">Enregistrer la section don</span>
                            <span x-show="$fetching()">Enregistrement…</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
