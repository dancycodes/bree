<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.sign_in') }} — {{ config('app.name') }}</title>
    @gale
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #002850;">

    <div class="w-full max-w-md px-6 py-10" x-data="{
        email: '',
        password: '',
        remember: false
    }">

        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <a href="{{ route('public.home') }}">
                <img src="{{ vasset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-20 w-auto">
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl px-8 py-10">
            <h1 class="text-2xl font-bold text-center mb-1" style="color: #143c64; font-family: 'Playfair Display', serif;">
                {{ __('auth.sign_in') }}
            </h1>
            <p class="text-center text-sm text-gray-500 mb-8">{{ config('app.name') }} — Administration</p>

            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg text-sm text-green-800 bg-green-50 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form @submit.prevent="$action('{{ route('admin.login.submit') }}')" x-sync>
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        {{ __('auth.email') }}
                    </label>
                    <input
                        id="email"
                        type="email"
                        x-name="email"
                        x-model="email"
                        autocomplete="email"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                        style="focus:ring-color: #c80078;"
                        placeholder="admin@breefondation.org"
                    >
                    <p x-message="email" class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        {{ __('auth.password_label') }}
                    </label>
                    <input
                        id="password"
                        type="password"
                        x-name="password"
                        x-model="password"
                        autocomplete="current-password"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                    <p x-message="password" class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" x-model="remember" x-name="remember" class="rounded border-gray-300">
                        {{ __('auth.remember_me') }}
                    </label>
                    <a href="{{ route('admin.password.request') }}"
                       class="text-sm font-medium transition"
                       style="color: #c80078;"
                       @mouseover="$el.style.opacity='0.8'"
                       @mouseout="$el.style.opacity='1'">
                        {{ __('auth.forgot_password') }}
                    </a>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-2.5 rounded-lg text-white font-semibold text-sm transition-all duration-150"
                    style="background-color: #c80078;"
                    @mouseover="$el.style.backgroundColor='#a8006a'"
                    @mouseout="$el.style.backgroundColor='#c80078'">
                    <span x-show="!$fetching()">{{ __('auth.sign_in_btn') }}</span>
                    <span x-show="$fetching()" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        {{ __('auth.signing_in') }}
                    </span>
                </button>
            </form>
        </div>

        <p class="text-center text-xs mt-6" style="color: rgba(255,255,255,0.5);">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
    </div>

</body>
</html>
