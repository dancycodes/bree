@extends('layouts.admin')

@section('title', 'Abonnés Newsletter')
@section('page_title', 'Abonnés Newsletter')
@section('breadcrumb', 'Newsletter')

@section('content')

    @fragment('subscribers-list')
    <div id="subscribers-list">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <p class="text-sm" style="color: #64748b;">
                    <span class="font-semibold" style="color: #1e293b;">{{ $activeCount }}</span>
                    abonné{{ $activeCount !== 1 ? 's' : '' }} actif{{ $activeCount !== 1 ? 's' : '' }}
                    <span class="mx-1" style="color: #cbd5e1;">·</span>
                    {{ $totalCount }} au total
                </p>
            </div>

            @can('newsletter.export')
                <a href="{{ route('admin.newsletter.export') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold text-white"
                   style="background-color: #143c64;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exporter CSV
                </a>
            @endcan
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden" style="border: 1px solid #e2e8f0;">

            @if ($subscribers->isEmpty())
                <div class="py-16 text-center">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm" style="color: #94a3b8;">Aucun abonné pour le moment.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Langue</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Inscrit le</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide" style="color: #94a3b8;">Statut</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #f8fafc;">
                        @foreach ($subscribers as $subscriber)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5 font-medium" style="color: #1e293b;">
                                    {{ $subscriber->email }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium"
                                          style="background-color: #f1f5f9; color: #475569;">
                                        {{ strtoupper($subscriber->locale) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5" style="color: #64748b;">
                                    {{ ($subscriber->subscribed_at ?? $subscriber->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if ($subscriber->status === 'active')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                              style="background-color: rgba(200,0,120,0.08); color: #c80078;">
                                            <span class="block w-1.5 h-1.5 rounded-full" style="background-color: #c80078;"></span>
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                              style="background-color: #f8fafc; color: #94a3b8;">
                                            <span class="block w-1.5 h-1.5 rounded-full" style="background-color: #cbd5e1;"></span>
                                            Désabonné
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    @if ($subscriber->status === 'active')
                                        <div x-data>
                                            <button @click="$action.delete('{{ route('admin.newsletter.destroy', $subscriber) }}', { include: [] })"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors"
                                                    style="background-color: #fef2f2; color: #dc2626;">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                                Désactiver
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($subscribers->hasPages())
                    <div class="px-5 py-4" style="border-top: 1px solid #f1f5f9;">
                        {{ $subscribers->links() }}
                    </div>
                @endif
            @endif

        </div>

    </div>
    @endfragment

@endsection
