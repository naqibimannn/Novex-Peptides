@extends('frontend.home.index')

@section('content')
<style>
.res-card{
  background:var(--card-surface);
  border:1px solid var(--line);
  border-radius:24px;
  overflow:hidden;
  display:flex;
  flex-direction:column;
  transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease, background-color .25s ease;
  cursor:pointer;
}
.res-card:hover{
  transform:translateY(-6px);
  box-shadow:0 24px 44px -20px rgba(47,111,159,.35);
  border-color:var(--gold);
}
.res-thumb{
  width:100%;
  aspect-ratio:16/10;
  overflow:hidden;
  background:var(--card-surface);
}
.res-thumb img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:transform .5s ease;
}
.res-card:hover .res-thumb img{
  transform:scale(1.04);
}
.res-body{
  padding:22px;
  display:flex;
  flex-direction:column;
  flex:1;
}
.res-body h3{
  color:var(--ink);
  transition:color .25s ease;
}

/* Modal Reader */
.modal-overlay{
  position:fixed;
  inset:0;
  background:rgba(10,17,26,.85);
  backdrop-filter:blur(6px);
  z-index:9999;
  display:none;
  align-items:center;
  justify-content:center;
  padding:20px;
}
.modal-overlay.open{display:flex}
.modal-content{
  background:var(--card-surface);
  border:1px solid var(--line);
  color:var(--ink);
  border-radius:24px;
  max-width:680px;
  width:100%;
  padding:32px;
  position:relative;
  box-shadow:0 25px 60px rgba(0,0,0,.45);
  max-height:90vh;
  overflow-y:auto;
  transition:background-color .25s ease, border-color .25s ease;
}
.modal-close{
  position:absolute;
  top:18px;
  right:18px;
  background:none;
  border:none;
  font-size:26px;
  color:var(--mut);
  cursor:pointer;
  line-height:1;
  transition:color .2s ease;
}
.modal-close:hover{color:var(--ink)}
</style>

<section class="hero">
  <img src="https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1800&q=85" alt="Educational Resources" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">Resources &amp; Literature</span>
      <h1>Read before you research</h1>
      <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:42px">Educational Resources</h1>
        <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
      </div>
    </div>
    
    <div class="g4">
      <article class="res-card" onclick="openResourceModal('retatrutide')">
        <div class="res-thumb">
          <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=700&q=85" alt="Understanding Retatrutide" loading="lazy">
        </div>
        <div class="res-body">
          <h3 style="font-size:20px;line-height:1.25">Understanding Retatrutide</h3>
          <p style="font-size:13px;color:var(--mut);margin:10px 0 16px;line-height:1.55">An investigational triple-receptor agonist (GIP, GLP-1, Glucagon) and what early research shows.</p>
          <span style="font-size:12px;font-weight:600;color:var(--green);margin-top:auto">Read Note →</span>
        </div>
      </article>

      <article class="res-card" onclick="openResourceModal('ghk-cu')">
        <div class="res-thumb">
          <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=700&q=85" alt="The Science of GHK-Cu" loading="lazy">
        </div>
        <div class="res-body">
          <h3 style="font-size:20px;line-height:1.25">The Science of GHK-Cu</h3>
          <p style="font-size:13px;color:var(--mut);margin:10px 0 16px;line-height:1.55">A naturally occurring copper peptide and its investigated role in tissue regeneration.</p>
          <span style="font-size:12px;font-weight:600;color:var(--green);margin-top:auto">Read Note →</span>
        </div>
      </article>

      <article class="res-card" onclick="openResourceModal('nad')">
        <div class="res-thumb">
          <img src="https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=700&q=85" alt="Benefits of NAD+" loading="lazy">
        </div>
        <div class="res-body">
          <h3 style="font-size:20px;line-height:1.25">Benefits of NAD+</h3>
          <p style="font-size:13px;color:var(--mut);margin:10px 0 16px;line-height:1.55">Why this coenzyme sits at the centre of cellular longevity and mitochondrial research.</p>
          <span style="font-size:12px;font-weight:600;color:var(--green);margin-top:auto">Read Note →</span>
        </div>
      </article>

      <article class="res-card" onclick="openResourceModal('tesamorelin')">
        <div class="res-thumb">
          <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700&q=85" alt="What is Tesamorelin" loading="lazy">
        </div>
        <div class="res-body">
          <h3 style="font-size:20px;line-height:1.25">What is Tesamorelin</h3>
          <p style="font-size:13px;color:var(--mut);margin:10px 0 16px;line-height:1.55">A synthetic peptide studied for metabolic pathway regulation and growth hormone release.</p>
          <span style="font-size:12px;font-weight:600;color:var(--green);margin-top:auto">Read Note →</span>
        </div>
      </article>
    </div>

    <div style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:40px;padding-top:16px">
      Educational content for research context only. It is not medical advice, diagnosis, or clinical recommendation.
    </div>
  </div>
