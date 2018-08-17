<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FoodRico System | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  {!!Html::style('css/bootstrap.min.css')!!}
  <!-- Font Awesome -->
  {!!Html::style('css/font-awesome.min.css')!!}
  <!-- Ionicons -->
  {!!Html::style('css/ionicons.min.css')!!}
  <!-- DataTables -->
  {!!Html::style('datatables/datatables.min.css')!!}
  <!-- Theme style -->
  {!!Html::style('css/AdminLTE.min.css')!!}
  
  <!-- iCheck -->
  {!!Html::style('css/skin-green.min.css')!!}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="https://www.foodrico.com/">
        |
        <b>Dwarka</b></a> |
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">
        @if ($errors->has('company_registration_mykad_number'))
          <span class="text-red">
            <strong>{{ $errors->first('company_registration_mykad_number') }}</strong>
          </span>
        @else
          Sign in to start your session
        @endif
      </p>

      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group{{ $errors->has('company_registration_mykad_number') ? ' has-error' : ' has-feedback' }}">
          <input type="text" name="company_registration_mykad_number" class="form-control" placeholder="Company Reg. No. / MyKad No." value="{{ old('company_registration_mykad_number') }}" required autofocus />
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group{{ $errors->has('company_registration_mykad_number') ? ' has-error' : ' has-feedback' }}">
          <input type="password" name="password" class="form-control" placeholder="Password" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-success btn-lg btn-block btn-flat">
              Sign In
            </button>
          </div>
          <!-- /.col -->
        </div>
        <div>
        <br>
        <a href="{{route('forgotPassword')}}"><center>I forgot my password</center></a>
      </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  {!!Html::script('js/jquery.min.js')!!}
  <!-- Bootstrap 3.3.7 -->
  {!!Html::script('js/bootstrap.min.js')!!}
</body>

</html>