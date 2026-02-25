@props([
    'title' => config('app.name'),
    'description' => '',
    'image' => '',
    'url' => '',
])

@php
    $image = $image ?: asset('images/logo.png');
    $url   = $url   ?: url()->current();
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
