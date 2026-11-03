@extends('frontend.home.index')

@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/skin/info.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
        'assets/website/skin/' . basename($clean),
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

$skinProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'skin' 
        OR category IN ('Skin Lab', 'Skincare', 'Novex Skincare', 'Skin', 'Skincare Peptides', 'Skincare Collection') 
     ORDER BY id DESC"
);

$skinShowCssPath = 'frontend/skin/show.css';
$skinShowCssVer = file_exists(public_path($skinShowCssPath)) ? filemtime(public_path($skinShowCssPath)) : time();

$skinShowJsPath = 'frontend/skin/show.js';
$skinShowJsVer = file_exists(public_path($skinShowJsPath)) ? filemtime(public_path($skinShowJsPath)) : time();

$itemListElements = [];
foreach ($skinProducts as $index => $item) {
    $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
        ? $item->slug
        : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

    $itemListElements[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item->title ?? 'Formula',
        'url' => url('/skin/show/' . $itemSlug),
    ];
}

$canonicalUrl = url('/skin/show');
@endphp

@section('seo')
<x-seo 
    title="Skin Lab Formulations &amp; Dermatological Care | Novex Peptides"
    description="Explore Novex Skin Lab formulations. Dermatology-inspired skincare, deep-cleansing mud foams, and cellular rejuvenation treatments crafted for Asian skin."
    :canonical="$canonicalUrl"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Novex Skin Lab Formulas Catalog',
        'url' => $canonicalUrl,
        'description' => 'Explore Novex Skin Lab formulations. Dermatology-inspired skincare, deep-cleansing mud foams, and cellular rejuvenation treatments crafted for Asian skin.',
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $itemListElements
        ]
    ]"
/>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset($skinShowCssPath) }}?v={{ $skinShowCssVer }}">

<section class="catalog-sec" id="cat">
  <div class="wrap">
    <div class="catalog-head">
      <div class="catalog-head-text">
        <a href="{{ url('/skin') }}" class="catalog-back-link">
          &larr; Back to Novex Skin Lab
        </a>
        <h1 class="catalog-title">Skin Lab Formulas</h1>
        <p class="catalog-desc">Select any formula to view its dermatological specifications, active ingredients, and complete details.</p>
      </div>
    </div>

    <input id="q" class="catalog-search" type="search" placeholder="Search formulas, skincare..." oninput="filterProducts(true)">

    <div class="catalog-filters" id="flt">
      <button type="button" class="filter-btn on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="filter-btn" onclick="setCategoryFilter('Skin Lab', this)">Skin Lab</button>
    </div>
    
    <div class="catalog-grid" id="pg">
      @forelse($skinProducts as $item)
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
                $slides = ['assets/website/skin/info.webp'];
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

            $detailUrl = url('/skin/show/' . $itemSlug);
            $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
            $itemCategory = $item->category ?? 'Skin Lab';
        @endphp

        <div class="catalog-card card pc" data-category="{{ $itemCategory }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Formula' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }} {{ $sIdx + 1 }}" width="300" height="300" loading="lazy">
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
                      <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }}" width="300" height="300" loading="lazy">
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
              <span class="meta-tag">{{ $item->dosage_spec ?? '100ml' }}</span>
              <span class="meta-tag">{{ $itemCategory }}</span>
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
      Novex Skin Lab formulations are crafted under strict laboratory standards for skin restoration, cellular protection, and daily rejuvenation.
    </p>
  </div>
</section>

<script src="{{ asset($skinShowJsPath) }}?v={{ $skinShowJsVer }}"></script>
@endsection