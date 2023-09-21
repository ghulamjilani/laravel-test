<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Model
use App\Models\Role;


class addRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles to be seeded
        $roles = ['Super Admin', 'Admin', 'B2C Customer', 'B2B Customer'];

        // Check if each role already exists before creating it
        foreach ($roles as $roleName) {
            $existingRole = Role::where('role', $roleName)->count();

            if ($existingRole < 1) {
                Role::create(['role' => $roleName]);
            }
        }
    }
}