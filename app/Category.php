<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "cat_id";
    public $table = "bil_category";
    public $timestamps=true;
    protected $fillable = [
        'cat_name','cat_description','cat_image','type_id','user_id','is_active','cid','lid','emp_id','sync_flag'
    ];
}
