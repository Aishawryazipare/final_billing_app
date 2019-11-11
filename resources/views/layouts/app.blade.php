<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>One Care App</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_componentshttp://localhost/billingApp/public/login#/Ionicons/css/ionicons.min.css">
  
 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
      <link href="css/sweetalert.css" rel="stylesheet">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .error{
        color: red;
    }
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
    ::-webkit-scrollbar {
    width: 0px;
    background: transparent;
</style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    @include('layouts.common.header')
    @include('layouts.common.sidebar')
     
     <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div id="content">
        @yield('content')
    </div>
    </section>

    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
    @include('layouts.common.footer')
   <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
   
  </aside>  
  <div class="control-sidebar-bg"></div>
    </div>
</body>
<script src="js/sweetalert.min.js"></script>

<script>
    $(document.body).addClass('skin-blue sidebar-mini sidebar-collapse');
     $(document).ready(function() {
            $('div.alert').delay(3000).slideUp(300);
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
    })
//        var mouseY = 0;
//       var topValue = 0;
//       window.addEventListener("mouseout",function(e){
//           mouseY = e.clientY;
//           if(mouseY<topValue) {
//               swal({
//               title: "Please Confirm?",
//               text: "Sync Data",
//               type: "warning",
//               showCancelButton: true,
//               confirmButtonColor: "#e74c3c",
//               confirmButtonText: "Yes",
//               cancelButtonText: "No",
//               closeOnConfirm: true,
//               closeOnCancel: true,
//               showLoaderOnConfirm: true,
//               showLoaderOnCancel: true,
//             }, function(isConfirm){
//                 if (isConfirm) {
//                    var msg="Master Data";
//                    $.ajax({
//                            url: 'sync_category',
//                            type: "GET",
//                            data: {data:msg},
//                            success: function(result) 
//                            {
//                                var res=JSON.parse(result);
//                                console.log(res); 
//                            }
//                        });
//                 }
//                 else {
//                     swal("Cancelled");
//                 }
//           });
//           }
//       },
//       false);
        });
    </script>




