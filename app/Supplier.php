<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = "sup_id";
    public $table = "bil_AddSupplier";
    public $timestamps=true;
    protected $fillable = [
        'sup_name','sup_address','sup_mobile_no','sup_email_id','sup_gst_no','is_active','cid',
        'lid','emp_id','sync_flag'
    ];
}
