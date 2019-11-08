@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>
        Add Location
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('bil_location_save') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Location name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  placeholder="Location Name" value="" id="loc_name" name="loc_name"  required >
                            </div>
                           
                        </div>
                        
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Save</button>
                        <a href="{{url('bil_location_list')}}" class="btn btn-danger" >Cancel</a>
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
    $("#loc_name").focusout(function(){
        var loc_name = $(this).val();
         $.ajax({
                    url: 'check-exist-location',
                            type: "GET",
                            data: {type:"location",loc_name:loc_name},
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
                              $("#loc_name").val("");
                            }
                        }
                    });
    });
 });
     var jvalidate = $("#type_form").validate({
    rules: { 
            password : {required: true},
        },
         messages: {
             cat_name: "Please Enter Category",
           }  
    });
</script>
@endsection
