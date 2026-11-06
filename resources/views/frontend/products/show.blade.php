@extends('frontend.home.index')

@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('reta1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    
    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
        'assets/website/skin/' . basename($clean),
        'assets/website/premium/' . basename($clean),
        'assets/website/category/' . basename($clean),
    ];

    foreach ($checkPaths as $p) {
        $realPath = public_path($p);
        if (file_exists($realPath)) {
            return asset($p) . '?v=' . filemtime($realPath);
        }
    }
    return asset($clean) . '?v=' . time();
};

$allProducts = [];

try {
    $dbRows = \Illuminate\Support\Facades\DB::select("SELECT * FROM products ORDER BY id DESC");
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

        $itemStock = (int)($row->stock ?? 0);
        $rawStatus = property_exists($row, 'stock_status') && !empty($row->stock_status) ? $row->stock_status : null;
        if (empty($rawStatus)) {
            $rawStatus = $itemStock > 0 ? 'in_stock' : 'out_of_stock';
        }

        $isComingSoon = ($rawStatus === 'coming_soon');

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
                        'val'   => $isComingSoon ? 0.00 : $vVal,
                        'p'     => $isComingSoon ? '' : (!empty($v['price']) ? $v['price'] : ('RM' . number_format($vVal, 2))),
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
            'name'          => $row->title ?? 'Untitled Formulation',
            'title'         => $row->subtitle ?? '',
            'spec'          => !empty($row->dosage_spec) ? $row->dosage_spec : '',
            'val'           => $isComingSoon ? 0.00 : $numericVal,
            'price'         => $isComingSoon ? '' : (!empty($row->price) ? $row->price : ('RM' . number_format($numericVal, 2))),
            'category'      => !empty($row->category) ? $row->category : 'General Catalog',
            'page_type'     => $row->page_type ?? 'products',
            'imgs'          => $imgs,
            'stock'         => $itemStock,
            'stock_status'  => $rawStatus,
            'badge_category'=> $row->badge_category ?? null,
            'variant_title' => !empty($row->variant_title) ? $row->variant_title : 'Select Formulation / Dosage:',
            'variants'      => $variants,
            'sizes'         => $sizes,
            'desc'          => !empty($row->description) ? $row->description : 'High-purity laboratory formulation verified with strict quality control standards.',
        ];

        $allProducts[$key] = $itemData;
        $allProducts[\Illuminate\Support\Str::slug($row->title ?? '')] = $itemData;
        $allProducts[strtolower(trim($row->title ?? ''))] = $itemData;
        $allProducts[(string)$row->id] = $itemData;
    }
} catch (\Throwable $e) {}

$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(3) ?? request()->segment(2) ?? '';
if (is_object($reqKey)) {
    $reqKey = $reqKey->slug ?? $reqKey->id ?? '';
}
$reqKey = urldecode((string)$reqKey);

$currProd = $allProducts[$reqKey]
    ?? $allProducts[strtolower($reqKey)]
    ?? $allProducts[\Illuminate\Support\Str::slug($reqKey)]
    ?? (!empty($allProducts) ? reset($allProducts) : [
        'id'            => 'not-found',
        'db_id'         => null,
        'name'          => 'Product Not Found',
        'title'         => 'No details available',
        'spec'          => '',
        'val'           => 0,
        'price'         => '',
        'category'      => 'Catalog',
        'page_type'     => 'products',
        'imgs'          => ['reta1.webp'],
        'stock'         => 0,
        'stock_status'  => 'out_of_stock',
        'badge_category'=> null,
        'variant_title' => 'Select Option:',
        'variants'      => [],
        'sizes'         => [],
        'desc'          => 'The requested product could not be found or has not been published yet.',
    ]);

$hasVariants = !empty($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel   = ($currProd['category'] === 'Apparel') || (!empty($currProd['sizes']) && count($currProd['sizes']) > 0);

$firstSegment = strtolower((string) request()->segment(1));

$isSkin        = ($firstSegment === 'skin') || request()->is('skin*');
$isPremium     = ($firstSegment === 'premium') || request()->is('premium*');
$isPerformance = ($firstSegment === 'performance') || request()->is('performance*');
$isAccessory   = ($firstSegment === 'accessory') || request()->is('accessory*');

if ($isSkin) {
    $backUrl  = url('/skin/show');
    $backText = '← Back to Novex Skin Lab';
} elseif ($isPremium) {
    $backUrl  = url('/premium/show');
    $backText = '← Back to Premium Supplements';
} elseif ($isPerformance) {
    $backUrl  = url('/performance/show');
    $backText = '← Back to Performance Division';
} elseif ($isAccessory) {
    $backUrl  = route('accessory');
    $backText = '← Back to Accessories';
} else {
    $backUrl  = route('products.index');
    $backText = '← Back to Catalog';
}

$showCssPath = 'frontend/products/show.css';
$showCssVer = file_exists(public_path($showCssPath)) ? filemtime(public_path($showCssPath)) : time();

$showJsPath = 'frontend/products/show.js';
$showJsVer = file_exists(public_path($showJsPath)) ? filemtime(public_path($showJsPath)) : time();

$seoImages = [];
foreach ($currProd['imgs'] as $imgItem) {
    $seoImages[] = $resolveImageUrl($imgItem);
}
$mainOgImage = $seoImages[0] ?? asset('reta1.webp');

$cleanDescription = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($currProd['desc'] ?? ''))), 155);
if (empty($cleanDescription)) {
    $cleanDescription = $currProd['name'] . ' - High-purity laboratory formulation verified with strict quality control standards.';
}

