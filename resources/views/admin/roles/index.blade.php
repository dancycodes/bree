@extends('layouts.admin')

@section('title', 'Rôles')
@section('page_title', 'Rôles')
@section('breadcrumb', 'Rôles')

@section('content')

    <div class="space-y-4">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <p class="text-sm" style="color: #64748b;">
                {{ $roles->count() }} rôle{{ $roles->count() !== 1 ? 's' : '' }}
            </p>
            @can('roles.create')
                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold text-white"
                   style="background-color: #143c64;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouveau rôle
                </a>
            @endcan
        </div>

        {{-- Roles list --}}
        @fragment('roles-list')
        <div id="roles-list">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($roles as $role)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

                        {{-- Card header --}}
                        <div class="px-5 py-4" style="border-bottom: 1px solid #f1f5f9;">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    @if ($role->name === 'Super Admin')
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                             style="background-color: rgba(200,0,120,0.1);">
                                            <svg class="w-4 h-4" fill="none" stroke="#c80078" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                             style="background-color: rgba(20,60,100,0.08);">
                                            <svg class="w-4 h-4" fill="none" stroke="#143c64" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-sm" style="color: #1e293b;">{{ $role->name }}</p>
                                        @if ($role->name === 'Super Admin')
                                            <p class="text-xs" style="color: #94a3b8;">Lecture seule</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($role->name !== 'Super Admin')
                                    <div class="flex items-center gap-1">
                                        @can('roles.edit')
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                               class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors hover:bg-blue-50"
                                               style="color: #143c64;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('roles.delete')
                                            <div x-data>
                                                <button @click="$action.delete('{{ route('admin.roles.destroy', $role) }}', { include: [] })"
                                                        class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors hover:bg-red-50"
                                                        style="color: #dc2626;">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endcan
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="px-5 py-3 flex items-center gap-4">
                            <div class="text-center">
                                <p class="text-lg font-bold" style="color: #1e293b;">{{ $role->permissions_count }}</p>
                                <p class="text-xs" style="color: #94a3b8;">permission{{ $role->permissions_count !== 1 ? 's' : '' }}</p>
                            </div>
                            <div class="w-px h-8" style="background-color: #f1f5f9;"></div>
                            <div class="text-center">
                                <p class="text-lg font-bold" style="color: #1e293b;">{{ $role->users_count }}</p>
                                <p class="text-xs" style="color: #94a3b8;">utilisateur{{ $role->users_count !== 1 ? 's' : '' }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        @endfragment

    </div>

@endsection
