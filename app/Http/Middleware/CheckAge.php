<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         if(!Auth::guard('admin')->check()  && !Auth::guard('employee')->check())
       {
           return redirect('/');
       }
       /*if(!Auth::guard('employee')->check())
       {
           return redirect('employee-login');
       }*/
       
       return $next($request);
    }
}
