<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banks;
class BankController extends Controller
{
    public function getListBank(){
    	$banks = Banks::select('list_bankList_MaNganHang','list_bankList_TenNH')->whereIn('list_Loai',[2,3])->distinct('list_bankList_MaNganHang')->get();
    	$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$banks
    	];
    	return response()->json($data);
    }

    public function getListChiNhanh(Request $request){
        $request->validate(["code"=>"required"]);
    	$banks = Banks::select('list_bankList_province_TenTinhThanh','list_bankList_province_branch_MaChiNhanh','list_bankList_province_branch_TenChiNhanh')->where('list_bankList_MaNganHang',$request->code)->get();
    	$collection = collect($banks);
    	$grouped = $collection->groupBy('list_bankList_province_TenTinhThanh');
    	$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$grouped->all(),
    	];
    	return response()->json($data);
    }
}
