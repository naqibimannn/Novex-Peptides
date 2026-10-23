@extends('frontend.home.index')

@php
// Kamus Data Penuh bagi Semua Produk & Imej Spesifik
$allProducts = [
    'retatrutide' => [
        'id' => 'retatrutide',
        'name' => 'Retatrutide',
        'title' => 'Advanced Weight Management',
        'spec' => '10mg - 100mg',
        'val' => 280,
        'price' => 'RM280.00 - RM980.00',
        'category' => 'Weight Management',
        'imgs' => ['reta1.webp', 'reta2.webp', 'reta3.webp', 'reta4.webp', 'reta5.webp'],
        'stock' => 63,
        'variants' => [
            ['label' => '10mg', 'val' => 280, 'price' => 'RM280.00', 'stock' => 25],
            ['label' => '30mg', 'val' => 480, 'price' => 'RM480.00', 'stock' => 18],
            ['label' => '60mg', 'val' => 780, 'price' => 'RM780.00', 'stock' => 12],
            ['label' => '100mg', 'val' => 980, 'price' => 'RM980.00', 'stock' => 8],
        ],
        'desc' => 'High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Select your preferred vial concentration above to view exact pricing.',
    ],
    'reta-plus' => [
        'id' => 'reta-plus',
        'name' => 'Retatrutide Plus (RETA PLUS)',
        'title' => 'Combination of Retatrutide + Cagrilintide',
        'spec' => '40mg',
        'val' => 590,
        'price' => 'RM590.00',
        'category' => 'Weight Management',
        'imgs' => ['retaplus1.webp', 'retaplus2.webp'],
        'stock' => 15,
        'desc' => 'Synergistic dual-action formulation pairing Retatrutide with Cagrilintide for comprehensive multi-target metabolic profiling.',
    ],
    'ghk-cu' => [
        'id' => 'ghk-cu',
        'name' => 'GHK-Cu',
        'title' => 'Radiant Skin & Cellular Rejuvenation',
        'spec' => '100mg',
        'val' => 180,
        'price' => 'RM180.00',
        'category' => 'Skincare Peptides',
        'imgs' => ['ghk1.webp', 'ghk2.webp'],
        'stock' => 30,
        'desc' => 'Naturally occurring copper complex tripeptide formulated for collagen matrix renewal and dermal restructuring research.',
    ],
    'nad-plus' => [
        'id' => 'nad-plus',
        'name' => 'NAD+',
        'title' => 'Radiant Skin & Cellular Rejuvenation',
        'spec' => '500mg',
        'val' => 220,
        'price' => 'RM220.00',
        'category' => 'Skincare Peptides',
        'imgs' => ['nad1.webp', 'nad2.webp'],
        'stock' => 20,
        'desc' => 'Essential coenzyme nicotinamide adenine dinucleotide (NAD+) supporting mitochondrial oxidative phosphorylation and cellular longevity.',
    ],
    'gluta' => [
        'id' => 'gluta',
        'name' => 'Glutathione',
        'title' => 'Radiant Skin & Cellular Rejuvenation',
        'spec' => '1500mg',
        'val' => 150,
        'price' => 'RM150.00',
        'category' => 'Skincare Peptides',
        'imgs' => ['glu1.webp', 'glu2.webp'],
        'stock' => 35,
        'desc' => 'Master antioxidant compound in ultra-pure lyophilised format for cellular oxidative stress mitigation and brightening assays.',
    ],
    'snap-8' => [
        'id' => 'snap-8',
        'name' => 'SNAP-8',
        'title' => 'Radiant Skin & Cellular Rejuvenation',
        'spec' => '10mg',
        'val' => 180,
        'price' => 'RM180.00',
        'category' => 'Skincare Peptides',
        'imgs' => ['snap1.webp', 'snap2.webp'],
        'stock' => 22,
        'desc' => 'Octapeptide complex engineered to study the modulation of facial muscle micro-contractions and expression lines.',
    ],
    'tesa' => [
        'id' => 'tesa',
        'name' => 'Tesamorelin',
        'title' => 'Optimise Performance & Longevity',
        'spec' => '5mg',
        'val' => 170,
        'price' => 'RM170.00',
        'category' => 'Performance',
        'imgs' => ['tesa1.webp', 'tesa2.webp'],
        'stock' => 14,
        'desc' => 'GHRH synthetic analogue investigated for endogenous growth hormone pathway regulation and body composition analysis.',
    ],
    'aicar' => [
        'id' => 'aicar',
        'name' => 'AICAR',
        'title' => 'Optimise Performance & Longevity',
        'spec' => '50mg',
        'val' => 220,
        'price' => 'RM220.00',
        'category' => 'Performance',
        'imgs' => ['aicar1.webp', 'aicar2.webp'],
        'stock' => 19,
        'desc' => 'AMPK activator compound investigated for cellular energy regulation and endurance adaptations in laboratory models.',
    ],
    'motsc' => [
        'id' => 'motsc',
        'name' => 'MOTS-C',
        'title' => 'Optimise Performance & Longevity',
        'spec' => '20mg',
        'val' => 180,
        'price' => 'RM180.00',
        'category' => 'Performance',
        'imgs' => ['mot1.webp', 'mot2.webp'],
        'stock' => 16,
        'desc' => 'Mitochondrial-derived peptide associated with insulin sensitivity and metabolic balance under physical strain.',
    ],
    'glutaglow-serum' => [
        'id' => 'glutaglow-serum',
        'name' => 'GlutaGlow Serum',
        'title' => 'Advanced Skincare For A Brighter You',
        'spec' => '10ml',
        'val' => 59.90,
        'price' => 'RM59.90',
        'category' => 'Skincare Collection',
        'imgs' => ['gluta1.webp', 'gluta2.webp', 'gluta3.webp', 'gluta4.webp'],
        'stock' => 40,
        'desc' => 'Concentrated brightening facial serum formulated with high-purity glutathione and peptide complexes for a radiant, even-toned complexion.',
    ],
    'ghk-cu-serum' => [
        'id' => 'ghk-cu-serum',
        'name' => 'GHK-Cu Serum',
        'title' => 'Advanced Skincare For A Brighter You',
        'spec' => '30ml',
        'val' => 79.90,
        'price' => 'RM79.90',
        'category' => 'Skincare Collection',
        'imgs' => ['ghks1.webp', 'ghks2.webp', 'ghks3.webp', 'ghks4.webp'],
        'stock' => 35,
        'desc' => 'Daily restorative copper peptide serum (30ml) designed to support skin elasticity, firmness, and barrier repair.',
    ],
    'glutathione-cream' => [
        'id' => 'glutathione-cream',
        'name' => 'Glutathione Cream',
        'title' => 'Advanced Skincare For A Brighter You',
        'spec' => 'Standard',
        'val' => 39.90,
        'price' => 'RM39.90',
        'category' => 'Skincare Collection',
        'imgs' => ['glc1.webp', 'glc2.webp', 'glc3.webp', 'glc4.webp'],
        'stock' => 45,
        'desc' => 'Nourishing antioxidant moisture cream enriched with glutathione to lock in hydration and promote luminous skin texture.',
    ],
    'jersey-01' => [
        'id' => 'jersey-01',
        'name' => 'Premium Athletic Jersey',
        'title' => 'Performance. Style. Everyday.',
        'spec' => 'Adult Size',
        'val' => 40,
        'price' => 'RM40.00',
        'category' => 'Apparel',
        'imgs' => ['jry1.webp', 'jry2.webp'],
        'sizes' => ['S', 'M', 'L', 'XL'],
        'stock' => 50,
        'desc' => 'Official Novex Peptides merchandise. Crafted with lightweight, breathable, and moisture-wicking hexagonal weave fabric. Features premium V-neck design and durable finish.',
    ]
];

