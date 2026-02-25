@extends('layouts.public')

@section('title', $album->title() . ' — ' . config('app.name'))

@section('content')
    <div class="py-20 text-center max-w-7xl mx-auto px-4">
        <p style="color: #94a3b8;">Album bientôt disponible.</p>
        <a href="{{ route('public.gallery') }}" class="text-sm font-semibold mt-4 inline-block" style="color: #c80078;">← Galerie</a>
    </div>
@endsection
