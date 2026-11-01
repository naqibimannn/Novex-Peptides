@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('reta1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    
    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
    ];

    foreach ($checkPaths as $p) {
        $realPath = public_path($p);
        if (file_exists($realPath)) {
            return asset($p) . '?v=' . filemtime($realPath);
        }
    }
    return asset($clean) . '?v=' . time();
};

$allProducts = [
    'retatrutide' => [
        'id'            => 'retatrutide',
        'db_id'         => null,
        'name'          => 'Retatrutide',
        'title'         => 'Advanced Weight Management',
        'spec'          => '10mg - 100mg',
        'val'           => 280,
        'price'         => 'RM280.00 - RM980.00',
        'category'      => 'Weight Management',
        'page_type'     => 'products',
        'imgs'          => ['reta1.webp', 'reta2.webp', 'reta3.webp', 'reta4.webp', 'reta5.webp'],
        'stock'         => 63,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [
            ['label' => '10mg', 'val' => 280, 'p' => 'RM280.00', 'stock' => 25],
            ['label' => '30mg', 'val' => 480, 'p' => 'RM480.00', 'stock' => 18],
            ['label' => '60mg', 'val' => 780, 'p' => 'RM780.00', 'stock' => 12],
            ['label' => '100mg', 'val' => 980, 'p' => 'RM980.00', 'stock' => 8],
        ],
        'sizes'         => [],
        'desc'          => 'High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Select your preferred vial concentration above to view exact pricing.',
    ],
    'jersey-01' => [
        'id'            => 'jersey-01',
        'db_id'         => null,
        'name'          => 'Premium Athletic Jersey',
        'title'         => 'Performance. Style. Everyday.',
        'spec'          => 'Adult Size',
        'val'           => 40,
        'price'         => 'RM40.00',
        'category'      => 'Apparel',
        'page_type'     => 'products',
        'imgs'          => ['jry1.webp', 'jry2.webp'],
        'stock'         => 50,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [],
        'sizes'         => ['S', 'M', 'L', 'XL'],
        'desc'          => 'Official Novex Peptides merchandise. Crafted with lightweight, breathable, and moisture-wicking hexagonal weave fabric. Features premium V-neck design and durable finish.',
    ]
];

try {
    $dbRows = \Illuminate\Support\Facades\DB::select("SELECT * FROM products");
    foreach ($dbRows as $row) {
        $imgs = [];
        if (!empty($row->image)) {
            $decodedImg = json_decode($row->image, true);
            $rawList = (json_last_error() === JSON_ERROR_NONE && is_array($decodedImg) && count($decodedImg) > 0)
                ? $decodedImg
                : [$row->image];
            $imgs = $rawList;
        }
        if (empty($imgs)) {
            $imgs = ['reta1.webp'];
        }

        $variants = [];
        if (!empty($row->has_variants) && !empty($row->variants)) {
            $decodedVar = is_string($row->variants) ? json_decode($row->variants, true) : $row->variants;
            if (is_array($decodedVar)) {
                foreach ($decodedVar as $v) {
                    $vVal = (float)($v['val'] ?? 0);
                    if ($vVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $v['price'] ?? '', $vm)) {
                        $vVal = (float)$vm[1];
                    }
                    $variants[] = [
                        'label' => $v['label'] ?? '',
                        'val'   => $vVal,
                        'p'     => !empty($v['price']) ? $v['price'] : ('RM' . number_format($vVal, 2)),
                        'stock' => (int)($v['stock'] ?? 0),
                    ];
                }
            }
        }

        $sizes = [];
        if (!empty($row->sizes)) {
            $decodedSizes = is_string($row->sizes) ? json_decode($row->sizes, true) : $row->sizes;
            if (is_array($decodedSizes)) {
                $sizes = array_values(array_filter(array_map('trim', $decodedSizes)));
            } elseif (is_string($row->sizes)) {
                $sizes = array_values(array_filter(array_map('trim', explode(',', $row->sizes))));
            }
        }

        $numericVal = (float)($row->price_val ?? 0);
        if ($numericVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $row->price ?? '', $m)) {
            $numericVal = (float)$m[1];
        }

        $rawSlug = property_exists($row, 'slug') && !empty($row->slug) ? $row->slug : '';
        $key = $rawSlug ?: \Illuminate\Support\Str::slug($row->title ?? ('product-' . $row->id));

        $itemData = [
            'id'            => $key,
            'db_id'         => $row->id,
            'name'          => $row->title ?? 'Untitled Product',
            'title'         => $row->subtitle ?? '',
            'spec'          => !empty($row->dosage_spec) ? $row->dosage_spec : '',
            'val'           => $numericVal,
            'price'         => !empty($row->price) ? $row->price : ('RM' . number_format($numericVal, 2)),
            'category'      => !empty($row->category) ? $row->category : 'Weight Management',
            'page_type'     => $row->page_type ?? 'products',
            'imgs'          => $imgs,
            'stock'         => (int)($row->stock ?? 0),
            'variant_title' => !empty($row->variant_title) ? $row->variant_title : 'Select Vial Concentration / Dosage:',
            'variants'      => $variants,
            'sizes'         => $sizes,
            'desc'          => !empty($row->description) ? $row->description : ($allProducts[$key]['desc'] ?? 'High-purity laboratory formulation verified with third-party quality control.'),
        ];

        $allProducts[$key] = $itemData;
        $allProducts[\Illuminate\Support\Str::slug($row->title ?? '')] = $itemData;
        $allProducts[strtolower(trim($row->title ?? ''))] = $itemData;
        $allProducts[(string)$row->id] = $itemData;
    }
} catch (\Throwable $e) {}

