@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (!is_string($path) || empty($path)) {
        return asset('assets/website/premium/product1.webp');
    }
    if (filter_var($path, FILTER_VALIDATE_URL)) {
        return $path;
    }

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

  #view-premium-supplements {
    display: block !important;
    width: 100%;
  }

  #view-premium-supplements .hero {
    position: relative;
    height: calc(100vh - var(--off, 110px));
    height: calc(100svh - var(--off, 110px));
    min-height: 520px;
    overflow: hidden;
    color: #fff !important;
    display: flex;
    align-items: center;
  }
  #view-premium-supplements .hero picture,
  #view-premium-supplements .hero picture img,
  #view-premium-supplements .hero>img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    filter: saturate(1.08) brightness(1.05);
    display: block;
  }
  #view-premium-supplements .hero:before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(90deg, rgba(10,17,26,.82), rgba(10,17,26,.25) 75%);
  }
  #view-premium-supplements .hero .wrap {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #view-premium-supplements .hero .in {
    max-width: 580px;
  }
  #view-premium-supplements .hero h1 {
    font-size: clamp(34px, 5.5vw, 72px);
    color: #FFFFFF !important;
    font-family: var(--serif);
    font-weight: 500;
    line-height: 1.15;
  }
  #view-premium-supplements .hero p {
    max-width: 480px;
    margin: 18px 0 28px;
    font-size: 16px;
    line-height: 1.6;
    opacity: .95;
    color: #FFFFFF !important;
  }
  #view-premium-supplements .hero .btn {
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
  #view-premium-supplements .hero .btn:hover {
    background: #E9F2FA !important;
    color: #245a82 !important;
  }

  #view-premium-supplements .mq {
    overflow: hidden;
    border-block: 1px solid var(--line);
    border-top: none;
    background: var(--card);
    white-space: nowrap;
    margin: 0;
    transition: background-color .25s ease, border-color .25s ease;
  }
  #view-premium-supplements .mq div {
    display: inline-flex;
    gap: 46px;
    padding: 17px 0;
    animation: supMq 34s linear infinite;
    font: italic 500 22px var(--serif);
    color: var(--ink);
  }
  #view-premium-supplements .mq span:after {
    content: "✦";
    font-style: normal;
    font-size: 11px;
    color: var(--gold);
    margin-left: 46px;
  }
  @keyframes supMq {
    to { transform: translateX(-50%); }
  }

  #sup-formulas {
    padding: 70px 0 80px !important;
    background: var(--bg);
    scroll-margin-top: 80px;
  }
  #sup-formulas .wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #sup-formulas .head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 32px;
    gap: 20px;
    flex-wrap: wrap;
  }
  #sup-formulas .head h2 {
    font-family: var(--serif);
    font-size: clamp(28px, 4vw, 42px);
    color: var(--ink);
    line-height: 1.15;
  }
  #sup-formulas .head p {
    font-size: 15px;
    color: var(--mut);
    line-height: 1.6;
    margin-top: 6px;
  }

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
  .pc .ph {
    aspect-ratio: 1 !important;
    border-radius: 20px;
    position: relative;
    background: var(--card-surface);
    border: 1px solid var(--line);
    overflow: hidden;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .prod-slider,
  .prod-slides {
    position: relative !important;
    width: 100% !important;
    height: 100% !important;
    overflow: hidden !important;
    border-radius: inherit !important;
    background: transparent !important;
  }
  .prod-slide {
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: opacity .45s ease-in-out, visibility .45s ease-in-out !important;
    padding: 12px;
    margin: 0;
    overflow: hidden;
    border-radius: inherit;
    background: var(--card-surface);
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    pointer-events: none !important;
    z-index: 1 !important;
  }
  .prod-slide.active {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    z-index: 2 !important;
  }
  .prod-slide-link {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    text-decoration: none !important;
    cursor: pointer !important;
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
    background: var(--bg2);
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

  .g2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
  }
  @media (max-width: 900px) {
    .g2 { grid-template-columns: 1fr; }
  }
  .nx-quality {
    margin-top: 0;
    align-items: center;
  }
  .nx-quality .ph {
    aspect-ratio: 4/3;
    border: 1px solid var(--line);
    border-radius: 24px;
    overflow: hidden;
    background: var(--card-surface);
  }
  .nx-quality .ph img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block;
  }
  .nx-q-body {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  .nx-eyebrow {
    font: 600 11px var(--sans);
    letter-spacing: .28em;
    text-transform: uppercase;
    color: var(--gold);
    display: block;
  }
  .nx-q-body h2 {
    font-family: var(--serif);
    font-size: clamp(28px, 4vw, 42px);
    color: var(--ink);
    line-height: 1.15;
  }
  .nx-q-body > p {
    color: var(--mut);
    font-size: 15px;
    line-height: 1.6;
  }
  .nx-q-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 6px;
  }
  .nx-q-list div {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--card-surface);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 14px 18px;
    transition: background-color .25s ease, border-color .25s ease;
  }
  .nx-q-list div:before {
    content: "✓";
    flex-shrink: 0;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--bg2);
    border: 1px solid var(--line);
    color: var(--green);
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .nx-q-list b {
    font-size: 13px;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: var(--ink);
  }

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

