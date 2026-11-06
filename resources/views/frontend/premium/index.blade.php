@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="Novex Premium Supplements | Science-Driven Nutrition"
    description="Science-driven nutrition for a healthier, stronger, and better you. High purity dietary supplements, antioxidant formulas, and daily wellness support."
    :canonical="route('premium')"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Novex Premium Supplements',
        'url' => route('premium'),
        'description' => 'Science-driven nutrition for a healthier, stronger, and better you. High purity dietary supplements, antioxidant formulas, and daily wellness support.'
    ]"
/>
@endsection

@section('content')
@php
  $premCssPath = 'frontend/premium/premium.css';
  $premCssVer = file_exists(public_path($premCssPath)) ? filemtime(public_path($premCssPath)) : time();

  $premJsPath = 'frontend/premium/premium.js';
  $premJsVer = file_exists(public_path($premJsPath)) ? filemtime(public_path($premJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($premCssPath) }}?v={{ $premCssVer }}">

<div id="view-premium-supplements">
  <section class="premium-hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/premium/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/premium/hero.webp') }}" alt="Novex Premium Supplements" width="1800" height="700" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap">
      <div class="in">
        <h1>Novex Premium<br>Supplements</h1>
        <p>Science-driven nutrition for a healthier, stronger and better you.</p>
        <div>
          <a class="btn-hero-shop" href="{{ route('premium.show') }}">Explore Supplements</a>
        </div>
      </div>
    </div>
  </section>

  <div class="mq">
    <div class="mq-inner">
      <span>Science-driven nutrition</span>
      <span>High purity ingredients</span>
      <span>Quality assured</span>
      <span>Manufactured with care</span>
      <span>30 capsules</span>
      <span>Dietary supplement</span>
      <span>Science-driven nutrition</span>
      <span>High purity ingredients</span>
      <span>Quality assured</span>
      <span>Manufactured with care</span>
      <span>30 capsules</span>
      <span>Dietary supplement</span>
    </div>
  </div>

  <section class="sec" id="sup-formulas">
    <div class="wrap">
      <div class="formula-block">
        <div class="formula-header-row">
          <div class="formula-text">
            <span class="formula-eyebrow">Science-Driven Nutrition</span>
            <h2 class="formula-title">Our Formulas</h2>
            <p class="formula-desc">Premium formulas and specialized nutritional bundles for metabolic support, antioxidant care, and everyday wellness.</p>
          </div>
          <div class="formula-action">
            <a href="{{ route('premium.show') }}" class="btn-formula-shop">
              Shop Now
            </a>
          </div>
        </div>

        <div class="formula-gallery-grid">
          <div class="formula-img-container">
            <img src="{{ asset('assets/website/premium/info1.webp') }}" alt="Novex Premium Formulas - Antioxidant" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1000&q=80'">
          </div>
          <div class="formula-img-container">
            <img src="{{ asset('assets/website/premium/info2.webp') }}" alt="Novex Premium Formulas - Wellness" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1000&q=80'">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="sec alt">
    <div class="wrap">
      <div class="nx-quality">
        <div class="quality-media">
          <img src="{{ asset('assets/website/premium/info.webp') }}" alt="Quality controlled laboratory" width="800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=80'">
        </div>
        <div class="nx-q-body">
          <span class="formula-eyebrow">Quality Promise</span>
          <h2 class="formula-title">Premium Quality You Can Trust</h2>
          <p class="formula-desc">Manufactured under strict quality control standards to ensure purity, safety and consistent performance.</p>
          <div class="nx-q-list">
            <div class="quality-item">
              <span class="quality-check">&#10003;</span>
              <b>High Purity Ingredients</b>
            </div>
            <div class="quality-item">
              <span class="quality-check">&#10003;</span>
              <b>Quality Assured</b>
            </div>
            <div class="quality-item">
              <span class="quality-check">&#10003;</span>
              <b>Manufactured With Care</b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/premium/cta.webp') }}" alt="A Healthier, Stronger You" width="1800" height="600" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1800&q=80'">
    </div>
    <div class="nx-cta-panel">
      <span class="eyebrow">Novex Premium Supplements</span>
      <h3>A Healthier, Stronger You</h3>
      <p>Support your daily wellness, look better, feel better and perform at your best.</p>
    </div>
  </section>
</div>

<script src="{{ asset($premJsPath) }}?v={{ $premJsVer }}"></script>
@endsection