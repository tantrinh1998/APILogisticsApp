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
}
