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
      Thumbnail Form
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Thumbnail Form</li>
    </ol> 
</section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search_code" id="search_code" class="form-control" onkeyup="get_code(this.value)" placeholder="Search By Name/Code/Barcode"/>
            </div>
            <div class="col-md-3">
                <input type="text" name="cust_name"  class="form-control"  onkeyup="assign_name(this.value)" placeholder="Client Name"/>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="">
                        <div class="iradio_minimal-blue checked" aria-checked="true" aria-disabled="false" style="position: relative;"><input type="radio" name="cash_or_credit" class="minimal" value="single" checked="" style="position: absolute; opacity: 0;" required> Card</div>
                    </label>
                    <label class="">
                        <div class="iradio_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="radio" name="cash_or_credit" class="minimal" value="multiple" style="position: absolute; opacity: 0;" required> Cash</div>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
             <div class="col-md-6">
             <div class="box box-default">
<!--            <div class="box-header with-border">
              <h3 class="box-title">Bill No:1</h3>
            </div>-->
           
              <div class="box-body">
                  <?php  foreach($category_data as $data){?>
                    <button type="submit" class="btn btn-success btn-lg cat" id="btn_submit" name="btn_submit" style="background-color:#FFFF80;color:black;" onclick="get_items(<?php echo $data->cat_id;?>)">{{$data->cat_name}}</button>
                    <span class="info-box-number cat_id" style="display:none;"><h2>{{$data->cat_id}}</h2></span>
                  
                  <?php }$all=0; ?>
                    <button type="submit" class="btn btn-success btn-lg cat" id="btn_submit" name="btn_submit" style="background-color:#FFFF80;color:black;" onclick="get_items(<?php echo $all;?>)">All Items</button>
                    <br/>
                    <br/>
                    <div id="item_data">
                        
                    </div>
                </div>  
                 </div>
        </div>
             <div class="col-md-6 table-responsive" id="print_content">
                 <form action="{{ url('add_bill') }}" method="POST" id="bill_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                 <div class="box box-default">
                     <div class="box-body">
                      
                      <h4 align="center">Bill No: {{@$bill_data->bill_no}}</h4>
                      <div class="row">
                          <div class="col-md-6"><span id="cust_data"></span><input type="hidden" name="cust_name" id="cust_name" class="form-control"/></div>
                          <div class="col-md-6"><span id="date" style="margin-left: 100px;"><b>Date: </b><?php echo date('Y-m-d');?></span></div>
                          <input type="hidden" name="cash_or_credit" id="cash_or_cerdit" value="cash"/>
                      </div>
                      <br/>
                       <table class="table table-striped" align="center">
            <thead>
            <tr>
              <th>No</th>
              <th>Item Name</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody id="bill_tbl">
                         <tr class="row1">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">Total</td>
                    <td style="font-weight: bold;"> <input type="text" name="bill_totalamt" class="bill_totalamt" id="bill_totalamt" style="border:none;"/></td>
                </tr>  
            </tbody>
          </table>   
                      
                     </div>   
                     <div class="box-footer">
                         <button type="button" style="display:none" class="btn btn-success pull-right" id="print_bill"><i class="fa fa-credit-card"></i> Print Bill
          </button>
          <button type="button" class="btn btn-primary pull-right" id="save_bill" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate Bill
          </button>
                     </div>
                 </div>
                  </form>
         
        </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="item_data">
            
            </div>  
            </div>
<!--        <div class="row">
            <div id="print_content1">
                hello
        </div>
        </div>-->
<!--      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Bill No:1</h3>
            </div>
              <form action="{{ url('add_inventory') }}" method="POST" id="inventory_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="text" name="search_code" id="search_code" class="form-control" onkeyup="get_code(this.value)"/>
                  <?php  foreach($category_data as $data){?>
                 <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua cat">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{$data->cat_name}}</span>
              <span class="info-box-number category"><h2>{{$data->cat_name}}</h2></span>
              <span class="info-box-number cat_id" style="display:none;"><h2>{{$data->cat_id}}</h2></span>

             
            </div>
             /.info-box-content 
          </div>
           /.info-box 
        </div>
                  <?php } ?>
                 
                </div>
                  
             
            </form>
          </div>
        </div>
      </div>
     <div class="row">
         <div class="box box-default">
             <div class="box-body" id="item_data">
            
             </div> 
         </div>                
     </div>
        <div class="row">
            <form action="{{ url('add_bill') }}" method="POST" id="inventory_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

               <div class="box box-default">
             <div class="box-body" id="">
                                        <input type="hidden" name="bill_array" id="bill_data"/>
                
                 <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Customer Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cat_name" placeholder="Customer Name" name="cust_name" required>
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Payment Type</label>
                        <div class="col-sm-4">
                                   <select class="form-control select2" style="width: 100%;" name="cash_or_credit" required>
                         <option value="cash">Cash</option> 
                         <option value="credit">Credit</option> 
                        
                    </select>
                        </div>
                    </div>
                  <button type="submit" class="btn btn-block btn-primary btn-lg" id="total_bill">Primary</button>
                 <br/>
                 <br/>
                     <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Item Name</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody id="bill_tbl">
                         <tr class="row1">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">Total</td>
                    <td style="font-weight: bold;"> <input type="text" name="bill_totalamt" class="bill_totalamt" id="bill_totalamt" style="border:none;"/></td>
                </tr>  
            </tbody>
          </table>
        </div>
         
         /.col 
      </div>
       <div class="box-footer">
                <button type="button" class="btn btn-success pull-right" id="btn_submit" name="btn_submit"><i class="fa fa-credit-card"></i> Generate Bill</button>
              </div>
             </div> 
     
         </div>
               </form>
        </div>-->
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
    $('.select2').select2() 
