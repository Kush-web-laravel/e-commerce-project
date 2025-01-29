@extends('layouts.app')
@section('content')

        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Products</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Products</li>
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
                    <h3 class="card-title">Add Products</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <select name="category_id" id="categoryName" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <medium id="categoryNameErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="subCategoryName">Subcategory Name</label>
                            <select name="sub_category_id" id="subCategoryName" class="form-control">
                                <option value="">Select Subcategory</option>
                                
                            </select>
                            <medium id="subCategoryNameErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="productName">Name</label>
                            <input type="text" class="form-control" id="productName" name="product_name" autocomplete="off" placeholder="Enter Name">
                            <medium id="productNameErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Price</label>
                            <input type="number" class="form-control" id="productPrice" name="product_price" autocomplete="off" placeholder="Enter Price">
                            <medium id="productPriceErr" class="text-danger"></medium>  
                        </div>
                        <div class="form-group">
                            <label for="productImage">Image</label>
                            <div class="input-group">
                            <div class="custom-file">
                            <input type="file" class="form-control" id="productImage" name="product_image" accept=".jpg, .jpeg, .png, .gif" autocomplete="off">
                                <label class="custom-file-label" for="productImage">Choose file</label>
                            </div>
                            </div>
                            <medium id="productImageErr" class="text-danger"></medium>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Description</label>
                            <textarea type="password" class="form-control" id="productDescription" name="product_description" autocomplete="off" placeholder="Enter Description"></textarea>
                            <medium id="productDescriptionErr" class="text-danger"></medium>
                        </div>
                    </div>
                <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary mr-2" value="Submit">
                        <a href="{{ route('product-view') }}" class="btn btn-default">Cancel</a>
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
            $('form#productForm').on('submit', function(e){
                    e.preventDefault();
                    var categoryName = $('#categoryName').val();
                    var subCategoryName = $('#subCategoryName').val();
                    var productName = $('#productName').val();
                    var productPrice = $('#productPrice').val();
                    var productImage = $('#productImage').val();
                    var productDescription = $('#productDescription').val();
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

                    if(productName == ''){
                        $('#productNameErr').addClass('error');
                        $('#productNameErr').text('Product name is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#productNameErr').removeClass('error');
                        $('#productNameErr').text('');
                    }

                    if(productImage == ''){
                        $('#productImageErr').addClass('error');
                        $('#productImageErr').text('Product image is required').css('font-weight','bold');
                        temp++;
                    }else{
                        if(productImage.split('.').pop().toLowerCase() == 'jpg' || productImage.split('.').pop().toLowerCase() == 'jpeg' || productImage.split('.').pop().toLowerCase() == 'png' || productImage.split('.').pop().toLowerCase() == 'gif'){
                            $('#productImageErr').removeClass('error');
                            $('#productImageErr').text('');
                        }else{
                            $('#productImageErr').addClass('error');
                            $('#productImageErr').text('Invalid image format').css('font-weight','bold');
                            temp++;
                        }
                    }

                    if(productPrice == ''){
                        $('#productPriceErr').addClass('error');
                        $('#productPriceErr').text('Product price is required').css('font-weight','bold');
                        temp++;
                    }else if(productPrice < 0){
                        $('#productPriceErr').addClass('error');
                        $('#productPriceErr').text('Product price must be greater than 0').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#productPriceErr').removeClass('error');
                        $('#productPriceErr').text('');
                    }

                    if(productDescription == ''){
                        $('#productDescriptionErr').addClass('error');
                        $('#productDescriptionErr').text('Product description is required').css('font-weight','bold');
                        temp++;
                    }else{
                        $('#productDescriptionErr').removeClass('error');
                        $('#productDescriptionErr').text('');
                    }
                
                    if(temp == 0){
                        let url = "{{ route('addProduct') }}";
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
                $('#categoryName').change(function() {
                    var categoryId = $(this).val();
                    var url = "{{ route('getSubcategories', ':id') }}". replace(':id', categoryId);
                    if (categoryId) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(data) {
                                $('#subCategoryName').empty();
                                $('#subCategoryName').append('<option value="">Select Subcategory</option>');
                                $.each(data, function(key, value) {
                                    $('#subCategoryName').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#subCategoryName').empty();
                        $('#subCategoryName').append('<option value="">Select Subcategory</option>');
                    }
                });
            });
    </script>

@endsection