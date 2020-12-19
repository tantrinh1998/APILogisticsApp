<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaoBangBanking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->tinyInteger('user_id');
            $table->string('name');
            $table->integer('stk');
            $table->string('ngan_hang');
            $table->string('tinh_thanh');
            $table->string('chi_nhanh');
            $table->string('primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banking', function (Blueprint $table) {
            Schema::dropIfExists('banking');
        });
    }
}
