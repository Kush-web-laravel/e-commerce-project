@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard-view') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="card" style="margin-top: 70px; margin-left: 15px; margin-right: 15px;">
            <div class="card-header">
                <h3 class="card-title">Orders List</h3>
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
                                    <th>Order Number</th>
                                    <th>User Name</th>
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php $index = 1; @endphp
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->order_status == 'dipatched' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>

                                        <td>{{ $order->ordered_on }}</td>
                                        <td>{{ $order->order_description }}</td>
                                        <td>
                                            <a href="{{ route('orderDetails', $order->id) }}" class="btn btn-primary viewBtn">View</a>
                                            <button class="btn btn-success changeStatusBtn" data-toggle="modal" data-target="#statusModal">Change Status</button>
                                            <a href="{{ route('invoice', $order->id) }}" class="btn btn-dark">Download invoice</a>
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

<div class="modal fade show" tabindex = "-1"  id="statusModal" aria-modal="true" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Change Order Status Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="changeOrderStatusForm" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="orderId" value="{{ $order->id }}">
                    <label for="orderNumber">Order Number</label>
                    <input type="text" name="order_number" id="orderNumber" class="form-control" value=" {{ $order->order_number }}" disabled>
                    <div class="mt-4"></div>
                    <label for="userName">User name</label>
                    <input type="text" name="user_name" id="userName" class="form-control" value=" {{ $user->name }}" disabled>
                    <div class="mt-4"></div>
                    <label for="orderDate">Order Date</label>
                    <input type="text" name="order_date" id="orderDate" class="form-control" value=" {{ $order->ordered_on }}" disabled>
                    <div class="mt-4"></div>
                    <label for="orderDescription">Order Description</label>
                    <input type="text" name="order_description" id="orderDescription" class="form-control" value=" {{ $order->order_description }}" disabled>
                    <div class="mt-4"></div>
                    <label for="orderStatus">Order Status</label>
                    <select class="form-control" id="orderStatus" name="order_status">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $order->order_status == 'accepted' ? 'selected' : '' }}>Accept</option>
                        <option value="rejected" {{ $order->order_status == 'rejected' ? 'selected' : '' }}>Reject</option>
                        <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>Dispatch</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary changeStatusButton">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
        $('.changeStatusButton').click(function(){
            var orderId = $('#orderId').val();
            var orderStatus = $('#orderStatus').val();

            var form = $('#changeOrderStatusForm').get(0);
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: "{{ route('changeOrderStatus') }}",
                data: formData,
                data: formData,
                processData: false,
                contentType: false, 
                success: function(response){
                    if(response.status === 'success'){
                        window.location.href = response.redirect_url;
                    }else{
                        Swal.fire(
                            'Error!',
                            'Failed to change order status.',
                            'error'
                        );
                    }
                }
            });
        });
    </script>
@endsection