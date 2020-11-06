<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrdersTable extends Migration
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
            $table->string('code');
            $table->string('soc')->nullable();
            $table->tinyInteger('pickup_id');
            $table->tinyInteger('receiver_id');
            $table->integer('amount');
            $table->integer('value')->nullable();
            $table->integer('fee')->nullable();
            $table->integer('weight');
            $table->string('note')->nullable();
            $table->string('service');
            $table->string('config');
            $table->tinyInteger('payer');
            $table->tinyInteger('product_type');
            $table->string('product')->nullable();
            $table->json('products')->nullable();
            $table->string('barter')->nullable();
            $table->json('pickup')->nullable();
            $table->json('delivery')->nullable();
            $table->json('journeys')->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('user_id');
            $table->tinyInteger('doisoat_id')->default('0');
            $table->tinyInteger('status');

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
