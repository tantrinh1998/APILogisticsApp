<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Status;
use App\Commune;
use App\District;
use App\Province;
class tinhPhiController extends Controller
{

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

 // 		 $bbs = [
 // 		 	[1,2,100],
 // 		 	[1,3,200],
 // 		 	[1,4,200],
 // 		 	[1,5,300],
 // 		 	[1,6,400],
 // 		 	[1,7,500],
 // 		 	[1,8,600],
 // 		 	[2,3,100],
 // 		 	[2,4,100],
 // 		 	[2,5,300],
 // 		 	[2,6,400],
 // 		 	[2,7,400],
 // 		 	[2,8,500],
 // 		 	[3,4,100],
 // 		 	[3,5,200],
 // 		 	[3,6,300],
 // 		 	[3,7,400],
 // 		 	[3,8,500],
 // 		 	[4,5,200],
 // 		 	[4,6,300],
 // 		 	[4,7,400],
 // 		 	[4,8,500],
 // 		 	[5,6,100],
 // 		 	[5,7,200],
 // 		 	[5,8,300],
 // 		 	[6,7,100],
 // 		 	[6,8,100],
 // 		 	[7,8,100],
 // 		 ];

 // 		 $phi = 0;

 // 		if($cca == $ccb) return 0 ;

 // 		foreach ($bbs as $key => $value) {
 // 			if( in_array($cca, $value) && in_array($ccb, $value) ) return ($value[2]/100);
 // 		}
 // 		return -1;
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

      return -6;
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
   public function tinhtien(Request $request) {

      $request->validate([
          'maHuyenA'=>'required|string',
          'maHuyenB'=>'required|string',
         
      ]);
      $districtA = District::where('district_code',$request->maHuyenA)->first();
      $districtB = District::where('district_code',$request->maHuyenB)->first();

      $codeA =  $districtA->province_code;
      $codeB =  $districtB->province_code;
   
      $weight =  $request->weight ?? 1 ;
      $checkHuyen =1;
      if($request->maHuyenA == $request->maHuyenB)  $checkHuyen=0;
      $rangeMien =0 ;
      $rangeTinh =0 ;
      $rangeWeight = 1 ;
      $fee=0;
      if(!empty($weight)) $rangeWeight= $this->getRangeWeight($weight);
      
      $aa =$this->checkRangeMien($codeA ,$codeB);
      if( $aa >50){
        $rangeMien = $aa/100;
      } else {
         $rangeTinh = $this->checkRangeTinh($codeA,$codeB);
      }
      if(empty($checkHuyen)) $checkHuyen=1; else $checkHuyen =0;
      

      $chuan = 10000; 
      $fee =  $chuan + 5000*$rangeWeight + $checkHuyen*5000 + $rangeTinh*7000 +$rangeMien*13000;
      $results =[
        'fee'=>$fee,
      ];
      $data = [
        'status' => 1 ,
        'message' => 'ok',
        'results' => $results
      ];
      return response()->json($data);

   }

   public function test() {
    
   }
   
}
