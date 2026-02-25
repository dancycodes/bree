<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminUsersController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('users.view');

        $search = $request->state('search', '');

        $query = User::query()->with('roles')->orderBy('name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $users = $query->paginate(30);

        if ($request->isGale()) {
            return gale()->fragment('admin.users.index', 'users-list', compact('users'));
        }

        return gale()->view('admin.users.index', compact('users'), web: true);
    }

    public function create(): mixed
    {
        $this->authorize('users.create');

        $roles = Role::orderBy('name')->get();

        return gale()->view('admin.users.create', compact('roles'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('users.create');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
            'is_active' => 'nullable|in:1,0,true,false',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_active' => filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $user->syncRoles($request->input('roles', []));

        return gale()->redirect(route('admin.users.index'));
    }

    public function edit(User $user): mixed
    {
        $this->authorize('users.edit');

        $roles = Role::orderBy('name')->get();
        $userRoles = $user->roles->pluck('name')->toArray();

        return gale()->view('admin.users.edit', compact('user', 'roles', 'userRoles'), web: true);
    }

    public function update(Request $request, User $user): mixed
    {
        $this->authorize('users.edit');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
            'is_active' => 'nullable',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_active' => filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
        ]);

        if ($request->input('password')) {
            $user->update(['password' => $request->input('password')]);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $user->syncRoles($request->input('roles', []));

        return gale()->redirect(route('admin.users.index'));
    }

    public function disable(User $user): mixed
    {
        $this->authorize('users.disable');

        if ($user->id === auth()->id()) {
            return gale()->dispatch('toast', [
                'message' => 'Vous ne pouvez pas désactiver votre propre compte.',
                'type' => 'error',
            ]);
        }

        $user->update(['is_active' => false]);

        $users = User::query()->with('roles')->orderBy('name')->paginate(30);

        return gale()
            ->fragment('admin.users.index', 'users-list', compact('users'))
            ->dispatch('toast', ['message' => 'Utilisateur désactivé', 'type' => 'success']);
    }

    public function enable(User $user): mixed
    {
        $this->authorize('users.disable');

        $user->update(['is_active' => true]);

        $users = User::query()->with('roles')->orderBy('name')->paginate(30);

        return gale()
            ->fragment('admin.users.index', 'users-list', compact('users'))
            ->dispatch('toast', ['message' => 'Utilisateur activé', 'type' => 'success']);
    }

    public function destroy(User $user): mixed
    {
        $this->authorize('users.disable');

        if ($user->id === auth()->id()) {
            return gale()->dispatch('toast', [
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.',
                'type' => 'error',
            ]);
        }

        $user->delete();

        $users = User::query()->with('roles')->orderBy('name')->paginate(30);

        return gale()
            ->fragment('admin.users.index', 'users-list', compact('users'))
            ->dispatch('toast', ['message' => 'Utilisateur supprimé', 'type' => 'success']);
    }
}
