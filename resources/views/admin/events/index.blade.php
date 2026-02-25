@extends('layouts.admin')

@section('title', 'Événements')
@section('page_title', 'Événements')
@section('breadcrumb', 'Événements')

@section('content')

    <div
        x-data="{ search: {{ Js::from($search) }} }"
        x-navigate.key.events-table>

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                {{-- Status filter tabs --}}
                <div class="flex items-center gap-1 p-1 rounded-xl" style="background-color: #f1f5f9;">
                    @foreach ([
                        'all' => ['label' => 'Tous', 'count' => $counts['all']],
                        'published' => ['label' => 'Publiés', 'count' => $counts['published']],
                        'draft' => ['label' => 'Brouillons', 'count' => $counts['draft']],
                    ] as $tab => $info)
                        <a href="{{ route('admin.events.index', array_merge(request()->only('search'), ['status' => $tab])) }}"
                           @click.prevent="$navigate('{{ route('admin.events.index', array_merge(request()->only('search'), ['status' => $tab])) }}', { key: 'events-table', replace: true })"
                           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                           style="{{ $status === $tab
                               ? 'background-color: #ffffff; color: #1e293b; box-shadow: 0 1px 3px rgba(0,0,0,0.08);'
                               : 'color: #64748b;' }}">
                            {{ $info['label'] }}
                            <span class="ml-1 text-xs {{ $status === $tab ? '' : 'opacity-60' }}">{{ $info['count'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('admin.events.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
               style="background-color: #c80078;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouvel événement
            </a>
        </div>

        {{-- Search --}}
        <div class="mb-4">
            <div class="relative max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" stroke-width="1.75" style="color: #94a3b8;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803z"/>
                </svg>
                <input
                    x-model="search"
                    type="text"
                    placeholder="Rechercher par titre…"
                    @input.debounce.400ms="$navigate('{{ route('admin.events.index') }}' + '?status={{ $status }}&search=' + encodeURIComponent($event.target.value), { key: 'events-table', replace: true })"
                    class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border focus:outline-none"
                    style="border-color: #e2e8f0; color: #1e293b;">
            </div>
        </div>

        @fragment('events-table')
        <div id="events-table">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                @if ($events->isEmpty())
                    <div class="py-16 text-center">
                        @if ($search !== '')
                            <p class="text-sm" style="color: #94a3b8;">Aucun événement ne correspond à « {{ $search }} ».</p>
                            <a href="{{ route('admin.events.index', ['status' => $status]) }}"
                               @click.prevent="search = ''; $navigate('{{ route('admin.events.index', ['status' => $status]) }}', { key: 'events-table', replace: true })"
                               class="inline-block mt-2 text-xs font-semibold" style="color: #c80078;">
                                Effacer la recherche
                            </a>
                        @else
                            <p class="text-sm" style="color: #94a3b8;">Aucun événement pour le moment.</p>
                            <a href="{{ route('admin.events.create') }}" class="inline-block mt-3 text-xs font-semibold"
                               style="color: #c80078;">
                                Créer le premier événement →
                            </a>
                        @endif
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider"
                                    style="color: #94a3b8;">Événement</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden sm:table-cell"
                                    style="color: #94a3b8;">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden md:table-cell"
                                    style="color: #94a3b8;">Statut</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden lg:table-cell"
                                    style="color: #94a3b8;">Inscrits</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="border-color: #f8fafc;">
                            @foreach ($events as $event)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0"
                                                 style="background-color: #f1f5f9;">
                                                @if ($event->thumbnail_path)
                                                    <img src="{{ asset($event->thumbnail_path) }}" alt=""
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" stroke-width="1.5"
                                                             style="color: #cbd5e1;">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate max-w-xs"
                                                   style="color: #1e293b;">
                                                    {{ $event->title_fr }}
                                                </p>
                                                <p class="text-xs truncate max-w-xs font-mono"
                                                   style="color: #94a3b8;">
                                                    {{ $event->slug }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs hidden sm:table-cell" style="color: #475569;">
                                        {{ $event->event_date->format('d/m/Y') }}
                                        @if ($event->event_time)
                                            <span style="color: #94a3b8;">{{ \Carbon\Carbon::createFromFormat('H:i:s', $event->event_time)->format('H:i') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        @if ($event->is_published)
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                                  style="background-color: #dcfce7; color: #16a34a;">Publié</span>
                                        @else
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                                  style="background-color: #f1f5f9; color: #64748b;">Brouillon</span>
                                        @endif
                                        @if ($event->registration_required)
                                            <span class="ml-1 text-xs font-semibold px-2.5 py-1 rounded-full"
                                                  style="background-color: #c8007812; color: #c80078;">Inscriptions</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-xs hidden lg:table-cell" style="color: #475569;">
                                        @if ($event->registration_required)
                                            {{ $event->registrations_count }}
                                            @if ($event->max_capacity)
                                                / {{ $event->max_capacity }}
                                            @endif
                                        @else
                                            <span style="color: #cbd5e1;">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-1 justify-end">
                                            <a href="{{ route('admin.events.edit', $event) }}"
                                               class="p-1.5 rounded-lg transition-colors hover:bg-slate-100"
                                               style="color: #64748b;" title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                </svg>
                                            </a>
                                            @if ($event->is_published)
                                                <a href="{{ route('public.events.show', $event) }}"
                                                   target="_blank"
                                                   class="p-1.5 rounded-lg transition-colors hover:bg-slate-100"
                                                   style="color: #64748b;" title="Voir en ligne">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                </a>
                                            @endif
                                            <button
                                                @click="if (confirm('Supprimer cet événement ?')) $action.delete('{{ route('admin.events.destroy', $event) }}')"
                                                class="p-1.5 rounded-lg transition-colors hover:bg-red-50"
                                                style="color: #ef4444;" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($events->hasPages())
                        <div class="px-6 py-4 border-t flex items-center justify-center gap-2"
                             style="border-color: #f1f5f9;">
                            @if (! $events->onFirstPage())
                                <a href="{{ $events->previousPageUrl() }}"
                                   @click.prevent="$navigate('{{ $events->previousPageUrl() }}', { key: 'events-table', replace: true })"
                                   class="px-3 py-1.5 rounded-lg text-xs transition-colors"
                                   style="border: 1px solid #e2e8f0; color: #475569;">&laquo;</a>
                            @endif
                            @foreach ($events->getUrlRange(max(1, $events->currentPage() - 2), min($events->lastPage(), $events->currentPage() + 2)) as $page => $url)
                                @if ($page == $events->currentPage())
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white"
                                          style="background-color: #c80078;">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                       @click.prevent="$navigate('{{ $url }}', { key: 'events-table', replace: true })"
                                       class="px-3 py-1.5 rounded-lg text-xs transition-colors"
                                       style="border: 1px solid #e2e8f0; color: #475569;">{{ $page }}</a>
                                @endif
                            @endforeach
                            @if ($events->hasMorePages())
                                <a href="{{ $events->nextPageUrl() }}"
                                   @click.prevent="$navigate('{{ $events->nextPageUrl() }}', { key: 'events-table', replace: true })"
                                   class="px-3 py-1.5 rounded-lg text-xs transition-colors"
                                   style="border: 1px solid #e2e8f0; color: #475569;">&raquo;</a>
                            @endif
                        </div>
                    @endif
                @endif

            </div>

        </div>
        @endfragment

    </div>

@endsection
