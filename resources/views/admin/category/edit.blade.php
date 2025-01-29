@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Category</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Category</li>
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
                    <h3 class="card-title">Update Category Details</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" id="updateCategoryForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-5">
                            <label for="category-name" class="col-sm-2 col-form-label">Name : </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="categoryName" name="category_name" autocomplete="off" value="{{ $categories->name }}">
                                <medium id="categoryNameErr" class="text-danger"></medium>
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="categoryImage" class="col-sm-2 col-form-label">Image : </label>
                            <div class="custom-file col-sm-10">
                                <input type="file" class="form-control" id="categoryImage" name="category_image" accept=".jpg, .jpeg, .png, .gif" autocomplete="off">
                                <label class="custom-file-label" for="categoryImage">Choose file</label>
                                <medium id="categoryImageErr" class="text-danger"></medium>
                                @if(isset($categories->image))
                                    <p id="categoryImagePreview" style="display: block; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">
                                        Current Image : <img src="{{ asset($categories->image) }}" id="categoryImagePreview" width="120" />
                                    </p>
                                @else
                                    <p id="categoryImagePreview" style="display: block; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Current Image : No image found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer mt-5">
                        <input type="submit" class="btn btn-info mr-2" value="Update">
                        <a href="{{ route('category-view') }}" class="btn btn-default">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
@endsection
@section('js')
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
        $(document).ready(function() {
            $('form#updateCategoryForm').on('submit', function(e){
                    e.preventDefault();
                    var categoryName = $('#categoryName').val();
                    var categoryImage = $('#categoryImage').val();
                    var temp = 0;
                    if(categoryName == ''){
                        $('#categoryNameErr').addClass('error');
                        $('#categoryNameErr').text('Category name is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#categoryNameErr').removeClass('error');
                        $('#categoryNameErr').text('');
                    }
                
                    if(categoryImage == ''){
                        $('#categoryImageErr').addClass('error');
                        $('#categoryImageErr').text('Category image is required').css('font-weight','bold');
                        temp++;
                    }else{
                        if(categoryImage != ''){
                            var extension = $('#categoryImage').val().split('.').pop().toLowerCase();
                            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                                $('#categoryImageErr').addClass('error');
                                $('#categoryImageErr').text('Invalid image file.(Only .jpg, .png, .jpeg and .gif allowed)').css('font-weight','bold');
                                temp++;
                            }else{
                                $('#categoryImageErr').removeClass('error');
                                $('#categoryImageErr').text('');
                            }
                        }
                    }

                    if(temp == 0){
                        let url = "{{ route('updateCategory', $categories->id) }}";
                        let formData = new FormData(this);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === 'success') {
                                    // toastr.success(response.message).css('width','500px');
                                    window.location.href = response.redirect_url;
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', status, error);
                                alert('An error occurred while processing your request. Please try again.');
                            }
                        });
                    }
                });
            });
    </script>
@endsection