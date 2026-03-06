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
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('menu_id');

            $table->integer('qty');
            $table->integer('price');
            $table->integer('subtotal');

            $table->timestamps();

            $table->foreign('cart_id')
                  ->references('id_cart')
                  ->on('carts')
                  ->onDelete('cascade');

            $table->foreign('menu_id')
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