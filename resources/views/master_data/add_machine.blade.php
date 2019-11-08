@extends('layouts.app')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
    <h1>
      Add Machine
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Machine Tracking</a></li>
      <li class="active">Add Machine</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Machine</h3>
            </div>
              <form action="{{ url('add_machine') }}" method="POST" id="type_form" class="form-horizontal" >
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_machine_model_no" class="col-sm-2 control-label">Model No.<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="machine_model_no" placeholder="Model No." name="machine_model_no" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_machine_ser_no" class="col-sm-2 control-label">Serialization No.<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="machine_ser_no" placeholder="Serialization No." name="machine_ser_no" required>
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="button" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
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
    $("#btn_submit").click(function(){
        var machine_ser_no=$("#machine_ser_no").val();
        var machine_model_no=$("#machine_model_no").val();
        if(machine_model_no=="")
        {
            swal({
                    position: 'top-end',
                    type: 'warning',
                    title: 'Please enter Machin Model No.',
                    showConfirmButton: true,
                    }); 
            return false;
        }
        if(machine_ser_no!="")
        {
            $.ajax({
                url: 'get_serial_no',
                type: "get",
                data: {machine_ser_no:machine_ser_no},
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
//                             alert(data3);
                             swal({
                                position: 'top-end',
                                type: 'warning',
                                title: 'Serial No. already exists',
                                showConfirmButton: true,
                                }); 
                                $("#machine_ser_no").val("");
                        }
                        else if(data3=="not present")
                        {
                            $("#type_form").submit();
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
            title: 'Please Machine Serial No.',
            showConfirmButton: true,
            }); 
        }
//        alert(dealer_code);
    });    
 });
</script>
@endsection