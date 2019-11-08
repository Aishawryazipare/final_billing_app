@extends('layouts.app')
@section('content')
<style>
    .small-box h3 {
        
    }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <?php
$color_array=array("bg-aqua","bg-green","bg-yellow","bg-red");
$a=0;
//echo $top_loc;
//exit;
?>
<h1>Total Scenario</h1>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-fw fa-shopping-cart" style="padding-top: 20px;"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><b style="font-size:17px;">Amount</b></span>
        <span class="info-box-number" style="font-size:17px;">Rs. {{$total_sales_amount}}</span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-fw fa-cubes" style="padding-top: 17px;"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><b style="font-size:17px;">Items</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_items}}</span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-fw fa-shopping-cart" style="padding-top: 20px;"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><b style="font-size:17px;">Orders</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_sales}}</span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-fw fa-map-marker" style="padding: 17px;"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><b style="font-size:17px;">Locations</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_loc}}</span>
      </div>
    </div>
</div>

            </div>
        </div>
    </div>
    <?php if(count($top_items)!=0){?>
    <h1>Top Selling Items</h1>
<!--    @foreach($top_items as $item)
    <div class="col-lg-3 col-xs-12">
        <div class="small-box <?php echo $color_array[$a];?>">
          <div class="inner">
              <h3 style=" text-align: center;">{{$item->item_name}}</h3>
              <h3 style=" text-align: center;">{{$item->item_qty}}</h3>
          </div>
          <div class="icon">
          </div>
        </div>
    </div>
    @endforeach-->
      <div class="col-md-6">
        <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Top Selling Items</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body" style="height: 359px;">
              <div class="table-responsive">
                <table class="table no-margin table table-bordered table-striped" id="example1">
                  <thead>
                  <tr>
                    <th>Sr No.</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php $j=1;?>
                      @foreach($top_items as $item)
                      <tr>
                          <td>{{$j}}</td>
                          <td>{{$item->item_name}}</td>
                          <td>{{$item->item_qty}}</td>
                      </tr>
                      <?php $j++;?>
                      @endforeach
                        
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    <?php }?>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
</script>
@endsection
