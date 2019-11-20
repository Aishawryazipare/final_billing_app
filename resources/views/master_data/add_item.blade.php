@extends('layouts.app')
@section('content')
<style>
    .btn-success {
        background-color: #00ffc3;
    border-color: #00ffc3;
    }
</style>
<section class="content-header">
    <h1>
      Add Item
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
      <li class="active">Add Item</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Item</h3>
            </div>
              <form action="{{ url('add_item') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Item Name<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="Item" name="item_name" required>
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Rate<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="rate" placeholder="Item Rate" name="item_rate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Discount %<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="disc" placeholder="Item Disc" name="item_dis" required>
                        </div>
                         <label for="lbl_cat_desc" class="col-sm-2 control-label">Discount Rate</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="disc_rate" placeholder="Disc Rate" name="item_disrate" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Tax<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="tax" placeholder="Tax" name="item_tax" required>
                        </div>
                         <label for="lbl_cat_desc" class="col-sm-2 control-label">Tax Value</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="tax_value" placeholder="Tax value" name="item_taxvalue" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Final Rate</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="final_rate" placeholder="Final Rate" name="item_final_rate" readonly>
                        </div>
                         <label for="lbl_cat_desc" class="col-sm-2 control-label">Unit</label>
                        <div class="col-sm-4">
                           <select class="form-control select2" style="width: 100%;" name="item_units" >
                         <option value="">-- Select Unit -- </option> 
                        @foreach($unit_data as $u)
                        <option value="{{$u->Unit_Id}}">{{$u->Unit_name}}</option>
                        @endforeach
                    </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Category<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                        <select class="form-control select2" style="width: 100%;" name="item_category" required>
                        <option value="">-- Select Category -- </option>
                         @foreach($category_data as $c)
                        <option value="{{$c->cat_id}}">{{$c->cat_name}}</option>
                        @endforeach
                    </select>
                    </div>
                        <label for="lbl_cat_desc" class="col-sm-2 control-label">Stock<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="Stock" name="item_stock" required>
                        </div>
                    </div>
                         <div class="form-group">
                        
                         <label for="lbl_cat_desc" class="col-sm-2 control-label">Bar Code<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="Bar Code" name="item_barcode" required>
                        </div>
                         <label for="lbl_cat_desc" class="col-sm-2 control-label">HSN No.</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="HSN Code" name="item_hsncode">
                        </div>
<!--                         <label for="lbl_cat_image" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-4">
                            <input type="file" name="cat_image" id="cat_image">
                            <p class="help-block">Example block-level help text here.</p>
                        </div>-->
                    </div>
                    
                  
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                <a href="{{url('item_data')}}" class="btn btn-danger" >Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
 $(document).ready(function(){
    $('.select2').select2() 
    $( ".rate_cal" ).keyup(function() {
    var rate=$('#rate').val();
    var disc=$('#disc').val();
    var tax=$('#tax').val();
    var disc_r=(rate*disc)/100;
    var disc_rate=rate-disc_r
    var tax_value=(tax*disc_rate)/100;
    var final_rate=(tax_value+disc_rate);
    $('#disc_rate').val(disc_rate);
    $('#tax_value').val(tax_value);
    $('#final_rate').val(final_rate.toFixed(2));
    
});
});
</script>
@endsection


