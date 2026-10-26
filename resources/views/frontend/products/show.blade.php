@extends('frontend.home.index')

@section('content')
@php
$allProducts = [
    'retatrutide' => [
        'id' => 'retatrutide',
        'name' => 'Retatrutide',
        'title' => 'Advanced Weight Management',
        'spec' => '10mg - 100mg',
        'val' => 280,
        'price' => 'RM280.00 - RM980.00',
        'category' => 'Weight Management',
        'page_type' => 'products',
        'imgs' => ['reta1.webp', 'reta2.webp', 'reta3.webp', 'reta4.webp', 'reta5.webp'],
        'stock' => 63,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants' => [
            ['label' => '10mg', 'val' => 280, 'price' => 'RM280.00', 'stock' => 25],
            ['label' => '30mg', 'val' => 480, 'price' => 'RM480.00', 'stock' => 18],
            ['label' => '60mg', 'val' => 780, 'price' => 'RM780.00', 'stock' => 12],
            ['label' => '100mg', 'val' => 980, 'price' => 'RM980.00', 'stock' => 8],
        ],
        'desc' => 'High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Select your preferred vial concentration above to view exact pricing.',
    ],
];

// Ambil semua produk dari database dan gabungkan ke $allProducts supaya terhubung penuh dengan Admin
try {
    $dbRows = \Illuminate\Support\Facades\DB::select("SELECT * FROM products");
    foreach ($dbRows as $row) {
        $imgs = ['reta1.webp'];
        if (!empty($row->image)) {
            $decodedImg = json_decode($row->image, true);
            $imgs = (json_last_error() === JSON_ERROR_NONE && is_array($decodedImg) && count($decodedImg) > 0)
                ? $decodedImg
                : [$row->image];
        }

        $variants = [];
        if (!empty($row->has_variants) && !empty($row->variants)) {
            $decodedVar = json_decode($row->variants, true);
            if (is_array($decodedVar)) {
                $variants = $decodedVar;
            }
        }

        $sizes = [];
        if (!empty($row->sizes)) {
            $decodedSizes = json_decode($row->sizes, true);
            if (is_array($decodedSizes)) {
                $sizes = $decodedSizes;
            }
        }

        $numericVal = (float)($row->price_val ?? 0);
        if ($numericVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $row->price ?? '', $m)) {
            $numericVal = (float)$m[1];
        }

        $key = $row->slug ?: \Illuminate\Support\Str::slug($row->title);
        $itemData = [
            'id'            => $key,
            'db_id'         => $row->id,
            'name'          => $row->title,
            'title'         => $row->subtitle ?? '',
            'spec'          => $row->dosage_spec ?? 'Standard',
            'val'           => $numericVal,
            'price'         => $row->price,
            'category'      => $row->category ?? 'Weight Management',
            'page_type'     => $row->page_type ?? 'products',
            'imgs'          => $imgs,
            'stock'         => (int)($row->stock ?? 0),
            'variant_title' => $row->variant_title ?: 'Select Vial Concentration / Dosage:',
            'variants'      => $variants,
            'sizes'         => $sizes,
            'desc'          => $row->description ?: ($allProducts[$key]['desc'] ?? 'High-purity laboratory formulation verified with third-party quality control.'),
        ];

        $allProducts[$key] = $itemData;
        $allProducts[(string)$row->id] = $itemData;
    }
} catch (\Throwable $e) {
    // Fallback jika tabel belum dimigrasi
}

