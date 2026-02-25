<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $__seoTitle = trim($__env->yieldContent('title'))
            ?: config('app.name') . ' — ' . __('meta.tagline');
        $__seoDesc  = trim($__env->yieldContent('meta_description'))
            ?: __('meta.default_description');
        $__seoImage = trim($__env->yieldContent('og_image'))
            ?: asset('images/logo.png');
    @endphp
    <x-seo :title="$__seoTitle" :description="$__seoDesc" :image="$__seoImage" :url="url()->current()" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- PWA --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#c80078">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Gale (Alpine.js + SSE + Morph) --}}
    @gale

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="antialiased min-h-screen flex flex-col" style="font-family: 'Inter', sans-serif; color: #1a1a2e; background-color: #ffffff;">

    {{-- ================================================================
         GLOBAL NAV LOADER (Gale navigation indicator)
         ================================================================ --}}
    <div
        x-data
        x-show="$gale.loading"
        x-transition:enter="transition-opacity duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-end="opacity-0"
        style="display: none;"
        class="fixed top-0 left-0 right-0 z-[9999] h-0.5 bg-transparent">
        <div class="h-full w-full animate-pulse" style="background-color: #c80078;"></div>
    </div>

    {{-- ================================================================
         HEADER / NAVIGATION
         Wrapper div holds x-data so the mobile overlay can be a sibling
         to the header (avoids backdrop-filter stacking context issue)
         ================================================================ --}}
    <div x-data="{
            mobileOpen: false,
            scrolled: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 20;
                });
            }
        }">
    <header
        class="fixed top-0 left-0 right-0 z-50 bg-white transition-shadow duration-300"
        :class="scrolled ? 'shadow-md' : ''"
        style="border-bottom: 1px solid rgba(20,60,100,0.08);">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 lg:h-20" style="height: 4.5rem;">

                {{-- Logo --}}
                <a href="{{ route('public.home') }}" class="flex items-center flex-shrink-0" wire:navigate>
                    <img src="{{ asset('images/logo.png') }}"
                         alt="{{ config('app.name') }}"
                         class="h-12 w-auto lg:h-14 object-contain">
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-1" x-navigate>
                    @php
                        $navLinks = [
                            ['route' => 'public.home',     'label' => __('nav.home')],
                            ['route' => 'public.about',    'label' => __('nav.about')],
                            ['route' => 'public.programs', 'label' => __('nav.programs')],
                            ['route' => 'public.news',     'label' => __('nav.news')],
                            ['route' => 'public.events',   'label' => __('nav.events')],
                            ['route' => 'public.gallery',  'label' => __('nav.gallery')],
                            ['route' => 'public.partners', 'label' => __('nav.partners')],
                        ];
                    @endphp

                    @foreach ($navLinks as $link)
                        @if (Route::has($link['route']))
                            <a href="{{ route($link['route']) }}"
                               class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150 relative group"
                               style="color: {{ request()->routeIs(str_replace('public.', 'public.*' ?: $link['route'], $link['route'])) ? '#c80078' : '#143c64' }};"
                               @mouseover="$el.style.color='#c80078'"
                               @mouseout="$el.style.color='{{ request()->routeIs($link['route']) ? '#c80078' : '#143c64' }}'">
                                {{ $link['label'] }}
                                <span class="absolute bottom-0 left-3 right-3 h-0.5 rounded-full transition-transform duration-200 origin-left scale-x-0 group-hover:scale-x-100"
                                      style="background-color: #c80078;"></span>
                            </a>
                        @endif
                    @endforeach
                </nav>

                {{-- Right Side: Language Switcher + CTA --}}
                <div class="hidden lg:flex items-center gap-4">

                    {{-- Language Switcher --}}
                    <div class="flex items-center gap-0.5 text-xs font-semibold tracking-widest" style="color: #143c64;">
                        <a href="{{ route('lang.switch', 'fr') }}"
                           class="px-2 py-1 rounded transition-colors duration-150"
                           style="{{ app()->getLocale() === 'fr' ? 'color: #c80078;' : 'color: #143c64; opacity: 0.5;' }}"
                           @mouseover="$el.style.opacity='1'"
                           @mouseout="$el.style.opacity='{{ app()->getLocale() === 'fr' ? '1' : '0.5' }}'">
                            FR
                        </a>
                        <span style="color: #143c64; opacity: 0.3;">|</span>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="px-2 py-1 rounded transition-colors duration-150"
                           style="{{ app()->getLocale() === 'en' ? 'color: #c80078;' : 'color: #143c64; opacity: 0.5;' }}"
                           @mouseover="$el.style.opacity='1'"
                           @mouseout="$el.style.opacity='{{ app()->getLocale() === 'en' ? '1' : '0.5' }}'">
                            EN
                        </a>
                    </div>

                    {{-- Donate CTA --}}
                    @if (Route::has('public.donate'))
                        <a href="{{ route('public.donate') }}"
                           class="btn-primary text-sm px-5 py-2.5 rounded-lg font-semibold">
                            {{ __('nav.donate') }}
                        </a>
                    @endif
                </div>

                {{-- Mobile Hamburger --}}
                <button
                    @click="mobileOpen = !mobileOpen"
                    class="lg:hidden flex flex-col gap-1.5 p-2 rounded-md transition-colors"
                    :aria-label="mobileOpen ? '{{ __('ui.close') }}' : 'Menu'"
                    aria-expanded="false"
                    :aria-expanded="mobileOpen.toString()">
                    <span class="block w-6 h-0.5 rounded-full transition-all duration-300"
                          style="background-color: #143c64;"
                          :class="mobileOpen ? 'rotate-45 translate-y-2' : ''"></span>
                    <span class="block w-6 h-0.5 rounded-full transition-all duration-300"
                          style="background-color: #143c64;"
                          :class="mobileOpen ? 'opacity-0' : ''"></span>
                    <span class="block w-6 h-0.5 rounded-full transition-all duration-300"
                          style="background-color: #143c64;"
                          :class="mobileOpen ? '-rotate-45 -translate-y-2' : ''"></span>
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile Menu Overlay — sibling to header, outside it to avoid stacking context --}}
    <div
        :style="`background-color:#002850; top:4.5rem; display:${mobileOpen ? 'flex' : 'none'}; opacity:${mobileOpen ? '1' : '0'}; transition: opacity 0.3s ease;`"
        class="fixed left-0 right-0 bottom-0 z-40 flex-col overflow-y-auto"
        style="background-color:#002850; top:4.5rem; display:none;">

        <div class="flex flex-col justify-center px-8 py-12 min-h-full">
            <nav class="flex flex-col gap-1" x-navigate>
                @foreach ($navLinks as $link)
                    @if (Route::has($link['route']))
                        <a href="{{ route($link['route']) }}"
                           @click="mobileOpen = false"
                           class="text-3xl font-medium py-3 border-b transition-colors duration-150 block"
                           style="font-family: 'Playfair Display', serif; color: rgba(255,255,255,0.85); border-color: rgba(255,255,255,0.1);"
                           @mouseover="$el.style.color='#c8a03c'"
                           @mouseout="$el.style.color='rgba(255,255,255,0.85)'">
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach

                @if (Route::has('public.donate'))
                    <a href="{{ route('public.donate') }}"
                       @click="mobileOpen = false"
                       class="mt-6 btn-primary text-center text-base py-3.5 rounded-xl w-full block">
                        {{ __('nav.donate') }}
                    </a>
                @endif
            </nav>

            {{-- Mobile Language Switcher --}}
            <div class="mt-10 flex items-center gap-4">
                <a href="{{ route('lang.switch', 'fr') }}"
                   class="text-sm font-bold tracking-widest transition-colors px-3 py-1.5 rounded-md"
                   style="{{ app()->getLocale() === 'fr' ? 'color: #c8a03c; background: rgba(200,160,60,0.15);' : 'color: rgba(255,255,255,0.4);' }}">
                    FR
                </a>
                <a href="{{ route('lang.switch', 'en') }}"
                   class="text-sm font-bold tracking-widest transition-colors px-3 py-1.5 rounded-md"
                   style="{{ app()->getLocale() === 'en' ? 'color: #c8a03c; background: rgba(200,160,60,0.15);' : 'color: rgba(255,255,255,0.4);' }}">
                    EN
                </a>
            </div>

            {{-- Mobile Contact --}}
            <div class="mt-auto pt-8 text-xs" style="color: rgba(255,255,255,0.4);">
                @if($siteSettings['contact_email'] ?? null)
                    <p>{{ $siteSettings['contact_email'] }}</p>
                @endif
                @if($siteSettings['contact_phone'] ?? null)
                    <p>{{ $siteSettings['contact_phone'] }}</p>
                @endif
            </div>
        </div>
    </div>
    </div>{{-- end x-data wrapper --}}

    {{-- Spacer for fixed header --}}
    <div class="h-[4.5rem]"></div>

    {{-- ================================================================
         MAIN CONTENT
         ================================================================ --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- ================================================================
         FOOTER
         ================================================================ --}}
    <footer style="background-color: #002850; color: rgba(255,255,255,0.8);">

        {{-- Main Footer --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                {{-- Brand Column --}}
                <div class="lg:col-span-1">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-16 w-auto mb-5 brightness-0 invert">
                    <p class="text-sm leading-relaxed mb-6" style="color: rgba(255,255,255,0.6); font-family: 'Playfair Display', serif; font-style: italic;">
                        Protéger. Élever. Inspirer.<br>
                        <span class="text-xs not-italic" style="font-family: 'Inter', sans-serif;">Pour un avenir plus humain.</span>
                    </p>
                    {{-- Social Links --}}
                    @php
                        $socialLinks = [
                            ['key' => 'social_facebook',  'name' => 'Facebook',  'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                            ['key' => 'social_instagram', 'name' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                            ['key' => 'social_linkedin',  'name' => 'LinkedIn',  'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
                            ['key' => 'social_youtube',   'name' => 'YouTube',   'icon' => 'M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z'],
                            ['key' => 'social_twitter',   'name' => 'X',         'icon' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                        ];
                        $activeSocials = array_filter($socialLinks, fn($s) => !empty($siteSettings[$s['key']] ?? ''));
                    @endphp
                    @if(count($activeSocials) > 0)
                        <div class="flex gap-3">
                            @foreach ($activeSocials as $social)
                                <a href="{{ $siteSettings[$social['key']] }}"
                                   target="_blank" rel="noopener"
                                   aria-label="{{ $social['name'] }}"
                                   class="w-9 h-9 rounded-full flex items-center justify-center transition-colors duration-150"
                                   style="background-color: rgba(255,255,255,0.08);"
                                   @mouseover="$el.style.backgroundColor='#c80078'"
                                   @mouseout="$el.style.backgroundColor='rgba(255,255,255,0.08)'">
                                    <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="{{ $social['icon'] }}"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Programs Column --}}
                <div>
                    <h4 class="text-xs font-bold tracking-widest uppercase mb-6" style="color: #c8a03c;">
                        {{ __('nav.programs') }}
                    </h4>
                    <ul class="space-y-3 text-sm">
                        @foreach ([
                            'BREE PROTÈGE',
                            'BREE ÉLÈVE',
                            'BREE RESPIRE',
                        ] as $program)
                            <li>
                                <a href="#"
                                   class="transition-colors duration-150 hover:text-white"
                                   style="color: rgba(255,255,255,0.6);">
                                    {{ $program }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Quick Links Column --}}
                <div>
                    <h4 class="text-xs font-bold tracking-widest uppercase mb-6" style="color: #c8a03c;">
                        Liens Rapides
                    </h4>
                    <ul class="space-y-3 text-sm">
                        @foreach ([
                            ['label' => __('nav.about'),    'route' => 'public.about'],
                            ['label' => __('nav.news'),     'route' => 'public.news'],
                            ['label' => __('nav.events'),   'route' => 'public.events'],
                            ['label' => __('nav.gallery'),  'route' => 'public.gallery'],
                            ['label' => __('nav.partners'), 'route' => 'public.partners'],
                            ['label' => __('nav.contact'),  'route' => 'public.contact'],
                        ] as $link)
                            <li>
                                @if (Route::has($link['route']))
                                    <a href="{{ route($link['route']) }}"
                                       class="transition-colors duration-150 hover:text-white"
                                       style="color: rgba(255,255,255,0.6);">
                                        {{ $link['label'] }}
                                    </a>
                                @else
                                    <span style="color: rgba(255,255,255,0.6);">{{ $link['label'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact Column --}}
                <div>
                    <h4 class="text-xs font-bold tracking-widest uppercase mb-6" style="color: #c8a03c;">
                        {{ __('nav.contact') }}
                    </h4>
                    <ul class="space-y-4 text-sm" style="color: rgba(255,255,255,0.6);">
                        @if(!empty($siteSettings['contact_email'] ?? ''))
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $siteSettings['contact_email'] }}" class="hover:text-white transition-colors">
                                {{ $siteSettings['contact_email'] }}
                            </a>
                        </li>
                        @endif
                        @if(!empty($siteSettings['contact_phone'] ?? ''))
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $siteSettings['contact_phone'] }}</span>
                        </li>
                        @endif
                        @if(!empty($siteSettings['contact_address'] ?? ''))
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color: #c8a03c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $siteSettings['contact_address'] }}</span>
                        </li>
                        @endif
                    </ul>

                    {{-- Donate CTA in footer --}}
                    @if (Route::has('public.donate'))
                        <div class="mt-8">
                            <a href="{{ route('public.donate') }}" class="btn-primary text-sm py-3 px-6 rounded-lg w-full text-center block">
                                {{ __('nav.donate') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div style="border-top: 1px solid rgba(255,255,255,0.08);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs" style="color: rgba(255,255,255,0.4);">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
                </p>
                <div class="flex gap-4 text-xs" style="color: rgba(255,255,255,0.4);">
                    <a href="#" class="hover:text-white transition-colors">Mentions légales</a>
                    <a href="#" class="hover:text-white transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

</body>
</html>
