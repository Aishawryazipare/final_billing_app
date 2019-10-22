@extends('layouts.app')

@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div><br><br>
            </div>
        </div>
    </div>
</div>
<script src="js/sweetalert.min.js"></script>
<script>
    function disable()
    {
        $.ajax({
        url: 'disable',
        type: "get",
        success: function(reportdata) { 
                console.log(reportdata);
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: '2FA disabled',
                    showConfirmButton: true,
                    }, function(isConfirm){
                     if (isConfirm) {
                        location.reload(true);
                     }
                     });  
        }
    });
    }
    </script>
@endsection


