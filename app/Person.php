<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;
use App\District;
use App\Commune;
class Person extends Model
{
    protected $table = "persons";
    protected $fillable = [
    	'code',
    	'name',
    	'email',
    	'phone',
    	'sphone',
    	'address',
    	'province',
    	'district',
    	'commune',
    	'type',
    ];

    public function findAddressByCodedistrict ($district_code) {
        // $person = New 
        
        $commune =  Commune::where('district_code',$district_code)->first();
        $commune->district->province;
       
        $results = 
                    $commune->name . ' - ' .
                    $commune->district->name .' - ' .
                    $commune->district->province->name;

        return $results;
    }
}