$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(2) ?? 'retatrutide';
if (is_object($reqKey)) {
    $reqKey = $reqKey->slug ?? $reqKey->id ?? 'retatrutide';
}
$reqKey = urldecode((string)$reqKey);

$currProd = $allProducts[$reqKey]
    ?? $allProducts[strtolower($reqKey)]
    ?? $allProducts[\Illuminate\Support\Str::slug($reqKey)]
    ?? reset($allProducts);

$hasVariants = !empty($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel   = ($currProd['category'] === 'Apparel') || (!empty($currProd['sizes']) && count($currProd['sizes']) > 0);

$firstSegment = request()->segment(1);

$isPremium = ($firstSegment === 'premium') 
    || request()->is('premium*') 
    || (($currProd['page_type'] ?? '') === 'premium') 
    || in_array($currProd['category'] ?? '', ['Premium Supplements', 'Supplements']);

$isPerformance = ($firstSegment === 'performance') 
    || request()->is('performance*') 
    || (($currProd['page_type'] ?? '') === 'performance') 
    || in_array($currProd['category'] ?? '', ['Performance', 'Performance Apparel']);

$isAccessory = ($firstSegment === 'accessory') 
    || request()->is('accessory*') 
    || (($currProd['page_type'] ?? '') === 'accessory') 
    || in_array($currProd['category'] ?? '', ['Accessory', 'Injection Kit', 'Syringes']);

$showCssPath = 'frontend/products/show.css';
$showCssVer = file_exists(public_path($showCssPath)) ? filemtime(public_path($showCssPath)) : time();

$showJsPath = 'frontend/products/show.js';
$showJsVer = file_exists(public_path($showJsPath)) ? filemtime(public_path($showJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($showCssPath) }}?v={{ $showCssVer }}">

<section class="product-detail-sec" id="productDetailSec">
  <div class="wrap">
    <div class="detail-back-nav">
      @if($isPremium)
        <a href="{{ url('/premium') }}" class="detail-back-link">&larr; Back to Premium Supplements</a>
      @elseif($isPerformance)
        <a href="{{ url('/performance') }}" class="detail-back-link">&larr; Back to Performance Division</a>
      @elseif($isAccessory)
        <a href="{{ route('accessory') }}" class="detail-back-link">&larr; Back to Accessories</a>
      @else
        <a href="{{ route('products.index') }}" class="detail-back-link">&larr; Back to Catalog</a>
      @endif
    </div>

    <div class="detail-grid">
      <div class="detail-media-wrap">
        <div class="detail-img-wrap prod-slider">
          <div class="prod-slides">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <div class="prod-slide contain-slide {{ $idx === 0 ? 'active' : '' }}">
                <img src="{{ $resolveImageUrl($imgFile) }}" 
                     alt="{{ $currProd['name'] }} Slide {{ $idx + 1 }}" 
                     loading="lazy"
                     onload="fitRoundedImg(this)"
                     onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1000'">
              </div>
            @endforeach
          </div>
        </div>

        @if(count($currProd['imgs']) > 1)
          <div class="ps-dots">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <span class="ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="setImgSlide(this, {{ $idx }})"></span>
            @endforeach
          </div>
        @endif
      </div>

      <div class="detail-info">
        <span class="detail-badge">{{ $currProd['category'] }}</span>
        <h1 class="detail-title">{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" class="detail-subtitle">
          {{ $currProd['title'] }}{{ !empty($currProd['spec']) ? ' (' . $currProd['spec'] . ')' : '' }}
        </p>
        <div id="detailPriceDisplay" class="detail-price">{{ $currProd['price'] }}</div>
        
        <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $currProd['stock'] }} units available)</div>

        @if($hasVariants)
        <div class="variant-panel">
          <label class="variant-label">
            {{ $currProd['variant_title'] }}
          </label>
          <div class="size-picker" id="variantPickerGroup">
            @foreach($currProd['variants'] as $vIdx => $v)
              <button type="button" class="size-btn {{ $vIdx === 0 ? 'active' : '' }}" onclick="selectProductVariant({{ $vIdx }}, this)">
                {{ $v['label'] }}
              </button>
            @endforeach
          </div>
          <small id="varHint" class="variant-hint">
            Select a dosage above to display the exact price.
          </small>
        </div>
        @endif

        @if($isApparel)
        <div class="apparel-panel">
          <div class="apparel-header">
            <label class="apparel-label">Select Size:</label>
            <a class="chart-link" onclick="openSizeModal()">View Size Chart</a>
          </div>
          <div class="size-picker" id="sizePickerGroup">
            @foreach($currProd['sizes'] as $sIdx => $sz)
              <button type="button" class="size-btn {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectProductSize('{{ $sz }}', this)">
                {{ $sz }}
              </button>
            @endforeach
          </div>
        </div>
        @endif

        <div class="detail-desc">
          <h4>Product Overview</h4>
          <p>{{ $currProd['desc'] }}</p>
        </div>

        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1, {{ (int)$currProd['stock'] }})">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1, {{ (int)$currProd['stock'] }})">+</button>
          </div>
          <button type="button" class="btn-add-cart" onclick="triggerAddToCart()">Add to Cart</button>
        </div>

        <div class="detail-guarantees">
          <p>&bull; High purity formulation verified with third-party quality control.</p>
          <p>&bull; Secure thermal-insulated packaging for all temperature-sensitive items.</p>
          <p>&bull; Direct WhatsApp support available for wholesale or technical inquiries.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal-overlay" id="sizeModal" onclick="if(event.target===this)closeSizeModal()">
  <div class="modal-content">
    <button type="button" class="modal-close" onclick="closeSizeModal()">&times;</button>
    <h3 class="modal-title">Size Chart (Adult)</h3>
    <p class="modal-subtitle">Novex Premium Athletic Jersey — All measurements in inches.</p>
    <div class="table-scroll">
      <table class="size-table">
        <thead>
          <tr>
            <th>Size</th>
            <th>Length (A)</th>
            <th>Chest (B)</th>
            <th>Shoulder</th>
            <th>Short Sleeve</th>
            <th>Long Sleeve</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><b>S</b></td>
            <td>26</td>
            <td>38</td>
            <td>16</td>
            <td>8.5</td>
            <td>22.5</td>
          </tr>
          <tr>
            <td><b>M</b></td>
            <td>27</td>
            <td>40</td>
            <td>17</td>
            <td>9</td>
            <td>23</td>
          </tr>
          <tr>
            <td><b>L</b></td>
            <td>28</td>
            <td>42</td>
            <td>18</td>
            <td>9.5</td>
            <td>23.5</td>
          </tr>
          <tr>
            <td><b>XL</b></td>
            <td>29</td>
            <td>44</td>
            <td>19</td>
            <td>10</td>
            <td>24</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="measure-guide">
      <b>How to Measure:</b><br>
      &bull; <b>Length (A):</b> Measure from the highest point of the shoulder to the bottom of the shirt.<br>
      &bull; <b>Chest (B):</b> Measure around the fullest part of the chest, keeping the tape horizontal.
    </div>
  </div>
</div>

<script>
window.CURRENT_PROD = @json($currProd);
window.PROD_FLAGS = {
  isPremium: @json($isPremium),
  isPerformance: @json($isPerformance),
  isAccessory: @json($isAccessory)
};
</script>
<script src="{{ asset($showJsPath) }}?v={{ $showJsVer }}"></script>
@endsection