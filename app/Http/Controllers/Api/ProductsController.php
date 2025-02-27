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
            'categoryId' => 'required|integer',
            'subcategoryId' => 'required|integer',
        ]);

        $id = $request->query('categoryId');
        //dd( $id);
        $subcategoryId = $request->query('subcategoryId');

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Category id, subcategory id is required',
                'products' => []
            ]);
        }else{
            
            if($id){
                $category = Category::where('id', $id)->first();
                $subCategory = SubCategory::where('category_id', $id)->get();
                if (!$subCategory) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sub Category not found',
                        'subCategory' => []
                    ]);
                }else{
                    foreach( $subCategory as $subCat){
                        $products = Product::where('sub_category_id', $subcategoryId)->get();
                        if (!$products) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Product not found',
                                'products' => []
                            ]);
                        }else{
                            foreach( $products as $product){
                                if($product->deleted_at == null){
                                    $product->image_url = url($product->image);
                                    $product->image = basename($product->image);
                                }else{
                                    return response()->json([
                                        'status' => 'error',
                                        'message' => 'Product might have been deleted or not exist',
                                        'products' => []
                                    ]);
                                }
                            }
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Product found',
                                'products' => $products,
                                'subcategory' => $subCat->name,
                                'category' => $category->name
                            ]);
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