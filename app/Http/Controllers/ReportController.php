<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
    
    public function getSale()
    {
        return view('reports.sale_report');
    }
    public function fetchSale(Request $request)
    {
         $requestData = $request->all();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
            $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                      ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
         }
          else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            
            // echo $client_data->location."".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                 $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$id])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
//                echo "Lid".$lid."<br/>CID: ".$cid."<br/>Emp ID: ".$emp_id."<br/>Sub Emp ID: ".$sub_emp_id."<br>";
//                    echo "in if";echo $emp_id;
                if($sub_emp_id != "")
                {
                 //   echo "in sub if";
                    
                    $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
            $i=1;
            $tdata='';
           
         foreach($bill_data as $data)
         {
             $tdata.='<tr>';
             $tdata.='<td>'.$i.'</td>';
             $tdata.='<td>'.$data->bill_no.'</td>';
             $tdata.='<td>'.$data->bill_totalamt.'</td>';
             $tdata.='<td>'.$data->cash_or_credit.'</td>';
             $tdata.='</tr>';
             $i++;
         }
         
         echo $tdata;
         
    }
    public function downloadSale(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
       
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
          $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
            $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                      ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
         }
          else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            
            // echo $client_data->location."".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                 $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$id])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
//                echo "Lid".$lid."<br/>CID: ".$cid."<br/>Emp ID: ".$emp_id."<br/>Sub Emp ID: ".$sub_emp_id."<br>";
//                    echo "in if";echo $emp_id;
                if($sub_emp_id != "")
                {
                 //   echo "in sub if";
                    
                    $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('tbl_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
         return view('reports.download_sales_report',['bill_data'=>$bill_data]);
    }
    public function getInventory()
    {
        return view('reports.inventory_report');
    }
    
    public function fetchInventory(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        $i=1;
		
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
         
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid])
                     ->get();
        }else if(Auth::guard('web')->check()){
            $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->get();
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
            $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
                 }
                 else
                 {
                     $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
                   $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
             }
    
            
        }  
        
        $tdata='';
           
        foreach($bill_data as $data)
        {
            $tdata.='<tr>';
            $tdata.='<td>'.$i.'</td>';
            $tdata.='<td>'.$data->inventorysupid.'</td>';
            $tdata.='<td>'.$data->inventoryitemid.'</td>';
            $tdata.='<td>'.$data->inventoryitemquantity.'</td>';
            $tdata.='<td>'.$data->inventorystatus.'</td>';
            $tdata.='</tr>';
            $i++;
        }
         
         echo $tdata;
         
    }
    public function DownloadInventory(Request $request)
    {
         $requestData = $request->all();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
         
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $inventory_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid])
                     ->get();
        }else if(Auth::guard('web')->check()){
            $inventory_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->get();
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
            $bill_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $inventory_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
                 }
                 else
                 {
                     $inventory_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
                   $inventory_data = DB::table('tbl_inventory')
                     ->select('tbl_inventory.*','tbl_AddItems.item_name as inventoryitemid')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','=','tbl_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['tbl_inventory.cid'=>$cid,'tbl_inventory.lid'=>$lid])
                     ->get();
             }
    
            
        } 
         
         
         return view('reports.download_inventory_report',['inventory_data'=>$inventory_data]);
    }
      public function getItem()
    {
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','cid'=>$id])->get();
         }else if(Auth::guard('web')->check()){
             $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0'])->get();
         } else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
             if($client_data->location == "single" && $role == 2)
            {
                 $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])->orderBy('item_name', 'asc')->get();   
             }
             else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                   $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                                ->orWhere(['emp_id'=>$sub_emp_id])
                                ->orWhere(['emp_id'=>$emp_id])
                                ->orderBy('item_name', 'asc')
                                ->get();    
                }
                else
                {
                          $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
                }
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                    $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
            }
            }
        return view('reports.item_report',['item_data'=>$item_data]);
    }
    public function downloadItem(Request $request)
    {
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','cid'=>$id])->get();
         }else if(Auth::guard('web')->check()){
             $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0'])->get();
         }else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
             if($client_data->location == "single" && $role == 2)
            {
                 $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])->orderBy('item_name', 'asc')->get();   
             }
             else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                   $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                                ->orWhere(['emp_id'=>$sub_emp_id])
                                ->orWhere(['emp_id'=>$emp_id])
                                ->orderBy('item_name', 'asc')
                                ->get();    
                }
                else
                {
                          $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
                }
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                    $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
            }
            }
            return view('reports.download_item_report',['item_data'=>$item_data]);
    }
    
    public function getItemSale()
    {
        return view('reports.item_sale_report');
    }
    
    public function fetchItemSale(Request $request)
    {
         $requestData = $request->all();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
        $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id])
                                      ->orderBy('item_name')
                                     ->get();
         }else if(Auth::guard('web')->check())
         {
             $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->orderBy('item_name')
                                     ->get();
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
                 $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid])
                                      ->orderBy('item_name')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get();
                 }
                 else
                 {
                         $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get(); 
                 }
            }
            else if($client_data->location == "multiple" && $role == 1)
                {
                 $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get();
            }
            
              
           }
            $i=1;
            $tdata='';
           
         foreach($bill_data as $data)
         {
             $tdata.='<tr>';
             $tdata.='<td>'.$i.'</td>';
             $tdata.='<td>'.$data->item_name.'</td>';
             $tdata.='<td>'.$data->item_qty.'</td>';
             $tdata.='<td>'.$data->item_rate.'</td>';
             $tdata.='</tr>';
             $i++;
         }
         
         echo $tdata;
         
    }
    public function downloadItemSale(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
       
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
            if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id])
                                      ->orderBy('item_name')
                                     ->get();
         }else if(Auth::guard('web')->check())
         {
             $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->orderBy('item_name')
                                     ->get();
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
                 $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid])
                                      ->orderBy('item_name')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get();
                 }
                 else
                 {
                         $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get(); 
                 }
            }
            else if($client_data->location == "multiple" && $role == 1)
                {
                 $bill_data = DB::table('tbl_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid])
                                      ->orderBy('item_name')
                                     ->get();
            }
            
              
           }
         return view('reports.download_item_sales_report',['bill_data'=>$bill_data]);
    }
    

    
}