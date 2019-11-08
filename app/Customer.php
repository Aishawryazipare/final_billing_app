<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = "cust_id";
    public $table = "bil_Addcustomer";
    public $timestamps=true;
    protected $fillable = [
        'cust_CompanyName','cust_name','address','mobile_no','email_id','cust_companyId_or_GST','is_active',
        'cid','lid','emp_id','sync_flag'
    ];
}
