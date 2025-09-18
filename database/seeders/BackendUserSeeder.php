<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BackendUser;

class BackendUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = BackendUser::firstOrCreate(
            ['email' => 'backend@example.com'],
            ['name' => 'Master Backend', 'password' => bcrypt('password')]
        );

        $user->syncRoles(['super-admin']); // beri role
    }
}
