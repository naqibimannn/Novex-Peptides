@extends('frontend.home.index')

@section('content')
<style>
.rows>div{
  background:var(--card);
  border-radius:24px;
  padding:24px 28px;
  margin-bottom:12px;
  display:grid;
  grid-template-columns:80px 1fr 1.5fr;
  gap:24px;
  align-items:baseline;
}
.rows b{font:italic 500 30px var(--serif);color:var(--gold)}
.rows p{color:#3A4D5E}

.gl{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.gl div{background:var(--card);border-radius:18px;padding:18px 20px}
.gl b{font:500 21px var(--serif);display:block;margin-bottom:4px;color:var(--ink)}
.gl p{font-size:13px;color:var(--mut);line-height:1.55}

@media(max-width:900px){
  .rows>div{grid-template-columns:50px 1fr}
  .rows p{grid-column:2}
}
@media(max-width:640px){
  .gl{grid-template-columns:1fr}
}
</style>

<section class="hero">
  <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=1800&q=85" alt="Science and Research" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">The lab notebook</span>
      <h1>Science today.<br>A healthier tomorrow.</h1>
      <p>Plain-language notes on the compounds we supply and the analytical tests that stand behind them.</p>
    </div>
  </div>
</section>

<section class="sec" id="science-reports">
  <div class="wrap">
    <div class="head">
      <div>
        <span class="lab-meta-tag">Analytical Verification Desk</span>
        <h1 style="font-size:clamp(34px,5vw,56px);margin-top:6px">Our Science &amp; Quality Control</h1>
        <p>Complete laboratory analytical reports (COA), HPLC purity assays, and strict mass spectrometry identification.</p>
      </div>
    </div>

    <div class="lab-grid" style="margin-bottom:60px">
      <div class="lab-item">
        <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab1.webp') }}', 'Science Page - HPLC Chromatography Analysis Certificate')">
          <img src="{{ asset('lab1.webp') }}" alt="HPLC Report 01" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta" style="margin-top:10px">
          <span class="lab-meta-tag">Certified Purity: &gt;99.2%</span>
          <h3 style="font-size:20px;margin-top:4px">HPLC Quantitative Assay #01</h3>
          <p style="font-size:13px;color:var(--mut)">Purity certified at &gt;99.2% single-peak resolution against reference standard markers with zero trace unreacted synthesis fragments.</p>
        </div>
      </div>

      <div class="lab-item">
        <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab2.webp') }}', 'Science Page - Mass Spectrometry Molecular Weight Verification')">
          <img src="{{ asset('lab2.webp') }}" alt="Mass Spec Report 02" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta" style="margin-top:10px">
          <span class="lab-meta-tag">Mass Spec • Sequence Confirmed</span>
          <h3 style="font-size:20px;margin-top:4px">ESI-MS Molecular Identity #02</h3>
          <p style="font-size:13px;color:var(--mut)">High-resolution electrospray ionisation mass spectrometry verifying theoretical molecular weight and exact amino acid peptide sequence fidelity.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec" style="padding-top:0">
  <div class="wrap">
    <div class="head">
      <div>
        <h2>How a batch is tested</h2>
        <p>Three questions, three analytical methods. Together they verify exactly what is sealed in the vial.</p>
      </div>
    </div>
    <div class="rows">
      <div>
        <b>I</b>
        <h3>Identity</h3>
        <p>Mass spectrometry confirms the molecular weight matches the intended peptide chemical formula.</p>
      </div>
      <div>
        <b>II</b>
        <h3>Purity</h3>
        <p>High-performance liquid chromatography (HPLC) separates the sample components and certifies purity levels exceed 99%.</p>
      </div>
      <div>
        <b>III</b>
        <h3>Content</h3>
        <p>Quantitative assay checks confirm that the active peptide mass stated on the label matches what the sealed vial holds.</p>
      </div>
    </div>
  </div>
</section>

<section class="sec alt">
  <div class="wrap">
    <div class="head">
      <div>
        <h2>Scientific Glossary</h2>
        <p>Essential terminology explaining peptide chemistry, manufacturing standards, and cold-chain integrity.</p>
      </div>
    </div>
    <div class="gl">
      <div>
        <b>Lyophilised</b>
        <p>Freeze-dried into a stable powder cake under vacuum, keeping the peptide molecular structure intact far longer than liquid solutions.</p>
      </div>
      <div>
        <b>HPLC</b>
        <p>High-performance liquid chromatography, the international laboratory analytical standard for resolving and measuring peptide purity.</p>
      </div>
      <div>
        <b>Agonist</b>
        <p>A biological ligand that activates a specific cellular receptor. Retatrutide, for instance, operates as a triple-receptor agonist.</p>
      </div>
      <div>
        <b>cGMP</b>
        <p>Current Good Manufacturing Practice, an internationally audited regulatory framework for consistent, documented pharmaceutical production.</p>
      </div>
      <div>
        <b>COA</b>
        <p>Certificate of Analysis, the official laboratory document reporting analytical test results, lot numbers, and compound assays for a specific batch.</p>
      </div>
      <div>
        <b>Cold Chain</b>
        <p>An unbroken, temperature-monitored logistics protocol from laboratory cryo-storage to final delivery to prevent thermal degradation.</p>
      </div>
    </div>
  </div>
</section>
@endsection