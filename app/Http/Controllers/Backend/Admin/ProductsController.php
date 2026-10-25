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
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,webp,jpg|max:3072',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (!empty(DB::select("SELECT id FROM products WHERE slug = ? LIMIT 1", [$slug]))) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $imagePaths[] = 'uploads/products/' . $filename;
            }
        }

        $finalImageJson = !empty($imagePaths) ? json_encode($imagePaths) : null;

        DB::insert(
            "INSERT INTO products (title, slug, price, dosage_spec, badge_category, image, created_at, updated_at) 
             VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $validated['title'],
                $slug,
                $validated['price'],
                $validated['dosage_spec'] ?? null,
                $validated['badge_category'] ?? null,
                $finalImageJson,
            ]
        );

        return back()->with('success', 'Product formulation successfully published.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'price'          => 'required|string|max:100',
            'dosage_spec'    => 'nullable|string|max:100',
            'badge_category' => 'nullable|string|max:100',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,webp,jpg|max:3072',
            'image_mode'     => 'nullable|in:replace,append',
        ]);

        $current = DB::select("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
        if (empty($current)) {
            return back()->withErrors(['msg' => 'Product formulation not found.']);
        }
        $product = $current[0];

        $existingImages = [];
        if (!empty($product->image)) {
            $decoded = json_decode($product->image, true);
            $existingImages = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                ? $decoded 
                : [$product->image];
        }

        $mode = $request->input('image_mode', 'replace');
        $finalImageList = $existingImages;

        if ($request->hasFile('images')) {
            $newUploadedPaths = [];
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $newUploadedPaths[] = 'uploads/products/' . $filename;
            }

            if ($mode === 'append') {
                $finalImageList = array_merge($existingImages, $newUploadedPaths);
            } else {
                foreach ($existingImages as $oldFile) {
                    if ($oldFile && file_exists(public_path($oldFile))) {
                        @unlink(public_path($oldFile));
                    }
                }
                $finalImageList = $newUploadedPaths;
            }
        }

        $imagePathJson = !empty($finalImageList) ? json_encode($finalImageList) : null;

        DB::update(
            "UPDATE products 
             SET title = ?, price = ?, dosage_spec = ?, badge_category = ?, image = ?, updated_at = NOW() 
             WHERE id = ?",
            [
                $validated['title'],
                $validated['price'],
                $validated['dosage_spec'] ?? null,
                $validated['badge_category'] ?? null,
                $imagePathJson,
                $id,
            ]
        );

        return back()->with('success', 'Product formulation successfully updated.');
    }

    public function destroy($id)
    {
        $product = DB::select("SELECT image FROM products WHERE id = ? LIMIT 1", [$id]);

        if (!empty($product)) {
            if (!empty($product[0]->image)) {
                $decoded = json_decode($product[0]->image, true);
                $files = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                    ? $decoded 
                    : [$product[0]->image];

                foreach ($files as $filePath) {
                    if ($filePath && file_exists(public_path($filePath))) {
                        @unlink(public_path($filePath));
                    }
                }
            }

            DB::delete("DELETE FROM products WHERE id = ?", [$id]);
            return back()->with('success', 'Product successfully removed from database.');
        }

        return back()->withErrors(['msg' => 'Product not found.']);
    }
}