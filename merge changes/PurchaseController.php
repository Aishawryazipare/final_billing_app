<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Item;
use App\Inventory;
use App\Category;
use App\Dealer;
use App\Machine;
use App\Subscription;
use Session;
class PurchaseController extends Controller
{
    
    public function getInventory()
    {
        return view('purchase.add_inventory');
    }
    public function getItemid(Request $request) {
       $item_id=$request['inventoryitemid'];
       $result= Item::select('item_id')->where('item_id','=',$item_id)->first();
       if(!empty($result))
       {
            echo json_encode("present");
       }
       else
       {
           echo json_encode("not present");
       }
    }
    public function addInventory(Request $request) {
        echo "<pre>";
        $requestData = $request->all();
        $item_id=$requestData['inventoryitemid'];
        $status=$requestData['inventorystatus'];
        $item_quantity=$requestData['inventoryitemquantity'];
        Inventory::create($requestData);
        $result= Item::select('item_stock')->where('item_id','=',$item_id)->first();
        if(!empty($result))
        {
            $item_stock=$result['item_stock'];
            if($status=="add")
            {
                $item_stock=$item_stock+$item_quantity;
            }
            elseif ($status=="substract")
            {
                $item_stock=$item_stock-$item_quantity;
            }
            else
            {
                $item_stock=$item_quantity;
            }
        }
        Item::find($item_id)->update(['item_stock' => $item_stock]);
        Session::flash('alert-success','Added Successfully.');
        return redirect('inventory');
    }  
}