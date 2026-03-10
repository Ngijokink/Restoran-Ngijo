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
            Schema::create('orders', function (Blueprint $table) {

        $table->id('id_order');

        $table->unsignedBigInteger('user_id');

        $table->string('order_code');


        $table->string('status')->default('pending');

        $table->integer('total_price')->default(0);



        $table->timestamps();

        $table->foreign('user_id')
          ->references('id_user')
          ->on('users')
          ->onDelete('cascade');
});
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('table_orders');
        }
    };
