@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1>
      Edit Subscription
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit Subscription</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Subscription</h3>
            </div>
              <form action="{{ url('edit-subscription') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_sub_name" class="col-sm-2 control-label">Subscription</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="sub_name" placeholder="Subscription Name" name="sub_name" value="{{$sub_data->sub_name}}" required>
                        </div>
                    </div>
                    <input style="display:none;" type="text" class="form-control" id="sub_id"  name="sub_id" value="{{$sub_data->sub_id}}">
                    <div class="form-group">
                        <label for="lbl_sub_users_no" class="col-sm-2 control-label">No. of users</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="sub_users_no" placeholder="No. of users" name="sub_users_no" value="{{$sub_data->sub_users_no}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_sub_price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="sub_price" placeholder="Price" name="sub_price" value="{{$sub_data->sub_price}}" required>
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
<script>
 $(document).ready(function(){
    $('.select2').select2() 
 });
</script>
@endsection


