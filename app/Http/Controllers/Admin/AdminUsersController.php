<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
