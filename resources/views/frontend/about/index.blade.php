@extends('frontend.home.index')

@section('content')
@php
  $aboutPath = public_path('assets/website/about/about.webp');
  $aboutVer = file_exists($aboutPath) ? filemtime($aboutPath) : time();
  $aboutUrl = asset('assets/website/about/about.webp') . '?v=' . $aboutVer;
@endphp

<section class="hero relative min-h-[480px] sm:min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
  <img id="heroImage" src="{{ asset('assets/website/about/hero.webp') }}" href="{{ asset('assets/website/about/hero.webp') }}" alt="Our story" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1800&q=85'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05]">
  <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="in max-w-[580px]">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block text-white">Our story</span>
      <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">One question behind every vial</h1>
      <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Is it really what the label says? Novex was built to answer that clearly, with paper to back it up.</p>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
  <div class="wrap g2 max-w-[1200px] mx-auto px-4 sm:px-6 grid grid-cols-1 min-[901px]:grid-cols-2 gap-10 items-center">
    <div>
      <h1 class="font-serif text-[32px] sm:text-[42px] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC] mb-4">Why Novex Exists</h1>
      <p class="text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.7] mb-3.5 text-[15px]">Researchers buying peptides online kept running into the same problem: a certificate that could not be matched to the vial in their hand.</p>
      <p class="text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.7] text-[15px]">We started Novex as a sourcing desk that treats the batch number as the centre of everything.</p>
      <p class="mt-3.5 text-[#1E2D3B] dark:text-[#F0F6FC] font-medium leading-[1.7] text-[15px]">If we cannot test it, trace it and explain it in plain language, it does not go into our catalog.</p>
    </div>
    
    <a href="{{ $aboutUrl }}" onclick="if(typeof openLightboxModal === 'function'){ openLightboxModal('{{ $aboutUrl }}', 'Why Novex Exists'); return false; }" class="about-img-link group aspect-[4/3] w-full rounded-[24px] overflow-hidden border border-[#D2E2EF] dark:border-[#1C2D3E] bg-white dark:bg-[#132232] p-5 sm:p-8 cursor-pointer transition-all duration-300 ease-out hover:scale-[1.015] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] flex items-center justify-center">
      <img src="{{ $aboutUrl }}" alt="Why Novex Exists - Lab Research" onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800'" class="w-full h-full object-cover rounded-[16px] block">
    </a>
  </div>
</section>

<section class="sec alt py-[54px] min-[901px]:py-20 bg-[#E9F2FA] dark:bg-[#101B27] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
      <div class="flex flex-col gap-2 max-w-[720px]">
        <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">How we work</h2>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px]">Four habits that shape what we stock and how we ship it.</p>
      </div>
    </div>
    
    <div class="rows space-y-3">
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">01</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Source narrowly</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Each compound addition needs published literature and a supplier we can audit.</p>
      </div>
      
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">02</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Test outside</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Purity results come from a third-party laboratory and are tied to the lot printed on your vial.</p>
      </div>
      
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">03</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Keep it cold</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Storage and shipping are designed around temperature stability, using insulated packaging.</p>
      </div>
      
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">04</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Explain plainly</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Clear, direct communication regarding purity, research focus, and handling protocols.</p>
      </div>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] border-t border-[#D2E2EF] dark:border-[#1C2D3E] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <p class="pull font-serif italic font-medium text-[clamp(24px,3.6vw,44px)] leading-[1.25] max-w-[900px] mx-auto text-center text-[#1E2D3B] dark:text-[#F0F6FC]">
      “A good certificate is one you can match to the vial in your hand.”
      <small class="block font-sans not-italic font-semibold text-[11px] tracking-[0.24em] uppercase text-[#3F84B5] dark:text-[#5CA5DA] mt-5">THE NOVEX PRINCIPLE</small>
    </p>
  </div>
</section>

<script>
function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/about/hero-phone.webp') }}"
    : "{{ asset('assets/website/about/hero.webp') }}";

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