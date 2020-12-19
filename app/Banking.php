<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    protected $table = 'banking';

    protected $fillable = [
    	'user_id',
    	'name',
    	'stk',
    	'ngan_hang',
    	'tinh_thanh',
    	'chi_nhanh',
    	'primary'
    ];
}
