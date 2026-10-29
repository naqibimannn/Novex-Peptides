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

<script>
(function() {
  var t = 'light';
  try { if (localStorage.getItem('nvx_theme') === 'dark') t = 'dark'; } catch (e) {}
  document.documentElement.setAttribute('data-theme', t);
})();
</script>

<style>
:root{
  --bg:#FFFFFF;
  --bg2:#E9F2FA;
  --ink:#1E2D3B;
  --mut:#5A6F82;
  --green:#2F6F9F;
  --line:#D2E2EF;
  --card:#F6FAFD;
  --card-surface:#FFFFFF;
  --header-bg:rgba(255,255,255,.98);
  --gold:#3F84B5;
  --red:#e11d48;
  --serif:'Cormorant Garamond',Georgia,serif;
  --sans:'Inter',system-ui,sans-serif;
}

[data-theme="dark"]{
  --bg:#0A111A;
  --bg2:#101B27;
  --ink:#F0F6FC;
  --mut:#8EA4B8;
  --green:#327BB3;
  --line:#1C2D3E;
  --card:#0E1824;
  --card-surface:#132232;
  --header-bg:rgba(10,17,26,.97);
  --gold:#5CA5DA;
  --red:#f43f5e;
}

*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{background:var(--bg);color:var(--ink);font:15px/1.65 var(--sans);overflow-x:hidden;transition:background-color .25s ease, color .25s ease}
img{display:block;width:100%;height:100%;object-fit:cover;background:transparent}
a{color:inherit;text-decoration:none}
button{font:inherit;cursor:pointer;border:0}
:focus-visible{outline:2px solid var(--green);outline-offset:2px}
h1,h2,h3,h4{font-family:var(--serif);font-weight:500;line-height:1.15;color:var(--ink)}
h1{font-size:clamp(34px,5.5vw,72px)}h2{font-size:clamp(26px,3.8vw,44px)}h3{font-size:clamp(20px,2.5vw,26px)}
.wrap{max-width:1200px;margin:0 auto;padding:0 24px}
.sec{padding:80px 0;background:var(--bg);transition:background-color .25s ease}
.alt{background:var(--bg2);transition:background-color .25s ease}
.btn{display:inline-block;background:var(--green);color:#fff;padding:12px 26px;font-size:13px;letter-spacing:.04em;transition:all .2s ease;text-align:center;border-radius:999px;touch-action:manipulation}
.btn:hover{background:#266391}
.btn.line{background:none;border:1px solid currentColor;color:inherit}

.top{background:var(--green);color:#E3EFF8;font-size:12px;text-align:center;padding:7px 12px;letter-spacing:.03em;transition:background-color .25s ease}
[data-theme="dark"] .top{background:#071018;border-bottom:1px solid var(--line);color:#9FB9D0}

header{position:sticky;top:0;z-index:100;background:var(--header-bg);border-bottom:1px solid var(--line);box-shadow:0 2px 8px rgba(0,0,0,.03);margin:0;transition:background-color .25s ease, border-color .25s ease}
.bar{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;height:78px;gap:20px;position:relative}

nav.dnav{display:flex;gap:24px;font-size:13px;font-weight:500}
nav.dnav a{padding:6px 0;border-bottom:1px solid transparent;transition:color .2s,border-color .2s}
nav.dnav a.on,nav.dnav a:hover{border-color:var(--gold);color:var(--green)}

.logo{text-align:center;font-family:var(--serif);font-size:32px;font-weight:600;line-height:1;letter-spacing:.06em;color:var(--ink);transition:all .25s ease}
.logo small{display:block;font:500 9px var(--sans);letter-spacing:.38em;margin-top:5px;color:var(--gold);transition:color .25s ease}
[data-theme="dark"] .logo{color:#FFFFFF !important;text-shadow:0 0 20px rgba(92,165,218,.3)}
[data-theme="dark"] .logo small{color:#5CA5DA !important}
[data-theme="dark"] .logo img,
[data-theme="dark"] img.logo,
[data-theme="dark"] .site-logo{filter:brightness(0) invert(1) drop-shadow(0 0 10px rgba(255,255,255,0.25))}

.rt{display:flex;align-items:center;justify-content:flex-end;gap:20px}
.tools{display:flex;align-items:center;gap:10px}

.theme-btn{
  background:none;
  border:1px solid var(--line);
  color:var(--ink);
  width:38px;
  height:38px;
  border-radius:50%;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  transition:all .2s ease;
  flex-shrink:0;
}
.theme-btn:hover{background:var(--bg2);border-color:var(--gold)}
.theme-btn svg{width:18px;height:18px;stroke:currentColor;fill:none;display:block}
.theme-btn .ico-sun{display:none}
[data-theme="dark"] .theme-btn .ico-sun{display:block}
[data-theme="dark"] .theme-btn .ico-moon{display:none}

.dd{position:relative}
.dd-trigger{background:none;color:inherit;font:inherit;font-weight:500;padding:6px 0;border-bottom:1px solid transparent;display:inline-flex;align-items:center;gap:5px;cursor:pointer;transition:color .2s,border-color .2s}
.dd-trigger svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.4;stroke-linecap:round;stroke-linejoin:round;transition:transform .2s}
.dd-trigger.on,.dd-trigger:hover,.dd.open .dd-trigger{border-color:var(--gold);color:var(--green)}
.dd.open .dd-trigger svg{transform:rotate(180deg)}
.dd-menu{display:none;position:absolute;top:100%;left:0;padding-top:12px;z-index:120}
.dd.open .dd-menu{display:block}
.dd-box{min-width:260px;background:var(--card-surface);border:1px solid var(--line);border-radius:16px;padding:6px;box-shadow:0 14px 34px rgba(0,0,0,.16);display:flex;flex-direction:column;gap:2px}
nav.dnav .dd-box a{display:block;padding:11px 14px;border-radius:10px;border-bottom:0;font-size:12px;font-weight:600;letter-spacing:.04em;color:var(--ink)}
nav.dnav .dd-box a:hover{background:var(--bg2);color:var(--green)}
@media(hover:hover){
  .dd:hover .dd-menu,.dd:has(:focus-visible) .dd-menu{display:block}
  .dd:hover .dd-trigger{border-color:var(--gold);color:var(--green)}
  .dd:hover .dd-trigger svg{transform:rotate(180deg)}
}

.burger-btn{
  display:none;
  background:none;
  border:1px solid var(--line);
  padding:7px;
  border-radius:10px;
  cursor:pointer;
  align-items:center;
  justify-content:center;
  color:var(--ink);
  transition:all .2s ease;
  position:relative;
  z-index:105;
  flex-shrink:0;
}
.burger-btn:hover{background:var(--bg2);border-color:var(--gold)}
.burger-btn svg{pointer-events:none}
.burger-btn.open .icon-open{display:none}
.burger-btn.open .icon-close{display:block !important}

.mnav{display:none}
.mnav.open{
  display:flex !important;
  position:absolute;
  top:100%;
  left:0;
  right:0;
  background:var(--header-bg);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
  flex-direction:column;
  gap:0;
  padding:12px 24px 24px;
  border-bottom:1px solid var(--line);
  box-shadow:0 16px 32px rgba(14,40,66,.12);
  z-index:104;
  max-height:calc(100vh - 78px);
  overflow-y:auto;
}
.mnav a{padding:14px 0;border-bottom:1px solid var(--line);font-size:15px;font-weight:500;color:var(--ink);transition:color .2s ease}
.mnav a:hover, .mnav a.on{color:var(--green);font-weight:600}

.m-group{display:flex;flex-direction:column;padding-top:6px}
.m-group-title{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--mut);padding:14px 0 4px}
.mnav a.sub{display:block;padding:12px 0 12px 14px;font-size:14px}
.m-group>a.sub:last-child{border-bottom:1px solid var(--line)}

.cart-trigger-btn{position:relative;background:none;border:0;color:var(--green);padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .2s ease}
.cart-trigger-btn:hover{transform:scale(1.12)}
.cart-trigger-btn svg{width:25px;height:25px;stroke:var(--green);stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round}
.cart-badge{position:absolute;top:-2px;right:-5px;background:var(--red);color:#fff;border-radius:999px;font-size:10px;min-width:18px;height:18px;line-height:18px;text-align:center;font-weight:700;padding:0 4px;border:2px solid var(--card-surface)}

.hero{position:relative;height:calc(100vh - var(--off, 110px));height:calc(100svh - var(--off, 110px));min-height:520px;overflow:hidden;color:#fff !important;display:flex;align-items:center}
.hero>img,
.hero picture,
.hero picture img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;filter:saturate(1.08) brightness(1.05)}
.hero:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(10,17,26,.82),rgba(10,17,26,.25) 75%)}
.hero .wrap{position:relative;z-index:2;width:100%}
.hero .in{max-width:580px}
.hero h1{font-size:clamp(34px,5.5vw,72px);color:#FFFFFF !important}
.hero p{max-width:480px;margin:18px 0 28px;font-size:16px;line-height:1.6;opacity:.95;color:#FFFFFF !important}
.hero span{color:#FFFFFF !important}
.hero .btn{background:#FFFFFF !important;color:var(--green) !important}
.hero .btn:hover{background:#E9F2FA !important;color:#245a82 !important}
.hero .btn.line{background:transparent !important;color:#FFFFFF !important;border:1px solid rgba(255,255,255,.85) !important;margin-left:10px}
.hero .btn.line:hover{background:rgba(255,255,255,.15) !important;border-color:#FFFFFF !important}

#view-performance-division .hero picture img,
#view-performance-division .hero>img,
#view-premium-supplements .hero picture img,
#view-premium-supplements .hero>img{
  object-position: top center;
}

.hero.sl:before{display:none}
.slide{position:absolute;inset:0;z-index:0;opacity:0;transition:opacity 1.1s ease-in-out;display:flex;align-items:center;overflow:hidden}
.slide.on{opacity:1;z-index:1}
.slide>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
.slide:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(10,17,26,.82),rgba(10,17,26,.20) 75%)}
.slide .wrap{width:100%}

.ctl{position:absolute;z-index:3;bottom:28px;left:0;right:0}
.ctl .wrap{display:flex;justify-content:space-between;align-items:center}
.dots2{display:flex;gap:10px}
.dot{width:34px;height:4px;background:rgba(255,255,255,.4);padding:0;border-radius:4px;cursor:pointer;transition:all .3s ease;border:none}
.dot.on{background:#fff;width:44px}
.arr{display:flex;gap:10px}
.arr button{width:42px;height:42px;border-radius:50%;background:rgba(10,17,26,.45);border:1px solid rgba(255,255,255,.6);color:#fff;font-size:18px;cursor:pointer;backdrop-filter:blur(4px);transition:all .2s ease}
.arr button:hover{background:#fff;color:var(--green)}

.mq{overflow:hidden;border-block:1px solid var(--line);border-top:none;background:var(--card);white-space:nowrap;margin:0;transition:background-color .25s ease, border-color .25s ease}
.mq div{display:inline-flex;gap:46px;padding:17px 0;animation:mq 34s linear infinite;font:italic 500 22px var(--serif);color:var(--ink)}
.mq span:after{content:"✦";font-style:normal;font-size:11px;color:var(--gold);margin-left:46px}
@keyframes mq{to{transform:translateX(-50%)}}

.head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;gap:20px;flex-wrap:wrap}
.head>div{display:flex;flex-direction:column;gap:8px;max-width:720px}
.head p{color:var(--mut)}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center}
.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
.g6{display:grid;grid-template-columns:repeat(auto-fit, minmax(170px, 1fr));gap:18px}
.ph{aspect-ratio:4/5;overflow:hidden;border-radius:24px;background:var(--card-surface)}
.cat{position:relative;aspect-ratio:3/4;overflow:hidden;color:#fff;display:flex;align-items:end;border-radius:26px}
.cat img{position:absolute;inset:0;transition:transform .6s}
.cat:hover img{transform:scale(1.04)}
.cat:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(0deg,rgba(10,17,26,.85),transparent 60%)}
.cat div{position:relative;z-index:2;padding:20px}
.cat h3{font-size:20px;color:#fff}
.cat p{font-size:12px;opacity:.9;margin-top:4px;color:#fff}

#lab-reports{
  position:relative;
  background:linear-gradient(rgba(233, 242, 250, 0.92), rgba(233, 242, 250, 0.95)), url('https://images.unsplash.com/photo-1758685848543-5c8ba81bc822?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D') center/cover no-repeat;
  padding:52px 0;
  transition:background .3s ease;
}
[data-theme="dark"] #lab-reports{
  background:linear-gradient(rgba(10, 17, 26, 0.90), rgba(16, 27, 39, 0.94)), url('https://images.unsplash.com/photo-1758685848543-5c8ba81bc822?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D') center/cover no-repeat;
}
#lab-reports h2{color:var(--ink)}
#lab-reports p{color:var(--mut)}

.pc{
  padding:14px;
  background:var(--card-surface);
  border:1px solid var(--line);
  border-radius:26px;
  transition:transform .3s,box-shadow .3s,background-color .25s ease,border-color .25s ease;
  display:flex;
  flex-direction:column;
}
.pc:hover{
  transform:translateY(-6px);
  box-shadow:0 24px 44px -24px rgba(47,111,159,.5);
}
.pc .ph{
  aspect-ratio:1 !important;
  border-radius:20px;
  position:relative;
  background:var(--card-surface);
  border:1px solid var(--line);
  overflow:hidden;
  padding:0;
  display:flex;
  align-items:center;
  justify-content:center;
}
.pc .ph img{
  width:auto !important;
  height:auto !important;
  max-width:100% !important;
  max-height:100% !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:14px !important;
  display:block;
  background:transparent;
}
.prod-slider{position:relative;width:100%;height:100%;overflow:hidden;border-radius:inherit;background:var(--card-surface)}
.prod-slides{position:relative;width:100%;height:100%;border-radius:inherit;overflow:hidden;background:var(--card-surface)}
.prod-slide{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  opacity:0;
  transition:opacity .65s ease-in-out;
  padding:12px;
  margin:0;
  overflow:hidden;
  border-radius:inherit;
  background:var(--card-surface);
  display:flex;
  align-items:center;
  justify-content:center;
  pointer-events:none;
}
.prod-slide.active{opacity:1 !important;pointer-events:auto !important}
.prod-slide img{
  width:auto !important;
  height:auto !important;
  max-width:100% !important;
  max-height:100% !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:14px !important;
  display:block;
  background:transparent;
}

.pc .ps-dots{
  position:relative;
  display:flex;
  justify-content:center;
  align-items:center;
  gap:6px;
  margin-top:10px;
  margin-bottom:2px;
  z-index:5;
}
.pc .ps-dot{
  width:7px;
  height:7px;
  border-radius:50%;
  background:var(--line);
  cursor:pointer;
  transition:all .25s ease;
}
.pc .ps-dot:hover{
  background:var(--mut);
}
.pc .ps-dot.active{
  background:var(--green);
  width:18px;
  border-radius:999px;
  transform:none;
}

.pc .b{
  text-align:left;
  align-items:stretch;
  padding:14px 8px 8px;
  gap:8px;
  display:flex;
  flex-direction:column;
  flex:1;
}
.pc h3{
  font-size:20px;
  line-height:1.2;
  color:var(--ink);
  font-family:var(--serif);
}
.pc .s{
  font-size:13px;
  color:var(--mut);
  line-height:1.4;
  min-height:36px;
}
.pc .meta{
  display:flex;
  gap:6px;
  flex-wrap:wrap;
  margin-top:auto;
}
.pc .meta span{
  font-size:11px;
  background:var(--bg2);
  color:var(--ink);
  padding:4px 10px;
  border-radius:999px;
  border:1px solid var(--line);
}
.btn-details{
  background:var(--green);
  color:#fff;
  padding:12px;
  border-radius:999px;
  font-size:13px;
  font-weight:600;
  text-align:center;
  margin-top:10px;
  transition:background .2s;
  display:block;
  text-decoration:none;
}
.btn-details:hover{background:#266391}

.t-single-grid{display:grid;grid-template-columns:1.24fr 1fr;gap:44px;align-items:center}
.t-slider-wrap{position:relative;width:100%;max-width:540px;margin:0 auto}
.t-slider{
  position:relative;
  width:100%;
  border-radius:24px;
  overflow:hidden;
  border:1px solid var(--line);
  background:transparent;
  box-shadow:0 12px 32px rgba(14,40,66,.07);
}
.t-slides{
  display:grid;
  grid-template-columns:100%;
  width:100%;
}
.t-slide{
  grid-column:1;
  grid-row:1;
  width:100%;
  opacity:0;
  pointer-events:none;
  transition:opacity .55s ease-in-out;
  display:block;
  text-decoration:none;
  cursor:pointer;
  border-radius:inherit;
  position:relative;
}
.t-slide.active{
  opacity:1;
  pointer-events:auto;
  z-index:2;
}
.t-slide img{
  width:100% !important;
  height:auto !important;
  max-width:100% !important;
  max-height:none !important;
  display:block !important;
  border-radius:inherit !important;
  padding:0 !important;
  margin:0 !important;
  transition:transform .4s ease;
}
.t-slide:hover img{transform:scale(1.015)}
.t-badge-zoom{
  position:absolute;
  top:12px;
  right:12px;
  background:rgba(20,35,50,.78);
  backdrop-filter:blur(6px);
  color:#fff;
  font-size:11px;
  font-weight:600;
  padding:5px 12px;
  border-radius:999px;
  display:flex;
  align-items:center;
  gap:5px;
  z-index:3;
  pointer-events:none;
}
.t-badge-zoom svg{width:13px;height:13px;stroke:#fff}
.t-dots{display:flex;justify-content:center;gap:8px;margin-top:14px}
.t-dot{
  width:8px;
  height:8px;
  border-radius:50%;
  background:var(--line);
  cursor:pointer;
  transition:all .25s ease;
}
.t-dot.active{
  background:var(--green);
  width:22px;
  border-radius:999px;
}

.t-single-content{display:flex;flex-direction:column;gap:16px}
.t-single-content h2{font-size:clamp(28px,4vw,42px);color:var(--ink)}
.t-single-content p{font-size:15px;color:var(--mut);line-height:1.65}
.t-metrics{display:flex;gap:24px;margin:8px 0 12px;padding:16px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.t-metrics div b{font-family:var(--serif);font-size:24px;color:var(--gold);display:block}
.t-metrics div p{font-size:12px;color:var(--mut);margin:0}

.t-lightbox{position:fixed;inset:0;background:rgba(10,17,26,.88);backdrop-filter:blur(8px);z-index:9999;display:none;align-items:center;justify-content:center;padding:20px}
.t-lightbox.open{display:flex}
.t-lightbox-inner{position:relative;max-width:960px;width:100%;background:var(--card-surface);border-radius:24px;padding:16px;box-shadow:0 25px 60px rgba(0,0,0,.5);display:flex;flex-direction:column;gap:10px;border:1px solid var(--line)}
.t-lightbox-inner img{width:100%;height:auto;max-height:80vh;object-fit:contain;border-radius:16px;background:var(--card-surface)}
.t-lightbox-title{font-size:14px;font-weight:600;color:var(--ink);padding:4px 6px;text-align:center}
.t-lightbox-close{position:absolute;top:-14px;right:-14px;width:38px;height:38px;border-radius:50%;background:var(--card-surface);color:var(--ink);font-size:22px;font-weight:600;box-shadow:0 6px 16px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;cursor:pointer;border:1px solid var(--line)}

.div2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.camp{position:relative;aspect-ratio:16/9;color:#fff;display:flex;align-items:center;border-radius:26px;overflow:hidden;cursor:pointer;border:1px solid var(--line)}
.camp img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;transition:transform .5s}
.camp:hover img{transform:scale(1.03)}
.camp:before{content:"";position:absolute;inset:0;z-index:1;background:rgba(10,17,26,.2)}

.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.steps div{background:var(--card-surface);border:1px solid var(--line);border-radius:24px;padding:24px}
.steps b{font:italic 500 46px/1 var(--serif);color:var(--gold)}
.steps h3{margin:10px 0 8px;font-size:23px;color:var(--ink)}
.steps p{font-size:14px;color:var(--mut)}

footer{background:var(--green);color:#E3EFF8;padding:60px 0 24px;font-size:13px;transition:background-color .25s ease}
[data-theme="dark"] footer{background:#070D14;border-top:1px solid var(--line);color:#C8DCEE}
.fg{display:grid;grid-template-columns:1.5fr 1fr 1.3fr 1.2fr;gap:32px}
footer h4{font-family:var(--serif);font-size:20px;font-weight:500;margin-bottom:12px;color:#fff}
footer li{list-style:none;margin-bottom:6px}
.social-links{display:flex;flex-direction:column;gap:10px;margin-top:8px}
.social-link{display:inline-flex;align-items:center;gap:10px;color:#E3EFF8;font-size:13px;font-weight:500;transition:all .2s ease;padding:7px 14px;background:rgba(255,255,255,.09);border-radius:12px;width:fit-content}
[data-theme="dark"] .social-link{background:rgba(255,255,255,.06);border:1px solid var(--line)}
.social-link:hover{background:rgba(255,255,255,.2);color:#fff;transform:translateY(-2px)}
.social-link svg{flex-shrink:0}
.copy{border-top:1px solid rgba(255,255,255,.2);margin-top:40px;padding-top:18px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;opacity:.85}
[data-theme="dark"] .copy{border-top:1px solid var(--line);color:var(--mut)}

#performance-division,#premium-supplements{scroll-margin-top:90px}
.nx-eyebrow{font:600 11px var(--sans);letter-spacing:.28em;text-transform:uppercase;color:var(--gold)}
.nx-ico{width:22px;height:22px;stroke:currentColor;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}

.nx-hero{position:relative;border-radius:26px;overflow:hidden;color:#fff;min-height:440px;display:flex;align-items:center;border:1px solid var(--line)}
.nx-hero>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.nx-hero:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(10,17,26,.9),rgba(10,17,26,.3) 78%)}
.nx-hero-in{position:relative;z-index:2;padding:48px;max-width:580px;display:flex;flex-direction:column;gap:14px;align-items:flex-start}
.nx-hero-in .nx-eyebrow{color:#9FCBEA}
.nx-hero-in h3{color:#fff;font-size:clamp(30px,4.2vw,52px);letter-spacing:.03em}
.nx-hero-in p{color:#fff;opacity:.92;max-width:440px}
.nx-acts{display:flex;gap:22px;flex-wrap:wrap;margin:4px 0 8px}
.nx-acts span{display:flex;flex-direction:column;align-items:center;gap:7px;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:#fff}
.nx-acts .nx-ico{width:26px;height:26px;stroke:#fff}
.nx-hero .btn{background:#fff;color:var(--green)}
.nx-hero .btn:hover{background:#E9F2FA}

.nx-feats{display:grid;grid-template-columns:repeat(5,1fr);gap:0;margin-top:24px;background:var(--card-surface);border:1px solid var(--line);border-radius:24px;overflow:hidden;transition:background-color .25s ease,border-color .25s ease}
.nx-feat{display:flex;align-items:center;gap:12px;padding:20px 18px;border-right:1px solid var(--line)}
.nx-feat:last-child{border-right:0}
.nx-feat .nx-ico{width:34px;height:34px;padding:7px;border-radius:50%;background:var(--bg2);color:var(--green);border:1px solid var(--line)}
.nx-feat b{display:block;font-size:12px;letter-spacing:.04em;text-transform:uppercase;color:var(--ink);line-height:1.3}
.nx-feat small{display:block;font-size:11px;color:var(--mut);line-height:1.4;margin-top:2px}

.nx-sig{margin-top:56px}
.nx-sig .ph{aspect-ratio:1/1;border:1px solid var(--line);background:#f5f7fa}
.nx-sig .ph img{object-fit:contain;transition:transform .6s}
.nx-sig .ph:hover img{transform:scale(1.04)}
.nx-sig-body{display:flex;flex-direction:column;gap:14px}
.nx-sig-body h2{font-size:clamp(28px,4vw,42px)}
.nx-tag{display:inline-block;align-self:flex-start;font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--green);background:var(--bg2);border:1px solid var(--line);padding:6px 14px;border-radius:999px}
.nx-sig-body p{color:var(--mut)}
.nx-views{display:flex;gap:8px;flex-wrap:wrap}
.nx-views span{font-size:11px;background:var(--bg2);color:var(--ink);padding:4px 12px;border-radius:999px;border:1px solid var(--line)}

.nx-d3{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:40px}
.nx-d3 div{background:var(--card-surface);border:1px solid var(--line);border-radius:24px;padding:22px;transition:transform .3s,box-shadow .3s,background-color .25s ease,border-color .25s ease}
.nx-d3 div:hover{transform:translateY(-4px);box-shadow:0 24px 44px -28px rgba(47,111,159,.5)}
.nx-d3 b{font:italic 500 34px/1 var(--serif);color:var(--gold)}
.nx-d3 h3{margin:8px 0 6px;font-size:20px}
.nx-d3 p{font-size:13px;color:var(--mut)}

.nx-band{position:relative;margin-top:40px;border-radius:26px;overflow:hidden;color:#fff;min-height:300px;display:flex;align-items:center;border:1px solid var(--line)}
.nx-band>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.nx-band:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(10,17,26,.88),rgba(10,17,26,.35))}
.nx-band-in{position:relative;z-index:2;padding:40px 48px;max-width:620px;display:flex;flex-direction:column;gap:12px;align-items:flex-start}
.nx-band-in h3{color:#fff;font-size:clamp(28px,3.6vw,44px)}
.nx-band-in p{color:#fff;opacity:.92}
.nx-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:4px}
.nx-chips span{display:inline-flex;align-items:center;gap:7px;font-size:12px;font-weight:500;color:#fff;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.35);backdrop-filter:blur(4px);padding:7px 14px;border-radius:999px}
.nx-chips .nx-ico{width:15px;height:15px}

.nx-benefits{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px}
.nx-benefits span{display:inline-flex;align-items:center;gap:9px;font-size:12px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--ink);background:var(--card-surface);border:1px solid var(--line);padding:10px 18px;border-radius:999px;transition:background-color .25s ease,border-color .25s ease}
.nx-benefits .nx-ico{width:18px;height:18px;color:var(--green)}

.nx-sup{background:var(--card-surface);border:1px solid var(--line);border-radius:26px;overflow:hidden;display:flex;flex-direction:column;transition:transform .3s,box-shadow .3s,background-color .25s ease,border-color .25s ease}
.nx-sup:hover{transform:translateY(-6px);box-shadow:0 24px 44px -24px rgba(47,111,159,.5)}
.nx-sup .ph{aspect-ratio:16/10;border-radius:0}
.nx-sup-body{padding:24px;display:flex;flex-direction:column;gap:10px;flex:1}
.nx-sup-body h3{font-size:28px}
.nx-sub{font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--gold)}
.nx-sup-body ul{list-style:none;display:flex;flex-direction:column;gap:7px;margin:4px 0 6px}
.nx-sup-body li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--mut)}
.nx-sup-body li:before{content:"\2713";flex-shrink:0;width:20px;height:20px;border-radius:50%;background:var(--bg2);border:1px solid var(--line);color:var(--green);font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;margin-top:1px}
.nx-sup-body .meta{display:flex;gap:6px;flex-wrap:wrap;margin-top:auto}
.nx-sup-body .meta span{font-size:11px;background:var(--bg2);color:var(--ink);padding:4px 10px;border-radius:999px;border:1px solid var(--line)}

.nx-quality{margin-top:56px;align-items:center}
.nx-quality .ph{aspect-ratio:4/3;border:1px solid var(--line)}
.nx-q-body{display:flex;flex-direction:column;gap:14px}
.nx-q-body h2{font-size:clamp(28px,4vw,42px)}
.nx-q-body>p{color:var(--mut)}
.nx-q-list{display:flex;flex-direction:column;gap:12px;margin-top:6px}
.nx-q-list div{display:flex;align-items:center;gap:14px;background:var(--card-surface);border:1px solid var(--line);border-radius:18px;padding:14px 18px;transition:background-color .25s ease,border-color .25s ease}
.nx-q-list .nx-ico{width:38px;height:38px;padding:8px;border-radius:50%;background:var(--bg2);color:var(--green);border:1px solid var(--line)}
.nx-q-list b{font-size:13px;letter-spacing:.05em;text-transform:uppercase;color:var(--ink)}

@media(max-width:1080px){
 .bar{display:flex;justify-content:space-between;align-items:center;height:68px}
 nav.dnav{display:none !important}
 .burger-btn{display:inline-flex !important}
 .logo{text-align:left;font-size:24px}
 .logo small{letter-spacing:.26em}
 .rt{gap:10px}
}
@media(max-width:960px){
 .t-single-grid{grid-template-columns:1fr;gap:32px}
 .t-slider-wrap{max-width:540px;margin:0 auto}
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
 .g3,.g4,.steps{grid-template-columns:1fr}
 .g6{grid-template-columns:repeat(2,1fr);gap:12px}
 .camp{min-height:unset}
 .t-metrics{flex-wrap:wrap;gap:16px}
}
@media(max-width:1000px){
 .nx-feats{grid-template-columns:repeat(2,1fr)}
 .nx-feat{border-bottom:1px solid var(--line)}
 .nx-feat:nth-child(2n){border-right:0}
 .nx-feat:last-child{grid-column:1/-1;border-bottom:0}
 .nx-d3{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
 .nx-hero{min-height:420px}
 .nx-hero-in,.nx-band-in{padding:28px 22px}
 .nx-feats{grid-template-columns:1fr}
 .nx-feat{border-right:0}
 .nx-feat:last-child{grid-column:auto}
 .nx-d3{grid-template-columns:1fr}
 .nx-sup-body{padding:20px}
 .nx-sig .ph{aspect-ratio:1/1}
}

.nx-toast{position:fixed;left:50%;bottom:calc(24px + env(safe-area-inset-bottom, 0px));transform:translate(-50%,20px);opacity:0;pointer-events:none;z-index:10000;background:var(--ink);color:var(--bg);padding:12px 22px;border-radius:999px;font-size:13px;font-weight:600;box-shadow:0 12px 30px rgba(0,0,0,.28);transition:opacity .25s ease,transform .25s ease;max-width:calc(100vw - 32px);text-align:center}
.nx-toast.show{opacity:1;transform:translate(-50%,0)}

.nxg{display:flex;flex-direction:column;gap:48px}
.nxg-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap}
.nxg-head p{color:var(--mut);margin-top:8px;max-width:520px}
.nxg-grid{display:grid;gap:28px 22px}
.nxg-grid.c4{grid-template-columns:repeat(4,1fr)}
.nxg-grid.c3{grid-template-columns:repeat(3,1fr)}
.nxg-fig{margin:0;min-width:0}
.nxg-ph{position:relative;overflow:hidden;border-radius:20px;border:1px solid var(--line);background:#f6f8fa}
.nxg-ph.rA{aspect-ratio:369/327}
.nxg-ph.rB{aspect-ratio:16/10}
.nxg-ph.rC{aspect-ratio:4/3;background:#f8f8f8}
.nxg-ph.rC img{inset:9%;width:82%;height:82%;object-fit:contain}
.nxg-ph img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.nxg-fig:hover .nxg-ph img{transform:scale(1.03)}
.nxg-cap{margin-top:12px}
.nxg-cap b{display:block;font-size:14px;font-weight:600;color:var(--ink);line-height:1.35}
.nxg-cap small{display:block;font-size:13px;color:var(--mut);margin-top:2px}
.nxg-title{display:flex;align-items:center;gap:18px;margin-bottom:-12px}
.nxg-title h3{font-size:clamp(22px,2.6vw,30px);white-space:nowrap}
.nxg-title:after{content:"";flex:1;height:1px;background:var(--line)}
@media(max-width:900px){
 .nxg{gap:40px}
 .nxg-grid.c4,.nxg-grid.c3{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:640px){
 .nxg-grid{gap:22px 14px}
 .nxg-ph{border-radius:16px}
 .nxg-cap b{font-size:13px}
 .nxg-cap small{font-size:12px}
 .nxg-head .btn{width:100%}
}

.nx-cta{--cta-rgb:27,68,104;position:relative;display:flex;align-items:center;height:clamp(260px,26vw,380px);overflow:hidden;background:rgb(var(--cta-rgb))}
[data-theme="dark"] .nx-cta{--cta-rgb:11,27,43}
.nx-cta-img{position:absolute;top:0;right:0;bottom:0;width:70%}
.nx-cta-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
.nx-cta:after{content:"";position:absolute;inset:0;z-index:1;pointer-events:none;background:linear-gradient(90deg,rgba(var(--cta-rgb),1) 0%,rgba(var(--cta-rgb),1) 30%,rgba(var(--cta-rgb),.6) 37%,rgba(var(--cta-rgb),.2) 50%,rgba(var(--cta-rgb),.1) 100%)}
.nx-cta-panel{position:relative;z-index:2;width:32%;min-width:300px;display:flex;flex-direction:column;gap:12px;padding:32px clamp(24px,4vw,64px);color:#fff}
.nx-cta-panel .nx-eyebrow{color:rgba(255,255,255,.75)}
.nx-cta-panel h3{color:#fff;font-size:clamp(26px,2.9vw,44px)}
.nx-cta-panel p{color:#fff;opacity:.9;font-size:15px}
@media(max-width:900px){
 .nx-cta{display:block;height:auto}
 .nx-cta:after{display:none}
 .nx-cta-img{position:relative;width:100%;aspect-ratio:2/1}
 .nx-cta-img img{object-position:60% center}
 .nx-cta-img:after{content:"";position:absolute;left:0;right:0;bottom:0;height:65%;background:linear-gradient(180deg,rgba(var(--cta-rgb),0),rgba(var(--cta-rgb),1))}
 .nx-cta-panel{width:auto;min-width:0;margin-top:-64px;padding:0 24px 36px}
}
</style>
</head>
<body>
<div class="top">Made in USA. High Purity. Research Graded. Cold chain shipping worldwide.</div>

@php
    $isCatalogActive = request()->routeIs('products.*') || request()->routeIs('accessory*') || request()->is('products*') || request()->is('accessory*');
    $isStoreActive = request()->is('performance*') || request()->is('premium*') || request()->routeIs('performance*') || request()->routeIs('premium*');
@endphp

<header>
  <div class="wrap bar">
    <nav class="dnav">
      <a href="{{ route('home') }}" class="{{ (request()->routeIs('home') && !request()->is('performance*') && !request()->is('premium*')) ? 'on' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>

      <div class="dd" id="ddCatalog">
        <button type="button" class="dd-trigger {{ $isCatalogActive ? 'on' : '' }}" onclick="toggleDD(event,'ddCatalog')" aria-haspopup="true">Catalog <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
        <div class="dd-menu"><div class="dd-box">
          <a href="{{ route('products.index') }}">Products</a>
          <a href="{{ route('accessory') }}">Accessory</a>
        </div></div>
      </div>

      <div class="dd" id="ddStore">
        <button type="button" class="dd-trigger {{ $isStoreActive ? 'on' : '' }}" onclick="toggleDD(event,'ddStore')" aria-haspopup="true">Novex Store <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
        <div class="dd-menu"><div class="dd-box">
          <a href="{{ url('/performance') }}">Novex Performance Division</a>
          <a href="{{ url('/premium') }}">Novex Premium Supplements</a>
        </div></div>
      </div>
    </nav>
    
    <a href="{{ route('home') }}" class="logo">NOVEX<small>PEPTIDES</small></a>
    
    <div class="rt">
      <nav class="dnav">
        <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'on' : '' }}">Resources</a>
        <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'on' : '' }}">Science</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
      </nav>

      <div class="tools">
        <button type="button" class="theme-btn" id="themeToggleBtn" onclick="toggleTheme()" aria-label="Switch to dark theme" title="Switch to dark theme">
          <svg class="ico-moon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
          <svg class="ico-sun" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
        </button>

        <a class="cart-trigger-btn" href="{{ route('cart') }}" aria-label="Shopping Cart">
          <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
          <span class="cart-badge" id="cartCount">0</span>
        </a>

        <button type="button" class="burger-btn" id="mobileBurgerBtn" onclick="toggleMobileNav(event)" aria-label="Toggle Menu">
          <svg class="icon-open" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
          <svg class="icon-close" style="display:none" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="mnav" id="navM">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>

    <div class="m-group">
      <span class="m-group-title">Catalog</span>
      <a class="sub {{ request()->routeIs('products.*') ? 'on' : '' }}" href="{{ route('products.index') }}">Products</a>
      <a class="sub {{ request()->routeIs('accessory') ? 'on' : '' }}" href="{{ route('accessory') }}">Accessory</a>
    </div>

    <div class="m-group">
      <span class="m-group-title">Novex Store</span>
      <a class="sub {{ request()->is('performance*') ? 'on' : '' }}" href="{{ url('/performance') }}">Novex Performance Division</a>
      <a class="sub {{ request()->is('premium*') ? 'on' : '' }}" href="{{ url('/premium') }}">Novex Premium Supplements</a>
    </div>

    <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'on' : '' }}">Resources</a>
    <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'on' : '' }}">Science</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
  </nav>
</header>

<main id="app">
@hasSection('content')
    @yield('content')
@else
  <div class="nx-view" id="view-home">
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
        <img src="https://images.unsplash.com/photo-1608068811588-3a67006b7489?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D" alt="Hero Banner 2">
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
        <img src="https://images.unsplash.com/photo-1614935151651-0bea6508db6b?q=80&w=1225&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D" alt="Hero Banner 3">
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
        <a class="cat" href="{{ route('products.show', 'retatrutide') }}"><img src="{{ asset('assets/website/category/c1.webp') }}" alt="Retatrutide"><div><h3>01 | Retatrutide</h3><p>Weight Management</p></div></a>
        <a class="cat" href="{{ route('products.show', 'reta-plus') }}"><img src="{{ asset('assets/website/category/c2.webp') }}" alt="Retatrutide Plus"><div><h3>02 | Retatrutide Plus</h3><p>Dual Action Formulation</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="{{ asset('assets/website/category/c3.webp') }}" alt="Skincare Peptides"><div><h3>03 | Skincare Peptides</h3><p>Cellular Rejuvenation</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="{{ asset('assets/website/category/c4.webp') }}" alt="Performance"><div><h3>04 | Performance</h3><p>Longevity & Power</p></div></a>
        <a class="cat" href="{{ route('products.index') }}"><img src="{{ asset('assets/website/category/c5.webp') }}" alt="Novex Skincare"><div><h3>05 | Novex Skincare</h3><p>Serums & Cream</p></div></a>
        <a class="cat" href="{{ route('products.show', 'jersey-01') }}"><img src="{{ asset('assets/website/category/c6.webp') }}" alt="Athletic Apparel"><div><h3>06 | Athletic Apparel</h3><p>Performance Jersey</p></div></a>
      </div>
    </div></section>

    <section class="sec alt" id="lab-reports">
      <div class="wrap">
        <div class="head" style="justify-content:center;text-align:center;margin-bottom:0">
          <div style="align-items:center;text-align:center;max-width:680px;margin:0 auto">
            <h2 style="font-size:clamp(28px,4vw,42px)">Third-Party Lab Testing &amp; COA Analysis</h2>
            <p style="margin:10px auto 20px;font-size:15px;line-height:1.6">
              Every batch is independently tested via HPLC and Mass Spectrometry to guarantee purity above 99% and authentic molecular sequence.
            </p>
            <a class="btn" href="{{ route('science') }}" style="padding:12px 32px;font-size:13px;font-weight:600">See Lab Reports →</a>
          </div>
        </div>
      </div>
    </section>

    <section class="sec" id="testimonies">
      <div class="wrap">
        <div class="t-single-grid">
          <div class="t-slider-wrap">
            <div class="t-slider" id="transformSlider">
              <div class="t-slides">
                @for ($i = 2; $i <= 8; $i++)
                  @php
                    $tFilename = 't' . $i . '.webp';
                    $tDiskPath = public_path($tFilename);
                    $tVersion = file_exists($tDiskPath) ? filemtime($tDiskPath) : time();
                    $tFullUrl = asset($tFilename) . '?v=' . $tVersion;
                  @endphp
                  <a href="{{ $tFullUrl }}" onclick="openLightboxModal('{{ $tFullUrl }}', 'Client Transformation #{{ $i }} - Real Results'); return false;" class="t-slide {{ $i === 2 ? 'active' : '' }}">
                    <img src="{{ $tFullUrl }}" alt="Client Transformation {{ $i }}" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700'">
                    <div class="t-badge-zoom">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                      <span>Enlarge</span>
                    </div>
                  </a>
                @endfor
              </div>
            </div>

            <div class="t-dots">
              @for ($i = 0; $i < 7; $i++)
                <span class="t-dot {{ $i === 0 ? 'active' : '' }}" onclick="setTransformSlide({{ $i }}, event)"></span>
              @endfor
            </div>
          </div>

          <div class="t-single-content">
            <h2>Real Transformations, Proven Results</h2>
            <p>Explore real transformation journeys from our community. Consistent protocol adherence with research-grade compounds supports sustained vitality, metabolic balance, and body composition optimisation.</p>
            <div class="t-metrics">
              <div>
                <b>12 Weeks</b>
                <p>Protocol Cycle</p>
              </div>
              <div>
                <b>&gt;99%</b>
                <p>HPLC Purity</p>
              </div>
              <div>
                <b>Optimal</b>
                <p>Metabolic Response</p>
              </div>
            </div>
            <div>
              <a class="btn" href="{{ route('products.index') }}" style="padding:14px 40px;font-size:14px;font-weight:600">Shop Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="sec alt"><div class="wrap">
      <div class="head">
        <div>
          <h2>Featured Formulations</h2>
          <p>High-purity research compounds and advanced formulations verified for laboratory excellence.</p>
        </div>
        <a class="btn line" href="{{ route('products.index') }}">View all</a>
      </div>
      <div class="g4">
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

            $items = $featuredProducts ?? \Illuminate\Support\Facades\DB::select(
                "SELECT * FROM products 
                 WHERE (page_type != 'accessory' OR page_type IS NULL OR page_type = '') 
                   AND (category NOT IN ('Accessory', 'Injection Kit', 'Syringes') OR category IS NULL) 
                 ORDER BY id DESC LIMIT 4"
            );
        @endphp

        @forelse($items as $item)
          @php
              $slides = [];
              if (!empty($item->image)) {
                  $decoded = json_decode($item->image, true);
                  if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                      $slides = array_values(array_filter($decoded, fn($p) => !empty($p)));
                  } else {
                      $slides = [$item->image];
                  }
              }
              if (empty($slides)) {
                  $slides = ['reta1.webp'];
              }

              $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                  ? $item->slug
                  : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

              $isItemAcc = (isset($item->page_type) && strtolower($item->page_type) === 'accessory')
                  || in_array($item->category ?? '', ['Accessory', 'Injection Kit', 'Syringes']);

              $detailUrl = $isItemAcc
                  ? (\Illuminate\Support\Facades\Route::has('accessory.show') ? route('accessory.show', $itemSlug) : url('/accessory/' . $itemSlug))
                  : (\Illuminate\Support\Facades\Route::has('products.show') ? route('products.show', $itemSlug) : url('/products/' . $itemSlug));
          @endphp

          <div class="card pc" data-category="{{ $item->category ?? 'Weight Management' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
            <div class="ph">
              <div class="prod-slider">
                <div class="prod-slides">
                  @foreach($slides as $sIdx => $imgSrc)
                    <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                      <img src="{{ $resolveImageUrl($imgSrc) }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            @if(count($slides) > 1)
              <div class="ps-dots">
                @foreach($slides as $sIdx => $imgSrc)
                  <span class="ps-dot {{ $sIdx === 0 ? 'active' : '' }}" onclick="setCardSlide(this, {{ $sIdx }})"></span>
                @endforeach
              </div>
            @endif

            <div class="b">
              <h3>{{ $item->title }}</h3>
              <p class="s">{{ $item->subtitle ?? '' }}</p>
              <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $item->price }}</div>
              <div class="meta">
                <span style="font-weight:600">{{ $item->dosage_spec ?? 'Standard' }}</span>
                <span>{{ $item->badge_category ?? 'Research grade' }}</span>
              </div>
              <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
            </div>
          </div>
        @empty
          <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--mut); font-size: 14px;">
            Formulation catalog is currently being updated.
          </div>
        @endforelse
      </div>

      <div class="div2" style="margin-top:48px">
        <a class="camp" href="{{ route('products.index') }}" aria-label="Explore Performance Peptides">
          <img src="{{ asset('f1.webp') }}" alt="Performance Peptides Banner" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1000&q=85'">
        </a>
        <a class="camp" href="{{ route('products.index') }}" aria-label="Explore Peptide Skincare">
          <img src="{{ asset('r1.webp') }}" alt="Skincare Peptides Banner" onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1000&q=85'">
        </a>
      </div>
    </div></section>

    <section class="sec"><div class="wrap">
      <div class="head"><div><h2>From the bench to your door</h2><p>Four checkpoints every vial passes before it leaves us.</p></div></div>
      <div class="steps">
        <div><b>01</b><h3>Synthesis</h3><p>Produced under certified partner cGMP conditions in the USA.</p></div>
        <div><b>02</b><h3>Testing</h3><p>Third-party testing verifies purity and compound identity via HPLC.</p></div>
        <div><b>03</b><h3>Cold Storage</h3><p>Stored under continuous temperature-monitored environments.</p></div>
        <div><b>04</b><h3>Insulated Dispatch</h3><p>Express courier cold-chain dispatch directly to your institution.</p></div>
      </div>
    </div></section>

    <section class="sec alt"><div class="wrap">
      <div class="head">
        <div>
          <h2>Latest Science Articles</h2>
          <p>Carefully curated scientific literature, compound mechanisms, and laboratory research notes.</p>
        </div>
        <a class="btn line" href="{{ route('resources') }}">All articles</a>
      </div>
      <div class="g4 art">
        <a class="card" href="{{ route('resources') }}" style="background:var(--card-surface);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="{{ asset('assets/website/science/s1.webp') }}" alt="Understanding Retatrutide">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">Understanding Retatrutide</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card-surface);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="{{ asset('assets/website/science/s2.webp') }}" alt="The Science of GHK-Cu">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">The Science of GHK-Cu</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card-surface);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="{{ asset('assets/website/science/s3.webp') }}" alt="Benefits of NAD+">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">Benefits of NAD+</h3></div>
        </a>
        <a class="card" href="{{ route('resources') }}" style="background:var(--card-surface);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column">
          <div class="ph" style="aspect-ratio:16/10;border-radius:0">
            <img src="{{ asset('assets/website/science/s4.webp') }}" alt="What is Tesamorelin">
          </div>
          <div class="b" style="padding:18px"><h3 style="font-size:20px">What is Tesamorelin</h3></div>
        </a>
      </div>
    </div></section>
  </div>
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
 <div class="copy"><span>© 2026 Novex Peptides. All rights reserved.</span><span>For laboratory use only. Not for human consumption.</span></div>
</div></footer>

<div class="nx-toast" id="nxToast" role="status" aria-live="polite"></div>

<script>
function applyTheme(mode) {
  const theme = (mode === 'dark') ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', theme);
  const btn = document.getElementById('themeToggleBtn');
  if (btn) {
    const label = 'Switch to ' + (theme === 'dark' ? 'light' : 'dark') + ' theme';
    btn.setAttribute('aria-label', label);
    btn.setAttribute('title', label);
  }
}

function toggleTheme() {
  const cur = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  const next = cur === 'dark' ? 'light' : 'dark';
  try { localStorage.setItem('nvx_theme', next); } catch (e) {}
  applyTheme(next);
}

function toggleDD(e, id) {
  if (e) { e.preventDefault(); e.stopPropagation(); }
  if (window.matchMedia('(hover:hover)').matches) return;
  const el = document.getElementById(id);
  document.querySelectorAll('.dd.open').forEach(d => { if (d !== el) d.classList.remove('open'); });
  if (el) el.classList.toggle('open');
}

function closeDD() {
  document.querySelectorAll('.dd.open').forEach(d => d.classList.remove('open'));
}

function toggleMobileNav(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) {
    const isOpen = navM.classList.toggle('open');
    if (btn) btn.classList.toggle('open', isOpen);
  }
}

function closeMobileNav() {
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) navM.classList.remove('open');
  if (btn) btn.classList.remove('open');
}

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDD(); });

document.addEventListener('click', (e) => {
  if (!e.target.closest('.dd')) closeDD();
  const navM = document.getElementById('navM');
  const burgerBtn = document.getElementById('mobileBurgerBtn');
  if (navM && navM.classList.contains('open')) {
    if (!navM.contains(e.target) && burgerBtn && !burgerBtn.contains(e.target)) {
      closeMobileNav();
    }
  }
});

let hi = 0, ht;
function go(n){
  const slides = document.querySelectorAll('.hero.sl .slide');
  const dots = document.querySelectorAll('.hero.sl .dot');
  if(!slides.length) return;
  hi = (n + slides.length) % slides.length;
  slides.forEach((x, i) => x.classList.toggle('on', i === hi));
  dots.forEach((d, i) => d.classList.toggle('on', i === hi));
}

function setCardSlide(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const card = dot.closest('.card') || dot.closest('.pc');
  if(!card) return;
  const slider = card.querySelector('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

var prodSlideTimer = null;
function startProdAutoSlide(){
  clearInterval(prodSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  prodSlideTimer = setInterval(() => {
    document.querySelectorAll('.card.pc').forEach(box => {
      const slides = box.querySelectorAll('.prod-slide');
      const dots = box.querySelectorAll('.ps-dot');
      if(slides.length < 2) return;
      let cur = 0;
      slides.forEach((s, idx) => { if(s.classList.contains('active')) cur = idx; });
      let next = (cur + 1) % slides.length;
      slides.forEach((s, idx) => s.classList.toggle('active', idx === next));
      dots.forEach((d, idx) => d.classList.toggle('active', idx === next));
    });
  }, 4500);
}

let tSlideIndex = 0;
const totalTSlides = 7;
let tSlideTimer = null;

function setTransformSlide(idx, e){
  if(e){
    e.preventDefault();
    e.stopPropagation();
  }
  tSlideIndex = (idx + totalTSlides) % totalTSlides;
  document.querySelectorAll('.t-slide').forEach((s, i) => {
    s.classList.toggle('active', i === tSlideIndex);
  });
  document.querySelectorAll('.t-dot').forEach((d, i) => {
    d.classList.toggle('active', i === tSlideIndex);
  });
}

function startTransformTimer(){
  clearInterval(tSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  tSlideTimer = setInterval(() => {
    setTransformSlide(tSlideIndex + 1);
  }, 4500);
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

const NX_CART_KEY = 'nvx_cart';
function nxGetCart() { try { return JSON.parse(localStorage.getItem(NX_CART_KEY)) || []; } catch (e) { return []; } }
function nxSaveCart(c) { try { localStorage.setItem(NX_CART_KEY, JSON.stringify(c)); } catch (e) {} }
function nxUpdateBadge() {
  const n = nxGetCart().reduce((a, i) => a + (i.qty || 0), 0);
  const b = document.getElementById('cartCount');
  if (b) b.textContent = n;
}
let nxToastTimer;
function nxToast(msg) {
  const t = document.getElementById('nxToast');
  if (!t) return;
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(nxToastTimer);
  nxToastTimer = setTimeout(() => t.classList.remove('show'), 2200);
}
function nxPickSize(btn) {
  const box = btn.closest('.nx-buy');
  box.querySelectorAll('.nx-size').forEach(b => b.classList.toggle('active', b === btn));
  box.classList.remove('need-size');
}
function nxQty(btn, d) {
  const inp = btn.parentElement.querySelector('input');
  let v = parseInt(inp.value, 10) || 1;
  inp.value = Math.min(99, Math.max(1, v + d));
}
function nxAdd(btn) {
  const box = btn.closest('.nx-buy');
  if (!box) return;
  let size = '';
  if (box.querySelector('.nx-size')) {
    const a = box.querySelector('.nx-size.active');
    if (!a) { box.classList.add('need-size'); nxToast('Please select a size first'); return; }
    size = a.dataset.size;
  }
  const inp = box.querySelector('.nx-qty input');
  const qty = Math.min(99, Math.max(1, parseInt(inp && inp.value, 10) || 1));
  const cart = nxGetCart();
  const id = box.dataset.id;
  const found = cart.find(i => i.id === id && (i.size || '') === size);
  if (found) { found.qty = Math.min(99, found.qty + qty); }
  else {
    cart.push({ id: id, name: box.dataset.name, price: parseFloat(box.dataset.price) || 0, img: box.dataset.img || '', size: size, qty: qty });
  }
  nxSaveCart(cart);
  nxUpdateBadge();
  nxToast('Added to cart' + (size ? ' (' + size + ')' : '') + ' \u2713');
  const old = btn.textContent;
  btn.textContent = 'Added \u2713';
  btn.classList.add('done');
  setTimeout(() => { btn.textContent = old; btn.classList.remove('done'); }, 1400);
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
  applyTheme(document.documentElement.getAttribute('data-theme'));
  nxUpdateBadge();

  if(document.querySelector('.hero.sl .slide')){
    ht = setInterval(() => go(hi + 1), 7000);
  }
  startProdAutoSlide();
  startTransformTimer();

  const transformBox = document.getElementById('transformSlider');
  if(transformBox){
    transformBox.addEventListener('mouseenter', () => clearInterval(tSlideTimer));
    transformBox.addEventListener('mouseleave', () => startTransformTimer());
  }
});
</script>
</body>
</html>