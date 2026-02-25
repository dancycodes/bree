@extends('layouts.admin')

@section('title', 'Nouvel utilisateur')
@section('page_title', 'Nouvel utilisateur')
@section('breadcrumb', 'Utilisateurs › Nouvel utilisateur')

@section('content')

    <div x-data="{
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            is_active: true,
            roles: [],
            avatarPreview: null,
            toggleRole(role) {
                const idx = this.roles.indexOf(role);
                if (idx >= 0) {
                    this.roles.splice(idx, 1);
                } else {
                    this.roles.push(role);
                }
            }
        }">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main form --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Identity --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-5" style="color: #1e293b;">Informations</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #374151;">Nom complet</label>
                            <input type="text" x-model="name" x-name="name"
                                   class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                                   style="border: 1px solid #e2e8f0; outline: none;"
                                   placeholder="Jean Dupont">
                            <p x-message="name" class="mt-1 text-xs" style="color: #dc2626;"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #374151;">Adresse e-mail</label>
                            <input type="email" x-model="email" x-name="email"
                                   class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                                   style="border: 1px solid #e2e8f0; outline: none;"
                                   placeholder="jean@breefondation.org">
                            <p x-message="email" class="mt-1 text-xs" style="color: #dc2626;"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #374151;">Mot de passe</label>
                                <input type="password" x-model="password" x-name="password"
                                       class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Min. 8 caractères">
                                <p x-message="password" class="mt-1 text-xs" style="color: #dc2626;"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1.5" style="color: #374151;">Confirmer le mot de passe</label>
                                <input type="password" x-model="password_confirmation" x-name="password_confirmation"
                                       class="w-full px-3.5 py-2.5 rounded-xl text-sm"
                                       style="border: 1px solid #e2e8f0; outline: none;"
                                       placeholder="Répéter le mot de passe">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Roles --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Rôles</h3>

                    <div class="space-y-2">
                        @foreach ($roles as $role)
                            <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-colors hover:bg-slate-50"
                                   style="border: 1px solid #f1f5f9;">
                                <input type="checkbox"
                                       :checked="roles.includes('{{ $role->name }}')"
                                       @change="toggleRole('{{ $role->name }}')"
                                       class="w-4 h-4 rounded"
                                       style="accent-color: #c80078;">
                                <span class="text-sm font-medium" style="color: #1e293b;">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p x-message="roles" class="mt-2 text-xs" style="color: #dc2626;"></p>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                {{-- Avatar --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Avatar</h3>

                    <div class="flex flex-col items-center gap-3">
                        <div class="w-20 h-20 rounded-full overflow-hidden flex items-center justify-center"
                             style="background-color: rgba(20,60,100,0.1);">
                            <template x-if="avatarPreview">
                                <img :src="avatarPreview" alt="" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!avatarPreview">
                                <span class="text-2xl font-bold" style="color: #143c64;"
                                      x-text="name ? name[0].toUpperCase() : '?'"></span>
                            </template>
                        </div>

                        <label class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold"
                               style="background-color: #f1f5f9; color: #475569;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Choisir une photo
                            <input type="file" name="avatar" x-files accept="image/*"
                                   @change="avatarPreview = $files('avatar')?.length ? $filePreview('avatar', 0) : null"
                                   class="hidden">
                        </label>
                        <p x-message="avatar" class="text-xs" style="color: #dc2626;"></p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #e2e8f0;">
                    <h3 class="text-sm font-semibold mb-4" style="color: #1e293b;">Statut</h3>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" x-model="is_active" x-name="is_active"
                               class="w-4 h-4 rounded"
                               style="accent-color: #c80078;">
                        <span class="text-sm" style="color: #374151;">Compte actif</span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-2">
                    <button @click="$action('{{ route('admin.users.store') }}', { include: ['name','email','password','password_confirmation','is_active','roles'] })"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
                            style="background-color: #c80078;">
                        <span x-show="!$fetching()">Créer l'utilisateur</span>
                        <span x-show="$fetching()">Enregistrement…</span>
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold"
                       style="background-color: #f1f5f9; color: #475569;">
                        Annuler
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
