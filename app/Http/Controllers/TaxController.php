<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth.basic');
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    public function getTax()
    {
        $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$cid])->get();
//          echo "<pre/>";print_r();exit;
        }
        return view('reports.tax_bill_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
    public function fetchTax(Request $request)
    {
         $requestData = $request->all();
         $total_amount=0;
         $result=array();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
              $cid = $this->admin->rid;
              if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                        if(isset($requestData['employee']))
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->selectRaw('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                        else
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                     
                  }
                  else
                  {
                      if(isset($requestData['employee']))
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$requestData['employee'],'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      else
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      
                  }
              }
            else {
                   if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
                   else
                   {
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
              
            }
 
           
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['gst_setting'=>"Yes"])
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
                 $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
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
                    
                    $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
            $i=1;
            $result_final=array();
         foreach($bill_data as $data)
         {
             $total_amount = $total_amount + $data->bill_totalamt;
              $bill_detail_data= $bill_data = DB::table('bil_AddBillDetail')
                                        ->selectRaw('sum(discount) as total_discount')
                                        ->selectRaw('sum(item_rate) as total_rate')
                                        ->selectRaw('sum(bill_tax) as total_tax')
                                        ->where(['bill_no'=>$data->bill_no,'isactive'=>0])
                                        ->first();
             $result_data['bill_no']=$data->bill_no;
             $result_data['total_rate']=$bill_detail_data->total_rate;
             $result_data['total_discount']=$bill_detail_data->total_discount;
             $result_data['total_tax']=$bill_detail_data->total_tax;
             $result_data['total_amount']=$data->bill_totalamt;
            
             array_push($result_final, $result_data);
         }
         $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }
    public function getEmployee()
    {
        $lid=$_GET['location'];
        $sdata='';
        if(Auth::guard('admin')->check()){
              $cid = $this->admin->rid;
        }
        if($lid=="all")
        $result_data =\App\Employee::select('*')->where(['cid'=>$cid,'is_active'=>'0'])->get();
        else
        $result_data =\App\Employee::select('*')->where(['lid'=>$lid,'is_active'=>'0'])->get();
        $sdata.='<option value="">---Select Employee---</option>';
        foreach($result_data as $data)
        {
            $sdata.='<option value="'.$data->id.'">'.$data->name.'</option>';
        }
        echo $sdata;
    }

    public function downloadTaxBill(Request $request)
    {
        $requestData = $request->all();
        $from_date = $requestData["from_date"];
       
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
          $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
       //  echo "<pre/>";print_r($requestData);exit;
         if(Auth::guard('admin')->check()){
               $cid = $this->admin->rid;
                 $cid = $this->admin->rid;
              if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                 if($lid=="all")
                  {
                        if(isset($requestData['employee']))
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                        else
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                     
                  }
                  else
                  {
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                  }
              }
            else {
                    if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
                   else
                   {
                        $bill_data = DB::table('bil_AddBillMaster')
                             ->select(['*'])
                               ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        
                        
                      /*$bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->leftjoin(['bil_AddDetail','bil_AddDetail.bill_no','=','bil_AddBillMaster.bill_no'])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();*/
                   }
                 //  echo "<pre/>";print_r($bill_data);exit;
            }
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('bil_AddBillMaster')
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
                 $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0,'gst_setting'=>"Yes"])
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
                    
                    $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0,'gst_setting'=>"Yes"])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
         return view('reports.download_bill_tax_report',['bill_data'=>$bill_data,'cid'=>$cid,'from_date'=>$requestData['from_date'],'to_date'=>$requestData['to_date']]);
    }
    public function getBillDetail()
    {
         $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$cid])->get();
        }
        return view('reports.tax.bill_detail_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
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
            $cid = $this->admin->rid;
            if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                      if(isset($requestData['employee']))
                      {
                          $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.emp_id'=>$requestData['employee']])
                     ->get();
                      }
                      else
                      {
                          $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid])
                     ->get();
                      }
                      
                  }
                  else {
                       if(isset($requestData['employee']))
                      {
                          $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid,'bil_inventory.emp_id'=>$requestData['employee']])
                     ->get();
                      }
                      else
                      {
                          $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->get();
                      }
                      
                  }
              }
              else
              {
                  if(isset($requestData['employee']))
                  {
                          $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.emp_id'=>$requestData['employee']])
                     ->get();
                  }
                  else{
                  $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid])
                     ->get();
                  }
              }
            
        }else if(Auth::guard('web')->check()){
            $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
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
            $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->get();
                 }
                 else
                 {
                     $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
                   $bill_data = DB::table('bil_inventory')
                     ->select('bil_inventory.*','bil_AddItems.item_name as inventoryitemid')
                     ->leftjoin('bil_AddItems','bil_AddItems.item_id','=','bil_inventory.inventoryitemid')
                     ->whereBetween('created_at', [$from_date, $to_date])
                     ->where(['bil_inventory.cid'=>$cid,'bil_inventory.lid'=>$lid])
                     ->get();
             }
    
            
        }  
        
        $tdata='';
        $result_final=array();
        foreach($bill_data as $data)
        {
            $supplier_data= \App\Supplier::select('*')->where(['sup_id'=>$data->inventorysupid])->first();
            $result_data['sup_name']=$supplier_data->sup_name;
            $result_data['inventoryitemid']=$data->inventoryitemid;
            $result_data['inventoryitemquantity']=$data->inventoryitemquantity;
            $result_data['inventorystatus']=$data->inventorystatus;
             if(isset($requestData['location']))
             {
             $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
             $result_data['loc_name']=$location_data->loc_name;
             }
             else
             {
                 $result_data['loc_name']='Own';
             }
              $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
             if(empty($user_data))
             {
                $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
              $result_data['user']=$user_data->reg_personname;  
             }
            else
            $result_data['user']=$user_data->name;  
            array_push($result_final,$result_data);
            $i++;
        }
         
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }
    public function DownloadBillDetail(Request $request)
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
            $cid = $this->admin->rid;
               if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                      if(isset($requestData['employee']))
                      {
                         $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                     ->get();
                      }
                      else
                      {
                       $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->where(['cid'=>$cid,'isactive'=>0])
                     ->get();
                      }
                      
                  }
                  else {
                      $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                     ->get();
                  }
              }
              else
              {
            if(isset($requestData['employee']))
                  {
                         $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
             ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                     ->get();
                  }
                  else{
                  $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'isactive'=>0])
                     ->get();
                  }
              }
        }else if(Auth::guard('web')->check()){
            $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->get();
        }
        else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
