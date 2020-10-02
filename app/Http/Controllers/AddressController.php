<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Province;
use App\District;
use App\Commune;

class AddressController extends Controller
{
    public function province(){
    	$data = Province::all();

    	return response()->json($data);

    }

    public function district($province_code){
    	$data = District::where('province_code',$province_code)->get();

    	return response()->json($data);
    }

    public function commune($province_code ,$district_code){
    	$data = Commune::where('district_code',$district_code)->get();

    	return response()->json($data);
    }
    
}
