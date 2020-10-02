<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaoBangKhoHang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khohang', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code');
            $table->string('name');
            $table->integer('phone');
            $table->string('contact');
            $table->string('code_commune');
            $table->string('code_district');
            $table->string('code_province');
            $table->string('address');
            $table->string('formatted_address');
            $table->tinyInteger('status');
            $table->tinyInteger('primary');
            $table->tinyInteger('user_id');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('khohang');
    }
}
