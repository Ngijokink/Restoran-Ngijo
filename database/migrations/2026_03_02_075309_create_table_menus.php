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

        $table->unsignedBigInteger('category_id');

        $table->string('name');

        $table->decimal('price',12,2);

        $table->integer('stock');

        $table->boolean('is_available')->default(true);

        $table->string('image')->nullable();

        $table->timestamps();

        $table->foreign('category_id')
            ->references('id_category')
            ->on('table_categories')
            ->onDelete('cascade');
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
