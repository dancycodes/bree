@extends('layouts.admin')

@section('title', 'Paramètres du site')
@section('page_title', 'Paramètres du site')
@section('breadcrumb', 'Paramètres')

@section('content')

    <div x-data="{
            contact_email:       {{ Js::from($settings['contact_email'] ?? '') }},
            contact_phone:       {{ Js::from($settings['contact_phone'] ?? '') }},
            contact_address:     {{ Js::from($settings['contact_address'] ?? '') }},
            social_facebook:     {{ Js::from($settings['social_facebook'] ?? '') }},
            social_instagram:    {{ Js::from($settings['social_instagram'] ?? '') }},
            social_linkedin:     {{ Js::from($settings['social_linkedin'] ?? '') }},
            social_youtube:      {{ Js::from($settings['social_youtube'] ?? '') }},
            social_twitter:      {{ Js::from($settings['social_twitter'] ?? '') }},
            donation_show_total: {{ Js::from($settings['donation_show_total'] ?? '0') }},
            donation_amounts:    {{ Js::from($settings['donation_amounts'] ?? '') }}
         }"
         class="max-w-3xl space-y-6">

        {{-- Contact Information --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
            <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                <h2 class="text-sm font-semibold" style="color: #1e293b;">Informations de contact</h2>
                <p class="text-xs mt-0.5" style="color: #94a3b8;">Affichées dans le pied de page et la page contact</p>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">Adresse e-mail</label>
                    <input type="email" x-model="contact_email"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                           style="border: 1px solid #e2e8f0; outline: none;"
                           placeholder="contact@breefondation.org">
                    <p x-message="contact_email" class="mt-1 text-xs text-red-500"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">Téléphone</label>
                    <input type="text" x-model="contact_phone"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                           style="border: 1px solid #e2e8f0; outline: none;"
                           placeholder="+41 22 345 69 89">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">Adresse postale</label>
                    <textarea x-model="contact_address" rows="2"
                              class="w-full px-3.5 py-2.5 rounded-xl text-sm resize-none"
                              style="border: 1px solid #e2e8f0; outline: none;"
                              placeholder="Rue de la Fondation 1, 1201 Genève, Suisse"></textarea>
                </div>
            </div>
        </div>

        {{-- Social Media Links --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
            <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                <h2 class="text-sm font-semibold" style="color: #1e293b;">Réseaux sociaux</h2>
                <p class="text-xs mt-0.5" style="color: #94a3b8;">Laisser vide pour masquer l'icône dans le pied de page</p>
            </div>
            <div class="px-6 py-5 space-y-4">
                @foreach([
                    ['key' => 'social_facebook',  'label' => 'Facebook',  'placeholder' => 'https://facebook.com/fondationbree'],
                    ['key' => 'social_instagram', 'label' => 'Instagram', 'placeholder' => 'https://instagram.com/fondationbree'],
                    ['key' => 'social_linkedin',  'label' => 'LinkedIn',  'placeholder' => 'https://linkedin.com/company/fondationbree'],
                    ['key' => 'social_youtube',   'label' => 'YouTube',   'placeholder' => 'https://youtube.com/@fondationbree'],
                    ['key' => 'social_twitter',   'label' => 'X (Twitter)', 'placeholder' => 'https://x.com/fondationbree'],
                ] as $social)
                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">{{ $social['label'] }}</label>
                        <input type="url" x-model="{{ $social['key'] }}"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                               style="border: 1px solid #e2e8f0; outline: none;"
                               placeholder="{{ $social['placeholder'] }}">
                        <p x-message="{{ $social['key'] }}" class="mt-1 text-xs text-red-500"></p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Donations --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
            <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                <h2 class="text-sm font-semibold" style="color: #1e293b;">Dons</h2>
                <p class="text-xs mt-0.5" style="color: #94a3b8;">Configuration de la page dons</p>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium" style="color: #374151;">Afficher le total des dons collectés</p>
                        <p class="text-xs mt-0.5" style="color: #94a3b8;">Affiche un compteur sur la page de dons publique</p>
                    </div>
                    <button @click="donation_show_total = donation_show_total === '1' ? '0' : '1'"
                            :style="`background-color: ${donation_show_total === '1' ? '#143c64' : '#e2e8f0'}`"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200">
                        <span :style="`transform: translateX(${donation_show_total === '1' ? '20px' : '2px'})`"
                              class="inline-block h-5 w-5 transform rounded-full bg-white shadow-sm transition-transform duration-200"></span>
                    </button>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color: #374151;">Montants suggérés (séparés par des virgules, en XAF)</label>
                    <input type="text" x-model="donation_amounts"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                           style="border: 1px solid #e2e8f0; outline: none;"
                           placeholder="5000,10000,25000,50000">
                    <p class="mt-1 text-xs" style="color: #94a3b8;">Exemple : 5000,10000,25000,50000</p>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex items-center justify-end gap-3">
            <button @click="$action.patch('{{ route('admin.settings.update') }}', { include: [
                        'contact_email','contact_phone','contact_address',
                        'social_facebook','social_instagram','social_linkedin','social_youtube','social_twitter',
                        'donation_show_total','donation_amounts'
                    ] })"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white"
                    style="background-color: #143c64;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les paramètres
            </button>
        </div>

    </div>

@endsection
