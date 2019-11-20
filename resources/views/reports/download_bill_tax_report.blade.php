<?php if (count($bill_data) > 0) {
    $client_data=\App\Admin::select('reg_personname')->where(['rid'=>$cid])->first();
    ?>
<table border="1">
    <tr><td colspan="6"><h3>BillWise Tax Report</h3></td><td style="text-align:center;"></td></tr>
    <tr>
        <th>Client<br/>Name:</th>
        <td colspan="6">{{$client_data->reg_personname}}</td>
    </tr>
    <tr>
        <th>Date:</th>
        <td colspan="6">{{$from_date}} To {{$to_date}}</td>
        <!--<th colspan="5" style="text-align:right;">To Date:{{$to_date}}</th>-->
    </tr>
        <tr> 
            <th style="text-align:center;">Sr.No.</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Bill No</th>
            <th style="text-align:center;">Basic Amount</th>
            <th style="text-align:center;">Disc Amount</th>
            <th style="text-align:center;">Total Tax</th>
            <th style="text-align:center;">Bill Amount</th>
        </tr>
              <?php $i=1;$total_amt=$total_disc_amt=$total_tax_amt=$total_basic_amt=0;
                  foreach($bill_data as $data) {
                     $bill_detail_data= $bill_data = DB::table('bil_AddBillDetail')
                                        ->selectRaw('sum(discount) as total_discount')
                                        ->selectRaw('sum(item_rate) as total_rate')
                                        ->selectRaw('sum(bill_tax) as total_tax')
                                        ->where(['bill_no'=>$data->bill_no,'isactive'=>0])
                                        ->first();
                      $total_amt=$total_amt+$data->bill_totalamt;
                      $total_basic_amt=$total_basic_amt+$bill_detail_data->total_rate;
                      $total_disc_amt=$total_disc_amt+$bill_detail_data->total_discount;
                      $total_tax_amt=$total_tax_amt+$bill_detail_data->total_tax;
                      //$total_cash=$total_cash+$data->cash_or_credit;
                      ?>
        <tr>
            <td style="text-align:center;">{{$i}}</td>
            <td style="text-align:center;">{{$data->bill_date}}</td>
            <td style="text-align:center;">{{$data->bill_no}}</td>
            <td style="text-align:center;">{{$bill_detail_data->total_rate}}</td>
            <td style="text-align:center;">{{$bill_detail_data->total_discount}}</td>
            <td style="text-align:center;">{{$bill_detail_data->total_tax}}</td>
            <td style="text-align:center;">{{$data->bill_totalamt}}</td>
                     
        </tr>
                    <?php
                  $i++;}
                  ?>
        <tr>
            <td style="text-align:center;"><b>Total</b></td>
            <td></td>
            <td></td>
            <td style="text-align:center;">{{$total_basic_amt}}</td>
            <td style="text-align:center;">{{$total_disc_amt}}</td>
            <td style="text-align:center;">{{$total_tax_amt}}</td>
            <td style="text-align:center;">{{$total_amt}}</td>
        </tr>
        
</table>
<?php 
//exit;
  $the_data = 'this is test text for downloading the contents.';
    $report_name = "BillWise Tax Report";
    header("Content-Type: application/xls");
    header("Content-type: image/Upload");
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=$report_name.xls");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Transfer-Encoding: binary');
} else {
    $flg = 1;
    echo '<a href="javascript:void(0)" onclick="goToURL(); return false;"></a>';
//}
    ?>
    <link href="css/sweetalert.css" rel="stylesheet" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script>
    //    alert();
    $(document).ready(function () {
        swal({title: "Error", text: "No Report Available For This Date", type: "error", confirmButtonText: "Back"},
                function () {
                    location.href = 'bill_tax_report';
                }
        );
    //    swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Sumbmitted Successfully for line A", confirmButtonText: "Ok" });

    });
    </script>
<?php
}
?>

