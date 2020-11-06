<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doisoat extends Model
{
    protected $table = 'doisoat';

    protected $fillable =[
        'code',
        'status',
        'tiendoisoat'
    ];

    public function getStatus(){
        return $this->belongsTo('App\Status','status');
    }
}
