@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Change Password</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Dashboard</li>
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
                    <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" id="changePasswordForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Current Password">
                            <span id="currentPwdError" class="text-danger"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                            <span id="newPwdError" class="text-danger"></span>    
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="confirm_new_password" class="col-sm-2 col-form-label">Confirm New Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password_confirmation" id="confirm_new_password" placeholder="Confirm New Password">
                            <span id="confirmPwdError" class="text-danger"></span>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="submit" class="btn btn-info mr-2" value="Submit">
                        <a href="{{ route('dashboard-view') }}" class="btn btn-default">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>

@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $('#current_password').on('change', function(){
                if( $('#current_password').val().trim() == '' ||  $('#current_password').val().trim() == null){
                    $('#current_password').focus();
                    $('#current_password').css('border', '1px solid red');
                    $('#currentPwdError').show().html('Current Password field is required');
                }else{
                    $('#current_password').css('border', '1px solid green');
                    $('#currentPwdError').hide();
                }
            });

            $('#new_password').on('change', function(){
                if( $('#new_password').val().trim() == '' ||  $('#new_password').val().trim() ==  null){
                    $('#new_password').focus();
                    $('#new_password').css('border', '1px solid red');
                    $('#newPwdError').show().html('New Password field is required');
                }else{
                    $('#new_password').css('border', '1px solid green');
                    $('#newPwdError').hide();
                }
            });

            $('#confirm_new_password').on('change', function(){
                if($('#confirm_new_password').val().trim() == '' || $('#confirm_new_password').val().trim() == null){
                    $('#confirm_new_password').focus();
                    $('#confirm_new_password').css('border', '1px solid red');
                    $('#confirmPwdError').show().html('Confirm Password field is required');
                }else{
                    $('#confirm_new_password').css('border', '1px solid green');
                    $('#confirmPwdError').hide();
                }
            });

            $('#changePasswordForm').on('submit', function(e){
                e.preventDefault();

                var current_password = $('#current_password').val();
                var new_password = $('#new_password').val();
                var confirm_new_password = $('#confirm_new_password').val();
                var temp = 0;

                    if(current_password.trim() == '' ||  current_password.trim() == null){
                        $('#current_password').focus();
                        $('#current_password').css('border', '1px solid red');
                        $('#currentPwdError').show().html('Current Password field is required');
                        temp ++;
                    }else{
                        $('#current_password').css('border', '1px solid green');
                        $('#currentPwdError').hide();

                        $.ajax({
                            type: "POST",
                            url: "{{ route('verifyCurrentPassword') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                current_password: current_password
                            },
                            success: function(response){
                                if(response.status == 'success'){
                                    $('#current_password').css('border', '1px solid green');
                                    $('#currentPwdError').hide();
                                }else{
                                    $('#current_password').focus();
                                    $('#current_password').css('border', '1px solid red');
                                    $('#currentPwdError').show().html(response.message);
                                }
                            }
                        });
                    }
                   
                    if(new_password.trim() == '' || new_password.trim() == null){
                        $('#new_password').focus();
                        $('#new_password').css('border', '1px solid red');
                        $('#newPwdError').show().html('New Password field is required');
                        temp++;
                    }else{
                        if(new_password.trim() != confirm_new_password.trim() && (confirm_new_password.trim() != '' || confirm_new_password.trim() != null)){
                            $('#new_password').css('border', '1px solid red');
                            $('#newPwdError').show().html('Passwords do not match');
                            temp++;
                        }else{
                            $('#new_password').css('border', '1px solid green');
                            $('#newPwdError').hide();
                        }
                    }
                
                    if(confirm_new_password.trim() == '' || confirm_new_password.trim() == null){
                        $('#confirm_new_password').focus();
                        $('#confirm_new_password').css('border', '1px solid red');
                        $('#confirmPwdError').show().html('Confirm Password field is required');
                        temp++;
                    }else{
                        if(new_password.trim() != confirm_new_password.trim() && (new_password.trim() != '' || new_password.trim() != null)){
                            $('#confirm_new_password').css('border', '1px solid red');
                            $('#confirmPwdError').show().html('Passwords do not match');
                            temp++;
                        }else{
                            $('#confirm_new_password').css('border', '1px solid green');
                            $('#confirmPwdError').hide();
                        }
                    }

                if(temp == 0){
                    var formData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('changePassword') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            if(response.status == 'success'){
                                window.location.href=response.redirect_url;
                            }else{
                                $('#newPwdError').show().html(response.message);
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