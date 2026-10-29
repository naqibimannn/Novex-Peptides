@extends('frontend.home.index')

@section('content')
@php
  $nxPrices = ['glp1' => 99.00, 'gluta' => 89.00, 'bundle' => 200.00];
@endphp

<div id="view-premium-supplements">
  <section class="hero">
    <picture>
      <source media="(orientation: portrait)" srcset="{{ asset('assets/website/premium/hero-phone.webp') }}">
      <img src="{{ asset('assets/website/premium/hero.webp') }}" alt="Novex Premium Supplements" loading="lazy">
    </picture>
    <div class="wrap"><div class="in">
      <h1>Novex Premium<br>Supplements</h1>
      <p>Science-driven nutrition for a healthier, stronger and better you.</p>
      <div style="display:flex;align-items:center;flex-wrap:wrap">
        <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
        <a class="btn line" href="#" onclick="document.getElementById('sup-formulas').scrollIntoView({behavior:'smooth'});return false;">Our Formulas</a>
      </div>
    </div></div>
  </section>

  <div class="mq"><div>
    <span>Science-driven nutrition</span><span>High purity ingredients</span><span>Quality assured</span><span>Manufactured with care</span><span>30 capsules</span><span>Dietary supplement</span>
    <span>Science-driven nutrition</span><span>High purity ingredients</span><span>Quality assured</span><span>Manufactured with care</span><span>30 capsules</span><span>Dietary supplement</span>
  </div></div>

  <section class="sec" id="sup-formulas"><div class="wrap">
    <div class="head"><div><h2>Our Formulas</h2><p>Premium formulas and a value bundle for metabolic support, antioxidant care and everyday wellness.</p></div><a class="btn line" href="{{ route('products.index') }}">View all</a></div>

    <div class="g3">
      <div class="card pc">
        <div class="ph"><img src="{{ asset('assets/website/premium/product1.webp') }}" alt="GLP-1 capsules" loading="lazy"></div>
        <div class="b">
          <h3>GLP-1</h3>
          <div class="s">Metabolic Support Formula</div>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM{{ number_format($nxPrices['glp1'], 2) }}</div>
          <div class="meta">
            <span style="font-weight:600">30 Capsules</span>
            <span>Dietary Supplement</span>
          </div>
          <div class="nx-buy" data-id="nx-glp1" data-name="Novex GLP-1 Metabolic Support Formula (30 Capsules)" data-price="{{ $nxPrices['glp1'] }}" data-img="{{ asset('assets/website/premium/product1.webp') }}">
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

      <div class="card pc">
        <div class="ph"><img src="{{ asset('assets/website/premium/product2.webp') }}" alt="Glutathione skin health" loading="lazy"></div>
        <div class="b">
          <h3>Glutathione</h3>
          <div class="s">Advanced Antioxidant Formula</div>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM{{ number_format($nxPrices['gluta'], 2) }}</div>
          <div class="meta">
            <span style="font-weight:600">30 Capsules</span>
            <span>Dietary Supplement</span>
          </div>
          <div class="nx-buy" data-id="nx-gluta" data-name="Novex Glutathione Advanced Antioxidant Formula (30 Capsules)" data-price="{{ $nxPrices['gluta'] }}" data-img="{{ asset('assets/website/premium/product2.webp') }}">
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

      <div class="card pc">
        <div class="ph"><img src="{{ asset('assets/website/premium/product3.webp') }}" alt="Novex Bundle Pack" loading="lazy"></div>
        <div class="b">
          <h3>Bundle Pack</h3>
          <div class="s">2 Bottle GLP-1 &amp; 2 Bottle Glutathione</div>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM{{ number_format($nxPrices['bundle'], 2) }}</div>
          <div class="meta">
            <span style="font-weight:600">4 Bottles (120 Capsules)</span>
            <span>Dietary Supplement</span>
          </div>
          <div class="nx-buy" data-id="nx-bundle" data-name="Novex Bundle Pack - 2 Bottle GLP-1 &amp; 2 Bottle Glutathione (120 Capsules)" data-price="{{ $nxPrices['bundle'] }}" data-img="{{ asset('assets/website/premium/product3.webp') }}">
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
    </div>
  </div></section>

  <section class="sec alt"><div class="wrap">
    <div class="g2 nx-quality" style="margin-top:0">
      <div class="ph"><img src="{{ asset('assets/website/premium/info.webp') }}" alt="Quality controlled laboratory" loading="lazy"></div>
      <div class="nx-q-body">
        <span class="nx-eyebrow">Quality Promise</span>
        <h2>Premium Quality You Can Trust</h2>
        <p>Manufactured under strict quality control standards to ensure purity, safety and consistent performance.</p>
        <div class="nx-q-list">
          <div><b>High Purity Ingredients</b></div>
          <div><b>Quality Assured</b></div>
          <div><b>Manufactured With Care</b></div>
        </div>
      </div>
    </div>
  </div></section>

  <section class="nx-cta">
    <div class="nx-cta-img">
      <img src="{{ asset('assets/website/premium/cta.webp') }}" alt="A Healthier, Stronger You" loading="lazy">
    </div>
    <div class="nx-cta-panel">
      <span class="nx-eyebrow">Novex Premium Supplements</span>
      <h3>A Healthier, Stronger You</h3>
      <p>Support your daily wellness, look better, feel better and perform at your best.</p>
    </div>
  </section>
</div>
@endsection
