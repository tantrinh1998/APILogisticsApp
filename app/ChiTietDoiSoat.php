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
        "tong_tien_phi",
        'tong_tien_thu_ho',
        "status",
        "status_name"
    ];

    public function DoiSoat(){
        return $this->hasMany('App\Doisoat','chitietdoisoat_id');
    }
}
