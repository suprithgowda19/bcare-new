<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'System Admin',
            'email'     => 'admin@gmail.com',
            'phone'     => '9999999999',
            'password'  => Hash::make('admin@123'), 
            'status'    => 'active',
            'email_verified_at' => now(),
        ]);

        // If you are using Spatie Permissions, assign the role here:
         $admin->assignRole('admin');
    }
}