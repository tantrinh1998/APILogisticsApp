<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTienphiTienthuho extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chitietdoisoat', function (Blueprint $table) {
           $table->string('tong_tien_phi')->nullable();
           $table->string('tong_tien_thu_ho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chitietdoisoat', function (Blueprint $table) {
            $table->dropColumn('tong_tien_phi');
            $table->dropColumn('tong_tien_thu_ho');
        });
    }
}
