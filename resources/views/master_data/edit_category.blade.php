@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1>
      Edit Category
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
      <li class="active">Edit Category</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Category</h3>
            </div>
              <form action="{{ url('edit-category') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Category<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="Category" name="cat_name" required value="{{$category_data->cat_name}}">
                        </div>
                    </div>
                    <input style="display:none;" type="text" class="form-control" id="cat_id" placeholder="Category" name="cat_id" required value="{{$category_data->cat_id}}">
                   
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Update</button>
                <a href="{{url('category_data')}}" class="btn btn-danger" >Cancel</a>
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


