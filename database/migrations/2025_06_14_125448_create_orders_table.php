<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->longText('note')->nullable();
            $table->decimal('subtotal_amount', 14)->nullable();
            $table->decimal('delivery_amount', 14)->nullable();
            $table->decimal('total_amount', 14)->nullable();
            $table->string('delivery_method')->nullable();
            $table->string('payment_method')->nullable();
            $table->unsignedTinyInteger('status')->nullable();
            $table->string('order_number')->nullable()->unique();
            $table->date('order_date')->nullable();
            $table->date('processing_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('cancelled_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
