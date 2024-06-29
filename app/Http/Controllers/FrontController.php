<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function buildMenu()
    {
        $brands = Brand::all();
        $categories = Category::with('products')->get();

        return response([
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

    public function home()
    {
        $brands = Brand::where('is_featured', 1)->select('id', 'name')->get();
        $categories = Category::where('is_featured', 1)->select('id', 'name')->get();
        $products = Product::with(['skus:id,name,price,product_id', 'skus.images:id,url,sku_id'])
            ->where('is_featured', 1)->select('id', 'name', 'slug')->get();

        return response([
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function productAssessories()
    {
        $brands = Brand::all();
        $categories = Category::with('products')->get();

        return response([
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

    public function products(Request $request)
    {
        $products = Product::with('skus.images');

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $products->where('brand_id', $request->brand_id);
        }

        if ($request->filled('value_type') && $request->filled('price')) {
            $products->whereHas('skus', function ($query) use ($request) {
                $query->where('price', $request->value_type, $request->get('price'));
            });
        }

        $products = $products->paginate(12);

        return response()->json($products);
    }

    public function product(Product $product)
    {
        return response()->json($product->load('skus.images'));
    }

}
