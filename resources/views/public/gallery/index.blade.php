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

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('gallery.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('gallery.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
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
                    <h2 class="bree-subsection-h3 mb-3"
                        style="color: #1e293b;">
                        {{ __('gallery.empty_heading') }}
                    </h2>
                    <p class="text-sm" style="color: #64748b;">{{ __('gallery.empty_sub') }}</p>
                </div>

            @else

                <div class="mb-12">
                    <h2 class="bree-section-h2"
                        data-animate="fade-up">
                        {{ __('gallery.albums_title') }}
                    </h2>
                    <div class="mt-3 h-1 w-12 rounded-full" style="background-color: #c8a03c;"></div>
                </div>

                {{-- Albums grid: 1-col mobile, 2-col tablet, 3-col desktop --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" x-data>

                    @foreach ($albums as $album)
                        <article class="gallery-album-card group relative overflow-hidden rounded-2xl shadow-sm"
                                 data-animate="fade-up">

                            {{-- Album image link — Gale navigate --}}
                            <a href="{{ route('public.gallery.show', $album) }}"
                               class="block relative overflow-hidden focus-visible:ring-2 focus-visible:ring-offset-2"
                               style="aspect-ratio: 16/9; display: block;"
                               aria-label="{{ $album->title() }}">

                                {{-- Cover photo or navy placeholder --}}
                                @if ($album->coverUrl())
                                    <img src="{{ $album->coverUrl() }}"
                                         alt="{{ $album->title() }}"
                                         class="w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-[1.03]"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full items-center justify-center"
                                         style="display:none; background-color: #002850; position:absolute; inset:0;">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1" style="color: rgba(255,255,255,0.2);">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                                        </svg>
                                    </div>
                                @else
                                    {{-- Navy placeholder when no cover photo --}}
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background-color: #002850; position:absolute; inset:0;">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1" style="color: rgba(255,255,255,0.2);">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Photo count badge — top right --}}
                                @if ($album->photos_count > 0)
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-white"
                                              style="background-color: rgba(0,0,0,0.55);">
                                            {{ trans_choice('gallery.photos_count', $album->photos_count) }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Title overlay bar — flat dark, no gradient (BR-001) --}}
                                <div class="absolute bottom-0 left-0 right-0 z-10 px-4 py-3"
                                     style="background-color: rgba(0,0,0,0.55);">
                                    <h3 class="font-medium text-sm leading-snug text-white truncate"
                                        style="font-family: 'Inter', sans-serif;">
                                        {{ $album->title() }}
                                    </h3>
                                    <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">
                                        {{ $album->created_at->translatedFormat('F Y') }}
                                    </p>
                                </div>

                                {{-- Hover "view" indicator overlay — flat color (BR-001) --}}
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"
                                     style="background-color: rgba(200,0,120,0.18);">
                                    <span class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-white px-4 py-2 rounded-full"
                                          style="background-color: rgba(0,0,0,0.5);">
                                        {{ __('gallery.view_album') }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </span>
                                </div>

                            </a>

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

@push('head')
<style>
    .gallery-album-card {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .gallery-album-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
    }
</style>
@endpush

@endsection
