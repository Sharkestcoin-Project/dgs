<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesStructure = [
            'Admin' => [
                'dashboard' => 'r',
                'plans' => 'c,r,u,d',
                'payouts' => 'r',
                'payout-methods' => 'c,r,u,d',
                'orders' => 'r,u,d',
                'users' => 'c,r,u,d',
                'products' => 'r',
                'user-plans' => 'r',
                'product-orders' => 'r',
                // Common
                'media' => 'c,r,u,d',
                'reviews' => 'c,r,u,d',
                'blog' => 'c,r,u,d',
                'pages' => 'c,r,u,d',
                'website' => 'r,u',
                // Settings
                'settings' => 'r',
                'languages' => 'c,r,u,d',
                'menus' => 'c,r,u,d',
                'seo' => 'c,r,u,d',
                'system-settings' => 'r,u',
                'cron-settings' => 'r,u',
                'taxes' => 'c,r,u,d',
                'currencies' => 'c,r,u,d',
                'gateways' => 'c,r,u,d',
                'roles' => 'c,r,u,d',
                'roles-assign' => 'r,c',
            ],
            'Manager' => [
                'dashboard' => 'r',
                'plans' => 'c,r,u,d',
                'payouts' => 'r,u',
                'payout-methods' => 'c,r,u,d',
                'orders' => 'c,r,u,d',
                'users' => 'c,r,u,d',
                'product-orders' => 'c,r,u,d',
                // Common
                'media' => 'c,r,u,d',
                'reviews' => 'c,r,u,d',
                'blog' => 'c,r,u,d',
                'pages' => 'c,r,u,d',
                'website' => 'r,u',
            ]
        ];

        foreach ($rolesStructure as $key => $modules) {
            // Create a new role
            $role = Role::firstOrCreate([
                'name' => $key,
                'guard_name' => 'web'
            ]);
            $permissions = [];

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $this->permissionMap()->get($perm);

                    $permissions[] = Permission::firstOrCreate([
                        'name' => $module . '-' . $permissionValue,
                        'guard_name' => 'web'
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            if (true) {
                $this->command->info("Creating '{$key}' user");
                // Create default user for each role
                $user = User::create([
                    'name' => ucwords(str_replace('_', ' ', $key)),
                    'email' => str($key)->remove(' ')->lower().'@'.str($key)->remove(' ')->lower().'.com',
                    'username' => str($key)->remove(' ')->lower(),
                    'password' => bcrypt('rootadmin'),
                    'avatar' => 'https://avatars.dicebear.com/api/adventurer/'.str($key)->slug().'.svg',
                    'email_verified_at' => now(),
                    'role' => 'admin'
                ]);
                $user->assignRole($role);
            }
        }
    }

    private function permissionMap(){
        return collect([
            'c' => 'create',
            'r' => 'read',
            'u' => 'update',
            'd' => 'delete'
        ]);
    }
}
