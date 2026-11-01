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

// HANYA MENGAMBIL PRODUK PERFORMANCE SAHAJA
$performanceProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'performance' 
        OR category = 'Performance Apparel' 
        OR slug IN ('nx-polo-navy', 'polo', 'half-zip-polo') 
     ORDER BY id DESC"
);
@endphp

<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap');

  :root {
    --bg:#FFFFFF;--bg2:#E9F2FA;--ink:#1E2D3B;--mut:#5A6F82;--green:#2F6F9F;
    --line:#D2E2EF;--card:#F6FAFD;--card-surface:#FFFFFF;--gold:#3F84B5;--red:#e11d48;
    --serif:'Cormorant Garamond',Georgia,serif;--sans:'Inter',system-ui,sans-serif;
  }

  [data-theme="dark"] {
    --bg:#0A111A;--bg2:#101B27;--ink:#F0F6FC;--mut:#8EA4B8;--green:#327BB3;
    --line:#1C2D3E;--card:#0E1824;--card-surface:#132232;--gold:#5CA5DA;
  }

  #view-performance-division {
    display: block !important;
    width: 100%;
  }

  /* HERO BANNER SECTION */
  #view-performance-division .hero {
    position: relative;
    height: calc(100vh - var(--off, 110px));
    height: calc(100svh - var(--off, 110px));
    min-height: 520px;
    overflow: hidden;
    color: #fff !important;
    display: flex;
    align-items: center;
  }
  #view-performance-division .hero picture,
  #view-performance-division .hero picture img,
  #view-performance-division .hero>img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    filter: saturate(1.08) brightness(1.05);
    display: block;
  }
  #view-performance-division .hero:before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(90deg, rgba(10,17,26,.82), rgba(10,17,26,.25) 75%);
  }
  #view-performance-division .hero .wrap {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #view-performance-division .hero .in {
    max-width: 580px;
  }
  #view-performance-division .hero h1 {
    font-size: clamp(34px, 5.5vw, 72px);
    color: #FFFFFF !important;
    font-family: var(--serif);
    font-weight: 500;
    line-height: 1.15;
  }
  #view-performance-division .hero p {
    max-width: 480px;
    margin: 18px 0 28px;
    font-size: 16px;
    line-height: 1.6;
    opacity: .95;
    color: #FFFFFF !important;
  }
  #view-performance-division .hero .btn {
    background: #FFFFFF !important;
    color: var(--green) !important;
    border-radius: 999px;
    padding: 12px 28px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .04em;
    display: inline-block;
    text-align: center;
    transition: all .2s ease;
    text-decoration: none;
  }
  #view-performance-division .hero .btn:hover {
    background: #E9F2FA !important;
    color: #245a82 !important;
  }

  /* MARQUEE BAR */
  #view-performance-division .mq {
    overflow: hidden;
    border-block: 1px solid var(--line);
    border-top: none;
    background: var(--card);
    white-space: nowrap;
    margin: 0;
    transition: background-color .25s ease, border-color .25s ease;
  }
  #view-performance-division .mq div {
    display: inline-flex;
    gap: 46px;
    padding: 17px 0;
    animation: perfMq 34s linear infinite;
    font: italic 500 22px var(--serif);
    color: var(--ink);
  }
  #view-performance-division .mq span:after {
    content: "✦";
    font-style: normal;
    font-size: 11px;
    color: var(--gold);
    margin-left: 46px;
  }
  @keyframes perfMq {
    to { transform: translateX(-50%); }
  }

  /* SIGNATURE SHOWCASE GRID STYLING (.nxg) */
  .nxg {
    display: flex;
    flex-direction: column;
    gap: 48px;
  }
  .nxg-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 20px;
    flex-wrap: wrap;
  }
  .nxg-head h2 {
    font-family: var(--serif);
    font-size: clamp(28px, 4vw, 42px);
    color: var(--ink);
    line-height: 1.15;
  }
  .nxg-head p {
    color: var(--mut);
    margin-top: 8px;
    max-width: 520px;
    font-size: 15px;
    line-height: 1.6;
  }
  .nxg-grid {
    display: grid;
    gap: 28px 22px;
  }
  .nxg-grid.c4 {
    grid-template-columns: repeat(4, 1fr);
  }
  .nxg-grid.c3 {
    grid-template-columns: repeat(3, 1fr);
  }
  .nxg-fig {
    margin: 0;
    min-width: 0;
  }
  .nxg-ph {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    border: 1px solid var(--line);
    background: #f6f8fa;
    display: block;
  }
  [data-theme="dark"] .nxg-ph {
    background: #101B27;
  }
  .nxg-ph.rA {
    aspect-ratio: 369/327;
  }
  .nxg-ph.rB {
    aspect-ratio: 16/10;
  }
  .nxg-ph.rC {
    aspect-ratio: 4/3;
    background: #f8f8f8;
  }
  [data-theme="dark"] .nxg-ph.rC {
    background: #0E1824;
  }
  .nxg-ph.rC img {
    inset: 9%;
    width: 82%;
    height: 82%;
    object-fit: contain;
  }
  .nxg-ph img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
    display: block;
  }
  .nxg-fig:hover .nxg-ph img {
    transform: scale(1.03);
  }
  .nxg-cap {
    margin-top: 12px;
  }
  .nxg-cap b {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
  }
  .nxg-cap small {
    display: block;
    font-size: 13px;
    color: var(--mut);
    margin-top: 2px;
  }
  .nxg-title {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: -12px;
  }
  .nxg-title h3 {
    font-family: var(--serif);
    font-size: clamp(22px, 2.6vw, 30px);
    white-space: nowrap;
    color: var(--ink);
  }
  .nxg-title:after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--line);
  }
  @media(max-width: 900px){
    .nxg { gap: 40px; }
    .nxg-grid.c4, .nxg-grid.c3 { grid-template-columns: repeat(2, 1fr); }
  }
  @media(max-width: 640px){
    .nxg-grid { gap: 22px 14px; }
    .nxg-ph { border-radius: 16px; }
    .nxg-cap b { font-size: 13px; }
    .nxg-cap small { font-size: 12px; }
  }

  /* PERFORMANCE PRODUCTS SECTION (WARNA LATAR ASAL --BG2) */
  #perf-signature {
    padding: 70px 0 80px !important;
    background: var(--bg2) !important;
    scroll-margin-top: 80px;
  }
  #perf-signature .wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #perf-signature .head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 32px;
    gap: 20px;
    flex-wrap: wrap;
  }
  #perf-signature .head h2 {
    font-family: var(--serif);
    font-size: clamp(28px, 4vw, 42px);
    color: var(--ink);
    line-height: 1.15;
  }
  #perf-signature .head p {
    font-size: 15px;
    color: var(--mut);
    line-height: 1.6;
    margin-top: 6px;
  }

  /* GRID 4 LAJUR */
  .g4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
  }
  @media (max-width: 1024px) {
    .g4 { grid-template-columns: repeat(3, 1fr); }
  }
  @media (max-width: 768px) {
    .g4 { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  }
  @media (max-width: 520px) {
    .g4 { grid-template-columns: 1fr; }
  }

  /* KAD PRODUK */
  .pc {
    padding: 14px;
    background: var(--card-surface);
    border: 1px solid var(--line);
    border-radius: 26px;
    transition: transform .3s, box-shadow .3s, background-color .25s ease, border-color .25s ease;
    display: flex;
    flex-direction: column;
  }
  .pc:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 44px -24px rgba(47,111,159,.5);
  }

  /* KOTAK GAMBAR PRODUK */
  #perf-signature .ph {
    aspect-ratio: 1 !important;
    border-radius: 20px !important;
    border: 1px solid var(--line) !important;
    background: #FAFAFC !important;
    overflow: hidden !important;
    padding: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    position: relative !important;
  }
  [data-theme="dark"] #perf-signature .ph {
    background: #0E1824 !important;
  }

  /* SISTEM SLAID GAMBAR TERATUR */
  #perf-signature .prod-slider,
  #perf-signature .prod-slides {
    position: relative !important;
    width: 100% !important;
    height: 100% !important;
    overflow: hidden !important;
    border-radius: inherit !important;
    background: transparent !important;
  }

  #perf-signature .prod-slide {
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: opacity .45s ease-in-out, visibility .45s ease-in-out !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: hidden !important;
    border-radius: inherit !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    pointer-events: none !important;
    z-index: 1 !important;
    background: transparent !important;
  }
  #perf-signature .prod-slide.active {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    z-index: 2 !important;
  }

  #perf-signature .prod-slide-link {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    text-decoration: none !important;
    cursor: pointer !important;
  }
  #perf-signature .prod-slide img {
    width: auto !important;
    height: auto !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: contain !important;
    object-position: center !important;
    border-radius: 14px !important;
    display: block;
    background: transparent;
  }

  .pc .ps-dots {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    margin-bottom: 2px;
    z-index: 5;
  }
  .pc .ps-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--line);
    cursor: pointer;
    transition: all .25s ease;
  }
  .pc .ps-dot:hover {
    background: var(--mut);
  }
  .pc .ps-dot.active {
    background: var(--green);
    width: 18px;
    border-radius: 999px;
    transform: none;
  }

  .pc .b {
    text-align: left;
    align-items: stretch;
    padding: 14px 8px 8px;
    gap: 8px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .pc h3 {
    font-size: 20px;
    line-height: 1.2;
    color: var(--ink);
    font-family: var(--serif);
  }
  .pc .s {
    font-size: 13px;
    color: var(--mut);
    line-height: 1.4;
    min-height: 36px;
  }
  .pc .meta {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: auto;
  }
  .pc .meta span {
    font-size: 11px;
    background: var(--bg);
    color: var(--ink);
    padding: 4px 10px;
    border-radius: 999px;
    border: 1px solid var(--line);
  }

  .btn-details {
    background: var(--green);
    color: #fff;
    padding: 12px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    margin-top: 10px;
    transition: background .2s;
    text-decoration: none;
    display: block;
  }
  .btn-details:hover {
    background: #245a82;
  }

  /* CTA BANNER COMPONENT */
  .nx-cta {
    --cta-rgb: 27, 68, 104;
    position: relative;
    display: flex;
    align-items: center;
    height: clamp(260px, 26vw, 380px);
    overflow: hidden;
    background: rgb(var(--cta-rgb));
  }
  [data-theme="dark"] .nx-cta {
    --cta-rgb: 11, 27, 43;
  }
  .nx-cta-img {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 70%;
  }
  .nx-cta-img img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
  }
  .nx-cta:after {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background: linear-gradient(90deg, rgba(var(--cta-rgb), 1) 0%, rgba(var(--cta-rgb), 1) 30%, rgba(var(--cta-rgb), .6) 37%, rgba(var(--cta-rgb), .2) 50%, rgba(var(--cta-rgb), .1) 100%);
  }
  .nx-cta-panel {
    position: relative;
    z-index: 2;
    width: 32%;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 32px clamp(24px, 4vw, 64px);
    color: #fff;
  }
  .nx-eyebrow {
    font: 600 11px var(--sans);
    letter-spacing: .28em;
    text-transform: uppercase;
    color: var(--gold);
    display: block;
  }
  .nx-cta-panel .nx-eyebrow {
    color: rgba(255, 255, 255, .75);
  }
  .nx-cta-panel h3 {
    color: #fff;
    font-family: var(--serif);
    font-size: clamp(26px, 2.9vw, 44px);
    font-weight: 500;
    line-height: 1.15;
  }
  .nx-cta-panel p {
    color: #fff;
    opacity: .9;
    font-size: 15px;
    line-height: 1.6;
  }
  @media (max-width: 900px) {
    .nx-cta {
      display: block;
      height: auto;
    }
    .nx-cta:after {
      display: none;
    }
    .nx-cta-img {
      position: relative;
      width: 100%;
      aspect-ratio: 2/1;
    }
    .nx-cta-img img {
      object-position: 60% center;
    }
    .nx-cta-img:after {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 65%;
      background: linear-gradient(180deg, rgba(var(--cta-rgb), 0), rgba(var(--cta-rgb), 1));
    }
    .nx-cta-panel {
      width: auto;
      min-width: 0;
      margin-top: -64px;
      padding: 0 24px 36px;
    }
  }
