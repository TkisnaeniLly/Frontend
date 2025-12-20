<?php

namespace App\Http\Controllers;

use App\Services\ProductApiService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductApiService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $rawProducts = collect($this->productService->getAllProducts());
        
        // Extract unique categories for filter dropdown (from raw data)
        $categories = $rawProducts
            ->pluck('Category.category_name')
            ->unique()
            ->values()
            ->all();

        // Filter by Search Query
        if ($request->has('q') && $request->q != '') {
            $query = strtolower($request->q);
            $rawProducts = $rawProducts->filter(function ($item) use ($query) {
                return str_contains(strtolower($item['product_name']), $query) 
                    || str_contains(strtolower($item['description']), $query);
            });
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $category = $request->category;
            $rawProducts = $rawProducts->filter(function ($item) use ($category) {
                return isset($item['Category']['category_name']) 
                    && strtolower($item['Category']['category_name']) === strtolower($category);
            });
        }

        // Transform data
        $transformedProducts = $rawProducts->map(function ($product) {
            $price = isset($product['Variants'][0]) ? floatval($product['Variants'][0]['price']) : 0;
            $image = isset($product['Media'][0]) ? $product['Media'][0]['media_url'] : null; // View handles null with fallback/helper
            
            return [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'category' => isset($product['Category']['category_name']) ? $product['Category']['category_name'] : 'Other',
                'brand' => $product['Brand']['brand_name'] ?? '',
                'price' => $price,
                'badge' => $this->getBadge($product),
                'image' => $image,
                'slug' => $product['slug'] ?? ''
            ];
        })->values()->all();

        return view('pages.products', [
            'products' => $transformedProducts,
            'categories' => $categories
        ]);
    }

    private function getBadge($product)
    {
        if (isset($product['created_at'])) {
            $createdAt = strtotime($product['created_at']);
            $daysSinceCreated = (time() - $createdAt) / (60 * 60 * 24);
            if ($daysSinceCreated <= 30) return 'New';
        }
        if (isset($product['Variants']) && count($product['Variants']) > 5) return 'Popular';
        return null;
    }

    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Pass product data to view
        return view('pages.detailproduk', compact('product'));
    }
}
