<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\User;
use Mpdf\Mpdf;

class OrdersController extends Controller
{
    //
    public function placeOrders(Request $request)
    {
        $userId = auth()->user()->id;
        $orders = Cart::where('user_id', $userId)->get();
        $orderNumber = Orders::generateOrderNumber();
    
        $totalAmount = 0;
        foreach ($orders as $order) {
            $totalAmount += $order->price * $order->quantity;
        }
    
        // Create the order
        $placedOrder = Orders::create([
            'user_id' => $userId,
            'order_number' => $orderNumber,
            'order_status' => 'pending',
            'total_amount' => $totalAmount,
            'ordered_on' => now()->format('Y-m-d H:i:s'),
            'order_description' => $request->input('order_description')
        ]);

        //dd($placedOrder);
    
        // Create order products and empty the cart
        foreach ($orders as $order) {
            OrderProduct::create([
                'order_id' => $placedOrder->id,
                'product_id' => $order->product_id,
                'quantity' => $order->quantity,
                'price' => $order->product->price
            ]);
        }
    
        // Empty the cart
        Cart::where('user_id', $userId)->delete();
    
        // Create order status history
        OrderStatusHistory::create([
            'order_number' => $placedOrder->order_number,
            'order_status' => $placedOrder->order_status,
            'status_updated_on' => now()->format('Y-m-d H:i:s')
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order' => $placedOrder
        ]);
    }

    public function orderDetails()
    {
        $userId = auth()->user()->id;
        $orders = Orders::where('user_id', $userId)->get();
      
        $productDetails = [];
    
        foreach($orders as $order){
            $products = OrderProduct::where('order_id', $order->id)
                ->join('products', 'order_products.product_id', '=', 'products.id')
                ->select('order_products.*', 'products.name', 'products.image')
                ->get();
    
            foreach ($products as $product) {
                $product->image_url = url('images/' . $product->image);
                $product->image_name = basename($product->image);
                unset($product->image); // Remove the image field
            }
    
            $productDetails[] = $products;
        }
    
        return response()->json([
            'status' => 'success',
            'order' => $orders,
            'productDetails' => $productDetails,
        ]);
    }

    public function showInvoice(Request $request)
    {
        $id = $request->query('id');
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
