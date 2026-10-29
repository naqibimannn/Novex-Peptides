@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('assets/website/performance/front-view.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    if (file_exists(public_path($path))) return asset($path);
    if (file_exists(public_path('uploads/products/' . basename($path)))) {
        return asset('uploads/products/' . basename($path));
    }
    if (file_exists(public_path('storage/' . ltrim($path, '/')))) {
        return asset('storage/' . ltrim($path, '/'));
    }
    return asset($path);
};

$poloProduct = [
    'id'             => 'nx-polo-navy',
    'name'           => 'Signature Unisex Half Zip Polo',
    'title'          => 'Navy · White Panel',
    'spec'           => 'Adult Fit',
    'val'            => 79.00,
    'price'          => 'RM79.00',
    'category'       => 'Performance Apparel',
    'badge_category' => 'Novex Performance Division',
    'stock'          => 45,
    'imgs'           => [
        'assets/website/performance/front-view.webp',
        'assets/website/performance/back-view.webp',
        'assets/website/performance/left-side-view.webp',
        'assets/website/performance/right-side-view.webp',
    ],
    'sizes'          => ['S', 'M', 'L', 'XL'],
    'desc'           => 'Designed for movement, built for a higher standard. A half zip polo with signature 3D embroidery and stretch piqué mesh fabric, crafted to move effortlessly from the padel court to everyday lifestyle.',
];

try {
    $dbItem = \Illuminate\Support\Facades\DB::select("SELECT * FROM products WHERE page_type = 'performance' OR slug IN ('nx-polo-navy', 'polo', 'half-zip-polo') LIMIT 1");
    if (!empty($dbItem)) {
        $row = $dbItem[0];
        $imgs = [];
        if (!empty($row->image)) {
            $decodedImg = json_decode($row->image, true);
            $imgs = (json_last_error() === JSON_ERROR_NONE && is_array($decodedImg) && count($decodedImg) > 0)
                ? $decodedImg
                : [$row->image];
        }
        $sizes = [];
        if (!empty($row->sizes)) {
            $decodedSizes = is_string($row->sizes) ? json_decode($row->sizes, true) : $row->sizes;
            if (is_array($decodedSizes)) {
                $sizes = array_values(array_filter(array_map('trim', $decodedSizes)));
            } elseif (is_string($row->sizes)) {
                $sizes = array_values(array_filter(array_map('trim', explode(',', $row->sizes))));
            }
        }
        $val = (float)($row->price_val ?? 0);
        if ($val <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $row->price ?? '', $m)) {
            $val = (float)$m[1];
        }
        $poloProduct = [
            'id'             => $row->slug ?? 'nx-polo-navy',
            'name'           => $row->title ?? $poloProduct['name'],
            'title'          => $row->subtitle ?? $poloProduct['title'],
            'spec'           => $row->dosage_spec ?? $poloProduct['spec'],
            'val'            => $val > 0 ? $val : $poloProduct['val'],
            'price'          => $row->price ?? $poloProduct['price'],
            'category'       => $row->category ?? $poloProduct['category'],
            'badge_category' => $row->badge_category ?? $poloProduct['badge_category'],
            'stock'          => (int)($row->stock ?? $poloProduct['stock']),
            'imgs'           => count($imgs) > 0 ? $imgs : $poloProduct['imgs'],
            'sizes'          => count($sizes) > 0 ? $sizes : $poloProduct['sizes'],
            'desc'           => !empty($row->description) ? $row->description : $poloProduct['desc'],
        ];
    }
} catch (\Throwable $e) {}
@endphp

