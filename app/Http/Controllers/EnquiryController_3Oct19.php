<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    public function validateMobile($id) {
        $id = trim($id);
        if (\App\Enquiry::where('mobile_no', $id)->exists()) {
            $enquiry_data = \App\Enquiry::where('mobile_no', $id)->first();
            echo json_encode($enquiry_data);
        }
    }
    
    public function enquiryList()
    {        
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $enquiry_list = DB::table('tbl_enquiry')
                     ->select('tbl_enquiry.*','tbl_AddItems.item_name','tbl_enquiry_status.status_name','users.name')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','tbl_enquiry.product_id')
                     ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','tbl_enquiry.status_id')
                     ->leftjoin('users','users.id','tbl_enquiry.emp_id')
                     ->where(['tbl_enquiry.is_active'=>0,'tbl_enquiry.cid'=>$id])
                     ->where('tbl_enquiry.active_inactive_status','=',1)
                     ->get();
        }else if(Auth::guard('web')->check()){
            $enquiry_list = DB::table('tbl_enquiry')
                     ->select('tbl_enquiry.*','tbl_AddItems.item_name','tbl_enquiry_status.status_name','users.name')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','tbl_enquiry.product_id')
                     ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','tbl_enquiry.status_id')
                     ->leftjoin('users','users.id','tbl_enquiry.emp_id')
                     ->where(['tbl_enquiry.is_active'=>0])
                     ->where('tbl_enquiry.active_inactive_status','=',1)
                     ->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            if($role == 1){
            $enquiry_list = DB::table('tbl_enquiry')
                     ->select('tbl_enquiry.*','tbl_AddItems.item_name','tbl_enquiry_status.status_name','users.name')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','tbl_enquiry.product_id')
                     ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','tbl_enquiry.status_id')
                     ->leftjoin('users','users.id','tbl_enquiry.emp_id')
                     ->where(['tbl_enquiry.is_active'=>0,'tbl_enquiry.cid'=>$cid,'tbl_enquiry.lid'=>$lid,'tbl_enquiry.emp_id'=>$emp_id])
                     ->where('tbl_enquiry.active_inactive_status','=',1)
                     ->get();
            } else if($role == 2){
                $enquiry_list = DB::table('tbl_enquiry')
                     ->select('tbl_enquiry.*','tbl_AddItems.item_name','tbl_enquiry_status.status_name','users.name')
                     ->leftjoin('tbl_AddItems','tbl_AddItems.item_id','tbl_enquiry.product_id')
                     ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','tbl_enquiry.status_id')
                     ->leftjoin('users','users.id','tbl_enquiry.emp_id')
                     ->where(['tbl_enquiry.is_active'=>0,'tbl_enquiry.cid'=>$cid,'tbl_enquiry.lid'=>$lid,'tbl_enquiry.emp_id'=>$emp_id])
                     ->where('tbl_enquiry.active_inactive_status','=',1)
                     ->get();
            }
        }  
        return view('enquiry.enquiry_list',['enquiry_list'=>$enquiry_list]);
    }
    
    public function addEnquiry()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
                $last_entry = \App\Enquiry::select('enquiry_no')->where(['emp_id'=>$id,'cid'=>$id])->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0,'cid'=>$id])->get();
                $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $source = \App\Source::select('name')->get();
                $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$id])->get();
                $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
                $last_entry = \App\Enquiry::select('enquiry_no')->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0])->get();
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0])->get();
                $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0])->get();
                $source = \App\Source::select('name')->get();
                $category = \App\Category::select('cat_id','cat_name')->where('is_active','=',1)->get();
                $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
                $last_entry = \App\Enquiry::select('enquiry_no')->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                $source = \App\Source::select('name')->get();
                
                $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
//                echo $cid;
//                echo $lid;
//                echo $sub_emp_id;
//                exit;
                if($client_data->location == "single" && $role == 2){
                    $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid])->get();
                }
                else if($client_data->location == "multiple" && $role == 2){
                     if($sub_emp_id != ""){
                        $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
                        $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
                        $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
                        $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
//                        echo "<pre>";print_r($category);exit;
                    }else{
                        $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                        $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                        $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                        $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid])->get();
                    }                    
                }
                else if($client_data->location == "multiple" && $role == 1){
                    $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                }
