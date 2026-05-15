<!DOCTYPE html>
<?php
$lang = 'ar';//LaravelLocalization::getCurrentLocale() ;
$dir = "";
$arrow = "right";
$pull = "pull-left";
if ($lang == "ar") {
    $dir = "rtl";
    $arrow = "left";
    $pull = "pull-right";
}
$site = App\Site::first();
?>
<html lang="{{$lang}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{URL::to('admin_panel')}}/images/favicon.ico">

        <title>{{$site[$lang.'_title']}} - {{trans('layout.admin')}} </title>

        <!-- Bootstrap 4.0-->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css">

        <!-- Bootstrap 4.0-->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/assets/vendor_components/font-awesome/css/font-awesome.min.css">

        <!-- Ionicons -->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/assets/vendor_components/Ionicons/css/ionicons.min.css">		

        <!-- bootstrap datepicker -->	
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/css/{{$lang}}/master_style.css">

        <!-- bonitoadmin Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{URL::to('admin_panel')}}/css/{{$lang}}/skins/_all-skins.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- google font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            @include('admin.layouts.include.header')

            @include('admin.layouts.include.sidebar')

            <div class="content-wrapper" dir="{{$dir}}">
                @yield('content')
            </div>

            @include('admin.layouts.include.footer')

            <input type="hidden" value="{{URL::to('/')}}" id="base-url">
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/jquery/dist/jquery.min.js"></script>

        <!-- popper -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/popper/dist/popper.min.js"></script>

        <!-- Bootstrap 4.0-->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- DataTables -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

        <!-- SlimScroll -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

        <!-- FastClick -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/fastclick/lib/fastclick.js"></script>

        <!-- bonitoadmin App -->
        <script src="{{URL::to('admin_panel')}}/js/template.js"></script>

        <!-- bonitoadmin for demo purposes -->
        <script src="{{URL::to('admin_panel')}}/js/demo.js"></script>

        <!-- This is data table -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>

        <!-- bootstrap datepicker -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <!-- start - This is for export functionality only -->
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
        <script src="{{URL::to('admin_panel')}}/assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>
        <!-- end - This is for export functionality only -->

        <!-- bonitoadmin for Data Table -->
        <script src="{{URL::to('admin_panel')}}/js/pages/data-table.js"></script>


        @yield('scripts')

    </body>
</html>
