<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $primaryKey = "id";
    public $table = "bil_payement_type";
   // public $timestamps=true;
    protected $fillable = [
        'payment_type','is_active','cid','lid','emp_id','sync_flag'
    ];
}
