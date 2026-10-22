<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Novex Peptides | Precision in Every Molecule</title>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#FFFFFF;--bg2:#E9F2FA;--ink:#1E2D3B;--mut:#5A6F82;--green:#2F6F9F;
  --line:#D2E2EF;--card:#F6FAFD;--gold:#3F84B5;--red:#e11d48;
  --serif:'Cormorant Garamond',Georgia,serif;--sans:'Inter',system-ui,sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{background:var(--bg);color:var(--ink);font:15px/1.65 var(--sans);overflow-x:hidden}
img{display:block;width:100%;height:100%;object-fit:cover;background:#ffffff}
a{color:inherit;text-decoration:none}
button{font:inherit;cursor:pointer;border:0}
:focus-visible{outline:2px solid var(--green);outline-offset:2px}
h1,h2,h3,h4{font-family:var(--serif);font-weight:500;line-height:1.15}
h1{font-size:clamp(34px,5.5vw,72px)}h2{font-size:clamp(26px,3.8vw,44px)}h3{font-size:clamp(20px,2.5vw,26px)}
.wrap{max-width:1200px;margin:0 auto;padding:0 24px}
.sec{padding:80px 0;background:var(--bg)}
.alt{background:var(--bg2)}
.btn{display:inline-block;background:var(--green);color:#fff;padding:12px 26px;font-size:13px;letter-spacing:.04em;transition:all .2s ease;text-align:center;border-radius:999px;touch-action:manipulation}
.btn:hover{background:#245a82}
.btn.line{background:none;border:1px solid currentColor;color:inherit}

/* Header & Navigasi */
.top{background:var(--green);color:#E3EFF8;font-size:12px;text-align:center;padding:7px 12px;letter-spacing:.03em}
header{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.98);border-bottom:1px solid var(--line);box-shadow:0 2px 8px rgba(0,0,0,.03);margin:0}
.bar{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;height:78px;gap:20px;position:relative}
nav.dnav{display:flex;gap:24px;font-size:13px;font-weight:500}
nav.dnav a{padding:6px 0;border-bottom:1px solid transparent;transition:color .2s,border-color .2s}
nav.dnav a.on,nav.dnav a:hover{border-color:var(--gold);color:var(--green)}
.logo{text-align:center;font-family:var(--serif);font-size:32px;font-weight:600;line-height:1;letter-spacing:.06em;color:var(--ink)}
.logo small{display:block;font:500 9px var(--sans);letter-spacing:.38em;margin-top:5px;color:var(--gold)}
.rt{display:flex;align-items:center;justify-content:flex-end;gap:20px}
.tools{display:flex;align-items:center;gap:12px}

.burger-btn{display:none;background:none;border:1px solid var(--line);padding:7px;border-radius:10px;cursor:pointer;align-items:center;justify-content:center;color:var(--ink);transition:all .2s ease}
.burger-btn:hover{background:var(--bg2);border-color:var(--gold)}
.burger-btn.open .icon-open{display:none}
.burger-btn.open .icon-close{display:block !important}

.mnav{display:none}
.mnav.open{display:flex;position:absolute;top:100%;left:0;right:0;background:rgba(255,255,255,.99);backdrop-filter:blur(10px);flex-direction:column;gap:0;padding:12px 24px 24px;border-bottom:1px solid var(--line);box-shadow:0 16px 32px rgba(14,40,66,.12);z-index:99}
.mnav a{padding:14px 0;border-bottom:1px solid var(--line);font-size:15px;font-weight:500;color:var(--ink)}
.mnav a:hover, .mnav a.on{color:var(--green);font-weight:600}
.mnav-shop-btn{margin-top:16px;width:100%;display:block;text-align:center;padding:13px 20px;font-size:14px;font-weight:600;border-radius:999px;background:var(--green);color:#fff !important;border-bottom:none !important}

.cart-trigger-btn{position:relative;background:none;border:0;color:var(--green);padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .2s ease}
.cart-trigger-btn:hover{transform:scale(1.12)}
.cart-trigger-btn svg{width:25px;height:25px;stroke:var(--green);stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round}
.cart-badge{position:absolute;top:-2px;right:-5px;background:var(--red);color:#fff;border-radius:999px;font-size:10px;min-width:18px;height:18px;line-height:18px;text-align:center;font-weight:700;padding:0 4px;border:2px solid #fff}

.hero{position:relative;height:calc(100vh - var(--off, 110px));min-height:520px;overflow:hidden;color:#fff;display:flex;align-items:center}
.hero>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;filter:saturate(1.08) brightness(1.05)}
.hero:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(14,40,66,.72),rgba(14,40,66,.18) 75%)}
.hero .wrap{position:relative;z-index:2;width:100%}
.hero .in{max-width:580px}
.hero p{max-width:480px;margin:18px 0 28px;font-size:16px;line-height:1.6;opacity:.92}
.hero .btn{background:#FFFFFF;color:var(--green)}
.hero .btn.line{background:none;color:#fff;margin-left:10px}

.hero.sl:before{display:none}
.slide{position:absolute;inset:0;z-index:0;opacity:0;transition:opacity 1.1s ease-in-out;display:flex;align-items:center;overflow:hidden}
.slide.on{opacity:1;z-index:1}
.slide>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
.slide:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(14,40,66,.82),rgba(14,40,66,.18) 75%)}
.ctl{position:absolute;z-index:3;bottom:28px;left:0;right:0}
.ctl .wrap{display:flex;justify-content:space-between;align-items:center}
.dots2{display:flex;gap:10px}
.dot{width:34px;height:4px;background:rgba(255,255,255,.4);padding:0;border-radius:4px;cursor:pointer;transition:all .3s ease}
.dot.on{background:#fff;width:44px}
.arr{display:flex;gap:10px}
.arr button{width:42px;height:42px;border-radius:50%;background:rgba(14,40,66,.35);border:1px solid rgba(255,255,255,.6);color:#fff;font-size:18px;cursor:pointer;backdrop-filter:blur(4px);transition:all .2s ease}

.head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;gap:20px;flex-wrap:wrap}
.head>div{display:flex;flex-direction:column;gap:8px;max-width:720px}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center}
.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
.g6{display:grid;grid-template-columns:repeat(auto-fit, minmax(170px, 1fr));gap:18px}
.ph{aspect-ratio:4/5;overflow:hidden;border-radius:24px;background:#ffffff}
.cat{position:relative;aspect-ratio:3/4;overflow:hidden;color:#fff;display:flex;align-items:end;border-radius:26px}
.cat img{position:absolute;inset:0;transition:transform .6s}
.cat:hover img{transform:scale(1.04)}
.cat:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(0deg,rgba(10,32,56,.85),transparent 60%)}
.cat div{position:relative;z-index:2;padding:20px}

.pc{padding:14px;background:#fff;border:1px solid var(--line);border-radius:26px;transition:transform .3s,box-shadow .3s;display:flex;flex-direction:column}
.pc:hover{transform:translateY(-6px);box-shadow:0 24px 44px -24px rgba(47,111,159,.5)}
.pc .ph{aspect-ratio:1;border-radius:20px;position:relative;background:#ffffff;border:1px solid rgba(210,226,239,.5);overflow:hidden}
.pc .chip{position:absolute;left:12px;top:12px;z-index:6;background:rgba(255,255,255,.9);backdrop-filter:blur(8px);color:var(--green);font-size:11px;font-weight:600;padding:5px 12px;border-radius:999px;border:1px solid rgba(210,226,239,.6)}
.pc .b{text-align:left;align-items:stretch;padding:16px 8px 8px;gap:8px;display:flex;flex-direction:column;flex:1}
.pc h3{font-size:20px;line-height:1.2}
.btn-details{background:var(--green);color:#fff;padding:12px;border-radius:999px;font-size:13px;font-weight:600;text-align:center;margin-top:10px;transition:background .2s}

.t-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.t-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:12px;display:flex;flex-direction:column;gap:14px;transition:all .3s ease}
.t-frame{position:relative;width:100%;aspect-ratio:3/2;border-radius:16px;overflow:hidden;background:#ffffff;border:1px solid rgba(210,226,239,.6);cursor:pointer}

.lab-grid{display:grid;grid-template-columns:repeat(2, 1fr);gap:40px;max-width:780px;margin:0 auto;align-items:start}
.lab-item{display:flex;flex-direction:column;gap:14px;width:100%;max-width:350px;margin:0 auto}
.lab-img-wrap{position:relative;width:100%;aspect-ratio:1 / 1.4;border-radius:18px;overflow:hidden;cursor:pointer;background:#ffffff;border:1px solid rgba(210,226,239,.95);box-shadow:0 10px 26px rgba(14,40,66,.07);transition:all .3s ease}
.lab-img-wrap img{width:100%;height:100%;object-fit:contain;padding:6px;border-radius:18px}
.lab-badge{position:absolute;top:12px;right:12px;background:rgba(30,45,59,.88);color:#fff;font-size:11px;font-weight:600;padding:5px 12px;border-radius:999px;display:flex;align-items:center;gap:5px}

footer{background:var(--green);color:#E3EFF8;padding:60px 0 24px;font-size:13px}
.fg{display:grid;grid-template-columns:1.5fr 1fr 1.3fr 1.2fr;gap:32px}
footer h4{font-family:var(--serif);font-size:20px;font-weight:500;margin-bottom:12px;color:#fff}
footer li{list-style:none;margin-bottom:6px}

@media(max-width:1080px){
 .bar{display:flex;justify-content:space-between;align-items:center;height:68px}
 nav.dnav,.btn-shop-desktop{display:none !important}
 .burger-btn{display:inline-flex}
 .logo{text-align:left;font-size:24px}
}
@media(max-width:900px){
 .g2,.div2,.fg,.t-grid{grid-template-columns:1fr}
 .g3,.g4{grid-template-columns:1fr 1fr}
 .sec{padding:54px 0}
}
@media(max-width:640px){
 .lab-grid,.g3,.g4{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="top">Made in USA. High Purity. Research Graded. Cold chain shipping worldwide.</div>

<header>
  <div class="wrap bar">
    <nav class="dnav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>
      <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'on' : '' }}">Products</a>
      <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'on' : '' }}">Science</a>
    </nav>
    
    <a href="{{ route('home') }}" class="logo">NOVEX<small>PEPTIDES</small></a>
    
    <div class="rt">
      <nav class="dnav">
        <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'on' : '' }}">Resources</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
      </nav>
      <div class="tools">
        <a class="btn btn-shop-desktop" href="{{ route('accessory') }}">Accessory</a>
        
        <a class="cart-trigger-btn" href="{{ route('cart') }}" aria-label="Shopping Cart">
          <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
          <span class="cart-badge" id="cartCount">0</span>
        </a>

        <button class="burger-btn" id="mobileBurgerBtn" onclick="toggleMobileNav()" aria-label="Toggle Menu">
          <svg class="icon-open" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
          <svg class="icon-close" style="display:none" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="mnav" id="navM">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('products.index') }}">Products</a>
    <a href="{{ route('science') }}">Science</a>
    <a href="{{ route('resources') }}">Resources</a>
    <a href="{{ route('contact') }}">Contact</a>
    <a class="btn mnav-shop-btn" href="{{ route('accessory') }}">Accessory</a>
  </nav>
</header>

<main id="app">
@hasSection('content')
    @yield('content')
@else
    <section class="hero sl">
      <div class="slide on">
        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85" alt="Lab 1">
        <div class="wrap"><div class="in"><h1>Precision in<br>Every Molecule</h1><p>Advanced peptide research. Science drives results, with premium quality made in USA.</p><a class="btn" href="{{ route('products.index') }}">Shop Now</a></div></div>
      </div>
    </section>

    <section class="sec"><div class="wrap">
      <div class="head"><div><h2>Explore by Series</h2><p>Six specialized series engineered for weight management, cellular rejuvenation, performance, and daily care.</p></div></div>
      <div class="g6">
        <a class="cat" href="{{ route('products.show', 'retatrutide') }}"><img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=700" alt="Retatrutide"><div><h3>01 | Retatrutide</h3><p>Weight Management</p></div></a>
        <a class="cat" href="{{ route('products.show', 'reta-plus') }}"><img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700" alt="Retatrutide Plus"><div><h3>02 | Retatrutide Plus</h3><p>Dual Action Formulation</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="https://images.unsplash.com/photo-1617897903246-719242758050?auto=format&fit=crop&w=700" alt="Skincare Peptides"><div><h3>03 | Skincare Peptides</h3><p>Cellular Rejuvenation</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=700" alt="Performance"><div><h3>04 | Performance</h3><p>Longevity & Power</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=700" alt="Novex Skincare"><div><h3>05 | Novex Skincare</h3><p>Serums & Cream</p></div></a>
        <a class="cat" href="{{ route('products.show', 'jersey-01') }}"><img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=700" alt="Athletic Apparel"><div><h3>06 | Athletic Apparel</h3><p>Performance Jersey</p></div></a>
      </div>
    </div></section>

    <section class="sec alt" id="lab-reports"><div class="wrap">
      <div class="head">
        <div>
          <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--green)">Verified Batch Integrity</span>
          <h2 style="margin-top:6px">Third-Party Lab Testing &amp; COA Analysis</h2>
          <p>Every single batch produced undergoes independent analytical verification via Reverse-Phase HPLC and Mass Spectrometry to certify purity above 99% and exact molecular identity.</p>
        </div>
      </div>
      <div class="lab-grid">
        <div class="lab-item">
          <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab1.webp') }}', 'COA HPLC Purity Test Report 01')">
            <img src="{{ asset('lab1.webp') }}" alt="COA Report 1" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600'">
            <div class="lab-badge">Inspect COA</div>
          </div>
          <div style="margin-top:8px">
            <h3 style="font-size:20px">Certificate of Analysis #01</h3>
            <p style="font-size:13px;color:var(--mut)">Comprehensive Reverse-Phase HPLC confirms >99.2% single-peak purity.</p>
          </div>
        </div>
        <div class="lab-item">
          <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab2.webp') }}', 'COA Mass Spectrometry Report 02')">
            <img src="{{ asset('lab2.webp') }}" alt="COA Report 2" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=600'">
            <div class="lab-badge">Inspect COA</div>
          </div>
          <div style="margin-top:8px">
            <h3 style="font-size:20px">Analytical Test Certificate #02</h3>
            <p style="font-size:13px;color:var(--mut)">ESI-MS verifying theoretical molecular weight and exact sequence fidelity.</p>
          </div>
        </div>
      </div>
    </div></section>

    <section class="sec" id="testimonies"><div class="wrap">
      <div class="head"><div><h2>Real Transformations, Proven Results</h2><p>Explore real transformation journeys from our community.</p></div></div>
      <div class="t-grid">
        <article class="t-card">
          <div class="t-frame"><img src="{{ asset('t1.webp') }}" alt="T1" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600'"></div>
          <div><h3>Weight Management & Vitality</h3><p style="font-size:13px;color:var(--mut)">Achieve a leaner physique with consistent adherence.</p></div>
        </article>
        <article class="t-card">
          <div class="t-frame"><img src="{{ asset('t2.webp') }}" alt="T2" onerror="this.src='https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=600'"></div>
          <div><h3>Stamina & Daily Endurance</h3><p style="font-size:13px;color:var(--mut)">Boost daily metabolic energy, focus and recovery.</p></div>
        </article>
        <article class="t-card">
          <div class="t-frame"><img src="{{ asset('t3.webp') }}" alt="T3" onerror="this.src='https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=600'"></div>
          <div><h3>Active Lifestyle & Confidence</h3><p style="font-size:13px;color:var(--mut)">Revitalise metabolic resilience and support active lifestyles.</p></div>
        </article>
      </div>
      <div style="text-align:center;margin-top:40px"><a class="btn" href="{{ route('products.index') }}">Shop Now</a></div>
    </div></section>
@endif
</main>

<footer><div class="wrap">
 <div class="fg">
  <div><h4>Novex Peptides</h4><p>Advanced peptide research for performance, longevity and aesthetic health.</p></div>
  <div><h4>Support</h4><ul><li><a href="{{ route('contact') }}">FAQ</a></li><li><a href="{{ route('contact') }}">Shipping &amp; Delivery</a></li><li><a href="{{ route('contact') }}">Terms &amp; Conditions</a></li></ul></div>
  <div><h4>Direct Orders</h4><p>WhatsApp Support:<br><b>+60 11-1208 5054</b></p></div>
 </div>
 <div style="margin-top:40px;border-top:1px solid rgba(255,255,255,.2);padding-top:18px;text-align:center"><span>© 2026 Novex Peptides. All rights reserved. For laboratory research use only.</span></div>
</div></footer>

<script>
function toggleMobileNav(){
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if(navM) navM.classList.toggle('open');
  if(btn) btn.classList.toggle('open');
}
</script>
</body>
</html>