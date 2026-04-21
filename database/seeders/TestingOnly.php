<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingOnly extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    User::updateOrCreate(
        ['email' => 'feril@gmail.com'],
        [
            'name' => 'Feril',
            'password' => '12345678', // Biarkan cast 'hashed' di Model yang bekerja
            'role' => 'admin'
        ]
    );
}
}
