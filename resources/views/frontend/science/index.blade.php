@extends('frontend.home.index')

@section('content')
<section class="sec">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(34px,5vw,56px)">Our Science &amp; Quality Control</h1>
        <p>Complete laboratory analytical reports (COA), HPLC purity assays, and strict mass spectrometry identification.</p>
      </div>
    </div>

    <div class="lab-grid" style="margin-bottom:60px">
      <div class="lab-item">
        <div class="lab-img-wrap">
          <img src="{{ asset('lab1.webp') }}" alt="HPLC Report 01" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600'">
        </div>
        <div style="margin-top:10px">
          <h3>HPLC Quantitative Assay #01</h3>
          <p style="font-size:13px;color:var(--mut)">Purity certified at >99.2% single-peak resolution.</p>
        </div>
      </div>

      <div class="lab-item">
        <div class="lab-img-wrap">
          <img src="{{ asset('lab2.webp') }}" alt="Mass Spec Report 02" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=600'">
        </div>
        <div style="margin-top:10px">
          <h3>ESI-MS Molecular Identity #02</h3>
          <p style="font-size:13px;color:var(--mut)">Exact amino acid sequence and theoretical molecular weight match.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection