@extends('layouts.login')

@section('content')
<style>
    .error{
        color:red;
    }
</style>
<section class="content">
    
  <div class="register-box">
  <div class="register-logo">
    <a href="/" style="color:white;"><b>Billing</b> App</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form  id="register_form" method="POST" action="{{ url('client-register') }}" aria-label="{{ __('Register') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" name="reg_companyname" id="reg_companyname" class="form-control" placeholder="Company Name" required >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="text" name="reg_personname" id="reg_personname" class="form-control" placeholder="Contact Person Name" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="text" name="reg_mobileno" onkeypress="return phoneno(event)" id="reg_mobileno" class="form-control" placeholder="Mobile" required>
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="email" name="reg_emailid" id="reg_emailid" class="form-control" placeholder="Email Address" >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="text" name="reg_address" id="reg_address" class="form-control" placeholder="Address" required>
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
      </div>
      <div class="form-group">
        <label class="">
            <div class="iradio_minimal-blue checked" aria-checked="true" aria-disabled="false" style="position: relative;"><input type="radio" name="location" class="minimal" value="single" checked="" style="position: absolute; opacity: 0;" required> Single Location</div>
        </label>
        <label class="">
            <div class="iradio_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="radio" name="location" class="minimal" value="multiple" style="position: absolute; opacity: 0;" required> Multi Location</div>
        </label>
      </div>
      <div class="form-group has-feedback">
          <input type="text" name="reg_username" id="reg_username" class="form-control" placeholder="Username" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="password" name="reg_userpassword" id="reg_userpassword" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" id="reg_companyid" id="reg_companyid" class="form-control" placeholder="Business" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="text" id="reg_dealercode" name="reg_dealercode" class="form-control" placeholder="Dealer Code" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
       <div class="form-group has-feedback">
           <b>Upload Logo</b>
      </div>              
      <div class="form-group has-feedback">
          <input type="file" id="reg_dealercode" name="upload_logo" class="form-control" placeholder="Upload Logo" >
        <span class="glyphicon glyphicon-folder-open form-control-feedback"></span>
      </div>
      <div class="form-group">
        <label class="">
          <div class="icheckbox_minimal-blue checked" aria-checked="false" aria-disabled="false" style="position: relative;">
              <input type="checkbox" class="minimal" name="permission[]" value="1" id="billing" style="position: absolute; opacity: 0;" required> Billing App
          </div>
        </label>
		
<!--        <label class="">
          <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
              <input type="checkbox" class="minimal" name="permission[]" id="enquiry" value="2" style="position: absolute; opacity: 0;" required> Enquiry App
          </div>
        </label>-->
      </div>
      <div class="row">
        <div class="col-xs-8">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <a href="{{url('admin-login')}}" class="btn btn-primary btn-block btn-flat">Login</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

<!--    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div>-->

    <!--<a href="login.html" class="text-center">I already have a membership</a>-->
  </div>
  <!-- /.form-box -->
</div>
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
                
                $("#email").focusout(function () {
                var email = $(this).val();
                $.ajax({
                    url: 'email-validate/' + email,
                    type: "GET",
                    success: function (data) {
                        console.log(data);
                        $("#email_validate").html(data);
                        if (data != "") {
                            $("#email").val("");
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
            $('#reg_mobileno').keypress(function(e) {
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