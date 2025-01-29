<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- Link to External CSS -->
    <link href="{{ asset('css/bill.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- Invoice Header -->
        <div class="invoice-title">
            <h2 class="mb-1 text-muted">E2Z.in</h2>
            <h4 class="float-end font-size-15">Invoice Number :  {{ $invoiceNumber }}</h4>
            <p class="text-muted mb-1">{{ $randomData['address'] }}</p>
            <p class="text-muted mb-1">
                <i class="uil uil-envelope-alt me-1"></i> {{ $randomData['email'] }}
            </p>
            <p class="text-muted">
                <i class="uil uil-phone me-1"></i> {{ $randomData['phone_number'] }}
            </p>
        </div>

        <!-- Spacer -->
        <hr>

        <!-- Customer Details -->
        <h4 class="float-end font-size-15" style="text-align: right">Order Number :  {{ $order->order_number }}</h4>
        <div>
            <h5 class="text-muted">Customer Details:</h5>
            <p class="text-muted mb-0">Name: {{ $user->name }}</p>
            <p class="text-muted mb-0">Email: {{ $user->email }}</p>
            <p class="text-muted mb-0">Address: {{ $user->address }}</p>
            <p class="text-muted">Phone: {{ $user->mobile_number }}</p>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;">No.</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end" style="width: 120px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($orderProducts as $orderProduct)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>
                            <h5 class="text-truncate font-size-14 mb-1">
                                {{ $products[$orderProduct->product_id]->name }}
                            </h5>
                            <p class="text-muted mb-0">
                                {{ $products[$orderProduct->product_id]->description }}
                            </p>
                        </td>
                        <td>{{ number_format($orderProduct->price, 2) }}</td>
                        <td>{{ $orderProduct->quantity }}</td>
                        <td class="text-end">
                            {{ number_format($orderProduct->price * $orderProduct->quantity, 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th scope="row" colspan="4" class="text-end">Total</th>
                        <td class="text-end">{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business! | Powered by E2Z.in</p>
        </div>
    </div>
</body>

</html>
