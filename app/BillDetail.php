<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    public $table = "bil_AddBillDetail";
    public $timestamps=false;
    protected $fillable = [
        'bill_no','item_name','item_qty','item_rate','discount','bill_tax','item_totalrate','created_at_TIMESTAMP','updated_at_TIMESTAMP','isactive','lid','cid','emp_id'
    ];
}
