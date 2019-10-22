<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = "inventoryid";
    public $table = "tbl_inventory";
    public $timestamps=false;
    protected $fillable = [
        'inventorysupid','inventoryitemid','inventoryitemquantity','inventorystatus','isactive'
    ];
}