//             $.ajax({
//                url: 'get_setting_details',
//                type: "get",
//                success: function(reportdata) {
//                        console.log(reportdata);
//                        var data1 = JSON.parse(reportdata);
//                           
//                        if(data1!="")
//                        {   
//                            if(data1.h1!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.h1+'</b></h5></center>');
//                            }
//                            if(data1.h2!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.h2+'</b></h5></center>');
//                            }
//                            if(data1.h3!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.h3+'</b></h5></center>');
//                            }
//                            if(data1.h4!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.h4+'</b></h5></center>');
//                            }
//                            if(data1.h5!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.h5+'</b></h5></center>');
//                            }
//                            if(data1.f1!=null)
//                            {
//                                 $("#print_content1").append('<center><h5><b>'+data1.f1+'</b></h5></center>');
//                            }
//                        }
//                }
//                });  
//     $("#print_bill").click(function(){
//                console.log("Hello");
//                   var prtContent = document.getElementById("print_content");
//      var WinPrint = window.open('', '', 'left=0,top=0,width=900,height=900,toolbar=0,scrollbars=0,status=0');
//		//WinPrint=window.open();
//	  WinPrint.document.write(prtContent.innerHTML);
//       WinPrint.document.close();
//       WinPrint.focus();
//       WinPrint.print();
//       WinPrint.close();
	   
	  // window.print();

//        var printContent =document.getElementById("print_content");
//        var windowUrl = 'about:blank';
//        var uniqueName = new Date();
//        var windowName = 'Print' + uniqueName.getTime();
////
//        var printWindow = window.open(windowUrl, windowName, 'left=50000,top=50000,width=800,height=600');
//        printWindow.document.write(printContent.innerHTML);
//        printWindow.document.close();
//        printWindow.focus();
//        printWindow.print();
//        printWindow.close();
//    });
    $( "#save_bill" ).click(function() {
        var cust_name=$('#cust_name').val();
        var payment_type=$('#cash_or_credit').val();
        var total=$('#bill_totalamt').val();
        if(cust_name == "" || payment_type == "" || total == 0)
        {
            alert("Required");
            swal({
  position: 'top-end',
  type: 'warning',
  title: 'Please  Fill All Details',
  showConfirmButton: false,
  timer: 1500
}); 
        }
        else
        {
                     $.ajax({
                            url: 'add_bill',
                            type: "POST",
                            data: $('#bill_form').serialize(),
                            success: function(result) 
                            {
                            console.log(result);
                            swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "Bill Generated Successfully", confirmButtonText: "Ok" });
                            $('#print_bill').attr("display","block");
    }
                    });
        }
    });
    
 });
  function get_items(cat_id){
//         var cat_id=$(this).find('.cat_id').text();
         if(cat_id==0)
         {
             $('#item_data').html("");
         }
         $.ajax({
                            url: 'get-item',
                            type: "GET",
                            data: {cat_id:cat_id},
                            success: function(result) 
                            {
                            console.log(result);
                            $('#item_data').append(result);
                        }
                    });
                    $(this).attr("disabled", true);
    }
 var total=0;
 var flag=0;
 var i=1;
 var result_arr=[];
 var new_qty;
 function cal(x,item_id)
 {
     flag=0;
     var item=$('#gitem_'+item_id).val();
     total=parseFloat(total)+parseFloat(x);
     result_arr.push(item_id);
     result_arr.push(x);
     $('#bill_data').val(result_arr);
     $('#bill_totalamt').val(total);
     $('#total_bill').text("Total Amount: "+total);
//     alert(result_arr);
$('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=parseFloat(new_qty)*parseFloat(rate);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
if(flag==0)
{
    qty=1;
    rate=x;
    amt=qty*rate;
    $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:left;'>" + i + "</td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][1]' class='item_name' value='" + item + "' style='border:none;width:100px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][2]' class='item_qty'  value='" + qty + "' style='border:none;width:30px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][3]' class='item_rate' value='" + rate + "' style='border:none;width:50px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][4]' class='item_amt' value='" + amt + "' style='border:none;width:80px;'/></td>\n\
            </tr>");
     i++;
}
 }
 function get_code(code)
 {
     var flag=0;
                $.ajax({
                            url: 'check-code',
                            type: "GET",
                            data: {code:code},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            var item=a.item_name;
                            var rate=a.item_rate;
                            var qty=1;
                            var amt=parseFloat(rate)*parseFloat(rate);
                            $('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=parseFloat(new_qty)*parseFloat(rate);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
if(flag==0)
{
    $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:left;'>" + i + "</td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][1]' class='item_name' value='" + item + "' style='border:none;width:100px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][2]' class='item_qty'  value='" + qty + "' style='border:none;width:30px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][3]' class='item_rate' value='" + rate + "' style='border:none;width:50px;'/></td>\n\
                    <td style='text-align:left;'><input type='text' name='stoppage[" + i + "][4]' class='item_amt' value='" + amt + "' style='border:none;width:80px;'/></td>\n\
            </tr>");
     i++;
}
                            }
                    });
 }
 function assign_name(cust_name)
 {
     $('#cust_name').val(cust_name);
     $('#cust_data').html("<b>Customer Name: </b> "+cust_name+"");
 }
</script>
@endsection


