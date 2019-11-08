<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;
use PDF;
class SalesController extends Controller
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
    public function getThumb()
    {
         if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
         $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '1','bil_category.cid'=>$id])
                ->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$id])->first();
          $bill_data = \App\BillMaster::select('bill_no')->where(['cid'=>$id])->orderBy('bill_no','desc')->first();
         }else if(Auth::guard('web')->check()){
             $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '1'])
                ->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::first();
          $bill_data = \App\BillMaster::select('bill_no')->orderBy('bill_no','desc')->first();
         }else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2)
            {
                 //echo "in else";exit;
                $category = DB::table('bil_category')
                ->select('bil_category.*','bil_type.type_name')
                ->leftjoin('bil_type','bil_type.type_id','=','bil_category.type_id')
                ->where(['bil_category.is_active' => '1','bil_category.cid'=>$cid])
                ->orderBy('bil_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$cid])->first();
          $bill_data = \App\BillMaster::select('bill_no')->where(['cid'=>$cid])->orderBy('bill_no','desc')->first();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                //echo "in else";exit;
                if($sub_emp_id != "")
                {
                    
                    $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '1', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->first();
                    $bill_data = \App\BillMaster::select('bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orWhere(['emp_id' => $sub_emp_id])
                            ->orWhere(['emp_id' => $emp_id])
                            ->orderBy('bill_no', 'desc')
                            ->first();
                }
                else
                {
                    $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '1', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                            ->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->first();
                    $bill_data = \App\BillMaster::select('bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orderBy('bill_no', 'desc')
                            ->first();
                }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                  $category = DB::table('bil_category')
                            ->select('bil_category.*', 'bil_type.type_name')
                            ->leftjoin('bil_type', 'bil_type.type_id', '=', 'bil_category.type_id')
                            ->where(['bil_category.is_active' => '1', 'bil_category.cid' => $cid, 'bil_category.lid' => $lid])
                            ->orderBy('bil_category.cat_name', 'asc')
                            ->get();
                    $hf_setting = \App\HeaderFooter::where(['cid' => $cid, 'lid' => $lid])
                            ->first();
                    $bill_data = \App\BillMaster::select('bill_no')->where(['cid' => $cid, 'lid' => $lid])
                            ->orderBy('bill_no', 'desc')
                            ->first();
             }
             
         }
        return view('sales.thumbnail_form',['category_data'=>$category,'bill_data'=>$bill_data,'hf_setting'=>$hf_setting]);
    }
    
    public function getItems()
    {
        $cat_id=$_GET["cat_id"];
        $bdata='';
        $j=1;
        if($cat_id==0)
        {
             if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $item_data = \App\Item::where(['is_active' => '0','cid'=>$id])->orderBy('item_name', 'asc')->get();
             }else if(Auth::guard('web')->check()){
              $item_data = \App\Item::where(['is_active' => '0'])->orderBy('item_name', 'asc')->get();   
             }
             else if(Auth::guard('employee')->check()){
           $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
         //   echo $lid;exit;
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
                               // ->orWhere(['emp_id'=>$emp_id])
                                ->orderBy('item_name', 'asc')
                                ->get();    
                }
                else
                {
                          $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
                }
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                    $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                                ->orderBy('item_name', 'asc')
                                ->get(); 
            }
            }
             
            foreach($item_data as $data)
            {
                $replaced_item = str_replace(' ', '_', $data->item_name);
                 $bdata.='<button type="button" class="btn btn-block btn-default" style="border-color:#666666;width:auto;height:68px;margin-bottom:5px;display:inline;margin-right:5px;" onclick="cal('.$data->item_final_rate.','.$data->item_id.','.$data->item_dis.','.$data->item_tax.')">'.wordwrap($data->item_name, 12, "<br/>", false).'<br/>Rs. '.$data->item_final_rate.'</button><input type="hidden" id="gitem_'.$data->item_id.'" value="'.$data->item_name.'"/>';
                $j++;

            }
        }
        else
        {
            if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$id])->get();
            }else if(Auth::guard('web')->check()){
             $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id])->get();   
            }
            else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
              $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$cid,'lid'=>$lid])->get();     
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                if($sub_emp_id != "")
                {
                     $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$cid,'lid'=>$lid])
                            ->orWhere(['emp_id'=>$sub_emp_id])
                           // ->orWhere(['emp_id'=>$emp_id])
                            ->get();    
                }
                else
                {
                     $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$cid,'lid'=>$lid])->get();
                }
              
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$cid,'lid'=>$lid])->get();
            }
            }
            foreach($item_data as $data)
            {
                $replaced_item = str_replace(' ', '_', $data->item_name);
                //$bdata.='<div class="col-sm-2" style="width:auto;"><button type="button" class="btn btn-block btn-default" style=" margin-left: -10px;border-color:#666666;width:auto;height:68px;" onclick="cal('.$data->item_final_rate.','.$data->item_id.','.$data->item_dis.','.$data->item_tax.')">'.wordwrap($data->item_name, 12, "<br/>", false).'<br/>Rs. '.$data->item_final_rate.'</button><input type="hidden" id="gitem_'.$data->item_id.'" value="'.$data->item_name.'"/></div>';
                $bdata.='<button type="button" class="btn btn-block btn-default" style="border-color:#666666;width:auto;height:68px;margin-bottom:5px;display:inline;margin-right:5px;" onclick="cal('.$data->item_final_rate.','.$data->item_id.','.$data->item_dis.','.$data->item_tax.')">'.wordwrap($data->item_name, 12, "<br/>", false).'<br/>Rs. '.$data->item_final_rate.'</button><input type="hidden" id="gitem_'.$data->item_id.'" value="'.$data->item_name.'"/>';
				$j++;

            } 
        }
       
        echo $bdata;
    }

    public function saveBill(Request $request)
    {
         $requestData = $request->all();
           if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
           }
           else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
             $requestData['lid'] = $this->employee->lid;
             $requestData['emp_id']= $this->employee->id;
           }
         $customer_data = \App\Customer::select('cust_id')->where('cust_name','=',$requestData['cust_name'])->first();
         if(!empty($customer_data))
         {
         $requestData['cust_id']=$customer_data->cust_id;
         }
         else
         {
             $cust_data=\App\Customer::create($requestData);
             $requestData['cust_id']=$cust_data->cust_id;
         }
         $requestData['bill_date']=date('Y-m-d h:i:s');
