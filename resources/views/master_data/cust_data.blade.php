@extends('layouts.app')
@section('title', 'Customer-List')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif  
    <section class="content-header">
      <h1>
        Customer Master
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Customer List</li>
      </ol>
    </section>
  
  <section class="content">
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">CUSTOMER LIST</h3><a href="{{url('add_cust')}}" class="panel-title" style="margin-left: 70%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Customer</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Customer Name</th>
                  <th>Mobile No.</th>
                  <th>Email ID</th>
                  <th>Address</th>
                  <th>State</th>
                  <th>City</th>
                  <th>Pin Code</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($cust as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->cust_name}}</td>
                            <td>{{$t->mob_no}}</td>
                            <td>{{$t->email_id}}</td>
                            <td>{{$t->address}}</td>
                            <td>{{$t->state}}</td>
                            <td>{{$t->city_name}}</td>
                            <td>{{$t->pincode}}</td>
                            <td>
                                <a href="{{ url('edit-cust?cust_id='.$t->cust_id)}}"><span class="fa fa-edit"></span></a>
                                <a href="{{ url('delete-cust')}}/{{$t->cust_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
                            </td>
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
