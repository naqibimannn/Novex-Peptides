@extends('frontend.home.index')

@section('content')
@php
  $lab1Ver = file_exists(public_path('lab1.webp')) ? filemtime(public_path('lab1.webp')) : time();
  $lab2Ver = file_exists(public_path('lab2.webp')) ? filemtime(public_path('lab2.webp')) : time();
  $lab1Url = asset('lab1.webp') . '?v=' . $lab1Ver;
  $lab2Url = asset('lab2.webp') . '?v=' . $lab2Ver;
@endphp

<section class="hero relative min-h-[480px] sm:min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
  <img id="heroImage" src="{{ asset('assets/website/science/hero.webp') }}" href="{{ asset('assets/website/science/hero.webp') }}" alt="Science and Research" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'" class="absolute inset-0 w-full h-full object-cover object-top filter saturate-[1.08] brightness-[1.05] block">
  <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="in max-w-[580px]">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block text-white">The lab notebook</span>
      <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Science today.<br>A healthier tomorrow.</h1>
      <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Plain-language notes on the compounds we supply and the analytical tests that stand behind them.</p>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200" id="science-reports">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
      <div>
        <h1 class="font-serif text-[clamp(34px,5vw,56px)] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] mt-1.5 leading-[1.15]">Our Science &amp; Quality Control</h1>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px] mt-1.5 leading-[1.6]">Complete laboratory analytical reports (COA), HPLC purity assays, and strict mass spectrometry identification.</p>
      </div>
    </div>

    <div class="lab-grid grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-7 min-[901px]:gap-10 max-w-[1060px] mx-auto mb-[60px] items-start">
      <div class="lab-item group flex flex-col gap-4 w-full max-w-[500px] max-sm:max-w-full mx-auto bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[20px] sm:rounded-[24px] p-3.5 sm:p-[18px] shadow-[0_10px_26px_rgba(14,40,66,0.06)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:shadow-[0_18px_36px_rgba(47,111,159,0.15)]">
        <div class="lab-img-wrap relative w-full aspect-[1/1.414] rounded-[16px] overflow-hidden cursor-pointer bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E]" onclick="openLightboxModal('{{ $lab1Url }}', 'Janoshik Test Report #123459 — Retatrutide 10 MG (Batch NXP-RT-001)')">
          <img src="{{ $lab1Url }}" alt="Janoshik Test Report Retatrutide 10 MG" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=85'" class="w-full h-full block object-contain object-center bg-transparent p-1">
          <div class="lab-badge absolute top-3 right-3 bg-[#142332]/[0.82] text-white text-[11px] font-semibold py-[5px] px-3 rounded-full backdrop-blur-[6px] flex items-center gap-[5px] z-[2] border border-white/20">
            <svg class="w-[13px] h-[13px] stroke-white fill-none stroke-[2.5] shrink-0" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta flex flex-col gap-1.5 pt-1 px-1 pb-0.5 text-left">
          <span class="lab-meta-tag inline-block text-[10px] font-bold uppercase tracking-[0.08em] text-[#2F6F9F] dark:text-[#327BB3] bg-[#E9F2FA] dark:bg-[#101B27] border border-[#D2E2EF] dark:border-[#1C2D3E] py-1 px-2.5 rounded-full w-fit">Purity: 99.795% • Task #123459</span>
          <h3 class="font-serif text-[22px] text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.25] transition-colors duration-200">Retatrutide 10 MG (Batch NXP-RT-001)</h3>
          <p class="text-[13.5px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6]">Independent Janoshik analytical test report conducted on 23 Mar 2026 verifying 10.60 mg active Retatrutide content and 99.795% purity (Unique Key: KSISHJQFL7NX).</p>
        </div>
      </div>

      <div class="lab-item group flex flex-col gap-4 w-full max-w-[500px] max-sm:max-w-full mx-auto bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[20px] sm:rounded-[24px] p-3.5 sm:p-[18px] shadow-[0_10px_26px_rgba(14,40,66,0.06)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:shadow-[0_18px_36px_rgba(47,111,159,0.15)]">
        <div class="lab-img-wrap relative w-full aspect-[1/1.414] rounded-[16px] overflow-hidden cursor-pointer bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E]" onclick="openLightboxModal('{{ $lab2Url }}', 'Janoshik Test Report #122238 — GHK-Cu (Copper Peptide)')">
          <img src="{{ $lab2Url }}" alt="Janoshik Test Report GHK-Cu Copper Peptide" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1000&q=85'" class="w-full h-full block object-contain object-center bg-transparent p-1">
          <div class="lab-badge absolute top-3 right-3 bg-[#142332]/[0.82] text-white text-[11px] font-semibold py-[5px] px-3 rounded-full backdrop-blur-[6px] flex items-center gap-[5px] z-[2] border border-white/20">
            <svg class="w-[13px] h-[13px] stroke-white fill-none stroke-[2.5] shrink-0" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Inspect High-Res Scan</span>
          </div>
        </div>
        <div class="lab-meta flex flex-col gap-1.5 pt-1 px-1 pb-0.5 text-left">
          <span class="lab-meta-tag inline-block text-[10px] font-bold uppercase tracking-[0.08em] text-[#2F6F9F] dark:text-[#327BB3] bg-[#E9F2FA] dark:bg-[#101B27] border border-[#D2E2EF] dark:border-[#1C2D3E] py-1 px-2.5 rounded-full w-fit">Purity: 99.717% • Task #122238</span>
          <h3 class="font-serif text-[22px] text-[#1E2D3B] dark:text-[#F0F6FC] leading-[1.25] transition-colors duration-200">GHK-Cu (Copper Peptide)</h3>
          <p class="text-[13.5px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6]">Independent Janoshik double-tested analysis conducted on 24 Mar 2026 confirming 71.39 mg GHK-Cu content and 99.717% purity (Unique Key: DTPDDS2WWWAH).</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec alt py-[54px] min-[901px]:py-20 bg-[#E9F2FA] dark:bg-[#101B27] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
      <div>
        <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">How a batch is tested</h2>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px] mt-1.5 leading-[1.6]">Three questions, three analytical methods. Together they verify exactly what is sealed in the vial.</p>
      </div>
    </div>
    <div class="rows space-y-3">
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">I</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Identity</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Mass spectrometry confirms the molecular weight matches the intended peptide chemical formula.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">II</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Purity</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">High-performance liquid chromatography (HPLC) separates the sample components and certifies purity levels exceed 99%.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] py-6 px-6 sm:px-7 grid grid-cols-[50px_1fr] min-[901px]:grid-cols-[80px_1fr_1.5fr] gap-6 items-baseline transition-colors duration-200">
        <b class="font-serif italic font-medium text-[30px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">III</b>
        <h3 class="font-serif text-[20px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Content</h3>
        <p class="max-[900px]:col-start-2 text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65] text-[15px]">Quantitative assay checks confirm that the active peptide mass stated on the label matches what the sealed vial holds.</p>
      </div>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
      <div>
        <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Scientific Glossary</h2>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px] mt-1.5 leading-[1.6]">Essential terminology explaining peptide chemistry, manufacturing standards, and cold-chain integrity.</p>
      </div>
    </div>
    <div class="gl grid grid-cols-1 sm:grid-cols-2 gap-3.5">
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">Lyophilised</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">Freeze-dried into a stable powder cake under vacuum, keeping the peptide molecular structure intact far longer than liquid solutions.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">HPLC</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">High-performance liquid chromatography, the international laboratory analytical standard for resolving and measuring peptide purity.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">Agonist</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">A biological ligand that activates a specific cellular receptor. Retatrutide, for instance, operates as a triple-receptor agonist.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">cGMP</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">Current Good Manufacturing Practice, an internationally audited regulatory framework for consistent, documented pharmaceutical production.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">COA</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">Certificate of Analysis, the official laboratory document reporting analytical test results, lot numbers, and compound assays for a specific batch.</p>
      </div>
      <div class="bg-[#F6FAFD] dark:bg-[#0E1824] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px] p-[18px_20px] transition-colors duration-200">
        <b class="font-serif font-medium text-[21px] block mb-1 text-[#1E2D3B] dark:text-[#F0F6FC]">Cold Chain</b>
        <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.55]">An unbroken, temperature-monitored logistics protocol from laboratory cryo-storage to final delivery to prevent thermal degradation.</p>
      </div>
    </div>
  </div>
</section>

<script>
function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/science/hero-phone.webp') }}"
    : "{{ asset('assets/website/science/hero.webp') }}";

  if (heroImg.getAttribute('src') !== targetUrl) {
    heroImg.setAttribute('src', targetUrl);
  }
  if (heroImg.getAttribute('href') !== targetUrl) {
    heroImg.setAttribute('href', targetUrl);
  }
}

const heroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (heroMediaQuery.addEventListener) {
  heroMediaQuery.addEventListener('change', updateHeroBanner);
} else if (heroMediaQuery.addListener) {
  heroMediaQuery.addListener(updateHeroBanner);
}
window.addEventListener('resize', updateHeroBanner);
document.addEventListener('DOMContentLoaded', updateHeroBanner);
updateHeroBanner();
</script>
@endsection