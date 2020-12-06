<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietDoiSoat extends Model
{
    protected $table = 'chitietdoisoat';

    protected $fillable = [
    	"code",
    	"user_id",
    	"tien_doi_soat",
    	"tien_da_tra",
    ];
}
