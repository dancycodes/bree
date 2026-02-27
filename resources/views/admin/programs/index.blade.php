@extends('layouts.admin')

@section('title', 'Programmes')
@section('page_title', 'Programmes')
@section('breadcrumb', 'Gestion des programmes et activités')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b" style="border-color: #e2e8f0;">
            <h2 class="text-sm font-semibold" style="color: #143c64;">
                Les 3 programmes de la Fondation BREE
            </h2>
            <p class="text-xs mt-1" style="color: #94a3b8;">
                Modifiez le contenu ou gérez les activités de chaque programme.
            </p>
        </div>

        <div class="divide-y" style="border-color: #f1f5f9;">
            @foreach ($programs as $program)
                <div class="px-6 py-5 flex items-center gap-4">

                    {{-- Color swatch --}}
                    <div class="w-1 self-stretch rounded-full flex-shrink-0"
                         style="background-color: {{ $program->color }};"></div>

                    {{-- Program image --}}
                    <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ vasset($program->image_path) }}"
                             alt="{{ $program->name_fr }}"
                             class="w-full h-full object-cover">
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm leading-tight" style="color: #1e293b;">
                            {{ $program->name_fr }}
                        </p>
                        <p class="text-xs mt-0.5" style="color: #64748b;">
                            {{ $program->name_en }}
                        </p>
                        <p class="text-xs mt-1" style="color: #94a3b8;">
                            {{ $program->program_activities_count }} activité(s)
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.programs.edit', $program) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-opacity hover:opacity-80"
                           style="background-color: #f1f5f9; color: #475569;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Modifier
                        </a>
                        <a href="{{ route('admin.programs.activities.index', $program) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-opacity hover:opacity-80"
                           style="background-color: {{ $program->color }}1a; color: {{ $program->color }};">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Activités
                        </a>
                        <a href="{{ route('admin.programs.stories.index', $program) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-opacity hover:opacity-80"
                           style="background-color: #f1f5f9; color: #475569;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                            Témoignages
                        </a>
                        <a href="{{ route('public.programs.show', $program) }}"
                           target="_blank"
                           class="p-2 rounded-lg transition-colors"
                           style="color: #94a3b8;"
                           title="Voir la page publique">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@endsection
