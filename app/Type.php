<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $primaryKey = "Unit_Id";
    public $table = "bil_AddIUnits";
    public $timestamps=true;
    protected $fillable = [
        'Unit_name','Unit_Taxvalue','is_active','cid','lid','emp_id','sync_flag'
    ];
}
