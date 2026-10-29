@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('reta1.webp');
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

$allProducts = [
    'retatrutide' => [
        'id'            => 'retatrutide',
        'db_id'         => null,
        'name'          => 'Retatrutide',
        'title'         => 'Advanced Weight Management',
        'spec'          => '10mg - 100mg',
        'val'           => 280,
        'price'         => 'RM280.00 - RM980.00',
        'category'      => 'Weight Management',
        'page_type'     => 'products',
        'imgs'          => ['reta1.webp', 'reta2.webp', 'reta3.webp', 'reta4.webp', 'reta5.webp'],
        'stock'         => 63,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [
            ['label' => '10mg', 'val' => 280, 'p' => 'RM280.00', 'stock' => 25],
            ['label' => '30mg', 'val' => 480, 'p' => 'RM480.00', 'stock' => 18],
            ['label' => '60mg', 'val' => 780, 'p' => 'RM780.00', 'stock' => 12],
            ['label' => '100mg', 'val' => 980, 'p' => 'RM980.00', 'stock' => 8],
        ],
        'sizes'         => [],
        'desc'          => 'High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Select your preferred vial concentration above to view exact pricing.',
    ],
    'jersey-01' => [
        'id'            => 'jersey-01',
        'db_id'         => null,
        'name'          => 'Premium Athletic Jersey',
        'title'         => 'Performance. Style. Everyday.',
        'spec'          => 'Adult Size',
        'val'           => 40,
        'price'         => 'RM40.00',
        'category'      => 'Apparel',
        'page_type'     => 'products',
        'imgs'          => ['jry1.webp', 'jry2.webp'],
        'stock'         => 50,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [],
        'sizes'         => ['S', 'M', 'L', 'XL'],
        'desc'          => 'Official Novex Peptides merchandise. Crafted with lightweight, breathable, and moisture-wicking hexagonal weave fabric. Features premium V-neck design and durable finish.',
    ]
];

try {
    $dbRows = \Illuminate\Support\Facades\DB::select("SELECT * FROM products");
    foreach ($dbRows as $row) {
        $imgs = [];
        if (!empty($row->image)) {
            $decodedImg = json_decode($row->image, true);
            $rawList = (json_last_error() === JSON_ERROR_NONE && is_array($decodedImg) && count($decodedImg) > 0)
                ? $decodedImg
                : [$row->image];
            $imgs = $rawList;
        }
        if (empty($imgs)) {
            $imgs = ['reta1.webp'];
        }

        $variants = [];
        if (!empty($row->has_variants) && !empty($row->variants)) {
            $decodedVar = is_string($row->variants) ? json_decode($row->variants, true) : $row->variants;
            if (is_array($decodedVar)) {
                foreach ($decodedVar as $v) {
                    $vVal = (float)($v['val'] ?? 0);
                    if ($vVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $v['price'] ?? '', $vm)) {
                        $vVal = (float)$vm[1];
                    }
                    $variants[] = [
                        'label' => $v['label'] ?? '',
                        'val'   => $vVal,
                        'p'     => !empty($v['price']) ? $v['price'] : ('RM' . number_format($vVal, 2)),
                        'stock' => (int)($v['stock'] ?? 0),
                    ];
                }
            }
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

        $numericVal = (float)($row->price_val ?? 0);
        if ($numericVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $row->price ?? '', $m)) {
            $numericVal = (float)$m[1];
        }

        $rawSlug = property_exists($row, 'slug') && !empty($row->slug) ? $row->slug : '';
        $key = $rawSlug ?: \Illuminate\Support\Str::slug($row->title ?? ('product-' . $row->id));

        $itemData = [
            'id'            => $key,
            'db_id'         => $row->id,
            'name'          => $row->title ?? 'Untitled Product',
            'title'         => $row->subtitle ?? '',
            'spec'          => !empty($row->dosage_spec) ? $row->dosage_spec : '',
            'val'           => $numericVal,
            'price'         => !empty($row->price) ? $row->price : ('RM' . number_format($numericVal, 2)),
            'category'      => !empty($row->category) ? $row->category : 'Weight Management',
            'page_type'     => $row->page_type ?? 'products',
            'imgs'          => $imgs,
            'stock'         => (int)($row->stock ?? 0),
            'variant_title' => !empty($row->variant_title) ? $row->variant_title : 'Select Vial Concentration / Dosage:',
            'variants'      => $variants,
            'sizes'         => $sizes,
            'desc'          => !empty($row->description) ? $row->description : ($allProducts[$key]['desc'] ?? 'High-purity laboratory formulation verified with third-party quality control.'),
        ];

        $allProducts[$key] = $itemData;
        $allProducts[\Illuminate\Support\Str::slug($row->title ?? '')] = $itemData;
        $allProducts[strtolower(trim($row->title ?? ''))] = $itemData;
        $allProducts[(string)$row->id] = $itemData;
    }
} catch (\Throwable $e) {}

