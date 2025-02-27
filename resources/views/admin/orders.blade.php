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
                                        <td>{{ $order->user_name}}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->order_status == 'dispatched' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>

                                        <td>{{ $order->ordered_on }}</td>
                                        <td>{{ $order->order_description }}</td>
                                        <td>
                                            <a href="{{ route('orderDetails', $order->id) }}" class="btn btn-primary viewBtn" style="font-size: 11px">View</a>
                                            <a href="javascript:void(0)" class="btn btn-success changeStatusBtn" data-id="{{ $order->id }}" data-toggle="modal" data-target="#statusModal" style="font-size: 11px">Change Status</a>
                                            <a href="{{ route('invoice', $order->id) }}" class="btn btn-dark" style="font-size: 11px">Download invoice</a>
                                            @if($order->order_status == 'delivered')
                                                <a href="javascript:void(0)" type="button" class="btn btn-warning attachFile mt-2" data-id="{{ $order->id }}" data-toggle="modal" data-target="#attachFileModal" style="font-size: 11px">Attach Delivery Slip</a>
                                            @endif
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

<div class="modal fade show" tabindex="-1" id="statusModal" aria-modal="true" role="dialog">
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
                    <input type="hidden" name="order_id" id="orderId">
                    <label for="orderNumber">Order Number</label>
                    <input type="text" name="order_number" id="orderNumber" class="form-control" disabled>
                    <div class="mt-4"></div>
                    <label for="userName">User name</label>
                    <input type="text" name="user_name" id="userName" class="form-control" disabled>
                    <div class="mt-4"></div>
                    <label for="orderDate">Order Date</label>
                    <input type="text" name="order_date" id="orderDate" class="form-control" disabled>
                    <div class="mt-4"></div>
                    <label for="orderDescription">Order Description</label>
                    <input type="text" name="order_description" id="orderDescription" class="form-control" disabled>
                    <div class="mt-4"></div>
                    <label for="orderStatus">Order Status</label>
                    <select class="form-control" id="orderStatus" name="order_status">
                        <option value="pending">Pending</option>
                        <option value="accepted">Accept</option>
                        <option value="order_rejected">Reject</option>
                        <option value="dispatched">Dispatch</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
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


<div class="modal fade" id="attachFileModal" tabindex="-1" role="dialog" aria-labelledby="attachFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachFileModalLabel">Attach Delivery Slip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="attachDeliverySlipForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" id="modalOrderId" value="">
                    <div class="form-group">
                        <label for="deliverySlip">Upload Delivery Slip</label>
                        <input type="file" class="form-control" id="deliverySlip" name="delivery_slip" accept="image/jpeg, image/png, image/jpg"required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDeliverySlip">Save</button>
            </div>
        </div>
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
        $('.changeStatusBtn').click(function(){
            var orderId = $(this).data('id');
            var url = "{{ route('detailsForStatusModal', ':id') }}".replace(':id', orderId);
            if($('#orderStatus').val() == 'rejected'){
                        alert($('#orderStatus').val());
                    }
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#orderId').val(response.order.id);
                    $('#orderNumber').val(response.order.order_number);
                    $('#userName').val(response.user.name);
                    $('#orderDate').val(response.order.ordered_on);
                    $('#orderDescription').val(response.order.order_description);
                    $('#orderStatus').val(response.order.order_status);
                }
            });
        });


        $('.changeStatusButton').click(function(){
            var orderId = $('#orderId').val();
            console.log(orderId);
            var orderStatus = $('#orderStatus').val();

            var form = $('#changeOrderStatusForm').get(0);
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: "{{ route('changeOrderStatus', ':id') }}".replace(':id', orderId),
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

        $('.attachFile').click(function(){
            var orderId = $(this).data('id');
            $('#modalOrderId').val(orderId);
        });

        $('#saveDeliverySlip').click(function(){
            var url = "{{ route('attachSlip') }}";
            var formData = new FormData($('#attachDeliverySlipForm')[0]);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == 'success'){
                        window.location.href=response.redirect_url;
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });



    </script>
@endsection