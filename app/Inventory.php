<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = "inventoryid";
    public $table = "bil_inventory";
    public $timestamps=false;
    protected $fillable = [
        'inventorysupid','inventoryitemid','inventoryitemquantity','inventorystatus','isactive','cid','lid','emp_id','sync_flag'
    ];
}
