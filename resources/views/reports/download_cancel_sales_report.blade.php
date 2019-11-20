<?php if (count($bill_data) > 0) {
    ?>
<table border="1">
    <tr><td colspan="9"><h3>Sales Bill Report</h3></td><td style="text-align:center;"></td></tr>
        <tr> 
            <th style="text-align:center;">Sr.No.</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Bill No</th>
            <th style="text-align:center;">Customer Name</th>
            <th style="text-align:center;">Total Amount</th>
            <th style="text-align:center;">Cash/Credit</th>
            <th style="text-align:center;">POS</th>
            <th style="text-align:center;">Location</th>
            <th style="text-align:center;">User</th>
        </tr>
              <?php $i=1;$total_amt=$total_cash=0;
                  foreach($bill_data as $data) {
                     // print_r($data);exit;
                      $customer_data= \App\Customer::select('*')->where(['cust_id'=>$data->cust_id])->first();
                      $location_data= \App\EnquiryLocation::select('*')->where(['loc_id'=>$data->lid])->first();
                      $user_data= \App\Employee::select('*')->where(['cid'=>$data->cid,'lid'=>$data->lid,'id'=>$data->emp_id])->first();
                      if(empty($user_data))
                      {
                          $user_data= \App\Admin::select('*')->where(['rid'=>$data->cid])->first();
                          $user_data->name=$user_data->reg_personname;
                      }
                      if(empty($location_data))
                      $data->loc_name="Own";
                      else
                      $data->loc_name=$location_data->loc_name;
                      
                      $point_of_data= \App\PointOfContact::select('*')->where(['id'=>$data->point_of_contact])->first();
                      $total_amt=$total_amt+$data->bill_totalamt;
                      //$total_cash=$total_cash+$data->cash_or_credit;
                      ?>
        <tr>
            <td style="text-align:center;">{{$i}}</td>
            <td style="text-align:center;">{{$data->bill_date}}</td>
            <td style="text-align:center;">{{$data->bill_no}}</td>
            <?php if(!empty($customer_data)) {?>
            <td style="text-align:center;">{{$customer_data->cust_name}}</td>
             <?php } else { ?>
             <td style="text-align:center;"></td>
             <?php } ?>
            <td style="text-align:center;">{{$data->bill_totalamt}}</td>
            <td style="text-align:center;">{{$data->cash_or_credit}}</td>
            <td style="text-align:center;">{{@$point_of_data->point_of_contact}}</td>
            <td style="text-align:center;">{{$data->loc_name}}</td>
            <td style="text-align:center;">{{$user_data->name}}</td>
            
        </tr>
                    <?php
                  $i++;}
                  ?>
        <tr>
            <td style="text-align:center;">Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center;">{{$total_amt}}</td>
            <td style="text-align:center;">{{$total_cash}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
</table>
<?php 
//exit;
  $the_data = 'this is test text for downloading the contents.';
    $report_name = "Cancel Sales Bill Report";
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
                    location.href = 'cancel_bill_report';
                }
        );
    //    swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Form Sumbmitted Successfully for line A", confirmButtonText: "Ok" });

    });
    </script>
<?php
}
?>

