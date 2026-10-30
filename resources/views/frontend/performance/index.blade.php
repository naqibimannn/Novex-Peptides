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

// HANYA MENGAMBIL PRODUK PERFORMANCE SAHAJA (MENEPIS PRODUK LAIN DARI KATALOG)
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
  }

  /* LATAR BELAKANG ASAL SEKSYEN PRODUK (VAR --BG2) */
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
  }
  #perf-signature .head p {
    font-size: 15px;
    color: var(--mut);
    line-height: 1.6;
    margin-top: 6px;
  }

  /* GRID 4 LAJUR SEPADAN DENGAN FORMAT PRODUK CATALOG */
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

  /* WARNA LATAR BELAKANG ASAL BAGI KOTAK GAMBAR PRODUK */
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

  #perf-signature .prod-slider,
  #perf-signature .prod-slides,
  #perf-signature .prod-slide {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: inherit;
    background: transparent !important;
  }
  .prod-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity .65s ease-in-out;
    padding: 0;
    margin: 0;
    overflow: hidden;
    border-radius: inherit;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .prod-slide.active {
    opacity: 1 !important;
    pointer-events: auto !important;
  }
  .prod-slide-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    text-decoration: none;
    cursor: pointer;
  }
  .prod-slide img {
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
                <img src="{{ $resolveImageUrl($gImg) }}" alt="{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}" loading="lazy">
              </div>
              <figcaption class="nxg-cap"><b>{{ $viewCaps[$gIdx] ?? ('View ' . ($gIdx + 1)) }}</b></figcaption>
            </figure>
          @endif
        @endforeach
      </div>

      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/collar.webp') }}" alt="Half zip collar" loading="lazy"></div><figcaption class="nxg-cap"><b>Half zip collar</b><small>Premium polo</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/embroidery.webp') }}" alt="Signature embroidery" loading="lazy"></div><figcaption class="nxg-cap"><b>Signature embroidery</b><small>3D embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/sleeve-label.webp') }}" alt="Sleeve label" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve label</b><small>Embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/fabric.webp') }}" alt="Premium polo fabric" loading="lazy"></div><figcaption class="nxg-cap"><b>Premium polo fabric</b><small>Stretch piqu&eacute; mesh</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/shoulder-panel.webp') }}" alt="Shoulder panel" loading="lazy"></div><figcaption class="nxg-cap"><b>Shoulder panel</b><small>Detail</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/side-panel.webp') }}" alt="Side panel" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel</b><small>Detail</small></figcaption></figure>
      </div>

      <div class="nxg-title"><h3>Collar &amp; Sleeve Details</h3></div>
      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-top.webp') }}" alt="Collar top view" loading="lazy"></div><figcaption class="nxg-cap"><b>Collar top view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-back.webp') }}" alt="Collar back view" loading="lazy"></div><figcaption class="nxg-cap"><b>Collar back view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-left.webp') }}" alt="Sleeve left (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-right.webp') }}" alt="Sleeve right (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve right (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-left.webp') }}" alt="Side panel left (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-right.webp') }}" alt="Side panel right (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel right (flat)</b></figcaption></figure>
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
                      $slides = array_values(array_filter($decoded, fn($p) => !empty($p)));
                  } else {
                      $slides = [$item->image];
                  }
              }
              if (empty($slides)) {
                  $slides = ['assets/website/performance/front-view.webp'];
              }

              $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                  ? $item->slug
                  : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

              // Pautan kekal membawa parameter ?from=performance
              $detailUrl = url('/products/' . $itemSlug) . '?from=performance';
          @endphp

          <div class="card pc" data-category="{{ $item->category ?? 'Performance' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph">
              @if(count($slides) > 1)
                <div class="prod-slider">
                  <div class="prod-slides">
                    @foreach($slides as $sIdx => $imgSrc)
                      @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                      <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                        <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title }}">
                          <img src="{{ $currentImgUrl }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
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
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'">
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
              <h3>{{ $item->title }}</h3>
              @if(!empty($item->subtitle))
                <p class="s">{{ $item->subtitle }}</p>
              @endif
              <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $item->price }}</div>
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
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}
</script>
@endsection