// Pengecaman ID produk daripada pembolehubah Controller ataupun Parameter URL
$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(2) ?? 'retatrutide';
if(is_object($reqKey)) {
    $reqKey = $reqKey->id ?? $reqKey->slug ?? 'retatrutide';
}
$currProd = $allProducts[$reqKey] ?? $allProducts['retatrutide'];
$hasVariants = isset($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel = isset($currProd['sizes']) && count($currProd['sizes']) > 0;
@endphp

@section('content')
<style>
.detail-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:48px;align-items:start}

/* Saiz & Bingkai Gambar Mengikut Standard Terkini (Crop Minimum, Tanpa Stretch) */
.detail-img-wrap{
  aspect-ratio:4/5;
  max-width:540px;
  width:100%;
  border-radius:24px;
  overflow:hidden;
  border:1px solid var(--line);
  background:#ffffff;
  position:relative;
  margin:0 auto;
}
.detail-img-wrap .prod-slide{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  opacity:0;
  transition:opacity .45s ease-in-out;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#fff;
  padding:0;
  overflow:hidden;
}
.detail-img-wrap .prod-slide.active{opacity:1;pointer-events:auto}
.detail-img-wrap .prod-slide img{
  width:100% !important;
  height:100% !important;
  object-fit:cover !important;
  object-position:center !important;
  border-radius:inherit;
  display:block;
}
.detail-img-wrap .ps-dots{
  position:absolute;
  bottom:16px;
  left:0;
  right:0;
  z-index:5;
  display:flex;
  justify-content:center;
  gap:8px;
}
.detail-img-wrap .ps-dot{
  width:9px;
  height:9px;
  border-radius:50%;
  background:rgba(255,255,255,.75);
  cursor:pointer;
  transition:all .3s ease;
  box-shadow:0 1px 4px rgba(0,0,0,.4);
}
.detail-img-wrap .ps-dot.active{
  background:var(--green);
  transform:scale(1.25);
}

