<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = [];
        if (Schema::hasTable('products')) {
            $products = DB::table('products')
                ->select('id', 'title', 'slug', 'updated_at', 'created_at')
                ->latest('updated_at')
                ->get();
        }

        $articles = [];
        if (Schema::hasTable('resources')) {
            $articles = DB::table('resources')
                ->select('id', 'title', 'slug', 'updated_at', 'created_at')
                ->latest('updated_at')
                ->get();
        }

        $xml = view('sitemap', [
            'products' => $products,
            'articles' => $articles
        ])->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}