<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap');

  :root {
    --bg:#FFFFFF;--bg2:#E9F2FA;--ink:#1E2D3B;--mut:#5A6F82;--green:#2F6F9F;
    --line:#D2E2EF;--card:#F6FAFD;--card-surface:#FFFFFF;--gold:#3F84B5;--red:#e11d48;
    --serif:'Cormorant Garamond',Georgia,serif;--sans:'Inter',system-ui,sans-serif;
  }

  [data-theme="dark"] {
    --bg:#0A111A;--bg2:#101B27;--ink:#F0F6FC;--mut:#8EA4B8;--green:#327BB3;
    --line:#1C2D3E;--card:#0E1824;--card-surface:#132232;--gold:#5CA5DA;
  }

  #view-performance-division {
    display: block !important;
  }

  .detail-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 48px !important;
    align-items: center !important;
  }

  .detail-media-box {
    width: 100%;
    max-width: 560px;
    margin: 0 auto;
  }

  #perf-signature .ph {
    aspect-ratio: 1 / 1 !important;
    border-radius: 28px !important;
    border: 1px solid var(--line) !important;
    background: #FAFAFC !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 24px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,.02) !important;
  }
  [data-theme="dark"] #perf-signature .ph {
    background: #0E1824 !important;
  }
  #perf-signature .ph img {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: contain !important;
    transition: transform .4s ease !important;
    display: block !important;
  }
  #perf-signature .ph:hover img {
    transform: scale(1.02) !important;
  }

  /* Susunan Kemas & Sekata bagi 4 Tag Pilihan Pandangan */
  .nx-views {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-top: 16px;
    width: 100%;
  }
  .nx-view-btn {
    font-size: 12px;
    font-weight: 600;
    background: var(--card-surface);
    color: var(--ink);
    padding: 9px 6px;
    border-radius: 999px;
    border: 1px solid var(--line);
    cursor: pointer;
    transition: all .2s ease;
    text-align: center;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0,0,0,.02);
  }
  .nx-view-btn:hover {
    border-color: var(--gold);
    color: var(--green);
    background: var(--bg2);
  }
  .nx-view-btn.active {
    background: var(--green);
    color: #FFFFFF !important;
    border-color: var(--green);
    box-shadow: 0 2px 10px rgba(47,111,159,.25);
  }

  .detail-info {
    display: flex !important;
    flex-direction: column !important;
    gap: 16px !important;
    text-align: left !important;
  }
  .detail-badge {
    display: inline-block;
    background: var(--bg2);
    color: var(--green);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .04em;
    align-self: flex-start;
  }
  .detail-price {
    font-size: clamp(26px,3vw,34px);
    font-weight: 700;
    color: var(--green);
    font-family: var(--serif);
  }
  .stock-badge {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
    color: #1ebe5a;
    background: rgba(37,211,102,.12);
    padding: 5px 14px;
    border-radius: 999px;
    align-self: flex-start;
  }
  .detail-desc {
    font-size: 14px;
    line-height: 1.7;
    color: #3A4D5E;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    padding: 20px 0;
  }
  .qty-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 8px;
    flex-wrap: wrap;
  }
  .qty-box {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--card);
    overflow: hidden;
  }
  .qty-box button {
    width: 40px;
    height: 40px;
    background: none;
    font-size: 17px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    color: var(--ink);
  }
  .qty-box button:hover {
    background: var(--bg2);
  }
  .qty-box input {
    width: 46px;
    text-align: center;
    border: 0;
    background: none;
    font-weight: 600;
    font-size: 14px;
    color: var(--ink);
    outline: none;
  }
  .btn-add-cart {
    background: var(--green);
    color: #fff;
    padding: 14px 28px;
    font-weight: 600;
    font-size: 14px;
    border-radius: 999px;
    flex: 1;
    min-width: 160px;
    text-align: center;
    border: none;
    cursor: pointer;
    transition: background .2s,transform .1s;
  }
  .btn-add-cart:active { transform: scale(0.98); }
  .btn-add-cart:hover { background: #245a82; }

  .size-picker {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin: 8px 0;
  }
  .size-btn {
    border: 1px solid var(--line);
    background: #fff;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: all .2s;
    color: var(--ink);
  }
  .size-btn:hover { border-color: var(--green); }
  .size-btn.active {
    background: var(--green);
    color: #fff;
    border-color: var(--green);
  }
  .chart-link {
    font-size: 12px;
    color: var(--gold);
    text-decoration: underline;
    cursor: pointer;
    font-weight: 500;
    display: inline-block;
  }

  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.6);
    z-index: 999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    backdrop-filter: blur(4px);
  }
  .modal-overlay.open { display: flex; }
  .modal-content {
    background: #fff;
    border-radius: 20px;
    max-width: 540px;
    width: 100%;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,.2);
    max-height: 90vh;
    overflow-y: auto;
  }
  .modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 22px;
    color: var(--mut);
    cursor: pointer;
  }
  .table-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 16px 0;
  }
  .size-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    text-align: center;
    min-width: 440px;
  }
  .size-table th, .size-table td {
    border: 1px solid var(--line);
    padding: 10px 8px;
  }
  .size-table th {
    background: var(--bg2);
    color: var(--green);
    font-weight: 600;
  }

  @media(max-width:900px){
    .detail-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
    .detail-media-box { max-width: 480px !important; }
  }
  @media(max-width:540px){
    .nx-views {
      grid-template-columns: repeat(2, 1fr);
    }
  }
