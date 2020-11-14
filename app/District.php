<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';

    protected $fillable = [
    	'district_code',
    	'name',
    	'type',
    	'province_code'

    ];

       public function province(){
   		return $this->belongsTo('App\Province','province_code','province_code');
   }
}
