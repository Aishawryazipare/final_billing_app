@extends('layouts.app')
@section('title', 'Bill Detail Report')
@section('content')
<style>
    @media screen and (max-device-width:640px), screen and (max-width:640px) {
    .mobile_date {
    Width: 60px;
    }
}
::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent */
}
</style>
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Bill Detail Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Report</a></li>
        <li class="active">Bill Detail Report</li>
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
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('download_bill_detail_report') }}">
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
                                <input type="text" name="from_date" class="form-control mobile_date datepicker from_date"id="from_date" style="background-color: #ffffff;" autocomplete="off" value="<?php echo date('Y-m-d');?>" required/>
                                        </div>
                        </div>
                         <label for="lbl_cat_name" class="col-sm-2 control-label">To Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar  calendar2"></i>
                                            </div>
                                <input type="text" name="to_date" class="form-control mobile_date datepicker to_date"  style="background-color: #ffffff;" value="<?php echo date('Y-m-d');?>" autocomplete="off"/>
                                        </div>
                        </div>
                    </div>
                       
                        <div class="form-group">
                          <?php if($location_data!=''){ ?>
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
                  <select class="form-control select2 employee" style="width: 100%;" name="employee" id="employee">
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
                        <!--<button type="button"  id="btnsubmit" class="btn btn-success"><i class="fa fa-fw fa-eye"></i>View</button>-->
                        <button type="submit"  id="download" class="btn btn-primary"><i class="fa fa-fw fa-download"></i>Download</button>
                        <a href="{{url('bill_detail_report')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
     @auth('admin')
     @endauth

<div class="modal fade in" id="bill_modal" style="display: none; padding-right: 15px;">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Default Modal</h4>
             </div>
             <div class="modal-body">
               <p>One fine body…</p>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Save changes</button>
             </div>
           </div>
           <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
       </div>
<!--    <div class="row result" style="display:none;">
        <div class="col-md-12">
             <div class="box" style="overflow-x:auto;">
            <div class="box-body" >
                <span id="amt"></span>
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead id="header_data">
                <tr>
                  <th style="width:20px;">No</th>
                  <th style="width:20px;">Bill No</th>
                  <th style="width:20;">Basic Amt</th>
                  <th style="width:50px;">Disc Amt</th>
                  <th style="width:20px;">Total Tax</th>
                  <th style="width:50px;">Bill Amount</th>
                </tr>
                </thead>
                <tbody id="table_data">
                   
                </tbody>
              </table>
            </div>
             </div>
        </div>
    </div>-->
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
                            url: 'bill_tax_report',
                            type: "POST",
                            data: {from_date:currentDate,to_date:currentDate},
                             success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                            var result=a.other_data;
                            var table = $('#example1').DataTable();
table.clear().draw();
     i=1;                        
         table = $('#example1').DataTable();    
         if(data!='') {               
          for (var key=0, size=result.length; key<size; key++){
            var j = -1;
            var r = new Array();
// represent columns as array
                r[++j] ='<tr><td>'+i+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].bill_no+'<input type="hidden" class="bill_no" value="'+result[key].bill_no+'"/></td></tr>';
                r[++j] ='<tr><td>'+result[key].total_rate+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_discount+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_tax+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_amount+'</td></tr>';
                rowNode = table.row.add(r);
                i++;

        }         
         }
         else {
         $('#example1').html('<h3>No Data Avaliable</h3>');
         }
         table.draw();
                            $('#amt').html("<h3>Total Amount:<span id='total_amt'>"+a.amount+"</span></h3>");
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
                            url: 'bill_tax_report',
                            type: "POST",
                            data: $("#userForm").serialize(),
                            success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                            var result=a.other_data;
                            var table = $('#example1').DataTable();
table.clear().draw();
     i=1;                        
         table = $('#example1').DataTable();    
         if(data!='') {               
          for (var key=0, size=result.length; key<size; key++){
            var j = -1;
            var r = new Array();
// represent columns as array
                r[++j] ='<tr><td>'+i+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].bill_no+'<input type="hidden" class="bill_no" value="'+result[key].bill_no+'"/></td></tr>';
                r[++j] ='<tr><td>'+result[key].total_rate+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_discount+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_tax+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].total_amount+'</td></tr>';
                rowNode = table.row.add(r);
                i++;

        }         
         }
         else {
         $('#example1').html('<h3>No Data Avaliable</h3>');
         }
         table.draw();
                            $('#amt').html("<h3>Total Amount:<span id='total_amt'>"+a.amount+"</span></h3>");
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
                            $('.employee').html(data);
                            }
                    });  
});
  $("#example1").on('click','.remove_field',function(){
       var bill_no=$(this).closest('tr').find('.bill_no').val();
       alert(bill_no);
        //$('#bill_modal').show();
                  $.ajax({
                            url: 'delete_bill_no',
                            type: "GET",
                            data: {bill_no:bill_no},
                            success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                            var amt=$('#total_amt').html();
                            if(a.flag==1)
                            {
                                  var new_amt= parseInt(amt) - parseInt(a.amount);
                            $('#amt').html("<h3>Total Amount:<span id='total_amt'>"+new_amt+"</span></h3>");
                             swal({ type: "success", title: "Done!", confirmButtonColor: "#292929", text: "Bill Delete Successfully", confirmButtonText: "Ok" }, 
                             function() {
                                    location.reload();
                                });
                            }
                          
                            }
                    }); 
  });
    });
</script>
@endsection
