<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the specific roles for the office hierarchy
        Role::create(['name' => 'Incubation Officer']);
        Role::create(['name' => 'Intern']);
        Role::create(['name' => 'Assistant']);
        Role::create(['name' => 'Student']);
    }
}