@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="Novex Skin Lab | Dermatology Crafted for Asian Skin"
    description="Science-backed skincare and dermatology-inspired treatments crafted for Asian skin. Advanced mud foams, glutathione, and gentle daily exfoliating formulas."
    :canonical="url('/skin')"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Novex Skin Lab',
        'url' => url('/skin'),
        'description' => 'Science-backed skincare and dermatology-inspired treatments crafted for Asian skin. Advanced mud foams, glutathione, and gentle daily exfoliating formulas.'
    ]"
/>
@endsection

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
    $svg = fn ($k, $c = 'w-7 h-7') => '<svg class="'.$c.'" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$ico[$k].'</svg>';

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

    $skinCssPath = 'frontend/skin/skin.css';
    $skinCssVer = file_exists(public_path($skinCssPath)) ? filemtime(public_path($skinCssPath)) : time();

    $skinJsPath = 'frontend/skin/skin.js';
    $skinJsVer = file_exists(public_path($skinJsPath)) ? filemtime(public_path($skinJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($skinCssPath) }}?v={{ $skinCssVer }}">

<div id="view-skin-lab">
  <section class="skin-hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/skin/hero-phone.webp') }}">
      <img id="heroImage" 
           src="{{ asset('assets/website/skin/hero.webp') }}" 
           data-desktop="{{ asset('assets/website/skin/hero.webp') }}" 
           data-phone="{{ asset('assets/website/skin/hero-phone.webp') }}" 
           alt="Novex Skin Lab" 
           width="1800"
           height="700"
           onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap">
      <div class="in">
        <span class="skin-eyebrow">NOVEX SKIN LAB</span>
        <h1>Dermatology<br>crafted for<br>Asian skin</h1>
        <div>
          <a class="btn-hero-explore" href="{{ url('/skin/show') }}">Explore Our Products</a>
        </div>
      </div>
    </div>
  </section>

  <div class="mq">
    <div class="mq-inner">
      <span>Science-Backed Formulation</span>
      <span>Gentle &amp; Effective for Daily Use</span>
      <span>Suitable for All Skin Types</span>
      <span>Dermatology Inspired Care</span>
      <span>Science-Backed Formulation</span>
      <span>Gentle &amp; Effective for Daily Use</span>
      <span>Suitable for All Skin Types</span>
      <span>Dermatology Inspired Care</span>
    </div>
  </div>

  <section id="products" class="skin-feature-sec">
    <div class="wrap skin-feature-grid">
      <div class="skin-feature-media">
        <img src="{{ asset('assets/website/skin/info.webp') }}" alt="Novex Extra Bright Mud Foam" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1000&q=80'">
      </div>

      <div class="skin-feature-content">
        <p class="skin-feature-subtitle">FEATURED PRODUCT</p>
        <h2 class="skin-feature-title">Extra Bright<br>Mud Foam</h2>
        <p class="skin-feature-desc">
          Deep cleansing face wash that removes impurities, excess oil and dead skin, while keeping skin clean, bright and smooth.
        </p>
        <ul class="skin-actives-grid">
          @foreach ($actives as [$n, $d, $c])
            <li class="skin-active-item">
              <span class="skin-active-dot" style="background:radial-gradient(circle at 32% 28%,#fff,{{ $c }} 70%)"></span>
              <span class="skin-active-name">{{ $n }}</span>
              <span class="skin-active-desc">{{ $d }}</span>
            </li>
          @endforeach
        </ul>
        <a href="{{ url('/skin/show') }}" class="btn-skin-shop">
          Shop Now <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
    </div>
  </section>

  <section class="skin-results-sec">
    <div class="wrap" style="max-width: 1100px;">
      <h2 class="skin-results-title">Real Skin Results</h2>
      <span class="skin-title-bar"></span>

      <div class="skin-results-grid">
        <div class="skin-compare-card">
          <div class="skin-compare-images">
            <div class="skin-compare-pane">
              <img src="{{ $transform1Url }}" alt="Before: Dull &amp; Uneven Skin" width="400" height="400" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('transform1.webp') }}'">
            </div>

            <div class="skin-compare-pane">
              <img src="{{ $transform2Url }}" alt="After: Clean, Smoother &amp; Brighter" width="400" height="400" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('transform2.webp') }}'">
            </div>

            <span class="skin-compare-badge" aria-hidden="true">&rsaquo;</span>
          </div>

          <div class="skin-compare-captions">
            <div class="skin-compare-col">
              <b>BEFORE</b><br>Dull &amp; Uneven Skin
            </div>
            <div class="skin-compare-col">
              <b>AFTER</b><br>Clean, Smoother &amp; Brighter
            </div>
          </div>
        </div>

        <div>
          <dl class="skin-stats-grid">
            @foreach ($stats as [$n, $t])
              <div>
                <dt class="skin-stat-num">+{{ $n }}%</dt>
                <dd class="skin-stat-desc">{{ $t }}</dd>
              </div>
            @endforeach
          </dl>
          <p class="skin-stat-note">*Based on user self-assessment after 2 weeks of regular use.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="skin-benefits-sec" id="order">
    <div class="wrap skin-benefits-grid">
      <div class="skin-benefits-left">
        <h2 class="skin-benefits-title">Key Benefits</h2>
        <span class="skin-benefits-bar"></span>
        <ul class="skin-benefits-list">
          @foreach ($benefits as [$i, $t])
            <li class="skin-benefit-item">
              <span class="skin-benefit-icon">{!! $svg($i, 'w-8 h-8') !!}</span>
              <span class="skin-benefit-label">{!! $t !!}</span>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="skin-benefits-media">
        <img src="{{ asset('assets/website/skin/benefits.webp') }}" alt="Novex Skin Lab Key Benefits" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('benefits.webp') }}'">
      </div>
    </div>
  </section>
</div>

<script>
window.NVX_SKIN = {
  heroPhone: '{{ asset("assets/website/skin/hero-phone.webp") }}',
  heroDesktop: '{{ asset("assets/website/skin/hero.webp") }}'
};
</script>
<script src="{{ asset($skinJsPath) }}?v={{ $skinJsVer }}"></script>
@endsection