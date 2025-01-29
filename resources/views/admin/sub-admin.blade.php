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
    <div class="add-subAdmin col-sm-2 float-right mr-2">
      <a href="{{ route('addSubAdmin-view') }}" class="btn btn-primary btn-block"><i class="fa fa-plus mr-2"></i>Add Sub Admin</a>
    </div>
  </div><!-- /.container-fluid -->
  <div class="card" style="margin-top: 70px; margin-left: 15px; margin-right: 15px;">
    <div class="card-header">
      <h3 class="card-title">DataTable with default features</h3>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($subadmins as $index => $subadmin)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subadmin->name }}</td>
                    <td>{{ $subadmin->email }}</td>
                    <td>
                      <a href="{{ route('editSubAdmin', $subadmin->id) }}" class="btn btn-primary btn-sm">Edit</a>
                      <form action="{{ route('deleteSubAdmin', $subadmin->id) }}" id="deleteSubAdmin" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                      </form>
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
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

  $('#deleteSubAdmin').on('submit', function(e){
    e.preventDefault();
    var form = this;

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, submit the form via AJAX
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the sub admin.',
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the sub admin.',
                        'error'
                    );
                }
            });
        }
    });
  });
</script>
@endsection