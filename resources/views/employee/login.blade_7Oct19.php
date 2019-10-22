@extends('layouts.login')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="/" style="color:white;"><b>Employee One Care</b> App</a>
  </div>
<!--    <div class="" style="text-align: center;">
        <img src="dist/img/logo3_new.png" class="img-circle" alt="User Image">
    </div>-->
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Log in to start your session</p>
                        
                        <form method="POST" action="{{ url('employee-login') }}" aria-label="{{ __('Login') }}">
                            @csrf
<div class="form-group has-feedback {{ $errors->has('mobile_no') ? ' has-error' : '' }}">
        <input type="text" id="mobile_no" name="mobile_no" class="form-control" placeholder="Mobile">
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
<!--                             <div class="row">
                <div class="col-lg-6">
               <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="role" value="1">
                        </span>
                    <input type="text" class="form-control" value="Admin" readonly>
                  </div>
                   /input-group 
                </div>
                 /.col-lg-6 
                <div class="col-lg-6">
                  <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="role" value="2">
                        </span>
                    <input type="text" class="form-control" value="Employee" readonly>
                  </div>
                   /input-group 
                </div>
                 /.col-lg-6 
              </div>-->
                            <!--<br/>-->
<!--                             <div class="form-group has-feedback">
                                 <input type="text" class="form-control" placeholder="CID" class="cid" id="cid" name="cid" onkeyup="check(this.value);" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        
      </div>-->
                            <div class="form-group has-feedback">
<!--        <select class="form-control select2" style="width: 100%;" name="item_category" required>
                        <option value="">-- Select Location -- </option>
                        <option value="1">Pune</option>
                        <option value="2">Solapur</option>-->
                    </select>
        
      </div>
                            
              <!-- /.row -->
        <div class="row">
<!--        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox"> Remember Me
                </label>
            </div>
        </div>-->
        <!-- /.col -->
        <div class="col-xs-4">
          <!--<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>-->
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        <!-- /.col -->
        </div>
    </form>

<!--    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>-->
    <!-- /.social-auth-links -->

    <!--<a href="#">I forgot my password</a>
    --><br>
<!--    <div style="text-align:center;">
  </div>
  <!-- /.login-box-body -->
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