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
use App\Doisoat;
use App\Khohang;
use App\Province;
use App\District;
use App\Commune;
use Carbon\Carbon;
use App\Journey;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetailOrder($orders){

    }
    public function index()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id',$user_id)->where('status','!=',29)->with('PickUper','Receiver','getStatus')->get();
        $results =[];
        foreach ($orders as $key => $element) {
            $temp = $element;
            
            $receive =Person::find( $temp->receiver_id);
        // dd($receive);
            $receiverAddress = $receive->address . " - ". $this->findAddressByCodedistrict ($receive->commune);

            $pickuper =Person::find( $temp->pickup_id);
            // dd($receive);
            $pickuperAddress = $pickuper->address . " - ". $this->findAddressByCodedistrict ($pickuper->commune);
            // dd($pickuperAddress );
            $temp["receiverAddress"] = $receiverAddress; 
            $temp["pickuperAddress"] = $pickuperAddress; 

             $results[] = $temp;

        }
        
        $data = [
            'message' => 'ok',
            'status' => '1',
            'results' => $results
        ];

        return response()->json($data);
    }

    public function getListStatus(){
        $results = Status::all();
        $data = [
            'status' => 1,
            'message' => 'ok',
            'results' =>  $results,
        ];
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {

      if(isset($request->pickup_code)) {
          $request->validate([
              
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
          // "product_type" => 'required|numeric',
          // "products" => 'required|string',

              ]);
      } else {
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
          // "product_type" => 'required|numeric',
          // "products" => 'required|string',

        ]);
      }


        
       //{pickup_code,pickup_phone,pickup_address,pickup_province,pickup_district,pickup_commune}
        $user_id = Auth::user()->id;
        if(isset($request->pickup_code)) {
          $khohang = Khohang::where('code',$request->pickup_code)->first();
          // dd($khohang); 
          if( empty($khohang)) {
            $logg = ["log"=>"kho hang khong ton tai"];
            return response()->json( $logg);
            die();
          }
          $arrPerson = [
            'code' => $request->pickup_code ?? null,
            'name' =>  null,
            'email' =>  null,
            'phone' => $khohang->phone ?? null,
            'sphone' => null,

            'address' => $khohang->address ?? null,

            'province' => $khohang->code_province ?? null,
            'district' => $khohang->code_district ?? null,
            'commune' => $khohang->code_commune ?? null,
            'type' => 1,
        ];

        } else {
            $arrPerson = [
            'code' => $request->pickup_code ?? null,
            'name' =>  null,
            'email' =>  null,
            'phone' => $request->pickup_phone ?? null,
            'sphone' => null,
            'address' => $request->pickup_address ?? null ,
            'province' => $request->pickup_province ?? null,
            'district' => $request->pickup_district ?? null,
            'commune' => $request->pickup_commune ?? null,
            'type' => 1,
        ];
        }
        $soc="";
        $code="";
        DB::beginTransaction();
        try {
       
        $pickuper = new Person($arrPerson);
        $pickuper->save();

        $pickup_id = $pickuper->id;
        
        $arrPerson = [
            'code' => null,
            'name' =>  $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone,
            'sphone' => $request->sphone ?? null,
            'address' => $request->address ?? null,
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
        $product_type = $request->product_type ?? 1;
        $product = $request->product ?? null;
        $products = $request->products ?? null;
        $barter = $request->barter;
        $notes = $request->notes ?? null;

        $id_last = Order::orderBy('id','desc')->first()->id ?? 0;
        $id_last+=1;
        
        $soc = 'PK.DACN'. $id_last;

        $code = 'MDH.DACN'.$id_last;

        //luu order
        $checkHuyen = 0;
        if($request->district == $request->pickup_district) {
            $checkHuyen =2108;
        }

        $fee = $this->tinhtien($request->province,$request->pickup_province,$request->weight,$checkHuyen);
        $status = 1 ;
        $dt = Carbon::now();
        $ddt = Carbon::now();
        $pickup = $dt->addDay(1);
        $delivery = $ddt->addDay(3);
        $journeys = null;

        $arrOrder =  [
        'code' => $code, 
        'soc' =>  $soc ??   null,
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
        'product_type' => $product_type ?? 1,
        'product' => $product,
        'products' => json_encode($products),
        'barter' => $barter,
        'pickup' => $pickup,
        'delivery' => $delivery,
        'journeys' => $journeys ?? null,
        'notes' => $notes,
        'user_id' => $user_id,
        'status' =>$status,
         ];

        $order = Order::create($arrOrder);
        $aab ='';
        // dd( $order);
        $aab = $order->getStatus->value;
        // dd($aab);

        DB::commit();
        } catch (\Exception $e) {
        DB::rollBack();
          
        \Log::info($e);
        $logg = ["log"=>$e];
        return response()->json($logg );
        }

        

    // $status_name = "Chờ Duyệt"; 
 // dd( $code);

    $results = [ 
        'code' => $code ,
        'soc' => $soc ?? null,
        'phone' => $request->phone,
        'amount' =>$amount,
        'weight' => $weight,
        'fee' => $fee,
        'status'=> $status,
        'status_name' =>$aab,
     ];

     $data = [
        'message' => 'Create Order Success',
        'status' =>'1',
        'results' => $results,
     ];
      $arrJourney = [
          'status' =>1,
          'id_order' =>  $order->id ?? 0,
          'note' => "Tao Don Hang"  ,
          'update_date' => Carbon::now()
        ];
      $journey = Journey::create( $arrJourney);
     // dd($aab);
    return response()->json($data);
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function findAddressByCodedistrict ($commune_code) {
        // $person = New 
        
        $commune =  Commune::where('commune_code',$commune_code)->first();
        // dd($commune);
        $commune->district->province;
       
        $results = 
                    $commune->name . ' - ' .
                    $commune->district->name .' - ' .
                    $commune->district->province->name;

      return $results;
    }
    public function show(Order $order)
    {

        $results = $order->load('PickUper','Receiver','getStatus');
        // dd( $results);  
        $receive =Person::find( $results->receiver_id);
        // dd($receive);
        $receiverAddress = $receive->address . " - ". $this->findAddressByCodedistrict ($receive->commune);

        $pickuper =Person::find( $results->pickup_id);
        // dd($receive);
        $pickuperAddress = $pickuper->address . " - ". $this->findAddressByCodedistrict ($pickuper->commune);
        // dd($pickuperAddress );
        $results["receiverAddress"] = $receiverAddress; 
        $results["pickuperAddress"] = $pickuperAddress; 
        $data=[];
        if($results->status !=='29'){
           $data = [
            'message' => 'Ok',
            'status'=>'1',
            'results' => $results,

         ];
        } else
        { $data = [
                    'message' => 'Ok',
                    'status'=>'1',
                    'results' => "",
        
                ];}
       


        return response()->json($data);
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
        // dd($request->all());


        if($order->status != 1) return response()->json(['Error'=>'No update when status there']);

        $temp = [];
        foreach ($request->all() as $key => $value) {
            if(isset($order[$key]) && $value != $order[$key]) {
                   $temp[$key] = $value;
            }
        }

          $arrUpdateReceiver =[];
          $receiver = Person::find($order->receiver_id);
        foreach ($request->only(['phone','name','email','address','province','district','commune']) as $key => $value) {
          if($value) {

          $arrUpdateReceiver[$key]=$value;

          if(isset($receiver[$key]) && $value != $receiver[$key]) {
                   $temp[$key] = $value;
            }
          }
        }
        
        $pickuper = Person::find($order->pickup_id);
        $arrUpdateOrder = [];
        foreach ($request->only(['amount','value','weight','note','config','products']) as $key => $value) {
          if($value) {
            $arrUpdateOrder[$key]=$value;
          
          if(isset($receiver[$key]) && $value != $receiver[$key]) {
                   $temp[$key] = $value;
            }
          }
        }
        
        // dd($arrUpdateOrder);

        $arrUpdatePickUper = ['code'=>$request->pickup_code];

        
        $receiver->update($arrUpdateReceiver);
        $pickuper->update($arrUpdatePickUper);

        $order->update($arrUpdateOrder);
        // dd($order);
        $results = $order;

        $data = [
            'status'=>1,
            'message' =>"ok",
            'results' =>$results,
        ];
        
        if(!empty($temp)){

      
         $arrJourney = [
          'status' =>$order->status,
          'id_order' => $order->id,
          'note' => 'update: ' . json_encode($temp) ,
          'update_date' => Carbon::now()
        ];
          $journey = Journey::create( $arrJourney);
        }
       
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->update([
            'status'=>29,
        ]);
        $data = [
          "status"=>"1",
          "message" =>"ok",
          "results" =>[],
        ];

        $arrJourney = [
          'status' =>29,
          'id_order' =>  $order->id,
          'note' => " Huy Don Hang" ,
          'update_date' => Carbon::now()
        ];

        $journey = Journey::create( $arrJourney);
        return response()->json($data);
    }

    public function getStatus(Request $request){
        $request->validate([
            'code' => 'required|string',
        ]);

        // dd($request->code);
        $order = Order::where('code',$request->code)->first();
        $statusName = $order->getstatus->value;
        // dd($statusName);
        $results =[
            'code' => $order->code,
            'status' => $order->status,
            'status_name' => $statusName,
        ];
        $data =[
            "status" => 1,
            "message" => "ok",
            'results' => $results,
        ];
        return response()->json($data);

    }

    

    public function updateStatus(Request $request){
        $request->validate([
            'code' => 'required|string',
            'status' => 'required|numeric'
        ]);
        $order = Order::where('code',$request->code)->first();

        $order->update([
            'status'=>$request->status,
        ]);
        $arrJourney = [
          'status' => $request->status,
          'id_order' =>  $order->id,
          'note' => $request->note ?? null ,
          'update_date' => Carbon::now()
        ];
        $journey = Journey::create( $arrJourney);
        $statusName = $order->getstatus->value;
        // dd($statusName);
        $results =[
            'code' => $order->code,
            'status' => $order->status,
            'status_name' => $statusName,
        ];
        $data =[
            "status" => 1,
            "message" => "ok",
            'results' => $results,
        ];
        return response()->json($data);
    }
    public function getJourney(Request $request) {
        $request->validate([
           'id_order' => 'required',
          
        ]);
      $mode = $request->mode ?? 1 ;
      if($mode<2) {
          $journey = Journey::where('id_order',$request->id_order)->groupBy('status')->get();
      } else {
           $journey = Journey::where('id_order',$request->id_order)->get();
      }
      
       
           
           $data = [
          'status'=> '1',
          "message" =>'ok',
          "results" => $journey];
        


        return response()->json($data);
    }
    public function doisoat1donhang( $code ,$user_id){
        // dd($code);
        // $code =$request->code;
        $check= -1;
        $listCodeOrder = Doisoat::select('code')->get();
        foreach ($listCodeOrder as $element) {
            if($element->code ==$code){
                $check=5;
            }
        }

        if($check != 5 ){

            $order = Order::where('code',$code)->first();
            // dd($order);
            $arrJourney = [
              'status' =>30,
              'id_order' =>  $order->id,
              'note' => " Da DOi Soat, Chua Thanh Toan" ,
              'update_date' => Carbon::now()
            ];
        
            $journey = Journey::create( $arrJourney);

            $phibaohiem =0;
            $amount =0;
            $fee=0;
            if(!empty($order->value) && !empty($order->amount) && !empty($order->fee))
            {   $amount = $order->amount;
                $fee = $order->fee;
                if( $order->value > 1000000 ) {
                if($order->value > 10000000) $phibaohiem= $order->value*0.0014;
                else
                $phibaohiem= $order->value*0.0008;
            }}

            $tiendoisoat = $amount - $fee -$phibaohiem ;

            $arrDoiSoat = [
                "code"=>$code,
                "tiendoisoat"=>$tiendoisoat,
                "status" => 30,
                "user_id" => $user_id,

            ];

            $doisoat = Doisoat::create($arrDoiSoat);
        }


    }

    public function doiSoatToanBoCua1User($user_id){
        
        $listCodeDonHang = Order::select('code')->where('user_id',$user_id)->get();
        // dd($listCodeDonHang);
        foreach($listCodeDonHang as $element){
            $this->doisoat1donhang($element->code ,$user_id);
        };
       
    }



    public function  doiSoatToanBoOrder(){
        $listIdUser = User::select('id')->get();

        foreach ($listIdUser as $element) {
            $this->doiSoatToanBoCua1User( $element->id);
        }


        $doisoat = Doisoat::all();
        $data = [
            'status'=>1,
            'message'=>'ok',
            'results' => $doisoat,
        ];
        return response()->json($data);
       
    }
    public function getDoiSoatTheoDotCua1User(){
       $user_id = Auth::user()->id;
       $doisoat  =  Doisoat::where('user_id',$user_id)->get()
                    ->groupBy(function($date) {
                      return \Carbon\Carbon::parse($date->created_at)->format('y-m-d');
                      });

       $data = [
          "status" => '1',
          "message" => 'ok',
          'results' => $doisoat
       ];
       return response()->json($data);
    }

    public function getDoiSoatTheoDotAll (){
      $doisoat  =  Doisoat::all()

                    ->groupBy(function($date) {
                      return \Carbon\Carbon::parse($date->created_at)->format('y-m-d');
                      });

       $data = [
          "status" => '1',
          "message" => 'ok',
          'results' => $doisoat
       ];
       return response()->json($data);
    }
    public function getAllDoiSoat(){
        $doisoat = Doisoat::all();
        $data = [
            'status'=>1,
            'message'=>'ok',
            'results' => $doisoat,
        ];
        return response()->json($data);
    }
    public function checkRangeMien($codeA,$codeB){
      if($codeA == $codeB) return 0;
      $mien =[
         '1' => [80,82,83,84,86,87,89,91,92,93,94,95,96],
         '2' => [79,74,70,72,75,77],
         '3' => [48,49,51,52,54,56,58,60] ,
         '4' => [62,64,66,67,68],
         '5' => [38,40,44,45,46,42],
         '6' => [1,26 ,27 ,33 , 35 ,30 ,31 ,34 ,36 ,37],
         '7' => [12 , 11 ,15 ,14 ,17 ,10],
         '8' => [2,4,8 ,6 ,20,19 ,24,22 ,25],
        ];  
      $cca = -1;
       $ccb = -1;
       foreach ($mien as $key => $value) {
         foreach ($value as $aab => $element) {
            if ($element == $codeA ) {$cca=$key ;}
            if ($element == $codeB ) {$ccb=$key ;}
            if( ($cca >0) && ($ccb>0)) {
               break;
            }

         }
       }
      $bbs = [
      [1,2,100],
      [1,3,200],
      [1,4,200],
      [1,5,300],
      [1,6,400],
      [1,7,500],
      [1,8,600],
      [2,3,100],
      [2,4,100],
      [2,5,300],
      [2,6,400],
      [2,7,400],
      [2,8,500],
      [3,4,100],
      [3,5,200],
      [3,6,300],
      [3,7,400],
      [3,8,500],
      [4,5,200],
      [4,6,300],
      [4,7,400],
      [4,8,500],
      [5,6,100],
      [5,7,200],
      [5,8,300],
      [6,7,100],
      [6,8,100],
      [7,8,100],
     ];

     $phi = 0;

    if($cca == $ccb) return $cca;

    foreach ($bbs as $key => $value) {
      if( in_array($cca, $value) && in_array($ccb, $value) ) return ($value[2]);
    }
    return -1;
      
    // tra ve khoang cach gia 2 mien neu khong chung mien ,
    //  neu chung mien cha ve mien * 100
   }

    // public function aaaaaa($cca ,$ccb) {

 //          $bbs = [
 //             [1,2,100],
 //             [1,3,200],
 //             [1,4,200],
 //             [1,5,300],
 //             [1,6,400],
 //             [1,7,500],
 //             [1,8,600],
 //             [2,3,100],
 //             [2,4,100],
 //             [2,5,300],
 //             [2,6,400],
 //             [2,7,400],
 //             [2,8,500],
 //             [3,4,100],
 //             [3,5,200],
 //             [3,6,300],
 //             [3,7,400],
 //             [3,8,500],
 //             [4,5,200],
 //             [4,6,300],
 //             [4,7,400],
 //             [4,8,500],
 //             [5,6,100],
 //             [5,7,200],
 //             [5,8,300],
 //             [6,7,100],
 //             [6,8,100],
 //             [7,8,100],
 //          ];

 //          $phi = 0;

 //         if($cca == $ccb) return 0 ;

 //         foreach ($bbs as $key => $value) {
 //             if( in_array($cca, $value) && in_array($ccb, $value) ) return ($value[2]/100);
 //         }
 //         return -1;
    // }

   public function checkRangeTinh($codeA , $codeB) {
      $flag = 0;
      if($codeA==$codeB) return 0;
      $flag = $this->checkRangeMien($codeA , $codeB);
      // return $flag;
      $cuc1 = [
         [96,80,400] , [87,89,83,91,94,95,84,200],[96,87,82,83,300],
         [91,94,95,80,300],[89,93,94,92,96,80,200] 
      ];
      // $value =[96,80,400];
      // return ($value[count($value)-1]/100);
      if($flag ==1) {
        foreach ($cuc1 as $key => $value) {
          if(  in_array($codeA, $value) &&  ( in_array($codeB, $value) )){
           
            return ($value[count($value)-1]/100);
          
          }
            
        }
        return 1;
      }
      // note cuc 1 con lai la 100
      $cuc2 =[
        [74,75,77,79,100] ,[70,72,74,100],[72,77,300],[70,77,200] , 
        [72,74,79,100]
      ];
      if($flag ==2) {
        foreach ($cuc1 as $key => $value) {
          if(  in_array($codeA, $value) &&  ( in_array($codeB, $value) )){
           
            return ($value[count($value)-1]/100);
          
          }
        return 2;
      }
      }
      
      $temp =[48,49,51,52,54,56,58,60] ;
      $a3 =0;
      $b3 =0;
      if($flag ==3 ){
        foreach ($temp as $key => $value) {
          if($codeA == $value ) $a3 = $key;
          if($codeB == $value ) $b3 = $key;
        }
        if( $a3 >$b3) return $a3-$b3;
        else return $b3-$a3;

      }
      $temp4 =[62,64,66,67,68]; 
      $a3 =0;
      $b3 =0;
      if($flag ==4 ){
        foreach ($temp4 as $key => $value) {
          if($codeA == $value ) $a3 = $key;
          if($codeB == $value ) $b3 = $key;
        }
        if( $a3 >$b3) return $a3-$b3;
        else return $b3-$a3;

      }  

      $temp5 = [38,40,44,45,46,42];
      $a3 =0;
      $b3 =0;
      if($flag ==5 ){
        foreach ($temp5 as $key => $value) {
          if($codeA == $value ) $a3 = $key;
          if($codeB == $value ) $b3 = $key;
        }
        if( $a3 >$b3) return $a3-$b3;
        else return $b3-$a3;

      }  
      // [1,26 ,27 ,33 , 35 ,30 ,31 ,34 ,36 ,37]
      $cuc6 = [
        [35,36,37,100],[35,36,34,100],[33,34,35,100],[1,33,35,100],[30,31,34,100],
        [30,33,34,100],[27,30,33,100],[27,33,1,100],[26,1,27,100],
        [26,27,35,200],[1,34,37,200],[1,30,36,200],[31,27,35,200],[37,33,200],[31,36,200],
        [31,37,1,300],[26,37,36,34,300],[37,30,27,300],[26,31,400]
      ]; 
      if($flag ==6) {
        foreach ($cuc6 as $key => $value) {
         if(  in_array($codeA, $value) &&  ( in_array($codeB, $value) )){
           
            return ($value[count($value)-1]/100);
          
          }
        }
        return 2;
      }
      $cuc7= [
        [14,15,17,100],
        [12,10,11,15,14,100], [17,12,300] , [17,10,11,200]
      ];
      if($flag ==7) {
        foreach ($cuc7 as $key => $value) {
         if(  in_array($codeA, $value) &&   in_array($codeB, $value) ){
           
            return ($value[count($value)-1]/100);
          
          }
        }
        return 2;
      }

      $cuc8= [
        [2,4,6,8,100],[4,6,20,100],[6,8,19,100],[6,20,19,100],[8,25,19,100],[19,20,24,100],[20,24,22,100],
        [2,4,19,20,200],[8,6,24,200],[2,25,200],[22,19,200],
        [4,24,25,2,300],[4,6,22,300],
        [25,22,8,2,400,24]
      ];
      if($flag ==8) {
        foreach ($cuc8 as $key => $value) {
         if(  in_array($codeA, $value) &&  ( in_array($codeB, $value) )){
           
            return ($value[count($value)-1]/100);
          
          }
        }
        return 2;
      }

      return -1;
   }
   public function getRangeWeight($weight){
      if($weight > 50001) return $weight/1000;
      $ArrWeight =[
        [1,1000,1],[1001,2000,1.5],[2001,5000,2.5],[5001,10000,4],[10001,30000,8],
        [30001,50000,12]
      ];

      foreach ($ArrWeight as $key => $value) {
            if($weight>$value[0] && $weight<=$value[1]) return $value[2];
      }
      return 0;
   }
   public function tinhtien($codeA ,$codeB ,$weight ,$checkHuyen) {
      $rangeMien =0 ;
      $rangeTinh =0 ;
      $rangeWeight = 1 ;

      if(!empty($weight)) $rangeWeight= $this->getRangeWeight($weight);
      
      $aa =$this->checkRangeMien($codeA ,$codeB);
      if( $aa >50){
        $rangeMien = $aa/100;
      } else {
         $rangeTinh = $this->checkRangeTinh($codeA,$codeB);
      }
      if(empty($checkHuyen)) $checkHuyen=1; else $checkHuyen =0;
      

      $chuan = 10000; 
      $fee =  $chuan + 5000*$rangeWeight + $checkHuyen*5000 + $rangeTinh*5000 +$rangeMien*10000;

      return $fee;

   }

   public function test() {
      $data = $this->tinhtien(87,96,1,0);
      dd($data);
   }
}
