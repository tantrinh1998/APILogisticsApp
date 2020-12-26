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
        "status_name",
        "the_ngan_hang"
    ];

    public function DoiSoat(){
        return $this->hasMany('App\Doisoat','chitietdoisoat_id');
    }
    public function scopeFrom($query, $request){

        if ($request->has('fromDate')) {
            $query->whereDate('created_at',">=", $request->fromDate);
        }

        return $query;
    }
    public function scopeTo($query, $request){

        if ($request->has('toDate')) {
            $query->whereDate('created_at',"<=", $request->toDate);
        }

        return $query;
    }
    public function ChiTietThe(){
        return $this->belongsTo('App\Banking','the_ngan_hang','id');
    }
}