.detail-info{display:flex;flex-direction:column;gap:16px}
.detail-badge{
  display:inline-block;
  background:var(--bg2);
  color:var(--green);
  padding:6px 14px;
  border-radius:999px;
  font-size:12px;
  font-weight:600;
  letter-spacing:.04em;
  align-self:flex-start;
}
.detail-price{
  font-size:clamp(26px,3vw,34px);
  font-weight:700;
  color:var(--green);
  font-family:var(--serif);
}
.stock-badge{
  display:inline-flex;
  align-items:center;
  font-size:13px;
  font-weight:600;
  color:#1ebe5a;
  background:rgba(37,211,102,.12);
  padding:5px 14px;
  border-radius:999px;
  align-self:flex-start;
}
.detail-desc{
  font-size:14px;
  line-height:1.7;
  color:#3A4D5E;
  border-top:1px solid var(--line);
  border-bottom:1px solid var(--line);
  padding:20px 0;
}

.size-picker{display:flex;gap:8px;flex-wrap:wrap;margin:8px 0}
.size-btn{
  border:1px solid var(--line);
  background:#fff;
  padding:8px 16px;
  font-size:13px;
  font-weight:600;
  border-radius:10px;
  cursor:pointer;
  transition:all .2s ease;
}
.size-btn:hover{border-color:var(--green)}
.size-btn.active{background:var(--green);color:#fff;border-color:var(--green)}
.chart-link{font-size:12px;color:var(--gold);text-decoration:underline;cursor:pointer;font-weight:500;display:inline-block}

.qty-row{display:flex;align-items:center;gap:16px;margin-top:8px;flex-wrap:wrap}
.qty-box{display:inline-flex;align-items:center;border:1px solid var(--line);border-radius:999px;background:var(--card);overflow:hidden}
.qty-box button{width:40px;height:40px;background:none;border:none;font-size:17px;font-weight:600;display:flex;align-items:center;justify-content:center;cursor:pointer}
.qty-box button:hover{background:var(--bg2)}
.qty-box input{width:46px;text-align:center;border:0;background:none;font-weight:600;font-size:14px}

.btn-add-cart{
  background:var(--green);
  color:#fff;
  padding:14px 28px;
  font-weight:600;
  font-size:14px;
  border-radius:999px;
  flex:1;
  min-width:180px;
  text-align:center;
  cursor:pointer;
  border:none;
  transition:background .2s ease, transform .1s ease;
}
.btn-add-cart:hover{background:#245a82}
.btn-add-cart:active{transform:scale(0.98)}

/* Cart Slide-in Drawer */
.cart-overlay{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.5);
  z-index:999;
  display:none;
  backdrop-filter:blur(3px);
}
.cart-overlay.open{display:block}
.cart-drawer{
  position:fixed;
  right:0;
  top:0;
  bottom:0;
  width:100%;
  max-width:460px;
  background:#fff;
  z-index:1000;
  transform:translateX(100%);
  transition:transform .3s ease;
  display:flex;
  flex-direction:column;
  box-shadow:-10px 0 30px rgba(0,0,0,.15);
}
.cart-drawer.open{transform:translateX(0)}
.cart-header{
  padding:20px 22px;
  border-bottom:1px solid var(--line);
  display:flex;
  justify-content:space-between;
  align-items:center;
}
.cart-items{
  padding:18px 22px;
  overflow-y:auto;
  flex:1;
  display:flex;
  flex-direction:column;
  gap:14px;
}
.cart-item{
  display:grid;
  grid-template-columns:60px 1fr auto auto;
  gap:12px;
  align-items:center;
  border-bottom:1px solid var(--line);
  padding-bottom:14px;
}
.cart-item-img{
  aspect-ratio:1;
  border-radius:12px;
  overflow:hidden;
  background:#ffffff;
  border:1px solid var(--line);
}
.cart-item-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}
.cart-del-btn{
  background:none;
  border:none;
  color:var(--red);
  padding:8px;
  cursor:pointer;
  border-radius:8px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  transition:background .2s,color .2s;
}
.cart-del-btn:hover{background:#ffe4e6;color:#be123c}
.cart-footer{
  padding:20px 22px;
  border-top:1px solid var(--line);
  background:var(--card);
}
.cart-total-row{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:16px;
  font-size:16px;
}
.cart-total-price{
  font-size:24px;
  font-weight:700;
  color:var(--green);
  font-family:var(--serif);
}
.btn-wa-proceed{
  width:100%;
  background:#25D366;
  color:#fff;
  padding:15px;
  border-radius:999px;
  font-weight:700;
  font-size:14px;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  border:none;
  cursor:pointer;
  transition:background .2s;
}
.btn-wa-proceed:hover{background:#1ebe5a}
.btn-wa-proceed svg{width:20px;height:20px;fill:#fff}

.toast{
  position:fixed;
  bottom:24px;
  left:50%;
  transform:translateX(-50%) translateY(100px);
  background:var(--ink);
  color:#fff;
  padding:12px 24px;
  border-radius:999px;
  font-size:13px;
  font-weight:500;
  box-shadow:0 10px 25px rgba(0,0,0,.2);
  z-index:9999;
  opacity:0;
  transition:all .3s ease;
  pointer-events:none;
}
.toast.show{transform:translateX(-50%) translateY(0);opacity:1}
.flying-img{
  position:fixed;
  z-index:99999;
  pointer-events:none;
  object-fit:cover;
  box-shadow:0 14px 32px rgba(47,111,159,.4);
  will-change:transform,top,left,width,height,opacity;
}

/* Modal Saiz Pakaian */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:999;display:none;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(4px)}
.modal-overlay.open{display:flex}
.modal-content{background:#fff;border-radius:20px;max-width:540px;width:100%;padding:28px;position:relative;box-shadow:0 20px 40px rgba(0,0,0,.2);max-height:90vh;overflow-y:auto}
.modal-close{position:absolute;top:16px;right:16px;background:none;border:none;font-size:22px;color:var(--mut);cursor:pointer}
.table-scroll{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;margin:16px 0}
.size-table{width:100%;border-collapse:collapse;font-size:13px;text-align:center;min-width:440px}
.size-table th,.size-table td{border:1px solid var(--line);padding:10px 8px}
.size-table th{background:var(--bg2);color:var(--green);font-weight:600}

@media(max-width:900px){
  .detail-grid{grid-template-columns:1fr}
  .detail-img-wrap{max-width:440px}
}
@media(max-width:640px){
  .cart-drawer{max-width:100%}
  .cart-item{grid-template-columns:52px 1fr auto auto;gap:8px}
}
</style>

<section class="sec">
  <div class="wrap">
    <div style="margin-bottom:24px">
      <a href="{{ route('products.index') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Catalog</a>
    </div>

    <div class="detail-grid">
      <!-- 1. Galeri Slaid Mengikut Imej Spesifik Produk -->
      <div class="detail-img-wrap">
        @foreach($currProd['imgs'] as $idx => $imgFile)
          <div class="prod-slide {{ $idx === 0 ? 'active' : '' }}" id="slide{{ $idx }}">
            <img src="{{ asset($imgFile) }}" alt="{{ $currProd['name'] }} Image {{ $idx + 1 }}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800'">
          </div>
        @endforeach

        @if(count($currProd['imgs']) > 1)
          <div class="ps-dots">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <span class="ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="showProductSlide({{ $idx }}, this)"></span>
            @endforeach
          </div>
        @endif
      </div>

      <!-- 2. Maklumat Dinamik Mengikut Produk Terpilih -->
      <div class="detail-info">
        <span class="detail-badge">{{ $currProd['category'] }}</span>
        <h1 style="font-size:clamp(28px, 4vw, 42px);margin:4px 0">{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" style="color:var(--mut);font-size:16px">{{ $currProd['title'] }} ({{ $currProd['spec'] }})</p>
        
        <div id="detailPriceDisplay" class="detail-price">{{ $currProd['price'] }}</div>
        
        <div id="detailStockDisplay" class="stock-badge">In Stock ({{ $currProd['stock'] }} units available)</div>

        <!-- Pemilih Varian Dos (Sekiranya Ada, cth: Retatrutide) -->
        @if($hasVariants)
        <div style="background:var(--card);padding:16px;border-radius:18px;border:1px solid var(--line);margin-top:6px">
          <label style="font-size:12px;font-weight:700;text-transform:uppercase;color:var(--ink);display:block;margin-bottom:6px">
            Select Vial Concentration / Dosage:
          </label>
          <div class="size-picker">
            @foreach($currProd['variants'] as $vIdx => $variant)
              <button type="button" class="size-btn {{ $vIdx === 0 ? 'active' : '' }}" onclick="selectVariant('{{ $variant['label'] }}', {{ $variant['val'] }}, '{{ $variant['price'] }}', {{ $variant['stock'] }}, this)">
                {{ $variant['label'] }}
              </button>
            @endforeach
          </div>
          <small id="varHint" style="font-size:12px;color:var(--mut);display:block;margin-top:4px">
            Select a dosage above to view exact pricing and available laboratory stock.
          </small>
        </div>
        @endif

        <!-- Pemilih Saiz Pakaian (Sekiranya Ada, cth: Jersey) -->
        @if($isApparel)
        <div style="margin-top:6px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
            <label style="font-size:12px;font-weight:600;text-transform:uppercase;color:var(--mut)">Select Size:</label>
            <a class="chart-link" onclick="openSizeModal()">View Size Chart</a>
          </div>
          <div class="size-picker">
            @foreach($currProd['sizes'] as $sIdx => $sz)
              <button type="button" class="size-btn {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectSize('{{ $sz }}', this)">
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

        <!-- Stepper Kuantiti & Butang Add to Cart -->
        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1)" aria-label="Decrease quantity">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1)" aria-label="Increase quantity">+</button>
          </div>
          
          <button type="button" class="btn-add-cart" onclick="addToCartFromDetail()">Add to Cart</button>
        </div>

        <div style="margin-top:12px;font-size:12px;color:var(--mut);line-height:1.6;border-top:1px solid var(--line);padding-top:14px">
          • High purity formulation verified with third-party quality control.<br>
          • Secure thermal-insulated packaging for all temperature-sensitive items.<br>
          • Direct WhatsApp support available for wholesale or technical inquiries.
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Notifikasi Toast -->
<div class="toast" id="toastMsg">✓ Added to cart</div>

<!-- Slide-in Cart Drawer & Checkout WhatsApp -->
<div class="cart-overlay" id="cartOverlay" onclick="closeCartDrawer()"></div>
<div class="cart-drawer" id="cartDrawer">
  <div class="cart-header">
    <h3 style="font-size:22px">Your Research Cart</h3>
    <button onclick="closeCartDrawer()" style="background:none;border:none;font-size:24px;color:var(--mut);cursor:pointer">&times;</button>
  </div>
  <div class="cart-items" id="cartItemsList"></div>
  <div class="cart-footer">
    <div class="cart-total-row">
      <span style="font-weight:600">Total Order:</span>
      <span class="cart-total-price" id="cartTotal">RM 0.00</span>
    </div>
    <button class="btn-wa-proceed" onclick="proceedToWhatsApp()">
      <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
      Click To Proceed
    </button>
  </div>
</div>

<!-- Modal Carta Saiz (Untuk Produk Pakaian) -->
<div class="modal-overlay" id="sizeModal" onclick="if(event.target===this)closeSizeModal()">
  <div class="modal-content">
    <button class="modal-close" onclick="closeSizeModal()">&times;</button>
    <h3 style="font-size:24px;margin-bottom:6px">Size Chart (Adult)</h3>
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
  </div>
</div>

<script>
const WA = '601112085054';

// Data Produk Semasa
const currentProduct = @json($currProd);
let currentSelectedDosage = currentProduct.variants ? currentProduct.variants[0].label : null;
let currentSelectedSize = currentProduct.sizes ? currentProduct.sizes[0] : null;
let currentUnitVal = currentProduct.variants ? currentProduct.variants[0].val : currentProduct.val;
let currentMaxStock = currentProduct.variants ? currentProduct.variants[0].stock : currentProduct.stock;
let currentQty = 1;

function showProductSlide(idx, dotEl){
  document.querySelectorAll('.detail-img-wrap .prod-slide').forEach((s, i) => {
    s.classList.toggle('active', i === idx);
  });
  document.querySelectorAll('.detail-img-wrap .ps-dot').forEach((d, i) => {
    d.classList.toggle('active', i === idx);
  });
}

function selectVariant(dosage, priceNum, priceFormatted, stock, btnEl){
  currentSelectedDosage = dosage;
  currentUnitVal = priceNum;
  currentMaxStock = stock;
  if(currentQty > stock) currentQty = 1;

  document.querySelectorAll('.size-picker .size-btn').forEach(b => b.classList.remove('active'));
  btnEl.classList.add('active');

  document.getElementById('detailPriceDisplay').innerText = priceFormatted;
  document.getElementById('detailSubDisplay').innerText = `${currentProduct.title} (${dosage})`;
  document.getElementById('detailStockDisplay').innerText = `In Stock (${stock} units available)`;
  document.getElementById('detailQtyInput').value = currentQty;
}

function selectSize(size, btnEl){
  currentSelectedSize = size;
  btnEl.closest('.size-picker').querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
  btnEl.classList.add('active');
}

function changeDetailQty(delta){
  currentQty = Math.max(1, Math.min(currentMaxStock, currentQty + delta));
  document.getElementById('detailQtyInput').value = currentQty;
}

function openSizeModal(){ document.getElementById('sizeModal').classList.add('open'); }
function closeSizeModal(){ document.getElementById('sizeModal').classList.remove('open'); }

// Pengurusan Keranjang / Cart Drawer
let CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');

function saveCart(){
  localStorage.setItem('nvx_cart', JSON.stringify(CART));
  updateCartBadge();
}

function updateCartBadge(){
  const count = CART.reduce((acc, item) => acc + item.qty, 0);
  const badge = document.getElementById('cartCount');
  if(badge) badge.innerText = count;
}

function showToast(msg){
  const t = document.getElementById('toastMsg');
  if(!t) return;
  t.innerText = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2200);
}

function addToCartFromDetail(){
  let itemSpec = currentProduct.spec;
  let itemSizeLabel = null;

  if(currentSelectedDosage){
    itemSpec = currentSelectedDosage;
    itemSizeLabel = `Dosage: ${currentSelectedDosage}`;
  } else if(currentSelectedSize){
    itemSizeLabel = `Size: ${currentSelectedSize}`;
  }

  const existing = CART.find(x => x.id === currentProduct.id && x.size === itemSizeLabel);

  if(existing){
    existing.qty += currentQty;
  } else {
    CART.push({
      id: currentProduct.id,
      n: currentProduct.name,
      s: itemSpec,
      val: currentUnitVal,
      i: currentProduct.imgs[0],
      size: itemSizeLabel,
      qty: currentQty
    });
  }

  saveCart();

  const mainImgEl = document.querySelector('.detail-img-wrap .prod-slide.active img') || document.querySelector('.detail-img-wrap img');
  triggerFlyAnimation(mainImgEl);

  showToast('✓ Added to cart');

  setTimeout(() => {
    openCartDrawer();
  }, 450);
}

function openCartDrawer(){
  renderCart();
  document.getElementById('cartOverlay').classList.add('open');
  document.getElementById('cartDrawer').classList.add('open');
}

function closeCartDrawer(){
  document.getElementById('cartOverlay').classList.remove('open');
  document.getElementById('cartDrawer').classList.remove('open');
}

function changeCartQty(index, delta){
  if(!CART[index]) return;
  CART[index].qty += delta;
  if(CART[index].qty <= 0){
    CART.splice(index, 1);
  }
  saveCart();
  renderCart();
}

function removeCartItem(index){
  if(!CART[index]) return;
  CART.splice(index, 1);
  saveCart();
  renderCart();
  showToast('Item removed from cart');
}

function renderCart(){
  const listEl = document.getElementById('cartItemsList');
  const totalEl = document.getElementById('cartTotal');
  if(!listEl) return;

  if(CART.length === 0){
    listEl.innerHTML = `
      <div style="text-align:center;padding:48px 0;color:var(--mut)">
        <p style="font-size:16px;margin-bottom:8px">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" onclick="closeCartDrawer()" class="btn" style="padding:8px 20px;font-size:12px">Explore Products</a>
      </div>
    `;
    totalEl.innerText = 'RM 0.00';
    return;
  }

  let total = 0;
  listEl.innerHTML = CART.map((item, idx) => {
    const subtotal = item.val * item.qty;
    total += subtotal;
    const detailLabel = item.size ? item.size : item.s;
    const imgSrc = item.i.startsWith('http') ? item.i : `{{ asset('') }}/${item.i}`.replace(/([^:]\/)\/+/g, "$1");

    return `
      <div class="cart-item">
        <div class="cart-item-img">
          <img src="${imgSrc}" alt="${item.n}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=150'">
        </div>
        <div>
          <h4 style="font-size:14px;line-height:1.25;margin-bottom:3px">${item.n}</h4>
          <span style="font-size:12px;color:var(--mut)">${detailLabel} • RM ${item.val.toFixed(2)}</span>
          <div style="font-size:13px;font-weight:700;color:var(--green);margin-top:4px">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box" style="transform:scale(0.85);transform-origin:center">
            <button onclick="changeCartQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input type="text" readonly value="${item.qty}">
            <button onclick="changeCartQty(${idx}, 1)" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div>
          <button type="button" class="cart-del-btn" onclick="removeCartItem(${idx})" aria-label="Delete ${item.n}" title="Delete item">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              <line x1="10" y1="11" x2="10" y2="17"></line>
              <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
          </button>
        </div>
      </div>
    `;
  }).join('');

  totalEl.innerText = `RM ${total.toFixed(2)}`;
}

function proceedToWhatsApp(){
  if(CART.length === 0){
    alert('Please add products to your cart first.');
    return;
  }

  let total = 0;
  let itemsText = '';
  CART.forEach((item, index) => {
    const subtotal = item.val * item.qty;
    total += subtotal;
    const detail = item.size ? `(${item.size})` : `(${item.s})`;
    itemsText += `${index + 1}. *${item.n}* ${detail}\n   • Quantity: ${item.qty} unit/vial\n   • Price: RM${item.val.toFixed(2)} x ${item.qty} = RM${subtotal.toFixed(2)}\n\n`;
  });

  const message = 
`Hello Novex Peptides, I would like to place an order for the following items:

${itemsText}*Total Order: RM ${total.toFixed(2)}*

Please confirm stock availability and payment / shipping details. Thank you!`;

  const url = `https://wa.me/${WA}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
}

function triggerFlyAnimation(sourceImgEl){
  const cartBtn = document.querySelector('.cart-trigger-btn') || document.getElementById('headerCartBtn');
  if(!sourceImgEl || !cartBtn) return;

  const srcRect = sourceImgEl.getBoundingClientRect();
  const destRect = cartBtn.getBoundingClientRect();

  const imgSrc = sourceImgEl.currentSrc || sourceImgEl.src;
  const flyer = document.createElement('img');
  flyer.src = imgSrc;
  flyer.className = 'flying-img';

  flyer.style.position = 'fixed';
  flyer.style.top = srcRect.top + 'px';
  flyer.style.left = srcRect.left + 'px';
  flyer.style.width = srcRect.width + 'px';
  flyer.style.height = srcRect.height + 'px';
  flyer.style.borderRadius = '24px';
  flyer.style.opacity = '1';
  flyer.style.transition = 'all 0.75s cubic-bezier(0.2, 0.9, 0.3, 1)';

  document.body.appendChild(flyer);
  flyer.getBoundingClientRect();

  const destX = destRect.left + (destRect.width / 2) - 15;
  const destY = destRect.top + (destRect.height / 2) - 15;

  requestAnimationFrame(() => {
    flyer.style.top = destY + 'px';
    flyer.style.left = destX + 'px';
    flyer.style.width = '30px';
    flyer.style.height = '30px';
    flyer.style.borderRadius = '50%';
    flyer.style.opacity = '0.3';
    flyer.style.transform = 'scale(0.4)';
  });

  setTimeout(() => {
    flyer.remove();
    cartBtn.classList.add('cart-bump');
    setTimeout(() => cartBtn.classList.remove('cart-bump'), 350);
  }, 760);
}

document.addEventListener('DOMContentLoaded', () => {
  updateCartBadge();
  const headerCartBtn = document.querySelector('.cart-trigger-btn');
  if(headerCartBtn){
    headerCartBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openCartDrawer();
    });
  }
});
</script>
@endsection