@extends('layouts.public')

@section('title', __('contact.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('contact.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(260px, 35vw, 380px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('contact.hero_heading') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(20,60,100,0.80);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.7);">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">{{ __('nav.home') }}</a></li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">{{ __('contact.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: rgba(255,255,255,0.8);"
                  data-animate="fade-up">
                {{ __('contact.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('contact.hero_heading') }}
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.75);"
               data-animate="fade-up">
                {{ __('contact.hero_sub') }}
            </p>

        </div>
    </section>

    {{-- ================================================================
         CONTACT SECTION — Two columns
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 items-start">

                {{-- ── Left: Contact Info Panel ── --}}
                <div class="lg:col-span-2 rounded-2xl overflow-hidden" style="background-color: #143c64;">

                    <div class="p-8 lg:p-10">

                        <h2 class="font-heading font-bold text-xl mb-8"
                            style="font-family: 'Playfair Display', serif; color: #ffffff;">
                            {{ __('contact.info_heading') }}
                        </h2>

                        <ul class="space-y-6">

                            {{-- Email --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.2);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider mb-1"
                                       style="color: rgba(255,255,255,0.5);">{{ __('contact.info_email_label') }}</p>
                                    <a href="mailto:{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}"
                                       class="text-sm font-medium hover:opacity-80 transition-opacity"
                                       style="color: #ffffff;">
                                        {{ $siteSettings['contact_email'] ?? config('mail.from.address') }}
                                    </a>
                                </div>
                            </li>

                            {{-- Phone --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.2);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider mb-1"
                                       style="color: rgba(255,255,255,0.5);">{{ __('contact.info_phone_label') }}</p>
                                    <a href="tel:{{ preg_replace('/\s/', '', $siteSettings['contact_phone'] ?? '') }}"
                                       class="text-sm font-medium hover:opacity-80 transition-opacity"
                                       style="color: #ffffff;">
                                        {{ $siteSettings['contact_phone'] ?? '' }}
                                    </a>
                                </div>
                            </li>

                            {{-- Address --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.2);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider mb-1"
                                       style="color: rgba(255,255,255,0.5);">{{ __('contact.info_address_label') }}</p>
                                    <p class="text-sm font-medium" style="color: #ffffff;">
                                        {{ $siteSettings['contact_address'] ?? '' }}
                                    </p>
                                </div>
                            </li>

                            {{-- Hours --}}
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                     style="background-color: rgba(200,0,120,0.2);">
                                    <svg class="w-5 h-5" style="color: #c80078;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider mb-1"
                                       style="color: rgba(255,255,255,0.5);">{{ __('contact.info_hours_label') }}</p>
                                    <p class="text-sm font-medium" style="color: #ffffff;">
                                        {{ __('contact.info_hours') }}
                                    </p>
                                </div>
                            </li>

                        </ul>

                        {{-- Social links --}}
                        <div class="mt-10 pt-8" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <p class="text-xs font-semibold uppercase tracking-wider mb-4"
                               style="color: rgba(255,255,255,0.5);">{{ __('contact.social_heading') }}</p>
                            <div class="flex items-center gap-3">
                                @foreach([
                                    ['href' => '#', 'label' => 'Facebook', 'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                                    ['href' => '#', 'label' => 'Instagram', 'icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                                    ['href' => '#', 'label' => 'LinkedIn', 'icon' => 'M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20.05 12 20.05 12 20.05s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z'],
                                ] as $social)
                                    <a href="{{ $social['href'] }}"
                                       aria-label="{{ $social['label'] }}"
                                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                       style="background-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8);">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="{{ $social['icon'] }}"/>
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Right: Contact Form ── --}}
                <div class="lg:col-span-3">

                    <div
                        x-data="{
                            contactName: '',
                            contactEmail: '',
                            contactSubject: '',
                            contactMessage: '',
                            contactSubmitted: false,
                        }"
                        x-sync="['contactName','contactEmail','contactSubject','contactMessage','contactSubmitted']"
                        class="bg-white rounded-2xl shadow-sm"
                        style="border: 1px solid #e2e8f0; padding: 40px;">

                        {{-- Success state --}}
                        <div x-show="contactSubmitted" x-cloak class="text-center py-8">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5"
                                 style="background-color: #f0fdf4;">
                                <svg class="w-8 h-8" style="color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="font-heading font-bold text-xl mb-2" style="font-family: 'Playfair Display', serif; color: #143c64;">
                                {{ __('contact.form_success_heading') }}
                            </h3>
                            <p class="text-sm mb-6" style="color: #64748b;">
                                {{ __('contact.form_success_sub') }}
                            </p>
                            <button @click="contactSubmitted = false"
                                    class="btn-outline text-sm px-5 py-2.5">
                                {{ __('contact.form_new_btn') }}
                            </button>
                        </div>

                        {{-- Form --}}
                        <div x-show="!contactSubmitted">

                            <h2 class="font-heading font-bold text-xl mb-6"
                                style="font-family: 'Playfair Display', serif; color: #143c64;">
                                {{ __('contact.form_heading') }}
                            </h2>

                            <form @submit.prevent="$action('{{ route('public.contact.store') }}', { include: ['contactName','contactEmail','contactSubject','contactMessage'] })"
                                  class="space-y-5">

                                @honeypot

                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-1.5" style="color: #374151;">
                                        {{ __('contact.form_name_label') }}
                                    </label>
                                    <input type="text"
                                           x-name="contactName"
                                           x-model="contactName"
                                           placeholder="{{ __('contact.form_name_placeholder') }}"
                                           class="w-full rounded-xl text-sm px-4 py-3 transition-colors focus:outline-none"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b;"
                                           autocomplete="name">
                                    <p x-message="contactName" class="mt-1 text-xs" style="color: #dc2626;"></p>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-1.5" style="color: #374151;">
                                        {{ __('contact.form_email_label') }}
                                    </label>
                                    <input type="email"
                                           x-name="contactEmail"
                                           x-model="contactEmail"
                                           placeholder="{{ __('contact.form_email_placeholder') }}"
                                           class="w-full rounded-xl text-sm px-4 py-3 transition-colors focus:outline-none"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b;"
                                           autocomplete="email">
                                    <p x-message="contactEmail" class="mt-1 text-xs" style="color: #dc2626;"></p>
                                </div>

                                {{-- Subject --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-1.5" style="color: #374151;">
                                        {{ __('contact.form_subject_label') }}
                                    </label>
                                    <input type="text"
                                           x-name="contactSubject"
                                           x-model="contactSubject"
                                           placeholder="{{ __('contact.form_subject_placeholder') }}"
                                           class="w-full rounded-xl text-sm px-4 py-3 transition-colors focus:outline-none"
                                           style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b;">
                                    <p x-message="contactSubject" class="mt-1 text-xs" style="color: #dc2626;"></p>
                                </div>

                                {{-- Message --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-1.5" style="color: #374151;">
                                        {{ __('contact.form_message_label') }}
                                    </label>
                                    <textarea x-name="contactMessage"
                                              x-model="contactMessage"
                                              rows="6"
                                              placeholder="{{ __('contact.form_message_placeholder') }}"
                                              class="w-full rounded-xl text-sm px-4 py-3 transition-colors focus:outline-none resize-none"
                                              style="border: 1.5px solid #e2e8f0; background-color: #fafafa; color: #1e293b;"></textarea>
                                    <p x-message="contactMessage" class="mt-1 text-xs" style="color: #dc2626;"></p>
                                </div>

                                <button type="submit"
                                        :disabled="$fetching()"
                                        class="btn-primary w-full py-3.5 rounded-xl font-semibold text-sm transition-all"
                                        style="opacity: 1;"
                                        :style="$fetching() ? 'opacity: 0.7; cursor: not-allowed;' : ''">
                                    <span x-show="!$fetching()">{{ __('contact.form_submit_btn') }}</span>
                                    <span x-show="$fetching()" x-cloak>{{ __('contact.form_submitting_btn') }}</span>
                                </button>

                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
