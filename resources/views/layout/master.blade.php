<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FoodRico System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
<style>.gridimage
{
  width: 10%;
  height: 10%;
  border: groove;
}
</style>

<style>
  .imageContainer > img:hover {
  width: 300px;
  height: 300px;
}
</style>
    {!!Html::style('css/bootstrap.min.css')!!}
    <!-- Font Awesome -->
    {!!Html::style('css/font-awesome.min.css')!!}
    <!-- Ionicons -->
    {!!Html::style('css/ionicons.min.css')!!}
    <!-- DataTables -->
    {!!Html::style('datatables/datatables.min.css')!!}

    {!!Html::style('sweetalert2/dist/sweetalert2.min.css')!!}

    <!-- Theme style -->
    {!!Html::style('css/AdminLTE.min.css')!!}
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->

    {!!Html::style('css/skin-green.min.css')!!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    @yield('style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-green fixed sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        @include('layout.header')

        <!-- Sidebar -->
        @include('layout.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>
                Copyright &copy; {{ date('Y') }}
                <a href="#">FoodRico</a>.
            </strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.2.3 -->

    {!!Html::script('js/jquery-2.2.3.min.js')!!}
    <!-- Bootstrap 3.3.6 -->
    {!!Html::script('js/bootstrap.min.js')!!}
    <!-- SlimScroll -->
    {!!Html::script('js/jquery.slimscroll.min.js')!!}
    <!-- AdminLTE App -->
    {!!Html::script('js/app.min.js')!!}
    <!-- datatable -->
    {!!Html::script('datatables/datatables.min.js')!!}
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {!!Html::script('sweetalert2/dist/sweetalert2.min.js')!!}
    
    @include('sweet::alert')

    @yield('script')
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>

</html>