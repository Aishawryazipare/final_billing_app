<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;
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
         $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '0','tbl_category.cid'=>$id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$id])->first();
          $bill_data = \App\BillMaster::select('bill_no')->where(['cid'=>$id])->orderBy('bill_no','desc')->first();
         }else if(Auth::guard('web')->check()){
             $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '0'])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::first();
          $bill_data = \App\BillMaster::select('bill_no')->orderBy('bill_no','desc')->first();
         }else if(Auth::guard('employee')->check()){
              $cid = $this->employee->cid;
             $lid = $this->employee->lid;
             $emp_id = $this->employee->id;
             $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '0','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid,'tbl_category.emp_id'=>$emp_id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
          $hf_setting= \App\HeaderFooter::where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first();
          $bill_data = \App\BillMaster::select('bill_no')->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->orderBy('bill_no','desc')->first();
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
            $item_data = \App\Item::where(['is_active' => '0','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->orderBy('item_name', 'asc')->get();   
            }
             
            foreach($item_data as $data)
            {
                $replaced_item = str_replace(' ', '_', $data->item_name);
                $bdata.='<div class="col-sm-4 col-md-3"><button type="button" class="btn btn-block btn-default" style="border-color:#666666;" onclick="cal('.$data->item_final_rate.','.$data->item_id.','.$data->item_dis.','.$data->item_tax.')">'.$data->item_name.'<br/>'.$data->item_final_rate.'</button><input type="hidden" id="gitem_'.$data->item_id.'" value="'.$data->item_name.'"/></div>';
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
            $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active' => '0','item_category'=>$cat_id,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();   
            }
            foreach($item_data as $data)
            {
                $replaced_item = str_replace(' ', '_', $data->item_name);
                $bdata.='<div class="col-sm-4 col-md-3"><button type="button" class="btn btn-block btn-default" style="border-color:#666666;" onclick="cal('.$data->item_final_rate.','.$data->item_id.','.$data->item_dis.','.$data->item_tax.')">'.$data->item_name.'<br/>'.$data->item_final_rate.'</button><input type="hidden" id="gitem_'.$data->item_id.'" value="'.$data->item_name.'"/></div>';
                $j++;

            } 
        }
       
        echo $bdata;
    }

    public function saveBill(Request $request)
    {
         $requestData = $request->all();
//         echo "<pre>";
//         print_r($requestData);
//         exit;
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
             $requestData["item_totalrate"]=$data[6];
             $bill_detail=\App\BillDetail::create($requestData);
         }
         
    }
    public function checkItems()
    {
        $code = $_GET["code"];
        if(Auth::guard('admin')->check()){
        $id = $this->admin->rid;
        $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
           $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code])->first(); 
        }
         else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $item_data = \App\Item::select('*')->where(['is_active' => '0','item_id'=>$code,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first(); 
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
            $item_data = \App\Item::select('*')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->where('item_name','like',$code)->first(); 
         }
        }
        echo  json_encode($item_data);
    }
    public function getItems1()
    {
        $query=$_GET["query"];
        $data = DB::table('tbl_AddItems')
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
    
}