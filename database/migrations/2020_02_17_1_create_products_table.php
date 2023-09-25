<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('price');
            $table->string('name');
            $table->string('capacity_label')->nullable();
            $table->string('quantity_per_package')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('unit_price')->nullable();
            $table->integer('points')->nullable();
            $table->string('image')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('suggested_quantity')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('action')->default(false);
            $table->float('charge')->default(0.00);
            $table->decimal('weight', 10, 2);
            $table->decimal('unit_factor', 10, 2)->nullable();
            $table->boolean('kit')->default(false);
            $table->string('material')->nullable();
            $table->boolean('polarized')->default(false);
            $table->string('price_table')->nullable();
            $table->string('order_type')->nullable();
            $table->string('segment')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('group_konnect')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('flavor')->nullable();
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
};