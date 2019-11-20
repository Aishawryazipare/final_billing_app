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
              <select class="form-control select2" style="width: 12%;" name="item_units" onchange="fetch_items(this.value);">
                           <option value="ALL">ALL</option> 
                           <option value="0">ACTIVE </option> 
                           <option value="1">INACTIVE</option> 
                                        </select>
            </div>
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                   <th style="width:20px;">Sr.No</th>
                  <th style="width:20px;">ICode</th>
                  <th>Item Name</th>
                  <th style="width:20px;">Rate</th>
                  <th style="width:20px;">Tax</th>
                  <th style="width:20px;">Discount</th>
                  <th style="width:20px;">Final Rate</th>
                  <th style="width:50px;">Category</th>
                  <th>Unit</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php $i=1;?>
                    @foreach($item_data as $s)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$s->item_id}}</td>
                            <td>{{$s->item_name}}</td>
                            <td>{{$s->item_rate}}</td>
                            <td>{{$s->item_tax}}</td>
                            <td>{{$s->item_dis}}</td>
                            <td>{{$s->item_final_rate}}</td>
                            <?php
                            $category_data= \App\Category::select('*')->where(['cat_id'=>$s->item_category])->first();
                        $unit_data= \App\Type::select('*')->where(['Unit_id'=>$s->item_units])->first();
                            if($s->is_active==0)
                          {
                              $label="success";
                              $msg="Active";
                          }
                          else
                          {
                               $label="danger";
                              $msg="Inactive";
                          }
                            ?>
                            <td>{{@$category_data->cat_name}}</td>
                            <td>{{@$unit_data->Unit_name}}</td>
                            <td>
								<?php if($s->is_active==0) {?>
                                <a href="{{ url('edit-item?item_id='.$s->item_id)}}"><span class="fa fa-edit"></span></a>
								<?php } ?>
                                <a href="{{ url('delete-item')}}/{{$s->item_id}}" style="color:red" class="delete"><small class="label label-{{$label}}">{{$msg}}</small></a>
                            </td>
                        </tr>
                        <?php $i++;?>
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
    var i=1;
$(document).ready(function(){
    $(".delete").on("click",function(){
        return confirm('Are you sure to Change Status');
    });
    $('.select2').select2();
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
  function fetch_items(x)
  {
      if(x=="ALL")
      {
          location.reload();
      }
      else
      {
         
          $.ajax({
                            url: 'get_items_filter',
                            type: "GET",
                            data: {filter:x},
                              success: function(data) {
                            console.log(data);
                            var a=JSON.parse(data);
                            var result=a;
                             var table;
         table = $('#example1').DataTable();    
         table.clear().draw();
         if(data!='') {               
          for (var key=0, size=result.length; key<size; key++){
            var j = -1;
            var item_id=result[key].item_id;
            var r = new Array();
// represent columns as array
                r[++j] ='<tr><td>'+i+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].item_id+'<input type="hidden" class="bill_no" value="'+result[key].bill_no+'"/></td></tr>';
                r[++j] ='<tr><td>'+result[key].item_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].item_rate+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].item_tax+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].item_dis+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].item_final_rate+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].cat_name+'</td></tr>';
                r[++j] ='<tr><td>'+result[key].Unit_Taxvalue+'</td></tr>';
                var url = '{{ url("delete-item", ":id") }}';
                url = url.replace('%3Aid', result[key].item_id);
                if(x==0)
                r[++j] ='<tr><td><a href="'+url+'"><small class="label label-success">Active</small></td></tr>';
                else
                r[++j] ='<tr><td><a href="'+url+'"><small class="label label-danger">Inctive</small></td></tr>';
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
       
  }
</script>
@endsection
