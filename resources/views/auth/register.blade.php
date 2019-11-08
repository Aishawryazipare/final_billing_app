@extends('layouts.app')

@section('content')
<style>
    .invalid-feedback{
        color:red;
    }
</style>
<?php 
if(Auth::guard('employee')->check()){
   $cid = Auth::guard('employee')->user()->cid;
   $client_loc = App\Admin::select('location')->where(['rid'=>$cid])->first();
   $location = $client_loc->location;
   $logeed_id = Auth::guard('employee')->user()->id; 
   $role = Auth::guard('employee')->user()->role;
}else if(Auth::guard('admin')->check()){
   $logeed_id = Auth::guard('admin')->user()->rid; 
   $location = Auth::guard('admin')->user()->location; 
}else if(Auth::guard('web')->check()){
   $logeed_id = Auth::guard('web')->user()->id; 
}
?>
<section class="content-header">
    <h1>
        User Register
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('user_mgt')}}"><i class="fa fa-dashboard"></i>Users</a></li>
        <li class="active">Add User</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="register_form" method="POST" action="{{ url('register') }}" aria-label="{{ __('Register') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Employee Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" placeholder="Employee Name" value="" name="name" required >
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="company" class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="role" required>
                                    <option value="">-- Select Role -- </option>
                                    <?php if($location == "multiple") { 
                                        if(Auth::guard('admin')->check()){ ?>
                                            <option value="1">Admin</option>
                                    <?php } }?>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" placeholder="Email" value="" name="email"  >
                            </div>
                            <code id="email_validate"></code>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" placeholder="Password" value="" name="password" required >
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" onkeypress="return phoneno(event)" id="mobile_no" placeholder="Mobile No" value="" name="mobile_no" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address" placeholder="Address" value="" name="address" required >
                            </div>
                        </div>
                        <?php if($location == "multiple") { 
                                        if(Auth::guard('admin')->check()){ ?>
                                    
                        <div class="form-group" >
                        <label for="company" class="col-sm-4 control-label">Location</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="lid" required>
                                    <option value="">-- Select Location -- </option>
                                    @foreach($city as $c)
                                    <option value="{{$c->loc_id}}">{{$c->loc_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <?php } }?>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{url('user-list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
 
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js'></script>-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){

            var jvalidate = $("#register_form").validate({
                rules: {   
                       // email: {required: true},
                        password : {required: true},
                    },
                     messages: {
                      //   email: "Please Enter Email Address",
                         password: "Please Enter Password"
                       }  
                });
                
                $('#btnsubmit').on('click', function() {
                    $("#orderForm").valid();
                });
                
                $("#mobile_no").focusout(function () {
                var email = $(this).val();
                $.ajax({
                    url: 'email-validate/' + email,
                    type: "GET",
                    success: function (data) {
                        console.log(data);
                        $("#email_validate").html(data);
                        if (data != "") {
                            $("#mobile_no").val("");
                        }
                    }
                });
            });
            
            function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function phoneno(){          
            $('#mobile_no').keypress(function(e) {
                var length = jQuery(this).val().length;
       if(length > 11) {
            return false;
       } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
       } else if((length == 0) && (e.which == 48)) {
            return false;
       }
            });
        }
        </script>
@endsection