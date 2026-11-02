@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/performance/front-view.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
        'assets/website/performance/' . basename($clean),
    ];

    foreach ($checkPaths as $p) {
        $realPath = public_path($p);
        if (file_exists($realPath)) {
            return asset($p) . '?v=' . filemtime($realPath);
        }
    }
    return asset($clean) . '?v=' . time();
};

$performanceProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'performance' 
        OR category = 'Performance Apparel' 
        OR slug IN ('nx-polo-navy', 'polo', 'half-zip-polo') 
     ORDER BY id DESC"
);

$perfShowCssPath = 'frontend/performance/show.css';
$perfShowCssVer = file_exists(public_path($perfShowCssPath)) ? filemtime(public_path($perfShowCssPath)) : time();

$perfShowJsPath = 'frontend/performance/show.js';
$perfShowJsVer = file_exists(public_path($perfShowJsPath)) ? filemtime(public_path($perfShowJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($perfShowCssPath) }}?v={{ $perfShowCssVer }}">

<section class="catalog-sec" id="cat">
  <div class="wrap">
    <div class="catalog-head">
      <div class="catalog-head-text">
        <a href="{{ url('/performance') }}" class="catalog-back-link">
          &larr; Back to Performance Division
        </a>
        <h1 class="catalog-title">Performance Collection</h1>
        <p class="catalog-desc">Engineered for high-intensity movement, athletic discipline, and daily comfort.</p>
      </div>
    </div>

    <input id="q" class="catalog-search" type="search" placeholder="Search performance product..." oninput="filterProducts(true)">

    <div class="catalog-filters" id="flt">
      <button type="button" class="filter-btn on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Performance', this)">Performance</button>
    </div>
    
    <div class="catalog-grid" id="pg">
      @forelse($performanceProducts as $item)
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
                $slides = ['assets/website/performance/front-view.webp'];
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

            $detailUrl = url('/performance/' . $itemSlug);
            $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
        @endphp

        <div class="catalog-card card pc" data-category="Performance" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Performance Product' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Performance Product' }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
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
                    <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Performance Product' }}">
                      <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Performance Product' }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
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
            <h3 class="card-title">{{ $item->title ?? 'Performance Product' }}</h3>
            @if(!empty($item->subtitle))
              <p class="card-subtitle">{{ $item->subtitle }}</p>
            @endif
            <div class="card-price">{{ $displayPrice }}</div>
            <div class="card-meta">
              <span class="meta-tag">{{ $item->dosage_spec ?? 'Adult Fit' }}</span>
              <span class="meta-tag">{{ $item->badge_category ?? $item->category ?? 'Performance' }}</span>
            </div>
            <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted, #5A6F82);">
          No performance products currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" class="no-match">
      <p>No products match your search or filter.</p>
    </div>

    <div id="pagination" class="catalog-pagination"></div>

    <p class="catalog-disclaimer">
      Novex Performance Division items are engineered for movement, athletic discipline, and daily comfort.
    </p>
  </div>
</section>

<script src="{{ asset($perfShowJsPath) }}?v={{ $perfShowJsVer }}"></script>
@endsection