@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <?php
$color_array=array("bg-aqua","bg-green","bg-yellow","bg-red");
$a=0;
//echo "<pre>";
//print_r($pie_loc);
//exit;
?>
<h1>Total Scenario</h1>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow" style="width:65px;"><i class="fa fa-fw fa-map-marker" style="padding: 17px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Amount</b></span>
        <span class="info-box-number" style="font-size:17px;">Rs. <?php echo round($total_sales_amount,2);?></span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red" style="width:65px;"><i class="fa fa-fw fa-cubes" style="padding-top: 17px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Items</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_items}}</span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green" style="width:65px;"><i class="fa fa-fw fa-shopping-cart" style="padding-top: 20px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Bills</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_sales}}</span>
      </div>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow" style="width:65px;"><i class="fa fa-fw fa-map-marker" style="padding: 17px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Locations</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_loc}}</span>
      </div>
    </div>
</div>


<!--<div class="col-md-2 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua" style="width:65px;"><i class="fa fa-fw fa-map-marker" style="padding: 17px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Category</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_loc}}</span>
      </div>
    </div>
</div>
<div class="col-md-2 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red" style="width:65px;"><i class="fa fa-fw fa-map-marker" style="padding: 17px;"></i></span>

      <div class="info-box-content" style="padding-left:0px;">
        <span class="info-box-text"><b style="font-size:17px;">Supplier</b></span>
        <span class="info-box-number" style="font-size:17px;">{{$total_loc}}</span>
      </div>
    </div>
</div>-->
            </div>
        </div>
    </div>
    <h1>Total Sales</h1>
        <div class="row">
            <div class="col-md-6">
                <div id="container1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            </div>
        <div class="col-md-6">
        <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Item Details</h3>
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
                    <th>Location/th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php $j=1;?>
                      @foreach($items as $i)
                      <tr>
                          <td>{{$j}}</td>
                          <td>{{$i->loc_name}}</td>
                          <td>{{$i->item_name}}</td>
                      </tr>
                      <?php $j++;?>
                      @endforeach
                        
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
   
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                 <?php if(count($top_loc)!=0){?>
    <h1>Location wise Sales</h1>
    <?php $b=1;?>
    @foreach($top_loc as $loc)
    <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box <?php echo $color_array[$b];?>">
           <div class="inner">
             <h3 style="font-size:55px;">{{$loc->orders}}</h3>
             <p style="font-size:16px;">Bills</p>
             <p style="font-size:26px;font-weight:bold;">{{$loc->loc_name}}</p>
           </div>
           <div class="icon" style="top:18px;right:20px;">
             <i class="fa fa-shopping-cart"></i>
           </div>
           <a href="#" class="small-box-footer">
           </a>
         </div>
       </div>
    <?php $b++;?>
    @endforeach
    <?php }?>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="js/highcharts.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
});
$(function () {
   // $('#example1').DataTable()
    $('#example1').DataTable({
         "iDisplayLength": 5,
    })
})
Highcharts.chart('container1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Location wise Sales'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Total Item Quantity:<b>{point.custom}</b><br>Total Amount (Rs.):<b>{point.custom1}</b>'
        
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Bills',
        colorByPoint: true,
        data:<?php echo json_encode($final_pie); ?>
    }]
});
</script>
@endsection
