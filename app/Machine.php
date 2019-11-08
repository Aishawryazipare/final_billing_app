<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $primaryKey = "machine_id";
    public $table = "bil_machine_data";
    public $timestamps=true;
    protected $fillable = [
        'machine_model_no','machine_ser_no','is_active'
    ];
}
