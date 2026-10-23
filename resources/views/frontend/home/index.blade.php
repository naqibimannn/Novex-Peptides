<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Novex Peptides | Precision in Every Molecule</title>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
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

.top{background:var(--green);color:#E3EFF8;font-size:12px;text-align:center;padding:7px 12px;letter-spacing:.03em}
header{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.98);border-bottom:1px solid var(--line);box-shadow:0 2px 8px rgba(0,0,0,.03);margin:0}
.bar{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;height:78px;gap:20px;position:relative}

/* Navigasi Desktop */
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
.mnav a{padding:14px 0;border-bottom:1px solid var(--line);font-size:15px;font-weight:500;color:var(--ink);transition:color .2s ease}
.mnav a:hover, .mnav a.on{color:var(--green);font-weight:600}

.cart-trigger-btn{position:relative;background:none;border:0;color:var(--green);padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .2s ease}
.cart-trigger-btn:hover{transform:scale(1.12)}
.cart-trigger-btn svg{width:25px;height:25px;stroke:var(--green);stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round}
.cart-badge{position:absolute;top:-2px;right:-5px;background:var(--red);color:#fff;border-radius:999px;font-size:10px;min-width:18px;height:18px;line-height:18px;text-align:center;font-weight:700;padding:0 4px;border:2px solid #fff}

.hero{position:relative;height:calc(100vh - var(--off, 110px));height:calc(100svh - var(--off, 110px));min-height:520px;overflow:hidden;color:#fff;display:flex;align-items:center}
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
.slide .wrap{width:100%}

.ctl{position:absolute;z-index:3;bottom:28px;left:0;right:0}
.ctl .wrap{display:flex;justify-content:space-between;align-items:center}
.dots2{display:flex;gap:10px}
.dot{width:34px;height:4px;background:rgba(255,255,255,.4);padding:0;border-radius:4px;cursor:pointer;transition:all .3s ease;border:none}
.dot.on{background:#fff;width:44px}
.arr{display:flex;gap:10px}
.arr button{width:42px;height:42px;border-radius:50%;background:rgba(14,40,66,.35);border:1px solid rgba(255,255,255,.6);color:#fff;font-size:18px;cursor:pointer;backdrop-filter:blur(4px);transition:all .2s ease}
.arr button:hover{background:#fff;color:var(--green)}

.mq{overflow:hidden;border-block:1px solid var(--line);background:var(--card);white-space:nowrap;margin:34px 0}
.mq div{display:inline-flex;gap:46px;padding:17px 0;animation:mq 34s linear infinite;font:italic 500 22px var(--serif)}
.mq span:after{content:"✦";font-style:normal;font-size:11px;color:var(--gold);margin-left:46px}
@keyframes mq{to{transform:translateX(-50%)}}

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
.cat h3{font-size:20px}
.cat p{font-size:12px;opacity:.9;margin-top:4px}

.pc{padding:14px;background:#fff;border:1px solid var(--line);border-radius:26px;transition:transform .3s,box-shadow .3s;display:flex;flex-direction:column}
.pc:hover{transform:translateY(-6px);box-shadow:0 24px 44px -24px rgba(47,111,159,.5)}
.pc .ph{aspect-ratio:1;border-radius:20px;position:relative;background:#ffffff;border:1px solid rgba(210,226,239,.5);overflow:hidden}
.pc .chip{position:absolute;left:12px;top:12px;z-index:6;background:rgba(255,255,255,.9);backdrop-filter:blur(8px);color:var(--green);font-size:11px;font-weight:600;padding:5px 12px;border-radius:999px;border:1px solid rgba(210,226,239,.6)}
.pc .b{text-align:left;align-items:stretch;padding:16px 8px 8px;gap:8px;display:flex;flex-direction:column;flex:1}
.pc h3{font-size:20px;line-height:1.2}
.pc .s{font-size:13px;color:var(--mut)}
.pc .meta{display:flex;gap:6px;flex-wrap:wrap;margin-top:auto}
.pc .meta span{font-size:11px;background:var(--bg2);color:var(--ink);padding:4px 10px;border-radius:999px}
.btn-details{background:var(--green);color:#fff;padding:12px;border-radius:999px;font-size:13px;font-weight:600;text-align:center;margin-top:10px;transition:background .2s}
.btn-details:hover{background:#245a82}

.t-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.t-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:12px;display:flex;flex-direction:column;gap:14px;transition:transform .35s cubic-bezier(.2,.8,.2,1),box-shadow .35s ease,border-color .25s ease}
.t-card:hover{transform:translateY(-6px);box-shadow:0 24px 48px -20px rgba(47,111,159,.35);border-color:var(--gold)}
.t-frame{position:relative;width:100%;aspect-ratio:3/2;border-radius:16px;overflow:hidden;background:#ffffff;border:1px solid rgba(210,226,239,.6);cursor:pointer}
.t-frame img{width:100%;height:100%;object-fit:cover;border-radius:16px;transition:transform .6s cubic-bezier(.2,.8,.2,1)}
.t-card:hover .t-frame img{transform:scale(1.03)}
.t-foot{padding:2px 6px 6px;display:flex;flex-direction:column;gap:8px;flex:1}
.t-foot h3{font-size:21px;line-height:1.25;color:var(--ink)}
.t-foot p{font-size:13px;color:var(--mut);line-height:1.55}

.lab-grid{display:grid;grid-template-columns:repeat(2, 1fr);gap:40px;max-width:780px;margin:0 auto;align-items:start}
.lab-item{display:flex;flex-direction:column;gap:14px;width:100%;max-width:350px;margin:0 auto}
.lab-img-wrap{position:relative;width:100%;aspect-ratio:1 / 1.4;border-radius:18px;overflow:hidden;cursor:pointer;background:#ffffff;border:1px solid rgba(210,226,239,.95);box-shadow:0 10px 26px rgba(14,40,66,.07);transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease}
.lab-img-wrap:hover{transform:translateY(-5px);border-color:var(--gold);box-shadow:0 18px 36px rgba(47,111,159,.16)}
.lab-img-wrap img{width:100%!important;height:100%!important;display:block;border-radius:18px;object-fit:contain;object-position:center;background:#ffffff;padding:6px}
.lab-badge{position:absolute;top:12px;right:12px;background:rgba(30,45,59,.88);color:#fff;font-size:11px;font-weight:600;padding:5px 12px;border-radius:999px;backdrop-filter:blur(6px);display:flex;align-items:center;gap:5px;z-index:2}
.lab-badge svg{width:13px;height:13px;stroke:#fff}
.lab-meta{display:flex;flex-direction:column;gap:6px;text-align:left}
.lab-meta-tag{display:inline-block;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--green);background:rgba(47,111,159,.12);padding:4px 10px;border-radius:999px;width:fit-content}
.lab-meta h3{font-size:20px;color:var(--ink);line-height:1.25}
.lab-meta p{font-size:13px;color:var(--mut);line-height:1.55}

.t-lightbox{position:fixed;inset:0;background:rgba(10,24,40,.88);backdrop-filter:blur(8px);z-index:9999;display:none;align-items:center;justify-content:center;padding:20px}
.t-lightbox.open{display:flex}
.t-lightbox-inner{position:relative;max-width:960px;width:100%;background:#fff;border-radius:24px;padding:16px;box-shadow:0 25px 60px rgba(0,0,0,.4);display:flex;flex-direction:column;gap:10px}
.t-lightbox-inner img{width:100%;height:auto;max-height:80vh;object-fit:contain;border-radius:16px;background:#fff}
.t-lightbox-title{font-size:14px;font-weight:600;color:var(--ink);padding:4px 6px;text-align:center}
.t-lightbox-close{position:absolute;top:-14px;right:-14px;width:38px;height:38px;border-radius:50%;background:#fff;color:var(--ink);font-size:22px;font-weight:600;box-shadow:0 6px 16px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;cursor:pointer;border:none}

.div2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.camp{position:relative;min-height:420px;color:#fff;display:flex;align-items:center;border-radius:26px;overflow:hidden}
.camp img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .5s}
.camp:hover img{transform:scale(1.03)}
.camp:before{content:"";position:absolute;inset:0;z-index:1;background:rgba(14,40,66,.52)}
.camp div{position:relative;z-index:2;padding:40px}
.camp h2{font-size:clamp(24px,3vw,36px);color:#fff;margin-bottom:6px}
.camp p{margin:10px 0 22px;max-width:380px;font-size:14px;color:#E3EFF8;opacity:.95}

.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.steps div{background:#fff;border:1px solid var(--line);border-radius:24px;padding:24px}
.steps b{font:italic 500 46px/1 var(--serif);color:var(--gold)}
.steps h3{margin:10px 0 8px;font-size:23px}
.steps p{font-size:14px;color:var(--mut)}

footer{background:var(--green);color:#E3EFF8;padding:60px 0 24px;font-size:13px}
.fg{display:grid;grid-template-columns:1.5fr 1fr 1.3fr 1.2fr;gap:32px}
footer h4{font-family:var(--serif);font-size:20px;font-weight:500;margin-bottom:12px;color:#fff}
footer li{list-style:none;margin-bottom:6px}
.social-links{display:flex;flex-direction:column;gap:10px;margin-top:8px}
.social-link{display:inline-flex;align-items:center;gap:10px;color:#E3EFF8;font-size:13px;font-weight:500;transition:all .2s ease;padding:7px 14px;background:rgba(255,255,255,.09);border-radius:12px;width:fit-content}
.social-link:hover{background:rgba(255,255,255,.2);color:#fff;transform:translateY(-2px)}
.social-link svg{flex-shrink:0}
.copy{border-top:1px solid rgba(255,255,255,.2);margin-top:40px;padding-top:18px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;opacity:.85}

@media(max-width:1080px){
 .bar{display:flex;justify-content:space-between;align-items:center;height:68px}
 nav.dnav{display:none !important}
 .burger-btn{display:inline-flex}
 .logo{text-align:left;font-size:24px}
 .logo small{letter-spacing:.26em}
 .rt{gap:12px}
}
@media(max-width:960px){
 .t-grid{grid-template-columns:1fr 1fr;gap:18px}
 .lab-grid{gap:28px;max-width:680px}
 .lab-item{max-width:310px}
}
@media(max-width:900px){
 .g2,.div2,.fg{grid-template-columns:1fr}
 .g3,.g4,.steps{grid-template-columns:1fr 1fr}
 .sec{padding:54px 0}
 .ctl{bottom:18px}
 .dot{width:26px;height:3px}
 .dot.on{width:36px}
 .arr button{width:36px;height:36px;font-size:15px}
}
@media(max-width:640px){
 .wrap{padding:0 18px}
 .hero{min-height:480px}
 .hero .in{max-width:100%}
 .hero .btn.line{margin:10px 0 0;display:inline-block}
 .g3,.g4,.steps,.t-grid,.lab-grid{grid-template-columns:1fr}
 .lab-item{max-width:320px}
 .g6{grid-template-columns:repeat(2,1fr);gap:12px}
 .camp{min-height:360px}
 .camp div{padding:28px 22px}
}
</style>
</head>
<body>
<div class="top">Made in USA. High Purity. Research Graded. Cold chain shipping worldwide.</div>

<header>
  <div class="wrap bar">
    <!-- Navigasi Kiri (Desktop) - Menempatkan Accessory menggantikan Science -->
    <nav class="dnav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>
      <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'on' : '' }}">Products</a>
      <a href="{{ route('accessory') }}" class="{{ request()->routeIs('accessory') ? 'on' : '' }}">Accessory</a>
    </nav>
    
    <!-- Logo Teks -->
    <a href="{{ route('home') }}" class="logo">NOVEX<small>PEPTIDES</small></a>
    
    <!-- Bahagian Kanan Header -->
    <div class="rt">
      <!-- Navigasi Kanan (Desktop) - Menempatkan Science menggantikan Accessory -->
      <nav class="dnav">
        <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'on' : '' }}">Resources</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
        <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'on' : '' }}">Science</a>
      </nav>

      <div class="tools">
        <!-- Butang Troli -->
        <a class="cart-trigger-btn" href="{{ route('cart') }}" aria-label="Shopping Cart">
          <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
          <span class="cart-badge" id="cartCount">0</span>
        </a>

        <!-- Butang 3 Garis (Hamburger Mobile) -->
        <button class="burger-btn" id="mobileBurgerBtn" onclick="toggleMobileNav()" aria-label="Toggle Menu">
          <svg class="icon-open" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
          <svg class="icon-close" style="display:none" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Menu Dropdown Mobile - Ditukar susunan selari dengan desktop -->
  <nav class="mnav" id="navM">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'on' : '' }}">Products</a>
    <a href="{{ route('accessory') }}" class="{{ request()->routeIs('accessory') ? 'on' : '' }}">Accessory</a>
    <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'on' : '' }}">Resources</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
    <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'on' : '' }}">Science</a>
  </nav>
</header>

<main id="app">
@hasSection('content')
    @yield('content')
@else
    <section class="hero sl">
      <div class="slide on">
        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85" alt="Hero Banner 1">
        <div class="wrap"><div class="in">
          <h1>Precision in<br>Every Molecule</h1>
          <p>Advanced peptide research. Science drives results, with premium quality made in USA.</p>
          <div style="display:flex;align-items:center;flex-wrap:wrap">
            <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
            <a class="btn line" href="{{ route('science') }}">Our Science</a>
          </div>
        </div></div>
      </div>
      <div class="slide">
        <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=1800&q=85" alt="Hero Banner 2">
        <div class="wrap"><div class="in">
          <h1>Certified Purity &<br>Rigorous Assay</h1>
          <p>Precision micro-pipetting, HPLC chromatographic testing, and batch-level verification.</p>
          <div style="display:flex;align-items:center;flex-wrap:wrap">
            <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
            <a class="btn line" href="{{ route('science') }}">Our Science</a>
          </div>
        </div></div>
      </div>
      <div class="slide">
        <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1800&q=85" alt="Hero Banner 3">
        <div class="wrap"><div class="in">
          <h1>State-of-the-art<br>Biomedical Lab</h1>
          <p>Synthesized under certified cGMP facilities with temperature-monitored cold chain storage.</p>
          <div style="display:flex;align-items:center;flex-wrap:wrap">
            <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
            <a class="btn line" href="{{ route('science') }}">Our Science</a>
          </div>
        </div></div>
      </div>
      <div class="slide">
        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=1800&q=85" alt="Hero Banner 4">
        <div class="wrap"><div class="in">
          <h1>Innovations for<br>Longevity & Health</h1>
          <p>Third-party tested research compounds delivered with cold chain integrity.</p>
          <div style="display:flex;align-items:center;flex-wrap:wrap">
            <a class="btn" href="{{ route('products.index') }}">Shop Now</a>
            <a class="btn line" href="{{ route('science') }}">Our Science</a>
          </div>
        </div></div>
      </div>
      <div class="ctl"><div class="wrap">
        <div class="dots2">
          <button class="dot on" onclick="go(0)" aria-label="Slide 1"></button>
          <button class="dot" onclick="go(1)" aria-label="Slide 2"></button>
          <button class="dot" onclick="go(2)" aria-label="Slide 3"></button>
          <button class="dot" onclick="go(3)" aria-label="Slide 4"></button>
        </div>
        <div class="arr">
          <button onclick="go(hi-1)" aria-label="Previous">&#8592;</button>
          <button onclick="go(hi+1)" aria-label="Next">&#8594;</button>
        </div>
      </div></div>
    </section>

    <div class="mq"><div>
      <span>Advanced peptide research</span><span>Science drives results</span><span>Third party tested</span><span>Cold chain from vial to door</span><span>Made in USA</span><span>Research grade only</span>
      <span>Advanced peptide research</span><span>Science drives results</span><span>Third party tested</span><span>Cold chain from vial to door</span><span>Made in USA</span><span>Research grade only</span>
    </div></div>

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
          <span class="lab-meta-tag">Verified Batch Integrity</span>
          <h2 style="margin-top:6px">Third-Party Lab Testing &amp; COA Analysis</h2>
          <p>Every single batch produced undergoes independent analytical verification via Reverse-Phase HPLC and Mass Spectrometry to certify purity above 99% and exact molecular identity.</p>
        </div>
      </div>
      <div class="lab-grid">
        <div class="lab-item">
          <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab1.webp') }}', 'Official Certificate of Analysis (COA) - HPLC Purity Test Report 01')">
            <img src="{{ asset('lab1.webp') }}" alt="COA HPLC Analysis Report" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=85'">
            <div class="lab-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <span>Click to Inspect COA</span>
            </div>
          </div>
          <div class="lab-meta">
            <span class="lab-meta-tag">Purity: &gt;99.2% • Verified</span>
            <h3>Certificate of Analysis (COA) #01</h3>
            <p>Comprehensive Reverse-Phase HPLC chromatography confirms single-peak molecular purity with zero trace heavy metal contaminants.</p>
          </div>
        </div>

        <div class="lab-item">
          <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab2.webp') }}', 'Official Certificate of Analysis (COA) - Mass Spectrometry & Analytical Assay 02')">
            <img src="{{ asset('lab2.webp') }}" alt="COA Analytical Results" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1000&q=85'">
            <div class="lab-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <span>Click to Inspect COA</span>
            </div>
          </div>
          <div class="lab-meta">
            <span class="lab-meta-tag">Mass Spec • Sequence Confirmed</span>
            <h3>Analytical Test Certificate #02</h3>
            <p>Electrospray Ionisation Mass Spectrometry (ESI-MS) verifying theoretical molecular weight and exact amino acid peptide sequence fidelity.</p>
          </div>
        </div>
      </div>
    </div></section>

    <section class="sec" id="testimonies"><div class="wrap">
      <div class="head">
        <div>
          <h2>Real Transformations, Proven Results</h2>
          <p>Explore real transformation journeys from our community. Interested in achieving similar results? Explore our research formulations below.</p>
        </div>
      </div>
      <div class="t-grid">
        <article class="t-card">
          <div class="t-frame" onclick="openLightboxModal('{{ asset('t1.webp') }}', 'Client Transformation - Weight Management & Vitality')">
            <img src="{{ asset('t1.webp') }}" alt="Transformation 1" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700'">
          </div>
          <div class="t-foot">
            <h3>Weight Management & Vitality</h3>
            <p>Achieve a leaner physique with consistent protocol adherence.</p>
          </div>
        </article>
        <article class="t-card">
          <div class="t-frame" onclick="openLightboxModal('{{ asset('t2.webp') }}', 'Client Transformation - Stamina & Daily Endurance')">
            <img src="{{ asset('t2.webp') }}" alt="Transformation 2" onerror="this.src='https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=700'">
          </div>
          <div class="t-foot">
            <h3>Stamina & Daily Endurance</h3>
            <p>Boost daily metabolic energy, focus and persistent recovery.</p>
          </div>
        </article>
        <article class="t-card">
          <div class="t-frame" onclick="openLightboxModal('{{ asset('t3.webp') }}', 'Client Transformation - Active Lifestyle & Confidence')">
            <img src="{{ asset('t3.webp') }}" alt="Transformation 3" onerror="this.src='https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=700'">
          </div>
          <div class="t-foot">
            <h3>Active Lifestyle & Confidence</h3>
            <p>Revitalise metabolic resilience and support active healthy lifestyles.</p>
          </div>
        </article>
      </div>
      <div style="text-align:center;margin-top:40px">
        <a class="btn" href="{{ route('products.index') }}" style="padding:14px 40px;font-size:14px;font-weight:600">Shop Now</a>
      </div>
    </div></section>

    <section class="sec alt"><div class="wrap">
      <div class="head"><div><h2>Featured Formulations</h2></div><a class="btn line" href="{{ route('products.index') }}">View all</a></div>
      <div class="g4">
        <!-- Retatrutide -->
        <div class="card pc">
          <div class="ph">
            <img src="{{ asset('reta1.webp') }}" alt="Retatrutide" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
            <span class="chip">Weight Management</span>
          </div>
          <div class="b">
            <h3>Retatrutide</h3>
            <p class="s">Advanced Weight Management</p>
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM280.00 - RM980.00</div>
            <div class="meta">
              <span style="font-weight:600">10mg - 100mg</span>
              <span>Research grade</span>
            </div>
            <a class="btn-details" href="{{ route('products.show', 'retatrutide') }}">See Details</a>
          </div>
        </div>
        <div class="card pc">
          <div class="ph">
            <img src="{{ asset('retaplus1.webp') }}" alt="Retatrutide Plus" onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600'">
            <span class="chip">Weight Management</span>
          </div>
          <div class="b">
            <h3>Retatrutide Plus (RETA PLUS)</h3>
            <p class="s">Combination of Retatrutide + Cagrilintide</p>
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM590.00</div>
            <div class="meta">
              <span style="font-weight:600">40mg</span>
              <span>Research grade</span>
            </div>
            <a class="btn-details" href="{{ route('products.show', 'reta-plus') }}">See Details</a>
          </div>
        </div>
        <div class="card pc">
          <div class="ph">
            <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600" alt="GlutaGlow Serum">
            <span class="chip">Skincare Collection</span>
          </div>
          <div class="b">
            <h3>GlutaGlow Serum</h3>
            <p class="s">Advanced Skincare For A Brighter You</p>
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM59.90</div>
            <div class="meta">
              <span style="font-weight:600">10ml</span>
              <span>Novex Beauty</span>
            </div>
            <a class="btn-details" href="{{ route('products.show', 'glutaglow-serum') }}">See Details</a>
          </div>
        </div>
        <div class="card pc">
          <div class="ph">
            <img src="{{ asset('jry1.webp') }}" alt="Premium Athletic Jersey" onerror="this.src='https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=600'">
            <span class="chip">Apparel</span>
          </div>
          <div class="b">
            <h3>Premium Athletic Jersey</h3>
            <p class="s">Performance. Style. Everyday.</p>
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM40.00</div>
            <div class="meta">
              <span style="font-weight:600">Adult Size</span>
              <span>Merchandise</span>
            </div>
            <a class="btn-details" href="{{ route('products.show', 'jersey-01') }}">See Details</a>
          </div>
        </div>
      </div>
    </div></section>

    <section class="sec" style="padding-top:0"><div class="wrap div2">
      <div class="camp">
        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1000&q=85" alt="Performance Peptides">
        <div>
          <h2>Fuel a Higher Standard</h2>
          <p>Science Driven Performance</p>
          <a class="btn" style="background:#FFFFFF;color:var(--green)" href="{{ route('products.index') }}">Explore peptides</a>
        </div>
      </div>
      <div class="camp">
        <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1000&q=85" alt="Skincare Peptides">
        <div>
          <h2>Radiant Skin From Within</h2>
          <p>Advanced Peptide Skincare</p>
          <a class="btn" style="background:#FFFFFF;color:var(--green)" href="{{ route('products.index') }}">Explore skincare</a>
        </div>
      </div>
    </div></section>

    <section class="sec alt"><div class="wrap">
      <div class="head"><div><h2>From the bench to your door</h2><p>Four checkpoints every vial passes before it leaves us.</p></div></div>
      <div class="steps">
        <div><b>01</b><h3>Synthesis</h3><p>Produced under certified partner cGMP conditions in the USA.</p></div>
        <div><b>02</b><h3>Testing</h3><p>Third-party testing verifies purity and compound identity via HPLC.</p></div>
        <div><b>03</b><h3>Cold Storage</h3><p>Stored under continuous temperature-monitored environments.</p></div>
        <div><b>04</b><h3>Insulated Dispatch</h3><p>Express courier cold-chain dispatch directly to your institution.</p></div>
      </div>
    </div></section>

    <section class="sec"><div class="wrap">
      <div class="head"><div><h2>Latest Science Articles</h2></div><a class="btn line" href="{{ route('resources') }}">All articles</a></div>
      <div class="g4 art">
        <a class="card" href="{{ route('resources') }}" style="background:var(--card);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=500&q=85" alt="Understanding Retatrutide">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">Understanding Retatrutide</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=500&q=85" alt="The Science of GHK-Cu">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">The Science of GHK-Cu</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=500&q=85" alt="Benefits of NAD+">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">Benefits of NAD+</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=500&q=85" alt="What is Tesamorelin">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">What is Tesamorelin</h3></div>
        </a>
      </div>
    </div></section>
@endif
</main>

<div class="t-lightbox" id="tLightbox" onclick="if(event.target===this)closeLightboxModal()">
  <div class="t-lightbox-inner">
    <button class="t-lightbox-close" onclick="closeLightboxModal()" aria-label="Close">&times;</button>
    <img id="tLightboxImg" src="" alt="Enlarged Document">
    <div id="tLightboxTitle" class="t-lightbox-title"></div>
  </div>
</div>

<footer><div class="wrap">
 <div class="fg">
  <div><h4>Novex Peptides</h4><p>Advanced peptide research for performance, longevity and aesthetic health.</p></div>
  <div><h4>Support</h4><ul><li><a href="{{ route('contact') }}">FAQ</a></li><li><a href="{{ route('contact') }}">Shipping &amp; Delivery</a></li><li><a href="{{ route('contact') }}">Order Tracking</a></li><li><a href="{{ route('contact') }}">Return Policy</a></li><li><a href="{{ route('contact') }}">Terms &amp; Conditions</a></li><li><a href="{{ route('contact') }}">Privacy Policy</a></li></ul></div>
  <div>
    <h4>Follow Us</h4>
    <div class="social-links">
      <a href="https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==" target="_blank" rel="noopener" class="social-link" aria-label="Follow us on Instagram">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
        </svg>
        <span>Instagram</span>
      </a>
      <a href="https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1" target="_blank" rel="noopener" class="social-link" aria-label="Follow us on TikTok">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
          <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.86.12V9.37a6.34 6.34 0 0 0-.86-.06A6.33 6.33 0 0 0 3.1 15.64a6.34 6.34 0 0 0 10.82 4.48 6.27 6.27 0 0 0 1.89-4.48V8.78a8.28 8.28 0 0 0 4.78 1.5V6.82a4.84 4.84 0 0 1-1-.13z"/>
        </svg>
        <span>TikTok</span>
      </a>
    </div>
  </div>
  <div><h4>Contact Desk</h4><p>Direct WhatsApp &amp; Inquiries:<br><b>+60 11-1208 5054</b></p></div>
 </div>
 <div class="copy"><span>© 2026 Novex Peptides. All rights reserved.</span><span>For laboratory research use only. Not for human consumption.</span></div>
</div></footer>

<script>
let hi = 0, ht;
function go(n){
  const slides = document.querySelectorAll('.slide');
  const dots = document.querySelectorAll('.dot');
  if(!slides.length) return;
  hi = (n + slides.length) % slides.length;
  slides.forEach((x, i) => x.classList.toggle('on', i === hi));
  dots.forEach((d, i) => d.classList.toggle('on', i === hi));
}

function openLightboxModal(src, title=''){
  const m = document.getElementById('tLightbox');
  const im = document.getElementById('tLightboxImg');
  const t = document.getElementById('tLightboxTitle');
  if(m && im){
    im.src = src;
    if(t) t.innerText = title;
    m.classList.add('open');
  }
}

function closeLightboxModal(){
  const m = document.getElementById('tLightbox');
  if(m) m.classList.remove('open');
}

function toggleMobileNav(){
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if(navM) navM.classList.toggle('open');
  if(btn) btn.classList.toggle('open');
}

const setOff = () => {
  const topEl = document.querySelector('.top');
  const hdrEl = document.querySelector('header');
  const h = (topEl ? topEl.offsetHeight : 0) + (hdrEl ? hdrEl.offsetHeight : 0);
  document.documentElement.style.setProperty('--off', h + 'px');
};

window.addEventListener('resize', setOff);
document.addEventListener('DOMContentLoaded', () => {
  setOff();
  if(document.querySelector('.slide')){
    ht = setInterval(() => go(hi + 1), 7000);
  }
});
</script>
</body>
</html>