@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">SubCategory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">SubCategory</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="add-subAdmin col-sm-2 float-right mr-2">
            <a href="{{ route('addSubCategory-view') }}" class="btn btn-primary btn-block"><i class="fa fa-plus mr-2"></i>Add SubCategory</a>
        </div>
    </div><!-- /.container-fluid -->
</div>

<div class="card" style="margin-top: 70px; margin-left: 15px; margin-right: 15px;">
            <div class="card-header">
                <h3 class="card-title">SubCategories List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Category Name</th>
                                    <th>SubCategory Name</th>
                                    <th>SubCategory Image</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcategories as $key => $subcategory)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $subcategory->category ? $subcategory->category->name : 'N/A' }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td><img src="{{ asset($subcategory->image) }}" width="120" /></td>
                                    <td>{{ $subcategory->description }}</td>
                                    <td>
                                        <a href="{{ route('editSubCategory', $subcategory->id) }}" class="btn btn-primary btn-sm editBtn">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="{{ $subcategory->id }}" style="display: inline-block;">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- /.card-body -->
        </div>

@endsection

@section('js')

    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
    $(function () {
        $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    </script>
    <script>
        $(document).on('click', '.deleteBtn', function() {
            var subcategoryId = $(this).data('id');
            var url = "{{ route('deleteSubCategory', ':id') }}";
            url = url.replace(':id', subcategoryId);
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this category!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(response) {
                                if(response.status === 'success'){
                                    Swal.fire(
                                    'Deleted!',
                                    'Your category has been deleted.',
                                    'success'
                                ); 
                                }else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again later.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
    </script>
   
@endsection