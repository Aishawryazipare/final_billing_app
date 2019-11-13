<?php

 

namespace App\Http\Controllers\Auth;

 

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Response;
use Cookie;

 

class EmployeeController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

    */

 

    use AuthenticatesUsers;

 

    protected $guard = 'employee';

 

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/add-enquiry';

 

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
//        $mobile = $request->cookie('mobile_no'); 
//        $pass = $request->cookie('password');
        return view('employee.login');
    }

//    protected function validateLogin(Request $request)
//    {
//        $this->validate($request, [
//           'email' => 'required',
//            'password' => 'required',
//        ]);
//    }

    public function username()
    {
        return 'reg_emailid';
    }

//    protected function credentials(Request $request)
//    {
//        return $request->only($this->username(), 'usePassword');
//    }
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile_no' => 'required',
            'password' => 'required',
        ]);
        if (auth()->guard('employee')->attempt(['mobile_no' => $request->mobile_no, 'password' => $request->password], $request->get('remember'))) {
           // $minutes = 1;
//            $minutes = 6*30*24*3600;
//            Cookie::queue('mobile_no', $request->mobile_no , $minutes);
//            Cookie::queue('password', $request->password , $minutes);
//            $response = new Response('Hello World');
//            $response->withCookie(cookie('mobile_no', $request->mobile_no , $minutes));
//            $response->withCookie(cookie('password', $request->password , $minutes));
            return redirect('employee-home');
        }
        return back()->withErrors(['email' => 'Email or password are wrong.']);
    }
    
    
    public function logout(Request $request)
    {
        auth()->guard('employee')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('employee-login' );
    }
    
   

}