<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
        return view('admin.category' , compact('categories'));
    }

    public function add()
    {
        return view('admin.category.add');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();            
        }
        // Create Category
        $category = Category::create([
            'name' => $request->category_name,
            'image' => $imageName,
        ]);

        $categoryId = $category->id;
        $imagePath = public_path('images/category/' . $categoryId);
        $image->move($imagePath, $imageName);

        $category->update(['image' => 'images/category/' . $categoryId . '/' . $imageName]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'redirect_url' => route('category-view'),
        ]);
    }


    public function edit($id)
    {
        $categories = Category::findOrFail($id);

        return view('admin.category.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Initialize the image name with the existing image
        $imageName = $category->image;

        // Check if a new image is uploaded
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/category/' . $category->id);

            // Delete the existing image if it exists
            $existingImagePath = public_path($category->image);
            if (file_exists($existingImagePath) && is_file($existingImagePath)) {
                unlink($existingImagePath);
            }

            // Move the new image to the specified directory
            $image->move($imagePath, $imageName);

            // Update the image path
            $imageName = 'images/category/' . $category->id . '/' . $imageName;
        }

        // Update the category
        $category->update([
            'name' => $request->category_name,
            'image' => $imageName,
        ]);

        // Redirect back with a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully!',
            'redirect_url' => route('category-view')
        ]);
    }


    public function delete($id)
    {
        $category = Category::find($id);
        if($category){
            $imagePath = public_path($category->image);

            $folderPath = public_path('images/category/' . $category->id);
    
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($folderPath) && is_dir($folderPath)) {
                rmdir($folderPath);
            }
    
            $subcategories = SubCategory::where('category_id', $id)->get();
            
            $products = Product::whereIn('sub_category_id', $subcategories->pluck('id'))->get();
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

            foreach ($subcategories as $subcategory) {
                // Delete subcategory images
                $subcategoryImagePath = public_path($subcategory->image);
                if (file_exists($subcategoryImagePath) && is_file($subcategoryImagePath)) {
                    unlink($subcategoryImagePath);
                }
    
                // Delete subcategory folder
                $subcategoryFolderPath = public_path('images/subcategory/' . $subcategory->id);
                if (file_exists($subcategoryFolderPath) && is_dir($subcategoryFolderPath)) {
                    rmdir($subcategoryFolderPath);
                }

                $subcategory->delete();
            }
            // Delete the category
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully!',
                'redirect_url' => route('category-view')
            ]);
        }
    }
                
}