$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(2) ?? 'retatrutide';
if(is_object($reqKey)) {
    $reqKey = $reqKey->slug ?? $reqKey->id ?? 'retatrutide';
}
$currProd = $allProducts[$reqKey] ?? reset($allProducts);
$hasVariants = isset($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel = isset($currProd['sizes']) && count($currProd['sizes']) > 0;
$isAccessory = ($currProd['page_type'] ?? '') === 'accessory' || ($currProd['category'] ?? '') === 'Accessory' || request()->is('accessory*');
@endphp

<!-- Gunakan style & markup show.blade.php seperti sedia kala, bagian dinamis di bawah ini telah terhubung ke Admin -->
<section class="sec">
  <div class="wrap">
    <div style="margin-bottom:24px">
      @if($isAccessory)
        <a href="{{ route('accessory') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Accessories</a>
      @else
        <a href="{{ route('products.index') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Catalog</a>
      @endif
    </div>

    <div class="detail-grid">
      <div class="detail-img-wrap">
        @foreach($currProd['imgs'] as $idx => $imgFile)
          <div class="prod-slide {{ $idx === 0 ? 'active' : '' }}" id="slide{{ $idx }}">
            <img src="{{ asset($imgFile) }}" alt="{{ $currProd['name'] }} Image {{ $idx + 1 }}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800'">
          </div>
        @endforeach

        @if(count($currProd['imgs']) > 1)
          <div class="ps-dots">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <span class="ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="showProductSlide({{ $idx }}, this)"></span>
            @endforeach
          </div>
        @endif
      </div>

      <div class="detail-info">
        <span class="detail-badge">{{ $currProd['category'] }}</span>
        <h1 style="font-size:clamp(28px, 4vw, 42px);margin:4px 0">{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" style="color:var(--mut);font-size:16px">{{ $currProd['title'] }} ({{ $currProd['spec'] }})</p>
        
        <div id="detailPriceDisplay" class="detail-price">{{ $currProd['price'] }}</div>
        
        <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $currProd['stock'] }} units available)</div>

        @if($hasVariants)
        <div style="background:var(--card);padding:16px;border-radius:18px;border:1px solid var(--line);margin-top:6px">
          <label style="font-size:12px;font-weight:700;text-transform:uppercase;color:var(--ink);display:block;margin-bottom:6px">
            {{ $currProd['variant_title'] ?? 'Select Vial Concentration / Dosage:' }}
          </label>
          <div class="size-picker">
            @foreach($currProd['variants'] as $vIdx => $variant)
              <button type="button" class="size-btn {{ $vIdx === 0 ? 'active' : '' }}" onclick="selectVariant('{{ addslashes($variant['label']) }}', {{ (float)$variant['val'] }}, '{{ addslashes($variant['price']) }}', {{ (int)$variant['stock'] }}, this)">
                {{ $variant['label'] }}
              </button>
            @endforeach
          </div>
          <small id="varHint" style="font-size:12px;color:var(--mut);display:block;margin-top:4px">
            Select an option above to view exact pricing and available laboratory stock.
          </small>
        </div>
        @endif

        @if($isApparel)
        <div style="margin-top:6px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
            <label style="font-size:12px;font-weight:600;text-transform:uppercase;color:var(--mut)">Select Size:</label>
            <a class="chart-link" onclick="openSizeModal()">View Size Chart</a>
          </div>
          <div class="size-picker">
            @foreach($currProd['sizes'] as $sIdx => $sz)
              <button type="button" class="size-btn {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectSize('{{ $sz }}', this)">
                {{ $sz }}
              </button>
            @endforeach
          </div>
        </div>
        @endif

        <div class="detail-desc">
          <h4 style="font-family:var(--serif);font-size:20px;margin-bottom:8px">Product Overview</h4>
          <p>{{ $currProd['desc'] }}</p>
        </div>

        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1)" aria-label="Decrease quantity">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1)" aria-label="Increase quantity">+</button>
          </div>
          
          <button type="button" class="btn-add-cart" onclick="addToCartFromDetail()">Add to Cart</button>
        </div>

        <!-- AUTO GUARANTEES BULLETS (ALWAYS SHOWN) -->
        <div style="margin-top:12px;font-size:12px;color:var(--mut);line-height:1.6;border-top:1px solid var(--line);padding-top:14px">
          • High purity formulation verified with third-party quality control.<br>
          • Secure thermal-insulated packaging for all temperature-sensitive items.<br>
          • Direct WhatsApp support available for wholesale or technical inquiries.
        </div>
      </div>
    </div>
  </div>
</section>