<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('order_id');

    $table->foreign('order_id')
          ->references('id_order')
          ->on('table_orders')
          ->onDelete('cascade');

    $table->decimal('amount', 12, 2);

    $table->enum('method', ['cash', 'qris', 'transfer']);

    $table->enum('status', ['pending', 'paid', 'failed'])
          ->default('pending');

    $table->string('proof')->nullable();

    $table->timestamp('paid_at')->nullable();

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};