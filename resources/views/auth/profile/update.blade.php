@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Profile</h1>
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
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" id="updateProfileForm">
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
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="resize-none form-control" name="address" id="address" placeholder="Address"></textarea>
                                <span id="addressError" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="city" id="city" placeholder="City">
                            <span id="cityError" class="text-danger"></span>    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-sm-2 col-form-label">State</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="state" id="state" placeholder="State">
                            <span id="stateError" class="text-danger"></span>    
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
            $('#name').change(function(){
                if($('#name').val().trim() == '' || $('#name').val().trim() == null){
                    $('#name').focus();
                    $('#name').css('border', '1px solid red');
                    $('#nameError').show().html('Name field is required');
                }else{
                    $('#name').css('border', '1px solid green');
                    $('#nameError').hide();
                }
            });

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

            $('#address').change(function(){
                if($('#address').val().trim() == '' || $('#address').val().trim() == null){
                    $('#address').focus();
                    $('#address').css('border', '1px solid red');
                    $('#addressError').show().html('Address field is required');
                }else{
                    $('#address').css('border', '1px solid green');
                    $('#addressError').hide();
                }
            });

            $('#city').change(function(){
                if($('#city').val().trim() == '' || $('#city').val().trim() == null){
                    $('#city').focus();
                    $('#city').css('border', '1px solid red');
                    $('#cityError').show().html('City field is required');
                }else{
                    $('#city').css('border', '1px solid green');
                    $('#cityError').hide();
                }
            });

            $('#state').change(function(){
                if($('#state').val().trim() == '' || $('#state').val().trim() == null){
                    $('#state').focus();
                    $('#state').css('border', '1px solid red');
                    $('#stateError').show().html('State field is required');
                }else{
                    $('#state').css('border', '1px solid green');
                    $('#stateError').hide();
                }
            });

            $('#updateProfileForm').submit(function(e){
                e.preventDefault();

                var name = $('#name').val();
                var email = $('#email').val();
                var address = $('#address').val();
                var city = $('#city').val();
                var state = $('#state').val();
                var temp = 0;

                if($('#name').val().trim() == '' || $('#name').val().trim() == null){
                    $('#name').focus();
                    $('#name').css('border', '1px solid red');
                    $('#nameError').show().html('Name field is required');
                    temp++;
                }else{
                    $('#name').css('border', '1px solid green');
                    $('#nameError').hide();
                }

                if($('#email').val().trim() == '' || $('#email').val().trim() == null){
                    $('#email').focus();
                    $('#email').css('border', '1px solid red');
                    $('#emailError').show().html('Email field is required');
                    temp++;
                }else{
                    $('#email').css('border', '1px solid green');
                    $('#emailError').hide();
                }

                if($('#address').val().trim() == '' || $('#address').val().trim() == null){
                    $('#address').focus();
                    $('#address').css('border', '1px solid red');
                    $('#addressError').show().html('Address field is required');
                    temp++;
                }else{
                    $('#address').css('border', '1px solid green');
                    $('#addressError').hide();
                }

                if($('#city').val().trim() == '' || $('#city').val().trim() == null){
                    $('#city').focus();
                    $('#city').css('border', '1px solid red');
                    $('#cityError').show().html('City field is required');
                    temp++;
                }else{
                    $('#city').css('border', '1px solid green');
                    $('#cityError').hide();
                }

                if($('#state').val().trim() == '' || $('#state').val().trim() == null){
                    $('#state').focus();
                    $('#state').css('border', '1px solid red');
                    $('#stateError').show().html('State field is required');
                    temp++;
                }else{
                    $('#state').css('border', '1px solid green');
                    $('#stateError').hide();
                }

                if(temp == 0){
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('profile') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            if(response.status == 'success'){
                                window.location.href=response.redirect_url
                            }else{
                                $('#errorMessage').show().html('Error filling the form.');
                                $('#errorMessage').css('display', 'block');
                            }
                        }
                    });
                }else{
                    $('#errorMessage').show().html('Please fill all the fields properly');
                }
            });
        });
    </script>

@endsection