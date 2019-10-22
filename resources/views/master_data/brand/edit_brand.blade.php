@extends('layouts.app')
@section('title', 'Edit-Brand')
@section('content')
<section class="content-header">
    <h1>
      Edit Brand
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit Brand</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Brand</h3>
            </div>
              <form action="{{ url('edit-brand') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$brand_data->brand_id}}" />
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-4">
                            <select class="form-control " style="width: 100%;" name="cat_id" id="cat_id">
                                    <option value="">-- Select Category -- </option>
                                    @foreach($category as $prod)
                                    <option value="{{$prod->cat_id}}" <?php if($prod->cat_id == $brand_data->cat_id) echo "selected"; ?>>{{$prod->cat_name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Brand Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="brand_name" value="{{$brand_data->brand_name}}" placeholder="Brand Name" name="brand_name" required>
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Update</button>
                <a href="{{url('brand_list')}}" class="btn btn-danger" >Cancel</a>
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