$stockStatus = $currProd['stock_status'] ?? (($currProd['stock'] ?? 0) > 0 ? 'in_stock' : 'out_of_stock');
$canAddToCart = ($stockStatus === 'in_stock') && (($currProd['stock'] ?? 0) > 0);

$productPrice = (float)($currProd['val'] ?? 0);
if ($stockStatus !== 'coming_soon' && $productPrice <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $currProd['price'] ?? '', $pm)) {
    $productPrice = (float)$pm[1];
}

$productSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/')
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Catalog',
                    'item' => $backUrl
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $currProd['name'],
                    'item' => url()->current()
                ]
            ]
        ],
        [
            '@type' => 'Product',
            'name' => $currProd['name'],
            'image' => $seoImages,
            'description' => $cleanDescription,
            'category' => $currProd['category'],
            'sku' => 'NVX-' . ($currProd['db_id'] ?? $currProd['id']),
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => 'MYR',
                'price' => number_format($productPrice, 2, '.', ''),
                'priceValidUntil' => \Carbon\Carbon::now()->addYear()->format('Y-12-31'),
                'availability' => $canAddToCart ? 'https://schema.org/InStock' : ($stockStatus === 'coming_soon' ? 'https://schema.org/PreOrder' : 'https://schema.org/OutOfStock'),
                'itemCondition' => 'https://schema.org/NewCondition',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'Novex Peptides'
                ]
            ]
        ]
    ]
];
@endphp

@section('seo')
<x-seo 
    :title="$currProd['name'] . ' | Novex Peptides'"
    :description="$cleanDescription"
    :og-image="$mainOgImage"
    :type="'product'"
    :schema="$productSchema"
/>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset($showCssPath) }}?v={{ $showCssVer }}">

<section class="product-detail-sec" id="productDetailSec">
  <div class="wrap">
    <div class="detail-back-nav">
      <a href="{{ $backUrl }}" class="detail-back-link" id="detailBackLink">{{ $backText }}</a>
    </div>

    <div class="detail-grid">
      <div class="detail-media-wrap">
        <div class="detail-img-wrap prod-slider">
          <div class="prod-slides">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <div class="prod-slide contain-slide {{ $idx === 0 ? 'active' : '' }}">
                <img src="{{ $resolveImageUrl($imgFile) }}" 
                     alt="{{ $currProd['name'] }} formulation view {{ $idx + 1 }}" 
                     width="600"
                     height="600"
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
        <span class="detail-badge">{{ !empty($currProd['badge_category']) ? $currProd['badge_category'] : $currProd['category'] }}</span>
        <h1 class="detail-title">{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" class="detail-subtitle">
          {{ $currProd['title'] }}{{ !empty($currProd['spec']) ? ' (' . $currProd['spec'] . ')' : '' }}
        </p>

        @if($stockStatus === 'coming_soon')
          <div id="detailPriceDisplay" class="detail-price" style="display: none !important;"></div>
        @else
          <div id="detailPriceDisplay" class="detail-price">{{ $currProd['price'] }}</div>
        @endif
        
        @if($stockStatus === 'in_stock')
          <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $currProd['stock'] }} units available)</div>
        @elseif($stockStatus === 'out_of_stock')
          <div id="detailStockDisplay" class="stock-badge" style="background:#fee2e2; color:#dc2626; border-color:#fca5a5;">Out of Stock</div>
        @elseif($stockStatus === 'coming_soon')
          <div id="detailStockDisplay" class="stock-badge" style="background:#fef3c7; color:#d97706; border-color:#fcd34d;">Coming Soon</div>
        @endif

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
          @if($stockStatus !== 'coming_soon')
          <small id="varHint" class="variant-hint">
            Select a dosage above to display the exact price.
          </small>
          @endif
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
          @if($canAddToCart)
            <div class="qty-box">
              <button type="button" onclick="changeDetailQty(-1, {{ (int)$currProd['stock'] }})">-</button>
              <input type="text" id="detailQtyInput" readonly value="1">
              <button type="button" onclick="changeDetailQty(1, {{ (int)$currProd['stock'] }})">+</button>
            </div>
            <button type="button" class="btn-add-cart" onclick="triggerAddToCart()">Add to Cart</button>
          @elseif($stockStatus === 'coming_soon')
            <button type="button" class="btn-add-cart" disabled style="background:#94a3b8; cursor:not-allowed; opacity:0.8; width:100%;">Coming Soon</button>
          @else
            <button type="button" class="btn-add-cart" disabled style="background:#94a3b8; cursor:not-allowed; opacity:0.8; width:100%;">Out of Stock</button>
          @endif
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
  isSkin: @json($isSkin),
  isPremium: @json($isPremium),
  isPerformance: @json($isPerformance),
  isAccessory: @json($isAccessory)
};
</script>
<script src="{{ asset($showJsPath) }}?v={{ $showJsVer }}"></script>
<script>
(function() {
  var syncBackLink = function() {
    var el = document.getElementById('detailBackLink') || document.querySelector('.detail-back-link');
    if (el) {
      el.setAttribute('href', @json($backUrl));
      el.textContent = @json($backText);
    }
  };
  syncBackLink();
  document.addEventListener('DOMContentLoaded', syncBackLink);
})();
</script>
@endsection