<div id="view-premium-supplements">
  <section class="hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/premium/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/premium/hero.webp') }}" alt="Novex Premium Supplements" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap"><div class="in">
      <h1>Novex Premium<br>Supplements</h1>
      <p>Science-driven nutrition for a healthier, stronger and better you.</p>
      <div style="display:flex;align-items:center;flex-wrap:wrap">
        <a class="btn" href="#sup-formulas" onclick="document.getElementById('sup-formulas').scrollIntoView({behavior:'smooth'});return false;">Shop Now</a>
      </div>
    </div></div>
  </section>

  <div class="mq"><div>
    <span>Science-driven nutrition</span><span>High purity ingredients</span><span>Quality assured</span><span>Manufactured with care</span><span>30 capsules</span><span>Dietary supplement</span>
    <span>Science-driven nutrition</span><span>High purity ingredients</span><span>Quality assured</span><span>Manufactured with care</span><span>30 capsules</span><span>Dietary supplement</span>
  </div></div>

  <section class="sec" id="sup-formulas">
    <div class="wrap">
      <div class="head">
        <div>
          <h2>Our Formulas</h2>
          <p>Premium formulas and specialized nutritional bundles for metabolic support, antioxidant care, and everyday wellness.</p>
        </div>
      </div>

      <div class="g4" id="pg">
        @forelse($premiumProducts as $item)
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
                  $slides = ['assets/website/premium/product1.webp'];
              }

              $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                  ? $item->slug
                  : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

              $detailUrl = url('/premium/' . $itemSlug);
              $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
          @endphp

          <div class="card pc" data-category="{{ $item->category ?? 'Supplements' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph">
              @if(count($slides) > 1)
                <div class="prod-slider">
                  <div class="prod-slides">
                    @foreach($slides as $sIdx => $imgSrc)
                      @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                      <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                        <a href="{{ $detailUrl }}" class="prod-slide-link" title="{{ $item->title ?? 'Product' }}">
                          <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
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
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Product' }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
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
              <h3>{{ $item->title ?? 'Untitled Formula' }}</h3>
              @if(!empty($item->subtitle))
                <p class="s">{{ $item->subtitle }}</p>
              @endif
              <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $displayPrice }}</div>
              <div class="meta">
                <span>{{ $item->dosage_spec ?? '30 Capsules' }}</span>
                <span>{{ $item->badge_category ?? 'Dietary Supplement' }}</span>
              </div>
              <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
            </div>
          </div>
        @empty
          <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--mut);">
            No formulas currently available.
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <section class="sec alt">
    <div class="wrap">
      <div class="g2 nx-quality">
        <div class="ph">
          <img src="{{ asset('assets/website/premium/info.webp') }}" alt="Quality controlled laboratory" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=80'">
        </div>
        <div class="nx-q-body">
          <span class="nx-eyebrow">Quality Promise</span>
          <h2>Premium Quality You Can Trust</h2>
          <p>Manufactured under strict quality control standards to ensure purity, safety and consistent performance.</p>
          <div class="nx-q-list">
            <div><b>High Purity Ingredients</b></div>
            <div><b>Quality Assured</b></div>
            <div><b>Manufactured With Care</b></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/premium/cta.webp') }}" alt="A Healthier, Stronger You" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1800&q=80'">
    </div>
    <div class="nx-cta-panel">
      <span class="nx-eyebrow">Novex Premium Supplements</span>
      <h3>A Healthier, Stronger You</h3>
      <p>Support your daily wellness, look better, feel better and perform at your best.</p>
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