<?php

namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Dealers extends Authenticatable
    {
//        use Notifiable;
        
        protected $table = 'tbl_dealers';
//        protected $guard = 'dealer';

        protected $fillable = [
            'name', 'email', 'password','role','mobile_no','address','is_active','cid','lid','sub_emp_id'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
    }
