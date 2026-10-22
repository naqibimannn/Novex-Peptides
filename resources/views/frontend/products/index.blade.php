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
  border-radius:999px;
  margin-bottom:16px;
  font:inherit;
  outline:none;
  transition:border-color .2s ease;
}
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
</style>

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Shop Catalog</h1>
        <p>Select any product to view its batch specifications, dosage options, stock availability, and full profile.</p>
      </div>
    </div>

    <input id="q" class="sq" type="search" placeholder="Search products, serums or apparel..." oninput="filterProducts()">

    <div class="filter" id="flt">
      <button type="button" class="on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" onclick="setCategoryFilter('Weight Management', this)">Weight Management</button>
      <button type="button" onclick="setCategoryFilter('Skincare Peptides', this)">Skincare Peptides</button>
      <button type="button" onclick="setCategoryFilter('Skincare Collection', this)">Skincare Collection</button>
      <button type="button" onclick="setCategoryFilter('Performance', this)">Performance</button>
      <button type="button" onclick="setCategoryFilter('Apparel', this)">Apparel</button>
      <button type="button" onclick="setCategoryFilter('Accessory', this)">Accessory</button>
    </div>
    
    <div class="g4" id="pg">
      <div class="card pc" data-category="Weight Management" data-keywords="retatrutide advanced weight management 10mg 30mg 60mg 100mg">
        <div class="ph">
          <img src="{{ asset('reta1.webp') }}" alt="Retatrutide" style="object-fit:contain;padding:10px" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
          <span class="chip">Weight Management</span>
        </div>
        <div class="b">
          <h3>Retatrutide</h3>
          <p class="s">Advanced Weight Management</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM280.00 - RM980.00</div>
          <div class="meta"><span>10mg - 100mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'retatrutide') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Weight Management" data-keywords="retatrutide plus reta plus cagrilintide 40mg">
        <div class="ph">
          <img src="{{ asset('retaplus1.webp') }}" alt="Retatrutide Plus" style="object-fit:contain;padding:10px" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600'">
          <span class="chip">Weight Management</span>
        </div>
        <div class="b">
          <h3>Retatrutide Plus (RETA PLUS)</h3>
          <p class="s">Retatrutide + Cagrilintide</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM590.00</div>
          <div class="meta"><span>40mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'reta-plus') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Peptides" data-keywords="ghk-cu radiant skin cellular rejuvenation copper 100mg">
        <div class="ph">
          <img src="{{ asset('ghk1.webp') }}" alt="GHK-Cu" style="object-fit:contain;padding:10px" onerror="this.src='https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600'">
          <span class="chip">Skincare Peptides</span>
        </div>
        <div class="b">
          <h3>GHK-Cu</h3>
          <p class="s">Radiant Skin &amp; Cellular Rejuvenation</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM180.00</div>
          <div class="meta"><span>100mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'ghk-cu') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Peptides" data-keywords="nad+ radiant skin cellular rejuvenation coenzyme 500mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600" alt="NAD+">
          <span class="chip">Skincare Peptides</span>
        </div>
        <div class="b">
          <h3>NAD+</h3>
          <p class="s">Radiant Skin &amp; Cellular Rejuvenation</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM220.00</div>
          <div class="meta"><span>500mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'nad-plus') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Peptides" data-keywords="glutathione master antioxidant skin brightening 1500mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1556229010-6c3f2c9ca5f8?auto=format&fit=crop&w=600" alt="Glutathione">
          <span class="chip">Skincare Peptides</span>
        </div>
        <div class="b">
          <h3>Glutathione</h3>
          <p class="s">Radiant Skin &amp; Cellular Rejuvenation</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM150.00</div>
          <div class="meta"><span>1500mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'gluta') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Peptides" data-keywords="snap-8 octapeptide expression lines 10mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?auto=format&fit=crop&w=600" alt="SNAP-8">
          <span class="chip">Skincare Peptides</span>
        </div>
        <div class="b">
          <h3>SNAP-8</h3>
          <p class="s">Radiant Skin &amp; Cellular Rejuvenation</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM180.00</div>
          <div class="meta"><span>10mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'snap-8') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Performance" data-keywords="tesamorelin optimise performance longevity ghrh 5mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600" alt="Tesamorelin">
          <span class="chip">Performance</span>
        </div>
        <div class="b">
          <h3>Tesamorelin</h3>
          <p class="s">Optimise Performance &amp; Longevity</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM170.00</div>
          <div class="meta"><span>5mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'tesa') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Performance" data-keywords="aicar ampk endurance energy regulation 50mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600" alt="AICAR">
          <span class="chip">Performance</span>
        </div>
        <div class="b">
          <h3>AICAR</h3>
          <p class="s">Optimise Performance &amp; Longevity</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM220.00</div>
          <div class="meta"><span>50mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'aicar') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Performance" data-keywords="motsc mots-c mitochondrial peptide metabolic balance 20mg">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=600" alt="MOTS-C">
          <span class="chip">Performance</span>
        </div>
        <div class="b">
          <h3>MOTS-C</h3>
          <p class="s">Optimise Performance &amp; Longevity</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM180.00</div>
          <div class="meta"><span>20mg</span><span>Research grade</span></div>
          <a class="btn-details" href="{{ route('products.show', 'motsc') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Collection" data-keywords="glutaglow serum brightening skincare 10ml">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600" alt="GlutaGlow Serum">
          <span class="chip">Skincare Collection</span>
        </div>
        <div class="b">
          <h3>GlutaGlow Serum</h3>
          <p class="s">Advanced Skincare For A Brighter You</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM59.90</div>
          <div class="meta"><span>10ml</span><span>Novex Beauty</span></div>
          <a class="btn-details" href="{{ route('products.show', 'glutaglow-serum') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Collection" data-keywords="ghk-cu serum copper peptide restorative 30ml">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&fit=crop&w=600" alt="GHK-Cu Serum">
          <span class="chip">Skincare Collection</span>
        </div>
        <div class="b">
          <h3>GHK-Cu Serum</h3>
          <p class="s">Advanced Skincare For A Brighter You</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM79.90</div>
          <div class="meta"><span>30ml</span><span>Novex Beauty</span></div>
          <a class="btn-details" href="{{ route('products.show', 'ghk-cu-serum') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Skincare Collection" data-keywords="glutathione cream moisture antioxidant hydration">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600" alt="Glutathione Cream">
          <span class="chip">Skincare Collection</span>
        </div>
        <div class="b">
          <h3>Glutathione Cream</h3>
          <p class="s">Advanced Skincare For A Brighter You</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM39.90</div>
          <div class="meta"><span>Standard</span><span>Novex Beauty</span></div>
          <a class="btn-details" href="{{ route('products.show', 'glutathione-cream') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Apparel" data-keywords="premium athletic jersey apparel merchandise shirt adult size">
        <div class="ph">
          <img src="{{ asset('jry1.webp') }}" alt="Premium Athletic Jersey" style="object-fit:contain;padding:10px" onerror="this.src='https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=600'">
          <span class="chip">Apparel</span>
        </div>
        <div class="b">
          <h3>Premium Athletic Jersey</h3>
          <p class="s">Performance. Style. Everyday.</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM40.00</div>
          <div class="meta"><span>Adult Size</span><span>Merchandise</span></div>
          <a class="btn-details" href="{{ route('products.show', 'jersey-01') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Accessory" data-keywords="injection kit reconstitution administration sterile mixing barrels accessory">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600" alt="Injection Kit">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Injection Kit</h3>
          <p class="s">Complete Reconstitution &amp; Administration Set</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM35.00</div>
          <div class="meta"><span>Standard Set</span><span>Laboratory Item</span></div>
          <a class="btn-details" href="{{ route('products.show', 'injection-kit') }}">See Details</a>
        </div>
      </div>

      <div class="card pc" data-category="Accessory" data-keywords="insulin needle 1ml micro-syringe 31g precision laboratory accessory">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600" alt="Insulin Needle 1 ml">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Insulin Needle 1 ml</h3>
          <p class="s">Ultra-Fine Precision Micro-Syringe (31G)</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM25.00</div>
          <div class="meta"><span>Box of 10 pcs</span><span>Laboratory Item</span></div>
          <a class="btn-details" href="{{ route('products.show', 'insulin-needle-1ml') }}">See Details</a>
        </div>
      </div>
    </div>

    <div id="noMatchMsg" style="display:none;text-align:center;padding:48px 0;color:var(--mut)">
      <p style="font-size:16px">No products match your search or filter.</p>
    </div>

    <!-- Peringatan Kegunaan Makmal -->
    <p style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:36px;padding-top:16px">
      Research chemicals are sold for in-vitro and laboratory research use only. Topical serums, creams, and merchandise items are formulated for daily cosmetic and athletic use.
    </p>
  </div>
</section>

<script>
let activeCategory = 'All';

function setCategoryFilter(cat, btn){
  activeCategory = cat;
  document.querySelectorAll('#flt button').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  filterProducts();
}

function filterProducts(){
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