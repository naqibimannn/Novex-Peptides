@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/premium/product1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

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

<section class="sec block pt-[60px] pb-20 bg-white dark:bg-[#0A111A] min-h-[80vh] transition-colors duration-200" id="cat">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-7 gap-5 flex-wrap">
      <div class="flex flex-col gap-2 max-w-[720px]">
        <a href="{{ url('/premium') }}" class="text-[12px] font-semibold text-[#2F6F9F] dark:text-[#327BB3] hover:underline mb-1 inline-flex items-center gap-1.5 no-underline">
          <span aria-hidden="true">&larr;</span> Back to Premium Supplements
        </a>
        <h1 class="font-serif font-medium leading-[1.15] text-[clamp(36px,5vw,60px)] text-[#1E2D3B] dark:text-[#F0F6FC]">Premium Formulas</h1>
        <p class="text-[15px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6]">Select any formula to view its dietary specifications, capsule count, stock availability, and complete details.</p>
      </div>
    </div>

    <input id="q" class="sq block w-full max-w-[360px] py-[11px] px-4 border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] rounded-full mb-5 text-[13px] text-[#1E2D3B] dark:text-[#F0F6FC] placeholder-[#5A6F82] dark:placeholder-[#8EA4B8] outline-none focus:border-[#2F6F9F] dark:focus:border-[#327BB3] transition-colors duration-200" type="search" placeholder="Search formulas, supplements..." oninput="filterProducts()">

    <div class="filter flex gap-2 flex-wrap mb-8 text-[13px]" id="flt">
      <button type="button" class="on bg-transparent border border-[#D2E2EF] dark:border-[#1C2D3E] py-[7px] px-[18px] text-[#1E2D3B] dark:text-[#F0F6FC] rounded-full cursor-pointer font-medium transition-all duration-200 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] [&.on]:!bg-[#2F6F9F] dark:[&.on]:!bg-[#327BB3] [&.on]:!text-white [&.on]:!border-[#2F6F9F] dark:[&.on]:!border-[#327BB3]" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" class="bg-transparent border border-[#D2E2EF] dark:border-[#1C2D3E] py-[7px] px-[18px] text-[#1E2D3B] dark:text-[#F0F6FC] rounded-full cursor-pointer font-medium transition-all duration-200 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] [&.on]:!bg-[#2F6F9F] dark:[&.on]:!bg-[#327BB3] [&.on]:!text-white [&.on]:!border-[#2F6F9F] dark:[&.on]:!border-[#327BB3]" onclick="setCategoryFilter('Premium Supplements', this)">Premium Supplements</button>
    </div>
    
    <div class="g4 grid grid-cols-1 min-[521px]:grid-cols-2 min-[769px]:grid-cols-3 min-[1025px]:grid-cols-4 gap-4 min-[769px]:gap-6" id="pg">
      @forelse($premiumProducts as $item)
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
                $slides = ['assets/website/premium/product1.webp'];
            }

            $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                ? $item->slug
                : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

            $detailUrl = url('/products/' . $itemSlug);
            $displayPrice = !empty($item->price) ? $item->price : ('RM' . number_format($item->price_val ?? 0, 2));
        @endphp

        <div class="card pc p-3.5 bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[26px] transition-all duration-300 flex flex-col hover:-translate-y-1.5 hover:shadow-[0_24px_44px_-24px_rgba(47,111,159,0.5)]" data-category="Premium Supplements" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
          <div class="ph aspect-square rounded-[20px] relative bg-white dark:bg-[#132232] border border-[#D2E2EF]/50 dark:border-[#1C2D3E] overflow-hidden">
            @if(count($slides) > 1)
              <div class="prod-slider relative w-full h-full overflow-hidden rounded-[inherit] bg-white dark:bg-[#132232]">
                <div class="prod-slides relative w-full h-full rounded-[inherit] overflow-hidden bg-white dark:bg-[#132232]">
                  @foreach($slides as $sIdx => $imgSrc)
                    @php $currentImgUrl = $resolveImageUrl($imgSrc); @endphp
                    <div class="prod-slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-700 ease-in-out pointer-events-none rounded-[inherit] overflow-hidden bg-white dark:bg-[#132232] flex items-center justify-center p-3 {{ $sIdx === 0 ? 'active !opacity-100 !pointer-events-auto' : '' }}">
                      <a href="{{ $detailUrl }}" class="prod-slide-link flex items-center justify-center w-full h-full no-underline cursor-pointer" title="{{ $item->title ?? 'Formula' }}">
                        <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }} {{ $sIdx + 1 }}" loading="lazy" class="w-auto h-auto max-w-full max-h-full object-contain rounded-[14px] block bg-white dark:bg-[#132232]">
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @elseif(count($slides) === 1)
              @php $currentImgUrl = $resolveImageUrl($slides[0]); @endphp
              <div class="prod-slider relative w-full h-full overflow-hidden rounded-[inherit] bg-white dark:bg-[#132232]">
                <div class="prod-slides relative w-full h-full rounded-[inherit] overflow-hidden bg-white dark:bg-[#132232]">
                  <div class="prod-slide active absolute inset-0 w-full h-full !opacity-100 !pointer-events-auto rounded-[inherit] overflow-hidden bg-white dark:bg-[#132232] flex items-center justify-center p-3">
                    <a href="{{ $detailUrl }}" class="prod-slide-link flex items-center justify-center w-full h-full no-underline cursor-pointer" title="{{ $item->title ?? 'Formula' }}">
                      <img src="{{ $currentImgUrl }}" alt="{{ $item->title ?? 'Formula' }}" loading="lazy" class="w-auto h-auto max-w-full max-h-full object-contain rounded-[14px] block bg-white dark:bg-[#132232]">
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
            <h3 class="font-serif text-[20px] leading-[1.2] text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $item->title ?? 'Formula' }}</h3>
            @if(!empty($item->subtitle))
              <p class="s text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.4] min-h-[36px]">{{ $item->subtitle }}</p>
            @endif
            <div class="text-[17px] font-bold text-[#2F6F9F] dark:text-[#327BB3] mt-1">{{ $displayPrice }}</div>
            <div class="meta flex gap-1.5 flex-wrap mt-auto">
              <span class="text-[11px] bg-[#E9F2FA] dark:bg-[#101B27] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $item->dosage_spec ?? '30 Capsules' }}</span>
              <span class="text-[11px] bg-[#E9F2FA] dark:bg-[#101B27] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">Premium Supplements</span>
            </div>
            <a class="btn-details block w-full bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#245a82] dark:hover:bg-[#286391] text-white py-3 rounded-full text-[13px] font-semibold text-center mt-2.5 transition-colors duration-200 no-underline" href="{{ $detailUrl }}">See Details</a>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8]">
          No formulas currently available in catalog.
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" class="hidden text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8]">
      <p class="text-base">No formulas match your search or filter.</p>
    </div>

    <p class="text-xs text-[#5A6F82] dark:text-[#8EA4B8] border-t border-[#D2E2EF] dark:border-[#1C2D3E] mt-9 pt-4">
      Novex Premium Supplements are manufactured under strict laboratory standards for health, antioxidant, and everyday wellness support.
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
  const card = dot.closest('.card') || dot.closest('.pc');
  if(!card) return;
  const slider = card.querySelector('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

function filterProducts(){
  const query = (document.getElementById('q')?.value || '').trim().toLowerCase();
  const cards = document.querySelectorAll('#pg .card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cardCat = card.getAttribute('data-category') || '';
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