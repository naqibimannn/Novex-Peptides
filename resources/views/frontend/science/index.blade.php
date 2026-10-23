@extends('frontend.home.index')

@section('content')
<style>
.lab-meta-tag{
  display:inline-block;
  font-size:10px;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.08em;
  color:var(--green);
  background:rgba(47,111,159,.12);
  padding:4px 10px;
  border-radius:999px;
  width:fit-content;
}
.lab-grid{
  display:grid;
  grid-template-columns:repeat(2, 1fr);
  gap:40px;
  max-width:1060px;
  margin:0 auto 60px;
  align-items:start;
}
.lab-item{
  display:flex;
  flex-direction:column;
  gap:16px;
  width:100%;
  max-width:500px;
  margin:0 auto;
  background:#fff;
  border:1px solid var(--line);
  border-radius:24px;
  padding:18px;
  box-shadow:0 10px 26px rgba(14,40,66,.06);
  transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease;
}
.lab-item:hover{
  transform:translateY(-5px);
  border-color:var(--gold);
  box-shadow:0 18px 36px rgba(47,111,159,.15);
}
.lab-img-wrap{
  position:relative;
  width:100%;
  aspect-ratio:1 / 1.414;
  border-radius:16px;
  overflow:hidden;
  cursor:pointer;
  background:#ffffff;
  border:1px solid rgba(210,226,239,.85);
}
.lab-img-wrap img{
  width:100% !important;
  height:100% !important;
  display:block;
  object-fit:contain !important;
  object-position:center !important;
  background:#ffffff;
  padding:4px;
}
.lab-badge{
  position:absolute;
  top:12px;
  right:12px;
  background:rgba(30,45,59,.88);
  color:#fff;
  font-size:11px;
  font-weight:600;
  padding:5px 12px;
  border-radius:999px;
  backdrop-filter:blur(6px);
  display:flex;
  align-items:center;
  gap:5px;
  z-index:2;
}
.lab-badge svg{
  width:13px;
  height:13px;
  stroke:#fff;
  flex-shrink:0;
}
.lab-meta{
  display:flex;
  flex-direction:column;
  gap:6px;
  padding:4px 4px 2px;
  text-align:left;
}
.lab-meta h3{
  font-size:22px;
  color:var(--ink);
  line-height:1.25;
}
.lab-meta p{
  font-size:13.5px;
  color:var(--mut);
  line-height:1.6;
}

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
  .lab-grid{gap:28px;max-width:100%}
}
@media(max-width:640px){
  .gl{grid-template-columns:1fr}
  .lab-grid{grid-template-columns:1fr;gap:20px}
  .lab-item{padding:14px;border-radius:20px;max-width:100%}
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
        <h1 style="font-size:clamp(34px,5vw,56px);margin-top:6px">Our Science &amp; Quality Control</h1>
        <p>Complete laboratory analytical reports (COA), HPLC purity assays, and strict mass spectrometry identification.</p>
      </div>
    </div>

    <div class="lab-grid">
      <div class="lab-item">
        <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab1.webp') }}', 'Janoshik Test Report #123459 — Retatrutide 10 MG (Batch NXP-RT-001)')">
          <img src="{{ asset('lab1.webp') }}" alt="Janoshik Test Report Retatrutide 10 MG" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta">
          <span class="lab-meta-tag">Purity: 99.795% • Task #123459</span>
          <h3>Retatrutide 10 MG (Batch NXP-RT-001)</h3>
          <p>Independent Janoshik analytical test report conducted on 23 Mar 2026 verifying 10.60 mg active Retatrutide content and 99.795% purity (Unique Key: KSISHJQFL7NX).</p>
        </div>
      </div>

      <div class="lab-item">
        <div class="lab-img-wrap" onclick="openLightboxModal('{{ asset('lab2.webp') }}', 'Janoshik Test Report #122238 — GHK-Cu (Copper Peptide)')">
          <img src="{{ asset('lab2.webp') }}" alt="Janoshik Test Report GHK-Cu Copper Peptide" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta">
          <span class="lab-meta-tag">Purity: 99.717% • Task #122238</span>
          <h3>GHK-Cu (Copper Peptide)</h3>
          <p>Independent Janoshik double-tested analysis conducted on 24 Mar 2026 confirming 71.39 mg GHK-Cu content and 99.717% purity (Unique Key: DTPDDS2WWWAH).</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec alt" style="padding-top:0">
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

<section class="sec">
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