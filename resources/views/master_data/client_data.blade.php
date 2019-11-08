@extends('layouts.app')
@section('title', 'Client-List')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif  
    @if (Session::has('alert-error'))
    <div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Error!</h4>
        {{ Session::get('alert-error') }}
    </div>
    @endif   
    <section class="content-header">
      <h1>
        Client List
      </h1>
    
      <ol class="breadcrumb">
        <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
        <li class="active">Clients</li>
      </ol>
    </section>
   
  <section class="content">
   <div class="box">
<!--            <div class="box-header">
              <h3 class="box-title">CLIENT LIST</h3><a href="{{url('add_dealer')}}" class="panel-title" style="margin-left: 73%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Dealer</a>
            </div>-->
            <!-- /.box-header -->
             <?php $x = 1; ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Name</th>
                  <th>Mobile No.</th>
                  <th>Email</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($client_data as $c)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$c->reg_personname}}</td>
                            <td>{{$c->reg_mobileno}}</td>
                            <td>{{$c->reg_emailid}}</td>
							 <?php if($c->activate_flag == 0) {?>
                            <td><button class="btn btn-primary start_status" id="{{$c->rid}}">Click Here To Activate</button></td>
                            <?php } else { ?>
                            <td><button class="btn btn-danger end_status" id="{{$c->rid}}">Click Here To Deactivate</button></td>
                            <?php } ?>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
 </div>   
  </section>
 
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete');
    });
    
    $(".start_status").on("click", function () {
        var id = this.id;
//        alert(id);
        swal({
            title: "Please Conform",
            text: "You want to activate account ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'active_link/' + id+'/1',
                    type: 'get',
                    success: function (response) {
                        location.reload();
                    }
                });
            } else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                swal("Cancelled", "", "error");
            }
        });
    })
    
    $(".end_status").on("click", function () {
        var id = this.id;
//        alert(id);
        swal({
            title: "Please Conform",
            text: "You want to Deactivate account ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                   url: 'active_link/' + id+'/0',
                    type: 'get',
                    success: function (response) {
                         location.reload();
                    }
                });
            } else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                swal("Cancelled", "", "error");
            }
        });
    })
    
    
});
$(function () {
//    $('#example1').DataTable()
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'scrollX': true
    })
  })
</script>
@endsection
