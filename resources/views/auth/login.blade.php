@extends('layouts.login')
@section('content')
<style>
    .error{
        color: red;
    }
</style>
<div class="login-box">
  <div class="login-logo">
    <a href="/" style="color:white;"><b>airBill Plus</b> App</a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Log in to start your session</p>
                        @isset($url)
                        <form method="POST" action='{{ url("login/$url") }}' id="register_form" aria-label="{{ __('Login') }}">
                        @else
                        <form method="POST" action="{{ route('login') }}" id="register_form"  aria-label="{{ __('Login') }}">
                        @endisset
                            @csrf
<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
        <div class="row">
<!--        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>-->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){

            var jvalidate = $("#register_form").validate({
                rules: {   
                        email: {required: true},
                        password : {required: true},
                    },
                     messages: {
                         email: "Please Enter Email Address",
                         password: "Please Enter Password"
                       }  
                });
                
                $('#btnsubmit').on('click', function() {
                    $("#orderForm").valid();
                });
                
        </script>
@endsection