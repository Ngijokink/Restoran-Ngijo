<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
    Schema::create('payments', function (Blueprint $table) {

    $table->id('id_payment');

    $table->unsignedBigInteger('id_cart');

    $table->decimal('amount', 12, 2);

    $table->enum('method', ['cash', 'qris', 'transfer']);

    $table->enum('status', ['pending', 'paid', 'failed'])
          ->default('pending');

    $table->string('proof')->nullable();

    $table->timestamp('paid_at')->nullable();

    $table->timestamps();

    $table->foreign('id_cart')
          ->references('id_cart')
          ->on('carts')
          ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};