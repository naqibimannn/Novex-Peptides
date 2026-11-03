<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PageRouterController extends Controller
{

    public function handle(Request $request, $slug = null)
    {
        $path = $slug ?? $request->path();
        $path = trim($path, '/');

        if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'api/')) {
            abort(404);
        }

        $product = DB::select("SELECT * FROM products WHERE slug = ? LIMIT 1", [$path]);
        if (!empty($product)) {
            $productData = $product[0];
            
            return view('frontend.product-detail', [
                'product' => $productData,
            ]);
        }

        $validPageTypes = ['products', 'skin', 'accessory', 'premium', 'performance'];
        if (in_array(strtolower($path), $validPageTypes)) {
            $catalogProducts = DB::select(
                "SELECT * FROM products WHERE LOWER(page_type) = ? OR LOWER(category) = ? ORDER BY id DESC", 
                [strtolower($path), strtolower($path)]
            );

            return view('frontend.catalog', [
                'currentPageType' => strtolower($path),
                'products'        => $catalogProducts,
            ]);
        }

        $cleanViewName = str_replace('/', '.', $path);
        
        // Semak di resources/views/frontend/pages/{path}.blade.php
        if (View::exists("frontend.pages.{$cleanViewName}")) {
            return view("frontend.pages.{$cleanViewName}");
        }

        if (View::exists("pages.{$cleanViewName}")) {
            return view("pages.{$cleanViewName}");
        }

        if (View::exists($cleanViewName)) {
            return view($cleanViewName);
        }

        abort(404);
    }
}