@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="Novex Performance Division | Technical Athletic Apparel"
    description="Sport, discipline, and performance lifestyle. Explore technical sportswear, signature unisex half zip polos, and athletic apparel engineered for movement."
    :canonical="url('/performance')"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Novex Performance Division',
        'url' => url('/performance'),
        'description' => 'Sport, discipline, and performance lifestyle. Explore technical sportswear, signature unisex half zip polos, and athletic apparel engineered for movement.'
    ]"
/>
@endsection

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

$perfCssPath = 'frontend/performance/performance.css';
$perfCssVer = file_exists(public_path($perfCssPath)) ? filemtime(public_path($perfCssPath)) : time();

$perfJsPath = 'frontend/performance/performance.js';
$perfJsVer = file_exists(public_path($perfJsPath)) ? filemtime(public_path($perfJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($perfCssPath) }}?v={{ $perfCssVer }}">

<div id="view-performance-division">
  <section class="performance-hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/performance/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/performance/hero.webp') }}" alt="Novex Performance Division" width="1800" height="700" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap">
      <div class="in">
        <h1>Novex Performance<br>Division</h1>
        <p>Sport. Discipline. Performance. Lifestyle. Designed for movement, built for a higher standard.</p>
        <div>
          <a class="btn-hero-explore" href="{{ url('/performance/show') }}">Explore Collection</a>
        </div>
      </div>
    </div>
  </section>

  <div class="mq">
    <div class="mq-inner">
      <span>Sport</span>
      <span>Discipline</span>
      <span>Performance</span>
      <span>Lifestyle</span>
      <span>Padel</span>
      <span>Train</span>
      <span>Move</span>
      <span>Explore</span>
      <span>Sport</span>
      <span>Discipline</span>
      <span>Performance</span>
      <span>Lifestyle</span>
      <span>Padel</span>
      <span>Train</span>
      <span>Move</span>
      <span>Explore</span>
    </div>
  </div>

  <section class="sec">
    <div class="wrap">
      <div class="nxg">
        <div class="nxg-head">
          <div>
            <h2>Signature Collection</h2>
            <p>Unisex half zip polo. Designed for movement, built for a higher standard.</p>
          </div>
        </div>

        <div class="nxg-grid c4">
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
              <figure class="nxg-fig">
                <div class="nxg-ph rA">
                  <img src="{{ $resolveImageUrl($gImg) }}" alt="{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}" width="400" height="400" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
                </div>
                <figcaption class="nxg-cap">
                  <b>{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}</b>
                </figcaption>
              </figure>
            @endif
          @endforeach
        </div>

        <div class="nxg-grid c3">
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/collar.webp') }}" alt="Half zip collar" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Half zip collar</b>
              <small>Premium polo</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/embroidery.webp') }}" alt="Signature embroidery" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Signature embroidery</b>
              <small>3D embroidery</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/sleeve-label.webp') }}" alt="Sleeve label" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Sleeve label</b>
              <small>Embroidery</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/fabric.webp') }}" alt="Premium polo fabric" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Premium polo fabric</b>
              <small>Stretch piqu&eacute; mesh</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/shoulder-panel.webp') }}" alt="Shoulder panel" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Shoulder panel</b>
              <small>Detail</small>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rB">
              <img src="{{ asset('assets/website/performance/side-panel.webp') }}" alt="Side panel" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Side panel</b>
              <small>Detail</small>
            </figcaption>
          </figure>
        </div>

        <div class="nxg-title">
          <h3>Collar &amp; Sleeve Details</h3>
        </div>

        <div class="nxg-grid c3">
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/collar-top.webp') }}" alt="Collar top view" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Collar top view</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/collar-back.webp') }}" alt="Collar back view" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Collar back view</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/sleeve-left.webp') }}" alt="Sleeve left (flat)" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Sleeve left (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/sleeve-right.webp') }}" alt="Sleeve right (flat)" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Sleeve right (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/side-panel-left.webp') }}" alt="Side panel left (flat)" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Side panel left (flat)</b>
            </figcaption>
          </figure>
          <figure class="nxg-fig">
            <div class="nxg-ph rC">
              <img src="{{ asset('assets/website/performance/side-panel-right.webp') }}" alt="Side panel right (flat)" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
            </div>
            <figcaption class="nxg-cap">
              <b>Side panel right (flat)</b>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </section>

  <section class="sec alt" id="perf-info">
    <div class="wrap">
      <div class="perf-info-grid">
        <div class="perf-info-media">
          <img src="{{ asset('assets/website/performance/info.webp') }}" alt="Performance Apparel Quality" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=1000&q=80'">
        </div>
        <div class="perf-info-body">
          <span class="perf-eyebrow">Engineered Performance</span>
          <h2 class="perf-title">Performance Collection</h2>
          <p class="perf-desc">Engineered for high-intensity movement, athletic discipline, and daily comfort. Discover our full line of performance apparel.</p>
          <div>
            <a href="{{ url('/performance/show') }}" class="btn-perf-shop">
              Shop Now &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/performance/cta.webp') }}" alt="More than sport" width="1800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=1800&q=80'">
    </div>
    <div class="nx-cta-panel">
      <span class="eyebrow">Novex Performance Division</span>
      <h3>More than sport.</h3>
      <p>People. Discipline. Progress. A higher you.</p>
    </div>
  </section>
</div>

<script src="{{ asset($perfJsPath) }}?v={{ $perfJsVer }}"></script>
@endsection