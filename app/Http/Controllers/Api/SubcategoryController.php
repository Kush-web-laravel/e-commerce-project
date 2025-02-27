<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;

class SubcategoryController extends Controller
{
    //
    public function subCategoryList(Request $request)
    {
        $id = $request->query('categoryId');
        if($id){
            $subCategories = SubCategory::where('category_id', $id)->get();

            if (!$subCategories) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sub Category not found',
                    'subCategory' => []
                ]);
            }else{
                foreach( $subCategories as $subCategory){
                    $subCategory->image_url = url($subCategory->image);
                    $subCategory->image = basename($subCategory->image);

                    $products = Product::where('sub_category_id', $subCategory->id)->count();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Category and Sub Category found',
                        'subCategory' => $subCategories,
                        'products' => 'Sub Category has '.$products.' products'
                    ]);
                   
                }
                
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Category id is required',
                'subCategory' => []
            ]);
        }
    }
}
