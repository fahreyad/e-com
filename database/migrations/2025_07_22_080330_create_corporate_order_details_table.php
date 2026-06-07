<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corporate_order_id')->nullable()->constrained('corporate_orders');
            $table->foreignId('product_id')->nullable()->constrained('package_products');
            $table->string('value')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('quantity')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporate_order_details');
    }
}
