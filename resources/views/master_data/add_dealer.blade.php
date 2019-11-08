@extends('layouts.app')
@section('title', 'Add User')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
      <h1>
          Add Dealer
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Dealer Registration</a></li>
        <li class="active">Add Dealer</li>
      </ol>
    </section>
   <section class="content">
<div class="row">
 <div class="col-md-12">
          <div class="box" style="border-top: 3px solid #ffffff;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <form class="form-horizontal" id="dealerForm" method="post" action="{{ url('add_dealer') }}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="userName" class="col-sm-2 control-label">Dealer Name<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control check-req" id="dealer_name" placeholder="Name" name="dealer_name">
                  </div>
                  <label for="userName" class="col-sm-2 control-label">Owner Name<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control check-req" id="owner_name" placeholder="Name" name="owner_name" required>
                  </div>
                  
                </div>
                <div class="form-group">
                   <label for="company" class="col-sm-2 control-label">Mobile No.<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control check-req" id="dealer_mobile_no" placeholder="Mobile No." name="dealer_mobile_no" required maxlength="10" onkeypress="return isNumberKey(event)">
                  </div>
                   <label for="gst" class="col-sm-2 control-label">Email ID<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                    <input type="email" class="form-control check-req" id="email" placeholder="Email ID" name="email" required>
                  </div>
                </div>
                <div class="form-group">  
                  <label class="col-sm-2 control-label">Address<span style="color:#ff0000;">*</span></label>  
                    <div class="col-sm-4">
                    <textarea class="form-control check-req" rows="3" placeholder="Enter Address..." name="dealer_address"></textarea>   
                    </div>
                   <label for="gst" class="col-sm-2 control-label">Password<span style="color:#ff0000;">*</span></label>

                  <div class="col-sm-4">
                    <input type="password" class="form-control check-req" id="password" placeholder="Password" name="password" required>
                  </div>
                  
                </div>
                 <div class="form-group">
                  
                   <label for="gst" class="col-sm-2 control-label">State<span style="color:#ff0000;">*</span></label>
                  <div class="col-sm-4">
                    <!--<input type="text" class="form-control" id="dealer_state" placeholder="State" name="dealer_state" required>-->
                    <select class="form-control select2 check-req" style="width: 100%;" id="dealer_state" name="dealer_state" required>
                     <option value="">-- Select State -- </option>
                      @foreach($state_list as $st)
                        <option value="{{$st->state_name}}">{{$st->state_name}}</option>
                      @endforeach
                    </select>
                  </div>
                   <label for="gst" class="col-sm-2 control-label">City<span style="color:#ff0000;">*</span></label>
                  <div class="col-sm-4">
                    <!--<input type="text" class="form-control" id="dealer_city" placeholder="City" name="dealer_city" required>-->
                    <select class="form-control select2 check-req" style="width: 100%;" name="dealer_city" id="dealer_city" required>
                    <option value="">-- Select City -- </option>
                    @foreach($city_list as $ct)
                        <option value="{{$ct->city_name}}">{{$ct->city_name}}</option>
                    @endforeach
                      <option value="West Bengal">West Bengal</option>-->
                   </select>
                  </div> 
                </div>
                  <div class="form-group">
                      <label for="gst" class="col-sm-2 control-label">GST No.<span style="color:#ff0000;">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control check-req" id="dealer_gst_no" placeholder="GST No." name="dealer_gst_no" required>
                  </div>
                       <label for="gst" class="col-sm-2 control-label">Dealer Code<span style="color:#ff0000;">*</span></label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="dealer_code" placeholder="Dealer Code" name="dealer_code" required maxlength="4">
                  </div>
                  </div>  
              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                  <a href="{{url('dealer_data')}}" class="btn btn-danger" >Cancel</a>
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
function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
}
 $(document).ready(function(){
    $('.select2').select2() 
    
   
    
    $("#btn_submit").click(function(){
        var flag=false;
        $('.check-req').each(function() {
            var val=$(this).val();
//            alert(val);
            if(val=="")
            {
//                alert("in if");
                flag=true;
                return false;
            } 
        });
//        alert(flag);
        if(flag == true)
        {
//           alert("if true");
            swal({
                position: 'top-end',
                type: 'warning',
                title: 'Please enter all required fields',
                showConfirmButton: true,
            }); 
           return false;
        }
        else
        {
       
//        alert("after each");
        var dealer_code=$("#dealer_code").val();
        if(dealer_code!="")
        {
//            alert(dealer_code);
            $.ajax({
                url: 'get_dealer_code',
                type: "get",
                data: {dealer_code:dealer_code},
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
                             swal({
                                position: 'top-end',
                                type: 'warning',
                                title: 'Dealer code already taken',
                                showConfirmButton: true,
                                }); 
                                $("#dealer_code").val("");
                        }
                        else if(data3=="not present")
                        {
                            $("#dealerForm").submit();
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
        }
    });
    
 });
</script>
@endsection
