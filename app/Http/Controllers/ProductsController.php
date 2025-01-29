<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $products = Product::with('category', 'subCategory')->get();
        return view('admin.products', compact('products'));
    }

    public function add(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->query('categoryId');
        $selectedCategoryId = $categoryId;

        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        $selectedSubCategoryId = $request->query('subCategoryId');

        return view('admin.products.add', compact('categories', 'selectedCategoryId', 'subcategories', 'selectedSubCategoryId'));
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('product_image')){
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
        }

        $product = Product::create([
            'name' => $request->product_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'price' => $request->product_price,
            'description' => $request->product_description,
            'image' => $imageName,
        ]);

        $imagePath = public_path('images/products'. '/'. $product->id);
        $image->move($imagePath, $imageName);

        $product->update(['image' => 'images/products/' . $product->id . '/' . $imageName]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'redirect_url' => route('product-view'),
        ]);
       
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
        ]);

        $product = Product::find($id);

        $imageName = $product->image;
        if($request->hasFile('product_image')){
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/products/' . $id);

            $existingImagePath = public_path($product->image);
            if(file_exists($existingImagePath) && is_file($existingImagePath)){
                unlink($existingImagePath);
            }
            
            $image->move($imagePath, $imageName);
            $imageName = 'images/products/' . $id . '/' . $imageName;
        }

        $product->update([
            'name' => $request->product_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'price' => $request->product_price,
            'description' => $request->product_description,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'redirect_url' => route('product-view'),
        ]);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $existingImagePath = public_path($product->image);
        $folderPath = public_path('images/products/' . $id);
        if(file_exists($existingImagePath) && is_file($existingImagePath)){
            unlink($existingImagePath);
        }
        if(file_exists($folderPath) && is_dir($folderPath)){
            rmdir($folderPath);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'redirect_url' => route('product-view'),
        ]);
    }
}
