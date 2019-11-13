@extends('layouts.app')
@section('title', 'Inventory Report')
@section('content')
<style>
    @media screen and (max-device-width:640px), screen and (max-width:640px) {
    .mobile_date {
    Width: 60px;
    }
}
</style>
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Inventory Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Report</a></li>
        <li class="active">Inventory Report</li>
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
            <div class="box" style="border-top: 3px solid #ffffff;border: 2px solid #00ffc3;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('download_inventory') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="en_id" id="en_id" value="" />
                       <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">From Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar calendar1"></i>
                                            </div>
                                <input type="text" name="from_date" class="form-control mobile_date datepicker from_date"id="from_date" style="background-color: #ffffff;" autocomplete="off" value="<?php echo date('Y-m-d');?>" required/>
                                        </div>
                        </div>
                         <label for="lbl_cat_name" class="col-sm-2 control-label">To Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar calendar2"></i>
                                            </div>
                                <input type="text" name="to_date" class="form-control mobile_date datepicker to_date"  style="background-color: #ffffff;" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
                                        </div>
                        </div>
                    </div>
                                             <?php if($location_data!=''){ ?>
                        <div class="form-group">
                         <label for="lbl_cat_name" class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-4">
                  <select class="form-control select2" style="width: 100%;" name="location" id="location">
                         <option value="">-- Select Location -- </option> 
                         <option value="all">All</option> 
                        @foreach($location_data as $u)
                        <option value="{{$u->loc_id}}">{{$u->loc_name}}</option>
                        @endforeach
                    </select>
                        </div>   
                        <?php } ?>
                          <?php if($employee_data!=''){ ?>
                       <label for="lbl_cat_name" class="col-sm-2 control-label">Employee</label>
                        <div class="col-sm-4">
                  <select class="form-control select2" style="width: 100%;" name="employee" id="employee">
                         <option value="">-- Select Employee -- </option> 
                        @foreach($employee_data as $u)
                        <option value="{{$u->id}}">{{$u->name}}</option>
                        @endforeach
                    </select>
                        </div>  
                          <?php } ?>
                        </div>
                        </div>
                    <div class="box-footer">
                        <button type="button"  id="btnsubmit" class="btn btn-success"><i class="fa fa-fw fa-eye"></i>View</button>
                        <button type="submit"  id="download" class="btn btn-primary"><i class="fa fa-fw fa-download"></i>Download</button>
                        <a href="{{url('inventory_report')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
    <div class="row result">
        <div class="col-md-12">
             <div class="box">
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Supplier Name</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Location</th>
                  <th>User</th>
                </tr>
                </thead>
                <tbody id="table_data">
                   
                </tbody>
              </table>
            </div>
             </div>
        </div>
    </div>
</section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
    var i=1;
     var fullDate = new Date();
    var month = fullDate.getMonth() + 1;
    var currentDate = fullDate.getFullYear() + "-" + month + "-" + fullDate.getDate();
    $.ajax({
                            url: 'inventory_report',
                            type: "POST",
                            data: {from_date:currentDate,to_date:currentDate},
                            success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                             var result=a.other_data;
                             var table;
         table = $('#example1').DataTable();    
         if(data!='') {               
          for (var key=0, size=result.length; key<size; key++){
            var j = -1;
            var r = new Array();
// represent columns as array
                r[++j] ='<tr><td>'+i+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].sup_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventoryitemid+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventoryitemquantity+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventorystatus+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].loc_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].user+'</td></tr>';
                rowNode = table.row.add(r);
                i++;

        }   
         }
         else {
         $('#table_data').html('<h3>No Data Avaliable</h3>');
         }
         table.draw();
                            $(".result").show();
                            }
                    });  
    $('.select2').select2();
    $('#example1').DataTable();
  $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true,
            Readonly: true
    }).attr("readonly", "readonly");
     $('.calendar1').click(function() {
    $(".from_date").focus();
  });
  $('.calendar2').click(function() {
    $(".to_date").focus();
  });
        $('.datepicker-autoclose').datepicker();  
        $("#btnsubmit").click(function(){
            var from_date=$('#from_date').val();
            if(from_date=="")
            {
                swal("Please select a Date", "", "error");
            }
            else
            {


               $.ajax({
                            url: 'inventory_report',
                            type: "POST",
                            data: $("#userForm").serialize(),
                            success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                             var result=a.other_data;
                             var table;
         table = $('#example1').DataTable();    
         if(data!='') {               
          for (var key=0, size=result.length; key<size; key++){
            var j = -1;
            var r = new Array();
// represent columns as array
                r[++j] ='<tr><td>'+i+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].sup_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventoryitemid+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventoryitemquantity+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].inventorystatus+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].loc_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].user+'</td></tr>';
                rowNode = table.row.add(r);
                i++;

        }   
         }
         else {
         $('#table_data').html('<h3>No Data Avaliable</h3>');
         }
         table.draw();
                            $(".result").show();
                            }
                    });  
            }
            
        }); 
                $('#location').change(function() {
            
          var location=$(this).val();
            $.ajax({
                            url: 'get_employees',
                            type: "GET",
                            data: {location:location},
                            success: function(data) {
                            console.log(data);
                             $('#employee').html('');
                            $('#employee').html(data);
                            }
                    });  
});
    });
</script>
@endsection
