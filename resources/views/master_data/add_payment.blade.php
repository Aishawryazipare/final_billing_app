@extends('layouts.app')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
    <h1>
      Add Payment Type
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
      <li class="active">Add Payment Type</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Payment Type</h3>
            </div>
              <form action="{{ url('add_payment_type') }}" method="POST" id="type_form" class="form-horizontal" >
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Payment Type<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="payment_type" placeholder="Payment Type" name="payment_type">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Point Of Contact<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="point_of_contact" placeholder="Point Of Contact" name="point_of_contact">
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script src="js/sweetalert.min.js"></script>
<script>
     $(document).ready(function(){
    $('.select2').select2() 
    $(".unit_name").focusout(function(){
        var category = $(this).val();
         $.ajax({
                    url: 'check-exist',
                            type: "GET",
                            data: {type:"Payment",data:category},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            if(a=="Already Exist")
                            {
                                swal({
  position: 'top-end',
  type: 'warning',
  title: 'Already Exist',
  showConfirmButton: false,
  timer: 1500
}); 
                            }
                        }
                    });
    });
 })
 var jvalidate = $("#type_form").validate({
    rules: { 
            password : {required: true},
        },
         messages: {
             Payment_name: "Please Enter Payment Name",
             Payment_Taxvalue: "Please Enter Payment Tax Value"
           }  
    });    
</script>
@endsection
