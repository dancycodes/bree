<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('roles.view');

        $roles = Role::withCount('users', 'permissions')->orderBy('name')->get();

        return gale()->view('admin.roles.index', compact('roles'), web: true);
    }

    public function create(): mixed
    {
        $this->authorize('roles.create');

        $allPermissions = Permission::orderBy('name')->get();
        $permissionGroups = $this->buildGroups($allPermissions);

        return gale()->view('admin.roles.create', compact('permissionGroups'), web: true);
    }

    public function edit(Role $role): mixed
    {
        $this->authorize('roles.edit');

        $allPermissions = Permission::orderBy('name')->get();
        $permissionGroups = $this->buildGroups($allPermissions);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return gale()->view('admin.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'), web: true);
    }

    public function update(Request $request, Role $role): mixed
    {
        $this->authorize('roles.edit');

        if ($role->name === 'Super Admin') {
            return gale()->dispatch('toast', [
                'message' => 'Les permissions du rôle Super Admin ne peuvent pas être modifiées.',
                'type' => 'error',
            ]);
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->syncPermissions($request->input('permissions', []));

        return gale()->dispatch('toast', ['message' => 'Permissions mises à jour', 'type' => 'success']);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('roles.create');

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);
        $role->syncPermissions($request->input('permissions', []));

        return gale()->redirect(route('admin.roles.index'));
    }

    public function destroy(Role $role): mixed
    {
        $this->authorize('roles.delete');

        if ($role->name === 'Super Admin') {
            return gale()->dispatch('toast', [
                'message' => 'Le rôle Super Admin ne peut pas être supprimé.',
                'type' => 'error',
            ]);
        }

        $userCount = $role->users()->count();

        if ($userCount > 0) {
            return gale()->dispatch('toast', [
                'message' => "Ce rôle est assigné à {$userCount} utilisateur".($userCount > 1 ? 's' : '').'. Veuillez le réassigner avant de supprimer.',
                'type' => 'error',
            ]);
        }

        $role->delete();

        $roles = Role::withCount('users', 'permissions')->orderBy('name')->get();

        return gale()
            ->fragment('admin.roles.index', 'roles-list', compact('roles'))
            ->dispatch('toast', ['message' => 'Rôle supprimé', 'type' => 'success']);
    }

    /** @param \Illuminate\Support\Collection<int, Permission> $permissions */
    private function buildGroups(\Illuminate\Support\Collection $permissions): array
    {
        $map = [
            'À propos' => ['about.view', 'about.edit'],
            'Activité' => ['activity.view'],
            'Candidatures' => ['applications.view', 'applications.edit'],
            'Contenu' => ['content.view', 'content.edit'],
            'Dons' => ['donations.view', 'donations.edit', 'donations.export'],
            'Événements' => ['events.view', 'events.create', 'events.edit', 'events.delete'],
            'Galerie' => ['gallery.view', 'gallery.create', 'gallery.edit', 'gallery.delete'],
            'Messages' => ['messages.view', 'messages.delete'],
            'Actualités' => ['news.view', 'news.create', 'news.edit', 'news.delete'],
            'Newsletter' => ['newsletter.view', 'newsletter.export'],
            'Partenaires' => ['partners.view', 'partners.create', 'partners.edit', 'partners.delete'],
            'Programmes' => ['programs.view', 'programs.edit'],
            'Rôles' => ['roles.view', 'roles.create', 'roles.edit', 'roles.delete'],
            'Paramètres' => ['settings.manage'],
            'Statistiques' => ['stats.view', 'stats.edit'],
            'Utilisateurs' => ['users.view', 'users.create', 'users.edit', 'users.disable'],
        ];

        $actionLabels = [
            'view' => 'Voir',
            'create' => 'Créer',
            'edit' => 'Modifier',
            'delete' => 'Supprimer',
            'export' => 'Exporter',
            'manage' => 'Gérer',
            'disable' => 'Désactiver',
        ];

        $groups = [];
        $permNames = $permissions->pluck('name')->flip();

        foreach ($map as $group => $names) {
            $items = [];
            foreach ($names as $name) {
                if ($permNames->has($name)) {
                    $action = explode('.', $name)[1] ?? $name;
                    $items[] = [
                        'name' => $name,
                        'label' => $actionLabels[$action] ?? $action,
                    ];
                }
            }
            if (! empty($items)) {
                $groups[$group] = $items;
            }
        }

        return $groups;
    }
}