</style>

<div id="view-performance-division">
  <!-- HERO BANNER -->
  <section class="hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/performance/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/performance/hero.webp') }}" alt="Novex Performance Division" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap"><div class="in">
      <h1>Novex Performance<br>Division</h1>
      <p>Sport. Discipline. Performance. Lifestyle. Designed for movement, built for a higher standard.</p>
      <div style="display:flex;align-items:center;flex-wrap:wrap">
        <a class="btn" href="#perf-signature" onclick="document.getElementById('perf-signature').scrollIntoView({behavior:'smooth'});return false;">Explore Collection</a>
      </div>
    </div></div>
  </section>

  <!-- MARQUEE BAR -->
  <div class="mq"><div>
    <span>Sport</span><span>Discipline</span><span>Performance</span><span>Lifestyle</span><span>Padel</span><span>Train</span><span>Move</span><span>Explore</span>
    <span>Sport</span><span>Discipline</span><span>Performance</span><span>Lifestyle</span><span>Padel</span><span>Train</span><span>Move</span><span>Explore</span>
  </div></div>

  <!-- SIGNATURE SHOWCASE DETAILS -->
  <section class="sec"><div class="wrap">
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
                <img src="{{ $resolveImageUrl($gImg) }}" alt="{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
              </div>
              <figcaption class="nxg-cap"><b>{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}</b></figcaption>
            </figure>
          @endif
        @endforeach
      </div>

      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/collar.webp') }}" alt="Half zip collar" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Half zip collar</b><small>Premium polo</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/embroidery.webp') }}" alt="Signature embroidery" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Signature embroidery</b><small>3D embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/sleeve-label.webp') }}" alt="Sleeve label" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Sleeve label</b><small>Embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/fabric.webp') }}" alt="Premium polo fabric" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Premium polo fabric</b><small>Stretch piqu&eacute; mesh</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/shoulder-panel.webp') }}" alt="Shoulder panel" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Shoulder panel</b><small>Detail</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/side-panel.webp') }}" alt="Side panel" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Side panel</b><small>Detail</small></figcaption></figure>
      </div>

      <div class="nxg-title"><h3>Collar &amp; Sleeve Details</h3></div>
      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-top.webp') }}" alt="Collar top view" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Collar top view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-back.webp') }}" alt="Collar back view" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Collar back view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-left.webp') }}" alt="Sleeve left (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Sleeve left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-right.webp') }}" alt="Sleeve right (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Sleeve right (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-left.webp') }}" alt="Side panel left (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Side panel left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-right.webp') }}" alt="Side panel right (flat)" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div><figcaption class="nxg-cap"><b>Side panel right (flat)</b></figcaption></figure>
      </div>
    </div>
  </div></section>

  <!-- KOLEKSI PRODUK KHUSUS PERFORMANCE DIVISION -->
  <section class="sec alt" id="perf-signature">
    <div class="wrap">
      <div class="head">
        <div>
          <h2>Performance Collection</h2>
          <p>Engineered for high-intensity movement, athletic discipline, and daily comfort.</p>
        </div>
      </div>

      <div class="g4" id="pg">
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

          <div class="card pc" data-category="{{ $item->category ?? 'Performance' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph">
              @if(count($slides) > 1)
                <div class="prod-slider">
                  <div class="prod-slides">
                    @foreach($slides as $sIdx => $imgSrc)
                      @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                      <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                        <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Product' }}">
                          <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
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
                      <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Product' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
                      </a>
                    </div>
                  </div>
                </div>
              @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg2);color:var(--green);font-family:var(--serif);font-size:68px;font-weight:600;border-radius:12px;user-select:none;">
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

            <div class="b">
              <h3>{{ $item->title ?? 'Performance Product' }}</h3>
              @if(!empty($item->subtitle))
                <p class="s">{{ $item->subtitle }}</p>
              @endif
              <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $displayPrice }}</div>
              <div class="meta">
                <span>{{ $item->dosage_spec ?? 'Adult Fit' }}</span>
                <span>{{ $item->badge_category ?? $item->category ?? 'Performance' }}</span>
              </div>
              <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
            </div>
          </div>
        @empty
          <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--mut);">
            No performance products currently available.
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- CTA BANNER SECTION -->
  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/performance/cta.webp') }}" alt="More than sport" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=1800&q=80'">
    </div>
    <div class="nx-cta-panel">
      <span class="nx-eyebrow">Novex Performance Division</span>
      <h3>More than sport.</h3>
      <p>People. Discipline. Progress. A higher you.</p>
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