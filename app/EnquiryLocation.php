<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryLocation extends Model
{
    protected $primaryKey = "loc_id";
    public $table = "bil_location";
    protected $fillable = [
        'loc_name','cid','user_id','is_active'
    ];
}
