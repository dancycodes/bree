<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin(): mixed
    {
        if (Auth::check()) {
            return gale()->redirect('/admin/dashboard');
        }

        return gale()->view('admin.auth.login', [], web: true);
    }

    public function login(LoginRequest $request): mixed
    {
        $validated = $request->validateState([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = (bool) $request->state('remember', false);

        if (! Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
            return gale()->messages([
                'email' => __('auth.failed'),
            ]);
        }

        if (! Auth::user()->is_active) {
            Auth::logout();

            return gale()->messages([
                'email' => __('auth.inactive'),
            ]);
        }

        Auth::user()->update(['last_login_at' => now()]);

        $request->session()->regenerate();

        return gale()->redirect('/admin/dashboard');
    }

    public function logout(Request $request): mixed
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return gale()->redirect('/admin/login');
    }

    public function showForgotPassword(): mixed
    {
        return gale()->view('admin.auth.passwords.email', [], web: true);
    }

    public function sendResetLink(Request $request): mixed
    {
        $validated = $request->validateState([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(['email' => $validated['email']]);

        return gale()->dispatch('toast', [
            'message' => __('passwords.sent'),
            'type' => 'success',
        ]);
    }

    public function showResetPassword(Request $request, string $token): mixed
    {
        return gale()->view('admin.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->get('email', ''),
        ], web: true);
    }

    public function resetPassword(Request $request): mixed
    {
        $validated = $request->validateState([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($validated, function ($user, $password) {
            $user->forceFill(['password' => bcrypt($password)])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return gale()->redirect('/admin/login')
                ->with('success', __('passwords.reset'));
        }

        return gale()->messages(['email' => __($status)]);
    }
}
