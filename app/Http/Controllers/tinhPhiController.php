<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tinhPhiController extends Controller
{

   public function checkMien($codeA,$codeB){
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
       $data = [$cca,$ccb];
       return $data;
   }

	public function checkRangeMien($cca ,$ccb) {
		// $mien =[
  //  		'1' => [80,82,83,84,86,87,89,91,92,93,94,95,96],
  //  		'2' => [79,74,70,72,75,77],
  //  		'3' => [48,49,51,52,54,56,58,60] ,
  //  		'4' => [62,64,66,67,68],
  //  		'5' => [38,40,44,45,46,42],
  //  		'6' => [1,26 ,27 ,33 , 35 ,30 ,31 ,34 ,36 ,37],
  //  		'7' => [12 , 11 ,15 ,14 ,17 ,10],
  //  		'8' => [2,4,8 ,6 ,20,19 ,24,22 ,25],
 	// 	  ];	
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

       // if($codeA == $codeB) return 999 ;

 		 $phi = 0;
 		 // $cca = -1;
 		 // $ccb = -1;
 		 // foreach ($mien as $key => $value) {
 		 // 	foreach ($value as $aab => $element) {
 		 // 		if ($element == $codeA ) {$cca=$key ;}
 		 // 		if ($element == $codeB ) {$ccb=$key ;}

 		 // 		if( ($cca >0) && ($ccb>0)) {
 		 // 			break;
 		 // 		}

 		 // 	}
 		 // }

 		if($cca == $ccb) return 0 ;

 		foreach ($bbs as $key => $value) {
 			if( in_array($cca, $value) && in_array($ccb, $value) ) return ($value[2]/100);
 		}
 		return -1;
	}

   public function checkRangeTinh($codeA , $codeB) {

      $cuc1 = [
         [96,80,400] , [87,89,83,91,94,95,84,200],[96,87,82,83,300],
         [91,94,95,80,300],[89,93,94,92,96,80,200] 
      ];
      $tinh = [
         '1' => '',
      ];
   }
   public function test() {
      $data = $this->checkMien(79,80);
      dd($data);
   }
   
}