</style>

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
        <a class="btn" href="#perf-signature" onclick="document.getElementById('perf-signature').scrollIntoView({behavior:'smooth'});return false;">Explore Collection</a>
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

  <section class="sec alt" id="perf-signature">
    <div class="wrap">
      <div class="detail-grid">
        <div class="detail-media-box">
          <div class="ph">
            <img id="perfPoloImg" 
                 src="{{ $resolveImageUrl($poloProduct['imgs'][0] ?? 'assets/website/performance/front-view.webp') }}" 
                 alt="{{ $poloProduct['name'] }}" 
                 loading="lazy" 
                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1000'">
          </div>
          <div class="nx-views">
            <button type="button" class="nx-view-btn active" onclick="setPoloView('{{ $resolveImageUrl($poloProduct['imgs'][0] ?? 'assets/website/performance/front-view.webp') }}', this)">Front view</button>
            <button type="button" class="nx-view-btn" onclick="setPoloView('{{ $resolveImageUrl($poloProduct['imgs'][1] ?? 'assets/website/performance/back-view.webp') }}', this)">Back view</button>
            <button type="button" class="nx-view-btn" onclick="setPoloView('{{ $resolveImageUrl($poloProduct['imgs'][2] ?? 'assets/website/performance/left-side-view.webp') }}', this)">Left side view</button>
            <button type="button" class="nx-view-btn" onclick="setPoloView('{{ $resolveImageUrl($poloProduct['imgs'][3] ?? 'assets/website/performance/right-side-view.webp') }}', this)">Right side view</button>
          </div>
        </div>

        <div class="detail-info">
          <span class="detail-badge">{{ $poloProduct['badge_category'] }}</span>
          <h1 style="font-size:clamp(28px, 4vw, 44px);margin:0">{{ $poloProduct['name'] }}</h1>
          <p id="detailSubDisplay" style="color:var(--mut);font-size:16px;margin:0">
            {{ $poloProduct['title'] }} ({{ $poloProduct['spec'] }})
          </p>
          <div id="detailPriceDisplay" class="detail-price">{{ $poloProduct['price'] }}</div>
          
          <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $poloProduct['stock'] }} units available)</div>

          <div style="margin-top:10px">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <label style="font-size:12px;font-weight:600;text-transform:uppercase;color:var(--mut)">Select Size:</label>
              <a class="chart-link" onclick="openSizeModal()">View Size Chart</a>
            </div>
            <div class="size-picker" id="sizePickerGroup">
              @foreach($poloProduct['sizes'] as $sIdx => $sz)
                <button type="button" class="size-btn {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectProductSize('{{ $sz }}', this)">
                  {{ $sz }}
                </button>
              @endforeach
            </div>
          </div>

          <div class="detail-desc">
            <h4 style="font-family:var(--serif);font-size:20px;margin-bottom:8px">Product Overview</h4>
            <p>{{ $poloProduct['desc'] }}</p>
          </div>

          <div class="qty-row">
            <div class="qty-box">
              <button type="button" onclick="changeDetailQty(-1, {{ (int)$poloProduct['stock'] }})">-</button>
              <input type="text" id="detailQtyInput" readonly value="1">
              <button type="button" onclick="changeDetailQty(1, {{ (int)$poloProduct['stock'] }})">+</button>
            </div>
            <button class="btn-add-cart" onclick="triggerAddToCart()">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </section>

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

