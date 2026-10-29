@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/premium/product1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    if (file_exists(public_path($path))) return asset($path);
    if (file_exists(public_path('uploads/products/' . basename($path)))) {
        return asset('uploads/products/' . basename($path));
    }
    if (file_exists(public_path('storage/' . ltrim($path, '/')))) {
        return asset('storage/' . ltrim($path, '/'));
    }
    return asset($path);
};

$dbProducts = \Illuminate\Support\Facades\DB::select(
    "SELECT * FROM products 
     WHERE page_type = 'premium' 
        OR category IN ('Premium Supplements', 'Supplements') 
     ORDER BY id DESC"
);

if (!empty($dbProducts)) {
    $premiumProducts = $dbProducts;
} else {
    $premiumProducts = [
        (object)[
            'id' => 101,
            'title' => 'GLP-1',
            'subtitle' => 'Metabolic Support Formula',
            'price' => 'RM99.00',
            'dosage_spec' => '30 Capsules',
            'badge_category' => 'Dietary Supplement',
            'image' => 'assets/website/premium/product1.webp',
            'slug' => 'glp-1',
            'category' => 'Supplements',
            'keywords' => 'glp-1 metabolic capsules',
        ],
        (object)[
            'id' => 102,
            'title' => 'Glutathione',
            'subtitle' => 'Advanced Antioxidant Formula',
            'price' => 'RM89.00',
            'dosage_spec' => '30 Capsules',
            'badge_category' => 'Dietary Supplement',
            'image' => 'assets/website/premium/product2.webp',
            'slug' => 'glutathione',
            'category' => 'Supplements',
            'keywords' => 'glutathione antioxidant capsules',
        ],
        (object)[
            'id' => 103,
            'title' => 'Bundle Pack',
            'subtitle' => '2 Bottle GLP-1 & 2 Bottle Glutathione',
            'price' => 'RM200.00',
            'dosage_spec' => '4 Bottles (120 Capsules)',
            'badge_category' => 'Dietary Supplement',
            'image' => 'assets/website/premium/product3.webp',
            'slug' => 'bundle-pack',
            'category' => 'Supplements',
            'keywords' => 'bundle pack glp-1 glutathione',
        ],
    ];
}
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
  }

  #sup-formulas {
    padding: 70px 0 80px !important;
    background: var(--bg);
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
  }
  #sup-formulas .head p {
    font-size: 15px;
    color: var(--mut);
    line-height: 1.6;
    margin-top: 6px;
  }

  .g3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 26px;
  }
  @media (max-width: 960px) {
    .g3 { grid-template-columns: repeat(2, 1fr); gap: 20px; }
  }
  @media (max-width: 600px) {
    .g3 { grid-template-columns: 1fr; }
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
    aspect-ratio: 1;
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

  .prod-slider {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: inherit;
    background: var(--card-surface);
  }
  .prod-slides {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    overflow: hidden;
    background: var(--card-surface);
  }
  .prod-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity .65s ease-in-out;
    padding: 14px;
    margin: 0;
    overflow: hidden;
    border-radius: inherit;
    background: var(--card-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .prod-slide.active {
    opacity: 1 !important;
    pointer-events: auto !important;
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
</style>

<div id="view-premium-supplements">
  <section class="hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/premium/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/premium/hero.webp') }}" alt="Novex Premium Supplements" loading="lazy">
    </picture>
    <div class="wrap"><div class="in">
      <h1>Novex Premium<br>Supplements</h1>
      <p>Science-driven nutrition for a healthier, stronger and better you.</p>
      <div style="display:flex;align-items:center;flex-wrap:wrap">
        <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
        <a class="btn line" href="#" onclick="document.getElementById('sup-formulas').scrollIntoView({behavior:'smooth'});return false;">Our Formulas</a>
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
          <p>Premium formulas and a value bundle for metabolic support, antioxidant care and everyday wellness.</p>
        </div>
        <a class="btn line" href="{{ route('products.index') }}">View all</a>
      </div>

      <div class="g3" id="pg">
        @forelse($premiumProducts as $item)
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
                  $slides = ['assets/website/premium/product1.webp'];
              }

              $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                  ? $item->slug
                  : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));
          @endphp

          <div class="card pc" data-category="{{ $item->category ?? 'Supplements' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph">
              @if(count($slides) > 1)
                <div class="prod-slider">
                  <div class="prod-slides">
                    @foreach($slides as $sIdx => $imgSrc)
                      <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                        <img src="{{ $resolveImageUrl($imgSrc) }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
                      </div>
                    @endforeach
                  </div>
                </div>
              @elseif(count($slides) === 1)
                <div class="prod-slider">
                  <div class="prod-slides">
                    <div class="prod-slide active">
                      <img src="{{ $resolveImageUrl($slides[0]) }}" alt="{{ $item->title }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
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
                <span>{{ $item->dosage_spec ?? '30 Capsules' }}</span>
                <span>{{ $item->badge_category ?? 'Dietary Supplement' }}</span>
              </div>
              <a class="btn-details" href="{{ url('/products/' . $itemSlug) }}">See Details</a>
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
      <div class="g2 nx-quality" style="margin-top:0">
        <div class="ph"><img src="{{ asset('assets/website/premium/info.webp') }}" alt="Quality controlled laboratory" loading="lazy"></div>
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
      <img src="{{ asset('assets/website/premium/cta.webp') }}" alt="A Healthier, Stronger You" loading="lazy">
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
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}
</script>
@endsection