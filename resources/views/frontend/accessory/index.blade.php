@extends('frontend.home.index')

@section('content')
<style>
.acc-features{
  display:grid;
  grid-template-columns:repeat(3, 1fr);
  gap:20px;
  margin-top:40px;
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
      <div class="card pc">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600" alt="Injection Kit" style="object-fit:contain;padding:12px">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Injection Kit</h3>
          <p class="s">Complete Reconstitution &amp; Administration Set</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM35.00</div>
          <div class="meta" style="margin-top:auto">
            <span style="font-weight:600">Standard Set</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('products.show', 'injection-kit') }}">See Details</a>
        </div>
      </div>

      <div class="card pc">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600" alt="Insulin Needle 1 ml" style="object-fit:contain;padding:12px">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Insulin Needle 1 ml</h3>
          <p class="s">Ultra-Fine Precision Micro-Syringe (31G)</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM25.00</div>
          <div class="meta" style="margin-top:auto">
            <span style="font-weight:600">Box of 10 pcs</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('products.show', 'insulin-needle-1ml') }}">See Details</a>
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
@endsection