@extends('layouts.public')

@section('title', 'Devenir Bénévole — ' . config('app.name'))
@section('meta_description', 'Rejoignez l\'équipe bénévole de la Fondation BREE et contribuez à l\'autonomisation des femmes et à la protection de l\'enfance.')

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 40vw, 420px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="Devenir Bénévole"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(200,0,120,0.75);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.7);">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">Accueil</a></li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li><a href="{{ route('public.partners') }}" class="hover:text-white transition-colors">Partenaires</a></li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">Devenir Bénévole</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.8);"
                  data-animate="fade-up">
                Rejoignez-nous
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                Devenir Bénévole
            </h1>

        </div>
    </section>

    {{-- ================================================================
         FORM SECTION
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                x-data="{
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    cityCountry: '',
                    areas: [],
                    availability: 'flexible',
                    motivation: '',
                    submitted: false,
                    toggleArea(area) {
                        const idx = this.areas.indexOf(area);
                        if (idx === -1) {
                            this.areas.push(area);
                        } else {
                            this.areas.splice(idx, 1);
                        }
                    }
                }"
                x-sync>

                {{-- Success state --}}
                <div x-show="submitted"
                     class="text-center py-16" style="display: none;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"
                         style="background-color: #dcfce7;">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             style="color: #16a34a;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-3"
                        style="color: #143c64; font-family: 'Playfair Display', serif;">
                        Candidature reçue !
                    </h2>
                    <p class="text-base mb-8" style="color: #64748b;">
                        Merci pour votre intérêt. Nous examinerons votre candidature et vous contacterons prochainement.
                    </p>
                    <button @click="submitted = false"
                            class="text-sm font-semibold transition-opacity hover:opacity-80"
                            style="color: #c80078;">
                        ← Soumettre une autre candidature
                    </button>
                </div>

                {{-- Form --}}
                <div x-show="!submitted">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl font-bold mb-3"
                            style="color: #143c64; font-family: 'Playfair Display', serif;"
                            data-animate="fade-up">
                            Formulaire de candidature bénévole
                        </h2>
                        <p class="text-base max-w-xl mx-auto" style="color: #64748b;" data-animate="fade-up">
                            Remplissez ce formulaire pour rejoindre notre équipe bénévole. Tous les champs marqués * sont obligatoires.
                        </p>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm p-8 lg:p-10 space-y-6">

                        {{-- Name row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    Prénom <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="firstName" x-name="firstName" type="text"
                                       placeholder="Votre prénom"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="firstName" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    Nom <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="lastName" x-name="lastName" type="text"
                                       placeholder="Votre nom de famille"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-colors"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="lastName" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                        </div>

                        {{-- Email & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    Email <span style="color: #c80078;">*</span>
                                </label>
                                <input x-model="email" x-name="email" type="email"
                                       placeholder="votre@email.com"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                                <p x-message="email" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                    Téléphone
                                </label>
                                <input x-model="phone" x-name="phone" type="tel"
                                       placeholder="+237 6XX XXX XXX"
                                       class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;">
                            </div>
                        </div>

                        {{-- City/Country --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                Ville / Pays
                            </label>
                            <input x-model="cityCountry" x-name="cityCountry" type="text"
                                   placeholder="Douala, Cameroun"
                                   class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                        </div>

                        {{-- Areas of interest (checkbox cards) --}}
                        <div>
                            <label class="block text-sm font-semibold mb-3" style="color: #475569;">
                                Programmes d'intérêt <span style="color: #c80078;">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach (['protege' => ['label' => 'BREE PROTÈGE', 'desc' => 'Protection de l\'enfance', 'color' => '#143c64'], 'eleve' => ['label' => 'BREE ÉLÈVE', 'desc' => 'Éducation & bourses', 'color' => '#c80078'], 'respire' => ['label' => 'BREE RESPIRE', 'desc' => 'Environnement & santé', 'color' => '#16a34a']] as $key => $prog)
                                    <button
                                        type="button"
                                        @click="toggleArea('{{ $key }}')"
                                        :style="areas.includes('{{ $key }}')
                                            ? 'border-color: {{ $prog['color'] }}; background-color: {{ $prog['color'] }}15;'
                                            : 'border-color: #e2e8f0; background-color: #ffffff;'"
                                        class="text-left p-4 rounded-xl border-2 transition-all">
                                        <div class="flex items-start gap-3">
                                            <div class="w-5 h-5 rounded flex items-center justify-center flex-shrink-0 mt-0.5 transition-colors"
                                                 :style="areas.includes('{{ $key }}')
                                                     ? 'background-color: {{ $prog['color'] }};'
                                                     : 'background-color: #e2e8f0;'">
                                                <svg x-show="areas.includes('{{ $key }}')"
                                                     class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold" style="color: #143c64;">{{ $prog['label'] }}</p>
                                                <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $prog['desc'] }}</p>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            <p x-message="areas" class="text-xs mt-1.5" style="color: #ef4444;"></p>
                        </div>

                        {{-- Availability --}}
                        <div>
                            <label class="block text-sm font-semibold mb-3" style="color: #475569;">
                                Disponibilité <span style="color: #c80078;">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach (['weekends' => 'Week-ends', 'weekdays' => 'Jours ouvrables', 'flexible' => 'Flexible'] as $val => $lbl)
                                    <button
                                        type="button"
                                        @click="availability = '{{ $val }}'"
                                        :style="availability === '{{ $val }}'
                                            ? 'background-color: #c80078; color: #ffffff; border-color: #c80078;'
                                            : 'background-color: #ffffff; color: #475569; border-color: #e2e8f0;'"
                                        class="px-5 py-2.5 rounded-xl text-sm font-semibold border-2 transition-all">
                                        {{ $lbl }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" x-name="availability" :value="availability">
                        </div>

                        {{-- Motivation --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: #475569;">
                                Message de motivation
                            </label>
                            <textarea x-model="motivation" x-name="motivation" rows="5"
                                      placeholder="Partagez vos motivations pour rejoindre la Fondation BREE en tant que bénévole…"
                                      class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none resize-y"
                                      style="border-color: #e2e8f0; color: #1e293b; line-height: 1.7;"></textarea>
                        </div>

                        {{-- Honeypot --}}
                        @honeypot

                        {{-- Submit --}}
                        <button
                            @click="$action('{{ route('public.volunteers.store') }}')"
                            :disabled="$fetching()"
                            class="w-full py-4 rounded-2xl text-sm font-bold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Soumettre ma candidature</span>
                            <span x-show="$fetching()">Envoi en cours…</span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
