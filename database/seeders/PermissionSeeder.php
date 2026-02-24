<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * All granular permissions — every admin action maps to one.
     *
     * @var array<string, list<string>>
     */
    private array $permissionGroups = [
        'news' => ['view', 'create', 'edit', 'delete'],
        'events' => ['view', 'create', 'edit', 'delete'],
        'gallery' => ['view', 'create', 'edit', 'delete'],
        'programs' => ['view', 'edit'],
        'partners' => ['view', 'create', 'edit', 'delete'],
        'donations' => ['view', 'edit', 'export'],
        'applications' => ['view', 'edit'],
        'newsletter' => ['view', 'export'],
        'messages' => ['view', 'delete'],
        'users' => ['view', 'create', 'edit', 'disable'],
        'roles' => ['view', 'create', 'edit', 'delete'],
        'settings' => ['manage'],
        'content' => ['view', 'edit'],
        'stats' => ['view', 'edit'],
        'activity' => ['view'],
    ];

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all permissions
        foreach ($this->permissionGroups as $resource => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$resource}.{$action}", 'guard_name' => 'web']);
            }
        }

        // Create Super Admin role with ALL permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Assign Super Admin role to the seeded admin user
        $admin = User::where('email', 'admin@breefondation.org')->first();
        if ($admin) {
            $admin->assignRole($superAdmin);
        }
    }
}
