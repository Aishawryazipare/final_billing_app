<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BrandController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public function __construct()
    {
       $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    public function getBrandData()
    {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $brand_data = DB::table('tbl_brand')
                    ->select('tbl_brand.*','tbl_category.cat_name')
                    ->leftjoin('tbl_category','tbl_category.cat_id','=','tbl_brand.cat_id')
                    ->orderBy('brand_id', 'asc')
                    ->where('tbl_brand.is_active','0')
                    ->where(['tbl_brand.cid'=>$id])
                    ->get();
        }else if(Auth::guard('web')->check()){
            $brand_data = DB::table('tbl_brand')
                    ->select('tbl_brand.*','tbl_category.cat_name')
                    ->leftjoin('tbl_category','tbl_category.cat_id','=','tbl_brand.cat_id')
                    ->orderBy('brand_id', 'asc')
                    ->where('tbl_brand.is_active','0')
                    ->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $brand_data = DB::table('tbl_brand')
                    ->select('tbl_brand.*','tbl_category.cat_name')
                    ->leftjoin('tbl_category','tbl_category.cat_id','=','tbl_brand.cat_id')
                    ->orderBy('brand_id', 'asc')
                    ->where('tbl_brand.is_active','0')
                    ->where(['tbl_brand.cid'=>$cid,'tbl_brand.lid'=>$lid,'tbl_brand.emp_id'=>$emp_id])
                    ->get();
        }         
        return view('master_data.brand.brand_list',['brand_data' => $brand_data]);
    }
    
    public function getBrand() {
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
        } 
        return view('master_data.brand.add_brand',['category'=>$category]);
    }
     public function addBrandData(Request $request) {
        $requestData = $request->all();
//        echo "<pre>";
//        print_r($requestData['cat_image']);
        if(Auth::guard('admin')->check()){
            $requestData['cid'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['cid'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['emp_id'] = $this->employee->id;
        }
        $requestData['created_at'] = date('Y-m-d h:m:s');
        \App\Brand::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('brand_list');
    }
    
    public function deleteBrand($id)
    {
        $status = 1;
        $query = \App\Brand::where('brand_id', $id)
                ->update(['is_active' => $status]);
        return redirect('brand_list');
    }
    
    public function editBrand()
    {
        $id=$_GET['id'];
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $query = \App\Brand::where('brand_id', $id)->where(['is_active' => '0','cid'=>$id])->first();
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$id])->get();
        }else if(Auth::guard('web')->check()){
            $query = \App\Brand::where('brand_id', $id)->where(['is_active' => '0'])->first();
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1])->get();
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $query = \App\Brand::where('brand_id', $id)->where(['is_active' => '0','cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->first();
            $category = \App\Category::select('cat_id','cat_name')->where(['is_active'=>1,'cid'=>$cid,'lid'=>$lid,'emp_id'=>$emp_id])->get();
        } 
        return view('master_data.brand.edit_brand',['brand_data' => $query,'category'=>$category]);
    }
    
     public function updateBrand(Request $request)
    {
        $requestData = $request->all();
//        echo "<pre/>";print_r($requestData);exit;
        $id=$requestData['id'];
         $users = \App\Brand::findorfail($id);
         $requestData['modify_at'] = date('Y-m-d h:m:s');
        $users->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('brand_list');
    }
}