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
            Schema::create('table_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('id_order')->primary();
                $table->unsignedBigInteger('user_id');
                $table->integer('total_price');
                $table->string('status');
                $table->string('order_code');
                $table->dateTime('paid_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
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
