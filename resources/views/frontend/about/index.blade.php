@extends('frontend.home.index')

@section('content')
@php
  $aboutPath = public_path('assets/website/about/about.webp');
  $aboutVer = file_exists($aboutPath) ? filemtime($aboutPath) : time();
  $aboutUrl = asset('assets/website/about/about.webp') . '?v=' . $aboutVer;

  $aboutCssPath = 'frontend/about/about.css';
  $aboutCssVer = file_exists(public_path($aboutCssPath)) ? filemtime(public_path($aboutCssPath)) : time();

  $aboutJsPath = 'frontend/about/about.js';
  $aboutJsVer = file_exists(public_path($aboutJsPath)) ? filemtime(public_path($aboutJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($aboutCssPath) }}?v={{ $aboutCssVer }}">

<section class="about-hero">
  <img id="heroImage" src="{{ asset('assets/website/about/hero.webp') }}" href="{{ asset('assets/website/about/hero.webp') }}" data-desktop="{{ asset('assets/website/about/hero.webp') }}" data-phone="{{ asset('assets/website/about/hero-phone.webp') }}" alt="Our story" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span class="eyebrow">Our story</span>
      <h1>One question behind every vial</h1>
      <p>Is it really what the label says? Novex was built to answer that clearly, with paper to back it up.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap about-story-grid">
    <div>
      <h2 class="about-story-title">Why Novex Exists</h2>
      <p class="about-story-p">Researchers buying peptides online kept running into the same problem: a certificate that could not be matched to the vial in their hand.</p>
      <p class="about-story-p">We started Novex as a sourcing desk that treats the batch number as the centre of everything.</p>
      <p class="about-story-highlight">If we cannot test it, trace it and explain it in plain language, it does not go into our catalog.</p>
    </div>
    
    <a href="{{ $aboutUrl }}" onclick="if(typeof openLightboxModal === 'function'){ openLightboxModal('{{ $aboutUrl }}', 'Why Novex Exists'); return false; }" class="about-img-link">
      <img src="{{ $aboutUrl }}" alt="Why Novex Exists - Lab Research" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800'">
    </a>
  </div>
</section>

<section class="sec alt">
  <div class="wrap">
    <div class="head">
      <div style="max-width: 720px;">
        <h2 class="sec-title">How we work</h2>
        <p class="sec-desc">Four habits that shape what we stock and how we ship it.</p>
      </div>
    </div>
    
    <div class="about-rows">
      <div class="about-row-card">
        <b>01</b>
        <h3>Source narrowly</h3>
        <p>Each compound addition needs published literature and a supplier we can audit.</p>
      </div>
      
      <div class="about-row-card">
        <b>02</b>
        <h3>Test outside</h3>
        <p>Purity results come from a third-party laboratory and are tied to the lot printed on your vial.</p>
      </div>
      
      <div class="about-row-card">
        <b>03</b>
        <h3>Keep it cold</h3>
        <p>Storage and shipping are designed around temperature stability, using insulated packaging.</p>
      </div>
      
      <div class="about-row-card">
        <b>04</b>
        <h3>Explain plainly</h3>
        <p>Clear, direct communication regarding purity, research focus, and handling protocols.</p>
      </div>
    </div>
  </div>
</section>

<section class="sec about-pull-wrap">
  <div class="wrap">
    <p class="about-pull">
      “A good certificate is one you can match to the vial in your hand.”
      <small>THE NOVEX PRINCIPLE</small>
    </p>
  </div>
</section>

<script>
window.NVX_ABOUT = {
  heroPhone: '{{ asset("assets/website/about/hero-phone.webp") }}',
  heroDesktop: '{{ asset("assets/website/about/hero.webp") }}'
};
</script>
<script src="{{ asset($aboutJsPath) }}?v={{ $aboutJsVer }}"></script>
@endsection