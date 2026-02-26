<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @gale
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background-color: #f1f5f9; font-family: 'Inter', sans-serif;">

<div
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: false,
        init() {
            this.sidebarCollapsed = window.innerWidth < 1024;
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) this.sidebarOpen = false;
            });
        }
    }"
    class="flex h-screen overflow-hidden">

    {{-- ================================================================
         SIDEBAR
         ================================================================ --}}
    {{-- Overlay for mobile --}}
    <div
        :style="`display:${sidebarOpen ? 'block' : 'none'}`"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-20 lg:hidden"
        style="background-color: rgba(0,0,0,0.5); display: none;"></div>

    {{-- Sidebar Panel --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:static inset-y-0 left-0 z-30 flex flex-col transition-transform duration-300 ease-in-out"
        style="background-color: #002850; width: 260px; min-width: 260px;">

        {{-- Logo / Brand --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b" style="border-color: rgba(255,255,255,0.08);">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto flex-shrink-0">
            <div>
                <p class="text-white font-semibold text-sm leading-tight">{{ config('app.name') }}</p>
                <p class="text-xs" style="color: rgba(255,255,255,0.4);">Administration</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3" x-data x-navigate>
            @php
                $navUnreadMessages = auth()->check() && auth()->user()?->can('messages.view')
                    ? \App\Models\ContactMessage::where('status', 'new')->count()
                    : 0;
                $navPendingApplications = auth()->check() && auth()->user()?->can('applications.view')
                    ? \App\Models\VolunteerApplication::where('status', 'pending')->count()
                      + \App\Models\PartnershipApplication::where('status', 'pending')->count()
                    : 0;

                $adminNavGroups = [
                    // ── Top-level (no group heading) ──
                    [
                        'heading' => null,
                        'items' => [
                            ['label' => __('nav.dashboard'), 'route' => 'admin.dashboard', 'active' => 'admin.dashboard*', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'permission' => null],
                        ],
                    ],

                    // ── Contenu ──
                    [
                        'heading' => __('nav.group.contenu'),
                        'items' => [
                            ['label' => __('nav.news'), 'route' => 'admin.news.index', 'active' => 'admin.news.*', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'permission' => 'news.view'],
                            ['label' => __('nav.events'), 'route' => 'admin.events.index', 'active' => 'admin.events.*', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'permission' => 'events.view'],
                            ['label' => __('nav.programs'), 'route' => 'admin.programs.index', 'active' => 'admin.programs.*', 'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7', 'permission' => 'programs.view'],
                            ['label' => __('nav.gallery'), 'route' => 'admin.gallery.albums.index', 'active' => 'admin.gallery.*', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'permission' => 'gallery.view'],
                            ['label' => __('nav.partners'), 'route' => 'admin.partners.index', 'active' => 'admin.partners.*', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'permission' => 'partners.view'],
                        ],
                    ],

                    // ── À propos ──
                    [
                        'heading' => __('nav.group.a_propos'),
                        'items' => [
                            ['label' => __('nav.founder'), 'route' => 'admin.about.founder.edit', 'active' => 'admin.about.founder.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'permission' => 'about.edit'],
                            ['label' => __('nav.patron'), 'route' => 'admin.about.patron.edit', 'active' => 'admin.about.patron.*', 'icon' => 'M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4', 'permission' => 'about.edit'],
                            ['label' => __('nav.milestones'), 'route' => 'admin.about.milestones.index', 'active' => 'admin.about.milestones.*', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'permission' => 'about.edit'],
                            ['label' => __('nav.team'), 'route' => 'admin.about.team.index', 'active' => 'admin.about.team.*', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'permission' => 'about.view'],
                            ['label' => __('nav.hero_cta'), 'route' => 'admin.hero.index', 'active' => 'admin.hero.*', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'permission' => 'content.edit'],
                            ['label' => __('nav.stats'), 'route' => 'admin.stats.index', 'active' => 'admin.stats.*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'permission' => 'stats.view'],
                        ],
                    ],

                    // ── Interactions ──
                    [
                        'heading' => __('nav.group.interactions'),
                        'items' => [
                            ['label' => __('nav.donations'), 'route' => 'admin.donations.index', 'active' => 'admin.donations.*', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'permission' => 'donations.view'],
                            ['label' => __('nav.applications'), 'route' => 'admin.applications.index', 'active' => ['admin.applications.*', 'admin.partnerships.*'], 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'permission' => 'applications.view', 'badge' => $navPendingApplications],
                            ['label' => __('nav.messages'), 'route' => 'admin.messages.index', 'active' => 'admin.messages.*', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'permission' => 'messages.view', 'badge' => $navUnreadMessages],
                            ['label' => __('nav.newsletter'), 'route' => 'admin.newsletter.index', 'active' => 'admin.newsletter.*', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'permission' => 'newsletter.view'],
                        ],
                    ],

                    // ── Système ──
                    [
                        'heading' => __('nav.group.systeme'),
                        'items' => [
                            ['label' => __('nav.users'), 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permission' => 'users.view'],
                            ['label' => __('nav.roles'), 'route' => 'admin.roles.index', 'active' => 'admin.roles.*', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'permission' => 'roles.view'],
                            ['label' => __('nav.settings'), 'route' => 'admin.settings.index', 'active' => 'admin.settings.*', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'permission' => 'settings.manage'],
                        ],
                    ],
                ];
            @endphp

            @foreach ($adminNavGroups as $group)
                @php
                    $visibleItems = collect($group['items'])->filter(fn ($item) =>
                        $item['permission'] === null || auth()->user()?->can($item['permission'])
                    );
                @endphp

                @if ($visibleItems->isNotEmpty())
                    {{-- Group heading --}}
                    @if ($group['heading'])
                        <p class="px-3 pt-4 pb-1.5 text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">
                            {{ $group['heading'] }}
                        </p>
                    @endif

                    @foreach ($visibleItems as $item)
                        @php
                            $activePatterns = is_array($item['active']) ? $item['active'] : [$item['active']];
                            $isActive = request()->routeIs(...$activePatterns);
                        @endphp
                        @if (Route::has($item['route']))
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-0.5 transition-all duration-150 relative group"
                               style="{{ $isActive ? 'background-color: rgba(200,0,120,0.15); color: white;' : 'color: rgba(255,255,255,0.65);' }}"
                               @mouseover="if (!{{ $isActive ? 'true' : 'false' }}) $el.style.backgroundColor='rgba(255,255,255,0.06)'"
                               @mouseout="if (!{{ $isActive ? 'true' : 'false' }}) $el.style.backgroundColor='transparent'">

                                {{-- Active indicator bar --}}
                                @if ($isActive)
                                    <span class="absolute left-0 inset-y-1 w-1 rounded-r-full" style="background-color: #c80078;"></span>
                                @endif

                                {{-- Icon --}}
                                <svg class="w-5 h-5 flex-shrink-0 {{ $isActive ? '' : 'opacity-60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>

                                <span>{{ $item['label'] }}</span>
                                @if (!empty($item['badge']))
                                    <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                          style="background-color: #c80078; color: #ffffff;">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        @else
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-0.5 cursor-not-allowed"
                                 style="color: rgba(255,255,255,0.3);">
                                <svg class="w-5 h-5 flex-shrink-0 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>
                                <span>{{ $item['label'] }}</span>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </nav>

        {{-- Sidebar Footer --}}
        <div class="px-4 py-4 border-t" style="border-color: rgba(255,255,255,0.08);">
            <a href="{{ route('public.home') }}"
               target="_blank"
               class="flex items-center gap-2 text-xs transition-colors"
               style="color: rgba(255,255,255,0.4);"
               @mouseover="$el.style.color='rgba(255,255,255,0.7)'"
               @mouseout="$el.style.color='rgba(255,255,255,0.4)'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Voir le site public
            </a>
        </div>
    </aside>

    {{-- ================================================================
         MAIN CONTENT AREA
         ================================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Bar --}}
        <header class="flex items-center gap-4 px-4 lg:px-6 py-3 bg-white border-b flex-shrink-0" style="border-color: #e2e8f0;">

            {{-- Mobile Hamburger --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 rounded-lg transition-colors"
                style="color: #143c64;"
                @mouseover="$el.style.backgroundColor='#f1f5f9'"
                @mouseout="$el.style.backgroundColor='transparent'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title / Breadcrumb --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-base font-semibold truncate" style="color: #143c64; font-family: 'Playfair Display', serif;">
                    @yield('page_title', 'Tableau de bord')
                </h1>
                @hasSection('breadcrumb')
                    <p class="text-xs mt-0.5" style="color: #94a3b8;">@yield('breadcrumb')</p>
                @endif
            </div>

            {{-- Right side: User info + Logout --}}
            <div class="flex items-center gap-3">
                {{-- User Name --}}
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                         style="background-color: #c80078;">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-medium leading-tight" style="color: #1e293b;">
                            {{ auth()->user()?->name }}
                        </p>
                        <p class="text-xs leading-tight" style="color: #94a3b8;">
                            {{ auth()->user()?->roles->first()?->name ?? 'Admin' }}
                        </p>
                    </div>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors"
                            style="color: #ef4444; background-color: #fef2f2;"
                            @mouseover="$el.style.backgroundColor='#fee2e2'"
                            @mouseout="$el.style.backgroundColor='#fef2f2'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Déconnexion</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            @if (session('success'))
                <div class="mb-4 p-4 rounded-xl text-sm font-medium flex items-center gap-2"
                     style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;"
                     x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Global Toast Notifications --}}
{{-- Brand colors: success=green, error=magenta #c80078, info=navy #143c64 --}}
<div
    x-data="{ show: false, message: '', type: 'success' }"
    @toast.window="message = $event.detail.message; type = $event.detail.type || 'success'; show = true; setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    :style="type === 'success' ? 'background-color:#16a34a' : (type === 'error' ? 'background-color:#c80078' : 'background-color:#143c64')"
    class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 rounded-xl text-sm font-semibold text-white shadow-xl max-w-sm"
    style="display: none;">
    {{-- Success icon --}}
    <template x-if="type === 'success'">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </template>
    {{-- Error icon --}}
    <template x-if="type === 'error'">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </template>
    {{-- Info icon --}}
    <template x-if="type === 'info'">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </template>
    <span x-text="message" class="leading-snug"></span>
</div>

@stack('scripts')

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('success')), type: 'success' } }));
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('error')), type: 'error' } }));
});
</script>
@endif

</body>
</html>
