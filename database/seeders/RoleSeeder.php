<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create the three roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'public']);
    }
}