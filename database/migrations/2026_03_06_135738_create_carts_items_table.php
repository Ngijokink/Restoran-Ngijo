<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('cart_items', function (Blueprint $table) {

        $table->id('id_cart_item');

        $table->unsignedBigInteger('id_cart');
        $table->unsignedBigInteger('id_menu');

        $table->integer('qty');

        $table->decimal('price',12,2);
        $table->decimal('subtotal',12,2);

        $table->timestamps();

        $table->foreign('id_cart')
            ->references('id_cart')
            ->on('carts')
            ->onDelete('cascade');

        $table->foreign('id_menu')
            ->references('id_menu')
            ->on('table_menus')
            ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};