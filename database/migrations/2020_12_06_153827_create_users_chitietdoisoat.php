<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersChitietdoisoat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietdoisoat', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->tinyInteger('user_id');
            $table->string('tien_doi_soat');
            $table->string('tien_da_tra');



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
        Schema::dropIfExists('chitietdoisoat');
    }
}
