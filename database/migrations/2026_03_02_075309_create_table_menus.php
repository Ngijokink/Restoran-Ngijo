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
        Schema::create('table_menus', function (Blueprint $table) {
            $table->id('id_menu');
            $table->id('category_id');
            $table->string('menu');
            $table->integer('price');
            $table->integer('stock');
            $table->enum('is_avaliable',['ada','kosong']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_menus');
    }
};
