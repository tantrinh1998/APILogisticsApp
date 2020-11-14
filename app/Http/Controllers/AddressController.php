<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Province;
use App\District;
use App\Commune;

class AddressController extends Controller
{
    public function province(){
    	$results = Province::all();
        $data = [
            'status' => '1',
            'message' => 'ok',
            'results' => $results
        ];
    	return response()->json($data);

    }

    public function district(Request $request){
    	$results = District::where('province_code',$request->province_code)->get();
        $data = [
            'status' => '1',
            'message' => 'ok',
            'results' => $results
        ];
    	return response()->json($data);
    }

    public function commune(Request $request){
    	$results = Commune::where('district_code',$request->district_code)->get();
          $data = [
            'status' => '1',
            'message' => 'ok',
            'results' => $results
        ];
    	return response()->json($data);
    }
    
    public function findByCommune (Request $request) {
        $commune =  Commune::where('district_code',$request->district_code)->first();
        $commune->district->province;
       
        $results = [
            "address" => $commune->name . ' - ' . $commune->district->name .' - ' . $commune->district->province->name
        ];
        $data = [
            "status" => '1',
            "message" => 'ok',
            "results" => $results
        ];
        return response()->json( $data);
    }
}
