@extends('layouts.public')

@section('title', __('news.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('news.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(280px, 35vw, 420px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('news.page_title') }}"
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
                    <li style="color: #ffffff;">{{ __('news.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('news.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 4vw, 3rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('news.hero_heading') }}
            </h1>

            <div class="mt-5 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>

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
            <div id="articles-grid">

                {{-- Category filter pills --}}
                <div class="flex flex-wrap gap-2 mb-12" data-animate="fade-up">
                    <a href="{{ route('public.news') }}"
                       class="px-5 py-2 rounded-full text-xs font-semibold transition-all"
                       style="{{ $category === 'all'
                           ? 'background-color: #c80078; color: #ffffff;'
                           : 'background-color: #ffffff; color: #475569; border: 1px solid #e2e8f0;' }}"
                       @click.prevent="$navigate('{{ route('public.news') }}', { key: 'articles', replace: true })">
                        {{ __('news.filter_all') }}
                        @if ($category === 'all')
                            <span class="ml-1 opacity-60">({{ $articles->total() }})</span>
                        @endif
                    </a>

                    @foreach ($categories as $cat)
                        <a href="{{ route('public.news', ['category' => $cat->slug]) }}"
                           class="px-5 py-2 rounded-full text-xs font-semibold transition-all"
                           style="{{ $category === $cat->slug
                               ? 'background-color: #c80078; color: #ffffff;'
                               : 'background-color: #ffffff; color: #475569; border: 1px solid #e2e8f0;' }}"
                           @click.prevent="$navigate('{{ route('public.news', ['category' => $cat->slug]) }}', { key: 'articles', replace: true })">
                            {{ $cat->name() }}
                            @if ($category === $cat->slug)
                                <span class="ml-1 opacity-60">({{ $articles->total() }})</span>
                            @endif
                        </a>
                    @endforeach
                </div>

                @if ($articles->isEmpty())
                    <div class="py-20 text-center" data-animate="fade-up">
                        <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center"
                             style="background-color: rgba(200,0,120,0.08);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color: #c80078;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                            </svg>
                        </div>
                        <p class="text-base font-medium" style="color: #475569;">
                            {{ $category !== 'all' ? __('news.no_articles_category') : __('news.no_articles') }}
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-stagger="0.06">
                        @foreach ($articles as $article)
                            <article class="bg-white rounded-2xl overflow-hidden shadow-sm transition-all hover:-translate-y-1 hover:shadow-md"
                                     style="border: 1px solid rgba(0,0,0,0.04);"
                                     data-animate="fade-up">

                                {{-- Thumbnail --}}
                                <a href="{{ route('public.news.show', $article) }}"
                                   class="block overflow-hidden" style="height: 200px;">
                                    <img src="{{ asset($article->thumbnail_path ?? 'images/sections/news-placeholder.jpg') }}"
                                         alt="{{ $article->title() }}"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                </a>

                                {{-- Content --}}
                                <div class="p-6">
                                    {{-- Category + date --}}
                                    <div class="flex items-center gap-3 mb-3">
                                        @if ($article->newsCategory || $article->category_fr)
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full"
                                                  style="background-color: #c8007812; color: #c80078;">
                                                {{ $article->categoryLabel() }}
                                            </span>
                                        @endif
                                        <span class="text-xs" style="color: #94a3b8;">
                                            {{ $article->published_at?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>

                                    {{-- Title --}}
                                    <h2 class="font-heading font-bold mb-3 leading-snug"
                                        style="font-family: 'Playfair Display', serif;
                                               font-size: 1.1rem;
                                               color: #002850;">
                                        <a href="{{ route('public.news.show', $article) }}"
                                           class="hover:opacity-75 transition-opacity">{{ $article->title() }}</a>
                                    </h2>

                                    {{-- Excerpt --}}
                                    @if ($article->excerpt())
                                        <p class="text-sm leading-relaxed mb-4 line-clamp-3" style="color: #5a6a7a;">
                                            {{ $article->excerpt() }}
                                        </p>
                                    @endif

                                    {{-- Read more --}}
                                    <a href="{{ route('public.news.show', $article) }}"
                                       class="inline-flex items-center gap-1 text-xs font-semibold transition-opacity hover:opacity-75"
                                       style="color: #c80078;">
                                        {{ __('news.read_more') }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                        </svg>
                                    </a>
                                </div>

                            </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($articles->hasPages())
                        <div class="mt-12 flex items-center justify-center gap-2">
                            {{-- Previous --}}
                            @if ($articles->onFirstPage())
                                <span class="px-4 py-2 rounded-xl text-sm opacity-40 cursor-not-allowed"
                                      style="border: 1px solid #e2e8f0; color: #475569;">
                                    &laquo;
                                </span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}"
                                   class="px-4 py-2 rounded-xl text-sm transition-colors"
                                   style="border: 1px solid #e2e8f0; color: #475569;"
                                   @click.prevent="$navigate('{{ $articles->previousPageUrl() }}', { key: 'articles', replace: true })">
                                    &laquo;
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @foreach ($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
                                @if ($page == $articles->currentPage())
                                    <span class="px-4 py-2 rounded-xl text-sm font-semibold text-white"
                                          style="background-color: #c80078;">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-4 py-2 rounded-xl text-sm transition-colors"
                                       style="border: 1px solid #e2e8f0; color: #475569;"
                                       @click.prevent="$navigate('{{ $url }}', { key: 'articles', replace: true })">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}"
                                   class="px-4 py-2 rounded-xl text-sm transition-colors"
                                   style="border: 1px solid #e2e8f0; color: #475569;"
                                   @click.prevent="$navigate('{{ $articles->nextPageUrl() }}', { key: 'articles', replace: true })">
                                    &raquo;
                                </a>
                            @else
                                <span class="px-4 py-2 rounded-xl text-sm opacity-40 cursor-not-allowed"
                                      style="border: 1px solid #e2e8f0; color: #475569;">
                                    &raquo;
                                </span>
                            @endif
                        </div>
                    @endif
                @endif

            </div>
            @endfragment

        </div>
    </section>

@endsection
