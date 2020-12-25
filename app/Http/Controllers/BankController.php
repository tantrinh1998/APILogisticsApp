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
	public function getListTinh(Request $request){
		$request->validate(["code"=>"required"]);
		$banks = Banks::select('list_bankList_province_TenTinhThanh')
		->where('list_bankList_MaNganHang',$request->code)
		->distinct()->get();
    	$data = [
    		"status"=>1,
			"message"=>"ok",
			"code_bank"=>$request->code,
    		"results"=>$banks
    	];
    	return response()->json($data);
    }
    public function getListChiNhanh(Request $request){
		$request->validate(["province"=>"required"]);
		$banks = Banks::select('list_bankList_province_branch_MaChiNhanh','list_bankList_province_branch_TenChiNhanh')
		->where('list_bankList_MaNganHang',$request->code)
		->where('list_bankList_province_TenTinhThanh',$request->province)
		->get();
    	$data = [
    		"status"=>1,
    		"message"=>"ok",
    		"results"=>$banks,
    	];
    	return response()->json($data);
    }
}
