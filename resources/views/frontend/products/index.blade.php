@extends('frontend.home.index')

@php
$allProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE (page_type NOT IN ('skin', 'accessory', 'premium', 'performance') OR page_type IS NULL OR page_type = '') 
       AND (category NOT IN ('Skin Lab', 'Accessory', 'Injection Kit', 'Syringes', 'Premium Supplements', 'Supplements', 'Performance Apparel') OR category IS NULL) 
       AND (slug NOT IN ('nx-polo-navy', 'polo', 'half-zip-polo') OR slug IS NULL)
     ORDER BY id DESC"
);

$itemListElements = [];
foreach ($allProducts as $index => $prod) {
    $pSlug = !empty($prod->slug) ? $prod->slug : \Illuminate\Support\Str::slug($prod->title ?? ('product-' . $prod->id));
    $itemListElements[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $prod->title,
        'url' => url('/products/' . $pSlug)
    ];
}
@endphp

@section('seo')
<x-seo 
    title="Shop Research Peptides Catalog | Novex Peptides"
    description="Browse certified high-purity peptides, metabolic research compounds, and laboratory solutions. Batch-level verification with third-party HPLC assay testing."
    :canonical="route('products.index')"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Novex Peptides Catalog',
        'url' => route('products.index'),
        'description' => 'Browse certified high-purity peptides, metabolic research compounds, and laboratory solutions.',
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $itemListElements
        ]
    ]"
/>
@endsection

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/placeholder.webp');
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

$prodCssPath = 'frontend/products/products.css';
$prodCssVer = file_exists(public_path($prodCssPath)) ? filemtime(public_path($prodCssPath)) : time();

$prodJsPath = 'frontend/products/products.js';
$prodJsVer = file_exists(public_path($prodJsPath)) ? filemtime(public_path($prodJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($prodCssPath) }}?v={{ $prodCssVer }}">

<section class="catalog-sec" id="cat">
  <div class="wrap">
    <div class="catalog-head">
      <div class="catalog-head-text">
        <h1 class="catalog-title">Shop Catalog</h1>
        <p class="catalog-desc">Select any product to view its batch specifications, dosage options, stock availability, and full profile.</p>
      </div>
    </div>

    <input id="q" class="catalog-search" type="search" placeholder="Search products, serums or apparel..." oninput="filterProducts(true)">

    <div class="catalog-filters" id="flt">
      <button type="button" class="filter-btn on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Weight Management', this)">Weight Management</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Skincare Peptides', this)">Skincare Peptides</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Skincare Collection', this)">Skincare Collection</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Performance', this)">Performance</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Apparel', this)">Apparel</button>
    </div>
    
    <div class="catalog-grid" id="pg">
      @forelse($allProducts as $item)
        @php
            $slides = [];
            if (!empty($item->image)) {
                $decoded = json_decode($item->image, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $slides = array_values(array_filter($decoded, fn($p) => !empty($p)));
                } elseif (is_string($item->image) && !empty($item->image)) {
                    $slides = [$item->image];
                }
            }
            if (empty($slides)) {
                $slides = ['assets/website/placeholder.webp'];
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

            $detailUrl = url('/products/' . $itemSlug);
        @endphp

        <div class="catalog-card card pc" data-category="{{ $item->category ?? 'Weight Management' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title }}" width="300" height="300" loading="lazy">
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @elseif(count($slides) === 1)
              @php $currentImgUrl = $resolveImageUrl($slides[0]); @endphp
              <div class="prod-slider">
                <div class="prod-slides">
                  <div class="prod-slide active">
                    <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                      <img src="{{ $currentImgUrl }}" alt="{{ $item->title }}" width="300" height="300" loading="lazy">
                    </a>
                  </div>
                </div>
              </div>
            @else
              <div class="card-ph-empty">
                N
              </div>
            @endif
          </div>

          @if(count($slides) > 1)
            <div class="ps-dots">
              @foreach($slides as $sIdx => $imgSrc)
                <span class="ps-dot {{ $sIdx === 0 ? 'active' : '' }}" onclick="setCardSlideCatalog(this, {{ $sIdx }})"></span>
              @endforeach
            </div>
          @endif

          <div class="card-b">
            <h3 class="card-title">{{ $item->title }}</h3>
            @if(!empty($item->subtitle))
              <p class="card-subtitle">{{ $item->subtitle }}</p>
            @endif
            <div class="card-price">{{ $item->price }}</div>
            <div class="card-meta">
              <span class="meta-tag">{{ $item->dosage_spec ?? 'Research grade' }}</span>
              <span class="meta-tag">{{ $item->badge_category ?? 'Research grade' }}</span>
            </div>
            <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted, #5A6F82);">
          No products currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" class="no-match">
      <p>No products match your search or filter.</p>
    </div>

    <div id="pagination" class="catalog-pagination"></div>

    <p class="catalog-disclaimer">
      Research chemicals are sold for in-vitro and laboratory research use only. Topical serums, creams, and merchandise items are formulated for daily cosmetic and athletic use.
    </p>
  </div>
</section>

<script src="{{ asset($prodJsPath) }}?v={{ $prodJsVer }}"></script>
@endsection