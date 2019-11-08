@extends('layouts.app')
@section('title', 'Type-List')
@section('content')
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <section class="content-header">
      <h1>
        Edit Customer
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Edit Customer</li>
      </ol>
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif
    </section>
    <section class="content">
     <div class="row">
<!--        <div class="col-md-3"></div>-->
       <div class="col-md-10">
         <div class="box box-primary">
           <div class="box-header with-border">
             <h3 class="box-title">Edit Customer</h3>
           </div>
             <form action="{{ url('edit-cust') }}" method="POST" id="type_form" class="form-horizontal" >
               {{ csrf_field() }}
               <div class="box-body">
                   <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Customer Name<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="item_id" placeholder="Type" name="cust_id" value="{{$cust_data->cust_id}}" style="display:none;">
                            <input type="text" class="form-control" id="type_name" placeholder="Customer Name" name="cust_name" value="{{$cust_data->cust_name}}">
                        </div>
                    </div>
                   <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Contact Person<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="contact_person" value="{{$cust_data->contact_person}}" placeholder="Contact Person" name="contact_person" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Mobile No.<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Mobile No." name="mob_no" value="{{$cust_data->mob_no}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Email ID<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Email ID" name="email_id" value="{{$cust_data->email_id}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="type_name" placeholder="Address" name="address" >{{$cust_data->address}}</textarea>
                        </div>
                    </div>
                   <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" style="width: 100%;" name="state" id="state" required>
                                    <option value="">-- Select State -- </option>
                                    @foreach($state as $st)
                                    <option value="{{$st->id}}" <?php if($st->id == $cust_data->state) echo "selected"; ?>>{{$st->state}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" style="width: 100%;" id="city" name="city" required>
                                <option value="">-- Select City -- </option>
                                @foreach($city as $c)
                                <option value="{{$c->city_id}}" <?php if($c->city_id == $cust_data->city) echo "selected"; ?>>{{$c->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Pin Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="type_name" placeholder="Pin Code" name="pincode" value="{{$cust_data->pincode}}">
                        </div>
                    </div>
               </div>
             <div class="box-footer">
               <button type="submit" class="btn btn-info" id="btn_submit" name="btn_submit">Update</button>
               <a href="{{url('cust_data')}}" class="btn btn-danger" >Cancel</a>
             </div>
           </form>
         </div>
       </div>
     </div>
   </section>
 
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function(){
//    alert();
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete user');
    });
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection
