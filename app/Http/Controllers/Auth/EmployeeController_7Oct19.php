<?php

 

namespace App\Http\Controllers\Auth;

 

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

 

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
            return redirect('add-enquiry');
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