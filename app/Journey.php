<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = "journeys";
     
    protected $fillable = [
    	'update_date',
    	'id_order',
    	'note',
    	'status',
    	'status_name',
    ];
}
