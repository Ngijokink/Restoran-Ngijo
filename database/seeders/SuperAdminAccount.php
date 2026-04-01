<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    User::updateOrCreate(
        ['email' => 'agus@gmail.com'],
        [
            'name' => 'Agus Bahlil',
            'password' => 'agusadmin123', // Biarkan cast 'hashed' di Model yang bekerja
            'role' => 'superadmin'
        ]
    );
}
}
