<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    protected $loginPath = 'admin-login';  
    public function authenticate()
    {
        //update
        $email = Input::get('email'); 
        $password = Input::get('password');
        if (Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 0 ])) {
            // Authentication passed...
            return redirect('/');
        }
    }
}