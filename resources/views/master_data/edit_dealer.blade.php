@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
      <h1>
          Edit Dealer
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Dealer</li>
      </ol>
    </section>
   <section class="content">
<div class="row">
 <div class="col-md-12">
          <div class="box" style="border-top: 3px solid #ffffff;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <form class="form-horizontal" id="dealerEditForm" method="post" action="{{ url('edit-dealer') }}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="userName" class="col-sm-2 control-label">Dealer Name</label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="dealer_name" placeholder="Name" name="dealer_name" required value="{{$dealer_data->dealer_name}}">
                  </div>
                    <label for="userName" class="col-sm-2 control-label">Owner Name</label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="owner_name" placeholder="Name" name="owner_name" required value="{{$dealer_data->owner_name}}">
                  </div>
                  
                   <input style="display: none;" type="text" class="form-control" id="dealer_id" name="dealer_id" required value="{{$dealer_data->dealer_id}}">
                                  </div>
                <div class="form-group">  
                  <label for="company" class="col-sm-2 control-label">Mobile No.</label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="dealer_mobile_no" placeholder="Mobile No." name="dealer_mobile_no" required maxlength="10" onkeypress="return isNumberKey(event)" value="{{$dealer_data->dealer_mobile_no}}">
                  </div>
                  <label for="gst" class="col-sm-2 control-label">Email ID</label>

                  <div class="col-sm-4">
                    <input type="email" class="form-control" id="email" placeholder="Email ID" name="email" required value="{{$dealer_data->email}}">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Address</label>  
                    <div class="col-sm-4">
                    <textarea class="form-control" rows="3" placeholder="Enter Address..." name="dealer_address">{{$dealer_data->dealer_address}}</textarea>   
                    </div>
                </div>
                 <div class="form-group">
                  <label for="gst" class="col-sm-2 control-label">State</label>
                  <div class="col-sm-4">
                    <!--<input type="text" class="form-control" id="dealer_state" placeholder="State" name="dealer_state" required>-->
                    <select class="form-control select2" style="width: 100%;" id="dealer_state" name="dealer_state" required>
                        <option value="{{$dealer_data->dealer_state}}">{{$dealer_data->dealer_state}}</option>
                        @foreach($state_list as $st)
                            <option value="{{$st->state_name}}">{{$st->state_name}}</option>
                        @endforeach
                    </select>
                  </div>
                   <label for="gst" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-4">
                    <!--<input type="text" class="form-control" id="dealer_city" placeholder="City" name="dealer_city" required>-->
                    <select class="form-control select2" style="width: 100%;" name="dealer_city" id="dealer_city" required>
                    <option value="{{$dealer_data->dealer_city}}">{{$dealer_data->dealer_city}}</option>
                        @foreach($city_list as $ct)
                            <option value="{{$ct->city_name}}">{{$ct->city_name}}</option>
                        @endforeach
                    </select>
                  </div> 
                </div>
                  <div class="form-group">
                   <label for="gst" class="col-sm-2 control-label">GST No.</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="dealer_gst_no" placeholder="GST No." name="dealer_gst_no" required value="{{$dealer_data->dealer_gst_no}}">
                  </div>
                       <label for="gst" class="col-sm-2 control-label">Dealer Code</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="dealer_code" placeholder="Dealer Code" name="dealer_code" required value="{{$dealer_data->dealer_code}}" readonly>
                  </div>
                  </div>  
              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                  <a href="{{url('add_dealer')}}" class="btn btn-danger" >Cancel</a>
              </div>
            </form>
          </div>
        </div>   
</div>
  </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
}
 $(document).ready(function(){
    $('.select2').select2() 
    $("#btn_submit").click(function(){
        $("#dealerEditForm").submit();
    });
 });
</script>
@endsection