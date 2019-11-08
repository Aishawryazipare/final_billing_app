<style>
    @page {
                margin:20px 25px 20px 25px;
            }
</style>
<?php
//echo "<pre>";
////print_r($setting_details);
//print_r($page_size);
//exit;
$total=0;
?>
<?php 
if($page_size=="A5")
{
?>
@if(!empty($setting_details))
    @if($setting_details->h1!=null)
        <h5><center>{{$setting_details->h1}}</center></h5>
    @endif
    @if($setting_details->h2!=null)
        <h5><center>{{$setting_details->h2}}</center></h5>
    @endif
    @if($setting_details->h3!=null)
        <h5><center>{{$setting_details->h3}}</center></h5>
    @endif
    @if($setting_details->h4!=null)
        <h5><center>{{$setting_details->h4}}</center></h5>
    @endif
    @if($setting_details->h5!=null)
        <h5><center>{{$setting_details->h5}}</center></h5>
    @endif
@endif
<hr>
<table width="100%">
    <tr>
        <td><b>Bill No: {{$bill_details[0]->bill_no}}</b></td>
        <td style="text-align: right;"><b>Date: <?php echo date('Y-m-d');?></b></td>
    </tr>
</table>
<table align="center">
    <thead>
        <th>No.</th>
        <th>Item Name</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
    </thead>
    <tbody>
    <tr></tr>
@if(!empty($bill_details))
    @foreach($bill_details as $bill)
        <?php $total=$total+$bill->item_totalrate;?>
        <tr>
            <td style="text-align:center;">1</td>
            <td style="text-align:center;">{{$bill->item_name}}</td>
            <td style="text-align:center;">{{$bill->item_qty}}</td>
            <td style="text-align:center;">{{$bill->item_rate}}</td>
            <td style="text-align:center;">{{$bill->item_totalrate}}</td>
        </tr>       
    @endforeach
@endif
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td><b>Total</b></td>
    <td style="text-align:center;"><?php echo round($total,3)?></td>
</tr>
</tbody>
</table>
<hr>
@if(!empty($setting_details))
    @if($setting_details->f1!=null)
        <h5><center>{{$setting_details->f1}}</center></h5>
    @endif
    @if($setting_details->f2!=null)
        <h5><center>{{$setting_details->f2}}</center></h5>
    @endif
    @if($setting_details->f3!=null)
        <h5><center>{{$setting_details->f3}}</center></h5>
    @endif
    @if($setting_details->f4!=null)
        <h5><center>{{$setting_details->f4}}</center></h5>
    @endif
    @if($setting_details->f5!=null)
        <h5><center>{{$setting_details->f5}}</center></h5>
    @endif
@endif    
<?php
}else if($page_size=="2 inch")
{?>
@if(!empty($setting_details))
    @if($setting_details->h1!=null)
        <center><h5>{{$setting_details->h1}}</h5></center>
    @endif
    @if($setting_details->h2!=null)
        <h5><center>{{$setting_details->h2}}</center></h5>
    @endif
    @if($setting_details->h3!=null)
        <h5><center>{{$setting_details->h3}}</center></h5>
    @endif
    @if($setting_details->h4!=null)
        <h5><center>{{$setting_details->h4}}</center></h5>
    @endif
    @if($setting_details->h5!=null)
        <h5><center>{{$setting_details->h5}}</center></h5>
    @endif
@endif
<table align="center" width="100%">
    <tr>
        <td style="font-size:12px;width:70px;"><b>Bill No: {{$bill_details[0]->bill_no}}</b></td>
        <td style="font-size:12px;text-align:right;width:100px"><b>Date: <?php echo date('Y-m-d');?></b></td>
    </tr>
</table>
<b align="center">----------------------------------</b>
<table align="center">
    <thead>
        <th style="font-size:12px;">No.</th>
        <th style="font-size:12px;">Item Name</th>
        <th style="font-size:12px;">Qty</th>
        <th style="font-size:12px;">Rate</th>
        <th style="font-size:12px;">Amount</th>
    </thead>
    <tbody>
    <tr></tr>
@if(!empty($bill_details))
    @foreach($bill_details as $bill)
        <?php $total=$total+$bill->item_totalrate;?>
        <tr>
            <td style="text-align:center;font-size:12px;">1</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_name}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_qty}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_rate}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_totalrate}}</td>
        </tr>       
    @endforeach
