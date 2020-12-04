<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;
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

    public function scopeCode($query, $request){

        if ($request->has('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }
    return $query;
    }

    public function scopeStatus($query, $request){

        if ($request->has('status')) {
            $query->where('status',  $request->status);
        }
    return $query;
    }

    public function scopePhone($query, $request){

        if ($request->has('phone')) {
            $reciver = Person::where('phone',$request->phone)->get();
            // dd( $reciver);
            foreach ($reciver as $key => $value) {
                // dd( $value);
                $query->orWhere('receiver_id',  $value->id);
            };
            // $query->orWhere('receiver_id',  $reciver->id);
        }
    
    return $query;
    }
    public function scopeFrom($query, $request){

        if ($request->has('fromDate')) {
            $query->whereDate('created_at',">=", $request->fromDate);
        }

        return $query;
    }
    public function scopeTo($query, $request){

        if ($request->has('endDate')) {
            $query->whereDate('created_at',"<=", $request->endDate);
        }

        return $query;
    }
}
