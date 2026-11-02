@extends('frontend.home.index')

@section('content')
@php
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
      @php
          $allAccessories = \Illuminate\Support\Facades\DB::select(
              "SELECT * FROM products 
               WHERE page_type = 'accessory' 
                  OR category IN ('Accessory', 'Injection Kit', 'Syringes') 
               ORDER BY id DESC"
          );
      @endphp

      @forelse($allAccessories as $item)
        @php
            $slides = [];
            if (!empty($item->image)) {
                $decoded = json_decode($item->image, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $slides = array_values(array_filter($decoded, fn($p) => !empty($p) && (file_exists(public_path($p)) || file_exists(public_path('uploads/products/' . basename($p))))));
                } elseif (file_exists(public_path($item->image))) {
                    $slides = [$item->image];
                }
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('accessory-' . $item->id));

            $detailUrl = \Illuminate\Support\Facades\Route::has('accessory.show') 
                ? route('accessory.show', $itemSlug) 
                : url('/accessory/' . $itemSlug);
        @endphp

        <div class="catalog-card card pc" data-category="{{ $item->category ?? 'Accessory' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="card-ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                        <img src="{{ asset($imgSrc) }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy">
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @elseif(count($slides) === 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  <div class="prod-slide active">
                    <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                      <img src="{{ asset($slides[0]) }}" alt="{{ $item->title }}" loading="lazy">
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