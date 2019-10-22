<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryStatusController extends Controller
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
    
    public function statusList()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $status_list = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $status_list = \App\EnquiryStatus::where('is_active','=',0)->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $status_list = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
        }            
        return view('enquiry_status.enquiry_status_list',['status_list'=>$status_list]);
    }
    
    public function addEnquirystatus()
    {
        return view('enquiry_status.add_enquiry_status');
    }
    
    public function saveStatus(Request $request)
    {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        $requestData['created_at'] = date('Y-m-d h:m:s');
        \App\EnquiryStatus::create($requestData);
        Session::flash('alert-success', 'Created Successfully.');
        return redirect('enquiry-status');
    }
    
    public function editStatus()
    {
        $id = $_GET['id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $status = \App\EnquiryStatus::where(['id'=>$id,'cid'=>$id])->first();
        }else if(Auth::guard('web')->check()){
            $status = \App\EnquiryStatus::findorfail($id);
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $status = \App\EnquiryStatus::where(['id'=>$id,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first();
        } 
        
        return view('enquiry_status.edit_enquiry_status',['status'=>$status]);
    }
    
    public function updateStatus($id,Request $request)
    {
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $requestData['modify_at'] = date('Y-m-d h:m:s');
        $status = \App\EnquiryStatus::findorfail($id);
        $status->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enquiry-status');
    }
    
    public function deleteStatus($id)
    {
        $query= \App\EnquiryStatus::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enquiry-status');
    }
    
  
   
}