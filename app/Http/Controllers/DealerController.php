<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Dealer;
use App\Machine;
use Session;
class DealerController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
//       $this->middleware(function ($request, $next) {
//            $this->user= Auth::user();
//
//            return $next($request);
//        });
    }
    
    public function login()
    {
        return view('dealer.login');
    }
    
    public function dealerLogin(Request $request)
    {
//         echo "<pre>";
//         print_r($request->all());
//         exit;
       
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('dealer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('dealer_data');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
   
    public function getDealerData() {
        $dealer_data = DB::table('bil_dealer')->where(['is_active' => '1'])->orderBy('dealer_name', 'asc')->get();
        return view('master_data.dealer_data',['dealer_data' => $dealer_data]);
    }
    
    public function getMachineData() {
        $machine_data = DB::table('bil_machine_data')->where(['is_active' => '1'])->orderBy('machine_model_no', 'asc')->get();
        return view('master_data.machine_data',['machine_data' => $machine_data]);
    }
    
    public function generateCode($digits = 4) 
    {
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits)
        {
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }  
    
    public function getDealer() {
        $u_dealer_code=uniqid();
        //If I want a 4-digit PIN code.
        $code = $this->generateCode();
        $result= Dealer::select('dealer_code')
                ->where('dealer_code','=',$code)
                ->first();
        if(!empty($result))
        {
            $code=$code+15;
        }
//        echo $code;
////If I want a 6-digit PIN code.
//        $pin = generatePIN(6);
//        echo $pin;
//        exit;
        $state_list=DB::table('bil_states')->get();
        $city_list=DB::table('bil_cities')->get();
        return view('master_data.add_dealer',['state_list'=>$state_list,'city_list'=>$city_list]);
    }
    
    public function getDealerCode(Request $request) {
//       echo "<pre>";
//       print_r($request['dealer_code']);
       $code=$request['dealer_code'];
       $result= Dealer::select('dealer_code')->where('dealer_code','=',$code)->first();
       if(!empty($result))
       {
            echo json_encode("present");
       }
       else
       {
           echo json_encode("not present");
       }
    }
    
    public function getMachine() {
        return view('master_data.add_machine');
    }
       
    public function addDealer(Request $request) {
        $requestData = $request->all();
        $requestData['password'] = bcrypt($requestData['password']);
//        echo "<pre>";
//        print_r($requestData);
//        exit;
        Dealer::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('dealer_data');
    }
    
    public function addMachine(Request $request) {
        $requestData = $request->all();
        Machine::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('machine_data');
    }
       
    public function editDealer()
    {
        $dealer_id=$_GET['dealer_id'];
        $query = Dealer::where('dealer_id', $dealer_id)->where(['is_active' => '1'])->first();
        $state_list=DB::table('bil_states')->get();
        $city_list=DB::table('bil_cities')->get();
        return view('master_data.edit_dealer',['dealer_data' => $query,'state_list'=>$state_list,'city_list'=>$city_list]);
    }
    
    public function editMachine()
    {
        $machine_id=$_GET['machine_id'];
        $query = Machine::where('machine_id', $machine_id)->where(['is_active' => '1'])->first();
        return view('master_data.edit_machine',['machine_data' => $query]);
    }
        
    public function updateDealer(Request $request)
    {
        $requestData = $request->all();
        $dealer_id=$requestData['dealer_id'];
        $owner_name=$requestData['owner_name'];
        $dealer_name=$requestData['dealer_name'];
        $dealer_mobile_no=$requestData['dealer_mobile_no'];
        $dealer_gst_no=$requestData['dealer_gst_no'];
        $email=$requestData['email'];
        $dealer_address=$requestData['dealer_address'];
        $dealer_state=$requestData['dealer_state'];
        $dealer_city=$requestData['dealer_city'];
        $dealer_code=$requestData['dealer_code'];
        $query =Dealer::findorfail($dealer_id);
        if(!empty($query))
        {
            $res=DB::table('bil_dealer')
                ->where('dealer_id', '=',$dealer_id)
                ->update([
                    'owner_name'=>$owner_name,
                    'dealer_name'=>$dealer_name,
                    'dealer_mobile_no'=>$dealer_mobile_no,
                    'dealer_gst_no'=>$dealer_gst_no,
                    'email'=>$email,
                    'dealer_address'=>$dealer_address,
                    'dealer_state'=>$dealer_state,
                    'dealer_city'=>$dealer_city,
                    'dealer_code'=>$dealer_code,
                     ]);
            if($res==1)
            {
                Session::flash('alert-success','Updated Successfully.');
            }
            else
            {
                Session::flash('alert-error','Something went wrong');
            }
        }
        else
        {
            Session::flash('alert-error','Something went wrong');
        }
        
        return redirect('dealer_data');
    }
    
     public function updateMachine(Request $request)
    {
        $requestData = $request->all();
        $machine_id=$requestData['machine_id'];
        $machine_model_no=$requestData['machine_model_no'];
        $machine_ser_no=$requestData['machine_ser_no'];
        $query =Dealer::findorfail($machine_id);
        if(!empty($query))
        {
            $res=DB::table('bil_machine_data')
                ->where('machine_id', '=',$machine_id)
                ->update(['machine_model_no'=>$machine_model_no,
                    'machine_ser_no'=>$machine_ser_no,
                     ]);
            if($res==1)
            {
                Session::flash('alert-success','Updated Successfully.');
            }
            else
            {
                Session::flash('alert-error','Something went wrong');
            }
        }
        else
        {
            Session::flash('alert-error','Something went wrong');
        }
        
        return redirect('machine_data');
    }
    
    public function deleteDealer($dealer_id)
    {
        $status = 0;
        $query = Dealer::where('dealer_id', $dealer_id)->update(['is_active' => $status]);
        return redirect('dealer_data');
    }
    
    public function deleteMachine($machine_id)
    {
        $status = 0;
        $query = Machine::where('machine_id', $machine_id)->update(['is_active' => $status]);
        return redirect('machine_data');
    }

    public function getSerialNo(Request $request) 
    {
       $machine_ser_no=$request['machine_ser_no'];
       $result= Machine::select('machine_ser_no')->where('machine_ser_no','=',$machine_ser_no)->first();
       if(!empty($result))
       {
            echo json_encode("present");
       }
       else
       {
           echo json_encode("not present");
       }
    }

}