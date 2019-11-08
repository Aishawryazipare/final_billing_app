@extends('layouts.login')
@section('content')
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<div class="login-box">
  <div class="login-logo">
    <a href="/" style="color:white;"><b>Admin airBill Plus</b> App</a>
  </div>
<!--    <div class="" style="text-align: center;">
        <img src="dist/img/logo3_new.png" class="img-circle" alt="User Image">
    </div>-->
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Log in to start your session</p>                        
                        <form method="POST" action="{{ url('admin-login') }}" aria-label="{{ __('Login') }}">
                            @csrf
<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="text" id="email" name="reg_mobileno" class="form-control" placeholder="Mobile">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
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
    <div class="form-group has-feedback"></div>
              <!-- /.row -->
        <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <div class="col-xs-6">
          <a href="{{url('client-register')}}" class="btn btn-primary btn-block btn-flat">Register</a>
        </div>
        </div>
    </form>
  </div>
</div>
<script>
    function check(cid)
    {
            $.ajax({
        url: 'check_location',
        type: "get",
        data: {cid:cid},
        success: function(reportdata) { 
                alert(reportdata);
            }
        });
    }
</script>
@endsection