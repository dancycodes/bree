@extends('layouts.public')

@section('title', __('news.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('news.meta_description'))

@push('head')
<style>
@keyframes gridFadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@section('content')

    {{-- ================================================================
         PAGE HERO
         Navy-tinted image with left magenta accent bar — same pattern
         as About and Programs pages.
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(300px, 38vw, 440px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('news.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">

        {{-- Solid dark overlay — NO gradient per BR-001 --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.78);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           x-navigate
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li style="color: #ffffff;" aria-current="page">{{ __('news.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('news.hero_label') }}
            </span>

            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ __('news.hero_heading') }}
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-relaxed"
               style="color: rgba(255,255,255,0.68);"
               data-animate="fade-up">
                {{ __('news.hero_tagline') }}
            </p>

            <div class="mt-6 h-0.5 w-16" style="background-color: #c8a03c;"></div>

        </div>

    </section>

    {{-- ================================================================
         ARTICLES GRID WITH CATEGORY FILTER
         ================================================================ --}}
    <section class="py-20" style="background-color: #f8f5f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data
             x-navigate.key.articles>

            @fragment('articles-grid')
            {{-- CSS-only fade-in on every fragment swap — avoids GSAP opacity:0 issues --}}
            <div id="articles-grid" style="animation: gridFadeIn 0.35s ease both;">

                {{-- ------------------------------------------------
                     Category filter pills
                     Scrolls horizontally on mobile — no multi-row wrap.
                     ------------------------------------------------ --}}
                <div class="relative mb-12">
                    {{-- Scrollable pill row — hidden scrollbar --}}
                    <div class="flex items-center gap-2 overflow-x-auto pb-1"
                         style="scrollbar-width: none; -ms-overflow-style: none;">

                        {{-- "All" pill --}}
                        <a href="{{ route('public.news') }}"
                           class="inline-flex items-center gap-1.5 shrink-0 px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 focus-visible:outline-none"
                           style="{{ $category === 'all'
                               ? 'background-color: #c80078; color: #ffffff; border: 1.5px solid #c80078;'
                               : 'background-color: #ffffff; color: #475569; border: 1.5px solid #e2e8f0;' }}"
                           @click.prevent="$navigate('{{ route('public.news') }}', { key: 'articles', replace: true })">
                            {{ __('news.filter_all') }}
                            @if ($category === 'all')
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-[10px] font-bold"
                                      style="background-color: rgba(255,255,255,0.25); color: #ffffff;">
                                    {{ $articles->total() }}
                                </span>
                            @endif
                        </a>

                        @foreach ($categories as $cat)
                            @php
                                $isActive = $category === $cat->slug;
                                $catColor = $cat->color ?: '#c80078';
                            @endphp
                            <a href="{{ route('public.news', ['category' => $cat->slug]) }}"
                               class="inline-flex items-center gap-1.5 shrink-0 px-5 py-2 rounded-full text-xs font-semibold transition-all duration-200 focus-visible:outline-none"
                               style="{{ $isActive
                                   ? 'background-color: #c80078; color: #ffffff; border: 1.5px solid #c80078;'
                                   : 'background-color: #ffffff; color: #475569; border: 1.5px solid #e2e8f0;' }}"
                               @click.prevent="$navigate('{{ route('public.news', ['category' => $cat->slug]) }}', { key: 'articles', replace: true })">
                                {{-- Colored dot for inactive pills to hint at category color --}}
                                @if (! $isActive)
                                    <span class="inline-block w-2 h-2 rounded-full shrink-0"
                                          style="background-color: {{ $catColor }};"></span>
                                @endif
                                {{ app()->getLocale() === 'fr' ? $cat->name_fr : $cat->name_en }}
                                @if ($isActive)
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-[10px] font-bold"
                                          style="background-color: rgba(255,255,255,0.25); color: #ffffff;">
                                        {{ $articles->total() }}
                                    </span>
                                @endif
                            </a>
                        @endforeach

                    </div>
                    {{-- Fade edge to hint at horizontal scrollability on mobile --}}
                    {{-- Subtle right-edge fade hint for mobile horizontal scroll --}}
                    <div class="absolute right-0 top-0 bottom-1 w-6 pointer-events-none sm:hidden"
                         style="background-color: rgba(248,245,240,0.85);"></div>
                </div>

                {{-- ------------------------------------------------
                     Empty state
                     ------------------------------------------------ --}}
                @if ($articles->isEmpty())
                    <div class="py-24 text-center">
                        <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center"
                             style="background-color: rgba(200,0,120,0.08);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="1.5" style="color: #c80078;" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                            </svg>
                        </div>
                        <p class="text-base font-semibold mb-2" style="color: #475569;">
                            {{ $category !== 'all' ? __('news.no_articles_category') : __('news.no_articles') }}
                        </p>
                        @if ($category === 'all')
                            <p class="text-sm" style="color: #94a3b8;">{{ __('news.no_articles_sub') }}</p>
                        @endif
                        @if ($category !== 'all')
                            <a href="{{ route('public.news') }}"
                               class="inline-flex items-center gap-2 mt-6 text-sm font-semibold transition-opacity hover:opacity-75"
                               style="color: #c80078;"
                               @click.prevent="$navigate('{{ route('public.news') }}', { key: 'articles', replace: true })">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                </svg>
                                {{ __('news.filter_all') }}
                            </a>
                        @endif
                    </div>

                @else

                    {{-- ------------------------------------------------
                         Article cards grid — 3 col desktop, 2 tablet, 1 mobile
                         Each card: 16:9 thumbnail, category badge, title, excerpt, date.
                         ------------------------------------------------ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($articles as $article)
                            @php
                                $catColor = $article->newsCategory?->color ?: '#c80078';
                                $hasThumbnail = ! empty($article->thumbnail_path);
                            @endphp

                            <article class="group card-lift bg-white rounded-2xl overflow-hidden flex flex-col"
                                     style="border: 1px solid rgba(0,0,0,0.05);
                                            box-shadow: 0 2px 12px rgba(0,0,0,0.06);"
                                     >

                                {{-- Thumbnail — 16:9 ratio --}}
                                <a href="{{ route('public.news.show', $article) }}"
                                   class="block relative overflow-hidden"
                                   style="aspect-ratio: 16/9;">

                                    @if ($hasThumbnail)
                                        <img src="{{ asset($article->thumbnail_path) }}"
                                             alt="{{ $article->title() }}"
                                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                             loading="lazy">
                                    @else
                                        {{-- Flat color placeholder when no thumbnail — BR-001 (no gradient) --}}
                                        <div class="absolute inset-0 flex items-center justify-center"
                                             style="background-color: {{ $catColor }}18;">
                                            <svg class="w-12 h-12 opacity-30" fill="none" stroke="{{ $catColor }}"
                                                 viewBox="0 0 24 24" stroke-width="1" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Category color bar at bottom of thumbnail --}}
                                    <div class="absolute bottom-0 left-0 right-0 h-0.5"
                                         style="background-color: {{ $catColor }};"></div>

                                </a>

                                {{-- Card body --}}
                                <div class="flex flex-col flex-1 p-6">

                                    {{-- Meta row: category badge + date --}}
                                    <div class="flex items-center justify-between gap-3 mb-4">
                                        @if ($article->categoryLabel())
                                            <span class="inline-block shrink-0 text-xs font-bold px-3 py-1 rounded-full tracking-wide"
                                                  style="background-color: {{ $catColor }}18; color: {{ $catColor }};">
                                                {{ $article->categoryLabel() }}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif
                                        <span class="text-xs shrink-0" style="color: #94a3b8;">
                                            {{ $article->published_at?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>

                                    {{-- Title --}}
                                    <h2 class="font-bold mb-3 leading-snug"
                                        style="font-family: 'Playfair Display', serif;
                                               font-size: 1.075rem;
                                               color: #002850;
                                               line-height: 1.35;">
                                        <a href="{{ route('public.news.show', $article) }}"
                                           class="transition-colors hover:opacity-80">
                                            {{ $article->title() }}
                                        </a>
                                    </h2>

                                    {{-- Excerpt (truncated at 2 lines) --}}
                                    @if ($article->excerpt())
                                        <p class="text-sm leading-relaxed mb-5 grow"
                                           style="color: #5a6a7a;
                                                  display: -webkit-box;
                                                  -webkit-line-clamp: 2;
                                                  -webkit-box-orient: vertical;
                                                  overflow: hidden;">
                                            {{ $article->excerpt() }}
                                        </p>
                                    @else
                                        <div class="grow"></div>
                                    @endif

                                    {{-- Read more link --}}
                                    <a href="{{ route('public.news.show', $article) }}"
                                       class="inline-flex items-center gap-1.5 text-xs font-bold self-start
                                              transition-all duration-200 hover:gap-2.5"
                                       style="color: #c80078;">
                                        {{ __('news.read_more') }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                        </svg>
                                    </a>

                                </div>

                            </article>
                        @endforeach
                    </div>

                    {{-- ------------------------------------------------
                         Pagination — current page highlighted magenta.
                         Hidden when only 1 page (< 9 articles).
                         ------------------------------------------------ --}}
                    @if ($articles->hasPages())
                        <nav class="mt-14 flex items-center justify-center gap-2"
                             aria-label="{{ __('news.page_title') }} pagination">

                            {{-- Previous --}}
                            @if ($articles->onFirstPage())
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm opacity-30 cursor-not-allowed"
                                      style="border: 1.5px solid #e2e8f0; color: #475569;"
                                      aria-disabled="true">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm transition-colors hover:bg-white"
                                   style="border: 1.5px solid #e2e8f0; color: #475569;"
                                   @click.prevent="$navigate('{{ $articles->previousPageUrl() }}', { key: 'articles', replace: true })"
                                   aria-label="{{ __('ui.previous') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @foreach ($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
                                @if ($page == $articles->currentPage())
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-bold text-white"
                                          style="background-color: #c80078; border: 1.5px solid #c80078;"
                                          aria-current="page">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm transition-colors hover:bg-white hover:border-slate-300"
                                       style="border: 1.5px solid #e2e8f0; color: #475569;"
                                       @click.prevent="$navigate('{{ $url }}', { key: 'articles', replace: true })">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm transition-colors hover:bg-white"
                                   style="border: 1.5px solid #e2e8f0; color: #475569;"
                                   @click.prevent="$navigate('{{ $articles->nextPageUrl() }}', { key: 'articles', replace: true })"
                                   aria-label="{{ __('ui.next') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </a>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm opacity-30 cursor-not-allowed"
                                      style="border: 1.5px solid #e2e8f0; color: #475569;"
                                      aria-disabled="true">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </span>
                            @endif

                        </nav>
                    @endif

                @endif

            </div>
            @endfragment

        </div>
    </section>

@endsection
