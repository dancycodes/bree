@extends('layouts.public')

@section('title', $album->title() . ' — ' . __('gallery.page_title') . ' — ' . config('app.name'))
@section('meta_description', $album->description_fr ?? __('gallery.meta_description'))

@push('head')
<style>
    @keyframes galleryFadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .photo-grid {
        animation: galleryFadeIn 0.35s ease both;
    }

    .gallery-photo-thumb {
        transition: transform 0.3s ease;
    }

    .gallery-photo-thumb:hover {
        transform: scale(1.03);
    }

    /* Lightbox image transition */
    .lightbox-img-wrap {
        transition: opacity 0.18s ease;
    }

    .lightbox-img-wrap.fading {
        opacity: 0;
    }
</style>
@endpush

@section('content')

    @php
        $photosData = $photos->map(fn ($p) => [
            'url'     => asset($p->path),
            'caption' => app()->getLocale() === 'fr' ? ($p->caption_fr ?? '') : ($p->caption_en ?? ''),
        ])->values()->toArray();
    @endphp

    <div
        x-data="{
            photos: {{ Js::from($photosData) }},
            activeIndex: null,
            open: false,
            imgFading: false,
            imgLoading: false,

            openAt(i) {
                this.activeIndex = i;
                this.imgLoading = true;
                this.open = true;
                document.body.style.overflow = 'hidden';
                this.$nextTick(() => this._gsapLightboxIn());
            },

            close() {
                this._gsapLightboxOut(() => {
                    this.open = false;
                    this.activeIndex = null;
                    document.body.style.overflow = '';
                });
            },

            prev() {
                if (this.activeIndex > 0) {
                    this._changePhoto(this.activeIndex - 1);
                }
            },

            next() {
                if (this.activeIndex < this.photos.length - 1) {
                    this._changePhoto(this.activeIndex + 1);
                }
            },

            _changePhoto(newIndex) {
                this.imgFading = true;
                this.imgLoading = true;
                setTimeout(() => {
                    this.activeIndex = newIndex;
                    this.imgFading = false;
                }, 180);
            },

            _gsapLightboxIn() {
                if (typeof gsap === 'undefined') return;
                const overlay = this.$el.querySelector('#gallery-lightbox');
                if (!overlay) return;
                gsap.fromTo(overlay,
                    { opacity: 0 },
                    { opacity: 1, duration: 0.25, ease: 'power2.out' }
                );
                const inner = overlay.querySelector('#lightbox-inner');
                if (inner) {
                    gsap.fromTo(inner,
                        { scale: 0.93, opacity: 0 },
                        { scale: 1, opacity: 1, duration: 0.3, ease: 'power3.out', delay: 0.05 }
                    );
                }
            },

            _gsapLightboxOut(callback) {
                if (typeof gsap === 'undefined') {
                    callback();
                    return;
                }
                const overlay = this.$el.querySelector('#gallery-lightbox');
                if (!overlay) { callback(); return; }
                gsap.to(overlay, {
                    opacity: 0,
                    duration: 0.2,
                    ease: 'power2.in',
                    onComplete: callback,
                });
            },

            /* Touch / swipe state */
            _touchStartX: null,

            handleTouchStart(e) {
                this._touchStartX = e.changedTouches[0].clientX;
            },

            handleTouchEnd(e) {
                if (this._touchStartX === null) return;
                const dx = e.changedTouches[0].clientX - this._touchStartX;
                if (Math.abs(dx) > 50) {
                    if (dx < 0) { this.next(); } else { this.prev(); }
                }
                this._touchStartX = null;
            }
        }"
        @keydown.escape.window="if (open) close()"
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
                               x-navigate
                               class="hover:text-white transition-colors"
                               style="color: rgba(255,255,255,0.5);">
                                {{ __('nav.home') }}
                            </a>
                        </li>
                        <li style="color: rgba(255,255,255,0.3);">/</li>
                        <li>
                            <a href="{{ route('public.gallery') }}"
                               x-navigate
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

                <div class="flex items-center gap-4 flex-wrap">
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

                    {{-- Empty state (BR-008: translated) --}}
                    <div class="text-center py-20">
                        <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6"
                             style="background-color: #ffffff;">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="1.2" style="color: #c8a03c;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                            </svg>
                        </div>
                        <h2 class="font-heading text-xl font-bold mb-2"
                            style="font-family: 'Playfair Display', serif; color: #002850;">
                            {{ __('gallery.album_empty') }}
                        </h2>
                        <p class="text-sm" style="color: #64748b;">{{ __('gallery.album_empty_sub') }}</p>
                    </div>

                @else

                    {{-- Photo grid: 2-col mobile+tablet, 3-col mid, 4-col desktop --}}
                    <div class="photo-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach ($photos as $i => $photo)
                            @php
                                $caption = app()->getLocale() === 'fr'
                                    ? ($photo->caption_fr ?? '')
                                    : ($photo->caption_en ?? '');
                            @endphp
                            <button
                                @click="openAt({{ $i }})"
                                class="gallery-photo-thumb group relative overflow-hidden rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                                style="aspect-ratio: 1/1; focus-ring-color: #c80078;"
                                aria-label="{{ __('gallery.expand_photo') }}{{ $caption ? ': ' . $caption : '' }}">

                                <img src="{{ asset($photo->path) }}"
                                     alt="{{ $caption }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy">

                                {{-- Hover overlay — flat dark color, no gradient (BR-001) --}}
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                     style="background-color: rgba(0,20,60,0.5);">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
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
                       x-navigate
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
             BR-004: dark backdrop (#000), centered image, arrows, close, counter
             BR-005: GSAP fade-in/out on open/close; cross-fade on photo change
             BR-006: keyboard nav (ArrowLeft/Right, Escape) — handled via @keydown above
             ================================================================ --}}
        <div
            x-cloak
            x-show="open"
            id="gallery-lightbox"
            class="fixed inset-0 z-50 flex items-center justify-center"
            style="background-color: rgba(0,0,0,0.92);"
            @click.self="close()"
            @touchstart="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)"
            role="dialog"
            aria-modal="true"
            :aria-label="activeIndex !== null ? photos[activeIndex].caption || '{{ __('gallery.expand_photo') }}' : '{{ __('gallery.expand_photo') }}'">

            {{-- Close button — top right --}}
            <button
                @click="close()"
                class="absolute top-4 right-4 w-11 h-11 flex items-center justify-center rounded-full transition-colors z-20"
                style="color: #ffffff; background-color: rgba(255,255,255,0.1);"
                @mouseover="$el.style.backgroundColor='rgba(255,255,255,0.2)'"
                @mouseout="$el.style.backgroundColor='rgba(255,255,255,0.1)'"
                :aria-label="'{{ __('gallery.close_lightbox') }}'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Prev arrow --}}
            <button
                @click.stop="prev()"
                x-show="photos.length > 1 && activeIndex > 0"
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full transition-colors z-20"
                style="color: #ffffff; background-color: rgba(255,255,255,0.1);"
                @mouseover="$el.style.backgroundColor='rgba(255,255,255,0.2)'"
                @mouseout="$el.style.backgroundColor='rgba(255,255,255,0.1)'"
                :aria-label="'{{ __('gallery.prev_photo') }}'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>

            {{-- Next arrow --}}
            <button
                @click.stop="next()"
                x-show="photos.length > 1 && activeIndex < photos.length - 1"
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full transition-colors z-20"
                style="color: #ffffff; background-color: rgba(255,255,255,0.1);"
                @mouseover="$el.style.backgroundColor='rgba(255,255,255,0.2)'"
                @mouseout="$el.style.backgroundColor='rgba(255,255,255,0.1)'"
                :aria-label="'{{ __('gallery.next_photo') }}'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </button>

            {{-- Photo + caption (centered) --}}
            <div id="lightbox-inner"
                 class="relative flex flex-col items-center justify-center px-14 sm:px-20 max-h-screen w-full gap-4">
                <template x-if="activeIndex !== null">
                    <div class="flex flex-col items-center gap-3 max-w-5xl w-full">

                        {{-- Image wrapper with cross-fade transition + loading spinner --}}
                        <div class="lightbox-img-wrap w-full flex justify-center relative"
                             :class="imgFading ? 'fading' : ''"
                             style="min-height: 120px;">

                            {{-- Loading spinner — shown while image loads --}}
                            <div x-show="imgLoading"
                                 class="absolute inset-0 flex items-center justify-center"
                                 aria-label="{{ __('gallery.loading_image') }}">
                                <svg class="w-10 h-10 animate-spin" fill="none" viewBox="0 0 24 24"
                                     aria-hidden="true" style="color: rgba(200,0,120,0.7);">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="3"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>

                            <img :src="photos[activeIndex].url"
                                 :alt="photos[activeIndex].caption"
                                 @load="imgLoading = false"
                                 @error="imgLoading = false"
                                 class="max-h-[75vh] max-w-full object-contain rounded-lg shadow-2xl"
                                 :style="imgLoading ? 'opacity: 0;' : 'opacity: 1; transition: opacity 0.2s ease;'"
                                 style="display: block;">
                        </div>

                        {{-- Caption — only render if non-empty (BR-spec: no empty caption element) --}}
                        <template x-if="photos[activeIndex].caption">
                            <p x-text="photos[activeIndex].caption"
                               class="text-sm text-center px-4"
                               style="color: rgba(255,255,255,0.75); max-width: 600px;"></p>
                        </template>

                        {{-- Counter — bottom center (BR-004) --}}
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-full tabular-nums"
                              style="background-color: rgba(255,255,255,0.12); color: rgba(255,255,255,0.8);"
                              x-text="(activeIndex + 1) + ' / ' + photos.length"></span>

                    </div>
                </template>
            </div>

        </div>

    </div>

@endsection