//                else  if($client_data->location == "multiple" && $role == 2){
//                    $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'sub_emp_id'=>$emp_id])->get();
//                    $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'sub_emp_id'=>$emp_id])->get();
//                    $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'sub_emp_id'=>$emp_id])->get();
//                    $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'sub_emp_id'=>$emp_id])->get();
//                }
//                else{
//                        $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
//                        $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
//                        $brand = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
//                        $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid])->get();
//                    }
//                }
        }  
        
        return view('enquiry.add_enquiry',['city'=>$city,'brand'=>$brand,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'last_entry'=>$last_entry,'source'=>$source,'status'=>$status,'category'=>$category]);
    }
    
    public function saveEnquiry(Request $request)
    {
        //$role = Auth::user()->role;
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        $requestData['insert_date'] = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            if(isset($requestData['assign_to_emp_id'])){
                $requestData['emp_id'] = $requestData['assign_to_emp_id'];
            }
        }
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
            $requestData['followup_date'] = $arr[1];
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
//        echo "<pre>";print_r($requestData);exit;
        
        $requestData['create_at'] = date('Y-m-d h:m:s');
        if($requestData['en_id'] == ""){
            \App\Enquiry::create($requestData);
            Session::flash('alert-success', 'Created Successfully.');
        }else{
            $id = $requestData['en_id'];
            $data = \App\Enquiry::findorfail($id);
            $data->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
        }
        return redirect('add-enquiry');
    }
    
    public function editEnquiry()
    {
        $id = $_GET['id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
                $last_entry = \App\Enquiry::select('enquiry_no')->where(['emp_id'=>$id,'cid'=>$id])->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0,'cid'=>$id])->get();
                $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $source = \App\Source::select('name')->get();
                $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$id])->get();
                $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$id])->get();
                $enquiry_data = \App\Enquiry::findorfail($id);
        }else if(Auth::guard('web')->check()){
                $last_entry = \App\Enquiry::select('enquiry_no')->where(['emp_id'=>$id])->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0])->get();
                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0])->get();
                $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0])->get();
                $source = \App\Source::select('name')->get();
                $category = \App\Category::select('cat_id','cat_name')->where('is_active','=',1)->get();
                $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0])->get();
                $enquiry_data = \App\Enquiry::findorfail($id);
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
             $role = $this->employee->role;
                $last_entry = \App\Enquiry::select('enquiry_no')->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->orderBy('enquiry_id','desc')->first();
                $status = \App\ActiveInactive::where(['is_active'=>0])->get();
                $city = \App\City::get();
                $custome_data = \App\Customer::select('cust_id','cust_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
//                $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                $employee_data = \App\Employee::select('id','name')->where(['role'=>2,'is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
//                $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                $source = \App\Source::select('name')->get();
//                $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                
                $enquiry_data = \App\Enquiry::findorfail($id);
                
                $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
                if($client_data->location == "single" && $role == 2){
                    $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                    $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid])->get();
                }else{
                    $product_data = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                    $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                }
        }
        
        return view('enquiry.edit_enquiry',['category'=>$category,'brand_list'=>$brand_list,'status'=>$status,'city'=>$city,'enquiry_data'=>$enquiry_data,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'source'=>$source]);
    }
    
    public function updateEnquiry($id,Request $request)
    {
        $requestData = $request->all();
        
//        echo "<pre>";print_r($requestData);exit;
        if(Auth::guard('admin')->check()){
            if(isset($requestData['assign_to_emp_id'])){
                $requestData['emp_id'] = $requestData['assign_to_emp_id'];
            }
        }
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
            $requestData['followup_date'] = $arr[1];
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
//        $requestData['follow_up'] = json_encode($requestData['follow_up']);
        $requestData['modified_At'] = date("Y-m-d h:m:s");
        $users = \App\Enquiry::findorfail($id);
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enquiry-list');
    }
    
    public function deletEnquiry($id)
    {
        $query= \App\Enquiry::where('enquiry_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enquiry-list');
    }
    
    public function getProduct($id){
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $product = \App\Item::select('item_id','item_name')->where(['item_category'=>$id,'is_active'=>0,'cid'=>$id])->get();  
            $brand_list = \App\Brand::select('brand_id','brand_name')->where(['cat_id'=>$id,'is_active'=>0,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $product = \App\Item::select('item_id','item_name')->where(['item_category'=>$id,'is_active'=>0])->get();  
            $brand_list = \App\Brand::select('brand_id','brand_name')->where(['cat_id'=>$id,'is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                 $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid])->get();
                 $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2){
                if($sub_emp_id != ""){
                    $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
                    $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$sub_emp_id])->get();
                }else{
                    $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                    $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid])->get();
                }                    
            }
            else if($client_data->location == "multiple" && $role == 1){
                $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
                $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
            }
            
            
            
//            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
//            if($client_data->location == "single" && $role == 2){
//                $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid])->get();
//                $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid])->get();
//            }else{
//                $product = \App\Item::select('item_id','item_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
//                $brand_list = \App\Brand::select('brand_id','brand_name')->where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
//            }
        }                
//        $product = \App\Item::select('item_id','item_name')->where(['item_category'=>$id,'is_active'=>0])->get();
        $all_arr = array();
        $list = $list1 = "";
        $list .="<option value=''>-- Select Product -- </option>";
        foreach($product as $prod){
            $list .= '<option value="'.$prod->item_id.'">'.$prod->item_name.'</option>';
        }
        
//        $brand_list = \App\Brand::select('brand_id','brand_name')->where(['cat_id'=>$id,'is_active'=>0])->get();
        $list1 .="<option value=''>-- Select Product -- </option>";
        foreach($brand_list as $prod){
            $list1 .= '<option value="'.$prod->brand_id.'">'.$prod->brand_name.'</option>';
        }
        $all_arr['brand'] = $list1;
        $all_arr['product'] = $list;
//        print_r($all_arr);exit;
        echo json_encode($all_arr);
//        echo $list;
//        echo $list1;
    }
  
   
}