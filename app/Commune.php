<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = 'commune';

    protected $fillable = [
    	'commune_code',
    	'nem',
    	'type',
    	'district_code',
    ];

   public function district(){
   		return $this->belongsTo('App\District','district_code','district_code');
   }
}
