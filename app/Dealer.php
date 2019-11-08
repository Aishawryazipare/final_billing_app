<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Dealer extends Authenticatable
    {
        use Notifiable;
        
        protected $table = 'bil_dealer';
        protected $guard = 'dealer';
        
        protected $primaryKey = "dealer_id";
        public $timestamps=true;
        
        protected $fillable = [
            'owner_name','password','dealer_name','dealer_mobile_no','email','dealer_address','dealer_state','dealer_gst_no',
        'dealer_city','dealer_code','is_active'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
    }
