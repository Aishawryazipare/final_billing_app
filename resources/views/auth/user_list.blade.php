@extends('layouts.app')
@section('title', 'User-List')
@section('content')
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <section class="content-header">
      <h1>
        User List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User List</li>
      </ol>
    </section>
  @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif
  <section class="content">
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">USER LIST</h3><a href="{{url('register')}}" class="panel-title" style="margin-left: 81%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New User</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($userData as $u)
                                <?php 
                                ?>
                                    <tr>
                                        <td>{{$x++}}</td>
                                        <td>{{$u->name}}</td>
                                        <td>{{$u->email}}</td>
                                        <td>{{$u->mobile_no}}</td>
                                        <td>{{$u->address}}</td>
                                        <td>
                                            <a href="{{ url('edit-user?id='.$u->id)}}"><span class="fa fa-edit"></span></a>
                                            <a href="{{ url('delete-user')}}/{{$u->id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
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
<script>
$(document).ready(function(){
//    alert();
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete user');
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
