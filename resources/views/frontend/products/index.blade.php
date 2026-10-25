@extends('frontend.home.index')

@section('content')
<style>
.sq{
  display:block;
  width:100%;
  max-width:380px;
  padding:12px 18px;
  border:1px solid var(--line);
  background:var(--card);
  color:var(--ink);
  border-radius:999px;
  margin-bottom:16px;
  font:inherit;
  outline:none;
  transition:border-color .2s ease, background-color .25s ease, color .25s ease;
}
.sq::placeholder{color:var(--mut)}
.sq:focus{border-color:var(--green)}
.filter{
  display:flex;
  gap:8px;
  flex-wrap:wrap;
  margin-bottom:32px;
  font-size:13px;
}
.filter button{
  background:none;
  border:1px solid var(--line);
  padding:8px 18px;
  color:var(--ink);
  border-radius:999px;
  cursor:pointer;
  font-weight:500;
  transition:all .2s ease;
}
.filter button:hover{background:var(--bg2);border-color:var(--gold)}
.filter button.on{
  background:var(--green);
  color:#fff;
  border-color:var(--green);
}

.pc .ph{
  aspect-ratio:4/5;
  border-radius:20px;
  position:relative;
  background:var(--card-surface);
  border:1px solid var(--line);
  overflow:hidden;
  padding:10px;
  display:flex;
  align-items:center;
  justify-content:center;
}
.pc .ph img{
  max-width:100% !important;
  max-height:100% !important;
  width:auto !important;
  height:auto !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:12px !important;
  display:block;
  background:transparent;
}
.prod-slider{position:relative;width:100%;height:100%;overflow:hidden;border-radius:12px;background:var(--card-surface)}
.prod-slides{position:relative;width:100%;height:100%;border-radius:inherit;overflow:hidden;background:var(--card-surface)}
.prod-slide{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  opacity:0;
  transition:opacity .65s ease-in-out;
  padding:0;
  margin:0;
  overflow:hidden;
  border-radius:inherit;
  background:var(--card-surface);
  display:flex;
  align-items:center;
  justify-content:center;
}
.prod-slide.active{opacity:1;pointer-events:auto}
.prod-slide img{
  max-width:100% !important;
  max-height:100% !important;
  width:auto !important;
  height:auto !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:12px !important;
  display:block;
  background:transparent;
}
.ps-dots{position:absolute;bottom:6px;left:0;right:0;z-index:5;display:flex;justify-content:center;gap:6px}
.ps-dot{width:7px;height:7px;border-radius:50%;background:rgba(255,255,255,.75);cursor:pointer;transition:all .3s ease;box-shadow:0 1px 4px rgba(0,0,0,.4)}
.ps-dot.active{background:var(--green);transform:scale(1.25)}
</style>

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Shop Catalog</h1>
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
      <button type="button" onclick="setCategoryFilter('Accessory', this)">Accessory</button>
    </div>
    
    <div class="g4" id="pg">
      @php
          $allProducts = $catalogProducts ?? \Illuminate\Support\Facades\DB::select("SELECT * FROM products ORDER BY id DESC");
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
        @endphp

        <div class="card pc" data-category="{{ $item->category ?? 'Weight Management' }}" data-keywords="{{ strtolower($item->keywords ?? ($item->title . ' ' . $item->subtitle)) }}">
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
              <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg2);color:var(--green);font-family:var(--serif);font-size:68px;font-weight:600;border-radius:12px;user-select:none;transition:background-color .25s ease;">
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
            <a class="btn-details" href="{{ route('products.show', $item->slug) }}">See Details</a>
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
</script>
@endsection