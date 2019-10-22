<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryStatus extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_enquiry_status";
     public $timestamps=false;
     protected $fillable = [
        'status_name','created_at' ,'modify_at','is_active','lid','cid','emp_id'
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
