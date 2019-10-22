@extends('layouts.app')
@section('content')
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
      Header Footer Settings
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Header Footer Settings</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
<!--        <div class="col-md-3"></div>-->
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Header Footer Settings</h3>
            </div>
              <form action="{{ url('add_header_footer') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group" id="div1">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="h1" placeholder="Header 1" name="h1">
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">F1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="f1" placeholder="Footer 1" name="f1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="h2" placeholder="Header 2" name="h2">
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">F2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="f2" placeholder="Footer 2" name="f2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="h3" placeholder="Header 3" name="h3">
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">F3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="f3" placeholder="Footer 3" name="f3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H4</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="h4" placeholder="Header 4" name="h4">
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">F4</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="f4" placeholder="Footer 4" name="f4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H5</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="h5" placeholder="Header 5" name="h5">
                        </div>
                        <label for="lbl_cat_name" class="col-sm-2 control-label">F5</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control rate_cal" id="f5" placeholder="Footer 5" name="f5">
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">H5</label>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-success" id="btn_print" name="btn_print">Print</button>
                        </div>
                    </div>-->
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                <a href="{{url('setting_data')}}" class="btn btn-danger" >Cancel</a>
              </div>
<!--              <div id="print_content">
                  
              </div>-->
            </form>
          </div>
        </div>
      </div>
    </section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
 $(document).ready(function(){
    $('.select2').select2() 
//    alert("hi");
    $.ajax({
                url: 'get_setting_details',
                type: "get",
                success: function(reportdata) {
                        console.log(reportdata);
                        var data1 = JSON.parse(reportdata);
                           
                        if(data1!="")
                        {
                            $("#h1").val(data1.h1);
                            $("#h2").val(data1.h2);
                            $("#h3").val(data1.h3);
                            $("#h4").val(data1.h4);
                            $("#h5").val(data1.h5);
                            $("#f1").val(data1.f1);
                            $("#f2").val(data1.f2);
                            $("#f3").val(data1.f3);
                            $("#f4").val(data1.f4);
                            $("#f5").val(data1.f5);
                            if(data1!="")
                        {
                            if(data1.h1!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h1+'</b></h5></center>');
                            }
                            if(data1.h2!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h2+'</b></h5></center>');
                            }
                            if(data1.h3!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h3+'</b></h5></center>');
                            }
                            if(data1.h4!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h4+'</b></h5></center>');
                            }
                            if(data1.h5!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h5+'</b></h5></center>');
                            }
                            $("#print_content").append('<center>Billing content to print in the page</center>');
                            if(data1.f1!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.f1+'</b></h5></center>');
                            }
                            
                        }
                        }
                        else
                        {
                            $("#h1").val("");
                            $("#h2").val("");
                            $("#h3").val("");
                            $("#h4").val("");
                            $("#h5").val("");
                            $("#f1").val("");
                            $("#f2").val("");
                            $("#f3").val("");
                            $("#f4").val("");
                            $("#f5").val("");
                        }
                }
                });  
                 $("#btn_print").click(function(){
//                $.ajax({
//                url: 'get_setting_details',
//                type: "get",
//                success: function(reportdata) {
//                        console.log(reportdata);
//                        var data1 = JSON.parse(reportdata);
//                           
//                        
//                }
//                });  
//                    var css = '@page { size: A5; }',
//                    head = document.head || document.getElementsById('print_content'),
//                    style = document.createElement('style');
//                    style.type = 'text/css';
//                    style.media = 'print';
//
//                    if (style.styleSheet){
//                      style.styleSheet.cssText = css;
//                    } else {
//                      style.appendChild(document.createTextNode(css));
//                    }
//                    head.appendChild(style);
//                    window.print();
                    
                    var printContent =document.getElementById("print_content");
//                    console.log(printContent.innerHTML);
//                    alert(printContent.innerHTML);
                    var windowUrl = 'about:blank';
                    var uniqueName = new Date();
                    var windowName = 'Print' + uniqueName.getTime();
//
                    var printWindow = window.open(windowUrl, windowName, 'left=50000,top=50000,width=800,height=600');
                    printWindow.document.write(printContent.innerHTML);
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                });
                
                
});
</script>
@endsection


