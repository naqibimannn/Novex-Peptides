@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/premium/product1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
        'assets/website/premium/' . basename($clean),
    ];

    foreach ($checkPaths as $p) {
        $realPath = public_path($p);
        if (file_exists($realPath)) {
            return asset($p) . '?v=' . filemtime($realPath);
        }
    }
    return asset($clean) . '?v=' . time();
};

$premiumProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'premium' 
        OR category IN ('Premium Supplements', 'Supplements') 
     ORDER BY id DESC"
);

$premShowCssPath = 'frontend/premium/show.css';
$premShowCssVer = file_exists(public_path($premShowCssPath)) ? filemtime(public_path($premShowCssPath)) : time();

$premShowJsPath = 'frontend/premium/show.js';
$premShowJsVer = file_exists(public_path($premShowJsPath)) ? filemtime(public_path($premShowJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($premShowCssPath) }}?v={{ $premShowCssVer }}">

<section class="catalog-sec" id="cat">
  <div class="wrap">
    <div class="catalog-head">
      <div class="catalog-head-text">
        <a href="{{ url('/premium') }}" class="catalog-back-link">
          &larr; Back to Premium Supplements
        </a>
        <h1 class="catalog-title">Premium Formulas</h1>
        <p class="catalog-desc">Select any formula to view its dietary specifications, capsule count, stock availability, and complete details.</p>
      </div>
    </div>

    <input id="q" class="catalog-search" type="search" placeholder="Search formulas, supplements..." oninput="filterProducts(true)">

    <div class="catalog-filters" id="flt">
      <button type="button" class="filter-btn on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Premium Supplements', this)">Premium Supplements</button>
    </div>
    
    <div class="catalog-grid" id="pg">
      @forelse($premiumProducts as $item)
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
                $slides = ['assets/website/premium/product1.webp'];
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

            $detailUrl = url('/products/' . $itemSlug);
            $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
        @endphp

        <div class="catalog-card card pc" data-category="Premium Supplements" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Formula' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }} {{ $sIdx + 1 }}" loading="lazy">
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
                    <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Formula' }}">
                      <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }}" loading="lazy">
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
            <h3 class="card-title">{{ $item->title ?? 'Formula' }}</h3>
            @if(!empty($item->subtitle))
              <p class="card-subtitle">{{ $item->subtitle }}</p>
            @endif
            <div class="card-price">{{ $displayPrice }}</div>
            <div class="card-meta">
              <span class="meta-tag">{{ $item->dosage_spec ?? '30 Capsules' }}</span>
              <span class="meta-tag">Premium Supplements</span>
            </div>
            <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted, #5A6F82);">
          No formulas currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" class="no-match">
      <p>No formulas match your search or filter.</p>
    </div>

    <div id="pagination" class="catalog-pagination"></div>

    <p class="catalog-disclaimer">
      Novex Premium Supplements are manufactured under strict laboratory standards for health, antioxidant, and everyday wellness support.
    </p>
  </div>
</section>

<script src="{{ asset($premShowJsPath) }}?v={{ $premShowJsVer }}"></script>
@endsection