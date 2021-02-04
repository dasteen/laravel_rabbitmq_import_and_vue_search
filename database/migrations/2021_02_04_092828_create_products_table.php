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

            $table->integer('external_id', false, true);
            $table->integer('category_id', false, true);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->string('currency', 5);

            $table->string('url', 1024)->nullable();
            $table->string('picture', 1024)->nullable();
            $table->string('vendor')->nullable();
            $table->string('sales_notes')->nullable();

            $table->integer('local_delivery_cost')->nullable();
            $table->boolean('available')->default(false);
            $table->boolean('delivery')->nullable();
            $table->boolean('store')->nullable();
            $table->boolean('pickup')->nullable();
            $table->boolean('manufacturer_warranty')->nullable();


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
