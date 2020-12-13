<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doisoat extends Model
{
    protected $table = 'doisoat';

    protected $fillable =[
        'code',
        'status',
        'tiendoisoat',
        'user_id'
    ];

    public function getStatus(){
        return $this->belongsTo('App\Status','status');
    }
    public function OrderT(){
        return $this->hasOne('App\Orders','code','code');
    }
}
