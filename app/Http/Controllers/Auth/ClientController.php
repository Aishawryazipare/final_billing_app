<?php

namespace App\Http\Controllers\Auth;

 

use App\Http\Controllers\Controller;

    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Http\Request;
    use Session;

class ClientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        //$this->middleware('auth');
//         $this->middleware('auth');
//    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
//    protected function create(array $data)
//    {
//        return Admin::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);
//    }
    
    public function showRegform()
    {
        return view('admin.register');
    }

   
    protected function create(Request $request)
    {
//        echo "<pre>";print_r($request->all());exit;
        $request = $request->all();
//        $this->validator($request->all())->validate();
        if(isset($request['upload_logo'])) {
            $design = $request['upload_logo'];
            $filename = rand(0,999).$design->getClientOriginalName();
            $destination= "logo/";
            $design->move($destination,$filename);
            $request['upload_logo'] = $filename;            
        }else{
			$request['upload_logo'] = "";      
		}
//        echo "<pre>";print_r($request);exit;
        $admin = \App\Admin::create([
            'reg_companyname' => $request['reg_companyname'],
            'reg_personname' => $request['reg_personname'],
            'reg_mobileno' => $request['reg_mobileno'],
            'reg_emailid' => $request['reg_emailid'],
            'reg_address' => $request['reg_address'],
            'reg_username' => $request['reg_username'],
            'reg_dealercode' => $request['reg_dealercode'],
            'created_at'=> date('Y-m-d h:m:s'),
            'password' => bcrypt($request['reg_userpassword']),
            'location' => $request['location'],
            'permission' => json_encode($request['permission']),
            'upload_logo' => $request['upload_logo']
        ]);
        Session::flash('alert-success','Register Successfully.');
        return redirect('/');
    }
    
}
