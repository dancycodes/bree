@extends('layouts.admin')

@section('title', 'Statistiques d\'impact')
@section('page_title', 'Statistiques d\'impact')
@section('breadcrumb', 'Statistiques')

@section('content')

    @php
        $icons = [
            ['label' => 'Enfants / Personnes', 'path' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['label' => 'Cœur / Bénéficiaires', 'path' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['label' => 'Étoile / Excellence', 'path' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
            ['label' => 'Cadenas / Sécurité', 'path' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
            ['label' => 'Maison / Foyer', 'path' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['label' => 'Diplôme / Éducation', 'path' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
            ['label' => 'Soleil / Espoir', 'path' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
            ['label' => 'Globe / Portée', 'path' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Arbre / Environnement', 'path' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
            ['label' => 'Calendrier / Années', 'path' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ];
    @endphp

    {{-- Outer div: add-form state only --}}
    <div
        x-data="{
            number: '',
            label_fr: '',
            label_en: '',
            icon_svg: '',
            is_active: '1',
            showIconPicker: false
        }"
        x-sync="['number','label_fr','label_en','icon_svg','is_active']">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Stats list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <h2 class="text-sm font-semibold" style="color: #143c64;">
                            Compteurs ({{ $stats->count() }}/8)
                        </h2>
                        <a href="{{ route('public.home') }}" target="_blank"
                           class="flex items-center gap-1.5 text-xs transition-colors"
                           style="color: #94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Voir le site
                        </a>
                    </div>

                    @fragment('stats-list')
                    @php
                        $fragmentIcons = [
                            ['label' => 'Enfants / Personnes', 'path' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                            ['label' => 'Cœur / Bénéficiaires', 'path' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                            ['label' => 'Étoile / Excellence', 'path' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                            ['label' => 'Cadenas / Sécurité', 'path' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                            ['label' => 'Maison / Foyer', 'path' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['label' => 'Diplôme / Éducation', 'path' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                            ['label' => 'Soleil / Espoir', 'path' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
                            ['label' => 'Globe / Portée', 'path' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['label' => 'Arbre / Environnement', 'path' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
                            ['label' => 'Calendrier / Années', 'path' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ];
                    @endphp
                    {{-- Fragment div owns ALL edit+drag state so x-if on list items can access editingId locally --}}
                    <div id="stats-list"
                         x-data="{
                             editingId: null,
                             editNumber: '',
                             editLabelFr: '',
                             editLabelEn: '',
                             editIconSvg: '',
                             editActive: '1',
                             showEditIconPicker: false,
                             dragSrcIdx: null,
                             items: {{ Js::from($stats->map(fn($s) => $s->id)->values()) }},
                             startEdit(id, number, labelFr, labelEn, iconSvg, isActive) {
                                 this.editingId = id;
                                 this.editNumber = number;
                                 this.editLabelFr = labelFr;
                                 this.editLabelEn = labelEn;
                                 this.editIconSvg = iconSvg;
                                 this.editActive = isActive ? '1' : '0';
                                 this.showEditIconPicker = false;
                             },
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
                                 await fetch('{{ route('admin.stats.reorder') }}', {
                                     method: 'POST',
                                     headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': {{ Js::from(csrf_token()) }} },
                                     body: JSON.stringify({ order: this.items })
                                 });
                             }
                         }"
                         x-sync="['editingId','editNumber','editLabelFr','editLabelEn','editIconSvg','editActive']">

                        @if ($stats->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucun compteur configuré.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez le premier compteur →</p>
                            </div>
                        @else
                            <ul class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($stats as $idx => $stat)
                                    <li id="stat-{{ $stat->id }}"
                                        class="transition-opacity"
                                        draggable="true"
                                        @dragstart="dragStart({{ $idx }})"
                                        @dragenter.prevent="dragEnter({{ $idx }})"
                                        @dragover.prevent
                                        @dragend="dragEnd()"
                                        :style="dragSrcIdx === {{ $idx }} ? 'opacity:0.4' : ''">

                                        <template x-if="editingId !== {{ $stat->id }}">
                                            <div class="px-4 py-4 flex items-start gap-3">

                                                {{-- Drag handle --}}
                                                <div class="cursor-grab mt-1 flex-shrink-0" style="color: #cbd5e1;">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                                                    </svg>
                                                </div>

                                                {{-- Icon preview --}}
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                                     style="background-color: rgba(200,160,60,0.12);">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                         stroke-width="1.5" style="color: #c8a03c;" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat->icon_svg }}"/>
                                                    </svg>
                                                </div>

                                                {{-- Info --}}
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-base font-bold leading-none" style="color: #c80078; font-family: 'Playfair Display', serif;">
                                                        {{ number_format($stat->number) }}
                                                    </p>
                                                    <p class="text-sm font-medium mt-0.5 truncate" style="color: #143c64;">
                                                        {{ $stat->label_fr }}
                                                        <span class="font-normal" style="color: #94a3b8;">/ {{ $stat->label_en }}</span>
                                                    </p>
                                                    @if (!$stat->is_active)
                                                        <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block"
                                                              style="background-color: #f1f5f9; color: #94a3b8;">Désactivé</span>
                                                    @endif
                                                </div>

                                                {{-- Actions --}}
                                                <div class="flex items-center gap-1 flex-shrink-0">
                                                    <button
                                                        @click="startEdit({{ $stat->id }}, {{ $stat->number }}, {{ json_encode($stat->label_fr) }}, {{ json_encode($stat->label_en) }}, {{ json_encode($stat->icon_svg) }}, {{ $stat->is_active ? 'true' : 'false' }})"
                                                        class="p-1.5 rounded-lg transition-colors hover:bg-slate-50"
                                                        style="color: #64748b;"
                                                        title="Modifier">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="if (confirm('Supprimer ce compteur ?')) $action.delete('{{ route('admin.stats.destroy', $stat) }}')"
                                                        class="p-1.5 rounded-lg transition-colors hover:bg-red-50"
                                                        style="color: #ef4444;"
                                                        title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                            </div>
                                        </template>

                                        <template x-if="editingId === {{ $stat->id }}">
                                            <div class="px-4 py-4 space-y-3">

                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Nombre *</label>
                                                        <input x-model="editNumber" x-name="editNumber" type="number" min="0"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editNumber" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Statut</label>
                                                        <select x-model="editActive" x-name="editActive"
                                                                class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                                style="border-color: #e2e8f0; color: #1e293b;">
                                                            <option value="1">Actif</option>
                                                            <option value="0">Désactivé</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Label (FR) *</label>
                                                        <input x-model="editLabelFr" x-name="editLabelFr" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editLabelFr" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium mb-1" style="color: #475569;">Label (EN) *</label>
                                                        <input x-model="editLabelEn" x-name="editLabelEn" type="text"
                                                               class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                                               style="border-color: #e2e8f0; color: #1e293b;">
                                                        <p x-message="editLabelEn" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                    </div>
                                                </div>

                                                {{-- Icon selector (edit) --}}
                                                <div>
                                                    <label class="block text-xs font-medium mb-1.5" style="color: #475569;">Icône *</label>
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                                                             style="background-color: rgba(200,160,60,0.12);">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                                 stroke-width="1.5" style="color: #c8a03c;" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" :d="editIconSvg"/>
                                                            </svg>
                                                        </div>
                                                        <button type="button"
                                                                @click="showEditIconPicker = !showEditIconPicker"
                                                                class="text-xs px-3 py-1.5 rounded-lg border transition-colors"
                                                                style="border-color: #e2e8f0; color: #475569;">
                                                            Changer l'icône
                                                        </button>
                                                    </div>
                                                    <div x-show="showEditIconPicker"
                                                         class="grid grid-cols-5 gap-2 p-3 rounded-xl border"
                                                         style="border-color: #e2e8f0; background-color: #f8fafc;">
                                                        @foreach ($fragmentIcons as $icon)
                                                            <button type="button"
                                                                    @click="editIconSvg = {{ json_encode($icon['path']) }}; showEditIconPicker = false"
                                                                    :style="editIconSvg === {{ json_encode($icon['path']) }} ? 'background-color: rgba(200,0,120,0.1); border-color: #c80078;' : 'border-color: transparent;'"
                                                                    class="w-10 h-10 rounded-lg border-2 flex items-center justify-center transition-all hover:bg-white"
                                                                    title="{{ $icon['label'] }}">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                     viewBox="0 0 24 24" stroke-width="1.5" style="color: #c8a03c;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="{{ $icon['path'] }}"/>
                                                                </svg>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" x-model="editIconSvg" x-name="editIconSvg">
                                                    <p x-message="editIconSvg" class="text-xs mt-1" style="color: #ef4444;"></p>
                                                </div>

                                                <div class="flex items-center gap-2 pt-1">
                                                    <button
                                                        @click="$action.patch('{{ route('admin.stats.update', $stat) }}')"
                                                        :disabled="$fetching()"
                                                        class="px-4 py-2 rounded-lg text-xs font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                                                        style="background-color: #c80078;">
                                                        <span x-show="!$fetching()">Enregistrer</span>
                                                        <span x-show="$fetching()">…</span>
                                                    </button>
                                                    <button
                                                        @click="editingId = null"
                                                        class="px-4 py-2 rounded-lg text-xs font-semibold transition-colors"
                                                        style="color: #64748b; border: 1px solid #e2e8f0;">
                                                        Annuler
                                                    </button>
                                                </div>

                                            </div>
                                        </template>

                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                    @endfragment

                </div>
            </div>

            {{-- Right: Add form --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Nouveau compteur
                    </h3>

                    @if ($stats->count() >= 8)
                        <p class="text-sm" style="color: #94a3b8;">Maximum 8 statistiques atteint.</p>
                    @else
                        <div class="space-y-3">

                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                    Nombre <span style="color: #ef4444;">*</span>
                                </label>
                                <input x-model="number" x-name="number" type="number" min="0"
                                       class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;"
                                       placeholder="1200">
                                <p x-message="number" class="text-xs mt-1" style="color: #ef4444;"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                    Label (FR) <span style="color: #ef4444;">*</span>
                                </label>
                                <input x-model="label_fr" x-name="label_fr" type="text"
                                       class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;"
                                       placeholder="enfants aidés">
                                <p x-message="label_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                    Label (EN) <span style="color: #ef4444;">*</span>
                                </label>
                                <input x-model="label_en" x-name="label_en" type="text"
                                       class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                                       style="border-color: #e2e8f0; color: #1e293b;"
                                       placeholder="children helped">
                                <p x-message="label_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                            </div>

                            {{-- Icon picker --}}
                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                    Icône <span style="color: #ef4444;">*</span>
                                </label>

                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                                         :style="icon_svg ? 'background-color: rgba(200,160,60,0.12);' : 'background-color: #f1f5f9;'">
                                        <template x-if="icon_svg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 stroke-width="1.5" style="color: #c8a03c;" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" :d="icon_svg"/>
                                            </svg>
                                        </template>
                                        <template x-if="!icon_svg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 stroke-width="1.5" style="color: #cbd5e1;" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                                            </svg>
                                        </template>
                                    </div>
                                    <button type="button"
                                            @click="showIconPicker = !showIconPicker"
                                            class="text-xs px-3 py-1.5 rounded-lg border transition-colors"
                                            style="border-color: #e2e8f0; color: #475569;">
                                        <span x-show="!icon_svg">Choisir une icône</span>
                                        <span x-show="icon_svg">Changer l'icône</span>
                                    </button>
                                </div>

                                <div x-show="showIconPicker"
                                     class="grid grid-cols-5 gap-2 p-3 rounded-xl border"
                                     style="border-color: #e2e8f0; background-color: #f8fafc;">
                                    @foreach ($icons as $icon)
                                        <button type="button"
                                                @click="icon_svg = {{ json_encode($icon['path']) }}; showIconPicker = false"
                                                :style="icon_svg === {{ json_encode($icon['path']) }} ? 'background-color: rgba(200,0,120,0.1); border-color: #c80078;' : 'border-color: transparent;'"
                                                class="w-10 h-10 rounded-lg border-2 flex items-center justify-center transition-all hover:bg-white"
                                                title="{{ $icon['label'] }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" stroke-width="1.5" style="color: #c8a03c;">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="{{ $icon['path'] }}"/>
                                            </svg>
                                        </button>
                                    @endforeach
                                </div>

                                <input type="hidden" x-model="icon_svg" x-name="icon_svg">
                                <p x-message="icon_svg" class="text-xs mt-1" style="color: #ef4444;"></p>
                            </div>

                            <button
                                @click="$action('{{ route('admin.stats.store') }}')"
                                :disabled="$fetching()"
                                class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                                style="background-color: #c80078;">
                                <span x-show="!$fetching()">Ajouter le compteur</span>
                                <span x-show="$fetching()">Ajout…</span>
                            </button>

                        </div>
                    @endif
                </div>

                {{-- Info card --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold mb-3 uppercase tracking-wider" style="color: #94a3b8;">
                        À propos
                    </h3>
                    <ul class="space-y-2 text-xs" style="color: #64748b;">
                        <li class="flex items-start gap-2">
                            <span style="color: #c8a03c;">•</span>
                            Minimum 4, maximum 8 compteurs affichés sur la page d'accueil.
                        </li>
                        <li class="flex items-start gap-2">
                            <span style="color: #c8a03c;">•</span>
                            Glissez-déposez les compteurs pour réorganiser leur ordre.
                        </li>
                        <li class="flex items-start gap-2">
                            <span style="color: #c8a03c;">•</span>
                            Les compteurs désactivés ne s'affichent pas sur le site.
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

@endsection
