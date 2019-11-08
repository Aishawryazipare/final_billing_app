<?php if (count($inventory_data) > 0) {
    ?>
<table border="1">
    <tr><td colspan="5"><h3>Inventory Report</h3></td><td style="text-align:center;"></td></tr>
        <tr> 
            <th style="text-align:center;">Sr.No.</th>
            <th style="text-align:center;">Supplier Name</th>
            <th style="text-align:center;">Item</th>
            <th style="text-align:center;">Quantity</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Location</th>
        </tr>
              <?php $i=1;$total_amt=$total_cash=0;
                  foreach($inventory_data as $data) {
                        $supplier_data= \App\Supplier::select('*')->where(['sup_id'=>$data->inventorysupid])->first();
                         $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
                        $total_amt=$total_amt+$data->inventoryitemquantity;
//                      $total_cash=$total_cash+$data->cash_or_credit;
                      ?>
        <tr>
            <td style="text-align:center;">{{$i}}</td>
            <td style="text-align:center;">{{$supplier_data->sup_name}}</td>
            <td style="text-align:center;">{{$data->inventoryitemid}}</td>
            <td style="text-align:center;">{{$data->inventoryitemquantity}}</td>
            <td style="text-align:center;">{{$data->inventorystatus}}</td>
            <td style="text-align:center;">{{$location_data->loc_name}}</td>
        </tr>
                    <?php
                  }
                  ?>
        <tr>
            <td style="text-align:center;">Total</td>
            <td></td>
            <td></td>
            <td style="text-align:center;">{{$total_amt}}</td>
            <td style="text-align:center;">{{$total_cash}}</td>
        </tr>
        
</table>
<?php 
//exit;
  $the_data = 'this is test text for downloading the contents.';
    $report_name = "Inventory Report";
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
                    location.href = 'inventory_report';
                }
        );
    //    swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Sumbmitted Successfully for line A", confirmButtonText: "Ok" });

    });
    </script>
<?php
}
?>

