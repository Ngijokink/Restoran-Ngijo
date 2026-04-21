<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PHPUnit\Metadata\Test;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Daftarkan seeder kamu di sini
        $this->call([
            SuperAdminAccount::class,
            TestingOnly::class,
            // Kamu bisa menambah seeder lain di sini nanti
        ]);
    }
}