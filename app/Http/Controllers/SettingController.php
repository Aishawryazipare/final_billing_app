<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Item;
use App\Inventory;
use App\Category;
use App\Dealer;
use App\Machine;
use App\Subscription;
use Session;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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
    
    public function getSetting()
    {
        return view('settings.setting_data');
    }
    public function getSettingDetails()
    {
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
            $hf_setting= \App\HeaderFooter::where('cid','=',$cid)->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid=$this->employee->cid;
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $hf_setting= \App\HeaderFooter::where(['cid'=>$cid,'lid'=>$lid])->first();
        } 
        if(!empty($hf_setting))
        {
            echo json_encode($hf_setting);
        }
        else
        {
            echo json_encode("");
        }
        
    }
    
    public function showSetting()
    {
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
            $hf_setting= \App\HeaderFooter::where('cid','=',$cid)->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid=$this->employee->cid;
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $hf_setting= \App\HeaderFooter::where(['cid'=>$cid,'lid'=>$lid])->first();
        } 
        return view('settings.show_setting',['hf_setting'=>$hf_setting]);
    }
    
    public function addHeaderFooter(Request $request)
    {
        $requestData = $request->all(); 
         if(Auth::guard('admin')->check()){
            $cid=$this->admin->rid;
            $requestData['cid'] = $this->admin->rid;
            $res= \App\HeaderFooter::select('id')->where(['cid'=>$cid])->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid=$this->employee->cid;
            $lid=$this->employee->lid;
            $emp_id=$this->employee->id;
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;            
            $res= \App\HeaderFooter::select('id')->where(['cid'=>$cid,'lid'=>$lid])->first();
        }  
        if(!empty($res))
        {
            $query= \App\HeaderFooter::where('id','=',$res->id)->firstOrFail();
            $query->update($requestData);
        }
        else
        {
            \App\HeaderFooter::create($requestData);
        } 
        Session::flash('alert-success','Added Successfully.');
        return redirect('settings');
    }
    
    public function getMainSetting()
    {
		$flag=0;
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
			$flag=1;
            $hf_setting= \App\HeaderFooter::where('cid','=',$cid)->first();
        }
        else if(Auth::guard('employee')->check()){
            $cid=$this->employee->cid;
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
			$role = $this->employee->role;
            $emp_id = $this->employee->id;
			 $client_data = \App\Admin::select('location')->where(['rid'=>$cid])->first();
            $hf_setting= \App\HeaderFooter::where(['cid'=>$cid,'lid'=>$lid])->first();
			if($client_data->location == "multiple" && $role == 1)
            {
				$flag=1;
			}
        } 
//        echo "<pre>";
//        print_r($hf_setting);
//        exit;
        return view('settings.main_setting',['hf_setting'=>$hf_setting,'flag'=>$flag]);
    }
    
   public function addMainSetting(Request $request)
    {
//        echo "<pre>";
        $requestData = $request->all();
//        print_r($requestData);
//        exit;
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
            $requestData['cid']=$cid;
            $res= \App\HeaderFooter::select('id')->where(['cid'=>$cid])->first();
        }
        else if(Auth::guard('employee')->check()){
           $cid=$this->employee->cid;
           $lid=$this->employee->lid;
           $emp_id=$this->employee->id;
           $requestData['cid'] = $this->employee->cid;
           $requestData['lid'] = $this->employee->lid;
           $requestData['emp_id'] = $this->employee->id;
           $res= \App\HeaderFooter::select('id')->where(['cid'=>$cid,'lid'=>$lid])->first();
        } 
        
         if(!empty($res))
        {
            $query= \App\HeaderFooter::where('id','=',$res->id)->firstOrFail();
            $query->update($requestData);
        }
        else
        {
            \App\HeaderFooter::create($requestData);
        }       
        Session::flash('alert-success','Added Successfully.');
        return redirect('main-setting');
    }   
}