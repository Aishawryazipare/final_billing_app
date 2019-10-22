<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Dealer;
use App\Machine;
use App\Subscription;
use Session;


class CustomerController extends Controller
{
    public function __construct()
    {
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            return $next($request);
        });
    }
    
    public function getCustomerData()
    {
//        $type = DB::table('tbl_customer')->where(['is_active' => '1'])->orderBy('cust_name', 'asc')->get();
        return view('master_data.customer_data');
    }
       
}