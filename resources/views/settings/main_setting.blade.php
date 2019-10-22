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
      Main Setting
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Main Setting</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Main Setting</h3>
            </div>
              <form action="{{ url('main-setting') }}" method="POST" id="type_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group" id="div1">
                        <label for="lbl_cat_name" class="col-sm-2 control-label">Page size</label>
                         <div class="col-sm-4">
                           <select class="form-control select2" style="width: 100%;" name="page_size" id="page_size">
                            @if(!empty($hf_setting))  
                                @if($hf_setting->page_size!=null)
                                   <option value="{{$hf_setting->page_size}}">{{$hf_setting->page_size}}</option>
                                @endif
                            @else
                                <option value="">Select</option>
                            @endif
                            
                            <option value="A5">A5</option>
                            <option value="2 inch">2 inch</option>
                            <option value="3 inch">3 inch</option>
                            <option value="other">other</option>
                        </select>
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                <a href="{{url('main-setting')}}" class="btn btn-danger" >Cancel</a>
              </div>
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
                $.ajax({
                url: 'bill_print',
                type: "get",
                success: function(reportdata) {
                        console.log(reportdata);
                        var data1 = JSON.parse(reportdata);
                           
                        
                }
                });  
                });
                
                
});
</script>
@endsection


