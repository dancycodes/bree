@extends('layouts.admin')

@section('title', 'Nouveau rôle')
@section('page_title', 'Nouveau rôle')
@section('breadcrumb', 'Rôles › Nouveau rôle')

@section('content')

    <div x-data="{
            name: '',
            permissions: [],
            togglePerm(p) {
                const idx = this.permissions.indexOf(p);
                if (idx >= 0) { this.permissions.splice(idx, 1); }
                else { this.permissions.push(p); }
            },
            toggleGroup(names) {
                const allSelected = names.every(n => this.permissions.includes(n));
                if (allSelected) {
                    this.permissions = this.permissions.filter(p => !names.includes(p));
                } else {
                    names.forEach(n => { if (!this.permissions.includes(n)) this.permissions.push(n); });
                }
            }
        }">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Permission groups (2/3) --}}
            <div class="lg:col-span-2 space-y-4">

                @foreach ($permissionGroups as $group => $items)
                    @php $names = array_column($items, 'name'); @endphp
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">
                        <div class="px-5 py-3.5 flex items-center justify-between" style="border-bottom: 1px solid #f8fafc;">
                            <p class="text-xs font-semibold uppercase tracking-wide" style="color: #64748b;">{{ $group }}</p>
                            <button @click="toggleGroup({{ Js::from($names) }})"
                                    class="text-xs font-medium transition-colors"
                                    :style="{{ Js::from($names) }}.every(n => permissions.includes(n)) ? 'color: #dc2626;' : 'color: #143c64;'"
                                    x-text="{{ Js::from($names) }}.every(n => permissions.includes(n)) ? 'Tout désélectionner' : 'Tout sélectionner'">
                            </button>
                        </div>
                        <div class="px-5 py-3 grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach ($items as $item)
                                <label class="flex items-center gap-2 cursor-pointer py-1">
                                    <input type="checkbox"
                                           :checked="permissions.includes('{{ $item['name'] }}')"
                                           @change="togglePerm('{{ $item['name'] }}')"
                                           class="w-4 h-4 rounded flex-shrink-0"
                                           style="accent-color: #c80078;">
                                    <span class="text-sm" style="color: #374151;">{{ $item['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                {{-- Role name --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Nom du rôle</h3>
                    <input type="text" x-model="name" x-name="name"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                           style="border: 1px solid #e2e8f0; outline: none;"
                           placeholder="Ex: Rédacteur">
                    <p x-message="name" class="mt-1 text-xs" style="color: #dc2626;"></p>
                </div>

                {{-- Selected count --}}
                <div class="bg-white rounded-2xl shadow-sm p-5" style="border: 1px solid #e2e8f0;">
                    <div class="text-center">
                        <p class="text-3xl font-bold" style="color: #c80078;" x-text="permissions.length"></p>
                        <p class="text-xs mt-1" style="color: #94a3b8;">permission<span x-show="permissions.length !== 1">s</span> sélectionnée<span x-show="permissions.length !== 1">s</span></p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-2">
                    <button @click="$action('{{ route('admin.roles.store') }}', { include: ['name', 'permissions'] })"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                            style="background-color: #c80078;">
                        <span x-show="!$fetching()">Créer le rôle</span>
                        <span x-show="$fetching()">Enregistrement…</span>
                    </button>
                    <a href="{{ route('admin.roles.index') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                       style="background-color: #f1f5f9; color: #475569;">
                        Annuler
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
