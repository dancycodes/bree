@extends('layouts.public')

@section('title', $album->title() . ' — ' . __('gallery.page_title') . ' — ' . config('app.name'))
@section('meta_description', $album->description_fr ?? __('gallery.meta_description'))

@section('content')

    @php
        $photosData = $photos->map(fn ($p) => [
            'url' => asset($p->path),
            'caption' => app()->getLocale() === 'fr' ? ($p->caption_fr ?? '') : ($p->caption_en ?? ''),
        ])->values()->toArray();
    @endphp

    <div
        x-data="{
            photos: {{ Js::from($photosData) }},
            activeIndex: null,
            open: false,
            openAt(i) { this.activeIndex = i; this.open = true; document.body.style.overflow = 'hidden'; },
            close() { this.open = false; this.activeIndex = null; document.body.style.overflow = ''; },
            prev() { if (this.activeIndex > 0) this.activeIndex--; },
            next() { if (this.activeIndex < this.photos.length - 1) this.activeIndex++; }
        }"
        @keydown.escape.window="close()"
        @keydown.arrow-left.window="if (open) prev()"
        @keydown.arrow-right.window="if (open) next()">

        {{-- ================================================================
             PAGE HEADER
             ================================================================ --}}
        <section class="pt-28 pb-12" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <nav class="mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-xs font-medium" style="color: rgba(255,255,255,0.5);">
                        <li>
                            <a href="{{ route('public.home') }}"
                               class="hover:text-white transition-colors"
                               style="color: rgba(255,255,255,0.5);">
                                {{ __('nav.home') }}
                            </a>
                        </li>
                        <li style="color: rgba(255,255,255,0.3);">/</li>
                        <li>
                            <a href="{{ route('public.gallery') }}"
                               class="hover:text-white transition-colors"
                               style="color: rgba(255,255,255,0.5);">
                                {{ __('gallery.page_title') }}
                            </a>
                        </li>
                        <li style="color: rgba(255,255,255,0.3);">/</li>
                        <li class="truncate max-w-xs" style="color: #ffffff;">{{ $album->title() }}</li>
                    </ol>
                </nav>

                <h1 class="font-heading font-bold mb-3"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(1.75rem, 4vw, 2.75rem);
                           color: #ffffff;
                           line-height: 1.15;"
                    data-animate="fade-up">
                    {{ $album->title() }}
                </h1>

                <div class="flex items-center gap-4">
                    @if ($photos->isNotEmpty())
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-full"
                              style="background-color: rgba(200,160,60,0.2); color: #c8a03c;">
                            {{ trans_choice('gallery.photos_count', $photos->count()) }}
                        </span>
                    @endif
                    @if ($album->description_fr || $album->description_en)
                        <p class="text-sm" style="color: rgba(255,255,255,0.65);">
                            {{ app()->getLocale() === 'fr' ? $album->description_fr : $album->description_en }}
                        </p>
                    @endif
                </div>

            </div>
        </section>

        {{-- ================================================================
             PHOTO GRID
             ================================================================ --}}
        <section class="py-16" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                @if ($photos->isEmpty())
                    <div class="text-center py-20">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             stroke-width="1" style="color: #cbd5e1;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                        </svg>
                        <p class="text-sm font-medium" style="color: #64748b;">Aucune photo dans cet album.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach ($photos as $i => $photo)
                            <button
                                @click="openAt({{ $i }})"
                                class="group relative overflow-hidden rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2"
                                style="aspect-ratio: 1/1; focus-ring-color: #c80078;">
                                <img src="{{ asset($photo->path) }}"
                                     alt="{{ app()->getLocale() === 'fr' ? ($photo->caption_fr ?? '') : ($photo->caption_en ?? '') }}"
                                     class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-110">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                     style="background-color: rgba(0,20,60,0.45);">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803zM10.5 7.5v6m3-3h-6"/>
                                    </svg>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Back link --}}
                <div class="mt-10">
                    <a href="{{ route('public.gallery') }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold transition-opacity hover:opacity-70"
                       style="color: #c80078;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        {{ __('gallery.back_to_gallery') }}
                    </a>
                </div>

            </div>
        </section>

        {{-- ================================================================
             LIGHTBOX OVERLAY
             ================================================================ --}}
        <div
            :style="`display:${open ? 'flex' : 'none'}`"
            class="fixed inset-0 z-50 items-center justify-center"
            style="background-color: rgba(0,0,0,0.92); display: none;"
            @click.self="close()">

            {{-- Close button --}}
            <button
                @click="close()"
                class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-full transition-colors hover:bg-white/10 z-10"
                style="color: #ffffff;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Counter --}}
            <div class="absolute top-5 left-1/2 -translate-x-1/2 z-10">
                <span class="text-sm font-semibold px-3 py-1.5 rounded-full"
                      style="background-color: rgba(255,255,255,0.12); color: #ffffff;"
                      x-text="activeIndex !== null ? (activeIndex + 1) + ' / ' + photos.length : ''"></span>
            </div>

            {{-- Prev arrow --}}
            <button
                @click="prev()"
                x-show="photos.length > 1 && activeIndex > 0"
                class="absolute left-4 sm:left-8 w-12 h-12 flex items-center justify-center rounded-full transition-colors hover:bg-white/10 z-10"
                style="color: #ffffff;">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>

            {{-- Next arrow --}}
            <button
                @click="next()"
                x-show="photos.length > 1 && activeIndex < photos.length - 1"
                class="absolute right-4 sm:right-8 w-12 h-12 flex items-center justify-center rounded-full transition-colors hover:bg-white/10 z-10"
                style="color: #ffffff;">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </button>

            {{-- Photo + caption --}}
            <div class="relative flex flex-col items-center justify-center px-16 sm:px-24 max-h-screen w-full">
                <template x-if="activeIndex !== null">
                    <div class="flex flex-col items-center gap-4 max-w-5xl w-full">
                        <img :src="photos[activeIndex].url"
                             :alt="photos[activeIndex].caption"
                             class="max-h-[75vh] max-w-full object-contain rounded-lg shadow-2xl">
                        <p x-text="photos[activeIndex].caption"
                           x-show="photos[activeIndex].caption"
                           class="text-sm text-center px-4"
                           style="color: rgba(255,255,255,0.75); max-width: 600px;"></p>
                    </div>
                </template>
            </div>

        </div>

    </div>

@endsection
