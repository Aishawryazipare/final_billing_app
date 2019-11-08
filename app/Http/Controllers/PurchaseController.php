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
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct()
    {
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
     public function getInventory()
    {
		$flag=0;
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
			$flag=1;
            $supplier_data= \App\Supplier::select('sup_id','sup_name')->where(['is_active'=>0,'cid'=>$id])->get();
            $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$id])->get();
            $inventory_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid','bil_AddSupplier.sup_name as inventorysupid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->leftjoin('bil_AddSupplier','bil_AddSupplier.sup_id','=','bil_inventory.inventorysupid')
                     ->where(['bil_inventory.cid'=>$id])
                     ->orderby('bil_AddSupplier.sup_id','desc')
                     ->get();
//            $inventory_data= Inventory::leftjoin('tbl_')->select('*')->where(['cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $supplier_data= \App\Supplier::select('sup_id','sup_name')->get();
            $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2)
            {   
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                $supplier_data= \App\Supplier::select('sup_id','sup_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                 $inventory_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid','bil_AddSupplier.sup_name as inventorysupid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->leftjoin('bil_AddSupplier','bil_AddSupplier.sup_id','=','bil_inventory.inventorysupid')
                     ->where(['bil_inventory.cid'=>$cid])
                     ->orderby('bil_AddSupplier.sup_id','desc')
                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                $supplier_data= \App\Supplier::select('sup_id','sup_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                 $inventory_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid','bil_AddSupplier.sup_name as inventorysupid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->leftjoin('bil_AddSupplier','bil_AddSupplier.sup_id','=','bil_inventory.inventorysupid')
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->orderby('bil_AddSupplier.sup_id','desc')
                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
				$flag=1;
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                $supplier_data= \App\Supplier::select('sup_id','sup_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                 $inventory_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid','bil_AddSupplier.sup_name as inventorysupid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->leftjoin('bil_AddSupplier','bil_AddSupplier.sup_id','=','bil_inventory.inventorysupid')
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->orderby('bil_AddSupplier.sup_id','desc')
                     ->get();
            }
        }
//        echo "<pre>";
//        print_r($product_data);
//        exit;
//        $supplier_data= \App\Supplier::select('sup_id','sup_name')->get();
        return view('purchase.add_inventory',['supplier_data'=>$supplier_data,'product_data'=>$product_data,'flag'=>$flag,'inventory_data'=>$inventory_data]);
    }
    
    public function getItemid(Request $request) {
        $item_id=$request['inventoryitemid'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $result = Item::select('item_id')->where('item_id','=',$item_id)->where(['is_active'=>0,'cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $result= Item::select('item_id')->where('item_id','=',$item_id)->where(['is_active'=>0])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $result= Item::select('item_id')->where('item_id','=',$item_id)->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first();
        } 
       
       
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
        $requestData = $request->all();
        $item_id=$requestData['inventoryitemid'];
        $status=$requestData['inventorystatus'];
		$requestData['sync_flag']=0;
        $item_quantity=$requestData['inventoryitemquantity'];
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
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
        Item::find($item_id)->update(['item_stock' => $item_stock,'sync_flag' => 0]);
        Session::flash('alert-success','Added Successfully.');
        return redirect('inventory');
    }  
}