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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('client_id')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->decimal('items_subtotal', 8, 2)->nullable();
            $table->decimal('tax_rate', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->decimal('total_products', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('shipping', 8, 2)->nullable();
            $table->string('customer_email')->nullable();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_address_line1')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_address_city')->nullable();
            $table->string('shipping_address_region')->nullable();
            $table->string('shipping_address_zipcode')->nullable();
            $table->string('shipping_address_phone')->nullable();
            $table->boolean('billing_same')->default(true);
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_address_line1')->nullable();
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_region')->nullable();
            $table->string('billing_address_zipcode')->nullable();
            $table->string('billing_address_phone')->nullable();
            $table->text('customer_notes')->nullable();
            $table->string('token')->unique();
            $table->ipAddress('ip_address');
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('client_id')->references('client_id')->on('customers');
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
