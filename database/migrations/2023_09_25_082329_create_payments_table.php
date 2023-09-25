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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->nullable();
            $table->unsignedBigInteger('cart_id');
            $table->string('name')->nullable();
            $table->string('billing_app')->nullable();
            $table->boolean('blocked')->nullable();
            $table->string('code')->nullable();
            $table->string('client_id')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_method_description')->nullable();
            $table->string('payment_condition')->nullable();
            $table->decimal('fee', 8, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('message')->nullable();
            $table->string('block_reason')->nullable();
            $table->integer('number')->nullable();
            $table->boolean('default')->nullable();
            $table->integer('days')->nullable();
            $table->integer('installments')->nullable();
            $table->string('type')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('partial_amount')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