</section>

<div class="modal-overlay" id="resourceModal" onclick="if(event.target===this)closeResourceModal()">
  <div class="modal-content">
    <button type="button" class="modal-close" onclick="closeResourceModal()" aria-label="Close">&times;</button>
    <div id="modalBody">
    </div>
  </div>
</div>

<script>
const articlesData = {
  'retatrutide': {
    title: 'Understanding Retatrutide',
    sub: 'An investigational triple-receptor agonist and what early research shows.',
    img: 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=900&q=85',
    paragraphs: [
      'Retatrutide is an investigational peptide designed to act on three receptors simultaneously: GIP, GLP-1, and glucagon. This triple mechanism is what distinguishes it from earlier single and dual receptor agonists.',
      'It has been studied in clinical trials run by its originator, and it is not an approved medicine. Published trial data are early and should be evaluated with laboratory analytical scrutiny.',
      'At Novex Peptides, retatrutide is supplied strictly as a high-purity research-grade compound for laboratory use, verified with third-party analytical testing on every production lot.'
    ]
  },
  'ghk-cu': {
    title: 'The Science of GHK-Cu',
    sub: 'A naturally occurring copper peptide and its role in skin biology research.',
    img: 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=900&q=85',
    paragraphs: [
      'GHK-Cu is a small tripeptide with high affinity for copper(II) ions. It occurs naturally in human plasma and saliva, with biological concentrations documented to decline as age advances.',
      'Laboratory studies have examined its biochemical modulation in collagen synthesis, dermal wound repair, fibroblasts, and tissue remodelling pathways.',
      'It is widely utilized in scientific cosmetic formulation assays, which is why it appears in our dedicated skincare range as well as the analytical research catalogue.'
    ]
  },
  'nad': {
    title: 'Benefits of NAD+',
    sub: 'Why this coenzyme sits at the centre of cellular energy research.',
    img: 'https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=900&q=85',
    paragraphs: [
      'NAD+ (Nicotinamide Adenine Dinucleotide) is an indispensable coenzyme found in all living cells. It mediates critical electron transfer reactions in oxidative phosphorylation and fuels sirtuin enzymatic activity.',
      'Extensive research indicates cellular NAD+ availability declines significantly over time, making it a pivotal subject of investigation in mitochondrial integrity and cellular longevity models.',
      'Scientific protocols on bioavailability and cellular uptake remain an evolving field of study, and our NAD+ is provided strictly for laboratory research evaluation.'
    ]
  },
  'tesamorelin': {
    title: 'What is Tesamorelin',
    sub: 'A synthetic peptide studied for metabolic optimisation and longevity.',
    img: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=900&q=85',
    paragraphs: [
      'Tesamorelin is a synthetic analogue of Growth Hormone-Releasing Factor (GRF). It acts selectively on pituitary somatotrophs to stimulate endogenous growth hormone synthesis and pulsatile release.',
      'It has been widely investigated in controlled clinical literature for adipose tissue metabolism, body composition profiling, and hepatic lipid regulation.',
      'Novex Peptides delivers tesamorelin in pure lyophilised format with third-party Certificate of Analysis verification for precise in-vitro and laboratory assays.'
    ]
  }
};

function openResourceModal(articleKey){
  const art = articlesData[articleKey];
  if(!art) return;

  const bodyEl = document.getElementById('modalBody');
  bodyEl.innerHTML = `
    <div style="aspect-ratio:16/9;border-radius:16px;overflow:hidden;margin-bottom:18px;border:1px solid var(--line)">
      <img src="${art.img}" alt="${art.title}" style="width:100%;height:100%;object-fit:cover">
    </div>
    <span style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--green);background:var(--bg2);padding:4px 10px;border-radius:999px;display:inline-block;margin-bottom:8px;border:1px solid var(--line)">Research Note</span>
    <h2 style="font-size:clamp(22px,3vw,30px);line-height:1.2;margin-bottom:6px;color:var(--ink)">${art.title}</h2>
    <p style="font-size:14px;color:var(--mut);margin-bottom:18px;font-style:italic">${art.sub}</p>
    <div style="display:flex;flex-direction:column;gap:12px;font-size:14px;line-height:1.7;color:var(--ink);border-top:1px solid var(--line);padding-top:16px">
      ${art.paragraphs.map(p => `<p>${p}</p>`).join('')}
    </div>
    <div style="font-size:11px;color:var(--mut);border-top:1px solid var(--line);margin-top:20px;padding-top:12px">
      Educational content for research context only. Not medical advice.
    </div>
  `;

  document.getElementById('resourceModal').classList.add('open');
}

function closeResourceModal(){
  document.getElementById('resourceModal').classList.remove('open');
}
</script>
@endsection