<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
             DB::table('status')->insert([
            'value' => "Chờ Duyệt",    	
       		]);
             DB::table('status')->insert([
            'value' =>"Chờ Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đã Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Lấy Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Không Lấy Được",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Nhập Kho",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đã Nhập Kho",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Chuyển Kho Giao",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đã Chuyển Kho Giao",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Giao Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' =>  "Đã Giao Hàng Toàn Bộ",    	
       		]);
             DB::table('status')->insert([
            'value' =>"Đã Giao Hàng Một Phần",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Giao Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Không Giao Được",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đã Đối Soát Giao Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đã Đối Soát Trả Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Chuyển Kho Trả",    	
       		]);
             DB::table('status')->insert([
            'value' =>  "Đang Trả Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' =>  "Đã Trả Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Hoãn Trả Hàng",    	
       		]);
             DB::table('status')->insert([
            'value' => "Huỷ",    	
       		]);
             DB::table('status')->insert([
            'value' => "Đang Vận Chuyển",    	
       		]);
              DB::table('status')->insert([
            'value' => "Xác Nhận Hoàn",    	
       		]);
            DB::table('status')->insert([
            'value' => "Đã Hủy",         
                  ]);




    }
}
