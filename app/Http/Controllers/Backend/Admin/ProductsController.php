<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        $products = DB::select("SELECT * FROM products ORDER BY id DESC");
        $secret = config('admin.secret_key') ?: env('ADMIN_SECRET_KEY');

        return view('backend.admin.dashboard.admin', [
            'section'  => 'products',
            'secret'   => $secret,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'price'          => 'required|string|max:100',
            'dosage_spec'    => 'nullable|string|max:100',
            'badge_category' => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpeg,png,webp,jpg|max:3072',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (!empty(DB::select("SELECT id FROM products WHERE slug = ? LIMIT 1", [$slug]))) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        DB::insert(
            "INSERT INTO products (title, slug, price, dosage_spec, badge_category, image, created_at, updated_at) 
             VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $validated['title'],
                $slug,
                $validated['price'],
                $validated['dosage_spec'] ?? null,
                $validated['badge_category'] ?? null,
                $imagePath,
            ]
        );

        return back()->with('success', 'Produk berjaya ditambah ke katalog.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'price'          => 'required|string|max:100',
            'dosage_spec'    => 'nullable|string|max:100',
            'badge_category' => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpeg,png,webp,jpg|max:3072',
        ]);

        $current = DB::select("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
        if (empty($current)) {
            return back()->withErrors(['msg' => 'Produk tidak dijumpai.']);
        }
        $product = $current[0];

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        DB::update(
            "UPDATE products 
             SET title = ?, price = ?, dosage_spec = ?, badge_category = ?, image = ?, updated_at = NOW() 
             WHERE id = ?",
            [
                $validated['title'],
                $validated['price'],
                $validated['dosage_spec'] ?? null,
                $validated['badge_category'] ?? null,
                $imagePath,
                $id,
            ]
        );

        return back()->with('success', 'Maklumat produk berjaya dikemaskini.');
    }

    public function destroy($id)
    {
        $product = DB::select("SELECT image FROM products WHERE id = ? LIMIT 1", [$id]);

        if (!empty($product)) {
            if ($product[0]->image && file_exists(public_path($product[0]->image))) {
                @unlink(public_path($product[0]->image));
            }

            DB::delete("DELETE FROM products WHERE id = ?", [$id]);
            return back()->with('success', 'Produk berjaya dipadam dari sistem.');
        }

        return back()->withErrors(['msg' => 'Produk tidak dijumpai.']);
    }
}