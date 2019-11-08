@extends('layouts.app')

@section('content')
<h1>Welcome Super Admin</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <?php
$color_array=array("bg-aqua","bg-green","bg-yellow","bg-red");
$a=0;

?>
@foreach($status as $row)
<?php
$data = \App\Enquiry::where(['status_id'=>$row->id,'active_inactive_status'=>1])->count();
if($a > 3){$a=0;}?>
<!--<div class="col-lg-3 col-xs-12">
           small box 
          <div class="small-box <?php echo $color_array[$a];?>">
            <div class="inner">
                <h3 style=" text-align: center;">{{$row->status_name}}</h3>

              <h3 style=" text-align: center;">{{$data}}</h3>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('dashboard_enq_list?status_id='.$row->id)}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>-->

<?php $a++;?>
@endforeach
            </div>
        </div>
    </div>
<!--    <div class="col-md-6">
    <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Todays FollowUp</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
             /.box-header 
            <div class="box-body" style="">
              <div class="table-responsive">
                <table class="table no-margin" >
                  <thead>
                  <tr>
                    <th>E-No</th>
                    <th>Cust. Name</th>
                    <th>Mob. No</th>
                    <th>Prod.Name</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($today_en as $e)
                    <tr>
                      <td><a href="{{url('edit-enquiry?id='.$e->enquiry_id)}}">{{$e->enquiry_no}}</a></td>
                      <td>{{$e->customer_name}}</td>
                      <td>{{$e->mobile_no}}</td>
                    </tr>  
                    @endforeach
                  </tbody>
                </table>
              </div>
               /.table-responsive 
            </div>
          </div>
        </div>-->
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
</script>
@endsection