@endif
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size:12px;"><b>Total</b></td>
    <td style="font-size:12px;text-align:center;"><?php echo round($total,3)?></td>
</tr>
</tbody>
</table>
<b align="center">----------------------------------</b>
@if(!empty($setting_details))
    @if($setting_details->f1!=null)
        <h5><center>{{$setting_details->f1}}</center></h5>
    @endif
    @if($setting_details->f2!=null)
        <h5><center>{{$setting_details->f2}}</center></h45
    @endif
    @if($setting_details->f3!=null)
        <h5><center>{{$setting_details->f3}}</center></h5>
    @endif
    @if($setting_details->f4!=null)
        <h5><center>{{$setting_details->f4}}</center></h5>
    @endif
    @if($setting_details->f5!=null)
        <h5><center>{{$setting_details->f5}}</center></h5>
    @endif
@endif  
<?php   
}else if($page_size=="3 inch")
{?>
@if(!empty($setting_details))
    @if($setting_details->h1!=null)
        <h5><center>{{$setting_details->h1}}</center></h5>
    @endif
    @if($setting_details->h2!=null)
        <h5><center>{{$setting_details->h2}}</center></h5>
    @endif
    @if($setting_details->h3!=null)
        <h5><center>{{$setting_details->h3}}</center></h5>
    @endif
    @if($setting_details->h4!=null)
        <h5><center>{{$setting_details->h4}}</center></h5>
    @endif
    @if($setting_details->h5!=null)
        <h5><center>{{$setting_details->h5}}</center></h5>
    @endif
@endif

<table align="center" width="100%">
    <tr>
        <td style="font-size:12px;"><b>Bill No: {{$bill_details[0]->bill_no}}</b></td>
        <td style="text-align: right;font-size:12px;"><b>Date: <?php echo date('Y-m-d');?></b></td>
    </tr>
</table>
<hr>
<table align="center">
    <thead>
        <th style="font-size:12px;">No.</th>
        <th style="font-size:12px;">Item Name</th>
        <th style="font-size:12px;">Qty</th>
        <th style="font-size:12px;">Rate</th>
        <th style="font-size:12px;">Amount</th>
    </thead>
    <tbody>
    <tr></tr>
@if(!empty($bill_details))
    @foreach($bill_details as $bill)
        <?php $total=$total+$bill->item_totalrate;?>
        <tr>
            <td style="text-align:center;font-size:12px;">1</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_name}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_qty}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_rate}}</td>
            <td style="text-align:center;font-size:12px;">{{$bill->item_totalrate}}</td>
        </tr>       
    @endforeach
@endif
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size:12px;"><b>Total</b></td>
    <td style="font-size:12px;text-align:center;"><?php echo round($total,3)?></td>
</tr>
</tbody>
</table>
<hr>
@if(!empty($setting_details))
    @if($setting_details->f1!=null)
        <h5><center>{{$setting_details->f1}}</center></h5>
    @endif
    @if($setting_details->f2!=null)
        <h5><center>{{$setting_details->f2}}</center></h45
    @endif
    @if($setting_details->f3!=null)
        <h5><center>{{$setting_details->f3}}</center></h5>
    @endif
    @if($setting_details->f4!=null)
        <h5><center>{{$setting_details->f4}}</center></h5>
    @endif
    @if($setting_details->f5!=null)
        <h5><center>{{$setting_details->f5}}</center></h5>
    @endif
@endif
<?php
}?>
<?php
//exit;
?>

