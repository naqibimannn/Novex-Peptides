@extends('frontend.home.index')

@section('content')
<style>
.sq{
  display:block;
  width:100%;
  max-width:380px;
  padding:12px 18px;
  border:1px solid var(--line);
  background:var(--card);
  color:var(--ink);
  border-radius:999px;
  margin-bottom:16px;
  font:inherit;
  outline:none;
  transition:border-color .2s ease, background-color .25s ease, color .25s ease;
}
.sq::placeholder{color:var(--mut)}
.sq:focus{border-color:var(--green)}
.filter{
  display:flex;
  gap:8px;
  flex-wrap:wrap;
  margin-bottom:32px;
  font-size:13px;
}
.filter button{
  background:none;
  border:1px solid var(--line);
  padding:8px 18px;
  color:var(--ink);
  border-radius:999px;
  cursor:pointer;
  font-weight:500;
  transition:all .2s ease;
}
.filter button:hover{background:var(--bg2);border-color:var(--gold)}
.filter button.on{
  background:var(--green);
  color:#fff;
  border-color:var(--green);
}

.pc .ph{
  aspect-ratio:4/5;
  border-radius:20px;
  position:relative;
  background:var(--card-surface);
  border:1px solid var(--line);
  overflow:hidden;
  padding:10px;
  display:flex;
  align-items:center;
  justify-content:center;
}
.pc .ph img{
  max-width:100% !important;
  max-height:100% !important;
  width:auto !important;
  height:auto !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:12px !important;
  display:block;
  background:transparent;
}
.prod-slider{position:relative;width:100%;height:100%;overflow:hidden;border-radius:12px;background:var(--card-surface)}
.prod-slides{position:relative;width:100%;height:100%;border-radius:inherit;overflow:hidden;background:var(--card-surface)}
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
  background:var(--card-surface);
  display:flex;
  align-items:center;
  justify-content:center;
}
.prod-slide.active{opacity:1;pointer-events:auto}
.prod-slide img{
  max-width:100% !important;
  max-height:100% !important;
  width:auto !important;
  height:auto !important;
  object-fit:contain !important;
  object-position:center !important;
  padding:0 !important;
  margin:0 !important;
  border-radius:12px !important;
  display:block;
  background:transparent;
}
.ps-dots{position:absolute;bottom:6px;left:0;right:0;z-index:5;display:flex;justify-content:center;gap:6px}
.ps-dot{width:7px;height:7px;border-radius:50%;background:rgba(255,255,255,.75);cursor:pointer;transition:all .3s ease;box-shadow:0 1px 4px rgba(0,0,0,.4)}
.ps-dot.active{background:var(--green);transform:scale(1.25)}
</style>

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Accessories</h1>
        <p>Laboratory-grade reconstitution kits, administration sets, and precision needles formulated for accurate laboratory measurement.</p>
      </div>
    </div>

    <input id="q" class="sq" type="search" placeholder="Search accessories, needles or kits..." oninput="filterAccessories()">

    <div class="filter" id="flt">
      <button type="button" class="on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" onclick="setCategoryFilter('Injection Kit', this)">Reconstitution Sets</button>
      <button type="button" onclick="setCategoryFilter('Syringes', this)">Precision Syringes</button>
    </div>
    
    <div class="g4" id="pg">
      <div class="card pc" data-category="Injection Kit" data-keywords="injection kit reconstitution administration set syringe 1ml alcohol swab 10x injections rm15">
        <div class="ph">
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ik1.webp') }}" alt="Injection Kit 1" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ik2.webp') }}" alt="Injection Kit 2" onerror="this.src='https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
        </div>
        <div class="b">
          <h3>Injection Kit</h3>
          <p class="s">Complete Reconstitution &amp; Administration Set</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM15.00</div>
          <div class="meta">
            <span style="font-weight:600">1 Set (10x Injections)</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('accessory.show', 'injection-kit') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Syringes" data-keywords="insulin needle 1ml disposable syringe 31g micro-syringe 100 pcs box rm55">
        <div class="ph">
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ins1.webp') }}" alt="Insulin Needle 1" onerror="this.src='https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ins2.webp') }}" alt="Insulin Needle 2" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
        </div>
        <div class="b">
          <h3>Insulin Needle 1 ml</h3>
          <p class="s">Ultra-Fine Precision Micro-Syringe (31G)</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM55.00</div>
          <div class="meta">
            <span style="font-weight:600">Box of 100 pcs</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('accessory.show', 'insulin-needle-1ml') }}">See Details</a>
        </div>
      </div>
    </div>

    <div id="noMatchMsg" style="display:none;text-align:center;padding:48px 0;color:var(--mut)">
      <p style="font-size:16px">No accessories match your search or filter.</p>
    </div>

    <p style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:36px;padding-top:16px">
      All accessories are individually sealed, sterile, and intended strictly for laboratory and peptide preparation assays.
    </p>
  </div>
</section>

<script>
let activeCategory = 'All';

function setCategoryFilter(cat, btn){
  activeCategory = cat;
  document.querySelectorAll('#flt button').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  filterAccessories();
}

function setCardSlideCatalog(dot, idx){
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

function filterAccessories(){
  const query = (document.getElementById('q')?.value || '').trim().toLowerCase();
  const cards = document.querySelectorAll('#pg .card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cardCat = card.getAttribute('data-category');
    const cardKeywords = card.getAttribute('data-keywords') || '';
    const textContent = card.innerText.toLowerCase();

    const matchesCategory = (activeCategory === 'All') || (cardCat === activeCategory);
    const matchesSearch = !query || cardKeywords.includes(query) || textContent.includes(query);

    if(matchesCategory && matchesSearch){
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  const noMatch = document.getElementById('noMatchMsg');
  if(noMatch){
    noMatch.style.display = visibleCount === 0 ? 'block' : 'none';
  }
}
</script>
@endsection