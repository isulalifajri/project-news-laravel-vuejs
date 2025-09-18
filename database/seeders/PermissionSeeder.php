<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
        ];

        $articles = [
            'articles.view',
            'articles.publish',
        ];

        $permissions = array_merge($users, $articles);

        foreach ($permissions as $perm) {
            [$group] = explode('.', $perm, 2);   // prefix sebelum titik jadi group
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'backend'],
                ['groups' => $group]
            );
        }
    }
}
