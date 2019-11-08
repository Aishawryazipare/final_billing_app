@extends('layouts.app')
@section('title', 'Add Supplier')
@section('content')
<section class="content-header">
      <h1>
          Add Supplier
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Add Supplier</li>
      </ol>
    </section>
   <section class="content">
<div class="row">
 <div class="col-md-12">
          <div class="box" style="border-top: 3px solid #ffffff;border: 2px solid #00ffc3;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <form class="form-horizontal" id="userForm" method="post" action="{{ url('add_supplier') }}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="userName" class="col-sm-2 control-label">Name<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="sup_name" placeholder="Company Name" name="sup_name" required>
                  </div>
                  <label for="company" class="col-sm-2 control-label">Mobile No.<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="sup_mobile_no" placeholder="Mobile No." name="sup_mobile_no" required maxlength="10" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                 <div class="form-group">
                   
                    <label for="gst" class="col-sm-2 control-label">Email<span style="color:#ff0000;">*</span></label>
                  <div class="col-sm-4">
                      <input type="email" class="form-control" id="sup_email" placeholder="Email" name="sup_email_id" required>
                  </div> 
                    <label for="gst" class="col-sm-2 control-label">GST No.</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="sup_gst_no" placeholder="GST No." name="sup_gst_no">
                  </div>
                </div>
                    <div class="form-group">
                  
                <label class="col-sm-2 control-label">Address</label>  
                    <div class="col-sm-4">
                    <textarea class="form-control" rows="3" placeholder="Enter Address..." name="sup_address" id="sup_address"></textarea>   
                    </div>
                </div>
                
                  
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                  <a href="{{url('supplier_data')}}" class="btn btn-danger" >Cancel</a>
                  
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
function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
}
 $(document).ready(function(){
    $('.select2').select2() 
 });
</script>
@endsection
