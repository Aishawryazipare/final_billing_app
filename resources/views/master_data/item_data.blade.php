@extends('layouts.app')
@section('title', 'Item-List')
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
        Item List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Item List</li>
      </ol>
    </section>
   
  <section class="content">
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">ITEM LIST</h3><a href="{{url('add_item')}}" class="panel-title" style="margin-left: 82%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Item</a>
            </div>
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Code</th>
                  <th>Item Name</th>
                  <th>Rate</th>
                  <th>Discount Rate</th>
                  <th>Final Rate</th>
                  <th>Category</th>
                  <th>Unit</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($item_data as $s)
                        <tr>
                            <td>{{$s->item_id}}</td>
                            <td>{{$s->item_name}}</td>
                            <td>{{$s->item_rate}}</td>
                            <td>{{$s->item_dis}}</td>
                            <td>{{$s->item_final_rate}}</td>
                            <?php
                            $category_data= \App\Category::select('*')->where(['cat_id'=>$s->item_category])->first();
                            $unit_data= \App\Type::select('*')->where(['Unit_id'=>$s->item_units])->first();
                            //echo "<pre/>";print_r($s->item_unit);exit;
                            ?>
                            <td>{{$category_data->cat_name}}</td>
                            <td>{{@$unit_data->Unit_name}}</td>
                            <td>
                                <a href="{{ url('edit-item?item_id='.$s->item_id)}}"><span class="fa fa-edit"></span></a>
                                <a href="{{ url('delete-item')}}/{{$s->item_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
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
