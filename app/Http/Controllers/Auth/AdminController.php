<?php

 

namespace App\Http\Controllers\Auth;

 

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

 

class AdminController extends Controller

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

 

    protected $guard = 'admin';

 

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/home-admin';

 

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
        return view('admin.login');
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
            'reg_mobileno' => 'required',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt(['reg_mobileno' => $request->reg_mobileno, 'password' => $request->password , 'activate_flag' => 1], $request->get('remember'))) {
            return redirect('home-admin');
        }
        return back()->withErrors(['email' => 'Mobile or password are wrong or your accoount is not activate.']);
    }
    
    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('admin-login' );
    }
    
    public function validateCredentials(UserContract $user, array $credentials)
    {
      $plain = $credentials['reg_userpassword'];

      return $this->hasher->check($plain, $user->getAuthPassword());
    }

}