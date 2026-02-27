@extends('layouts.admin')

@section('title', 'Partenaires')
@section('page_title', 'Partenaires')
@section('breadcrumb', 'Partenaires')

@section('content')

    <div x-data x-navigate.key.partners-table>

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm" style="color: #64748b;">
                {{ $partners->count() }} partenaire{{ $partners->count() !== 1 ? 's' : '' }}
            </p>
            <a href="{{ route('admin.partners.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
               style="background-color: #c80078;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouveau partenaire
            </a>
        </div>

        @fragment('partners-table')
        <div id="partners-table"
             x-data="{
                 dragSrcIdx: null,
                 items: {{ Js::from($partners->map(fn($p) => $p->id)->values()) }},
                 dragStart(idx) { this.dragSrcIdx = idx; },
                 dragEnter(idx) {
                     if (this.dragSrcIdx === null || this.dragSrcIdx === idx) return;
                     const arr = [...this.items];
                     const moved = arr.splice(this.dragSrcIdx, 1)[0];
                     arr.splice(idx, 0, moved);
                     this.items = arr;
                     this.dragSrcIdx = idx;
                 },
                 async dragEnd() {
                     this.dragSrcIdx = null;
                     await fetch('{{ route('admin.partners.reorder') }}', {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': {{ Js::from(csrf_token()) }} },
                         body: JSON.stringify({ order: this.items })
                     });
                 }
             }">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                @if ($partners->isEmpty())
                    <div class="py-16 text-center">
                        <p class="text-sm mb-3" style="color: #94a3b8;">Aucun partenaire pour le moment.</p>
                        <a href="{{ route('admin.partners.create') }}" class="text-xs font-semibold"
                           style="color: #c80078;">Ajouter le premier partenaire →</a>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <th class="px-4 py-3 w-8"></th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider"
                                    style="color: #94a3b8;">Partenaire</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden sm:table-cell"
                                    style="color: #94a3b8;">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden sm:table-cell"
                                    style="color: #94a3b8;">Statut</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider hidden lg:table-cell"
                                    style="color: #94a3b8;">Site</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $idx => $partner)
                                <tr class="hover:bg-slate-50 transition-colors"
                                    draggable="true"
                                    @dragstart="dragStart({{ $idx }})"
                                    @dragenter.prevent="dragEnter({{ $idx }})"
                                    @dragover.prevent
                                    @dragend="dragEnd()"
                                    :style="dragSrcIdx === {{ $idx }} ? 'opacity:0.5' : ''"
                                    style="border-bottom: 1px solid #f8fafc;">

                                    {{-- Drag handle --}}
                                    <td class="px-4 py-4 cursor-grab" style="color: #cbd5e1;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                                        </svg>
                                    </td>

                                    {{-- Logo + name --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-10 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center"
                                                 style="background-color: #f1f5f9;">
                                                @if ($partner->logo_path)
                                                    <img src="{{ vasset($partner->logo_path) }}" alt=""
                                                         class="w-full h-full object-contain">
                                                @else
                                                    <span class="text-xs font-bold" style="color: #94a3b8;">
                                                        {{ mb_substr($partner->name, 0, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate max-w-xs" style="color: #1e293b;">
                                                    {{ $partner->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Type --}}
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @php
                                            $typeColors = [
                                                'institutional' => ['bg' => '#eff6ff', 'fg' => '#2563eb'],
                                                'financial'     => ['bg' => '#fef9c3', 'fg' => '#854d0e'],
                                                'technical'     => ['bg' => '#f0fdf4', 'fg' => '#16a34a'],
                                            ];
                                            $tc = $typeColors[$partner->type] ?? ['bg' => '#f1f5f9', 'fg' => '#64748b'];
                                        @endphp
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                              style="background-color: {{ $tc['bg'] }}; color: {{ $tc['fg'] }};">
                                            {{ $partner->typeLabel() }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @if ($partner->is_published)
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                                  style="background-color: #dcfce7; color: #16a34a;">Publié</span>
                                        @else
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                                  style="background-color: #f1f5f9; color: #64748b;">Brouillon</span>
                                        @endif
                                    </td>

                                    {{-- Website --}}
                                    <td class="px-4 py-4 hidden lg:table-cell">
                                        @if ($partner->website_url)
                                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"
                                               class="text-xs truncate max-w-[160px] block hover:underline"
                                               style="color: #c80078;">
                                                {{ parse_url($partner->website_url, PHP_URL_HOST) }}
                                            </a>
                                        @else
                                            <span class="text-xs" style="color: #cbd5e1;">—</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-1 justify-end">
                                            <a href="{{ route('admin.partners.edit', $partner) }}"
                                               class="p-1.5 rounded-lg transition-colors hover:bg-slate-100"
                                               style="color: #64748b;" title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                </svg>
                                            </a>
                                            <button
                                                @click="if (confirm('Supprimer ce partenaire ?')) $action.delete('{{ route('admin.partners.destroy', $partner) }}')"
                                                class="p-1.5 rounded-lg transition-colors hover:bg-red-50"
                                                style="color: #ef4444;" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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
                @endif

            </div>
        </div>
        @endfragment

    </div>

@endsection
