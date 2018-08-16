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
      <a href="">
        |
        <b>Food</b>Rico</a> |
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body clearfix">
        <p class="login-box-msg ">Enter your email</p>

        <form action="#" method="post" id="send-email" enctype ="multipart/form-data">
          {!! csrf_field() !!}
          <!-- /.col -->
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-envelope"></i>
              </div>
              <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>
          </div>

          <div>
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password Via Email</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <!-- <a >I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

 <!-- jQuery 3 -->
  {!!Html::script('js/jquery.min.js')!!}
  <!-- Bootstrap 3.3.7 -->
  {!!Html::script('js/bootstrap.min.js')!!}

<script>
  $('#send-email').on('submit',function(e){
    e.preventDefault();
    console.log('pressed');
    var data = $(this).serialize();
    console.log(data);
    var formData = new FormData($(this)[0]);

    console.log(formData);

    $.ajax(
        {
          url:"{{route('sendEmail')}}",
          type: "POST",
          data: formData,
          async: false,
          success: function(response)
      {
       console.log(response);
       $("[data-dismiss = modal]").trigger({type: "click"});
          swal('SUCCESS', 'Correct Email', 'success').then(function() {
           window.location.replace("{{route('index')}}");
         });
       
       },
      cache: false,
      contentType: false,
      processData: false
    });

    e.preventDefault();

  });
</script>
</body>

</html>