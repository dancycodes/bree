@extends('layouts.public')

@section('title', $article->title() . ' — ' . config('app.name'))
@section('meta_description', $article->excerpt() ?: Str::limit(strip_tags($article->content_fr ?? ''), 160))
@section('og_image', $article->thumbnail_path ? asset($article->thumbnail_path) : asset('images/logo.png'))

@section('content')

    {{-- ================================================================
         ARTICLE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(340px, 44vw, 540px);">

        @if ($article->thumbnail_path)
            <img src="{{ asset($article->thumbnail_path) }}"
                 alt="{{ $article->title() }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="eager">
        @else
            @php $catColor = $article->newsCategory?->color ?: '#c80078'; @endphp
            <div class="absolute inset-0" style="background-color: {{ $catColor }};"></div>
        @endif

        {{-- Solid dark overlay — NO gradient per BR-001 --}}
        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.82);"></div>

        {{-- Left magenta accent bar --}}
        <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: #c80078;"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

            {{-- Breadcrumb --}}
            <nav class="mb-5" aria-label="{{ __('ui.breadcrumb') }}">
                <ol class="flex items-center gap-2 text-xs font-medium flex-wrap"
                    style="color: rgba(255,255,255,0.55);">
                    <li>
                        <a href="{{ route('public.home') }}"
                           x-navigate
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li>
                        <a href="{{ route('public.news') }}"
                           x-navigate
                           class="hover:text-white transition-colors focus-visible:outline-white">
                            {{ __('news.page_title') }}
                        </a>
                    </li>
                    <li aria-hidden="true" style="color: rgba(255,255,255,0.3);">/</li>
                    <li class="truncate" style="max-width: 20rem; color: #ffffff;" aria-current="page">
                        {{ $article->title() }}
                    </li>
                </ol>
            </nav>

            {{-- Category badge --}}
            @if ($article->categoryLabel())
                <span class="inline-block self-start text-xs font-bold px-3 py-1 rounded-full mb-4 tracking-wide"
                      style="background-color: #c80078; color: #ffffff;"
                      data-animate="fade-up">
                    {{ $article->categoryLabel() }}
                </span>
            @endif

            {{-- Title --}}
            <h1 class="bree-hero-h1 max-w-3xl"
                style="color: #ffffff;"
                data-animate="fade-up">
                {{ $article->title() }}
            </h1>

            {{-- Meta row: author + date --}}
            <div class="mt-6 flex items-center gap-4" data-animate="fade-up">
                {{-- Author avatar --}}
                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 text-[11px] font-bold"
                     style="background-color: #c8a03c; color: #002850;">
                    FB
                </div>
                <div>
                    <p class="text-sm font-semibold leading-tight" style="color: rgba(255,255,255,0.92);">
                        {{ __('news.foundation_author') }}
                    </p>
                    <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.55);">
                        {{ __('news.published_on') }} {{ $article->published_at?->translatedFormat('d F Y') }}
                    </p>
                </div>
                {{-- Gold separator rule --}}
                <div class="hidden sm:block h-8 w-px ml-2" style="background-color: rgba(200,160,60,0.4);"></div>
                {{-- Reading time estimate --}}
                @php
                    $bodyText = strip_tags($article->content_fr ?? '');
                    $wordCount = str_word_count($bodyText);
                    $readingMins = max(1, (int) ceil($wordCount / 200));
                @endphp
                <div class="hidden sm:flex items-center gap-1.5 text-xs" style="color: rgba(255,255,255,0.55);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $readingMins }} min
                </div>
            </div>

        </div>

    </section>

    {{-- ================================================================
         ARTICLE BODY + SIDEBAR
         ================================================================ --}}
    <section class="py-16 lg:py-24" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:grid lg:grid-cols-3 lg:gap-16 xl:gap-20">

                {{-- ------------------------------------------------
                     Article body (2/3)
                     Typography: 18px Inter, 1.75 line-height, Playfair headings
                     ------------------------------------------------ --}}
                <div class="lg:col-span-2">

                    {{-- Excerpt lead — blockquote style --}}
                    @if ($article->excerpt())
                        <p class="text-lg font-medium leading-relaxed mb-10"
                           style="color: #143c64;
                                  border-left: 3px solid #c80078;
                                  padding-left: 1.25rem;
                                  font-family: 'Playfair Display', serif;
                                  font-style: italic;">
                            {{ $article->excerpt() }}
                        </p>
                    @endif

                    {{-- Body content
                         BR-005: 18px Inter, 1.75 line-height.
                         Headings inside body use Playfair Display.
                         Tables are wrapped for horizontal scroll on mobile.
                         Inline images are responsive. --}}
                    @php
                        $content = app()->getLocale() === 'fr' ? $article->content_fr : $article->content_en;
                        $content = $content ?: ($article->content_fr ?? '');
                    @endphp

                    @if ($content)
                        <div class="article-body">
                            @php
                                // Detect HTML content vs plain text
                                $isHtml = str_contains($content, '<') && str_contains($content, '>');
                            @endphp

                            @if ($isHtml)
                                {{-- Rich HTML content — render directly, wrap tables for mobile --}}
                                @php
                                    // Wrap bare <table> tags in a scrollable container
                                    $safeContent = preg_replace(
                                        '/<table([^>]*)>/i',
                                        '<div class="table-scroll-wrapper"><table$1>',
                                        $content
                                    );
                                    $safeContent = preg_replace('/<\/table>/i', '</table></div>', $safeContent ?? $content);
                                @endphp
                                {!! $safeContent !!}
                            @else
                                {{-- Plain text content — split on double newlines --}}
                                @foreach (explode("\n\n", $content) as $paragraph)
                                    @if (trim($paragraph))
                                        <p>
                                            {!! nl2br(e(trim($paragraph))) !!}
                                        </p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @else
                        @if ($article->excerpt())
                            <div class="article-body">
                                <p>{{ $article->excerpt() }}</p>
                            </div>
                        @endif
                    @endif

                    {{-- Back link --}}
                    <div class="mt-14 pt-8" style="border-top: 1.5px solid #e2e8f0;">
                        <a href="{{ route('public.news') }}"
                           x-navigate
                           class="inline-flex items-center gap-2 text-sm font-semibold transition-all duration-200 hover:gap-3"
                           style="color: #002850;">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            {{ __('news.back_to_news') }}
                        </a>
                    </div>

                </div>

                {{-- ------------------------------------------------
                     Sidebar (1/3)
                     Share + category info — sticky on desktop.
                     ------------------------------------------------ --}}
                <aside class="mt-12 lg:mt-0">

                    <div class="rounded-2xl overflow-hidden sticky top-24"
                         style="border: 1px solid #e2e8f0;">

                        {{-- Sidebar header --}}
                        <div class="px-6 pt-6 pb-4" style="border-bottom: 1px solid #f1f5f9;">
                            <h3 class="text-xs font-bold tracking-widest uppercase"
                                style="color: #94a3b8; letter-spacing: 0.1em;">
                                {{ __('news.share') }}
                            </h3>
                        </div>

                        <div class="p-6 space-y-3">
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all hover:translate-x-1"
                               style="background-color: #f0f4ff; color: #1877f2;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>

                            {{-- X (Twitter) --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all hover:translate-x-1"
                               style="background-color: #f5f5f5; color: #000000;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                X (Twitter)
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all hover:translate-x-1"
                               style="background-color: #f0f7ff; color: #0a66c2;">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                        </div>

                        {{-- Category info --}}
                        @if ($article->categoryLabel())
                            <div class="px-6 pb-6 pt-1" style="border-top: 1px solid #f1f5f9;">
                                <p class="text-xs font-bold tracking-widest uppercase mb-3"
                                   style="color: #94a3b8; letter-spacing: 0.1em;">
                                    {{ __('news.category_label') }}
                                </p>
                                <a href="{{ route('public.news', ['category' => $article->newsCategory?->slug ?? $article->category_slug]) }}"
                                   x-navigate
                                   class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2 rounded-full transition-opacity hover:opacity-80"
                                   style="background-color: {{ $article->newsCategory?->color ? $article->newsCategory->color . '18' : '#c8007812' }};
                                          color: {{ $article->newsCategory?->color ?: '#c80078' }};">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0"
                                          style="background-color: {{ $article->newsCategory?->color ?: '#c80078' }};"></span>
                                    {{ $article->categoryLabel() }}
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
         Visually separated with gold rule + section heading.
         3-column grid on desktop, 1-column on mobile (BR-007).
         ================================================================ --}}
    @if ($related->isNotEmpty())
        <section class="py-16 lg:py-20" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Section heading with gold accent --}}
                <div class="flex items-center gap-6 mb-12">
                    <div>
                        <span class="block text-xs font-bold tracking-widest uppercase mb-2"
                              style="color: #c8a03c;">
                            {{ __('news.page_title') }}
                        </span>
                        <h2 class="font-bold"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.35rem, 2.5vw, 1.9rem);
                                   color: #002850;">
                            {{ __('news.related_articles') }}
                        </h2>
                    </div>
                    {{-- Gold decorative rule --}}
                    <div class="hidden sm:block flex-1 h-px" style="background-color: #c8a03c; opacity: 0.3;"></div>
                </div>

                {{-- 3-col desktop grid (BR-007) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach ($related as $rel)
                        @php
                            $relCatColor = $rel->newsCategory?->color ?: '#c80078';
                        @endphp

                        <article class="group bg-white rounded-2xl overflow-hidden flex flex-col"
                                 style="border: 1px solid rgba(0,0,0,0.05);
                                        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
                                        transition: transform 0.25s ease, box-shadow 0.25s ease;"
                                 onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.12)';"
                                 onmouseleave="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';"
                                 >

                            {{-- Thumbnail — 16:9 --}}
                            <a href="{{ route('public.news.show', $rel) }}"
                               class="block relative overflow-hidden"
                               style="aspect-ratio: 16/9;">
                                @if ($rel->thumbnail_path)
                                    <img src="{{ asset($rel->thumbnail_path) }}"
                                         alt="{{ $rel->title() }}"
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-300"
                                         style="transform: scale(1);"
                                         onmouseenter="this.style.transform='scale(1.03)';"
                                         onmouseleave="this.style.transform='scale(1)';"
                                         loading="lazy">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center"
                                         style="background-color: {{ $relCatColor }}18;">
                                        <svg class="w-10 h-10 opacity-30" fill="none" stroke="{{ $relCatColor }}"
                                             viewBox="0 0 24 24" stroke-width="1" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                {{-- Category color bar --}}
                                <div class="absolute bottom-0 left-0 right-0 h-0.5"
                                     style="background-color: {{ $relCatColor }};"></div>
                            </a>

                            {{-- Card body --}}
                            <div class="flex flex-col flex-1 p-5">
                                {{-- Meta: badge + date --}}
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    @if ($rel->categoryLabel())
                                        <span class="shrink-0 text-xs font-bold px-2.5 py-0.5 rounded-full"
                                              style="background-color: {{ $relCatColor }}18; color: {{ $relCatColor }};">
                                            {{ $rel->categoryLabel() }}
                                        </span>
                                    @else
                                        <span></span>
                                    @endif
                                    <span class="text-xs shrink-0" style="color: #94a3b8;">
                                        {{ $rel->published_at?->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 class="font-bold mb-4 leading-snug grow"
                                    style="font-family: 'Playfair Display', serif;
                                           font-size: 0.95rem;
                                           color: #002850;
                                           line-height: 1.35;">
                                    <a href="{{ route('public.news.show', $rel) }}"
                                       class="transition-opacity hover:opacity-75">
                                        {{ $rel->title() }}
                                    </a>
                                </h3>

                                {{-- Read more --}}
                                <a href="{{ route('public.news.show', $rel) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold self-start
                                          transition-all duration-200 hover:gap-2.5"
                                   style="color: #c80078;">
                                    {{ __('news.read_more') }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
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

{{-- ================================================================
     ARTICLE BODY STYLES
     These scoped styles apply only to the article body section.
     BR-005: 18px Inter, 1.75 line-height; Playfair headings inside body.
     BR-003: inline images responsive (max-width: 100%).
     Tables scrollable on mobile.
     ================================================================ --}}
@push('head')
<style>
/* Article body typography */
.article-body {
    color: #374151;
    font-family: 'Inter', system-ui, sans-serif;
    font-size: 1.125rem; /* 18px */
    line-height: 1.75;
}

.article-body p {
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
    line-height: 1.75;
    color: #374151;
}

.article-body h1,
.article-body h2,
.article-body h3,
.article-body h4,
.article-body h5,
.article-body h6 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: #002850;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    line-height: 1.25;
}

.article-body h1 { font-size: 2rem; }
.article-body h2 { font-size: 1.6rem; }
.article-body h3 { font-size: 1.3rem; }
.article-body h4 { font-size: 1.1rem; }

.article-body a {
    color: #c80078;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: opacity 0.15s;
}

.article-body a:hover {
    opacity: 0.75;
}

.article-body strong,
.article-body b {
    font-weight: 700;
    color: #002850;
}

.article-body em,
.article-body i {
    font-style: italic;
}

.article-body ul,
.article-body ol {
    margin-bottom: 1.5rem;
    padding-left: 1.75rem;
}

.article-body ul {
    list-style-type: disc;
}

.article-body ol {
    list-style-type: decimal;
}

.article-body li {
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
    line-height: 1.75;
}

.article-body blockquote {
    border-left: 3px solid #c80078;
    padding-left: 1.25rem;
    margin: 2rem 0;
    font-family: 'Playfair Display', serif;
    font-style: italic;
    color: #143c64;
    font-size: 1.15rem;
}

/* Inline images — responsive (BR-003) */
.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
}

/* Tables — horizontally scrollable on mobile (edge case) */
.table-scroll-wrapper,
.article-body > table {
    overflow-x: auto;
    display: block;
    max-width: 100%;
    margin-bottom: 1.5rem;
    -webkit-overflow-scrolling: touch;
}

.article-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    min-width: 480px;
}

.article-body th {
    background-color: #f8f5f0;
    font-weight: 700;
    color: #002850;
    padding: 0.75rem 1rem;
    border-bottom: 2px solid #e2e8f0;
    text-align: left;
    font-family: 'Inter', sans-serif;
}

.article-body td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: top;
}

.article-body tr:last-child td {
    border-bottom: none;
}

/* Horizontal rule */
.article-body hr {
    border: none;
    border-top: 1.5px solid #e2e8f0;
    margin: 2.5rem 0;
}
</style>
@endpush
