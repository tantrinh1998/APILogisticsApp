<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Doisoat;
use App\Order;
use App\User;
use App\Status;
use DB;
use Carbon\Carbon;

class DoiSoatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:doisoat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DOi soat toan bo Don hang';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->doiSoatToanBoOrder();
        $users = User::all();
        $today =Carbon::now()->dayOfWeek;
        foreach ( $users as $element) {
            if($element->doisoat == 1 ){
                if( $today ==3)
                $this->doiSoatToanBoCua1User($element->id);
            }
            if($element->doisoat == 2 ){
                if( ($today ==3) || ( $today ==5))
                $this->doiSoatToanBoCua1User($element->id);
            }
            if($element->doisoat == 3 ){
                 if( ($today ==3) || ( $today ==7))
                $this->doiSoatToanBoCua1User($element->id);
            }
            if($element->doisoat == 4 ){
                 if( ($today ==5) || ( $today ==7))
                $this->doiSoatToanBoCua1User($element->id);
            }
            if($element->doisoat == 5 ){
                 if( ($today ==5) || ( $today ==7) || ( $today ==3) )
                $this->doiSoatToanBoCua1User($element->id);
            }
          
        }

        
    }
    public function doisoat1donhang( $code ){
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
                "code"=>"$code",
                "tiendoisoat"=>" $tiendoisoat",
                "status" => 30,

            ];

            $doisoat = Doisoat::create($arrDoiSoat);
        }


    }

    public function doiSoatToanBoCua1User($user_id){
        
        $listCodeDonHang = Order::select('code')->where('user_id',$user_id)->get();

        foreach($listCodeDonHang as $element){
            $this->doisoat1donhang($element);
        };
       
    }

    public function getAllDoiSoat(){
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
}
