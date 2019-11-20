<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\User;

class UserController extends Controller
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
    
    public function validateEmail($id) {
        $id = trim($id);
        if (\App\Employee::where('mobile_no', $id)->exists()) {
            echo "Mobile No Already exists!";
        }
    }
    
    public function addEmployee(){
        $city = \App\City::select('city_id','city_name')->get();
        if(Auth::guard('admin')->check())
        {
            $cid = $this->admin->rid;
            $location= \App\EnquiryLocation::select('loc_id','loc_name')
                    ->where(['is_active'=>1,'cid'=>$cid])
                    ->get();
        }
        else if(Auth::guard('employee')->check())
        {
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $sub_emp_id = $this->employee->sub_emp_id;
            $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            if($client_data->location == "single" && $role == 2)
            {
                $location= \App\EnquiryLocation::select('loc_id','loc_name')
                    ->where(['is_active'=>1,'cid'=>$cid])
                    ->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $location= \App\EnquiryLocation::select('loc_id','loc_name')
                    ->where(['is_active'=>1,'cid'=>$cid,'loc_id'=>$lid])
                    ->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $location= \App\EnquiryLocation::select('loc_id','loc_name')
                    ->where(['is_active'=>1,'cid'=>$cid,'loc_id'=>$lid])
                    ->get();
            }
        }
//        echo "<pre>";print_r($location);exit;
        return view('auth.register',['city'=>$location]);
    }

    public function saveUser(Request $request)
    {
//        echo "<pre>";print_r($request->all());exit;
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
//            if($requestData['role']==2)
//            {
//                    $requestData['lid'] = NULL;
//            }
//            else
//            {
//                    $requestData['lid'] = $this->employee->lid;
//            }
        }else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
//            print_r("hi");
//            exit;
            $requestData['sub_emp_id'] = $this->employee->id;
        }
		 $requestData['android_password'] =$requestData['password'];
        $requestData['password'] = bcrypt($requestData['password']);
        \App\Employee::create($requestData);
        
        return redirect('user-list');
    }
    
    public function userList(){
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
            $userData = \App\Employee::where(['is_active'=>0,'cid'=>$cid])->get();
        }else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
//            $sub_emp_id = $this->employee->sub_emp_id;
            $userData = \App\Employee::where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'sub_emp_id'=>$emp_id])->get();
        }
        return view('auth.user_list',['userData'=>$userData]);
    }
  
    public function userEdit(){
        $id = $_GET['id'];
        $userData = \App\Employee::findorfail($id);
        return view('auth.edit_user',['userData'=>$userData]);
    }
    
    public function updateUser($id,Request $request)
    {
        $requestData = $request->all();
		 $requestData['android_password'] =$requestData['password'];
//        echo "<pre>";print_r($requestData);exit;
        if ($request->password)
            $requestData['password'] = bcrypt($request->password);
        $users = \App\Employee::findorfail($id);
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('user-list');
    }
    
    public function deletUser($id)
    {
		
        $query= \App\Employee::where('id', $id)->update(['is_active' => 1]);
		//echo "<pre/>";print_r($query);exit;
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('user-list');
    }
   
}