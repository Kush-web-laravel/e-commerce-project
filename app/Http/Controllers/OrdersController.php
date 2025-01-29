<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\Product;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Mpdf\Mpdf;

class OrdersController extends Controller
{
    //
    public function index()
    {
        $userId = auth()->user()->id;
        $orders = Orders::where('user_id', $userId)->get();
        //dd($orders);
        $user = auth()->user();
        return view('admin.orders', compact('orders', 'user'));
    }

    public function orderDetails($id)
    {
        $orders = Orders::where('id', $id)->first();
        $orderProducts = OrderProduct::where('order_id', $id)->get();
        $productId = OrderProduct::where('order_id', $id)->pluck('product_id');
        $productName = Product::whereIn('id', $productId)->pluck('name', 'id')->toArray();
        $productImage = Product::whereIn('id', $productId)->pluck('image', 'id')->toArray();
    
        return view('admin.orders.view', compact('orders', 'orderProducts', 'productName', 'productImage'));
    }

    public function changeOrderStatus(Request $request)
    {
        $order = Orders::where('id', $request->order_id)->first();
        $orderNumber = $order->order_number;
        $order->update([
            'order_status' => $request->order_status
        ]);

        OrderStatusHistory::create([
            'order_number' => $orderNumber,
            'order_status' => $request->order_status,
            'status_updated_on' => now()->format('Y-m-d H:i:s')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated successfully',
            'redirect_url' => route('orders-view')
        ]);
    }

    public function showInvoice(Request $request, $id)
    {
        $order = Orders::where('id', $id)->first();
        $userId = Orders::where('id', $id)->pluck('user_id');
        $user = User::where('id', $userId)->first();
        
        $invoiceNumber = Orders::generateInvoiceNumber();
        $randomData = Orders::generateRandomData();

        $order = Orders::find($order->id);
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
        $products = Product::whereIn('id', $orderProducts->pluck('product_id'))->get()->keyBy('id');
        
        $html = view('admin.orders.invoice', compact('order', 'invoiceNumber', 'randomData', 'user', 'orderProducts', 'products'))->render();
        $mpdf = new Mpdf(['format' => 'A4']);

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF as a string
        $pdfContent = $mpdf->Output('', 'S');

        return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="invoice.pdf"');
    }

}
