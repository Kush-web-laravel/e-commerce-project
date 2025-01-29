<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class CategoryController extends Controller
{
    //
    public function categoryList(Request $request)
    {
        $id = $request->query('id');
        // Fetch the category with subcategories
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
                'category' => []
            ]);
        }else{
            $category->image_url = url($category->image);
            $category->image = basename($category->image);

            $subcategories = SubCategory::where('category_id', $id)->count();
            $products = Product::where('category_id', $id)->count();
            return response()->json([
                'status' => 'success',
                'message' => 'Category and Sub Category found',
                'category' => $category,
                'subcategories' => 'Category has '.$subcategories.' subcategories',
                'products' => 'Category has '.$products.' products'
            ]);
        }
      
    }

}
