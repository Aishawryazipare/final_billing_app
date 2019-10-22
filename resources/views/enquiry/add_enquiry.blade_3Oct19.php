@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<style>
    @media screen and (max-device-width:640px), screen and (max-width:640px) {
    .mobile_date {
    Width: 60px;
    }
}
</style>
<?php 
if(Auth::guard('employee')->check()){
   $logeed_id = Auth::guard('employee')->user()->id; 
   $role = Auth::guard('employee')->user()->role;
}else if(Auth::guard('admin')->check()){
   $logeed_id = Auth::guard('admin')->user()->rid; 
}else if(Auth::guard('web')->check()){
   $logeed_id = Auth::guard('web')->user()->id; 
}
//$logeed_id = Auth::user()->id;
//$role = Auth::user()->role; ?>
<section class="content-header">
    <h1>
        Add New Enquiry
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Enquiry</a></li>
        <li class="active">Add Enquiry</li>
    </ol>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('add-enquiry') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="en_id" id="en_id" value="" />
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Enquiry No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="enquiry_no" placeholder="Enquiry No" value="<?php if(isset($last_entry->enquiry_no)) echo (++$last_entry->enquiry_no); else echo "E-".$logeed_id."- 1"; ?>" name="enquiry_no" readonly >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Mobile No<span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" onkeypress="return phoneno(event)" id="mobile_no" onkeyup="check();"  placeholder="Mobile No" value="" name="mobile_no"  required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Customer Name <span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" value="" name="customer_name"  required>
                            </div>
                            <label for="company" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="email" placeholder="Email" value="" name="email"  >
                            </div>
                            <span id="message"></span>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="address" placeholder="Address" value="" name="address"  >
                            </div>
                            <label for="company" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-4">
                                <!--<input type="text" class="form-control" id="user" placeholder="City" value="" name="city_id"  >-->
                                <select class="form-control select2" style="width: 100%;" name="city_id" id="city_id">
                                    <option value="">-- Select City -- </option>
                                    @foreach($city as $c)
                                    <option value="{{$c->city_name}}">{{$c->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-4 ">
                                <select class="form-control " style="width: 100%;" name="cat_id" id="cat_id">
                                    <option value="">-- Select Category -- </option>
                                    @foreach($category as $prod)
                                    <option value="{{$prod->cat_id}}">{{$prod->cat_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Brand Name</label>
                            <div class="col-sm-4">
                                <select class="form-control " style="width: 100%;" name="brand_id" id="brand_id">
                                    <option value="">-- Select Product -- </option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Product Name</label>
                            <div class="col-sm-4">
                                <select class="form-control " style="width: 100%;" name="product_id" id="product_id">
                                    <option value="">-- Select Product -- </option>
                                   
                                </select>
                            </div>
                            <label for="gst" class="col-sm-2 control-label">Enquiry Status</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" name="status_id" id="status_id" required>
                                    <option value="">-- Select Status -- </option>
                                    @foreach($enquiry_status as $enq)
                                    <option value="{{$enq->id}}">{{$enq->status_name}}</option>
                                    @endforeach
                                </select>
                            </div>                            
                        </div>
                        <div class="form-group">   
                            <label for="gst" class="col-sm-2 control-label">Source</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" id="source" name="source" >
                                    <option value="">-- Select Status -- </option>
                                    <option value="Other" selected>Other</option>
                                    @foreach($source as $su)
                                    <option value="{{$su->name}}">{{$su->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="gst" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" id="active_inactive_status" name="active_inactive_status" >
                                    @foreach($status as $su)
                                    <option value="{{$su->id}}">{{$su->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <!--<a href="{{url('add-enquiry-status')}}" class="col-sm-1">Add</a>-->
                          
                        <div class="form-group">      
                            <?php if(Auth::guard('admin')->check()){  ?>
                            <label for="gst" class="col-sm-2 control-label">Assign To Employee</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="assign_to_emp_id" id="assign_to_emp_id" >
                                    <option value="">-- Select Employee -- </option>
                                    @foreach($employee_data as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{url('register')}}" class="col-sm-1" target="_blank">Add</a>
                            <?php } ?>
                        </div>
                        <div class="form-group" id="source_text" style="display: none;">                  
                            <label for="gst" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4"></div>
                            <label for="gst" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <input type="text" name="source_val" class="form-control" id="source_val" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Follow Up</label>
                        </div>
                        <table style="margin: 10px 10px 10px 10px;" class="table" >
                            <tbody id="h_lost">                                
                                <tr class="first">
                                    <td>
                                        <textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up[0][0]" required ></textarea>   
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="follow_up[0][1]" class="form-control mobile_date datepicker" value="" />
                                        </div>
                                    </td>
                                    <td><i class="fa fa-plus-circle btn-success add_field_button"></i></td>
                                    <input type="hidden" name="follow_up[0][2]" value="<?php echo date('Y-m-d h:m:s'); ?>" />
                                </tr>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
                        <a href="{{url('enquiry-list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>
$(document).ready(function () {
//    $('.select2').select2();
    $('div.alert').delay(3000).slideUp(300);

    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var i = 0;
    var x = 1; //initlal text box is_countable
    var s = 14;
    
    $("#cat_id").on("change",function () {
    var cat_id = $(this).val();
        $.ajax({
            url: 'product_val/' + cat_id,
            type: "GET",
            success: function (response) {
                console.log(response);
                var data = JSON.parse(response);
                console.log(data);
                $("#brand_id").html(data.brand);
                $("#product_id").html(data.product);
            }
        });
    });
    
    
    $(document).on('click','.add_field_button',function () {
//        alert();
        x++;
        var date = $("#cop_date").val();
        var message = $('.input_fields_wrap tr').length;
        
        $("#h_lost").append('<tr class="first"><td><textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up['+x+'][0]" required ></textarea></td><td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" name="follow_up['+ x +'][1]" id="datepicker"  class="form-control mobile_date datepicker" value="" /></div></td><input type="hidden" class="form-control" name="follow_up['+x+'][2]" value="<?php echo date('Y-m-d h:m:s'); ?>" readonly /><td><i class="fa fa-minus-circle btn-danger remove_field"></i></td></tr>')
        $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
    })
//        $('select').select2();
        $('.datepicker-autoclose').datepicker();  
        
        
        
    });
    
    $("#source").on("change",function(){
        var a = $(this).val();
        if(a == "Event" || a == "Reference") {
            $("#source_text").css("display","block");
        }
    })
    
     $("#h_lost").on('click', '.remove_field', function () {
        $(this).parent().parent().remove();
    });
    
    $("#mobile_no").focusout(function () {
        var mobile_no = $(this).val();
        $.ajax({
            url: 'mobile-validate/' + mobile_no,
            type: "GET",
            success: function (response) {
//                console.log(response);
                var data = JSON.parse(response);
                $("#en_id").val(data.enquiry_id);
                $("#enquiry_no").val(data.enquiry_no);
                $("#customer_name").val(data.customer_name);
                $("#email").val(data.email);
                $("#address").val(data.address);
                $("#city_id").val(data.city_id).attr("selected", "selected");
                $('#city_id').trigger('change.select2');
                $("#cat_id").val(data.cat_id).attr("selected","selected");
                $('#cat_id').trigger('change.select2');
                $('#cat_id').trigger('change');
                
                $("#status_id").val(data.status_id).attr("selected", "selected");
                $('#status_id').trigger('change.select2');
                $("#source").val(data.source).attr("selected", "selected");
                $('#status_id').trigger('change.select2');
                $("#brand_id").val(data.brand_id).trigger('change');
                $("#brand_id").val(data.brand_id).attr("selected","selected");
                $('#brand_id').trigger('change.select2');
                $('#brand_id').trigger('change',data.brand_id);
                $("#product_id").val(data.product_id).attr("selected", "selected");
                $('#product_id').trigger('change.select2');
                $('#product_id').trigger('change',data.product_id);
                var json_data = JSON.parse(data.follow_up);
                console.log(json_data);
                $("#h_lost").html("");
                var x = 1;
                $.each(json_data, function(index, value){
//                    if(x == 1){
                    $("#h_lost").append('<tr class="first"><td><textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up['+x+'][0]" readonly >'+value[0]+'</textarea></td><td><input type="date" name="follow_up['+ x +'][1]" class="form-control" value="'+value[1]+'" readonly /></td><input type="hidden" class="form-control" name="follow_up['+x+'][2]" value="'+value[2]+'" readonly /><td><a href="javascript:void(0)" class="btn btn-success btn-mini add_field_button">Add</a></td></tr>')
//                    }else{
//                        $("#h_lost").append('<tr class="first"><td><b>FollowUp '+x+'</b></td><td><textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up['+x+'][0]" readonly >'+value[0]+'</textarea></td><td><input type="date" name="follow_up['+ x +'][1]" class="form-control" value="'+value[1]+'" readonly /></td><input type="hidden" class="form-control" name="follow_up['+x+'][2]" value="'+value[2]+'" readonly /></tr>')
//                    }
                    x++;
                });
                
            }
        });
    });

});

var jvalidate = $("#userForm").validate({
    rules: { 
            password : {required: true},
        },
         messages: {
             mobile_no: "Please Enter Mobile No",
             customer_name: "Please Enter Customer Name"
           }  
    });

    $('#btnsubmit').on('click', function() {
        $("#orderForm").valid();
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
            $('#mobile_no').keypress(function(e) {
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
