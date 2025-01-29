<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\OrderStatusHistory;
use App\Models\Product;

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
        $order = Orders::where('user_id', $userId)->first();
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
        //dd($orderProducts);
        $productId = OrderProduct::where('order_id', $order->id)->pluck('product_id');
        $productNames = Product::whereIn('id', $productId)->pluck('name', 'id')->toArray();
    
        // Collect product prices and quantities
        $productPrices = [];
        $productQuantities = [];
        foreach ($orderProducts as $orderProduct) {
            $productPrices[$orderProduct->product_id] = $orderProduct->price;
            $productQuantities[$orderProduct->product_id] = $orderProduct->quantity;
        }
    
        $productDetails = [
            'productNames' => $productNames,
            'productPrices' => $productPrices,
            'productQuantities' => $productQuantities
        ];
    
        return response()->json([
            'status' => 'success',
            'order' => $order,
            'productDetails' => $productDetails
        ]);
    }

    public function showInvoice(Request $request)
    {
        $order = Orders::all();
        return view('admin.orders.invoice', compact('order'));
    }


    
}