$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(2) ?? 'retatrutide';
if (is_object($reqKey)) {
    $reqKey = $reqKey->slug ?? $reqKey->id ?? 'retatrutide';
}
$reqKey = urldecode((string)$reqKey);

$currProd = $allProducts[$reqKey]
    ?? $allProducts[strtolower($reqKey)]
    ?? $allProducts[\Illuminate\Support\Str::slug($reqKey)]
    ?? reset($allProducts);

$hasVariants = !empty($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel   = ($currProd['category'] === 'Apparel') || (!empty($currProd['sizes']) && count($currProd['sizes']) > 0);
$isAccessory = ($currProd['page_type'] ?? '') === 'accessory' 
    || in_array($currProd['category'] ?? '', ['Accessory', 'Injection Kit', 'Syringes']) 
    || request()->is('accessory*');
@endphp

<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap');

  :root {
    --bg:#FFFFFF;--bg2:#E9F2FA;--ink:#1E2D3B;--mut:#5A6F82;--green:#2F6F9F;
    --line:#D2E2EF;--card:#F6FAFD;--gold:#3F84B5;--red:#e11d48;
    --serif:'Cormorant Garamond',Georgia,serif;--sans:'Inter',system-ui,sans-serif;
  }

  .hero, .hero.sl, .mq, #lab-reports, #testimonies, .camp, .steps, .art, .g6, .div2,
  section.sec:not(#productDetailSec) {
    display: none !important;
  }

  #productDetailSec {
    display: block !important;
    padding: 60px 0 80px !important;
    background: var(--bg) !important;
  }
  #productDetailSec .wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  #productDetailSec h1 {
    font-family: var(--serif);
    font-weight: 500;
    line-height: 1.15;
    font-size: clamp(28px, 4vw, 44px);
    color: var(--ink);
  }

  .detail-grid {
    display: grid !important;
    grid-template-columns: 1.15fr 1fr !important;
    gap: 48px !important;
    align-items: start !important;
  }
  .detail-media-wrap {
    max-width: 580px !important;
    width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
  }
  .detail-img-wrap {
    aspect-ratio: 1 !important;
    width: 100% !important;
    border-radius: 28px !important;
    overflow: hidden !important;
    border: 1px solid var(--line) !important;
    background: #ffffff !important;
    position: relative !important;
  }

  .prod-slider {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: inherit;
    background: #fff;
  }
  .prod-slides {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    overflow: hidden;
    background: #fff;
  }
  .prod-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity .65s ease-in-out;
    pointer-events: none;
    border-radius: inherit;
    overflow: hidden;
    background: #fff;
  }
  .prod-slide.active {
    opacity: 1 !important;
    pointer-events: auto !important;
  }
  .prod-slide>img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: inherit;
    display: block;
    background: #fff;
  }
  .prod-slide.contain-slide {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 18px !important;
    background: #fff !important;
  }
  .prod-slide.contain-slide>img {
    width: auto !important;
    height: auto !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: contain !important;
    border-radius: 22px !important;
    background: #fff;
    box-shadow: 0 4px 14px rgba(14,40,66,.06);
    flex-shrink: 0;
  }

  .detail-media-wrap .ps-dots {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 14px;
    margin-bottom: 2px;
    z-index: 5;
  }
  .detail-media-wrap .ps-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--line);
    cursor: pointer;
    transition: all .25s ease;
  }
  .detail-media-wrap .ps-dot:hover {
    background: var(--mut);
  }
  .detail-media-wrap .ps-dot.active {
    background: var(--green);
    width: 22px;
    border-radius: 999px;
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
    .detail-grid { grid-template-columns: 1fr !important; }
    .detail-media-wrap { max-width: 480px !important; margin: 0 auto; width: 100% !important; }
    #productDetailSec { padding: 40px 0 60px !important; }
  }
</style>

