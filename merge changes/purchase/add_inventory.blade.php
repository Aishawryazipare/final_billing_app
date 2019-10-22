@extends('layouts.app')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
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
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
            </div>
              <form action="{{ url('add_inventory') }}" method="POST" id="inventory_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Supplier ID</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inventorysupid" placeholder="Supplier ID" name="inventorysupid" required>
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Item ID</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="inventoryitemid" placeholder="Item ID" name="inventoryitemid" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Quantity</label>
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
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $('.select2').select2() 
    
   
    
    $("#btn_submit").click(function(){
        var inventoryitemid=$("#inventoryitemid").val();
        if(inventoryitemid!="")
        {
//            alert(inventoryitemid);
            $.ajax({
                url: 'get_item_id',
                type: "get",
                data: {inventoryitemid:inventoryitemid},
                beforeSend: function(){
                       $('.loader').show()
                },
                complete: function(){
                       $('.loader').hide();
                },
                success: function(reportdata) { 
                        var data3 = JSON.parse(reportdata);
                        console.log(data3);
//                        alert(data3);
                        if(data3 =="present")
                        {
//                             alert(data3);
                            $("#inventory_form").submit();
                        }
                        else if(data3=="not present")
                        {
                            alert(data3);
                             swal({
                                position: 'top-end',
                                type: 'warning',
                                title: 'Item ID not found',
                                showConfirmButton: true,
                                }); 
                                $("#inventoryitemid").val("");
                        }
                        else
                        {
                            swal({
                                position: 'top-end',
                                type: 'warning',
                                title: 'Something went wrong',
                                showConfirmButton: true,
                                }); 
                        }
                        
                    }                 
                });
           
        }
        else
        {
            swal({
            position: 'top-end',
            type: 'warning',
            title: 'Please enter 4 digit dealer code',
            showConfirmButton: true,
            }); 
        }
//        alert(dealer_code);
    });
    
 });
</script>
@endsection


