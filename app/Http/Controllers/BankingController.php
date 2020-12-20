<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banking;
use Auth;
class BankingController extends Controller
{
    public function store(Request $request){
    $user_id = Auth::user()->id;
    $request->validate([          
          "name" => 'required|string',
          "stk" => 'required|string',
          "ngan_hang" => 'required|string',
          "tinh_thanh" => 'required|string',
          "chi_nhanh" => 'required|string',
      ]);
    $primary = 2;
    $banking=[];
    $banking = Banking::where('user_id',$user_id)->get();

    if(empty($banking[0])) {
    	$primary = 1;
    }
    if($request->primary ==1 ) {
    	$primary =1;
    	foreach ($banking as $key => $value) {
    		$banking[$key]->update(["primary"=>2]);
    	}
    }

    $arr=[
    	"name" => $request->name,
          "user_id" =>  $user_id,
          "stk" => $request->stk,
          "ngan_hang" => $request->ngan_hang,
          "tinh_thanh" => $request->tinh_thanh,
          "chi_nhanh" => $request->chi_nhanh,
          "primary" => $primary,
    ];

    $banking = Banking::create($arr);
    $data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$banking
    	];
    	return response()->json($data);

    }

    public function index(){
    	$user_id = Auth::user()->id;
    	$banking = Banking::where('user_id',$user_id)->get();
 		$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$banking
    	];
    	return response()->json($data);
    }
    public function show(Request $request){
    	$request->validate(['id'=>'required']);
    	$banking = Banking::where('id',$request->id)->first();
 		$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$banking
    	];
    	return response()->json($data);
    }

     public function delete(Request $request){
    	$request->validate(['id'=>'required']);
    	$banking = Banking::where('id',$request->id)->first();
    	if(!empty($banking)) {$banking->delete();}
    	
 		$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>"Deleted"
    	];
    	return response()->json($data);
    }

    public function updatePrimary(Request $request){
    	$request->validate([
    		'id'=> 'required',
    	]);
    	$user_id = Auth::user()->id;
    	$bankings = Banking::where('user_id',$user_id)->get();
    	foreach ($bankings as $key => $value) {
    		$bankings[$key]->update(["primary"=>2]);
    	}

    	$banking = Banking::where('id',$request->id)->first();
    	$banking->update(['primary'=>1]);
    	
    	$data = [
    		"status"=>1,
    		"message"=>"updated",
    		"results"=>$banking
    	];
    	return response()->json($data);
    }
}