<section class="sec" id="productDetailSec">
  <div class="wrap">
    <div style="margin-bottom:24px">
      @if($isAccessory)
        <a href="{{ route('accessory') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Accessories</a>
      @else
        <a href="{{ route('products.index') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Catalog</a>
      @endif
    </div>

    <div class="detail-grid">
      <div class="detail-media-wrap">
        <div class="detail-img-wrap prod-slider">
          <div class="prod-slides">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <div class="prod-slide {{ $idx === 0 ? 'active' : '' }} contain-slide">
                <img src="{{ $resolveImageUrl($imgFile) }}" 
                     alt="{{ $currProd['name'] }} Slide {{ $idx + 1 }}" 
                     onload="fitRoundedImg(this)"
                     onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1000'">
              </div>
            @endforeach
          </div>
        </div>

        @if(count($currProd['imgs']) > 1)
          <div class="ps-dots">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <span class="ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="setImgSlide(this, {{ $idx }})"></span>
            @endforeach
          </div>
        @endif
      </div>

      <div class="detail-info">
        <span class="detail-badge">{{ $currProd['category'] }}</span>
        <h1>{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" style="color:var(--mut);font-size:16px">
          {{ $currProd['title'] }}{{ !empty($currProd['spec']) ? ' (' . $currProd['spec'] . ')' : '' }}
        </p>
        <div id="detailPriceDisplay" class="detail-price">{{ $currProd['price'] }}</div>
        
        <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $currProd['stock'] }} units available)</div>

        @if($hasVariants)
        <div style="margin-top:6px;background:var(--card);padding:16px;border-radius:18px;border:1px solid var(--line)">
          <label style="font-size:12px;font-weight:700;text-transform:uppercase;color:var(--ink);display:block;margin-bottom:6px">
            {{ $currProd['variant_title'] }}
          </label>
          <div class="size-picker" id="variantPickerGroup">
            @foreach($currProd['variants'] as $vIdx => $v)
              <button type="button" class="size-btn var-btn {{ $vIdx === 0 ? 'active' : '' }}" onclick="selectProductVariant({{ $vIdx }}, this)">
                {{ $v['label'] }}
              </button>
            @endforeach
          </div>
          <small id="varHint" style="font-size:12px;color:var(--mut);display:block;margin-top:4px">
            Select a dosage above to display the exact price.
          </small>
        </div>
        @endif

        @if($isApparel)
        <div style="margin-top:10px">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <label style="font-size:12px;font-weight:600;text-transform:uppercase;color:var(--mut)">Select Size:</label>
            <a class="chart-link" onclick="openSizeModal()">View Size Chart</a>
          </div>
          <div class="size-picker" id="sizePickerGroup">
            @foreach($currProd['sizes'] as $sIdx => $sz)
              <button type="button" class="size-btn {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectProductSize('{{ $sz }}', this)">
                {{ $sz }}
              </button>
            @endforeach
          </div>
        </div>
        @endif

        <div class="detail-desc">
          <h4 style="font-family:var(--serif);font-size:20px;margin-bottom:8px">Product Overview</h4>
          <p>{{ $currProd['desc'] }}</p>
        </div>

        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1, {{ (int)$currProd['stock'] }})">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1, {{ (int)$currProd['stock'] }})">+</button>
          </div>
          <button class="btn-add-cart" onclick="triggerAddToCart()">Add to Cart</button>
        </div>

        <div style="margin-top:18px;font-size:12px;color:var(--mut);line-height:1.6;border-top:1px solid var(--line);padding-top:14px">
          • High purity formulation verified with third-party quality control.<br>
          • Secure thermal-insulated packaging for all temperature-sensitive items.<br>
          • Direct WhatsApp support available for wholesale or technical inquiries.
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal-overlay" id="sizeModal" onclick="if(event.target===this)closeSizeModal()">
  <div class="modal-content">
    <button class="modal-close" onclick="closeSizeModal()">&times;</button>
    <h3 style="font-size:24px;margin-bottom:6px;font-family:var(--serif);color:var(--ink)">Size Chart (Adult)</h3>
    <p style="font-size:13px;color:var(--mut);margin-bottom:12px">Novex Premium Athletic Jersey — All measurements in inches.</p>
    <div class="table-scroll">
      <table class="size-table">
        <thead>
          <tr><th>Size</th><th>Length (A)</th><th>Chest (B)</th><th>Shoulder</th><th>Short Sleeve</th><th>Long Sleeve</th></tr>
        </thead>
        <tbody>
          <tr><td><b>S</b></td><td>26</td><td>38</td><td>16</td><td>8.5</td><td>22.5</td></tr>
          <tr><td><b>M</b></td><td>27</td><td>40</td><td>17</td><td>9</td><td>23</td></tr>
          <tr><td><b>L</b></td><td>28</td><td>42</td><td>18</td><td>9.5</td><td>23.5</td></tr>
          <tr><td><b>XL</b></td><td>29</td><td>44</td><td>19</td><td>10</td><td>24</td></tr>
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
  let currentDetailProduct = @json($currProd);
  let currentDetailQty = 1;
  let currentDetailSize = (currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0) ? currentDetailProduct.sizes[0] : 'S';
  let currentSelectedVariant = (currentDetailProduct.variants && currentDetailProduct.variants.length > 0) ? currentDetailProduct.variants[0] : null;

  function fitRoundedImg(el){
    if(!el || !el.naturalWidth || !el.naturalHeight) return;
    const r = el.naturalWidth / el.naturalHeight;
    el.style.aspectRatio = el.naturalWidth + ' / ' + el.naturalHeight;
    if(r >= 1){
      el.style.width = '100%';
      el.style.height = 'auto';
    } else {
      el.style.height = '100%';
      el.style.width = 'auto';
    }
  }

  function setImgSlide(dot, targetIdx){
    if(window.event){
      window.event.preventDefault();
      window.event.stopPropagation();
    }
    const wrap = dot.closest('.detail-media-wrap') || document.getElementById('productDetailSec');
    if(!wrap) return;
    const box = wrap.querySelector('.prod-slider');
    if(!box) return;
    const slides = box.querySelectorAll('.prod-slide');
    const dots = wrap.querySelectorAll('.ps-dot');
    slides.forEach((s, idx)=>s.classList.toggle('active', idx === targetIdx));
    dots.forEach((d, idx)=>d.classList.toggle('active', idx === targetIdx));
  }

  function changeDetailQty(delta, maxStock){
    const limit = currentSelectedVariant ? currentSelectedVariant.stock : maxStock;
    currentDetailQty = Math.max(1, Math.min(limit > 0 ? limit : 99, currentDetailQty + delta));
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

  function selectProductVariant(idx, btnEl){
    if(!currentDetailProduct.variants || !currentDetailProduct.variants[idx]) return;
    const v = currentDetailProduct.variants[idx];
    currentSelectedVariant = v;

    const group = document.getElementById('variantPickerGroup');
    if(group) {
      group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    }
    if(btnEl) btnEl.classList.add('active');

    const priceEl = document.getElementById('detailPriceDisplay');
    const subEl = document.getElementById('detailSubDisplay');
    const stockEl = document.getElementById('detailStockDisplay');
    const hintEl = document.getElementById('varHint');

    if(priceEl) priceEl.innerText = v.p;
    if(subEl) subEl.innerText = `${currentDetailProduct.title} (${v.label})`;
    if(stockEl) stockEl.innerText = `In Stock (${v.stock} units available)`;
    if(hintEl) hintEl.style.display = 'none';

    if(currentDetailQty > v.stock && v.stock > 0){
      currentDetailQty = 1;
      const qEl = document.getElementById('detailQtyInput');
      if(qEl) qEl.value = 1;
    }
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
    if (typeof addToCartFromDetail === 'function') {
      addToCartFromDetail(currentDetailProduct.id);
      return;
    }

    let cart = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
    let itemSpec = currentDetailProduct.spec;
    let itemVal = currentDetailProduct.val;
    let itemLabel = currentDetailProduct.name;

    if(currentSelectedVariant){
      itemSpec = currentSelectedVariant.label;
      itemVal = currentSelectedVariant.val;
    } else if(currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0){
      itemSpec = 'Size: ' + currentDetailSize;
    }

    const existing = cart.find(x => x.id === currentDetailProduct.id && x.s === itemSpec);
    if(existing){
      existing.qty += currentDetailQty;
    } else {
      cart.push({
        id: currentDetailProduct.id,
        n: itemLabel,
        s: itemSpec,
        val: itemVal,
        i: currentDetailProduct.imgs[0],
        qty: currentDetailQty
      });
    }

    localStorage.setItem('nvx_cart', JSON.stringify(cart));
    const badge = document.getElementById('cartCount');
    if(badge){
      badge.innerText = cart.reduce((acc, item) => acc + item.qty, 0);
    }
    alert('✓ Added to cart: ' + itemLabel + ' (' + itemSpec + ')');
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.contain-slide img').forEach(el => {
      if(el.complete) fitRoundedImg(el);
    });

    if (@json($isAccessory)) {
      document.querySelectorAll('nav.dnav a, nav.mnav a').forEach(a => {
        const href = a.getAttribute('href') || '';
        const text = a.textContent.trim();
        if (href.includes('accessory') || text === 'Accessory') {
          a.classList.add('on');
        }
        if (href.includes('products') || text === 'Products') {
          a.classList.remove('on');
        }
      });
    }

    const detailSec = document.getElementById('productDetailSec');
    const footerEl = document.querySelector('footer');
    if(detailSec && footerEl && footerEl.parentNode) {
      footerEl.parentNode.insertBefore(detailSec, footerEl);
    }
  });
</script>
@endsection