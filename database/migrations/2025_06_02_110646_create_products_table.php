<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('value')->nullable();
            $table->decimal('regular_price', 14)->nullable();
            $table->decimal('sale_price', 14)->nullable();
            $table->string('image')->nullable();
            $table->json('gallery_image')->nullable();
            $table->unsignedTinyInteger('is_variation')->nullable();
            $table->unsignedTinyInteger('is_best_sale')->nullable();
            $table->unsignedTinyInteger('is_hot_sale')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
