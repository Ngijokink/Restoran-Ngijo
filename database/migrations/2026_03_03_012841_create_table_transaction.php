<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // primary key

            $table->unsignedBigInteger('order_id');

            $table->decimal('total', 10, 2);
            $table->string('method');
            $table->string('status')->default('pending');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id_order')
                  ->on('table_orders')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};