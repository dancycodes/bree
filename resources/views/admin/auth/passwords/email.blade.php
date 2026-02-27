<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.reset_password') }} — {{ config('app.name') }}</title>
    @gale
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #002850;">

    <div class="w-full max-w-md px-6 py-10" x-data="{ email: '' }">

        <div class="flex justify-center mb-8">
            <img src="{{ vasset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-20 w-auto">
        </div>

        <div class="bg-white rounded-2xl shadow-2xl px-8 py-10">
            <h1 class="text-2xl font-bold text-center mb-2" style="color: #143c64; font-family: 'Playfair Display', serif;">
                {{ __('auth.reset_password') }}
            </h1>
            <p class="text-center text-sm text-gray-500 mb-8">{{ __('auth.reset_password_hint') }}</p>

            <form @submit.prevent="$action('{{ route('admin.password.email') }}')" x-sync>
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('auth.email') }}</label>
                    <input type="email" x-name="email" x-model="email" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 transition"
                        placeholder="admin@breefondation.org">
                    <p x-message="email" class="mt-1 text-xs text-red-600"></p>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-lg text-white font-semibold text-sm transition"
                    style="background-color: #c80078;">
                    <span x-show="!$fetching()">{{ __('auth.send_reset_link') }}</span>
                    <span x-show="$fetching()">{{ __('auth.sending') }}...</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="text-sm transition" style="color: #c80078;">
                    &larr; {{ __('auth.back_to_login') }}
                </a>
            </div>
        </div>
    </div>

</body>
</html>
