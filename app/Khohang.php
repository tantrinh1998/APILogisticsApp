<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Khohang extends Model
{
    protected $table = 'khohang';

    protected $fillable = [
    	'code',
    	'name',
    	'phone',
    	'contact',
    	'code_commune',
    	'code_district',
    	'code_province',
    	'address',
    	'formatted_address',
    	'status',
    	'primary',
    	'user_id',
    ];
}
