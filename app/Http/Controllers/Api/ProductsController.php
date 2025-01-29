<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    //
    public function productList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'subcategoryId' => 'required|integer',
            'productId' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Category id, subcategory id and product id is required',
                'products' => []
            ]);
        }else{
            $id = $request->query('id');
            $subcategoryId = $request->query('subcategoryId');
            $productId = request()->query('productId');

            if($id){
                $subCategory = SubCategory::find($subcategoryId);
                if (!$subCategory) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sub Category not found',
                        'subCategory' => []
                    ]);
                }else{
                    if($subCategory->category_id != $id){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Sub Category not found in this category',
                            'subCategory' => []
                        ]);
                    }else{
                        $products = Product::find($productId);
                        if (!$products) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Product not found',
                                    'products' => []
                                ]);
                        }else{
                            if($products->sub_category_id != $subcategoryId){
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Product not found in this subcategory',
                                    'products' => []
                                ]);
                            }else{
                                if($products->deleted_at == null){
                                    $category = Category::find($id);
                                    $subCategory = SubCategory::find($subcategoryId);
                                    
                                    $products->image_url = url($products->image);
                                    $products->image = basename($products->image);
                                    return response()->json([
                                        'status' => 'success',
                                        'message' => 'Product found',
                                        'products' => $products,
                                        'subcategory' => $subCategory->name,
                                        'category' => $category->name
                                    ]);
                                }else{
                                    return response()->json([
                                        'status' => 'error',
                                        'message' => 'Product might have been deleted or not exist',
                                        'products' => []
                                    ]);
                                }
                            }
                            
                        }
                    }
                
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category id is required',
                    'products' => []
                ]);
            }
        }
        
    }

    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'productId' => 'required',
            'quantity' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Product id and quantity is required',
                'cart' => []
            ]);
        }else{
            $productId = $request->input('productId');
            $product = Product::find($productId);
            if($product){
                $userId = auth()->user()->id;
                $quantity = $request->quantity ?? 1;

                $cart = Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);

                $cart->total_amount = $product->price * $cart->quantity;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product added to cart',
                    'cart' => $cart
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product ',
                    'cart' => []
                ]);
            }
        }
        
    }   

    public function listCart()
    {
        $userId = auth()->user()->id;
        $carts = Cart::where('user_id', $userId)->get();
    
        $totalAmount = 0;
        foreach ($carts as $cart) {
            $totalAmount += $cart->price * $cart->quantity;
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Cart list',
            'carts' => $carts,
            'total_amount' => $totalAmount
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartId' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart id is required',
                'cart' => []
            ]);
        } else {
            $cartId = $request->input('cartId');
            $cart = Cart::find($cartId);
            if ($cart) {
                $cart->delete();
    
                $userId = auth()->user()->id;
                $carts = Cart::where('user_id', $userId)->get();
                $totalAmount = 0;
                foreach ($carts as $cartItem) {
                    $totalAmount += $cartItem->product->price * $cartItem->quantity;
                }
    
                $productName = Product::find($cart->product_id)->name;
                $cart->product_name = $productName;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from cart',
                    'cart' => $cart,
                    'total_amount' => $totalAmount
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found in cart',
                    'cart' => []
                ]);
            }
        }
    }
    
}