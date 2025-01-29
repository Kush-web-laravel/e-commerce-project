<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Product;

class SubCategoryController extends Controller
{
    //
    public function index()
    {
        $subcategories = SubCategory::with('category')->get();
        return view('admin.subcategory', compact('subcategories'));
    }

    public function add(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->query('categoryId');
        $selectedCategoryId = $categoryId;
        return view('admin.subcategory.add', compact('categories', 'selectedCategoryId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
            'sub_category_description' => 'required',
            'sub_category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('sub_category_image')) {
            $image = $request->file('sub_category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();            
        }
        // Create Category
        $subCategory = Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->sub_category_name,
            'description' => $request->sub_category_description,
            'image' => $imageName,
        ]);

        $subCategoryId = $subCategory->id;
        $imagePath = public_path('images/subcategory/' . $subCategoryId);
        $image->move($imagePath, $imageName);

        $subCategory->update(['image' => 'images/subcategory/' . $subCategoryId . '/' . $imageName]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory created successfully',
            'redirect_url' => route('subcategory-view'),
        ]);

    }

    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        $categories = Category::all();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
            'sub_category_description' => 'required',
            'sub_category_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $subCategory = SubCategory::find($id);
        $imageName = $subCategory->image;
        if ($request->hasFile('sub_category_image')) {
            $image = $request->file('sub_category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/subcategory/' . $id);
        
            $existingImagePath = public_path($subCategory->image);
            if (file_exists($existingImagePath) && is_file($existingImagePath)) {
                unlink($existingImagePath);
            }

            $image->move($imagePath, $imageName);

            $imageName = 'images/subcategory/' . $id . '/' . $imageName;

        }

        $subCategory->update([
            'category_id' => $request->category_id,
            'name' => $request->sub_category_name,
            'description' => $request->sub_category_description,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory updated successfully',
            'redirect_url' => route('subcategory-view'),
        ]);
    }

    public function delete($id)
    {
        $subCategory = SubCategory::find($id);
        $imagePath = public_path($subCategory->image);

        $folderPath = public_path('images/subcategory/' . $id);
        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }
        if (file_exists($folderPath) && is_dir($folderPath)) {
            rmdir($folderPath);
        }

        $products = Product::where('sub_category_id', $id)->get();
        foreach ($products as $product) {
            // Delete product images
            $productImagePath = public_path($product->image);
            if (file_exists($productImagePath) && is_file($productImagePath)) {
                unlink($productImagePath);
            }
    
            // Delete product folder
            $productFolderPath = public_path('images/product/' . $product->id);
            if (file_exists($productFolderPath) && is_dir($productFolderPath)) {
                rmdir($productFolderPath);
            }
    
            $product->delete();
        }
        $subCategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory deleted successfully',
            'redirect_url' => route('subcategory-view'),
        ]);
    }
}
