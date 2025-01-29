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
        $id = $request->query('id');
        $subcategoryId = $request->query('subcategoryId');
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
                    if($subCategory->deleted_at == null){
                        $subCategory->image_url = url($subCategory->image);
                        $subCategory->image = basename($subCategory->image);
        
                        $products = Product::where('sub_category_id', $subcategoryId)->count();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Category and Sub Category found',
                            'subCategory' => $subCategory,
                            'products' => 'Sub Category has '.$products.' products'
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Sub Category is deleted or not exists',
                            'subCategory' => []
                        ]);
                    }
                   
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
