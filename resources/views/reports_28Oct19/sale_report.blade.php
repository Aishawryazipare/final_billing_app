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
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Sales Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Report</a></li>
        <li class="active">Sales Report</li>
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
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('download_sale') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="en_id" id="en_id" value="" />
                       <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label ">From Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar  calendar1"></i>
                                            </div>
                                <input type="text" name="from_date" class="form-control mobile_date datepicker from_date"id="from_date" autocomplete="off" required/>
                                        </div>
                        </div>
                         <label for="lbl_cat_name" class="col-sm-2 control-label">To Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar  calendar2"></i>
                                            </div>
                                <input type="text" name="to_date" class="form-control mobile_date datepicker to_date" value=""  autocomplete="off"/>
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
                        </div>
                        <?php } ?>
                        </div>
                    <div class="box-footer">
                        <button type="button"  id="btnsubmit" class="btn btn-success"><i class="fa fa-fw fa-eye"></i>View</button>
                        <button type="submit"  id="download" class="btn btn-primary"><i class="fa fa-fw fa-download"></i>Download</button>
                        <a href="{{url('enquiry-list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
     @auth('admin')
     @endauth


    <div class="row result" style="display:none;">
        <div class="col-md-12">
             <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead id="header_data">
                <tr>
                  <th style="width:50px;">No</th>
                  <th>Bill No</th>
                  <th>Customer Name</th>
                  <th>Total Amount</th>
                  <th>Cash/Credit</th>
                  <th>Location</th>
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
    $('.select2').select2();
    $('#example1').DataTable();
 $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
    })
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
                            url: 'sale_report',
                            type: "POST",
                            data: $("#userForm").serialize(),
                            success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                            $("#header_data").html(a.head);
                            $("#table_data").html(a.other_data);
                             $('#example1').DataTable();
                            $(".result").show();
                            }
                    });  
            }
            
        }); 
    });
</script>
@endsection
