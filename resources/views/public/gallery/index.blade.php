@extends('layouts.public')

@section('title', __('gallery.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('gallery.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 35vw, 420px);">

        <img src="{{ asset('images/sections/gallery-placeholder.jpg') }}"
             alt="{{ __('gallery.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.78);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            <nav class="mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.6);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li style="color: #ffffff;">{{ __('gallery.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('gallery.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('gallery.hero_heading') }}
            </h1>

            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

        </div>

    </section>

    {{-- ================================================================
         ALBUMS GRID
         ================================================================ --}}
    <section class="py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($albums->isEmpty())

                {{-- Empty state --}}
                <div class="text-center py-24">
                    <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6"
                         style="background-color: #ffffff;">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2"
                             style="color: #c8a03c;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                        </svg>
                    </div>
                    <h2 class="font-heading text-2xl font-bold mb-3"
                        style="font-family: 'Playfair Display', serif; color: #1e293b;">
                        {{ __('gallery.empty_heading') }}
                    </h2>
                    <p class="text-sm" style="color: #64748b;">{{ __('gallery.empty_sub') }}</p>
                </div>

            @else

                <div class="mb-12">
                    <h2 class="font-heading text-3xl font-bold"
                        style="font-family: 'Playfair Display', serif; color: #002850;"
                        data-animate="fade-up">
                        {{ __('gallery.albums_title') }}
                    </h2>
                    <div class="mt-3 h-1 w-12 rounded-full" style="background-color: #c8a03c;"></div>
                </div>

                {{-- Albums grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($albums as $album)
                        <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300"
                                 data-animate="fade-up">

                            {{-- Cover photo --}}
                            <div class="relative overflow-hidden" style="height: 220px;">
                                @if ($album->coverUrl())
                                    <img src="{{ $album->coverUrl() }}"
                                         alt="{{ $album->title() }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background-color: #f1f5f9;">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1" style="color: #cbd5e1;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Hover overlay --}}
                                <div class="absolute inset-0 flex items-end p-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                     style="background: linear-gradient(to top, rgba(0,20,60,0.82) 0%, transparent 60%);">
                                    <span class="text-xs font-semibold text-white uppercase tracking-wider">
                                        {{ __('gallery.view_album') }}
                                        <span class="ml-1">→</span>
                                    </span>
                                </div>

                                {{-- Photo count badge --}}
                                @if ($album->photos_count > 0)
                                    <div class="absolute top-3 right-3">
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-white"
                                              style="background-color: rgba(0,0,0,0.55);">
                                            {{ trans_choice('gallery.photos_count', $album->photos_count) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Card body --}}
                            <div class="p-5">
                                <h3 class="font-heading font-bold text-base leading-snug mb-2"
                                    style="font-family: 'Playfair Display', serif; color: #002850;">
                                    {{ $album->title() }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs" style="color: #94a3b8;">
                                        {{ $album->created_at->translatedFormat('F Y') }}
                                    </p>
                                    {{-- Link placeholder for F-050 --}}
                                    <a href="{{ route('public.gallery.show', $album) }}"
                                       class="text-xs font-semibold transition-colors hover:opacity-70"
                                       style="color: #c80078;">
                                        {{ __('gallery.view_album') }} →
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($albums->hasPages())
                    <div class="mt-12 flex items-center justify-center gap-2">
                        @if (! $albums->onFirstPage())
                            <a href="{{ $albums->previousPageUrl() }}"
                               class="px-4 py-2 rounded-xl text-sm font-medium transition-colors"
                               style="border: 1px solid #e2e8f0; color: #475569;">&laquo;</a>
                        @endif
                        @foreach ($albums->getUrlRange(max(1, $albums->currentPage() - 2), min($albums->lastPage(), $albums->currentPage() + 2)) as $page => $url)
                            @if ($page == $albums->currentPage())
                                <span class="px-4 py-2 rounded-xl text-sm font-semibold text-white"
                                      style="background-color: #c80078;">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-4 py-2 rounded-xl text-sm font-medium transition-colors"
                                   style="border: 1px solid #e2e8f0; color: #475569;">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($albums->hasMorePages())
                            <a href="{{ $albums->nextPageUrl() }}"
                               class="px-4 py-2 rounded-xl text-sm font-medium transition-colors"
                               style="border: 1px solid #e2e8f0; color: #475569;">&raquo;</a>
                        @endif
                    </div>
                @endif

            @endif

        </div>
    </section>

@endsection
