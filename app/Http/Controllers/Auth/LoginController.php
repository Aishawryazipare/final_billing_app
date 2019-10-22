<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
//     public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//        $this->middleware('guest:admin')->except('logout');
//        $this->middleware('guest:writer')->except('logout');
//        $this->middleware('guest:dealer')->except('logout');
//        $this->middleware('guest:employee')->except('logout');
//    }
    
    public function logout(Request $request)
    {
        $this->guard()->logout();
        return $this->loggedOut($request) ?: redirect('/');
    }
    
//    
//    public function logout(Request $request)
//    {
////        print_r($request->all());
////        exit;
//        
//        $request->session()->invalidate();
//        if(Auth::guard('admin'))
//        {
//             return $this->loggedOut($request) ?: redirect('admin-login');
//        }
//        else if(Auth::guard('employee'))
//        {
//             return $this->loggedOut($request) ?: redirect('employee-login');
//        }
//        else if(Auth::guard('dealer'))
//        {
//             return $this->loggedOut($request) ?: redirect('dealer-login');
//        }
//        else
//        {
//            $this->guard()->logout();
//            return $this->loggedOut($request) ?: redirect('/');
//        }
//    }
}
