<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = "sub_id";
    public $table = "tbl_subscription";
    public $timestamps=true;
    protected $fillable = [
        'sub_name','sub_users_no','sub_price','is_active','cid','lid','emp_id'
    ];
}


