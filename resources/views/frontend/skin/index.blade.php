@extends('frontend.home.index')

@section('content')
@php
    $img = fn ($f) => file_exists(public_path("images/skin-lab/$f")) ? asset("images/skin-lab/$f") : null;

    $ico = [
        'pores'     => '<path d="M3 11h5.5M15.5 11H21"/><path d="M12 3.5v6"/><path d="M9.2 11c0 3.2 1.2 6.5 2.8 6.5s2.8-3.3 2.8-6.5"/><path d="M7.2 11c0 4.6 2.1 8.5 4.8 8.5s4.8-3.9 4.8-8.5"/><circle cx="5" cy="14" r="0.7" fill="currentColor" stroke="none"/><circle cx="6.5" cy="17" r="0.7" fill="currentColor" stroke="none"/><circle cx="4.5" cy="18.5" r="0.7" fill="currentColor" stroke="none"/><circle cx="19" cy="14" r="0.7" fill="currentColor" stroke="none"/><circle cx="17.5" cy="17" r="0.7" fill="currentColor" stroke="none"/><circle cx="19.5" cy="18.5" r="0.7" fill="currentColor" stroke="none"/>',
        'brighten'  => '<path d="M8 4.5l1.1 2.9L12 8.5l-2.9 1.1L8 12.5l-1.1-2.9L4 8.5l2.9-1.1L8 4.5z"/><path d="M15.5 11.5l1.4 3.6 3.6 1.4-3.6 1.4-1.4 3.6-1.4-3.6-3.6-1.4 3.6-1.4 1.4-3.6z"/><path d="M18 4.5l.7 1.8 1.8.7-1.8.7-.7 1.8-.7-1.8-1.8-.7 1.8-.7.7-1.8z"/><circle cx="7.5" cy="17.5" r="1" fill="currentColor" stroke="none"/>',
        'oil'       => '<path d="M12 3.5c0 0 4.5 5.2 4.5 8.2a4.5 4.5 0 0 1-9 0c0-3 4.5-8.2 4.5-8.2z"/><path d="M10.2 11.8a2 2 0 0 0 1.8 1.8"/><path d="M4.5 18c1.8-1.5 3.6-1.5 5.4 0 1.8 1.5 3.6 1.5 5.4 0 1.4-1.2 2.8-1.4 4.2-.3"/><path d="M7 20.8c1.6-1.2 3.2-1.2 4.8 0 1.6 1.2 3.2 1.2 4.8 0"/>',
        'exfoliate' => '<path d="M4 14.8c2-1.6 3.6-1.6 5.4 0 1.8 1.6 3.6 1.6 5.4 0 1.8-1.6 3.4-1.6 5.2 0"/><path d="M4 18.5c2-1.6 3.6-1.6 5.4 0 1.8 1.6 3.6 1.6 5.4 0 1.8-1.6 3.4-1.6 5.2 0"/><circle cx="12" cy="9.5" r="1.6"/><circle cx="7" cy="10.5" r="0.9" fill="currentColor" stroke="none"/><circle cx="15.5" cy="6.8" r="0.8" fill="currentColor" stroke="none"/><circle cx="18" cy="10.2" r="0.9" fill="currentColor" stroke="none"/>',
        'purify'    => '<path d="M12 3.5l7 2.8v5.2c0 4.8-3 8.3-7 10-4-1.7-7-5.2-7-10V6.3l7-2.8z"/><path d="M12 9.5v5M9.5 12h5"/>',
        'smooth'    => '<path d="M4 8.5c2.6-1.6 5.2-1.6 7.8 0 2.6 1.6 5.2 1.6 8.2 0"/><path d="M4 12.5c2.6-1.6 5.2-1.6 7.8 0 2.6 1.6 5.2 1.6 8.2 0"/><path d="M4 16.5c2.6-1.6 5.2-1.6 7.8 0 2.6 1.6 5.2 1.6 8.2 0"/>',
    ];
    $svg = fn ($k, $c = 'w-7 h-7') => '<svg class="'.$c.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$ico[$k].'</svg>';

    $actives = [
        ['Glutathione', 'Help brighten and even skin tone', '#BBD3E6'],
        ['Vitamin C', 'Antioxidant care for a radiant look', '#D2E2EF'],
        ['AHA', 'Gently exfoliates dead skin cells', '#A9C9E0'],
        ['Mud Foam', 'Deep cleanses pores and removes impurities', '#B4C2CE'],
    ];

    $stats = [
        ['98', 'Agreed skin feels cleaner & fresher'],
        ['95', 'Noticed skin looks brighter'],
        ['93', 'Felt skin is smoother & healthier'],
    ];

    $benefits = [
        ['pores', 'Deeply<br>Cleanses Pores'],
        ['brighten', 'Brightens<br>Dull Skin'],
        ['oil', 'Controls<br>Excess Oil'],
        ['exfoliate', 'Gently<br>Exfoliates'],
        ['purify', 'Purifies<br>& Refines'],
        ['smooth', 'Keeps Skin<br>Smooth & Healthy'],
    ];

    $resolveTransform = function($name) {
        if (file_exists(public_path('assets/website/skin/' . $name))) {
            return asset('assets/website/skin/' . $name);
        }
        if (file_exists(public_path($name))) {
            return asset($name);
        }
        if (file_exists(public_path('images/skin-lab/' . $name))) {
            return asset('images/skin-lab/' . $name);
        }
        return asset('assets/website/skin/' . $name);
    };

    $transform1Url = $resolveTransform('transform1.webp');
    $transform2Url = $resolveTransform('transform2.webp');
