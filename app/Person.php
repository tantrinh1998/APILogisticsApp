<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
