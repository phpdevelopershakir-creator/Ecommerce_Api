<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Social;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function latetstProducts()
    {
        $products = Product::with('product_sizes.size', 'product_colors.color')->orderBy('created_at', 'DESC')
            ->where('status', 1)
            ->limit(8)
            ->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }

    public function featuredProducts()
    {
        $products = Product::with('product_sizes.size', 'product_colors.color')->orderBy('created_at', 'DESC')
            ->where('status', 1)
            ->where('is_featured', 'yes')
            ->limit(8)
            ->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }

    public function getCategories()
    {
        $categories = Category::orderBy('created_at', 'ASC')
            ->where('status', 1)
            ->limit(8)
            ->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }

    public function getByCategory($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        return response()->json([
            'status' => 200,
            'data' => $subcategories
        ]);
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('created_at', 'ASC')
            ->where('status', 1)
            ->limit(8)
            ->get();
        return response()->json([
            'status' => 200,
            'data' => $brands
        ]);
    }

    public function getProducts(Request $request)
    {
        $products = Product::with('product_sizes.size', 'product_colors.color')->orderBy('created_at', 'DESC')
            ->where('status', 1);

        //filter products by category
        if (!empty($request->category)) {
            $catArray = explode(',', $request->category);
            $products = $products->whereIn('category_id', $catArray);
        }

        if (!empty($request->subcategory)) {
            $SubcatArray = explode(',', $request->subcategory);
            $products = $products->whereIn('subcategory_id', $SubcatArray);
        }
        if (!empty($request->brand)) {
            $brandArray = explode(',', $request->brand);
            $products = $products->whereIn('brand_id', $brandArray);
        }


        $products = $products->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::with('product_images', 'product_sizes.size', 'product_colors.color')->find($id);
        if ($product == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $product
        ], 200);
    }

    public function HomegetCategories()
    {
        $home_categories = Category::with([
            'products.product_sizes.size',
            'products.product_colors.color'
        ])
            ->where('home_category', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'ASC')
            ->limit(8)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $home_categories
        ]);
    }

    public function getSocials()
    {
        $socials = Social::orderBy('created_at', 'ASC')->get();

        return response()->json([
            'status' => 200,
            'data' => $socials
        ]);
    }

    public function getSliders()
    {
        $sliders = Slider::orderBy('created_at', 'ASC')->get();
        return response()->json([
            'status' => 200,
            'data' => $sliders
        ]);
    }
}
