<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
class BasicAdminSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        $permissions = [
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',
            'mobil list',
            'mobil create',
            'mobil edit',
            'mobil delete',
            'sewa list',
            'sewa create',
            'sewa edit',
            'sewa delete',
            'sewa updateselesai',
            'sopir list',
            'sopir create',
            'sopir edit',
            'sopir delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('permission list');
        $role1->givePermissionTo('role list');
        $role1->givePermissionTo('user list');
        $role1->givePermissionTo('mobil list');
        $role1->givePermissionTo('mobil create');
        $role1->givePermissionTo('mobil edit');
        $role1->givePermissionTo('mobil delete');
        $role1->givePermissionTo('sewa list');
        $role1->givePermissionTo('sewa create');
        $role1->givePermissionTo('sewa edit');
        $role1->givePermissionTo('sewa delete');
        $role1->givePermissionTo('sewa updateselesai');
        $role1->givePermissionTo('sopir list');
        $role1->givePermissionTo('sopir create');
        $role1->givePermissionTo('sopir edit');
        $role1->givePermissionTo('sopir delete');

        $role2 = Role::create(['name' => 'writer']);
        $role2->givePermissionTo('permission list');
        $role2->givePermissionTo('role list');
        $role2->givePermissionTo('user list');
        $role2->givePermissionTo('mobil list');
        $role2->givePermissionTo('sewa list');
        $role2->givePermissionTo('sewa create');
        $role2->givePermissionTo('sewa edit');
        $role2->givePermissionTo('sewa delete');
        $role2->givePermissionTo('sopir list');
        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
        ]);
        $user->assignRole($role3);
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
        ]);
        $user->assignRole($role1);
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'writer@gmail.com',
        ]);
        $user->assignRole($role2);
    }
}
