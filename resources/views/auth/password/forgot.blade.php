<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo App | Forgot Password</title>

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
    <a href=""><b>Demo</b>App</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form id="forgotPasswordForm">
        @csrf
        <div class="input-group mb-3">
          <input type="email"name="email" class="form-control" id="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span id="emailError" style="color: red;"></span>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('login-view') }}">Login</a>
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
    $('#email').change(function(){
        if($('#email').val().trim() == '' || $('#email').val().trim() == null){
            $('#email').focus();
            $('#email').css('border', '1px solid red');
            $('#emailError').show().html('Email field is required');
        }else{
            $('#email').css('border', '1px solid green');
            $('#emailError').hide();
        }
    });

    $('#forgotPasswordForm').submit(function(e){
        e.preventDefault();

        var email = $('#email').val();
        var temp = 0;

        if(email.trim() == '' || email.trim() == null){
            $('#email').focus();
            $('#email').css('border', '1px solid red');
            $('#emailError').show().html('Email field is required');
            temp++;
        }else{
          $('#email').css('border', '1px solid green');
          $('#emailError').hide();
        }

        if(temp == 0){
            $.ajax({
                type: 'POST',
                url: '{{ route("forgotPassword") }}',
                data: {  _token: '{{ csrf_token() }}',email: email},
                success: function(response){
                    if(response.status == 'success'){
                        window.location.href = response.redirect_url;
                        $('#emailSuccess').show().html(response.message);
                    }else{
                        $('#email').focus();
                        $('#email').css('border', '1px solid red');
                        $('#emailError').show().html(response.message);
                    }
                }
            });
        }

    });
</script>
</body>
</html>
