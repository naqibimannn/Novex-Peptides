@extends('frontend.home.index')

@section('content')
<style>
/* Penataan Gaya Kad Produk Mengikut Standard Paparan Utama */
.pc{
  padding:14px;
  background:#fff;
  border:1px solid var(--line);
  border-radius:26px;
  transition:transform .3s ease,box-shadow .3s ease;
  display:flex;
  flex-direction:column;
}
.pc:hover{
  transform:translateY(-6px);
  box-shadow:0 24px 44px -24px rgba(47,111,159,.5);
}
.pc .ph{
  aspect-ratio:4/5;
  border-radius:20px;
  position:relative;
  background:#ffffff;
  border:1px solid rgba(210,226,239,.5);
  overflow:hidden;
  padding:0;
}
.pc .ph img{
  width:100% !important;
  height:100% !important;
  object-fit:cover !important;
  object-position:center !important;
  padding:0 !important;
  border-radius:inherit;
  display:block;
}
.pc .chip{
  position:absolute;
  left:12px;
  top:12px;
  z-index:6;
  background:rgba(255,255,255,.92);
  backdrop-filter:blur(8px);
  color:var(--green);
  font-size:11px;
  font-weight:600;
  padding:5px 12px;
  border-radius:999px;
  border:1px solid rgba(210,226,239,.6);
}
.pc .b{
  text-align:left;
  align-items:stretch;
  padding:16px 8px 8px;
  gap:8px;
  display:flex;
  flex-direction:column;
  flex:1;
}
.pc h3{font-size:20px;line-height:1.2;color:var(--ink)}
.pc .s{font-size:13px;color:var(--mut)}
.pc .meta{display:flex;gap:6px;flex-wrap:wrap;margin-top:auto}
.pc .meta span{
  font-size:11px;
  background:var(--bg2);
  color:var(--ink);
  padding:4px 10px;
  border-radius:999px;
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
  transition:background .2s ease;
  text-decoration:none;
}
.btn-details:hover{background:#245a82}

/* Sistem Slaid Gambar Produk */
.prod-slider{position:relative;width:100%;height:100%;overflow:hidden;border-radius:inherit;background:#fff}
.prod-slides{position:relative;width:100%;height:100%;border-radius:inherit;overflow:hidden;background:#fff}
.prod-slide{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  opacity:0;
  transition:opacity .65s ease-in-out;
  padding:0;
  margin:0;
  overflow:hidden;
  border-radius:inherit;
  background:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
}
.prod-slide.active{opacity:1;pointer-events:auto}
.prod-slide img{
  width:100% !important;
  height:100% !important;
  object-fit:cover !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:inherit;
  display:block;
}
.ps-dots{position:absolute;bottom:10px;left:0;right:0;z-index:5;display:flex;justify-content:center;gap:6px}
.ps-dot{
  width:7px;
  height:7px;
  border-radius:50%;
  background:rgba(255,255,255,.75);
  cursor:pointer;
  transition:all .3s ease;
  box-shadow:0 1px 4px rgba(0,0,0,.4);
}
.ps-dot.active{background:var(--green);transform:scale(1.25)}

/* Ciri-ciri Aksesori */
.acc-features{
  display:grid;
  grid-template-columns:repeat(3, 1fr);
  gap:20px;
  margin-top:48px;
}
.acc-feat-card{
  background:var(--card);
  border:1px solid var(--line);
  border-radius:20px;
  padding:22px;
  display:flex;
  flex-direction:column;
  gap:6px;
}
.acc-feat-card small{
  font-size:11px;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:var(--gold);
}
.acc-feat-card h4{
  font-family:var(--serif);
  font-size:20px;
  color:var(--ink);
}
.acc-feat-card p{
  font-size:13px;
  color:var(--mut);
  line-height:1.55;
}

@media(max-width:900px){
  .acc-features{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .acc-features{grid-template-columns:1fr}
}
</style>

<section class="hero">
  <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1800&q=85" alt="Research Accessories" onerror="this.src='https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">Laboratory Supplies</span>
      <h1>Precision Reconstitution &amp; Dispensing</h1>
      <p>Individually sealed, sterile preparation sets and ultra-fine micro-syringes engineered for accurate analytical research.</p>
    </div>
  </div>
</section>

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Research Accessories</h1>
        <p>Laboratory-grade reconstitution kits, administration sets, and precision needles formulated for accurate laboratory measurement.</p>
      </div>
    </div>

    <div class="g4">
      <!-- 1. Injection Kit (ik1.webp & ik2.webp - RM15.00) -->
      <div class="card pc">
        <div class="ph">
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ik1.webp') }}" alt="Injection Kit 1" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ik2.webp') }}" alt="Injection Kit 2" onerror="this.src='https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlide(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlide(this, 1)"></span>
            </div>
          </div>
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Injection Kit</h3>
          <p class="s">Complete Reconstitution &amp; Administration Set</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM15.00</div>
          <div class="meta">
            <span style="font-weight:600">1 Set (10x Injections)</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ Route::has('accessory.show') ? route('accessory.show', 'injection-kit') : url('/accessory/injection-kit') }}">See Details</a>
        </div>
      </div>

      <!-- 2. Insulin Needle 1 ml (ins1.webp & ins2.webp - RM55.00) -->
      <div class="card pc">
        <div class="ph">
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ins1.webp') }}" alt="Insulin Needle 1" onerror="this.src='https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ins2.webp') }}" alt="Insulin Needle 2" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlide(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlide(this, 1)"></span>
            </div>
          </div>
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Insulin Needle 1 ml</h3>
          <p class="s">Ultra-Fine Precision Micro-Syringe (31G)</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM55.00</div>
          <div class="meta">
            <span style="font-weight:600">Box of 100 pcs</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ Route::has('accessory.show') ? route('accessory.show', 'insulin-needle-1ml') : url('/accessory/insulin-needle-1ml') }}">See Details</a>
        </div>
      </div>
    </div>

    <div class="acc-features">
      <div class="acc-feat-card">
        <small>Integrity</small>
        <h4>100% Sterile &amp; Sealed</h4>
        <p>Each unit is ethylene oxide sterilized and individually blister-packed to ensure zero bacterial contamination.</p>
      </div>
      <div class="acc-feat-card">
        <small>Measurement</small>
        <h4>Ultra-Fine 31G Precision</h4>
        <p>Designed with micro-beveled needle tips and crystal-clear barrel markings for minimal dead-volume fluid transfer.</p>
      </div>
      <div class="acc-feat-card">
        <small>Compliance</small>
        <h4>Laboratory Grade</h4>
        <p>Fully compatible with standard bacteriostatic water solutions, reconstitution solvents, and laboratory protocols.</p>
      </div>
    </div>

    <p style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:36px;padding-top:16px">
      All research accessories are individually sealed, sterile, and intended strictly for laboratory and peptide preparation assays.
    </p>
  </div>
</section>

<script>
function setCardSlide(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const slider = dot.closest('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = slider.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

let prodSlideTimer;
function startProdAutoSlide(){
  clearInterval(prodSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  prodSlideTimer = setInterval(() => {
    document.querySelectorAll('.card .prod-slider').forEach(box => {
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

document.addEventListener('DOMContentLoaded', () => {
  startProdAutoSlide();
});
</script>
@endsection