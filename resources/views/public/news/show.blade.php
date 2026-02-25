@extends('layouts.public')

@section('title', $article->title() . ' — ' . config('app.name'))
@section('meta_description', $article->excerpt() ?: Str::limit(strip_tags($article->content_fr ?? ''), 160))
@section('og_image', $article->thumbnail_path ? asset($article->thumbnail_path) : asset('images/logo.png'))

@section('content')

    {{-- ================================================================
         ARTICLE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(320px, 40vw, 500px);">

        <img src="{{ asset($article->thumbnail_path ?? 'images/sections/news-placeholder.jpg') }}"
             alt="{{ $article->title() }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.80);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">

            {{-- Breadcrumb --}}
            <nav class="mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.6);">
                    <li>
                        <a href="{{ route('public.home') }}" class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">{{ __('nav.home') }}</a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li>
                        <a href="{{ route('public.news') }}" class="hover:text-white transition-colors"
                           style="color: rgba(255,255,255,0.6);">{{ __('news.page_title') }}</a>
                    </li>
                    <li style="color: rgba(255,255,255,0.4);">/</li>
                    <li class="truncate max-w-xs" style="color: #ffffff;">{{ $article->title() }}</li>
                </ol>
            </nav>

            {{-- Category badge --}}
            @if ($article->category_fr)
                <span class="inline-block self-start text-xs font-bold px-3 py-1 rounded-full mb-4"
                      style="background-color: #c80078; color: #ffffff;"
                      data-animate="fade-up">
                    {{ $article->category() }}
                </span>
            @endif

            {{-- Title --}}
            <h1 class="font-heading font-bold max-w-3xl"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.5rem, 4vw, 2.75rem);
                       color: #ffffff;
                       line-height: 1.15;"
                data-animate="fade-up">
                {{ $article->title() }}
            </h1>

            {{-- Date + author --}}
            <div class="mt-5 flex items-center gap-4" data-animate="fade-up">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                     style="background-color: #c8a03c; color: #002850; font-size: 0.65rem; font-weight: 700;">
                    FB
                </div>
                <div>
                    <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.9);">
                        {{ __('news.foundation_author') }}
                    </p>
                    <p class="text-xs" style="color: rgba(255,255,255,0.55);">
                        {{ __('news.published_on') }} {{ $article->published_at?->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>

        </div>

    </section>

    {{-- ================================================================
         ARTICLE BODY + SIDEBAR
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:grid lg:grid-cols-3 lg:gap-16">

                {{-- Article body (2/3) --}}
                <div class="lg:col-span-2" data-animate="fade-up">

                    {{-- Excerpt lead --}}
                    @if ($article->excerpt())
                        <p class="text-lg font-medium leading-relaxed mb-8"
                           style="color: #143c64; border-left: 3px solid #c80078; padding-left: 1.25rem;">
                            {{ $article->excerpt() }}
                        </p>
                    @endif

                    {{-- Body content --}}
                    @php
                        $content = app()->getLocale() === 'fr' ? $article->content_fr : $article->content_en;
                        $content = $content ?: ($article->content_fr ?? '');
                    @endphp

                    @if ($content)
                        <div class="prose-article space-y-5">
                            @foreach (explode("\n\n", $content) as $paragraph)
                                @if (trim($paragraph))
                                    <p class="text-base leading-relaxed" style="color: #374151;">
                                        {!! nl2br(e(trim($paragraph))) !!}
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-base leading-relaxed" style="color: #374151;">
                            {{ $article->excerpt() }}
                        </p>
                    @endif

                    {{-- Back link --}}
                    <div class="mt-12 pt-8" style="border-top: 1px solid #e2e8f0;">
                        <a href="{{ route('public.news') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold transition-opacity hover:opacity-75"
                           style="color: #002850;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            {{ __('news.back_to_news') }}
                        </a>
                    </div>

                </div>

                {{-- Sidebar (1/3) --}}
                <aside class="mt-12 lg:mt-0">

                    {{-- Social share --}}
                    <div class="bg-white rounded-2xl p-6 mb-6 sticky top-24"
                         style="border: 1px solid #e2e8f0;">

                        <h3 class="text-xs font-bold tracking-widest uppercase mb-5"
                            style="color: #94a3b8;">
                            {{ __('news.share') }}
                        </h3>

                        <div class="flex flex-col gap-3">
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors"
                               style="background-color: #f0f4ff; color: #1877f2;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>

                            {{-- Twitter/X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors"
                               style="background-color: #f5f5f5; color: #000000;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                X (Twitter)
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors"
                               style="background-color: #f0f7ff; color: #0a66c2;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                        </div>

                        {{-- Category info --}}
                        @if ($article->category_fr)
                            <div class="mt-6 pt-5" style="border-top: 1px solid #f1f5f9;">
                                <p class="text-xs font-medium mb-2" style="color: #94a3b8;">Catégorie</p>
                                <a href="{{ route('public.news', ['category' => $article->category_slug]) }}"
                                   class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full transition-opacity hover:opacity-75"
                                   style="background-color: #c8007812; color: #c80078;">
                                    {{ $article->category() }}
                                </a>
                            </div>
                        @endif

                    </div>

                </aside>

            </div>

        </div>
    </section>

    {{-- ================================================================
         RELATED ARTICLES
         ================================================================ --}}
    @if ($related->isNotEmpty())
        <section class="py-16" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <h2 class="font-heading font-bold mb-10"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(1.4rem, 3vw, 2rem);
                           color: #002850;"
                    data-animate="fade-up">
                    {{ __('news.related_articles') }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger="0.06">
                    @foreach ($related as $rel)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-sm transition-all hover:-translate-y-1 hover:shadow-md"
                                 style="border: 1px solid rgba(0,0,0,0.04);"
                                 data-animate="fade-up">
                            <a href="{{ route('public.news.show', $rel) }}"
                               class="block overflow-hidden" style="height: 160px;">
                                <img src="{{ asset($rel->thumbnail_path ?? 'images/sections/news-placeholder.jpg') }}"
                                     alt="{{ $rel->title() }}"
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            </a>
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    @if ($rel->category_fr)
                                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                                              style="background-color: #c8007812; color: #c80078;">
                                            {{ $rel->category() }}
                                        </span>
                                    @endif
                                    <span class="text-xs" style="color: #94a3b8;">
                                        {{ $rel->published_at?->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="font-heading font-semibold mb-2 leading-snug"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 0.95rem;
                                           color: #002850;">
                                    <a href="{{ route('public.news.show', $rel) }}"
                                       class="hover:opacity-75 transition-opacity">{{ $rel->title() }}</a>
                                </h3>
                                <a href="{{ route('public.news.show', $rel) }}"
                                   class="inline-flex items-center gap-1 text-xs font-semibold"
                                   style="color: #c80078;">
                                    {{ __('news.read_more') }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

@endsection
