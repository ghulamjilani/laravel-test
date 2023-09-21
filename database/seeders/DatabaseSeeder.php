<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'      => 'Super Admin',
            'email'     => 'super.admin@admin.com',
            'role_id'   => 1,
        ]);

        User::factory(10)->create();
    }
}
