<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
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
    
    //Type 
    public function getTypeData() {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $type = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $type = DB::table('tbl_AddIUnits')->where(['is_active' => '0'])->get();
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
                $type = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
               
                if($sub_emp_id != "")
                {
                    $type = DB::table('tbl_AddIUnits')
                            ->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                            ->orWhere(['emp_id'=>$sub_emp_id])
                            ->orWhere(['emp_id'=>$emp_id])
                            ->get();
                }
                else
                {
                    $type = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->get();
                }
                
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $type = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->get();
            }
        }
        return view('master_data.type_data',['type' => $type]);
    }
    
    public function getType() {
        return view('master_data.add_type');
    }
    
    public function editType()
    {
        $type_id=$_GET['type_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = Type::where('Unit_id', $type_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = Type::where('Unit_id', $type_id)->where(['is_active' => '0'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                $query = Type::where('Unit_id', $type_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->first();
            }
            else
            {
                $query = Type::where('Unit_id', $type_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
        }
        return view('master_data.edit_type',['type_data' => $query]);
    }
    
    public function addType(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        Type::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('type_data');
    }
    
    public function updateType(Request $request)
    {
        $requestData = $request->all();
        $type_id=$requestData['Unit_Id'];
        $query =Type::findorfail($type_id);
        $query->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('type_data');
    }
    
    public function deleteType($unit_id)
    {
        $status = 1;
        $query = Type::where('Unit_Id', $unit_id)->update(['is_active' => $status]);
        return redirect('type_data');
    }
    
    
    //Category
    
    public function getCategoryData() {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
        }else if(Auth::guard('web')->check()){
             $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1'])
                ->orderBy('tbl_category.cat_name', 'asc')
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
			
                $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                if($sub_emp_id != ""){
                $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
                }
                else
                {
                    $category = DB::table('tbl_category')
                    ->select('tbl_category.*','tbl_type.type_name')
                    ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                    ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid,'emp_id'=>$emp_id])
                    ->orderBy('tbl_category.cat_name', 'asc')
                    ->get();
                }
            }
            else if($client_data->location == "multiple" && $role == 1){
				
             $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
            }
        }
        return view('master_data.category_data',['category' => $category]);
    }
    
    public function getCategory() {
        return view('master_data.add_category');
    }
    
    public function addCategory(Request $request) {
        $requestData = $request->all();
        
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        if(!empty($requestData['cat_image']))
        {
           $filename =$requestData['cat_image']->getClientOriginalName();
            $destination= 'cat_images';
            $requestData['cat_image']->move($destination,$filename);
            $requestData['cat_image']=$filename;
        }
        else
        {
            $requestData['cat_image']="cat.png";
        }
        Category::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('category_data');
    }
    
     public function editCategory()
    {
        $cat_id=$_GET['cat_id'];
       // echo $cat_id;
//        exit;
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = DB::table('tbl_category')
                ->select('tbl_category.*')
                ->where(['cat_id'=>$cat_id,'tbl_category.is_active' => '1','cid'=>$id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->first();
        }else if(Auth::guard('web')->check()){
            $query = DB::table('tbl_category')
                ->select('tbl_category.*')
                ->where(['cat_id'=>$cat_id,'tbl_category.is_active' => '1'])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){ 
			
            $query = DB::table('tbl_category')
                ->select('tbl_category.*')
                ->where(['cat_id'=>$cat_id,'tbl_category.is_active' => '1','cid'=>$cid,'lid'=>$lid])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->first();
            }
            else
            {
                
                $query = DB::table('tbl_category')
                ->select('tbl_category.*')
                ->where(['cat_id'=>$cat_id,'tbl_category.is_active' => '1','cid'=>$cid,'lid'=>$lid])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->first();
//                     echo "in else";
//                echo $cat_id;
//                print_r($query);
//                exit;
            }
        }  

        return view('master_data.edit_category',['category_data' => $query]);
    }
    
    public function updateCategory(Request $request)
    {
        $requestData = $request->all();
//        echo "<pre>";
//        print_r($requestData['cat_image']);
//        exit;
        $cat_id=$requestData['cat_id'];
        $cat_name=$requestData['cat_name'];
   
        $query =Category::findorfail($cat_id);
        $query->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('category_data');
    }
    
     public function deleteCategory($cat_id)
    {
        $status = 0;
        $query = Category::where('cat_id', $cat_id)->update(['is_active' => $status]);
        return redirect('category_data');
    }
    
    //Subscription
    
    public function getSubscriptionData() {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $sub_data= DB::table('tbl_subscription')->where(['is_active' => '1','cid'=>$id])->orderBy('sub_name', 'asc')->get();
        }else if(Auth::guard('web')->check()){
             $sub_data= DB::table('tbl_subscription')->where(['is_active' => '1'])->orderBy('sub_name', 'asc')->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $sub_data= DB::table('tbl_subscription')->where(['is_active' => '1','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->orderBy('sub_name', 'asc')->get();
        }        
        return view('master_data.subscription_data',['sub_data' => $sub_data]);
    }
    
    public function getSubscription() {
        return view('master_data.add_subscription');
    }
    
     public function addSubscription(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        Subscription::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('subscription_data');
    }
    
    public function editSubscription()
    {
        $sub_id=$_GET['sub_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = Subscription::where('sub_id', $sub_id)->where(['is_active' => '1','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = Subscription::where('sub_id', $sub_id)->where(['is_active' => '1'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $query = Subscription::where('sub_id', $sub_id)->where(['is_active' => '1','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first();
        }        
        return view('master_data.edit_subscription',['sub_data' => $query]);
    }
    
    public function updateSubscription(Request $request)
    {
        $requestData = $request->all();
        $sub_id=$requestData['sub_id'];
        $sub_name=$requestData['sub_name'];
        $sub_users_no=$requestData['sub_users_no'];
        $sub_price=$requestData['sub_price'];
        if($sub_id!="")
        {
            $query = Subscription::findorfail($sub_id);
            DB::table('tbl_subscription')
                    ->where('sub_id', '=',$sub_id)
                    ->update(['sub_name'=>$sub_name,'sub_users_no'=>$sub_users_no,'sub_price'=>$sub_price]);
            Session::flash('alert-success','Updated Successfully.');
        }
        else
        {
            Session::flash('alert-error','Error Updating');
        }
        return redirect('subscription_data');
    }
    
     public function deleteSubscription($sub_id)
    {
        $status = 0;
        $query = Subscription::where('sub_id', $sub_id)
                ->update(['is_active' => $status]);
        return redirect('subscription_data');
    }
    
    public function dashboard_enq_list()
    {
        $status_id=$_GET['status_id'];
        $query = \App\Enquiry::where('status_id', $status_id)->get();
        $enq_status = \App\EnquiryStatus::select('status_name')->where(['id'=>$status_id])->first();
        return view('dashboard_enq_list',['status_data' => $query,'status_nm'=>$enq_status]);
    }
    
    //Customer
    public function getCustomerData()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $customer_data = \App\Customer::orderBy('cust_name', 'asc')->where(['is_active'=>'0','cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
                        $customer_data = \App\Customer::orderBy('cust_name', 'asc')->where(['is_active'=>'0'])->get();
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
                $customer_data = \App\Customer::orderBy('cust_name', 'asc')->where(['is_active'=>'0','cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $customer_data = \App\Customer::orderBy('cust_name', 'asc')->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $customer_data = \App\Customer::orderBy('cust_name', 'asc')->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])->get();
            }
               
            
        } 
        
        return view('master_data.customer_data',['customer_data' => $customer_data]);
    }
    
    public function getCustomer() {
        return view('master_data.add_customer');
    }
    
    public function addCustomer(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
//        echo "<pre>";
//        print_r($requestData);exit;
        \App\Customer::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('customer_data');
    }
    
    public function editCustomer()
    {
        $cust_id=$_GET['cust_id'];
        
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = \App\Customer::where('cust_id', $cust_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = \App\Customer::where('cust_id', $cust_id)->where(['is_active' => '0'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id; 
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                $query = \App\Customer::where('cust_id', $cust_id)->where(['is_active' => '0','cid'=>$cid])->first();
            }
            else
            {
                $query = \App\Customer::where('cust_id', $cust_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
            
        }        
        return view('master_data.edit_customer',['customer_data' => $query]);
    }
    
    public function updateCustomer(Request $request)
    {
        $requestData = $request->all();
        $cust_id=$requestData['cust_id'];
         $users = \App\Customer::findorfail($cust_id);
        $users->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('customer_data');
    }
    
    public function deleteCustomer($cust_id)
    {
        $status = 1;
        $query = \App\Customer::where('cust_id', $cust_id)
                ->update(['is_active' => $status]);
        return redirect('customer_data');
    }
    
    //Item
  
    
    public function getItemData()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active'=>'0','cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $item_data = \App\Item::orderBy('item_name', 'asc')->where('is_active','0')->get();
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
                $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active'=>'0','cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
//                echo "multiple role 2";
               
                $item_data = \App\Item::orderBy('item_name', 'asc')
                        ->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])
                        ->orWhere(['emp_id'=>$sub_emp_id])
                        ->orWhere(['emp_id'=>$emp_id])
                        ->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $item_data = \App\Item::orderBy('item_name', 'asc')->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])->get();
            }
                
        } 
//        echo "<pre>";
//        print_r($item_data);
//        exit;
        return view('master_data.item_data',['item_data' => $item_data]);
    }
    
    public function getItem() {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
             $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
         $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1'])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
            $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0'])->get();
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
                $category = DB::table('tbl_category')
                    ->select('tbl_category.*','tbl_type.type_name')
                    ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                    ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                    ->orderBy('tbl_category.cat_name', 'asc')
                    ->get();
                $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $category = DB::table('tbl_category')
                    ->select('tbl_category.*','tbl_type.type_name')
                    ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                    ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                    ->orderBy('tbl_category.cat_name', 'asc')
                    ->get();
                $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $category = DB::table('tbl_category')
                    ->select('tbl_category.*','tbl_type.type_name')
                    ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                    ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                    ->orderBy('tbl_category.cat_name', 'asc')
                    ->get();
                $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])->get();
            }
        } 
        
        
        return view('master_data.add_item',['category_data'=>$category,'unit_data'=>$unit_data]);
    }
    
    public function addItem(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
//        echo "<pre>";
//        print_r($requestData['cat_image']);
        \App\Item::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('item_data');
    }
    
    public function deleteItem($item_id)
    {
        $status = 1;
        $query = \App\Item::where('item_id', $item_id)
                ->update(['is_active' => $status]);
        return redirect('item_data');
    }
     public function editItem()
    {
        $item_id=$_GET['item_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
            $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$id])->get();
            $query = \App\Item::where('item_id', $item_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1'])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
            $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0'])->get();
            $query = \App\Item::where('item_id', $item_id)->where(['is_active' => '0'])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2){
                $category = DB::table('tbl_category')
                    ->select('tbl_category.*','tbl_type.type_name')
                    ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                    ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid])
                    ->orderBy('tbl_category.cat_name', 'asc')
                    ->get();
               
                
                $unit_data = DB::table('tbl_AddIUnits')->where(['is_active' => '0','cid'=>$cid])->get();
                $query = \App\Item::where('item_id', $item_id)
                        ->where(['is_active' => '0','cid'=>$cid])->first();
            }
            else
            {
                $category = DB::table('tbl_category')
                ->select('tbl_category.*','tbl_type.type_name')
                ->leftjoin('tbl_type','tbl_type.type_id','=','tbl_category.type_id')
                ->where(['tbl_category.is_active' => '1','tbl_category.cid'=>$cid,'tbl_category.lid'=>$lid])
                ->orWhere(['tbl_category.emp_id'=>$emp_id])
                ->orWhere(['tbl_category.emp_id'=>$sub_emp_id])
                ->orderBy('tbl_category.cat_name', 'asc')
                ->get();
                $unit_data = DB::table('tbl_AddIUnits')
                        ->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->orWhere(['emp_id'=>$emp_id])
                        ->orWhere(['emp_id'=>$sub_emp_id])
                        ->get();
                $query = \App\Item::where('item_id', $item_id)
                        ->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
        }         
        return view('master_data.edit_item',['item_data' => $query,'category_data'=>$category,'unit_data'=>$unit_data]);
    }
     public function updateItem(Request $request)
    {
        $requestData = $request->all();
//        echo "<pre/>";print_r($requestData);exit;
        $item_id=$requestData['item_id'];
         $users = \App\Item::findorfail($item_id);
        $users->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('item_data');
    }
    
    public function getCity($id){
        $city = \App\City::select('city_id','city_name')->where(['state_code'=>$id])->get();
        $data = "";
        $data = '<option value="">-- Select City -- </option>';
        foreach($city as $c)
        {
            $data .= '<option value="'.$c->city_id.'">'.$c->city_name.'</option>';
        }
        echo $data;
    }
    
    
    
    public function addSupplier(Request $request) {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
//        echo "<pre>";
//        print_r($requestData);exit;
        \App\Supplier::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('supplier_data');
    }
    
    public function getSupplier() {
        return view('master_data.add_supplier');
    }
    
    public function deleteSupplier($sup_id)
    {
        $status = 1;
        $query = \App\Supplier::where('sup_id', $sup_id)
                ->update(['is_active' => $status]);
        return redirect('supplier_data');
    }
    
     public function getSupplierData()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $supplier_data = \App\Supplier::orderBy('sup_name', 'asc')->where(['is_active'=>'0','cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $supplier_data = \App\Supplier::orderBy('sup_name', 'asc')->where(['is_active'=>'0'])->get();
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
                $supplier_data = \App\Supplier::orderBy('sup_name', 'asc')->where(['is_active'=>'0','cid'=>$cid])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $supplier_data = \App\Supplier::orderBy('sup_name', 'asc')->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $supplier_data = \App\Supplier::orderBy('sup_name', 'asc')->where(['is_active'=>'0','cid'=>$cid,'lid'=>$lid])->get();
            }
        } 
        return view('master_data.supplier_data',['supplier_data' => $supplier_data]);
    }

    public function editSupplier()
    {
        $sup_id=$_GET['sup_id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = \App\Supplier::where('sup_id', $sup_id)->where(['is_active' => '0','cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $query = \App\Supplier::where('sup_id', $sup_id)->where(['is_active' => '0'])->first();
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
                $query = \App\Supplier::where('sup_id', $sup_id)->where(['is_active' => '0','cid'=>$cid])->first();
				//echo "<pre>";
				//echo $cid;
				//print_r($query);
				//exit;
                
            }
            else
            {
                $query = \App\Supplier::where('sup_id', $sup_id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid])
                        ->first();
            }
        } 
        
        
        return view('master_data.edit_supplier',['supplier_data' => $query]);
    }
     public function updateSupplier(Request $request)
    {
        $requestData = $request->all();
//        echo "<pre/>";print_r($requestData);exit;
        $sup_id=$requestData['sup_id'];
         $users = \App\Supplier::findorfail($sup_id);
        $users->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('supplier_data');
    }
    
    public function check()
    {
        $type=$_GET['type'];
        $data=$_GET['data'];
        if($type=="Category")
        {
			if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
			  $query = Category::where(['cat_name'=>$data,'cid'=>$id,'is_active' => '1'])->first();
        }else if(Auth::guard('web')->check()){
			$query = Category::where(['cat_name'=>$data,'is_active' => '1'])->first();
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
				$query = Category::where(['cat_name'=>$data,'cid'=>$id,'lid'=>$lid,'is_active' => '1'])->first();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
               $query = Category::where(['cat_name'=>$data,'cid'=>$id,'lid'=>$lid,'is_active' => '1'])->first();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
				 $query = Category::where(['cat_name'=>$data,'cid'=>$id,'lid'=>$lid,'is_active' => '1'])->first();
            }
        } 
            //$query = Category::where('cat_name', $data)->first();
            if(!empty($query))
            echo json_encode("Already Exist");
        }
        else if($type=="Unit")
        {
            $query = Type::where('Unit_name', $data)->first();
            if(!empty($query))
            echo json_encode("Already Exist");
        }
    }
    
}