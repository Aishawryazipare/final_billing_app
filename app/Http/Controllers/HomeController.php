<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
            $this->dealer = Auth::guard('dealer')->user();
            return $next($request);
        });
    }

    
    public function indexAdmin()
    {
        $date = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$id])
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
            $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id,'emp_id'=>$emp_id,'lid'=>$lid])->get();
        }  
        return view('admin.home',['today_en'=>$today_en,'status'=>$status]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $role = Auth::guard('web')->user()->role;// Auth::user()->role;
//        $id = Auth::guard('user')->user()->id;//Auth::user()->id;
        $date = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$id])
                  ->get();
        }else if(Auth::guard('web')->check()){
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
//             $status = App\EnquiryStatus::where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
        }  
        
       
//        echo "<pre>";print_r($today_en);exit;
        //if($role == '2'){
            //return redirect('add-enquiry');
        //}else{
//            $data = DB::table('tbl_enquiry as e')
//                        ->select(DB::raw('count(enquiry_id) as count_enq'),'tbl_enquiry_status.status_name','e.status_id')
//                        ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','=','e.status_id');
////                        ->leftjoin('users','users.id','=','e.emp_id')
//                    if($role == '2'){
//                            $data->where('emp_id','=',$id);
//                        }
//                   $enquiry_list =   $data->groupBy('e.status_id');
//                    $enquiry_list =  $data->get();
                    
        return view('home',['today_en'=>$today_en,'status'=>$status]);
        //}
    }
    
    public function empIndex(){
        $date = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$id])
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){						
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            if($role == 1){
                $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
                $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$cid,'emp_id'=>$emp_id])->get();
            }else{
            $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
               $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$cid,'emp_id'=>$emp_id])->get();
            }
            
        }  
       
        return view('employee.home',['today_en'=>$today_en,'status'=>$status]);
    }
    public function dealerIndex(){
        $date = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$id])
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id])->get();
        }
        else if(Auth::guard('dealer')->check()){
           $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
        }
        else if(Auth::guard('web')->check()){
             $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            if($role == 1){
                $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
                $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$cid,'emp_id'=>$emp_id])->get();
            }else{
            $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
                  ->get();
               $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$cid,'emp_id'=>$emp_id])->get();
            }
        }
        return view('dealer.home');
    }
    public function showClients()
    {
        if(Auth::guard('dealer')->check())
        {
            $dealer_id = Auth::guard('dealer')->user()->dealer_id;
            $dealer_code = Auth::guard('dealer')->user()->dealer_code;
            $client_data=DB::table('tbl_Registration')
                    ->where('reg_dealercode','=',$dealer_code)
                    ->get();
            return view('dealer.dealer_clients',['client_data'=>$client_data]);
        }
    }
    
    

    
}
