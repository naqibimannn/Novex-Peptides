@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="Quality Control &amp; HPLC Lab Testing | Novex Peptides"
    description="Explore third-party laboratory COA reports, HPLC purity assays exceeding 99%, mass spectrometry identity confirmation, and scientific peptide glossaries."
    :canonical="route('science')"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Novex Peptides Science & Quality Control',
        'url' => route('science'),
        'description' => 'Explore third-party laboratory COA reports, HPLC purity assays exceeding 99%, mass spectrometry identity confirmation, and scientific peptide glossaries.',
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/')
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Science & Quality Control',
                    'item' => route('science')
                ]
            ]
        ]
    ]"
/>
@endsection

@section('content')
@php
  $lab1Path = 'assets/website/science/lab1.webp';
  $lab2Path = 'assets/website/science/lab2.webp';
  $lab3Path = 'assets/website/science/lab3.webp';

  $lab1Ver = file_exists(public_path($lab1Path)) ? filemtime(public_path($lab1Path)) : time();
  $lab2Ver = file_exists(public_path($lab2Path)) ? filemtime(public_path($lab2Path)) : time();
  $lab3Ver = file_exists(public_path($lab3Path)) ? filemtime(public_path($lab3Path)) : time();

  $lab1Url = asset($lab1Path) . '?v=' . $lab1Ver;
  $lab2Url = asset($lab2Path) . '?v=' . $lab2Ver;
  $lab3Url = asset($lab3Path) . '?v=' . $lab3Ver;

  $sciCssPath = 'frontend/science/science.css';
  $sciCssVer = file_exists(public_path($sciCssPath)) ? filemtime(public_path($sciCssPath)) : time();

  $sciJsPath = 'frontend/science/science.js';
  $sciJsVer = file_exists(public_path($sciJsPath)) ? filemtime(public_path($sciJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($sciCssPath) }}?v={{ $sciCssVer }}">

<section class="science-hero">
  <img id="heroImage" 
       src="{{ asset('assets/website/science/hero.webp') }}" 
       data-desktop="{{ asset('assets/website/science/hero.webp') }}" 
       data-phone="{{ asset('assets/website/science/hero-phone.webp') }}" 
       alt="Science and Quality Control Laboratory" 
       width="1800"
       height="700"
       onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span class="eyebrow">The lab notebook</span>
      <h1>Science today.<br>A healthier tomorrow.</h1>
      <p>Plain-language notes on the compounds we supply and the analytical tests that stand behind them.</p>
    </div>
  </div>
</section>

<section class="sec" id="science-reports">
  <div class="wrap">
    <div class="head">
      <div>
        <h2 class="sec-title">Our Science &amp; Quality Control</h2>
        <p class="sec-desc">Complete laboratory analytical reports (COA), HPLC purity assays, and strict mass spectrometry identification.</p>
      </div>
    </div>

    <div class="lab-grid">
      <div class="lab-item">
        <a href="{{ $lab1Url }}" class="lab-img-wrap" target="_blank" rel="noopener noreferrer">
          <img src="{{ $lab1Url }}" alt="Janoshik Test Report Retatrutide 10 MG" width="800" height="1100" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </a>
        <div class="lab-meta">
          <span class="lab-meta-tag">Purity: 99.795% • Task #123459</span>
          <h3>Retatrutide 10 MG (Batch NXP-RT-001)</h3>
          <p>Independent Janoshik analytical test report conducted on 23 Mar 2026 verifying 10.60 mg active Retatrutide content and 99.795% purity (Unique Key: KSISHJQFL7NX).</p>
        </div>
      </div>

      <div class="lab-item">
        <a href="{{ $lab2Url }}" class="lab-img-wrap" target="_blank" rel="noopener noreferrer">
          <img src="{{ $lab2Url }}" alt="Janoshik Test Report GHK-Cu Copper Peptide" width="800" height="1100" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </a>
        <div class="lab-meta">
          <span class="lab-meta-tag">Purity: 99.717% • Task #122238</span>
          <h3>GHK-Cu (Copper Peptide)</h3>
          <p>Independent Janoshik double-tested analysis conducted on 24 Mar 2026 confirming 71.39 mg GHK-Cu content and 99.717% purity (Unique Key: DTPDDS2WWWAH).</p>
        </div>
      </div>

      <div class="lab-item">
        <a href="{{ $lab3Url }}" class="lab-img-wrap" target="_blank" rel="noopener noreferrer">
          <img src="{{ $lab3Url }}" alt="Certificate of Analysis VYREX5 (Batch VXR051024A)" width="800" height="1100" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1000&q=85'">
          <div class="lab-badge">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </a>
        <div class="lab-meta">
          <span class="lab-meta-tag">Purity: 99.821% • Batch #VXR051024A</span>
          <h3>VYREX⁵ — Research Peptide Blend</h3>
          <p>Analytical laboratory Certificate of Analysis issued by Novex Peptides USA on 03 Oct 2025, confirming 99.821% RP-HPLC purity, 10.02 mg active peptide content, and LC-MS molecular confirmation [M+H]⁺ at 1687.4.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec alt">
  <div class="wrap">
    <div class="head">
      <div>
        <h2 class="sec-title">How a batch is tested</h2>
        <p class="sec-desc">Three questions, three analytical methods. Together they verify exactly what is sealed in the vial.</p>
      </div>
    </div>
    <div class="science-rows">
      <div class="science-row-card">
        <b>I</b>
        <h3>Identity</h3>
        <p>Mass spectrometry confirms the molecular weight matches the intended peptide chemical formula.</p>
      </div>
      <div class="science-row-card">
        <b>II</b>
        <h3>Purity</h3>
        <p>High-performance liquid chromatography (HPLC) separates the sample components and certifies purity levels exceed 99%.</p>
      </div>
      <div class="science-row-card">
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
        <h2 class="sec-title">Scientific Glossary</h2>
        <p class="sec-desc">Essential terminology explaining peptide chemistry, manufacturing standards, and cold-chain integrity.</p>
      </div>
    </div>
    <div class="glossary-grid">
      <div class="glossary-card">
        <b>Lyophilised</b>
        <p>Freeze-dried into a stable powder cake under vacuum, keeping the peptide molecular structure intact far longer than liquid solutions.</p>
      </div>
      <div class="glossary-card">
        <b>HPLC</b>
        <p>High-performance liquid chromatography, the international laboratory analytical standard for resolving and measuring peptide purity.</p>
      </div>
      <div class="glossary-card">
        <b>Agonist</b>
        <p>A biological ligand that activates a specific cellular receptor. Retatrutide, for instance, operates as a triple-receptor agonist.</p>
      </div>
      <div class="glossary-card">
        <b>cGMP</b>
        <p>Current Good Manufacturing Practice, an internationally audited regulatory framework for consistent, documented pharmaceutical production.</p>
      </div>
      <div class="glossary-card">
        <b>COA</b>
        <p>Certificate of Analysis, the official laboratory document reporting analytical test results, lot numbers, and compound assays for a specific batch.</p>
      </div>
      <div class="glossary-card">
        <b>Cold Chain</b>
        <p>An unbroken, temperature-monitored logistics protocol from laboratory cryo-storage to final delivery to prevent thermal degradation.</p>
      </div>
    </div>
  </div>
</section>

<script>
window.NVX_SCIENCE = {
  heroPhone: '{{ asset("assets/website/science/hero-phone.webp") }}',
  heroDesktop: '{{ asset("assets/website/science/hero.webp") }}'
};
</script>
<script src="{{ asset($sciJsPath) }}?v={{ $sciJsVer }}"></script>
@endsection