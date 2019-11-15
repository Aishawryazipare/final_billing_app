<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = "item_id";
    public $table = "bil_AddItems";
    public $timestamps=false;
    protected $fillable = [
       'item_date', 'item_name','item_rate','item_dis','item_disrate','item_tax','item_taxvalue','item_final_rate','item_category','item_units','item_stock','item_barcode','item_hsncode','is_active',
        'cid','lid','emp_id','sync_flag'
    ];
}
