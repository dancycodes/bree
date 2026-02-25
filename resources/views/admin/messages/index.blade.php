@extends('layouts.admin')

@section('title', 'Messages de contact')
@section('page_title', 'Messages de contact')
@section('breadcrumb', 'Messages')

@section('content')

    <div x-data class="flex gap-6 items-start">

        {{-- ── Left: Messages List ── --}}
        @fragment('messages-list')
        <div id="messages-list" class="flex-1 min-w-0">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm" style="color: #64748b;">
                    {{ $messages->total() }} message{{ $messages->total() !== 1 ? 's' : '' }}
                    @if ($unreadCount > 0)
                        <span class="ml-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold"
                              style="background-color: rgba(200,0,120,0.1); color: #c80078;">
                            {{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

                @if ($messages->isEmpty())
                    <div class="py-16 text-center">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm" style="color: #94a3b8;">Aucun message pour le moment.</p>
                    </div>
                @else
                    <div class="divide-y" style="border-color: #f1f5f9;">
                        @foreach ($messages as $msg)
                            <div class="flex items-start gap-4 px-5 py-4 cursor-pointer transition-colors hover:bg-slate-50"
                                 @click="$action.post('{{ route('admin.messages.show', $msg) }}', { include: [] })">

                                {{-- Unread dot --}}
                                <div class="flex-shrink-0 mt-1.5">
                                    @if ($msg->status === 'new')
                                        <span class="block w-2 h-2 rounded-full" style="background-color: #c80078;"></span>
                                    @else
                                        <span class="block w-2 h-2 rounded-full opacity-0"></span>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-baseline justify-between gap-2">
                                        <p class="text-sm truncate {{ $msg->status === 'new' ? 'font-bold' : 'font-medium' }}"
                                           style="color: {{ $msg->status === 'new' ? '#1e293b' : '#475569' }};">
                                            {{ $msg->name }}
                                        </p>
                                        <time class="text-xs flex-shrink-0" style="color: #94a3b8;">
                                            {{ $msg->created_at->format('d/m/Y') }}
                                        </time>
                                    </div>
                                    <p class="text-xs truncate mt-0.5 {{ $msg->status === 'new' ? 'font-semibold' : '' }}"
                                       style="color: {{ $msg->status === 'new' ? '#374151' : '#64748b' }};">
                                        {{ $msg->subject }}
                                    </p>
                                    <p class="text-xs truncate mt-0.5" style="color: #94a3b8;">
                                        {{ Str::limit($msg->message, 70) }}
                                    </p>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    @if ($messages->hasPages())
                        <div class="px-5 py-4" style="border-top: 1px solid #f1f5f9;">
                            {{ $messages->links() }}
                        </div>
                    @endif
                @endif

            </div>

        </div>
        @endfragment

        {{-- ── Right: Message Detail Panel (server-driven visibility) ── --}}
        @fragment('message-detail')
        @php $showPanel = isset($message) && $message; @endphp
        <div id="message-detail"
             class="w-96 flex-shrink-0 sticky top-6"
             style="{{ $showPanel ? '' : 'display: none;' }}">

            @if ($showPanel)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

                    {{-- Panel Header --}}
                    <div class="px-6 py-4" style="border-bottom: 1px solid #f1f5f9;">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="font-semibold text-sm truncate" style="color: #1e293b;">{{ $message->name }}</p>
                                <p class="text-xs mt-0.5" style="color: #94a3b8;">{{ $message->email }}</p>
                            </div>
                            <time class="text-xs flex-shrink-0 mt-0.5" style="color: #94a3b8;">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </time>
                        </div>
                        <p class="mt-3 text-sm font-semibold" style="color: #143c64;">{{ $message->subject }}</p>
                    </div>

                    {{-- Message Body --}}
                    <div class="px-6 py-5">
                        <p class="text-sm leading-relaxed whitespace-pre-line" style="color: #475569;">{{ $message->message }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="px-6 py-4 flex items-center gap-3" style="border-top: 1px solid #f1f5f9;">

                        <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold text-white"
                           style="background-color: #143c64;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Répondre
                        </a>

                        @can('messages.delete')
                            <button @click="$action.delete('{{ route('admin.messages.destroy', $message) }}', { include: [] })"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold"
                                    style="background-color: #fef2f2; color: #dc2626;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        @endcan

                    </div>

                </div>
            @endif

        </div>
        @endfragment

    </div>

@endsection
