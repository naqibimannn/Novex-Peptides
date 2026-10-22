@extends('frontend.home.index')

@section('content')
<style>
.rows>div{background:var(--card);border-radius:24px;padding:24px 28px;margin-bottom:12px;display:grid;grid-template-columns:80px 1fr 1.5fr;gap:24px;align-items:baseline}
.rows b{font:italic 500 30px var(--serif);color:var(--gold)}
.rows p{color:#3A4D5E}
.pull{font:italic 500 clamp(24px,3.6vw,44px)/1.25 var(--serif);max-width:900px;margin:auto;text-align:center}
.pull small{display:block;font:600 11px var(--sans);letter-spacing:.24em;text-transform:uppercase;color:var(--gold);margin-top:20px}
@media(max-width:900px){
  .rows>div{grid-template-columns:50px 1fr}
  .rows p{grid-column:2}
}
</style>

<section class="hero">
  <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1800&q=85" alt="Our story">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">Our story</span>
      <h1>One question behind every vial</h1>
      <p>Is it really what the label says? Novex was built to answer that clearly, with paper to back it up.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap g2">
    <div>
      <h1 style="font-size:42px;margin-bottom:16px">Why Novex Exists</h1>
      <p style="color:var(--mut);line-height:1.7;margin-bottom:14px">Researchers buying peptides online kept running into the same problem: a certificate that could not be matched to the vial in their hand.</p>
      <p style="color:var(--mut);line-height:1.7">We started Novex as a sourcing desk that treats the batch number as the centre of everything.</p>
      <p style="margin-top:14px;color:#3A4D5E">If we cannot test it, trace it and explain it in plain language, it does not go into our catalog.</p>
    </div>
    <div style="aspect-ratio:4/3;border-radius:24px;overflow:hidden">
      <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800" alt="About Lab">
    </div>
  </div>
</section>

<section class="sec alt">
  <div class="wrap">
    <div class="head">
      <div>
        <h2>How we work</h2>
        <p>Four habits that shape what we stock and how we ship it.</p>
      </div>
    </div>
    <div class="rows">
      <div>
        <b>01</b>
        <h3>Source narrowly</h3>
        <p>Each compound addition needs published literature and a supplier we can audit.</p>
      </div>
      <div>
        <b>02</b>
        <h3>Test outside</h3>
        <p>Purity results come from a third-party laboratory and are tied to the lot printed on your vial.</p>
      </div>
      <div>
        <b>03</b>
        <h3>Keep it cold</h3>
        <p>Storage and shipping are designed around temperature stability, using insulated packaging.</p>
      </div>
      <div>
        <b>04</b>
        <h3>Explain plainly</h3>
        <p>Clear, direct communication regarding purity, research focus, and handling protocols.</p>
      </div>
    </div>
  </div>
</section>

<section class="sec" style="background:var(--bg2)">
  <div class="wrap">
    <p class="pull">
      “A good certificate is one you can match to the vial in your hand.”
      <small>THE NOVEX PRINCIPLE</small>
    </p>
  </div>
</section>
@endsection