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
        $category = Category::all();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
                'category' => []
            ]);
        }else{
            foreach ($category as $cat) {
                $cat->image_url = url($cat->image);
                $cat->image = basename($cat->image);

                $subcategories = SubCategory::where('category_id', $cat->id)->count();
                $products = Product::where('category_id', $cat->id)->count();
            }

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
