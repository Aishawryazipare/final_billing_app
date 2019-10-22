@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1>
      Edit Machine
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit Machine</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Machine</h3>
            </div>
              <form action="{{ url('edit-machine') }}" method="POST" id="type_form" class="form-horizontal" >
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_machine_model_no" class="col-sm-2 control-label">Model No.</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="machine_model_no" placeholder="Model No." name="machine_model_no" required value="{{$machine_data->machine_model_no}}">
                        </div>
                    </div>
                     <input type="text" style="display:none;" class="form-control" id="machine_id" placeholder="Model No." name="machine_id" value="{{$machine_data->machine_id}}">
                    <div class="form-group">
                        <label for="lbl_machine_ser_no" class="col-sm-2 control-label">Serialization No.</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="machine_ser_no" placeholder="Serialization No." name="machine_ser_no" required value="{{$machine_data->machine_ser_no}}">
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

@endsection
