@extends('layouts.admin')

@section('title', 'Utilisateurs')
@section('page_title', 'Utilisateurs')
@section('breadcrumb', 'Utilisateurs')

@section('content')

    <div x-data="{ search: '' }">

        {{-- Header --}}
        <div class="mb-4 flex items-center justify-between gap-3">
            @can('users.create')
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold text-white flex-shrink-0"
                   style="background-color: #143c64;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvel utilisateur
                </a>
            @endcan
        </div>

        {{-- Search --}}
        <div class="mb-4 flex items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #94a3b8;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       x-model="search"
                       x-name="search"
                       x-sync="['search']"
                       @input.debounce.400ms="$action.post('{{ route('admin.users.index') }}', { include: ['search'] })"
                       placeholder="Rechercher par nom ou email…"
                       class="w-full pl-9 pr-3 py-2 rounded-xl text-sm"
                       style="border: 1px solid #e2e8f0; outline: none;">
            </div>
        </div>

        {{-- Users table --}}
        @fragment('users-list')
        <div id="users-list">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

                @if ($users->isEmpty())
                    <div class="py-16 text-center">
                        <p class="text-sm" style="color: #94a3b8;">Aucun utilisateur trouvé.</p>
                    </div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Utilisateur</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Rôles</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Dernière connexion</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Statut</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="border-color: #f8fafc;">
                            @foreach ($users as $user)
                                <tr class="hover:bg-slate-50 transition-colors">

                                    {{-- Avatar + name/email --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden"
                                                 style="background-color: rgba(20,60,100,0.1);">
                                                @if ($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-sm font-bold" style="color: #143c64;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium truncate" style="color: #1e293b;">{{ $user->name }}</p>
                                                <p class="text-xs truncate" style="color: #94a3b8;">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Roles --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse ($user->roles as $role)
                                                <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium"
                                                      style="background-color: rgba(20,60,100,0.08); color: #143c64;">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs" style="color: #94a3b8;">—</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    {{-- Last login --}}
                                    <td class="px-5 py-3.5 text-xs" style="color: #64748b;">
                                        {{ $user->last_login_at?->format('d/m/Y H:i') ?? '—' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-3.5">
                                        @if ($user->is_active)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background-color: rgba(200,0,120,0.08); color: #c80078;">
                                                <span class="block w-1.5 h-1.5 rounded-full" style="background-color: #c80078;"></span>
                                                Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background-color: #f8fafc; color: #94a3b8;">
                                                <span class="block w-1.5 h-1.5 rounded-full" style="background-color: #cbd5e1;"></span>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-5 py-3.5">
                                        <div x-data class="flex items-center justify-end gap-2">

                                            @if (Route::has('admin.users.edit'))
                                                @can('users.edit')
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold"
                                                       style="background-color: #f1f5f9; color: #475569;">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Modifier
                                                    </a>
                                                @endcan
                                            @endif

                                            @if ($user->id !== auth()->id())
                                                @if ($user->is_active)
                                                    <button @click="$action.post('{{ route('admin.users.disable', $user) }}', { include: [] })"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold"
                                                            style="background-color: #fffbeb; color: #92400e;">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                        </svg>
                                                        Désactiver
                                                    </button>
                                                @else
                                                    <button @click="$action.post('{{ route('admin.users.enable', $user) }}', { include: [] })"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold"
                                                            style="background-color: #ecfdf5; color: #065f46;">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Activer
                                                    </button>
                                                @endif

                                                <button @click="$action.delete('{{ route('admin.users.destroy', $user) }}', { include: [] })"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold"
                                                        style="background-color: #fef2f2; color: #dc2626;">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($users->hasPages())
                        <div class="px-5 py-4" style="border-top: 1px solid #f1f5f9;">
                            {{ $users->links() }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
        @endfragment

    </div>

@endsection
