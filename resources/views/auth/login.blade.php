<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo App | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Demo</b>App</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
      @endif
      <span id="emailSuccess"></span>
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="loginForm" action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" id="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span id="emailError"></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <span id="pwdError"></span>
        <div class="row">
          <div class="col-8">
            <!-- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="{{route('forgotPassword-view')}}">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script>

$(document).ready(function(){

  $('#loginForm').on('submit', function(e){
    e.preventDefault();
    var temp = 0;

    if($('#email').val().trim() == '' || $('#email').val().trim() == null){
      $('#email').focus();
      $('#email').css('border', '1px solid red');
      $('#emailError').show().html('Email field is required').css('color', 'red');
      temp++;
    }else{
      $('#email').css('border', '1px solid green');
      $('#emailError').hide();
    }

    if($('#password').val().trim() == '' || $('#password').val().trim() == null){
      $('#password').focus();
      $('#password').css('border', '1px solid red');
      $('#pwdError').show().html('Password field is required').css('color', 'red');
      temp++;
    }else{
      $('#password').css('border', '1px solid green');
      $('#pwdError').hide();
    }

    if(temp == 0){
      this.submit();
    }
  });
  

});

</script>
</body>
</html>
