<?php

 

namespace App\Http\Controllers\Auth;

 

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Response;
use Cookie;

 

class DealerLoginController extends Controller

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

 

    protected $guard = 'dealer';

 

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/dealer-home';

 

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
//        echo "hello";
//        exit;
        return view('dealer.login');
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
//        echo "<pre>";
//        print_r($request->all());
//        exit;
        
        $this->validate($request, [
            'dealer_mobile_no' => 'required',
            'password' => 'required',
        ]);
        if (auth()->guard('dealer')->attempt(['dealer_mobile_no' => $request->dealer_mobile_no, 'password' => $request->password], $request->get('remember'))) {
           // $minutes = 1;
            $minutes = 6*30*24*3600;
            Cookie::queue('dealer_mobile_no', $request->dealer_mobile_no , $minutes);
            Cookie::queue('password', $request->password , $minutes);
//            $response = new Response('Hello World');
//            $response->withCookie(cookie('mobile_no', $request->mobile_no , $minutes));
//            $response->withCookie(cookie('password', $request->password , $minutes));
            return redirect('dealer-home');
        }
        return back()->withErrors(['email' => 'Email or password are wrong.']);
    }
    
    
    public function logout(Request $request)
    {
        auth()->guard('dealer')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('dealer-login' );
    }
    
   

}