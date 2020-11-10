<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Khohang;
use Illuminate\Http\Request;
use Auth;
use App\Commune;
use App\District;
use App\Province;

class KhohangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = Auth::user()->id; 
        $khohang = Khohang::where('user_id',$user_id)->get();
        $data=[
            'messaage' => 'ok',
            'status'=>'1',
            'results'=>$khohang,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'contact' => 'required|string',
            'code_commune' => 'required|string',
            'code_district' => 'required|string',
            'code_province' => 'required|string',
            'address' => 'required|string',
            'primary' => 'required|numeric',
        ]);

        $user_id = Auth::user()->id;

        $stt = Khohang::orderby('id','desc')->first()->id ?? 0;
        $stt+=1;

        $code = 'KH00000'.$stt;
        $commune = Commune::select('name')->where('commune_code',$request->code_commune)->first() ;
        $district = District::select('name')->where('district_code',$request->code_district)->first() ;
        $province = Province::select('name')->where('province_code',$request->code_province)->first();
        $formatted_address= $request->address . " - ". $commune->name ." - ". $district->name ." - ".$province->name;
        $khohang_detail = [
            'code' => $code,
            'name' => $request->name,
            'phone' => $request->phone,
            'contact' => $request->contact,
            'code_commune' => $request->code_commune,
            'code_district' => $request->code_district,
            'code_province' => $request->code_province,
            'address'  => $request->address,
            'formatted_address' => $formatted_address,
            'status'=>'1',
            'primary' => $request->primary,
            'user_id'=> $user_id,
        ];

        $khohang = new Khohang($khohang_detail);
        $khohang->save();

            if($request->primary == 1 ) 
                $primary_name = "Kho Mặc Định" ;
            else $primary_name = "Kho Thường";
        $results = [
            'code'=>'$code',
            'name' => $request->name,
            'address'  => $request->address,
            'formatted_address' => $formatted_address,          
            'status'=>'1',
            'status_name' => 'Hoạt Động',
            'primary' => $request->primary,
            'primary_name' =>'$primary_name',
            'created_at' => $khohang->created_at,
            'updated_at' => $khohang->updated_at,
        ];

        $data =[
            'messaage' => 'ok',
            'status'=>'1',
            'results'=>$results,
        ];

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Khohang  $khohang
     * @return \Illuminate\Http\Response
     */
    public function show(Khohang $khohang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Khohang  $khohang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        
        $request->validate([
             'name' => 'required|string',
             // 'code' => 'required|string',
             'contact' => 'required|string',
             'phone' => 'required|numeric',

        ]);
        $khohang = Khohang::where('code',$code)->first();
        $khohang->name = $request->name;
        // $khohang->code = $code;
        $khohang->contact = $request->contact;
        $khohang->phone = $request->phone;

        $khohang->save();
        $diff = [
            'name' => $request->name,
            'contact' => $request->contact,
        ];

        $results = [
            'code' => $code,
            'diff' =>$diff,
            'updated_at'=> $khohang->updated_at,
        ];
        
     
        $data = [
            'messaage' =>'ok',
            "status"=>"1",
            'results' =>$results,
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Khohang  $khohang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Khohang $khohang)
    {
        //
    }
}
