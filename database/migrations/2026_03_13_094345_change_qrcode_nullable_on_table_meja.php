<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migration ini tidak diperlukan lagi karena qr_code sudah nullable di migration awal
    }

    public function down(): void
    {
        // Tidak ada yang di-rollback
    }
};
