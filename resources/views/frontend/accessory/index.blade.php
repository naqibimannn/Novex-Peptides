@extends('frontend.home.index')

@php
$allAccessories = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'accessory' 
        OR category IN ('Accessory', 'Injection Kit', 'Syringes') 
     ORDER BY id DESC"
);

$itemListElements = [];
foreach ($allAccessories as $index => $item) {
    $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
        ? $item->slug
        : \Illuminate\Support\Str::slug($item->title ?? ('accessory-' . $item->id));

    $itemUrl = \Illuminate\Support\Facades\Route::has('accessory.show') 
        ? route('accessory.show', $itemSlug) 
        : url('/accessory/' . $itemSlug);

    $itemListElements[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item->title,
        'url' => $itemUrl,
    ];
}

$canonicalUrl = \Illuminate\Support\Facades\Route::has('accessory') ? route('accessory') : url('/accessory');
@endphp

@section('seo')
<x-seo 
    title="Laboratory Accessories &amp; Injection Kits | Novex Peptides"
    description="Explore sterile laboratory accessories, reconstitution solutions, and precision injection kits engineered for research handling."
    :canonical="$canonicalUrl"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Novex Peptides Accessory Catalog',
        'url' => $canonicalUrl,
        'description' => 'Explore sterile laboratory accessories, reconstitution solutions, and precision injection kits engineered for research handling.',
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

$accCssPath = 'frontend/accessory/accessory.css';
$accCssVer = file_exists(public_path($accCssPath)) ? filemtime(public_path($accCssPath)) : time();

$accJsPath = 'frontend/accessory/accessory.js';
$accJsVer = file_exists(public_path($accJsPath)) ? filemtime(public_path($accJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($accCssPath) }}?v={{ $accCssVer }}">

<section class="catalog-sec" id="cat">
  <div class="wrap">
    <div class="catalog-head">
      <div class="catalog-head-text">
        <h1 class="catalog-title">Accessory Catalog</h1>
        <p class="catalog-desc">Select any laboratory accessory, injection equipment, or sterile supply to review specifications, stock availability, and usage details.</p>
      </div>
    </div>

    <input id="q" class="catalog-search" type="search" placeholder="Search accessories, syringes or injection kits..." oninput="filterProducts(true)">

    <div class="catalog-filters" id="flt">
      <button type="button" class="filter-btn on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Accessory', this)">Accessory</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Injection Kit', this)">Injection Kit</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Syringes', this)">Syringes</button>
    </div>
    
    <div class="catalog-grid" id="pg">
      @forelse($allAccessories as $item)
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
                : \Illuminate\Support\Str::slug($item->title ?? ('accessory-' . $item->id));

            $detailUrl = \Illuminate\Support\Facades\Route::has('accessory.show') 
                ? route('accessory.show', $itemSlug) 
                : url('/accessory/' . $itemSlug);

            $itemStock = (int)($item->stock ?? 0);
            $stockStatus = property_exists($item, 'stock_status') && !empty($item->stock_status) 
                ? $item->stock_status 
                : ($itemStock > 0 ? 'in_stock' : 'out_of_stock');
            $isComingSoon = ($stockStatus === 'coming_soon');
        @endphp

        <div class="catalog-card card pc" data-category="{{ $item->category ?? 'Accessory' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title }} view {{ $sIdx + 1 }}" width="300" height="300" loading="lazy">
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

            @if($isComingSoon)
              <div class="card-price coming-soon">Coming Soon</div>
            @else
              <div class="card-price">{{ $item->price }}</div>
            @endif

            <div class="card-meta">
              <span class="meta-tag">{{ $item->dosage_spec ?? 'Laboratory Standard' }}</span>
              <span class="meta-tag">{{ $item->badge_category ?? $item->category ?? 'Accessory' }}</span>
            </div>
            <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted, #5A6F82);">
          No accessories currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" class="no-match">
      <p>No accessories match your search or filter.</p>
    </div>

    <div id="pagination" class="catalog-pagination"></div>

    <p class="catalog-disclaimer">
      Sterile medical accessories, syringes, and injection tools are intended for laboratory, research, or authorized personal clinical use only.
    </p>
  </div>
</section>

<script src="{{ asset($accJsPath) }}?v={{ $accJsVer }}"></script>
@endsection