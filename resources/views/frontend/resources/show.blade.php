@extends('frontend.home.index')

@section('content')
@php
    $articles = \Illuminate\Support\Facades\DB::select("SELECT * FROM resources ORDER BY id DESC");
    
    $resolveImageUrl = function($path) {
        if (empty($path)) return asset('assets/website/science/s1.webp');
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
        $clean = ltrim($path, '/');
        if (file_exists(public_path($clean))) return asset($clean) . '?v=' . filemtime(public_path($clean));
        if (file_exists(public_path('uploads/resources/' . basename($clean)))) {
            return asset('uploads/resources/' . basename($clean)) . '?v=' . time();
        }
        return asset($clean);
    };
@endphp

<section class="hero relative min-h-[480px] sm:min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
  <img id="heroImage" src="{{ asset('assets/website/resources/hero.webp') }}" href="{{ asset('assets/website/resources/hero.webp') }}" alt="Educational Resources" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05]">
  <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="in max-w-[580px]">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block text-white">Resources &amp; Literature</span>
      <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Read before you research</h1>
      <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
      <div>
        <h1 class="font-serif text-[32px] sm:text-[42px] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Educational Resources</h1>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px] mt-1.5 leading-[1.6]">Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
      </div>
    </div>
    
    <div class="g4 grid grid-cols-1 sm:grid-cols-2 min-[901px]:grid-cols-4 gap-6">
      @forelse($articles as $art)
        <a class="res-card group bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] overflow-hidden flex flex-col no-underline transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_24px_44px_-20px_rgba(47,111,159,0.35)] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA]" href="{{ url('/resources/' . $art->slug) }}">
          <div class="res-thumb w-full aspect-[16/10] overflow-hidden bg-white dark:bg-[#132232]">
            <img src="{{ $resolveImageUrl($art->image) }}" alt="{{ $art->title }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-105">
          </div>
          <div class="res-body p-[22px] flex flex-col flex-1">
            <h3 class="font-serif text-[20px] leading-[1.25] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200">{{ $art->title }}</h3>
            <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] my-2.5 mb-4 leading-[1.55] line-clamp-2">
              {{ $art->subtitle }}
            </p>
            <span class="text-xs font-semibold text-[#2F6F9F] dark:text-[#327BB3] mt-auto">Read Article &rarr;</span>
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8]">
          No educational resources currently published.
        </div>
      @endforelse
    </div>

    <div class="text-xs text-[#5A6F82] dark:text-[#8EA4B8] border-t border-[#D2E2EF] dark:border-[#1C2D3E] mt-10 pt-4">
      Educational content for research context only. It is not medical advice, diagnosis, or clinical recommendation.
    </div>
  </div>
</section>

<script>
function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/resources/hero-phone.webp') }}"
    : "{{ asset('assets/website/resources/hero.webp') }}";

  if (heroImg.getAttribute('src') !== targetUrl) {
    heroImg.setAttribute('src', targetUrl);
  }
  if (heroImg.getAttribute('href') !== targetUrl) {
    heroImg.setAttribute('href', targetUrl);
  }
}

const heroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (heroMediaQuery.addEventListener) {
  heroMediaQuery.addEventListener('change', updateHeroBanner);
} else if (heroMediaQuery.addListener) {
  heroMediaQuery.addListener(updateHeroBanner);
}
window.addEventListener('resize', updateHeroBanner);
document.addEventListener('DOMContentLoaded', updateHeroBanner);
updateHeroBanner();
</script>
@endsection