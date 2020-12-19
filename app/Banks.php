<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = 'banklist';

    protected $fillable = [
    	'list_bankList_MaNganHang',
    	'list_bankList_TenNH',
    	'list_bankList_province_branch_MaChiNhanh',
    	'list_bankList_province_Code',
    	'list_bankList_province_branch_TenChiNhanh'
    ];
}
