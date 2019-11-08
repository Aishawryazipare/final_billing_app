@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>
        Edit Location
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('bil_location_update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="loc_id" value="{{$location->loc_id}}" />
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Location name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  placeholder="Location Name" value="{{$location->loc_name}}" id="loc_name" name="loc_name"  required >
                            </div>
                           
                        </div>
                        
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Update</button>
                        <a href="{{url('bil_location_list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>

@endsection
