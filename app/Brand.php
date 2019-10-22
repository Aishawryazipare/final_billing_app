<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = "brand_id";
    public $table = "tbl_brand";
    public $timestamps=false;
    protected $fillable = [
        'brand_name','cat_id','created_at','modify_at','is_active','cid','lid','emp_id'
    ];
}
