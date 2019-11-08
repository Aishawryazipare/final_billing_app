<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    protected $primaryKey = "bill_no";
    public $table = "bil_AddBillMaster";
    public $timestamps=false;
    protected $fillable = [
        'bill_date','cust_id','cash_or_credit','discount','bill_totalamt','bill_tax','created_at_TIMESTAMP','updated_at_TIMESTAMP','isactive','lid','cid','emp_id'
    ];
}
