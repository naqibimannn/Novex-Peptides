@extends('frontend.home.index')

@section('content')
@php
  $nxPrices = ['polo' => 79.00];
@endphp

<div id="view-performance-division">
  <section class="hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/performance/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/performance/hero.webp') }}" alt="Novex Performance Division" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1800&q=80'">
    </picture>
    <div class="wrap"><div class="in">
      <h1>Novex Performance<br>Division</h1>
      <p>Sport. Discipline. Performance. Lifestyle. Designed for movement, built for a higher standard.</p>
      <div style="display:flex;align-items:center;flex-wrap:wrap">
        <a class="btn" href="{{ route('products.show', 'jersey-01') }}">Explore Collection</a>
        <a class="btn line" href="#" onclick="document.getElementById('perf-signature').scrollIntoView({behavior:'smooth'});return false;">Signature Collection</a>
      </div>
    </div></div>
  </section>

  <div class="mq"><div>
    <span>Sport</span><span>Discipline</span><span>Performance</span><span>Lifestyle</span><span>Padel</span><span>Train</span><span>Move</span><span>Explore</span>
    <span>Sport</span><span>Discipline</span><span>Performance</span><span>Lifestyle</span><span>Padel</span><span>Train</span><span>Move</span><span>Explore</span>
  </div></div>

  <section class="sec"><div class="wrap">
    <div class="nxg">
      <div class="nxg-head">
        <div>
          <h2>Signature Collection</h2>
          <p>Unisex half zip polo. Designed for movement, built for a higher standard.</p>
        </div>
      </div>

      <div class="nxg-grid c4">
        <figure class="nxg-fig"><div class="nxg-ph rA"><img src="{{ asset('assets/website/performance/front-view.webp') }}" alt="Front view" loading="lazy"></div><figcaption class="nxg-cap"><b>Front view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rA"><img src="{{ asset('assets/website/performance/back-view.webp') }}" alt="Back view" loading="lazy"></div><figcaption class="nxg-cap"><b>Back view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rA"><img src="{{ asset('assets/website/performance/left-side-view.webp') }}" alt="Left side view" loading="lazy"></div><figcaption class="nxg-cap"><b>Left side view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rA"><img src="{{ asset('assets/website/performance/right-side-view.webp') }}" alt="Right side view" loading="lazy"></div><figcaption class="nxg-cap"><b>Right side view</b></figcaption></figure>
      </div>

      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/collar.webp') }}" alt="Half zip collar" loading="lazy"></div><figcaption class="nxg-cap"><b>Half zip collar</b><small>Premium polo</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/embroidery.webp') }}" alt="Signature embroidery" loading="lazy"></div><figcaption class="nxg-cap"><b>Signature embroidery</b><small>3D embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/sleeve-label.webp') }}" alt="Sleeve label" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve label</b><small>Embroidery</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/fabric.webp') }}" alt="Premium polo fabric" loading="lazy"></div><figcaption class="nxg-cap"><b>Premium polo fabric</b><small>Stretch piqu&eacute; mesh</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/shoulder-panel.webp') }}" alt="Shoulder panel" loading="lazy"></div><figcaption class="nxg-cap"><b>Shoulder panel</b><small>Detail</small></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rB"><img src="{{ asset('assets/website/performance/side-panel.webp') }}" alt="Side panel" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel</b><small>Detail</small></figcaption></figure>
      </div>

      <div class="nxg-title"><h3>Collar &amp; Sleeve Details</h3></div>
      <div class="nxg-grid c3">
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-top.webp') }}" alt="Collar top view" loading="lazy"></div><figcaption class="nxg-cap"><b>Collar top view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/collar-back.webp') }}" alt="Collar back view" loading="lazy"></div><figcaption class="nxg-cap"><b>Collar back view</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-left.webp') }}" alt="Sleeve left (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/sleeve-right.webp') }}" alt="Sleeve right (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Sleeve right (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-left.webp') }}" alt="Side panel left (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel left (flat)</b></figcaption></figure>
        <figure class="nxg-fig"><div class="nxg-ph rC"><img src="{{ asset('assets/website/performance/side-panel-right.webp') }}" alt="Side panel right (flat)" loading="lazy"></div><figcaption class="nxg-cap"><b>Side panel right (flat)</b></figcaption></figure>
      </div>
    </div>
  </div></section>

  <section class="sec alt"><div class="wrap">
    <div class="g2 nx-sig" id="perf-signature">
      <div class="ph"><img src="{{ asset('assets/website/performance/front-view.webp') }}" alt="Novex Signature Unisex Half Zip Polo" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1000&q=80'"></div>
      <div class="nx-sig-body">
        <span class="nx-eyebrow">Novex Performance Division</span>
        <h2>Unisex Half Zip Polo</h2>
        <span class="nx-tag">Navy &middot; White Panel</span>
        <p>Designed for movement. Built for a higher standard. A half zip polo with signature embroidery and stretch piqu&eacute; mesh fabric, made to move with you from the court to everyday life.</p>
        <div class="nx-views"><span>Front view</span><span>Back view</span><span>Left side view</span><span>Right side view</span></div>
        <div class="nx-price">RM{{ number_format($nxPrices['polo'], 2) }}</div>
        <div class="nx-buy" data-id="nx-polo-navy" data-name="Signature Unisex Half Zip Polo" data-price="{{ $nxPrices['polo'] }}" data-img="{{ asset('assets/website/performance/front-view.webp') }}">
          <div class="nx-sizes" role="group" aria-label="Select size">
            <span class="nx-lbl">Size</span>
            <button type="button" class="nx-size" data-size="S" onclick="nxPickSize(this)">S</button>
            <button type="button" class="nx-size" data-size="M" onclick="nxPickSize(this)">M</button>
            <button type="button" class="nx-size" data-size="L" onclick="nxPickSize(this)">L</button>
            <button type="button" class="nx-size" data-size="XL" onclick="nxPickSize(this)">XL</button>
          </div>
          <div class="nx-buyrow">
            <div class="nx-qty" aria-label="Quantity">
              <button type="button" onclick="nxQty(this,-1)" aria-label="Decrease quantity">&minus;</button>
              <input type="number" value="1" min="1" max="99" inputmode="numeric" aria-label="Quantity">
              <button type="button" onclick="nxQty(this,1)" aria-label="Increase quantity">+</button>
            </div>
            <button type="button" class="btn nx-add" onclick="nxAdd(this)">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </div></section>

  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/performance/cta.webp') }}" alt="More than sport" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=1800&q=80'">
    </div>
    <div class="nx-cta-panel">
      <span class="nx-eyebrow">Novex Performance Division</span>
      <h3>More than sport.</h3>
      <p>People. Discipline. Progress. A higher you.</p>
    </div>
  </section>
</div>
@endsection