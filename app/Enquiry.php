<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "enquiry_id";
    public $table = "tbl_enquiry";
     public $timestamps=false;
     protected $fillable = [
        'enquiry_no','mobile_no', 'customer_name', 'email','address','city_id','product_id' ,'assign_to_emp_id' ,'status_id' ,'follow_up' ,'create_at' ,'modify_at','is_active',
         'source','source_val','followup_date','emp_id','sync_flag','insert_date','active_inactive_status',
         'cat_id','brand_id','cid','lid','sub_emp_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}