//         echo "<pre/>";print_r($requestData);exit;
         $bill_master=\App\BillMaster::create($requestData);
//           echo "<pre/>";print_r($bill_master);exit;
         foreach($requestData["stoppage"] as $data)
         {
             $requestData["bill_no"]=$bill_master->bill_no;
             $requestData["item_name"]=$data[1];
             $requestData["item_qty"]=$data[2];
             $requestData["item_rate"]=$data[3];
             $requestData["discount"]=$data[4];
             $requestData["bill_tax"]=$data[5];
             $requestData["item_totalrate"]=$data[6];
             $bill_detail=\App\BillDetail::create($requestData);
         }
         echo json_encode($bill_master);
         
    }
    public function checkItems()
    {
        
        $code = $_GET["code"];
        if(Auth::guard('admin')->check()){
            
        $id = $this->admin->rid;
        $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$id])->first();
       // echo "<pre/>";print_r($item_data);exit;
        }else if(Auth::guard('web')->check()){
           $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code])->first(); 
           //echo "<pre/>";print_r($item_data);exit;
        }
         else if(Auth::guard('employee')->check()){
               $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
           // echo $client_data->location."".$role;exit;
            if($client_data->location == "single" && $role == 2){
                //$item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first(); 
                $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid])->first(); 
            }
             else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                 //   echo "Lid".$lid."<br/>CID: ".$cid."<br/>Emp ID: ".$emp_id."<br/>Sub Emp ID: ".$sub_emp_id."<br>Item:".$code;
                  //  echo "in if";echo $emp_id;
                    $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid,'lid'=>$lid])
                            ->first(); 
                    //echo "<pre/>";                    print_r($item_data);exit;
                }
                 else
                {
                   //  echo "in else";
                     $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid,'lid'=>$lid])->first();
                 }
            }
             else if($client_data->location == "multiple" && $role == 1)
            {
                 $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid,'lid'=>$lid])->first();
             }
          //   echo "<pre/>";print_r($item_data);exit;
            
         }
        if(empty($item_data))
        {
            if(Auth::guard('admin')->check()){
        $id = $this->admin->rid;
        $item_data = \App\Item::select('*')->where(['is_active' => '0','item_name'=>$code,'cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
           $item_data = \App\Item::select('*')->where(['is_active' => '0','item_name'=>$code])->first(); 
        }
         else if(Auth::guard('employee')->check()){
             $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                -$item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid])->where('item_name','like',$code)->first(); 
            }
                       else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                    $item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                            ->where('item_name','like',$code)
                            ->first(); 
                }
                else
                {
                     $item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->where('item_name','like',$code)->first();    
                }
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
               $item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->where('item_name','like',$code)->first();     
            }
            //$item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->where('item_name','like',$code)->first(); 
         }
         // echo "<pre/>";print_r($item_data);exit;
        }
        echo  json_encode($item_data);
    }
    public function getItems1()
    {
        $query=$_GET["query"];
        $data = DB::table('bil_AddItems')
        ->where('item_name', 'LIKE', "%{$query}%")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->item_name.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
    }
    
    public function downloadBill()
    {
        $bill_no=$_GET["bill_no"];
        $bill_details=DB::table('bil_AddBillDetail')
                ->where('bill_no','=',$bill_no)
                ->get();
				//print_r($bill_details);
				//exit;
        if(count($bill_details)>0)
        {
            $cid=$bill_details[0]->cid;
            $lid=$bill_details[0]->lid;
            $emp_id=$bill_details[0]->emp_id;
            $setting_details=DB::table('bil_header_footer')
                ->where(['cid'=>$cid,'lid'=>$lid])
                ->first();
				
            if(!empty($setting_details))
            {
//                print_r($setting_details);
                $page_size=$setting_details->page_size;
//                print_r($page_size);
                if($page_size=="A5")
                {
                    $customPaper ="A5";
                }
                else if($page_size=="2 inch")
                {
                     $customPaper = array(0,0,169,500);
                }
                else if($page_size=="3 inch")
                {
                     $customPaper = array(0,0,241,432);
                }
                else
                {
                    $customPaper ="a4";
                }
                    
            }
            
        }
//        exit;
//        $customPaper = array(0,0,76.2,500);
        $pdf = PDF::loadView('sales.bill_pdf',['setting_details'=>$setting_details,'bill_details'=>$bill_details,'page_size'=>$page_size])->setPaper($customPaper);
//        $pdf->save(storage_path().'_filename.pdf');
        
        return $pdf->download('bill_pdf.pdf');  
    }
    
}