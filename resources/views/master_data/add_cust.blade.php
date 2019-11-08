@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1>
      Add Customer
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Master Data</a></li>
      <li class="active">Add Customer</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Customer</h3>
            </div>
              <form action="{{ url('add_cust') }}" method="POST" id="cust_form" class="form-horizontal" >
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Customer Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Customer Name" name="cust_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="contact_person" placeholder="Contact Person" name="contact_person" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Mobile No.</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Mobile No." name="mob_no" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Email ID</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Email ID" name="email_id" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="type_name" placeholder="Address" name="address" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" style="width: 100%;" name="state" id="state" required>
                                    <option value="">-- Select State -- </option>
                                    @foreach($state as $st)
                                    <option value="{{$st->id}}">{{$st->state}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" style="width: 100%;" id="city" name="city" required>
                                <option value="">-- Select City -- </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Pin Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Pin Code" name="pincode" required>
                        </div>
                    </div>
                    
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                <a href="{{url('cust_data')}}" class="btn btn-danger" >Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
    $('div.alert').delay(3000).slideUp(300);

    $("#state").on("change",function(){
        var a = $(this).val();
        $.ajax({
        url: 'get_city/' + a,
        type: "GET",
        success: function(response) {
          $("#city").html(response);
        }
       });
    })
    
     $("#h_lost").on('click', '.remove_field', function () {
        $(this).parent().parent().remove();
    });


});
</script>
@endsection
