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
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
//            $this->employee = Auth::guard('employee')->user();
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
        return view('settings.show_setting',['hf_setting'=>$hf_setting]);
    }
    
    public function addHeaderFooter(Request $request)
    {
        $requestData = $request->all();
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
        }
        $requestData['cid']=$cid;
        
        $res= \App\HeaderFooter::where('cid','=',$cid)->first();
        if(!empty($res))
        {
            $query= \App\HeaderFooter::where('cid', '=', $cid)->firstOrFail();
            $query->update($requestData);
        }
        else
        {
            \App\HeaderFooter::create($requestData);
        }        
        Session::flash('alert-success','Added Successfully.');
        return redirect('settings');
    }
    
    public function print_bill()
    {
       echo "hello";
       exit;

    }
    
}