<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super-admin',
            'editor',
            'viewer',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'backend']);
        }

        // Assign permission ke role tertentu
        $editor = Role::findByName('editor', 'backend');
        $editor->givePermissionTo([
            'articles.view',
            'articles.publish',
        ]);

        $viewer = Role::findByName('viewer', 'backend');
        $viewer->givePermissionTo([
            'users.view',
            'articles.view',
        ]);
    }
}
