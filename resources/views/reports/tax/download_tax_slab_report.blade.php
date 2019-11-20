<?php if (count($bill_data) > 0) {
    $client_data=\App\Admin::select('reg_personname')->where(['rid'=>$cid])->first();
    ?>
<table border="1">
    <tr><td colspan="3"><h3>Tax Slab Report</h3></td><td style="text-align:center;"></td></tr>
    <tr>
        <th>Client<br/>Name:</th>
        <td colspan="2">{{$client_data->reg_personname}}</td>
    </tr>
    <tr>
        <th>Date:</th>
        <td colspan="3">{{$from_date}} To {{$to_date}}</td>
        <!--<th colspan="5" style="text-align:right;">To Date:{{$to_date}}</th>-->
    </tr>
        <tr> 
            <th  style="text-align:center;">Sr.No.</th>
            <th style="text-align:center;">Tax%</th>
            <th style="text-align:center;">Tax Amount</th>
        </tr>
        <?php
        $i=1;
        $total_tax=0;
        foreach($bill_data as $data)
        {
            $total_tax=$total_tax+$data->tax_total;
            ?>
        <tr>
        <td style="text-align:center;">{{$i}}</td>
        <td style="text-align:center;">{{$data->discount}}</td>
        <td style="text-align:center;">{{$data->tax_total}}</td>
        </tr>
        <?php
        $i++;}
        ?>
        <tr>
            <td></td>
            <td>TOTAL TAX</td>
            <td style="text-align:center;">{{$total_tax}}</td>
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
}
else {
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
                    location.href = 'tax_slab_report';
                }
        );
    //    swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Sumbmitted Successfully for line A", confirmButtonText: "Ok" });

    });
    </script>
<?php
}
?>

