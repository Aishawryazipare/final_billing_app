<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Admin extends Authenticatable
    {
        use Notifiable;
        
        
        protected $primaryKey = "rid";
        public $table = "bil_Registration";
        public $timestamps=false;

//        protected $guard = 'admin';

        protected $fillable = [
            'reg_companyname', 'reg_personname', 'reg_mobileno','reg_emailid' ,'reg_address' ,'reg_username' ,'password' 
            ,'reg_companyid' ,'reg_dealercode' ,'created_at' ,'modified_at' ,'permission', 'is_active',
            'location','permission','reg_userpassword','activate_flag','upload_logo'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
        
//        public function getAuthPassword()
//        {
//            return $this->reg_userpassword;
//        }
    }
    
    