//            echo $client_data->location."&".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->where(['cid'=>$cid,'isactive'=>0])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                     ->get();
                 }
                 else
                 {
                 $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                      ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
                  $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                     ->get();
             }
    
            
        }  
         //echo "<pre/>";print_r($bill_data);exit;
         
         return view('reports.tax.download_bill_report',['bill_data'=>$bill_data,'cid'=>$cid,'from_date'=>$requestData['from_date'],'to_date'=>$requestData['to_date']]);
    }
      public function getTaxSlab()
    {
            $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$cid])->get();
        }
        return view('reports.tax.tax_slab_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
     public function fetchTaxSlab(Request $request)
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
            $cid = $this->admin->rid;
               if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                      if(isset($requestData['employee']))
                      {
                    $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])   
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.emp_id'=>$requestData['employee']])
                     ->get();
                      }
                      else
                      {
                       $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                      ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
                      }
                      
                  }
                  else {
                      $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                  }
              }
              else
              {
            if(isset($requestData['employee']))
                  {
                   $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.emp_id'=>$requestData['employee']])
                     ->get();
                  }
                  else{
                 $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
                  }
              }
        }else if(Auth::guard('web')->check()){
            $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->get();
        }
        else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
//            echo $client_data->location."&".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])    
                     ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                    $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                 }
                 else
                 {
                $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                      ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
              $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
             }
    
            
        }  
//         echo "<pre/>";print_r($bill_data);exit;
         
         echo json_encode($bill_data);
    }
    
      public function downloadTaxSlab(Request $request)
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
            $cid = $this->admin->rid;
               if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                      if(isset($requestData['employee']))
                      {
                    $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])   
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.emp_id'=>$requestData['employee']])
                     ->get();
                      }
                      else
                      {
                       $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                      ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
                      }
                      
                  }
                  else {
                      $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                  }
              }
              else
              {
            if(isset($requestData['employee']))
                  {
                   $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.emp_id'=>$requestData['employee']])
                     ->get();
                  }
                  else{
                 $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
                  }
              }
        }else if(Auth::guard('web')->check()){
            $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillMaster.*')
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                    ->get();
        }
        else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
