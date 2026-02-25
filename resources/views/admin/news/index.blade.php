@extends('layouts.admin')

@section('title', 'Articles — Actualités')
@section('page_title', 'Articles d\'actualités')
@section('breadcrumb', 'Actualités')

@section('content')

    <div x-data>

        {{-- Header actions --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm" style="color: #64748b;">
                {{ $articles->total() }} article{{ $articles->total() !== 1 ? 's' : '' }}
            </p>
            <a href="{{ route('admin.news.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
               style="background-color: #c80078;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouvel article
            </a>
        </div>

        {{-- Articles table --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            @if ($articles->isEmpty())
                <div class="py-16 text-center">
                    <p class="text-sm" style="color: #94a3b8;">Aucun article pour le moment.</p>
                    <a href="{{ route('admin.news.create') }}"
                       class="inline-block mt-3 text-xs font-semibold"
                       style="color: #c80078;">
                        Créer le premier article →
                    </a>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #94a3b8;">Article</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden sm:table-cell" style="color: #94a3b8;">Catégorie</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden md:table-cell" style="color: #94a3b8;">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden lg:table-cell" style="color: #94a3b8;">Date</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #f8fafc;">
                        @foreach ($articles as $article)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0"
                                             style="background-color: #f1f5f9;">
                                            @if ($article->thumbnail_path)
                                                <img src="{{ asset($article->thumbnail_path) }}"
                                                     alt=""
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color: #cbd5e1;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 3v18M21 3v18"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold truncate max-w-xs" style="color: #1e293b;">
                                                {{ $article->title_fr }}
                                            </p>
                                            <p class="text-xs truncate max-w-xs" style="color: #94a3b8;">
                                                {{ $article->slug }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    @if ($article->category_slug)
                                        <span class="text-xs font-medium px-2.5 py-1 rounded-full"
                                              style="background-color: #c8007812; color: #c80078;">
                                            {{ $article->category_fr }}
                                        </span>
                                    @else
                                        <span class="text-xs" style="color: #cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    @if ($article->status === 'published')
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                              style="background-color: #dcfce7; color: #16a34a;">
                                            Publié
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                              style="background-color: #f1f5f9; color: #64748b;">
                                            Brouillon
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-xs hidden lg:table-cell" style="color: #94a3b8;">
                                    {{ $article->published_at?->format('d/m/Y') ?? $article->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1 justify-end">
                                        <a href="{{ route('admin.news.edit', $article) }}"
                                           class="p-1.5 rounded-lg transition-colors hover:bg-slate-100"
                                           style="color: #64748b;"
                                           title="Modifier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                            </svg>
                                        </a>
                                        @if ($article->status === 'published')
                                            <a href="{{ route('public.news.show', $article) }}"
                                               target="_blank"
                                               class="p-1.5 rounded-lg transition-colors hover:bg-slate-100"
                                               style="color: #64748b;"
                                               title="Voir en ligne">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                        <button
                                            @click="if (confirm('Supprimer cet article ?')) $action.delete('{{ route('admin.news.destroy', $article) }}')"
                                            class="p-1.5 rounded-lg transition-colors hover:bg-red-50"
                                            style="color: #ef4444;"
                                            title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($articles->hasPages())
                    <div class="px-6 py-4 border-t flex items-center justify-center gap-2" style="border-color: #f1f5f9;">
                        @if (! $articles->onFirstPage())
                            <a href="{{ $articles->previousPageUrl() }}"
                               class="px-3 py-1.5 rounded-lg text-xs transition-colors"
                               style="border: 1px solid #e2e8f0; color: #475569;">&laquo;</a>
                        @endif
                        @foreach ($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
                            @if ($page == $articles->currentPage())
                                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white" style="background-color: #c80078;">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs transition-colors" style="border: 1px solid #e2e8f0; color: #475569;">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($articles->hasMorePages())
                            <a href="{{ $articles->nextPageUrl() }}"
                               class="px-3 py-1.5 rounded-lg text-xs transition-colors"
                               style="border: 1px solid #e2e8f0; color: #475569;">&raquo;</a>
                        @endif
                    </div>
                @endif
            @endif

        </div>

        {{-- News sub-nav --}}
        <div class="mt-5 bg-white rounded-2xl shadow-sm p-5 inline-flex gap-4">
            <a href="{{ route('admin.news.index') }}"
               class="text-xs font-semibold px-3 py-1.5 rounded-lg"
               style="color: #c80078; background-color: #c8007808;">
                Articles
            </a>
            <a href="{{ route('admin.news.categories.index') }}"
               class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors"
               style="color: #475569;">
                Catégories
            </a>
        </div>

    </div>

@endsection
