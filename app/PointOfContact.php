<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointOfContact extends Model
{
    protected $primaryKey = "id";
    public $table = "bil_point_of_contact";
    public $timestamps=true;
    protected $fillable = [
        'point_of_contact','is_active','cid','lid','emp_id','sync_flag'
    ];
}
