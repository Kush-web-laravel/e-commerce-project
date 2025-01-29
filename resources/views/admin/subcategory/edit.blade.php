@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Sub Category</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">SubCategory</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>

        <div class="content col-md-10 ml-3">
            <div class="alert alert-danger" style="display: none;">
                <span id="errorMessage"></span>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit SubCategory</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="updateSubcategoryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}" />
                    <div class="card-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <select name="category_id" id="categoryName" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <medium id="categoryNameErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="subCategoryName">Name</label>
                            <input type="text" class="form-control" id="subCategoryName" name="sub_category_name" autocomplete="off" placeholder="Enter Name" value="{{  $subcategory->name }}">
                            <medium id="subCategoryNameErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="subCategoryImage">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control" id="subCategoryImage" name="sub_category_image" accept=".jpg, .jpeg, .png, .gif" autocomplete="off">
                                    <label class="custom-file-label" for="subCategoryImage">Choose file</label>  
                                </div>
                            </div>
                            <medium id="subCategoryImageErr" class="text-danger"></medium>
                        </div>
                        @if(isset($subcategory->image))
                            <p id="subCategoryImagePreview" style="display: block; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">
                                Current Image : <img src="{{ asset($subcategory->image) }}" id="subCategoryImagePreview" width="120" />
                            </p>
                        @else
                            <p id="subCategoryImagePreview" style="display: block; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Current Image : No image found</p>
                        @endif
                        <div class="form-group">
                            <label for="subCategoryDescription">Description</label>
                            <textarea type="password" class="form-control" id="subCategoryDescription" name="sub_category_description" autocomplete="off" placeholder="Enter Description">{{ $subcategory->description }}</textarea>
                            <medium id="subCategoryDescriptionErr" class="text-danger"></medium>
                        </div>
                    </div>
                <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary mr-2" value="Submit">
                        <a href="{{ route('subcategory-view') }}" class="btn btn-default">Cancel</a>
                    </div>
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
            $('form#updateSubcategoryForm').on('submit', function(e){
                    e.preventDefault();
                    var categoryName = $('#categoryName').val();
                    var subCategoryName = $('#subCategoryName').val();
                    var subCategoryImage = $('#subCategoryImage').val();
                    var subCategoryDescription = $('#subCategoryDescription').val();
                    var temp = 0;
                    if(categoryName == ''){
                        $('#categoryNameErr').addClass('error');
                        $('#categoryNameErr').text('Category name is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#categoryNameErr').removeClass('error');
                        $('#categoryNameErr').text('');
                    }

                    if(subCategoryName == ''){
                        $('#subCategoryNameErr').addClass('error');
                        $('#subCategoryNameErr').text('SubCategory name is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#subCategoryNameErr').removeClass('error');
                        $('#subCategoryNameErr').text('');
                    }

                    if( subCategoryImage != '') {
                        if(subCategoryImage.split('.').pop().toLowerCase() == 'jpg' || subCategoryImage.split('.').pop().toLowerCase() == 'jpeg' || subCategoryImage.split('.').pop().toLowerCase() == 'png' || subCategoryImage.split('.').pop().toLowerCase() == 'gif'){
                            $('#subCategoryImageErr').removeClass('error');
                            $('#subCategoryImageErr').text('');
                        }else{
                            $('#subCategoryImageErr').addClass('error');
                            $('#subCategoryImageErr').text('Invalid image format').css('font-weight','bold');
                            temp++;
                        }
                    }

                    if(subCategoryDescription == ''){
                        $('#subCategoryDescriptionErr').addClass('error');
                        $('#subCategoryDescriptionErr').text('SubCategory description is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#subCategoryDescriptionErr').removeClass('error');
                        $('#subCategoryDescriptionErr').text('');
                    }
                    let subcategory_id = $('input[name="subcategory_id"]').val();
                    if(temp === 0){
                        alert(subcategory_id);
                        let url = "{{ route('updateSubCategory', ':id') }}".replace(':id', subcategory_id);
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
                                    window.location.href= response.redirect_url;
                                }
                            }
                        });
                    }
                });
            });
    </script>

@endsection