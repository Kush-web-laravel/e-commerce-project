@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Sub Admin</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Sub Admin</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>

        <div class="content col-md-10 ml-3">
            <div class="alert alert-danger" style="display: none;">
                <span id="errorMessage"></span>
            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Add Sub Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" id="subAdminForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            <span id="nameError" class="text-danger"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            <span id="emailError" class="text-danger"></span>    
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <span id="pwdError" class="text-danger"></span>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Confirm Password">
                            <span id="confirmPwdError" class="text-danger"></span>    
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="submit" class="btn btn-info mr-2" value="Submit">
                        <a href="{{ route('subAdmin-view') }}" class="btn btn-default">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>

@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $('#name').on('change', function(){
                if( $('#name').val().trim() == '' ||  $('#name').val().trim() == null){
                    $('#name').focus();
                    $('#name').css('border', '1px solid red');
                    $('#nameError').show().html('Name field is required');
                }else{
                    $('#name').css('border', '1px solid green');
                    $('#nameError').hide();
                }
            });

            $('#email').on('change', function(){
                if( $('#email').val().trim() == '' ||  $('#email').val().trim() ==  null){
                    $('#email').focus();
                    $('#email').css('border', '1px solid red');
                    $('#emailError').show().html('Email field is required');
                }else{
                    $('#email').css('border', '1px solid green');
                    $('#emailError').hide();
                }
            });
            $('#password').on('change', function(){
                if( $('#password').val().trim() == '' ||  $('#password').val().trim() == null){
                    $('#password').focus();
                    $('#password').css('border', '1px solid red');
                    $('#pwdError').show().html('Password field is required');
                }else{
                    if( $('#password').val().trim() != $('#confirm_password').val().trim() && ($('#confirm_password').val().trim() != '' || $('#confirm_password').val().trim() != null)){
                        $('#password').css('border', '1px solid red');
                        $('#pwdError').show().html('Passwords do not match');
                    }else{
                        $('#password').css('border', '1px solid green');
                        $('#pwdError').hide();
                    }
                }
            });

            $('#confirm_password').on('change', function(){
                if($('#confirm_password').val().trim() == '' || $('#confirm_password').val().trim() == null){
                        $('#confirm_password').focus();
                        $('#confirm_password').css('border', '1px solid red');
                        $('#confirmPwdError').show().html('Confirm Password field is required');
                    }else{
                        if($('#password').val().trim() != $('#confirm_password').val().trim() && ($('#password').val().trim() != '' || $('#password').val().trim() != null)){
                            $('#confirm_password').css('border', '1px solid red');
                            $('#confirmPwdError').show().html('Passwords do not match');
                        }else{
                            $('#confirm_password').css('border', '1px solid green');
                            $('#confirmPwdError').hide();
                        }
                    }
            });

            $('#subAdminForm').on('submit', function(e){
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();
                var temp = 0;

                    if(name.trim() == '' || name.trim() == null){
                        $('#name').focus();
                        $('#name').css('border', '1px solid red');
                        $('#nameError').show().html('Name field is required');
                        temp++;
                    }else{
                        $('#name').css('border', '1px solid green');
                        $('#nameError').hide();
                    }
                   

                    if(email.trim() == '' || email.trim() ==  null){
                        $('#email').focus();
                        $('#email').css('border', '1px solid red');
                        $('#emailError').show().html('Email field is required');
                        temp++;
                    }else{
                        $('#email').css('border', '1px solid green');
                        $('#emailError').hide();
                    }

                    if(password.trim() == '' || password.trim() == null){
                        $('#password').focus();
                        $('#password').css('border', '1px solid red');
                        $('#pwdError').show().html('Password field is required');
                        temp++;
                    }else{
                        if(password.trim() != confirm_password.trim() && (confirm_password.trim() != '' || confirm_password.trim() != null)){
                            $('#password').css('border', '1px solid red');
                            $('#pwdError').show().html('Passwords do not match');
                            temp++;
                        }else{
                            $('#password').css('border', '1px solid green');
                            $('#pwdError').hide();
                        }
                    }
                
                    if(confirm_password.trim() == '' || confirm_password.trim() == null){
                        $('#confirm_password').focus();
                        $('#confirm_password').css('border', '1px solid red');
                        $('#confirmPwdError').show().html('Confirm Password field is required');
                        temp++;
                    }else{
                        if(password.trim() != confirm_password.trim() && (password.trim() != '' || password.trim() != null)){
                            $('#confirm_password').css('border', '1px solid red');
                            $('#confirmPwdError').show().html('Passwords do not match');
                            temp++;
                        }else{
                            $('#confirm_password').css('border', '1px solid green');
                            $('#confirmPwdError').hide();
                        }
                    }

                if(temp == 0){
                    var formData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('addSubAdmin') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            if(response.status == 'success'){
                                window.location.href=response.redirect_url
                                $('#successMessage').show().html(response.message);
                            }else{
                                $('#errorMessage').show().html('Error creating sub admin !!');
                            }
                        }
                    });
                }else{
                    $('#errorMessage').show().html('Please fill all the fields properly.');
                }
            });
        });
    </script>

@endsection