@extends('layouts.admin')

@section('title', "Équipe — À Propos")
@section('page_title', "Membres de l'équipe")
@section('breadcrumb', "À Propos › Équipe")

@section('content')

    <div
        x-data="{
            members: @json($members->pluck('id')),
            name: '',
            title_fr: '',
            title_en: '',
            is_published: false,
            draggingId: null
        }"
        x-sync="['name','title_fr','title_en','is_published','members']">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Members list --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #e2e8f0;">
                        <h2 class="text-sm font-semibold" style="color: #143c64;">
                            Membres ({{ $members->count() }})
                        </h2>
                        <p class="text-xs" style="color: #94a3b8;">Glissez pour réordonner</p>
                    </div>

                    @fragment('team-list')
                    <div id="team-list">
                        @if ($members->isEmpty())
                            <div class="px-6 py-10 text-center">
                                <p class="text-sm" style="color: #94a3b8;">Aucun membre configuré.</p>
                                <p class="text-xs mt-1" style="color: #cbd5e1;">Ajoutez le premier membre →</p>
                            </div>
                        @else
                            <ul
                                @dragover.prevent
                                class="divide-y" style="border-color: #f8fafc;">
                                @foreach ($members as $member)
                                    <li
                                        id="member-{{ $member->id }}"
                                        draggable="true"
                                        @dragstart="draggingId = {{ $member->id }}"
                                        @dragover.prevent
                                        @drop.prevent="
                                            const fromIdx = members.indexOf(draggingId);
                                            const toIdx = members.indexOf({{ $member->id }});
                                            if (fromIdx !== -1 && toIdx !== -1 && fromIdx !== toIdx) {
                                                members.splice(fromIdx, 1);
                                                members.splice(toIdx, 0, draggingId);
                                                $action('{{ route('admin.about.team.reorder') }}', { include: ['members'] });
                                            }
                                            draggingId = null;
                                        "
                                        class="px-6 py-4 flex items-center gap-3 cursor-grab active:cursor-grabbing"
                                        :style="draggingId === {{ $member->id }} ? 'opacity:0.5;background-color:#f8fafc' : ''">

                                        {{-- Drag handle --}}
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" stroke-width="1.5" style="color: #cbd5e1;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                                        </svg>

                                        {{-- Photo / monogram --}}
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden flex items-center justify-center"
                                             style="{{ $member->photo_path ? '' : 'background-color: rgba(200,0,120,0.08); border: 1px solid rgba(200,0,120,0.2);' }}">
                                            @if ($member->photo_path)
                                                <img src="{{ vasset($member->photo_path) }}"
                                                     alt="{{ $member->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs font-bold" style="color: #c80078;">
                                                    {{ $member->initials() }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium leading-snug" style="color: #1e293b;">
                                                {{ $member->name }}
                                            </p>
                                            <p class="text-xs mt-0.5" style="color: #94a3b8;">
                                                {{ $member->title_fr }}
                                            </p>
                                        </div>

                                        {{-- Published badge --}}
                                        <div class="flex-shrink-0">
                                            @if ($member->is_published)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                      style="background-color: #dcfce7; color: #16a34a;">
                                                    Publié
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                      style="background-color: #f1f5f9; color: #94a3b8;">
                                                    Brouillon
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-1 flex-shrink-0">
                                            <a href="{{ route('admin.about.team.edit', $member) }}"
                                               class="p-1.5 rounded-lg transition-colors"
                                               style="color: #64748b;"
                                               title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                </svg>
                                            </a>
                                            <button
                                                @click="if (confirm('Supprimer ce membre ?')) $action.delete('{{ route('admin.about.team.destroy', $member) }}')"
                                                class="p-1.5 rounded-lg transition-colors"
                                                style="color: #ef4444;"
                                                title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    @endfragment

                </div>
            </div>

            {{-- Right: Add member form + sub-nav --}}
            <div class="space-y-5">

                {{-- Add form --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold mb-4" style="color: #143c64;">
                        Ajouter un membre
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Nom <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="name" x-name="name" type="text"
                                   placeholder="Ex: Amina Diallo"
                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="name" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre (FR) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_fr" x-name="title_fr" type="text"
                                   placeholder="Ex: Directrice Générale"
                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_fr" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                                Titre (EN) <span style="color: #ef4444;">*</span>
                            </label>
                            <input x-model="title_en" x-name="title_en" type="text"
                                   placeholder="Ex: Executive Director"
                                   class="w-full text-sm px-3 py-2 rounded-lg border focus:outline-none"
                                   style="border-color: #e2e8f0; color: #1e293b;">
                            <p x-message="title_en" class="text-xs mt-1" style="color: #ef4444;"></p>
                        </div>

                        <div class="flex items-center gap-2">
                            <input x-model="is_published" x-name="is_published" type="checkbox"
                                   id="is-published-new" class="rounded">
                            <label for="is-published-new" class="text-xs" style="color: #475569;">
                                Publier immédiatement
                            </label>
                        </div>

                        <button
                            @click="$action('{{ route('admin.about.team.store') }}')"
                            :disabled="$fetching()"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!$fetching()">Ajouter le membre</span>
                            <span x-show="$fetching()">Ajout en cours…</span>
                        </button>
                    </div>
                </div>

                {{-- About sub-nav --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold mb-3" style="color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                        Section À Propos
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.about.founder.edit') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Fondatrice
                        </a>
                        <a href="{{ route('admin.about.patron.edit') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Marraine
                        </a>
                        <a href="{{ route('admin.about.milestones.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors"
                           style="color: #475569;">
                            Jalons
                        </a>
                        <a href="{{ route('admin.about.team.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium"
                           style="color: #c80078; background-color: #c8007808;">
                            Équipe
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
