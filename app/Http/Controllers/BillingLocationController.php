<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BillingLocationController extends Controller
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
    
     
    public function listLocation(){
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $location = \App\EnquiryLocation::where(['cid'=>$id,'is_active'=>1])->get();
        }
        else if(Auth::guard('web')->check()){
            $location = \App\EnquiryLocation::where(['cid'=>$this->admin->rid,'is_active'=>1])->get();
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
                $location = \App\EnquiryLocation::where(['cid'=>$cid,'is_active'=>1])->get();
            }
            else if($client_data->location == "multiple" && $role == 2)
            {
                $location = \App\EnquiryLocation::where(['cid'=>$cid,'is_active'=>1,'loc_id'=>$lid])->get();
            }
            else if($client_data->location == "multiple" && $role == 1)
            {
                $location = \App\EnquiryLocation::where(['cid'=>$cid,'is_active'=>1,'loc_id'=>$lid])->get();
            }
        }
        return view('bil_location.enq_location',['location'=>$location]);
    }
  
    public function addLocation(){
        return view('bil_location.add_location');
    }
    
    public function saveLocation(Request $request){
        $requestData = $request->all();
        $requestData['cid'] = $this->admin->rid;
        
        \App\EnquiryLocation::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('bil_location_list');
    }
   
    public function editLocation(){
        $id = $_GET['id'];
        $location = \App\EnquiryLocation::where(['loc_id'=>$id,'is_active'=>1])->first();
        return view('bil_location.edit_location',['location'=>$location]);
    }
    
    public function updateLocation(Request $request){
        $requestData = $request->all();
        $id = $requestData['loc_id'];
        $location = \App\EnquiryLocation::where(['loc_id'=>$id,'is_active'=>1])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('bil_location_list');
    }
    public function deleteLocation($loc_id)
    {
        $status = 0;
        $query = \App\EnquiryLocation::where('loc_id', $loc_id)->update(['is_active' => $status]);
        return redirect('bil_location_list');
    }
    public function check()
    {
        $loc_name=$_GET['loc_name'];
	if(Auth::guard('admin')->check())
        {
            $id = $this->admin->rid;
            $query = \App\EnquiryLocation::where(['loc_name'=>$loc_name,'cid'=>$id,'is_active' => '1'])->first();
        }
        if(!empty($query))
        {
            echo json_encode("Already Exist");
        }
    }
    
}