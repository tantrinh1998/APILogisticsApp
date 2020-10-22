<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Auth;
use App\Status;
use App\User;
use App\Person;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        $request->validate([
            
    "pickup_phone" => 'required|numeric',
    "pickup_address" => 'required|string',
    // "pickup_commune" => 'required|string',
    "pickup_district" => 'required|string',
    "pickup_province" => 'required|string',
    "name" => 'required|string',
    "phone" => 'required|numeric',
    // "email" => 'required|string',
    "address" => 'required|string',
    "province" => 'required|string',
    "district" => 'required|string',
    "commune" => 'required|string',
    "amount" => 'required|numeric',
    // "value" => 'required|numeric',
    "weight"  => 'required|numeric',
    "payer" => 'required|numeric',
    "service" => 'required|numeric',
    "config" => 'required|numeric',
        // "soc" => 'required|string',
        // "note" => 'required|string',
    "product_type" => 'required|numeric',
    // "products" => 'required|string',

        ]);
       //{pickup_code,pickup_phone,pickup_address,pickup_province,pickup_district,pickup_commune}
        $user_id = Auth::user()->id;
        //luu nguoi gui
        $arrPerson = [
            'code' => $request->pickup_code ?? null,
            'name' =>  null,
            'email' =>  null,
            'phone' => $request->pickup_phone,
            'sphone' => null,
            'address' => $request->pickup_address,
            'province' => $request->pickup_province,
            'district' => $request->pickup_district,
            'commune' => $request->pickup_commune,
            'type' => 1,
        ];
        DB::beginTransaction();
        try {
       
        $pickuper = new Person($arrPerson);
        $pickuper->save();

        $pickup_id = $pickuper->id;
        //luu nguoi nhan
        $arrPerson = [
            'code' => null,
            'name' =>  $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone,
            'sphone' => $request->sphone ?? null,
            'address' => $request->address,
            'province' => $request->province,
            'district' => $request->district,
            'commune' => $request->commune,
            'type' => 2,
        ];

        $receiver = new Person($arrPerson);
        $receiver->save();

        $receiver_id = $receiver->id;

        $amount = $request->amount;
        $value = $request->value;
        $weight = $request->weight;
        $note = $request->note;
        $service = $request->service;
        $config = $request->config;
        $payer = $request->payer;
        $product_type = $request->product_type;
        $product = $request->product ?? null;
        $products = $request->products ?? null;
        $barter = $request->barter;
        $notes = $request->notes ?? null;

        $id_last = Order::orderBy('id','desc')->first()->id ?? 0;
        $id_last+=1;
        $soc = 'PK.DACN'. $id_last;

        $code = 'MDH>DACN'.$id_last;
        //luu order
        $fee = 50000;
        $status = 1 ;
        $pickup = null;
        $delivery = null;
        $journeys = null;

        $arrOrder =  [
        'code' => $code, 
        'soc' =>  $soc,
        'pickup_id' => $pickup_id,
        'receiver_id' => $receiver_id,
        'amount' => $amount,
        'value' => $value,
        'fee' => $fee,
        'weight' => $weight ,
        'note' => $note,
        'service' => $service,
        'config' => $config,
        'payer' => $payer ,
        'product_type' => $product_type,
        'product' => $product,
        'products' => json_encode($products),
        'barter' => $barter,
        'pickup' => $pickup,
        'delivery' => $delivery,
        'journeys' => $journeys,
        'notes' => $notes,
        'user_id' => $user_id,
        'status' =>$status,
         ];

        Order::create($arrOrder);


        DB::commit();
        } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::info($e);

        return "cc";
        }




    $status_name = "Chờ Duyệt"; 

    $results = [ 
        'code' => $code ,
        'soc' => $soc,
        'phone' => $request->phone,
        'amount' =>$amount,
        'weight' => $weight,
        'fee' => $fee,
        'status'=> $status,
        'status_name' =>$status_name,
     ];

     $data = [
        'message' => 'Create Order Success',
        'status' =>'Success',
        'results' => $results,
     ];
    return response()->json($data);
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
