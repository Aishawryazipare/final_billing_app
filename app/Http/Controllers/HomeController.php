<?php

namespace App\Http\Controllers;
use App\Item;
use App\BillDetail;
use App\EnquiryLocation;
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
            $location = $this->admin->location;
//            echo $location;
//            exit;
            if($location=="multiple")
            {
                $total_items=Item::where('cid', '=', $id)->count();
                $total_sales= BillDetail::where('cid', '=', $id)->count();
				$total_sales_amount= BillDetail::where('cid', '=', $id)->sum('item_totalrate');
                $total_loc= EnquiryLocation::where('cid', '=', $id)->count();
                $top_loc="";
                $top_items="";
                $top_items= DB::table('bil_AddBillDetail')
                     ->select('item_name')
                     ->where('cid', '=', $id)
                     ->selectRaw('sum(item_qty) as item_qty')
                     ->groupby('item_name')
                     ->orderby('item_qty','desc')
                     ->limit(4)
                     ->get();
                $top_loc= DB::table('bil_AddBillDetail')
                     ->leftjoin('bil_location','bil_location.loc_id','=','bil_AddBillDetail.lid')
                     ->select('bil_location.loc_name')
                     ->where('bil_AddBillDetail.cid', '=', $id)
                     ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                     ->groupby('bil_location.loc_name')
                     ->orderby('orders','desc')
                     ->get();
                $pie_loc= DB::table('bil_AddBillDetail')
                     ->leftjoin('bil_location','bil_location.loc_id','=','bil_AddBillDetail.lid')
                     ->select('bil_location.loc_name')
                     ->where('bil_AddBillDetail.cid', '=', $id)
                     ->selectRaw('sum(bil_AddBillDetail.item_totalrate) as amount')
                     ->selectRaw('sum(bil_AddBillDetail.item_qty) as qty')
                     ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                     ->groupby('bil_location.loc_name')
                     ->orderby('orders','desc')
                     ->get();   
                $data=array();
                foreach($pie_loc as $loc)
                {
                    $data['name']=$loc->loc_name;
                    $data['y']=$loc->orders;
                    $data['custom']=$loc->qty;
                    $data['custom1']=$loc->amount;
                    $final_pie[]=$data;
                }
				 $items=DB::table('bil_AddItems')
                     ->leftjoin('bil_location','bil_location.loc_id','=','bil_AddItems.lid')
                     ->select('bil_location.loc_name','bil_AddItems.item_name')
                     ->where('bil_AddItems.cid', '=', $id)
                     ->orderby('bil_AddItems.item_name','desc')
                     ->get(); 
//                echo "<pre>";
//                print_r($items);
//                exit;
                return view('admin.home',['total_items'=>$total_items,'total_sales'=>$total_sales,'top_items'=>$top_items,'total_loc'=>$total_loc,'top_loc'=>$top_loc,'final_pie'=>$final_pie,'items'=>$items,'total_sales_amount'=>$total_sales_amount]);
//                echo "<pre>";
//                print_r($final_pie);
//                exit;
                //return view('admin.home',['total_items'=>$total_items,'total_sales'=>$total_sales,'top_items'=>$top_items,'total_loc'=>$total_loc,'top_loc'=>$top_loc,'final_pie'=>$final_pie]);
            }
            if($location=="single")
            {
                $total_items=Item::where('cid', '=', $id)->count();
                $total_sales= BillDetail::where('cid', '=', $id)->count();
				$total_sales_amount= BillDetail::where('cid', '=', $id)->sum('item_totalrate');
                $total_loc= EnquiryLocation::where('cid', '=', $id)->count();
                $top_loc="";
                $top_items="";
                $top_items= DB::table('bil_AddBillDetail')
                     ->select('item_name')
                     ->where('cid', '=', $id)
                     ->selectRaw('sum(item_qty) as item_qty')
                     ->groupby('item_name')
                     ->orderby('item_qty','desc')
                     ->limit(4)
                     ->get();
                $top_loc= DB::table('bil_AddBillDetail')
                     ->leftjoin('bil_location','bil_location.loc_id','=','bil_AddBillDetail.lid')
                     ->select('bil_location.loc_name')
                     ->where('bil_AddBillDetail.cid', '=', $id)
                     ->selectRaw('count(DISTINCT(bil_AddBillDetail.bill_no)) as orders')
                     ->groupby('bil_location.loc_name')
                     ->orderby('orders','desc')
                     ->limit(4)
                     ->get();
                return view('admin.home-single',['total_items'=>$total_items,'total_sales'=>$total_sales,'top_items'=>$top_items,'total_loc'=>$total_loc,'total_sales_amount'=>$total_sales_amount]);
//                return view('admin.home-single');
            }
            
        }
        
    }
    
//    public function indexAdmin()
//    {
//        $date = date('Y-m-d');
//        if(Auth::guard('admin')->check()){
//            $id = $this->admin->rid;
//            $today_en = DB::table('tbl_enquiry')
//                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
//                  ->where('followup_date','=',$date)
//                  ->where(['cid'=>$id])
//                  ->get();
//             $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id])->get();
//        }else if(Auth::guard('web')->check()){
//             $today_en = DB::table('tbl_enquiry')
//                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
//                  ->where('followup_date','=',$date)
//                  ->get();
//             $status = \App\EnquiryStatus::where(['is_active'=>0])->get();
//        }
//        else if(Auth::guard('employee')->check()){
//            $cid = $this->employee->cid;
//            $lid = $this->employee->lid;
//            $emp_id = $this->employee->id;
//            $today_en = DB::table('tbl_enquiry')
//                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
//                  ->where('followup_date','=',$date)
//                  ->where(['cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])
//                  ->get();
//            $status = \App\EnquiryStatus::where(['is_active'=>0,'cid'=>$id,'emp_id'=>$emp_id,'lid'=>$lid])->get();
//        }  
//        return view('admin.home',['today_en'=>$today_en,'status'=>$status]);
//    }
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
	   public function send()
    {
        $msg=$_GET['data'];
        $conn = mysqli_connect("localhost","root","","billing_app_new");
		$sql = " select token,id from tbl_employees";
		$result = mysqli_query($conn,$sql);
		$date = date('Y-m-d');
		$tokens = array();
		if(mysqli_num_rows($result) > 0 ){
			while ($row = mysqli_fetch_assoc($result)) {
				$tokens = array($row["token"]);
				$message = array("message" => "Please Sync Data For ".$msg);
				$this->send_notification($tokens,$message);
			}
		}
		mysqli_close($conn);
    }
    	public function send_notification($tokens,$message){
         $url = 'https://fcm.googleapis.com/fcm/send';
         $arr=array(1,2,3,4,5,6,7);
//         print_r($arr);
//         exit;
         
         
		$fields = array(
			 'registration_ids' => $tokens,
			 'data' => $message,
                        'arr'=>$arr
			);
			
		//print_r($fields);
		
		$headers = array(
			'Authorization:key=AIzaSyC9US8Sm1i0JsBoQ7Z75L3xiGqjcV7jOBo',
			'Content-Type:application/json'
			);
	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
//       print_r($result);
//       exit;
       return $result;
    } 
    
    

    
}
