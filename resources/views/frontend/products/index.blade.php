@extends('frontend.home.index')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap');

  :root {
    --bg:#FFFFFF;--bg2:#E9F2FA;--ink:#1E2D3B;--mut:#5A6F82;--green:#2F6F9F;
    --line:#D2E2EF;--card:#F6FAFD;--gold:#3F84B5;--red:#e11d48;
    --serif:'Cormorant Garamond',Georgia,serif;--sans:'Inter',system-ui,sans-serif;
  }

  .hero, .hero.sl, .mq, #lab-reports, #testimonies, .camp, .steps, .art, .g6, .div2,
  section.sec:not(#cat) {
    display: none !important;
  }

  #cat {
    display: block !important;
    padding: 60px 0 80px !important;
    background: var(--bg) !important;
    min-height: 80vh;
  }
  #cat .wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #cat h1 {
    font-family: var(--serif);
    font-weight: 500;
    line-height: 1.15;
    font-size: clamp(36px, 5vw, 60px);
    color: var(--ink);
  }
  #cat .head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 28px;
    gap: 20px;
    flex-wrap: wrap;
  }
  #cat .head>div {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-width: 720px;
  }
  #cat .head p {
    font-size: 15px;
    color: var(--mut);
    line-height: 1.6;
  }

  .sq {
    display: block;
    width: 100%;
    max-width: 360px;
    padding: 11px 16px;
    border: 1px solid var(--line);
    background: var(--card);
    border-radius: 999px;
    margin-bottom: 20px;
    font: inherit;
    font-size: 13px;
    color: var(--ink);
    outline: none;
    transition: border-color .2s ease;
  }
  .sq::placeholder { color: var(--mut); }
  .sq:focus { border-color: var(--green); }

  .filter {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 32px;
    font-size: 13px;
  }
  .filter button {
    background: none;
    border: 1px solid var(--line);
    padding: 7px 18px;
    color: var(--ink);
    border-radius: 999px;
    cursor: pointer;
    font-weight: 500;
    transition: all .2s;
  }
  .filter button:hover {
    background: var(--bg2);
    border-color: var(--gold);
  }
  .filter button.on {
    background: var(--green);
    color: #fff;
    border-color: var(--green);
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
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 26px;
    transition: transform .3s, box-shadow .3s;
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
    background: #ffffff;
    border: 1px solid rgba(210,226,239,.5);
    overflow: hidden;
  }

  .prod-slider {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: inherit;
    background: #fff;
  }
  .prod-slides {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    overflow: hidden;
    background: #fff;
  }
  .prod-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity .65s ease-in-out;
    pointer-events: none;
    border-radius: inherit;
    overflow: hidden;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
  }
  .prod-slide.active {
    opacity: 1 !important;
    pointer-events: auto !important;
  }
  .prod-slide img {
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 14px;
    display: block;
    background: #fff;
  }

  .ps-dots {
    position: absolute;
    bottom: 8px;
    left: 0;
    right: 0;
    z-index: 5;
    display: flex;
    justify-content: center;
    gap: 6px;
  }
  .ps-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(47,111,159,.25);
    cursor: pointer;
    transition: all .3s ease;
  }
  .ps-dot.active {
    background: var(--green);
    transform: scale(1.25);
  }

  .pc .b {
    text-align: left;
    align-items: stretch;
    padding: 16px 8px 8px;
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

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1>Shop Catalog</h1>
        <p>Select any product to view its batch specifications, dosage options, stock availability, and full profile.</p>
      </div>
    </div>

    <input id="q" class="sq" type="search" placeholder="Search products, serums or apparel..." oninput="filterProducts()">

    <div class="filter" id="flt">
      <button type="button" class="on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" onclick="setCategoryFilter('Weight Management', this)">Weight Management</button>
      <button type="button" onclick="setCategoryFilter('Skincare Peptides', this)">Skincare Peptides</button>
      <button type="button" onclick="setCategoryFilter('Skincare Collection', this)">Skincare Collection</button>
      <button type="button" onclick="setCategoryFilter('Performance', this)">Performance</button>
      <button type="button" onclick="setCategoryFilter('Apparel', this)">Apparel</button>
    </div>
    
    <div class="g4" id="pg">
      @php
          $allProducts = \Illuminate\Support\Facades\DB::select(
              "SELECT * FROM products 
               WHERE (page_type != 'accessory' OR page_type IS NULL OR page_type = '') 
                 AND (category NOT IN ('Accessory', 'Injection Kit', 'Syringes') OR category IS NULL) 
               ORDER BY id DESC"
          );
      @endphp

      @forelse($allProducts as $item)
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
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));
        @endphp

        <div class="card pc" data-category="{{ $item->category ?? 'Weight Management' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="ph">
            @if(count($slides) > 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <img src="{{ asset($imgSrc) }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy">
                    </div>
                  @endforeach
                </div>
                <div class="ps-dots">
                  @foreach($slides as $sIdx => $imgSrc)
                    <span class="ps-dot {{ $sIdx === 0 ? 'active' : '' }}" onclick="setCardSlideCatalog(this, {{ $sIdx }})"></span>
                  @endforeach
                </div>
              </div>
            @elseif(count($slides) === 1)
              <div class="prod-slider">
                <div class="prod-slides">
                  <div class="prod-slide active">
                    <img src="{{ asset($slides[0]) }}" alt="{{ $item->title }}" loading="lazy">
                  </div>
                </div>
              </div>
            @else
              <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg2);color:var(--green);font-family:var(--serif);font-size:68px;font-weight:600;border-radius:12px;user-select:none;">
                N
              </div>
            @endif
          </div>
          <div class="b">
            <h3>{{ $item->title }}</h3>
            @if(!empty($item->subtitle))
              <p class="s">{{ $item->subtitle }}</p>
            @endif
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $item->price }}</div>
            <div class="meta">
              <span>{{ $item->dosage_spec ?? 'Research grade' }}</span>
              <span>{{ $item->badge_category ?? 'Research grade' }}</span>
            </div>
            <a class="btn-details" href="{{ url('/products/' . $itemSlug) }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--mut);">
          No products currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" style="display:none;text-align:center;padding:48px 0;color:var(--mut)">
      <p style="font-size:16px">No products match your search or filter.</p>
    </div>

    <p style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:36px;padding-top:16px">
      Research chemicals are sold for in-vitro and laboratory research use only. Topical serums, creams, and merchandise items are formulated for daily cosmetic and athletic use.
    </p>
  </div>
</section>

<script>
let activeCategory = 'All';

function setCategoryFilter(cat, btn){
  activeCategory = cat;
  document.querySelectorAll('#flt button').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  filterProducts();
}

function setCardSlideCatalog(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const slider = dot.closest('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = slider.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

function filterProducts(){
  const query = (document.getElementById('q')?.value || '').trim().toLowerCase();
  const cards = document.querySelectorAll('#pg .card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cardCat = card.getAttribute('data-category');
    const cardKeywords = card.getAttribute('data-keywords') || '';
    const textContent = card.innerText.toLowerCase();

    const matchesCategory = (activeCategory === 'All') || (cardCat === activeCategory);
    const matchesSearch = !query || cardKeywords.includes(query) || textContent.includes(query);

    if(matchesCategory && matchesSearch){
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  const noMatch = document.getElementById('noMatchMsg');
  if(noMatch){
    noMatch.style.display = visibleCount === 0 ? 'block' : 'none';
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const catSec = document.getElementById('cat');
  const footerEl = document.querySelector('footer');
  if (catSec && footerEl && footerEl.parentNode) {
    footerEl.parentNode.insertBefore(catSec, footerEl);
  }
});
</script>
@endsection