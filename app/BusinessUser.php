<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessUser extends Authenticatable
{

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_business_users";
     protected $fillable = [
        'name', 'email', 'password' ,'organization' ,'gst_no' ,'pan_no' ,'contact_no' ,'address' ,'type' ,'category' ,'owner' , 'is_active'
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
