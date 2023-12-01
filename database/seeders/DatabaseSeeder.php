<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super.admin@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Merchant One',
            'email' => 'merchant@gmail.com'
        ]);

        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole($role);
    }
}
