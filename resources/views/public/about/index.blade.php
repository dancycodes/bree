@extends('layouts.public')

@section('title', __('about.page_title') . ' — ' . config('app.name'))
@section('meta_description', __('about.meta_description'))

@section('content')

    {{-- ================================================================
         PAGE HERO
         ================================================================ --}}
    <section class="relative overflow-hidden" style="height: clamp(360px, 50vw, 560px);">

        <img src="{{ asset('images/sections/about.jpg') }}"
             alt="{{ __('about.page_title') }}"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0" style="background-color: rgba(0,20,60,0.75);"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

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
                    <li style="color: #ffffff;">{{ __('about.page_title') }}</li>
                </ol>
            </nav>

            <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                  style="color: #c8a03c;"
                  data-animate="fade-up">
                {{ __('about.hero_label') }}
            </span>

            <h1 class="font-heading font-bold"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(2rem, 5vw, 4rem);
                       color: #ffffff;
                       line-height: 1.1;"
                data-animate="fade-up">
                {{ __('about.hero_heading') }}
            </h1>

            <p class="mt-4 text-base max-w-xl"
               style="color: rgba(255,255,255,0.75);"
               data-animate="fade-up">
                {{ __('about.hero_tagline') }}
            </p>

            <div class="mt-6 h-1 w-16 rounded-full" style="background-color: #c8a03c;"></div>
        </div>

    </section>

    {{-- ================================================================
         ORIGIN STORY
         ================================================================ --}}
    <section class="py-24 lg:py-32" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                {{-- Image --}}
                <div class="relative" data-animate="fade-right">
                    <div class="rounded-2xl overflow-hidden" style="aspect-ratio: 4/3;">
                        <img src="{{ asset('images/sections/about.jpg') }}"
                             alt="{{ __('about.story_heading') }}"
                             class="w-full h-full object-cover">
                    </div>
                    {{-- Accent block --}}
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 rounded-2xl -z-10"
                         style="background-color: #c8a03c26;"></div>
                    <div class="absolute -top-4 -left-4 w-16 h-16 rounded-xl -z-10"
                         style="background-color: #c8007826;"></div>
                </div>

                {{-- Text --}}
                <div data-animate="fade-left">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                          style="color: #c80078;">
                        {{ __('about.story_label') }}
                    </span>
                    <h2 class="font-heading font-bold mb-8"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.75rem, 3.5vw, 2.75rem);
                               color: #002850;
                               line-height: 1.2;">
                        {{ __('about.story_heading') }}
                    </h2>
                    <div class="space-y-5">
                        <p class="text-base leading-relaxed" style="color: #5a6a7a;">
                            {{ __('about.story_p1') }}
                        </p>
                        <p class="text-base leading-relaxed" style="color: #5a6a7a;">
                            {{ __('about.story_p2') }}
                        </p>
                        <p class="text-base font-medium leading-relaxed" style="color: #143c64;">
                            {{ __('about.story_p3') }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ================================================================
         FOUNDER PROFILE
         ================================================================ --}}
    @if ($founder)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #002850;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                    {{-- Portrait --}}
                    <div class="flex justify-center lg:justify-end" data-animate="fade-right">
                        @if ($founder->photo_path)
                            <div class="relative">
                                <div class="w-72 h-72 lg:w-96 lg:h-96 rounded-full overflow-hidden border-4"
                                     style="border-color: #c8a03c;">
                                    <img src="{{ asset($founder->photo_path) }}"
                                         alt="{{ $founder->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                {{-- Gold ring accent --}}
                                <div class="absolute -bottom-3 -right-3 w-24 h-24 rounded-full border-2"
                                     style="border-color: #c8a03c40;"></div>
                            </div>
                        @else
                            {{-- Elegant placeholder --}}
                            <div class="relative">
                                <div class="w-72 h-72 lg:w-80 lg:h-80 rounded-full flex items-center justify-center border-4"
                                     style="border-color: #c8a03c; background-color: rgba(200,160,60,0.08);">
                                    <div class="text-center">
                                        <div class="font-heading font-bold text-5xl mb-2"
                                             style="font-family: 'Playfair Display', serif; color: #c8a03c;">
                                            {{ mb_strtoupper(mb_substr($founder->name, 0, 2)) }}
                                        </div>
                                        <div class="w-8 h-0.5 mx-auto rounded-full" style="background-color: #c8a03c;"></div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-3 -right-3 w-20 h-20 rounded-full border-2"
                                     style="border-color: #c8a03c30;"></div>
                            </div>
                        @endif
                    </div>

                    {{-- Bio --}}
                    <div data-animate="fade-left">
                        <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                              style="color: #c8a03c;">
                            {{ __('about.founder_label') }}
                        </span>
                        <h2 class="font-heading font-bold mb-2"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                                   color: #ffffff;">
                            {{ $founder->name }}
                        </h2>
                        <p class="text-sm font-semibold mb-8" style="color: #c80078;">
                            {{ $founder->title() }}
                        </p>

                        <div class="space-y-4 mb-8">
                            @foreach (explode("\n\n", $founder->bio()) as $paragraph)
                                <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.75);">
                                    {{ $paragraph }}
                                </p>
                            @endforeach
                        </div>

                        @if ($founder->message())
                            <blockquote class="border-l-2 pl-6 italic"
                                        style="border-color: #c8a03c;
                                               font-family: 'Playfair Display', serif;
                                               font-size: 1rem;
                                               color: rgba(255,255,255,0.9);
                                               line-height: 1.6;">
                                {{ $founder->message() }}
                            </blockquote>
                        @endif
                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         TIMELINE
         ================================================================ --}}
    @if ($milestones->count() > 0)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #f8f5f0;">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c8a03c;">
                        {{ __('about.timeline_label') }}
                    </span>
                    <h2 class="font-heading font-bold"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                               color: #002850;">
                        {{ __('about.timeline_heading') }}
                    </h2>
                </div>

                {{-- Timeline --}}
                <div class="relative">
                    {{-- Vertical line --}}
                    <div class="absolute left-6 top-0 bottom-0 w-px md:left-1/2 md:-translate-x-px"
                         style="background-color: #143c6430;"></div>

                    <div class="space-y-12">
                        @foreach ($milestones as $index => $milestone)
                            @php $isEven = $index % 2 === 0; @endphp
                            <div class="relative flex items-start gap-6 md:gap-0"
                                 data-animate="fade-up">

                                {{-- Desktop: alternate sides --}}
                                {{-- Mobile: always left --}}
                                <div class="md:w-1/2 @if($isEven) md:pr-10 md:text-right @else md:order-last md:pl-10 @endif hidden md:block">
                                    @if ($isEven)
                                        <div class="inline-block">
                                            <div class="text-3xl font-bold font-heading mb-1"
                                                 style="font-family: 'Playfair Display', serif; color: #c8a03c;">
                                                {{ $milestone->year }}
                                            </div>
                                            <h3 class="font-semibold text-lg mb-2" style="color: #002850;">
                                                {{ $milestone->title() }}
                                            </h3>
                                            @if ($milestone->description())
                                                <p class="text-sm leading-relaxed" style="color: #5a6a7a;">
                                                    {{ $milestone->description() }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Gold dot --}}
                                <div class="flex-shrink-0 relative z-10 md:absolute md:left-1/2 md:-translate-x-1/2 md:top-1">
                                    <div class="w-3 h-3 rounded-full border-2"
                                         style="background-color: #c8a03c; border-color: #f8f5f0; box-shadow: 0 0 0 3px #c8a03c40;"></div>
                                </div>

                                {{-- Right side (even) or left side (odd) on desktop, always shown on mobile --}}
                                <div class="flex-1 md:w-1/2 @if(!$isEven) md:pr-10 md:text-right @else md:pl-10 @endif">
                                    {{-- Mobile: always show here --}}
                                    <div class="md:hidden">
                                        <div class="text-2xl font-bold font-heading mb-1"
                                             style="font-family: 'Playfair Display', serif; color: #c8a03c;">
                                            {{ $milestone->year }}
                                        </div>
                                        <h3 class="font-semibold text-base mb-1.5" style="color: #002850;">
                                            {{ $milestone->title() }}
                                        </h3>
                                        @if ($milestone->description())
                                            <p class="text-sm leading-relaxed" style="color: #5a6a7a;">
                                                {{ $milestone->description() }}
                                            </p>
                                        @endif
                                    </div>
                                    {{-- Desktop: only show on odd --}}
                                    @if (!$isEven)
                                        <div class="hidden md:inline-block">
                                            <div class="text-3xl font-bold font-heading mb-1"
                                                 style="font-family: 'Playfair Display', serif; color: #c8a03c;">
                                                {{ $milestone->year }}
                                            </div>
                                            <h3 class="font-semibold text-lg mb-2" style="color: #002850;">
                                                {{ $milestone->title() }}
                                            </h3>
                                            @if ($milestone->description())
                                                <p class="text-sm leading-relaxed" style="color: #5a6a7a;">
                                                    {{ $milestone->description() }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         PATRON PROFILE
         ================================================================ --}}
    @if ($patron)
        <section class="py-24 lg:py-32 overflow-hidden" style="background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                    {{-- Bio (left) --}}
                    <div data-animate="fade-right">
                        <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                              style="color: #c80078;">
                            {{ __('about.patron_label') }}
                        </span>
                        <h2 class="font-heading font-bold mb-2"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                                   color: #002850;">
                            {{ $patron->name }}
                        </h2>
                        <p class="text-sm font-semibold mb-2" style="color: #c80078;">
                            {{ $patron->title() }}
                        </p>
                        <p class="text-xs font-medium mb-8" style="color: #c8a03c;">
                            {{ $patron->role() }}
                        </p>

                        @if ($patron->description())
                            <div class="space-y-4 mb-8">
                                @foreach (explode("\n\n", $patron->description()) as $paragraph)
                                    <p class="text-sm leading-relaxed" style="color: #5a6a7a;">
                                        {{ $paragraph }}
                                    </p>
                                @endforeach
                            </div>
                        @endif

                        @if ($patron->quote())
                            <blockquote class="border-l-2 pl-6 italic"
                                        style="border-color: #c8a03c;
                                               font-family: 'Playfair Display', serif;
                                               font-size: 1rem;
                                               color: #002850;
                                               line-height: 1.6;">
                                {{ $patron->quote() }}
                            </blockquote>
                        @endif
                    </div>

                    {{-- Portrait (right) --}}
                    <div class="flex justify-center lg:justify-start" data-animate="fade-left">
                        @if ($patron->photo_path)
                            <div class="relative">
                                <div class="w-72 h-72 lg:w-96 lg:h-96 rounded-full overflow-hidden border-4"
                                     style="border-color: #c8a03c;">
                                    <img src="{{ asset($patron->photo_path) }}"
                                         alt="{{ $patron->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-3 -left-3 w-24 h-24 rounded-full border-2"
                                     style="border-color: #c8a03c40;"></div>
                            </div>
                        @else
                            <div class="relative">
                                <div class="w-72 h-72 lg:w-80 lg:h-80 rounded-full flex items-center justify-center border-4"
                                     style="border-color: #c8a03c; background-color: rgba(200,160,60,0.06);">
                                    <div class="text-center">
                                        <div class="font-heading font-bold text-5xl mb-2"
                                             style="font-family: 'Playfair Display', serif; color: #c8a03c;">
                                            {{ mb_strtoupper(mb_substr($patron->name, 0, 2)) }}
                                        </div>
                                        <div class="w-8 h-0.5 mx-auto rounded-full" style="background-color: #c8a03c;"></div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-3 -left-3 w-20 h-20 rounded-full border-2"
                                     style="border-color: #c8a03c30;"></div>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         5 MISSION COMMITMENTS
         ================================================================ --}}
    <section class="py-24 lg:py-32" style="background-color: #002850;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16" data-animate="fade-up">
                <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                      style="color: #c8a03c;">
                    {{ __('about.values_label') }}
                </span>
                <h2 class="font-heading font-bold"
                    style="font-family: 'Playfair Display', serif;
                           font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                           color: #ffffff;">
                    {{ __('about.values_heading') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6" data-stagger="0.08">
                @foreach ([1,2,3,4,5] as $i)
                    <div class="rounded-2xl p-6 flex flex-col items-center text-center"
                         style="background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);"
                         data-animate="fade-up">

                        {{-- Number badge --}}
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4 font-bold text-sm"
                             style="background-color: #c8a03c20; color: #c8a03c; border: 1px solid #c8a03c40;">
                            {{ $i }}
                        </div>

                        <h3 class="font-heading font-bold mb-3"
                            style="font-family: 'Playfair Display', serif;
                                   font-size: 1.1rem;
                                   color: #ffffff;">
                            {{ __('about.value_' . $i . '_title') }}
                        </h3>
                        <p class="text-xs leading-relaxed" style="color: rgba(255,255,255,0.65);">
                            {{ __('about.value_' . $i . '_desc') }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ================================================================
         TEAM MEMBERS
         ================================================================ --}}
    @if ($teamMembers->isNotEmpty())
        <section class="py-24 lg:py-32" style="background-color: #f8f5f0;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16" data-animate="fade-up">
                    <span class="block text-xs font-bold tracking-widest uppercase mb-3"
                          style="color: #c80078;">
                        {{ __('about.team_label') }}
                    </span>
                    <h2 class="font-heading font-bold"
                        style="font-family: 'Playfair Display', serif;
                               font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                               color: #002850;">
                        {{ __('about.team_heading') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-stagger="0.07">
                    @foreach ($teamMembers as $member)
                        <div class="text-center group" data-animate="fade-up">

                            {{-- Photo or monogram --}}
                            <div class="mx-auto mb-5 relative"
                                 style="width: 140px; height: 140px;">
                                @if ($member->photo_path)
                                    <div class="w-full h-full rounded-full overflow-hidden border-2 transition-transform duration-300 group-hover:scale-105"
                                         style="border-color: #e2e8f0;">
                                        <img src="{{ asset($member->photo_path) }}"
                                             alt="{{ $member->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-full rounded-full flex items-center justify-center border-2 transition-transform duration-300 group-hover:scale-105"
                                         style="border-color: #c8007830; background-color: rgba(200,0,120,0.06);">
                                        <span class="font-heading font-bold text-2xl"
                                              style="font-family: 'Playfair Display', serif; color: #c80078;">
                                            {{ $member->initials() }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Name & title --}}
                            <h3 class="font-semibold text-base mb-1" style="color: #002850;">
                                {{ $member->name }}
                            </h3>
                            <p class="text-xs font-medium" style="color: #c80078;">
                                {{ $member->title() }}
                            </p>

                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ================================================================
         CTA
         ================================================================ --}}
    <section class="py-20" style="background-color: #ffffff;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="fade-up">

            <div class="h-1 w-16 mx-auto mb-8 rounded-full" style="background-color: #c80078;"></div>

            <span class="block text-xs font-bold tracking-widest uppercase mb-4"
                  style="color: #c80078;">
                {{ __('about.cta_label') }}
            </span>

            <h2 class="font-heading font-bold mb-5"
                style="font-family: 'Playfair Display', serif;
                       font-size: clamp(1.75rem, 3.5vw, 2.5rem);
                       color: #002850;">
                {{ __('about.cta_heading') }}
            </h2>

            <p class="text-base leading-relaxed mb-8" style="color: #5a6a7a;">
                {{ __('about.cta_text') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.home') }}#don"
                   class="inline-flex items-center gap-3 px-8 py-4 text-sm font-semibold rounded-full text-white transition-opacity hover:opacity-90"
                   style="background-color: #c80078;">
                    {{ __('about.cta_donate') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                    </svg>
                </a>
                <a href="{{ route('public.home') }}#benevole"
                   class="inline-flex items-center gap-3 px-8 py-4 text-sm font-semibold rounded-full transition-colors"
                   style="color: #002850; border: 2px solid #002850;">
                    {{ __('about.cta_volunteer') }}
                </a>
            </div>

        </div>
    </section>

@endsection