//            echo $client_data->location."&".$role;exit;
            if($client_data->location == "single" && $role == 2)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])    
                     ->where(['bil_AddBillMaster.cid'=>$cid])
                     ->get();
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                    $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                 }
                 else
                 {
                $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                      ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
                 }
             }
             else if($client_data->location == "multiple" && $role == 1)
                {
              $bill_data = DB::table('bil_AddBillMaster')
                     ->select('bil_AddBillDetail.discount')
                      ->selectRaw('sum(bil_AddBillDetail.bill_tax) as tax_total')
                     ->leftjoin('bil_AddBillDetail','bil_AddBillDetail.bill_no','=','bil_AddBillMaster.bill_no')
                     ->groupBy('bil_AddBillDetail.discount')     
                     ->whereBetween('bil_AddBillMaster.bill_date', [$from_date, $to_date])
                     ->where(['bil_AddBillMaster.cid'=>$cid,'bil_AddBillMaster.lid'=>$lid])
                     ->get();
             }
    
            
        }  
//         echo "<pre/>";print_r($bill_data);exit;
         
         return view('reports.tax.download_tax_slab_report',['bill_data'=>$bill_data,'cid'=>$cid,'from_date'=>$requestData['from_date'],'to_date'=>$requestData['to_date']]);
    }
    
    public function getItemSale()
    {
            $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$cid])->get();
        }
        return view('reports.item_sale_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
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
             if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                      if(isset($requestData['employee']))
                      {
                          $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                      }
                      else
                      {
                         $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get(); 
                      }
                  }
                  else
                  {
                       if(isset($requestData['employee']))
                      {
                           $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'lid'=>$lid,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                      }
                      else
                      {
                           $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                      }
                  }
              }
              else
              {
                  if(isset($requestData['employee']))
                  {
                       $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                  }
                  else
                  {
                      $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get(); 
                  }
                  
              }
        
         }else if(Auth::guard('web')->check())
         {
             $bill_data = DB::table('bil_AddBillDetail')
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
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid,'isactive'=>0])->first();
            if($client_data->location == "single" && $role == 2)
            {
                 $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                 }
                 else
                 {
                         $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get(); 
                 }
            }
            else if($client_data->location == "multiple" && $role == 1)
                {
                 $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
            }
            
              
           }
            $i=1;
            $tdata='';
           $total_amount=0;
            $result_final=array();
         foreach($bill_data as $data)
         {
             
             $result_data['item_name']=$data->item_name;
             $item_data= \App\Item::select('*')->where(['item_name'=>$data->item_name])->first();
             $result_data['icode']=$item_data->item_id;
             $result_data['item_qty']=$data->item_qty;
             $result_data['item_rate']=$data->item_rate;
             $result_data['item_totalrate']=$data->item_totalrate;
                        if(isset($requestData['location']))
             {
             $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
             $result_data['loc_name']=$location_data->loc_name;
             }
             else
             {
                 $result_data['loc_name']='Own';
             }
              $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
             if(empty($user_data))
             {
                $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
              $result_data['user']=$user_data->reg_personname;  
             }
            else
            $result_data['user']=$user_data->name;  
            array_push($result_final,$result_data);
             $total_amount=$total_amount+$data->item_totalrate;
             
             $i++;
         }
         
          $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
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
                   if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                       $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                  }
                  else
                  {
                       $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                  }
              }
              else
              {
                  if(isset($requestData['employee']))
                  {
                       $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'emp_id'=>$requestData['employee'],'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                  }
                  else
                  {
                      $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$id,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get(); 
                  }
              }
         }else if(Auth::guard('web')->check())
         {
             $bill_data = DB::table('bil_AddBillDetail')
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
                 $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                 if($sub_emp_id != "")
                {
                     $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
                 }
                 else
                 {
                         $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get(); 
                 }
            }
            else if($client_data->location == "multiple" && $role == 1)
                {
                 $bill_data = DB::table('bil_AddBillDetail')
                                     ->select('*')
                                     ->whereBetween('created_at_TIMESTAMP', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>0])
                                      ->orderBy('item_name')
                                     ->get();
            }
            
              
           }
         return view('reports.download_item_sales_report',['bill_data'=>$bill_data]);
    }
     public function getCancelSale()
    {
        $location_data=$employee_data='';
        if(Auth::guard('admin')->check()){
          $cid = $this->admin->rid;   
          if($this->admin->location=="multiple")
          {
               $location_data= \App\EnquiryLocation::select('*')->where(['cid'=>$cid])->get();
          }
         
          $employee_data= \App\Employee::select('*')->where(['cid'=>$cid])->get();
//          echo "<pre/>";print_r();exit;
        }
        return view('reports.cancel_sale_report',['location_data'=>$location_data,'employee_data'=>$employee_data]);
    }
    public function fetchCancelSale(Request $request)
    {
         $requestData = $request->all();
         $total_amount=0;
         $result=array();
        $from_date = $requestData["from_date"];
        if(!empty($requestData["to_date"]))
         $to_date = $requestData["to_date"];
        else
          $to_date = $from_date;
        
         $from_date = date($from_date . ' 00:00:00', time());
         $to_date   = date($to_date . ' 22:00:40', time());
           
         if(Auth::guard('admin')->check()){
              $cid = $this->admin->rid;
              if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                  if($lid=="all")
                  {
                        if(isset($requestData['employee']))
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                        else
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                     
                  }
                  else
                  {
                      if(isset($requestData['employee']))
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$requestData['employee'],'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      else
                      {
                           $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                      }
                      
                  }
              }
            else {
                   if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
                   else
                   {
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
              
            }
 
           
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('bil_AddBillMaster')
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
                 $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>1])
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
                    
                    $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
            $i=1;
            $result_final=array();
         foreach($bill_data as $data)
         {
             $total_amount = $total_amount + $data->bill_totalamt;
             $result_data['bill_no']=$data->bill_no;
             $customer_data= \App\Customer::select('*')->where(['cust_id'=>$data->cust_id])->first();
             if(!empty($customer_data))
              $result_data['cust_name']=$customer_data->cust_name;
             else
               $result_data['cust_name']='';
            
             $result_data['bill_totalamt']=$data->bill_totalamt;
             $result_data['cash_or_credit']=$data->cash_or_credit;
             if(isset($requestData['location']))
             {
             $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
            $result_data['loc_name']=$location_data->loc_name;
             }
             else
             {
                  $result_data['loc_name']='Own';
             }
             $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
             if(empty($user_data))
             {
                $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
              $result_data['user']=$user_data->reg_personname;  
             }
            else
            $result_data['user']=$user_data->name;  
             array_push($result_final, $result_data);
         }
         $result['amount']=round($total_amount,2);
         $result['other_data']=$result_final;
         echo json_encode($result);
         
    }
    public function downloadCancelSale(Request $request)
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
               $cid = $this->admin->rid;
                 $cid = $this->admin->rid;
              if(isset($requestData['location']))
              {
                 
                  $lid=$requestData['location'];
                 //  echo $lid;exit;
                 if($lid=="all")
                  {
                        if(isset($requestData['employee']))
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                        else
                        {
                             $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>0])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                        }
                     
                  }
                  else
                  {
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                  }
              }
            else {
                    if(isset($requestData['employee']))
                   {
                          $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'emp_id'=>$requestData['employee'],'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
                   else
                   {
                       $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                   }
            }
         
         }
         else if(Auth::guard('web')->check()){
             $bill_data = DB::table('bil_AddBillMaster')
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
                 $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                    ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'isactive'=>1])
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
                    
                    $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
        
                }
                else
                {
                      $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                $bill_data = DB::table('bil_AddBillMaster')
                                     ->select('*')
                                      ->whereBetween('bill_date', [$from_date, $to_date])
                                     ->where(['cid'=>$cid,'lid'=>$lid,'isactive'=>1])
                                     ->orderBy('bill_date')
                                     ->orderBy('bill_no')
                                     ->get();
             }
          }
         return view('reports.download_cancel_sales_report',['bill_data'=>$bill_data]);
    }

    
}