@endphp

<div id="view-skin-lab" class="block w-full">
  <section class="hero relative min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/skin/hero-phone.webp') }}">
      <img id="heroImage" src="{{ asset('assets/website/skin/hero.webp') }}" href="{{ asset('assets/website/skin/hero.webp') }}" alt="Novex Skin Lab" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1800&q=80'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05] block">
    </picture>
    <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
      <div class="in max-w-[580px]">
        <span class="font-sans font-semibold text-[11px] tracking-[0.28em] uppercase text-[#5CA5DA] block mb-3">NOVEX SKIN LAB</span>
        <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white mb-8">Dermatology<br>crafted for<br>Asian skin</h1>
        <div class="flex items-center flex-wrap">
          <a class="btn inline-block bg-white text-[#2F6F9F] dark:text-[#327BB3] hover:bg-[#E9F2FA] hover:text-[#245a82] rounded-full py-3 px-7 text-[13px] font-semibold tracking-[0.04em] text-center transition-all duration-200 no-underline" href="#products">Explore Our Products</a>
        </div>
      </div>
    </div>
  </section>

  <div class="mq overflow-hidden border-b border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] whitespace-nowrap m-0 transition-colors duration-200">
    <div class="inline-flex gap-11 py-[17px] animate-mq font-serif italic font-medium text-[22px] text-[#1E2D3B] dark:text-[#F0F6FC]">
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Science-Backed Formulation</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Gentle &amp; Effective for Daily Use</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Suitable for All Skin Types</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Dermatology Inspired Care</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Science-Backed Formulation</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Gentle &amp; Effective for Daily Use</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Suitable for All Skin Types</span>
      <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Dermatology Inspired Care</span>
    </div>
  </div>

  <section id="products" class="py-14 lg:py-20 bg-gradient-to-b from-[#E9F2FA] to-[#F6FAFD] dark:from-[#0B1B2B] dark:to-[#0A111A] transition-colors duration-200">
    <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 items-center">
      <div class="relative w-full min-h-[360px] lg:min-h-[480px] rounded-2xl overflow-hidden border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#E9F2FA] dark:bg-[#132232] flex items-center justify-center p-0 shadow-sm">
        <img src="{{ asset('assets/website/skin/info.webp') }}" href="{{ asset('assets/website/skin/info.webp') }}" alt="Novex Extra Bright Mud Foam" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1000&q=80'" class="w-full h-full object-cover block absolute inset-0">
      </div>

      <div>
        <p class="text-[12px] font-semibold tracking-[.25em] text-[#2F6F9F] dark:text-[#5CA5DA]">FEATURED PRODUCT</p>
        <h2 class="font-serif mt-3 text-4xl sm:text-5xl font-medium leading-[1.05] text-[#1E2D3B] dark:text-[#F0F6FC]">Extra Bright<br>Mud Foam</h2>
        <p class="mt-5 max-w-[30rem] text-[15px] leading-relaxed text-[#5A6F82] dark:text-[#8EA4B8]">
          Deep cleansing face wash that removes impurities, excess oil and dead skin, while keeping skin clean, bright and smooth.
        </p>
        <ul class="mt-7 grid grid-cols-2 sm:grid-cols-4 gap-4 list-none p-0">
          @foreach ($actives as [$n, $d, $c])
            <li class="text-center sm:text-left">
              <span class="block w-11 h-11 rounded-full mx-auto sm:mx-0 shadow-inner" style="background:radial-gradient(circle at 32% 28%,#fff,{{ $c }} 70%)"></span>
              <span class="mt-2 block text-[13px] font-bold text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $n }}</span>
              <span class="block text-[11px] leading-snug text-[#5A6F82] dark:text-[#8EA4B8]">{{ $d }}</span>
            </li>
          @endforeach
        </ul>
        <a href="#order" class="mt-8 inline-flex items-center gap-3 px-7 py-3.5 text-sm font-semibold rounded-full bg-[#2F6F9F] hover:bg-[#245a82] dark:bg-[#327BB3] dark:hover:bg-[#286391] text-white transition-colors duration-200 no-underline">
          Shop Now <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
    </div>
  </section>

  <section class="py-14 lg:py-16 bg-white dark:bg-[#0A111A] transition-colors duration-200">
    <div class="wrap max-w-[1100px] mx-auto px-4 sm:px-6">
      <h2 class="font-serif text-center text-2xl sm:text-3xl font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Real Skin Results</h2>
      <span class="mx-auto mt-3 block h-0.5 w-10 bg-[#2F6F9F] dark:bg-[#5CA5DA]"></span>

      <div class="mt-10 grid lg:grid-cols-[1.3fr_1fr] gap-10 items-center">
        <div class="flex flex-col rounded-2xl overflow-hidden border border-[#D2E2EF] dark:border-[#1C2D3E] bg-white dark:bg-[#132232] shadow-sm">
          <div class="relative grid grid-cols-2 w-full m-0 p-0 overflow-hidden">
            <div class="relative w-full aspect-square overflow-hidden m-0 p-0 bg-transparent">
              <img src="{{ $transform1Url }}" href="{{ $transform1Url }}" alt="Before: Dull & Uneven Skin" class="w-full h-full object-cover block m-0 p-0" style="width:100%;height:100%;object-fit:cover;display:block;transform:scale(1.10);transform-origin:center;" onerror="this.onerror=null;this.src='{{ asset('transform1.webp') }}'">
            </div>

            <div class="relative w-full aspect-square overflow-hidden m-0 p-0 border-l border-[#D2E2EF] dark:border-[#1C2D3E] bg-transparent">
              <img src="{{ $transform2Url }}" href="{{ $transform2Url }}" alt="After: Clean, Smoother & Brighter" class="w-full h-full object-cover block m-0 p-0" style="width:100%;height:100%;object-fit:cover;display:block;transform:scale(1.10);transform-origin:center;" onerror="this.onerror=null;this.src='{{ asset('transform2.webp') }}'">
            </div>

            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 grid place-items-center w-7 h-7 rounded-full bg-white text-[#2F6F9F] shadow-md text-xs font-bold pointer-events-none z-10" aria-hidden="true">&rsaquo;</span>
          </div>

          <div class="grid grid-cols-2 divide-x divide-[#D2E2EF] dark:divide-[#1C2D3E] border-t border-[#D2E2EF] dark:border-[#1C2D3E] bg-white dark:bg-[#132232]">
            <div class="px-4 py-3 text-[11px] leading-tight text-[#5A6F82] dark:text-[#8EA4B8]">
              <b class="text-[#1E2D3B] dark:text-[#F0F6FC] font-bold">BEFORE</b><br>Dull &amp; Uneven Skin
            </div>
            <div class="px-4 py-3 text-[11px] leading-tight text-[#5A6F82] dark:text-[#8EA4B8]">
              <b class="text-[#1E2D3B] dark:text-[#F0F6FC] font-bold">AFTER</b><br>Clean, Smoother &amp; Brighter
            </div>
          </div>
        </div>

        <div>
          <dl class="grid grid-cols-3 gap-3 text-center">
            @foreach ($stats as [$n, $t])
              <div>
                <dt class="font-serif text-3xl sm:text-4xl font-bold text-[#2F6F9F] dark:text-[#5CA5DA]">+{{ $n }}%</dt>
                <dd class="mt-2 text-[12px] leading-snug text-[#5A6F82] dark:text-[#8EA4B8]">{{ $t }}</dd>
              </div>
            @endforeach
          </dl>
          <p class="mt-5 text-center text-[11px] italic text-[#5A6F82] dark:text-[#8EA4B8]">*Based on user self-assessment after 2 weeks of regular use.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="pt-6 pb-0 lg:pt-10 bg-gradient-to-b from-[#E9F2FA] to-[#F6FAFD] dark:from-[#0B1B2B] dark:to-[#0A111A] transition-colors duration-200 overflow-hidden" id="order">
    <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6 grid lg:grid-cols-[1.55fr_1fr] gap-6 items-center">
      <div class="py-4 lg:py-6">
        <h2 class="font-serif text-center text-2xl sm:text-3xl lg:text-4xl font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Key Benefits</h2>
        <span class="mx-auto mt-2.5 block h-0.5 w-12 bg-[#2F6F9F] dark:bg-[#5CA5DA]"></span>
        <ul class="mt-7 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3.5 list-none p-0">
          @foreach ($benefits as [$i, $t])
            <li class="flex flex-col items-center justify-center gap-2 text-center px-2 py-3 bg-transparent">
              <span class="text-[#233862] dark:text-[#5CA5DA]">{!! $svg($i, 'w-8 h-8') !!}</span>
              <span class="text-[11.5px] font-semibold leading-tight text-[#1E2D3B] dark:text-[#F0F6FC]">{!! $t !!}</span>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="w-full flex justify-center lg:justify-end items-end self-end m-0 p-0 leading-none">
        <img src="{{ asset('assets/website/skin/benefits.webp') }}" href="{{ asset('assets/website/skin/benefits.webp') }}" alt="Novex Skin Lab Key Benefits" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('benefits.webp') }}'" class="w-full max-w-[320px] h-auto object-contain block self-end align-bottom m-0 p-0">
      </div>
    </div>
  </section>
</div>

<script>
function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/skin/hero-phone.webp') }}"
    : "{{ asset('assets/website/skin/hero.webp') }}";

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