<div class="modal-overlay" id="sizeModal" onclick="if(event.target===this)closeSizeModal()">
  <div class="modal-content">
    <button class="modal-close" onclick="closeSizeModal()">&times;</button>
    <h3 style="font-size:24px;margin-bottom:6px;font-family:var(--serif);color:var(--ink)">Size Chart (Adult)</h3>
    <p style="font-size:13px;color:var(--mut);margin-bottom:12px">Novex Performance Division — Unisex Half Zip Polo (All measurements in inches).</p>
    <div class="table-scroll">
      <table class="size-table">
        <thead>
          <tr><th>Size</th><th>Length (A)</th><th>Chest (B)</th><th>Shoulder</th><th>Short Sleeve</th></tr>
        </thead>
        <tbody>
          <tr><td><b>S</b></td><td>26</td><td>38</td><td>16</td><td>8.5</td></tr>
          <tr><td><b>M</b></td><td>27</td><td>40</td><td>17</td><td>9</td></tr>
          <tr><td><b>L</b></td><td>28</td><td>42</td><td>18</td><td>9.5</td></tr>
          <tr><td><b>XL</b></td><td>29</td><td>44</td><td>19</td><td>10</td></tr>
        </tbody>
      </table>
    </div>
    <div style="font-size:12px;color:var(--mut);line-height:1.6;background:var(--bg2);padding:14px;border-radius:12px">
      <b>How to Measure:</b><br>
      • <b>Length (A):</b> Measure from the highest point of the shoulder to the bottom of the shirt.<br>
      • <b>Chest (B):</b> Measure around the fullest part of the chest, keeping the tape horizontal.
    </div>
  </div>
</div>

<script>
  let currentDetailProduct = @json($poloProduct);
  let currentDetailQty = 1;
  let currentDetailSize = (currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0) ? currentDetailProduct.sizes[0] : 'S';

  function setPoloView(src, el) {
    const img = document.getElementById('perfPoloImg');
    if (img) img.src = src;
    document.querySelectorAll('.nx-view-btn').forEach(b => b.classList.remove('active'));
    if (el) el.classList.add('active');
  }

  function changeDetailQty(delta, maxStock){
    currentDetailQty = Math.max(1, Math.min(maxStock > 0 ? maxStock : 99, currentDetailQty + delta));
    const el = document.getElementById('detailQtyInput');
    if(el) el.value = currentDetailQty;
  }

  function selectProductSize(size, btnEl){
    currentDetailSize = size;
    const group = document.getElementById('sizePickerGroup');
    if(group) {
      group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    }
    if(btnEl) btnEl.classList.add('active');
  }

  function openSizeModal(){
    const m = document.getElementById('sizeModal');
    if(m) m.classList.add('open');
  }
  function closeSizeModal(){
    const m = document.getElementById('sizeModal');
    if(m) m.classList.remove('open');
  }

  function triggerAddToCart(){
    let cart = [];
    try {
      cart = JSON.parse(localStorage.getItem('nvx_cart')) || [];
    } catch(e) {
      cart = [];
    }

    let itemSpec = 'Size: ' + currentDetailSize;
    let itemVal = parseFloat(currentDetailProduct.val) || 79.00;
    let itemLabel = currentDetailProduct.name;
    let itemImg = currentDetailProduct.imgs && currentDetailProduct.imgs.length > 0 ? currentDetailProduct.imgs[0] : '';

    const existing = cart.find(x => x.id === currentDetailProduct.id && (x.size === itemSpec || x.s === itemSpec));
    if(existing){
      existing.qty += currentDetailQty;
    } else {
      cart.push({
        id: currentDetailProduct.id,
        name: itemLabel,
        n: itemLabel,
        s: itemSpec,
        size: itemSpec,
        price: itemVal,
        val: itemVal,
        img: itemImg,
        i: itemImg,
        qty: currentDetailQty
      });
    }

    try {
      localStorage.setItem('nvx_cart', JSON.stringify(cart));
    } catch(e) {}

    const totalCount = cart.reduce((acc, item) => acc + (item.qty || 0), 0);
    const badge = document.getElementById('cartCount');
    if(badge){
      badge.textContent = totalCount;
      badge.classList.add('cart-bump');
      setTimeout(() => badge.classList.remove('cart-bump'), 350);
    }

    const toast = document.getElementById('nxToast');
    if (toast) {
      toast.textContent = 'Added to cart (' + currentDetailSize + ') \u2713';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2200);
    } else {
      alert('✓ Added to cart: ' + itemLabel + ' (' + itemSpec + ')');
    }
  }
</script>
@endsection