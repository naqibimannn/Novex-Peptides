@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (!is_string($path) || empty($path)) {
        return asset('assets/website/performance/front-view.webp');
    }
    if (filter_var($path, FILTER_VALIDATE_URL)) {
        return $path;
    }

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
@endphp

<div id="view-performance-division" class="block w-full">
  <section class="hero relative min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/performance/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/performance/hero.webp') }}" alt="Novex Performance Division" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1800&q=80'" class="absolute inset-0 w-full h-full object-cover object-top filter saturate-[1.08] brightness-[1.05] block">
    </picture>
    <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
      <div class="in max-w-[580px]">
        <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Novex Performance<br>Division</h1>
        <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Sport. Discipline. Performance. Lifestyle. Designed for movement, built for a higher standard.</p>
        <div class="flex items-center flex-wrap">
          <a class="btn inline-block bg-white text-[#2F6F9F] dark:text-[#327BB3] hover:bg-[#E9F2FA] hover:text-[#245a82] rounded-full py-3 px-7 text-[13px] font-semibold tracking-[0.04em] text-center transition-all duration-200 no-underline" href="#perf-signature" onclick="document.getElementById('perf-signature').scrollIntoView({behavior:'smooth'});return false;">Explore Collection</a>
        </div>
      </div>
    </div>
  </section>

  <div class="mq overflow-hidden border-b border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] whitespace-nowrap m-0 transition-colors duration-200">
    <div class="inline-flex gap-11 py-[17px] animate-mq font-serif italic font-medium text-[22px] text-[#1E2D3B] dark:text-[#F0F6FC]">
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Sport</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Discipline</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Performance</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Lifestyle</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Padel</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Train</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Move</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Explore</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Sport</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Discipline</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Performance</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Lifestyle</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Padel</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Train</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Move</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Explore</span>
    </div>
  </div>

  <section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
    <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
      <div class="nxg flex flex-col gap-10 min-[901px]:gap-12">
        <div class="nxg-head flex justify-between items-end gap-5 flex-wrap">
          <div>
            <h2 class="font-serif text-[clamp(28px,4vw,42px)] text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.15] font-medium">Signature Collection</h2>
            <p class="text-[#5A6F82] dark:text-[#8EA4B8] mt-2 max-w-[520px] text-[15px] leading-[1.6]">Unisex half zip polo. Designed for movement, built for a higher standard.</p>
          </div>
        </div>

        <div class="nxg-grid c4 grid grid-cols-2 min-[901px]:grid-cols-4 gap-3.5 sm:gap-[22px] min-[901px]:gap-[28px_22px]">
          @php
              $viewCaps = ['Front view', 'Back view', 'Left side view', 'Right side view'];
              $displayImgs = [
                  'assets/website/performance/front-view.webp',
                  'assets/website/performance/back-view.webp',
                  'assets/website/performance/left-side-view.webp',
                  'assets/website/performance/right-side-view.webp'
              ];
          @endphp
          @foreach($displayImgs as $gIdx => $gImg)
            @if($gIdx < 4)
              <figure class="nxg-fig group m-0 min-w-0">
                <div class="nxg-ph rA relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[369/327] block">
                  <img src="{{ $resolveImageUrl($gImg) }}" alt="{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
                </div>
                <figcaption class="nxg-cap mt-3">
                  <b class="block text-[13px] sm:text-e-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}</b>
                </figcaption>
              </figure>
            @endif
          @endforeach
        </div>

        <div class="nxg-grid c3 grid grid-cols-2 min-[901px]:grid-cols-3 gap-3.5 sm:gap-[22px] min-[901px]:gap-[28px_22px]">
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/collar.webp') }}" alt="Half zip collar" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Half zip collar</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">Premium polo</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/embroidery.webp') }}" alt="Signature embroidery" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Signature embroidery</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">3D embroidery</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/sleeve-label.webp') }}" alt="Sleeve label" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Sleeve label</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">Embroidery</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/fabric.webp') }}" alt="Premium polo fabric" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Premium polo fabric</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">Stretch piqu&eacute; mesh</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/shoulder-panel.webp') }}" alt="Shoulder panel" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Shoulder panel</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">Detail</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rB relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f6f8fa] dark:bg-[#101B27] aspect-[16/10] block">
              <img src="{{ asset('assets/website/performance/side-panel.webp') }}" alt="Side panel" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Side panel</b>
              <small class="block text-xs sm:text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-0.5">Detail</small>
            </figcaption>
          </figure>
        </div>

        <div class="nxg-title flex items-center gap-[18px] -mb-3 after:content-[''] after:flex-1 after:h-[1px] after:bg-[#D2E2EF] dark:after:bg-[#1C2D3E]">
          <h3 class="font-serif text-[clamp(22px,2.6vw,30px)] whitespace-nowrap text-[#1E2D3B] dark:text-[#F0F6FC]">Collar &amp; Sleeve Details</h3>
        </div>

        <div class="nxg-grid c3 grid grid-cols-2 min-[901px]:grid-cols-3 gap-3.5 sm:gap-[22px] min-[901px]:gap-[28px_22px]">
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/collar-top.webp') }}" alt="Collar top view" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Collar top view</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/collar-back.webp') }}" alt="Collar back view" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Collar back view</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/sleeve-left.webp') }}" alt="Sleeve left (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Sleeve left (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/sleeve-right.webp') }}" alt="Sleeve right (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Sleeve right (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/side-panel-left.webp') }}" alt="Side panel left (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Side panel left (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig group m-0 min-w-0">
            <div class="nxg-ph rC relative overflow-hidden rounded-2xl sm:rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#f8f8f8] dark:bg-[#0E1824] aspect-[4/3] block">
              <img src="{{ asset('assets/website/performance/side-panel-right.webp') }}" alt="Side panel right (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="absolute inset-[9%] w-[82%] h-[82%] object-contain transition-transform duration-500 ease-out group-hover:scale-[1.03] block">
            </div>
            <figcaption class="nxg-cap mt-3">
              <b class="block text-[13px] sm:text-[14px] font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.35]">Side panel right (flat)</b>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </section>

  <section class="sec alt pt-[70px] pb-20 bg-[#E9F2FA] dark:bg-[#101B27] scroll-mt-20 transition-colors duration-200" id="perf-signature">
    <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
      <div class="head flex justify-between items-end mb-8 gap-5 flex-wrap">
        <div>
          <h2 class="font-serif text-[clamp(28px,4vw,42px)] text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.15] font-medium">Performance Collection</h2>
          <p class="text-[15px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6] mt-1.5">Engineered for high-intensity movement, athletic discipline, and daily comfort.</p>
        </div>
      </div>

      <div class="g4 grid grid-cols-1 min-[521px]:grid-cols-2 min-[769px]:grid-cols-3 min-[1025px]:grid-cols-4 gap-4 min-[769px]:gap-6" id="pg">
        @forelse($performanceProducts as $item)
          @php
              $slides = [];
              if (!empty($item->image)) {
                  $decoded = json_decode($item->image, true);
                  if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                      $slides = array_values(array_filter($decoded, fn($p) => is_string($p) && !empty($p)));
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

              $detailUrl = url('/premium/' . $itemSlug);
              $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
          @endphp

          <div class="card pc p-3.5 bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[26px] transition-all duration-300 flex flex-col hover:-translate-y-1.5 hover:shadow-[0_24px_44px_-24px_rgba(47,111,159,0.5)]" data-category="{{ $item->category ?? 'Performance' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph aspect-square rounded-[20px] border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#FAFAFC] dark:bg-[#0E1824] overflow-hidden p-3 flex items-center justify-center relative">
              @if(count($slides) > 1)
                <div class="prod-slider relative w-full h-full overflow-hidden rounded-[inherit] bg-transparent">
                  <div class="prod-slides relative w-full h-full rounded-[inherit] overflow-hidden bg-transparent">
                    @foreach($slides as $sIdx => $imgSrc)
                      @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                      <div class="prod-slide absolute inset-0 w-full h-full opacity-0 invisible transition-all duration-500 ease-in-out p-0 m-0 overflow-hidden rounded-[inherit] flex items-center justify-center pointer-events-none z-[1] bg-transparent {{ $sIdx === 0 ? 'active !opacity-100 !visible !pointer-events-auto !z-[2]' : '' }}">
                        <a href="{{ $detailUrl }}" class="prod-slide-link flex items-center justify-center w-full h-full no-underline cursor-pointer" title="{{ $item->title ?? 'Product' }}">
                          <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="w-auto h-auto max-w-full max-h-full object-contain object-center rounded-[14px] block bg-transparent">
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              @elseif(count($slides) === 1)
                @php $currentImgUrl = $resolveImageUrl($slides[0]); @endphp
                <div class="prod-slider relative w-full h-full overflow-hidden rounded-[inherit] bg-transparent">
                  <div class="prod-slides relative w-full h-full rounded-[inherit] overflow-hidden bg-transparent">
                    <div class="prod-slide active absolute inset-0 w-full h-full !opacity-100 !visible !pointer-events-auto !z-[2] p-0 m-0 overflow-hidden rounded-[inherit] flex items-center justify-center bg-transparent">
                      <a href="{{ $detailUrl }}" class="prod-slide-link flex items-center justify-center w-full h-full no-underline cursor-pointer" title="{{ $item->title ?? 'Product' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'" class="w-auto h-auto max-w-full max-h-full object-contain object-center rounded-[14px] block bg-transparent">
                      </a>
                    </div>
                  </div>
                </div>
              @else
                <div class="w-full h-full flex items-center justify-center bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-serif text-[68px] font-semibold rounded-[12px] select-none">
                  N
                </div>
              @endif
            </div>

            @if(count($slides) > 1)
              <div class="ps-dots relative flex justify-center items-center gap-1.5 mt-2.5 mb-0.5 z-[5]">
                @foreach($slides as $sIdx => $imgSrc)
                  <span class="ps-dot w-[7px] h-[7px] rounded-full bg-[#D2E2EF] dark:bg-[#1C2D3E] cursor-pointer transition-all duration-250 hover:bg-[#5A6F82] {{ $sIdx === 0 ? 'active !bg-[#2F6F9F] dark:!bg-[#327BB3] !w-[18px]' : '' }}" onclick="setCardSlideCatalog(this, {{ $sIdx }})"></span>
                @endforeach
              </div>
            @endif

            <div class="b text-left items-stretch pt-3.5 px-2 pb-2 gap-2 flex flex-col flex-1">
              <h3 class="font-serif text-[20px] leading-[1.2] text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $item->title ?? 'Performance Product' }}</h3>
              @if(!empty($item->subtitle))
                <p class="s text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.4] min-h-[36px]">{{ $item->subtitle }}</p>
              @endif
              <div class="text-[17px] font-bold text-[#2F6F9F] dark:text-[#327BB3] mt-1">{{ $displayPrice }}</div>
              <div class="meta flex gap-1.5 flex-wrap mt-auto">
                <span class="text-[11px] bg-white dark:bg-[#0A111A] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $item->dosage_spec ?? 'Adult Fit' }}</span>
                <span class="text-[11px] bg-white dark:bg-[#0A111A] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $item->badge_category ?? $item->category ?? 'Performance' }}</span>
              </div>
              <a class="btn-details block w-full bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#245a82] dark:hover:bg-[#286391] text-white py-3 rounded-full text-[13px] font-semibold text-center mt-2.5 transition-colors duration-200 no-underline" href="{{ $detailUrl }}">See Details</a>
            </div>
          </div>
        @empty
          <div class="col-span-full text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8]">
            No performance products currently available.
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <section class="nx-cta relative flex items-center h-[clamp(260px,26vw,380px)] overflow-hidden bg-[#1B4468] dark:bg-[#0B1B2B] max-[900px]:block max-[900px]:h-auto after:content-[''] after:absolute after:inset-0 after:z-[1] after:pointer-events-none max-[900px]:after:hidden after:bg-[linear-gradient(90deg,#1B4468_0%,#1B4468_30%,rgba(27,68,104,0.6)_37%,rgba(27,68,104,0.2)_50%,rgba(27,68,104,0.1)_100%)] dark:after:bg-[linear-gradient(90deg,#0B1B2B_0%,#0B1B2B_30%,rgba(11,27,43,0.6)_37%,rgba(11,27,43,0.2)_50%,rgba(11,27,43,0.1)_100%)]">
    <div class="nx-cta-img absolute top-0 right-0 bottom-0 w-[70%] max-[900px]:relative max-[900px]:w-full max-[900px]:aspect-[2/1] max-[900px]:after:content-[''] max-[900px]:after:absolute max-[900px]:after:inset-x-0 max-[900px]:after:bottom-0 max-[900px]:after:h-[65%] max-[900px]:after:bg-gradient-to-t max-[900px]:after:from-[#1B4468] max-[900px]:after:to-transparent dark:max-[900px]:after:from-[#0B1B2B]">
      <img src="{{ asset('assets/website/performance/cta.webp') }}" alt="More than sport" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=1800&q=80'" class="absolute inset-0 w-full h-full object-cover object-center max-[900px]:object-[60%_center] block">
    </div>
    <div class="nx-cta-panel relative z-[2] w-[32%] min-w-[300px] flex flex-col gap-3 py-8 px-[clamp(24px,4vw,64px)] text-white max-[900px]:w-auto max-[900px]:min-w-0 max-[900px]:-mt-16 max-[900px]:pt-0 max-[900px]:px-6 max-[900px]:pb-9">
      <span class="nx-eyebrow text-white/75 font-sans font-semibold text-[11px] tracking-[0.28em] uppercase block">Novex Performance Division</span>
      <h3 class="text-white font-serif text-[clamp(26px,2.9vw,44px)] font-medium leading-[1.15]">More than sport.</h3>
      <p class="text-white/90 text-[15px] leading-[1.6]">People. Discipline. Progress. A higher you.</p>
    </div>
  </section>
</div>

<script>
function setCardSlideCatalog(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const card = dot.closest('.card') || dot.closest('.pc');
  if(!card) return;
  const slider = card.querySelector('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  
  slides.forEach((s, i) => {
    s.classList.toggle('active', i === idx);
  });
  dots.forEach((d, i) => {
    d.classList.toggle('active', i === idx);
  });
}
</script>
@endsection