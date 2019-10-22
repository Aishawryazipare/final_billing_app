<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class ActiveInactiveController extends Controller
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

            return $next($request);
        });
    }
    
  
    
    public function statusList()
    {
        $status_list = \App\ActiveInactive::where('is_active','=',0)->get();
        return view('active_inactive.status_list',['status_list'=>$status_list]);
    }
    
    public function addEnquirystatus()
    {
        return view('active_inactive.add_status');
    }
    
    public function saveStatus(Request $request)
    {
        $requestData = $request->all();
        $requestData['created_at'] = date('Y-m-d h:m:s');
        \App\ActiveInactive::create($requestData);
        Session::flash('alert-success', 'Created Successfully.');
        return redirect('active-inactive');
    }
    
    public function editStatus()
    {
        $id = $_GET['id'];
        $status = \App\ActiveInactive::findorfail($id);
        return view('active_inactive.edit_status',['status'=>$status]);
    }
    
    public function updateStatus($id,Request $request)
    {
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
//        $requestData['modify_at'] = date('Y-m-d h:m:s');
        $status = \App\ActiveInactive::findorfail($id);
        $status->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('active-inactive');
    }
    
    public function deleteStatus($id)
    {
        $query= \App\ActiveInactive::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('active-inactive');
    }
    
  
   
}