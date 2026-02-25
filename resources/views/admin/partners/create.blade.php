@extends('layouts.admin')

@section('title', 'Nouveau partenaire')
@section('page_title', 'Partenaires')
@section('breadcrumb', 'Partenaires › Nouveau')

@section('content')

    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('admin.partners.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold hover:opacity-80 transition-opacity"
               style="color: #c80078;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm p-8 space-y-6">
            @csrf

            @include('admin.partners._form', ['partner' => null])

            <div class="pt-2">
                <button type="submit"
                        class="px-6 py-3 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                        style="background-color: #c80078;">
                    Créer le partenaire
                </button>
            </div>

        </form>

    </div>

@endsection
