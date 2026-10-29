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

    private function extractNumericPrice($priceString, $explicitVal = null)
    {
        if ($explicitVal !== null && $explicitVal !== '' && is_numeric($explicitVal) && (float)$explicitVal > 0) {
            return (float)$explicitVal;
        }
        if (preg_match('/([0-9]+(?:\.[0-9]+)?)/', $priceString, $matches)) {
            return (float)$matches[1];
        }
        return 0.00;
    }

    private function processVariants(Request $request)
    {
        $hasVariants = $request->boolean('has_variants') ? 1 : 0;
        if (!$hasVariants) {
            return [0, null, null];
        }

        $variantTitle = $request->input('variant_title') ?: 'Select Vial Concentration / Dosage:';
        $labels = $request->input('variant_label', []);
        $prices = $request->input('variant_price', []);
        $vals   = $request->input('variant_val', []);
        $stocks = $request->input('variant_stock', []);

        $variantsArray = [];
        foreach ($labels as $idx => $label) {
            $cleanLabel = trim($label ?? '');
            if ($cleanLabel === '') continue;

            $rawPrice = trim($prices[$idx] ?? '');
            $numVal = isset($vals[$idx]) && $vals[$idx] !== ''
                ? (float)$vals[$idx]
                : $this->extractNumericPrice($rawPrice);

            if ($rawPrice === '' && $numVal > 0) {
                $rawPrice = 'RM' . number_format($numVal, 2);
            }

            $vStock = isset($stocks[$idx]) && is_numeric($stocks[$idx]) ? (int)$stocks[$idx] : 0;

            $variantsArray[] = [
                'label' => $cleanLabel,
                'val'   => $numVal,
                'price' => $rawPrice,
                'stock' => $vStock,
            ];
        }

        if (empty($variantsArray)) {
            return [0, null, null];
        }

        return [1, $variantTitle, json_encode($variantsArray)];
    }

    private function processSizes(Request $request, $variantsJson)
    {
        $extractedSizes = [];
        if ($variantsJson) {
            $decodedVars = json_decode($variantsJson, true);
            if (is_array($decodedVars)) {
                foreach ($decodedVars as $v) {
                    $lbl = trim($v['label'] ?? '');
                    if (preg_match('/^(xs|s|m|l|xl|xxl|2xl|3xl|4xl|free size|size\s*[a-z0-9]+)$/i', $lbl)) {
                        $extractedSizes[] = strtoupper($lbl);
                    }
                }
            }
        }

        $rawSizes = trim($request->input('sizes', ''));
        if ($rawSizes !== '') {
            $parts = array_values(array_filter(array_map('trim', explode(',', $rawSizes))));
            $extractedSizes = array_merge($extractedSizes, $parts);
        }

        $uniqueSizes = array_values(array_unique(array_filter($extractedSizes)));
        return !empty($uniqueSizes) ? json_encode($uniqueSizes) : null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'price'          => 'required|string|max:100',
            'price_val'      => 'nullable|numeric',
            'dosage_spec'    => 'nullable|string|max:100',
            'stock'          => 'nullable|integer|min:0',
            'badge_category' => 'nullable|string|max:100',
            'category'       => 'nullable|string|max:100',
            'page_type'      => 'nullable|in:products,accessory,premium,performance',
            'keywords'       => 'nullable|string',
            'description'    => 'nullable|string',
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

        $destination = public_path('uploads/products');
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $filename);
                $imagePaths[] = 'uploads/products/' . $filename;
            }
        }

        $finalImageJson = !empty($imagePaths) ? json_encode($imagePaths) : null;
        [$hasVariants, $variantTitle, $variantsJson] = $this->processVariants($request);
        $sizesJson = $this->processSizes($request, $variantsJson);
        $priceVal = $this->extractNumericPrice($validated['price'], $validated['price_val'] ?? null);

        $totalStock = (int)($validated['stock'] ?? 0);
        if ($hasVariants && $variantsJson) {
            $decodedVars = json_decode($variantsJson, true);
            $sumVariantStock = array_sum(array_column($decodedVars, 'stock'));
            if ($sumVariantStock > 0) {
                $totalStock = $sumVariantStock;
            }
        }

        DB::insert(
            "INSERT INTO products (
                title, subtitle, slug, price, price_val, dosage_spec, stock, 
                badge_category, category, page_type, keywords, description, 
                has_variants, variant_title, variants, sizes, image, created_at, updated_at
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $validated['title'],
                $validated['subtitle'] ?? null,
                $slug,
                $validated['price'],
                $priceVal,
                $validated['dosage_spec'] ?? null,
                $totalStock,
                $validated['badge_category'] ?? null,
                $validated['category'] ?? 'Weight Management',
                $validated['page_type'] ?? 'products',
                $validated['keywords'] ?? strtolower($validated['title']),
                $validated['description'] ?? null,
                $hasVariants,
                $variantTitle,
                $variantsJson,
                $sizesJson,
                $finalImageJson,
            ]
        );

        return back()->with('success', 'Product formulation successfully published.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'price'          => 'required|string|max:100',
            'price_val'      => 'nullable|numeric',
            'dosage_spec'    => 'nullable|string|max:100',
            'stock'          => 'nullable|integer|min:0',
            'badge_category' => 'nullable|string|max:100',
            'category'       => 'nullable|string|max:100',
            'page_type'      => 'nullable|in:products,accessory,premium,performance',
            'keywords'       => 'nullable|string',
            'description'    => 'nullable|string',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,webp,jpg|max:3072',
            'image_mode'     => 'nullable|in:replace,append',
            'retained_images'=> 'nullable|array',
            'retained_images.*' => 'string',
        ]);

        $current = DB::select("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
        if (empty($current)) {
            return back()->withErrors(['msg' => 'Product formulation not found.']);
        }
        $product = $current[0];

        $destination = public_path('uploads/products');
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $existingImages = [];
        if (!empty($product->image)) {
            $decoded = json_decode($product->image, true);
            $existingImages = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                ? $decoded 
                : [$product->image];
        }

        $retained = $request->input('retained_images', []);
        $mode = $request->input('image_mode', 'replace');
        $finalImageList = [];

        if ($mode === 'append') {
            $finalImageList = !empty($retained) ? $retained : $existingImages;
        } else {
            $retainedMap = array_flip($retained);
            foreach ($existingImages as $oldFile) {
                if (!isset($retainedMap[$oldFile])) {
                    if ($oldFile && file_exists(public_path($oldFile)) && str_starts_with($oldFile, 'uploads/')) {
                        @unlink(public_path($oldFile));
                    }
                }
            }
            $finalImageList = $retained;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $filename);
                $finalImageList[] = 'uploads/products/' . $filename;
            }
        }

        $imagePathJson = !empty($finalImageList) ? json_encode(array_values($finalImageList)) : null;
        [$hasVariants, $variantTitle, $variantsJson] = $this->processVariants($request);
        $sizesJson = $this->processSizes($request, $variantsJson);
        $priceVal = $this->extractNumericPrice($validated['price'], $validated['price_val'] ?? null);

        $totalStock = (int)($validated['stock'] ?? 0);
        if ($hasVariants && $variantsJson) {
            $decodedVars = json_decode($variantsJson, true);
            $sumVariantStock = array_sum(array_column($decodedVars, 'stock'));
            if ($sumVariantStock > 0) {
                $totalStock = $sumVariantStock;
            }
        }

        DB::update(
            "UPDATE products 
             SET title = ?, subtitle = ?, price = ?, price_val = ?, dosage_spec = ?, stock = ?, 
                 badge_category = ?, category = ?, page_type = ?, keywords = ?, description = ?, 
                 has_variants = ?, variant_title = ?, variants = ?, sizes = ?, image = ?, updated_at = NOW() 
             WHERE id = ?",
            [
                $validated['title'],
                $validated['subtitle'] ?? null,
                $validated['price'],
                $priceVal,
                $validated['dosage_spec'] ?? null,
                $totalStock,
                $validated['badge_category'] ?? null,
                $validated['category'] ?? 'Weight Management',
                $validated['page_type'] ?? 'products',
                $validated['keywords'] ?? strtolower($validated['title']),
                $validated['description'] ?? null,
                $hasVariants,
                $variantTitle,
                $variantsJson,
                $sizesJson,
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
                    if ($filePath && file_exists(public_path($filePath)) && str_starts_with($filePath, 'uploads/')) {
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