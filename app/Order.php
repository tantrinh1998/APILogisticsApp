<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code', 
        'soc',
    
        'pickup_id',
        'receiver_id',
        'amount',
        'value',
        'fee',
        'weight',
        'note',
        'service',
        'config',
        'payer',
        'product_type',
        'product',
        'products',
        'barter',
        'pickup',
        'delivery',
        'journeys',
        'notes',
        'user_id',
        'status',
    ];
    public function PickUper(){
        return $this->belongsTo('App\Person','pickup_id');
    }
    public function Receiver(){
        return $this->belongsTo('App\Person','receiver_id');
    }
    public function getStatus(){
        return $this->belongsTo('App\Status','status');
    }


}
