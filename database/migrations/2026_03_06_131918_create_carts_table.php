<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('carts', function (Blueprint $table) {
    $table->id('id_cart');

    $table->unsignedBigInteger('id_order')->nullable();

    $table->unsignedBigInteger('user_id');

    $table->decimal('total_price',12,2)->default(0);

    $table->timestamps();

    $table->foreign('id_order')
          ->references('id_order')
          ->on('orders')
          ->onDelete('cascade');

    $table->foreign('user_id')
          ->references('id_user')
          ->on('users')
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};