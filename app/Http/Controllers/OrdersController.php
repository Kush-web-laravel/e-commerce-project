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
        $orders = Orders::join('users', 'orders.user_id', '=', 'users.id')
                        ->select('orders.*', 'users.name as user_name')
                        ->get();
        return view('admin.orders', compact('orders'));
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

    public function changeOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,accepted,order_rejected,dispatched,delivered,cancelled',
        ]);
        $order = Orders::where('id', $id)->first();
        //dd($id,$order);
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

    public function detailsForStatusModal($id)
    {
        $order = Orders::find($id);
        $user = User::find($order->user_id);

        return response()->json([
            'order' => $order,
            'user' => $user,
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
    public function attachDeliverySlip(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_slip' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $order = Orders::find($request->input('order_id'));
    
        if ($request->hasFile('delivery_slip')) {
            $slip = $request->file('delivery_slip');
            $slipName = time() . '.' . $slip->getClientOriginalExtension();
            $slipPath = public_path('images/orders/delivery_slip/' . $order->id);
    
            $slip->move($slipPath, $slipName);
    
            // Update the order with the delivery slip path
            $order->update(['delivery_slip' => 'images/orders/delivery_slip/' . $order->id . '/' . $slipName]);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Delivery slip attached successfully',
            'redirect_url' => route('orders-view')
        ]);
    }
    

}
