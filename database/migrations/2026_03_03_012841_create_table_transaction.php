<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
<<<<<<< HEAD
            $table->unsignedBigInteger('id_orders');
            $table->foreign('id_orders')->references('id_order')->on('table_orders')->onDelete('cascade');
=======
            $table->id();
            $table->unsignedBigInteger('order_id');
>>>>>>> 52eff5d (fix: Users Model)
            $table->decimal('total', 10, 2);
            $table->string('method');
            $table->string('status')->default(  'pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id_order')->on('table_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
