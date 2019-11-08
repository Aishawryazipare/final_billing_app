@extends('layouts.app')
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
      Add Stock
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Purchase</a></li>
      <li class="active">Add Stock</li>
	  
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Stock</h3>
			  <?php if($flag==1) { ?>
			  <button type="button" class="btn btn-success" id="sync_btn" name="sync_btn" style="margin-left:85%"><i class="fa fa-fw fa-cloud-upload"></i>Sync</button>
			  <?php } ?>
			</div>
              <form action="{{ url('add_inventory') }}" method="POST" id="inventory_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Supplier Name</label>
                        <div class="col-sm-4">
                           <select class="form-control select2" style="width: 100%;" name="inventorysupid" required>
                            <option value="">Select</option>
                            @foreach($supplier_data as $s)
                                <option value="{{$s->sup_id}}">{{$s->sup_name}}</option>
                            @endforeach
                        </select>
                        </div>
<!--                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inventorysupid" placeholder="Supplier ID" name="inventorysupid" required>
                        </div>-->
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Item Name<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control select2" style="width: 100%;" id="inventoryitemid" name="inventoryitemid" required>
                                <option value="">Select</option>
                                @foreach($product_data as $s)
                                    <option value="{{$s->item_id}}">{{$s->item_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Quantity<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="inventoryitemquantity" placeholder="Quantity" name="inventoryitemquantity" required>
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Stock</label>
                        <div class="col-sm-4">
                            <input type="radio" name="inventorystatus" value="add" checked> Add<br>
                            <input type="radio" name="inventorystatus" value="substract"> Substract<br>
                            <input type="radio" name="inventorystatus" value="set"> Set 
                        </div>
                    </div>   
                </div>
              <div class="box-footer">
                <button type="button" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                 <a href="{{url('inventory')}}" class="btn btn-danger" >Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
        <div class="row result">
        <div class="col-md-12">
             <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Supplier Name</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody id="table_data">
                <?php $a=1;?>
                @foreach($inventory_data as $in)
                <tr>
                    <td>{{$a}}</td>
                    <td>{{$in->inventorysupid}}</td>
                    <td>{{$in->inventoryitemid}}</td>
                    <td>{{$in->inventoryitemquantity}}</td>
                    <td>{{$in->inventorystatus}}</td>

                </tr>
                    
                <?php $a++;?>
                @endforeach
                </tbody>
              </table>
            </div>
             </div>
        </div>
    </div>
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $('.select2').select2() 
    $('#example1').DataTable();
    $( "#sync_btn" ).click(function() {
         var msg="Inventory";
         $.ajax({
                 url: 'sync_category',
                 type: "GET",
                 data: {data:msg},
                 success: function(result) 
                 {
                     var res=JSON.parse(result);
                     console.log(res); 
                 }
             });
     });
    
    $("#btn_submit").click(function(){
        var inventoryitemid=$("#inventoryitemid").val();
        if(inventoryitemid!="")
        {
             $("#inventory_form").submit();
//            alert(inventoryitemid);
//            $.ajax({
//                url: 'get_item_id',
//                type: "get",
//                data: {inventoryitemid:inventoryitemid},
//                beforeSend: function(){
//                       $('.loader').show()
//                },
//                complete: function(){
//                       $('.loader').hide();
//                },
//                success: function(reportdata) { 
//                        var data3 = JSON.parse(reportdata);
//                        console.log(data3);
////                        alert(data3);
//                        if(data3 =="present")
//                        {
////                             alert(data3);
//                            $("#inventory_form").submit();
//                        }
//                        else if(data3=="not present")
//                        {
//                           // alert(data3);
//                             swal({
//                                position: 'top-end',
//                                type: 'warning',
//                                title: 'Item ID not found',
//                                showConfirmButton: true,
//                                }); 
//                                $("#inventoryitemid").val("");
//                        }
//                        else
//                        {
//                            swal({
//                                position: 'top-end',
//                                type: 'warning',
//                                title: 'Something went wrong',
//                                showConfirmButton: true,
//                                }); 
//                        }
//                        
//                    }                 
//                });
           
        }
        else
        {
            swal({
            position: 'top-end',
            type: 'warning',
            title: 'Please Select Item ',
            showConfirmButton: true,
            }); 
        }
//        alert(dealer_code);
    });
    
 });
</script>
@endsection


