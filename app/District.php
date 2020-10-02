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
}
