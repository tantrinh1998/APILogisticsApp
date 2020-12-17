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
        $khohang = Khohang::where('user_id',$user_id)->where("status",1)->get();
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
           
        ]);
        $user_id = Auth::user()->id;
        $primary =  2;
        $khohangg=[];
        if(isset($request->primary) && $request->primary == 1){

         $khohang = Khohang::where('user_id',$user_id)->where("status",1)->get();
         foreach ($khohang as $key => $value) {
              $value->update(["primary"=>2]);
           }
        $primary =  1 ;
         } else {

          $khohangg = Khohang::where('user_id',$user_id)->where("status",1)->get();
          if(empty($khohangg[0])){
             $primary = 1;
          }
         }
        
        
        
        $CheckCommune =Commune::where('commune_code',$request->code_commune)->first();
          $log = ["log"=>"code commune khong dung"];
          if(empty($CheckCommune)) return response()->json( $log);
        $user_id = Auth::user()->id;

        $stt = Khohang::orderby('id','desc')->first()->id ?? 0;
        $stt+=1;

        $code = 'KH00000'.$stt;
        // dd($code);
        $commune = Commune::select('name')->where('commune_code',$request->code_commune)->first() ;
        $district = District::select('name')->where('district_code',$request->code_district)->first() ;
        $province = Province::select('name')->where('province_code',$request->code_province)->first();
        $abc = $this->findByCommune($request->code_district);
        $formatted_address= $request->address . ' - ' .$abc;
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
            'primary' => $primary ,
            'user_id'=> $user_id,
        ];

        $khohang = new Khohang($khohang_detail);
        $khohang->save();

            if($primary == 1 ) 
                $primary_name = "Kho Mặc Định" ;
            else $primary_name = "Kho Thường";
        $results = [
            'code'=>$code,
            'name' => $request->name,
            'address'  => $request->address,
            'formatted_address' => $formatted_address,          
            'status'=>'1',
            'status_name' => 'Hoạt Động',
            'primary' => $primary,
            'primary_name' =>$primary_name,
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
        $results = $khohang;
        $data =[
            'messaage' => 'ok',
            'status'=>'1',
            'results'=>$results,
        ];
         return response()->json($data);
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

    public function updatePrimary (Request $request){
      $request->validate([
        'primary' => 'required',
        'code' => 'required'
      ]);

      $user_id = Auth::user()->id;
      $khohangg = Khohang::where('code',$request->code)->first();
      if($request->primary == 1){
         $khohang = Khohang::where('user_id',$user_id)->get();
         foreach ($khohang as $key => $value) {
              $value->update(["primary"=>2]);
         }
         
         $khohangg->update(["primary"=>1]);
      } else {
          $khohangg->update(["primary"=>2]);
          $khohang = Khohang::where('user_id',$user_id)->first();
          $khohang->update(["primary"=>1]);
      }
      $khohang1 = Khohang::where('user_id',$user_id)->get();
      $results = $khohang1;
      $data = [
        "status"=>1,
        "message"=>"ok",
        "results"=>$results
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
        $khohang->update(["status"=>2]);
        $user_id = Auth::user()->id;
        
        if($khohang->primary == 1){
         $khohangg = Khohang::where('user_id',$user_id)->where("status",1)->first();
         $khohangg->update(["primary"=>1]);
        }
        $data = [
          "status"=>1,
          "messgae"=>"deleted",
          "results"=>$khohang
        ];
        return response()->json($data);
    }

        public function findByCommune ($district_code) {
        $commune =  Commune::where('district_code',$district_code)->first();
        // dd($commune);
        $commune->district->province;
       
        $results = 
             $commune->name . ' - ' . $commune->district->name .' - ' . $commune->district->province->name
        ;

        return $results;
    }
}
