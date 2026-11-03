<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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

    private function recordAuditLog(Request $request, string $event, array $payload = []): void
    {
        if (!Schema::hasTable('audit_logs')) {
            return;
        }

        try {
            DB::statement("ALTER TABLE `audit_logs` MODIFY COLUMN `event` VARCHAR(100) NOT NULL");
        } catch (\Throwable $e) {
        }

        $columns = Schema::getColumnListing('audit_logs');
        $userId = auth()->id() ?? DB::table('users')->orderBy('id', 'asc')->value('id') ?? 1;
        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        $logData = [];

        if (in_array('user_id', $columns, true)) {
            $logData['user_id'] = $userId;
        }
        if (in_array('event', $columns, true)) {
            $logData['event'] = $event;
        }
        if (in_array('ip_address', $columns, true)) {
            $logData['ip_address'] = $request->ip() ?? '127.0.0.1';
        }
        if (in_array('user_agent', $columns, true)) {
            $logData['user_agent'] = substr((string) $request->userAgent(), 0, 255);
        }
        if (in_array('payload', $columns, true)) {
            $logData['payload'] = json_encode($payload);
        }
        if (in_array('created_at', $columns, true)) {
            $logData['created_at'] = $nowKl;
        }
        if (in_array('updated_at', $columns, true)) {
            $logData['updated_at'] = $nowKl;
        }

        DB::table('audit_logs')->insert($logData);
    }

    private function validateImageSecurity($file): void
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExts  = ['jpg', 'jpeg', 'png', 'webp'];

        $realMime   = $file->getMimeType();
        $clientExt  = strtolower($file->getClientOriginalExtension());
        $guessedExt = strtolower($file->guessExtension() ?? '');

        if (
            $clientExt === 'svg' ||
            str_contains(strtolower($realMime), 'svg') ||
            str_contains(strtolower($realMime), 'xml') ||
            !in_array($realMime, $allowedMimes, true) ||
            !in_array($clientExt, $allowedExts, true) ||
            !in_array($guessedExt, $allowedExts, true)
        ) {
            throw ValidationException::withMessages([
                'images' => 'Format imej tidak sah. Hanya JPG, JPEG, PNG, dan WEBP dibenarkan (SVG disekat).',
            ]);
        }
    }

    private function processImageToWebp($file, $destinationDir, $maxDimension = 1200, $quality = 80): string
    {
        $filename = 'prod_' . time() . '_' . Str::random(16) . '.webp';
        $targetPath = $destinationDir . DIRECTORY_SEPARATOR . $filename;
        $sourcePath = $file->getRealPath();

        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            $fallbackExt = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
            $fallbackName = 'prod_' . time() . '_' . Str::random(16) . '.' . $fallbackExt;
            $file->move($destinationDir, $fallbackName);
            return 'uploads/products/' . $fallbackName;
        }

        $mime = $imageInfo['mime'];
        $srcImage = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
            'image/png'               => @imagecreatefrompng($sourcePath),
            'image/webp'              => @imagecreatefromwebp($sourcePath),
            default                   => null,
        };

        if (!$srcImage) {
            $fallbackExt = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
            $fallbackName = 'prod_' . time() . '_' . Str::random(16) . '.' . $fallbackExt;
            $file->move($destinationDir, $fallbackName);
            return 'uploads/products/' . $fallbackName;
        }

        $origWidth = imagesx($srcImage);
        $origHeight = imagesy($srcImage);

        if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
            if ($origWidth >= $origHeight) {
                $newWidth = $maxDimension;
                $newHeight = (int) round(($origHeight / $origWidth) * $maxDimension);
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int) round(($origWidth / $origHeight) * $maxDimension);
            }
        } else {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }

        $targetImage = imagecreatetruecolor($newWidth, $newHeight);

        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparentColor = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
        imagefill($targetImage, 0, 0, $transparentColor);

        imagecopyresampled(
            $targetImage,
            $srcImage,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        imagewebp($targetImage, $targetPath, $quality);

        imagedestroy($srcImage);
        imagedestroy($targetImage);

        return 'uploads/products/' . $filename;
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

    private function processVariants(Request $request): array
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

    private function processSizes(Request $request, $variantsJson): ?string
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
            'page_type'      => 'nullable|in:products,skin,accessory,premium,performance',
            'keywords'       => 'nullable|string',
            'description'    => 'nullable|string',
            'images'         => 'nullable|array',
            'images.*'       => 'file|max:12288|mimes:jpeg,png,webp,jpg|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (!empty(DB::select("SELECT id FROM products WHERE slug = ? LIMIT 1", [$slug]))) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $destination = public_path('uploads/products');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true, true);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $this->validateImageSecurity($file);
                    $imagePaths[] = $this->processImageToWebp($file, $destination);
                }
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

        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        $productId = DB::table('products')->insertGetId([
            'title'          => $validated['title'],
            'subtitle'       => $validated['subtitle'] ?? null,
            'slug'           => $slug,
            'price'          => $validated['price'],
            'price_val'      => $priceVal,
            'dosage_spec'    => $validated['dosage_spec'] ?? null,
            'stock'          => $totalStock,
            'badge_category' => $validated['badge_category'] ?? null,
            'category'       => $validated['category'] ?? 'Weight Management',
            'page_type'      => $validated['page_type'] ?? 'products',
            'keywords'       => $validated['keywords'] ?? strtolower($validated['title']),
            'description'    => $validated['description'] ?? null,
            'has_variants'   => $hasVariants,
            'variant_title'  => $variantTitle,
            'variants'       => $variantsJson,
            'sizes'          => $sizesJson,
            'image'          => $finalImageJson,
            'created_at'     => $nowKl,
            'updated_at'     => $nowKl,
        ]);

        Cache::forget('frontend_products_list');

        $this->recordAuditLog($request, 'product_created', [
            'product_id' => $productId,
            'title'      => $validated['title'],
            'category'   => $validated['category'] ?? 'Weight Management',
            'price'      => $validated['price'],
            'stock'      => $totalStock,
        ]);

        return back()->with('success', 'Product formulation successfully published.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'subtitle'          => 'nullable|string|max:255',
            'price'             => 'required|string|max:100',
            'price_val'         => 'nullable|numeric',
            'dosage_spec'       => 'nullable|string|max:100',
            'stock'             => 'nullable|integer|min:0',
            'badge_category'    => 'nullable|string|max:100',
            'category'          => 'nullable|string|max:100',
            'page_type'         => 'nullable|in:products,skin,accessory,premium,performance',
            'keywords'          => 'nullable|string',
            'description'       => 'nullable|string',
            'images'            => 'nullable|array',
            'images.*'          => 'file|max:12288|mimes:jpeg,png,webp,jpg|mimetypes:image/jpeg,image/png,image/webp',
            'image_mode'        => 'nullable|in:replace,append',
            'retained_images'   => 'nullable|array',
            'retained_images.*' => 'string',
        ]);

        $current = DB::select("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
        if (empty($current)) {
            return back()->withErrors(['msg' => 'Product formulation not found.']);
        }
        $product = $current[0];

        $destination = public_path('uploads/products');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true, true);
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
                    $fullPath = public_path(ltrim($oldFile, '/'));
                    if (File::exists($fullPath) && !str_contains($fullPath, 'assets/website/')) {
                        File::delete($fullPath);
                    }
                }
            }
            $finalImageList = $retained;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $this->validateImageSecurity($file);
                    $finalImageList[] = $this->processImageToWebp($file, $destination);
                }
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

        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        DB::update(
            "UPDATE products 
             SET title = ?, subtitle = ?, price = ?, price_val = ?, dosage_spec = ?, stock = ?, 
                 badge_category = ?, category = ?, page_type = ?, keywords = ?, description = ?, 
                 has_variants = ?, variant_title = ?, variants = ?, sizes = ?, image = ?, updated_at = ? 
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
                $nowKl,
                $id,
            ]
        );

        Cache::forget('frontend_products_list');

        $this->recordAuditLog($request, 'product_updated', [
            'product_id' => $id,
            'title'      => $validated['title'],
            'category'   => $validated['category'] ?? 'Weight Management',
            'price'      => $validated['price'],
            'stock'      => $totalStock,
        ]);

        return back()->with('success', 'Product formulation successfully updated.');
    }

    public function destroy($id)
    {
        $product = DB::select("SELECT id, title, image FROM products WHERE id = ? LIMIT 1", [$id]);

        if (!empty($product)) {
            $productRecord = $product[0];

            if (!empty($productRecord->image)) {
                $decoded = json_decode($productRecord->image, true);
                $files = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
                    ? $decoded
                    : [$productRecord->image];

                foreach ($files as $filePath) {
                    $fullPath = public_path(ltrim($filePath, '/'));
                    if (File::exists($fullPath) && !str_contains($fullPath, 'assets/website/')) {
                        File::delete($fullPath);
                    }
                }
            }

            DB::delete("DELETE FROM products WHERE id = ?", [$id]);

            Cache::forget('frontend_products_list');

            $this->recordAuditLog(request(), 'product_deleted', [
                'product_id' => $id,
                'title'      => $productRecord->title ?? 'Formulation Item',
            ]);

            return back()->with('success', 'Product successfully removed from database.');
        }

        return back()->withErrors(['msg' => 'Product not found.']);
    }
}