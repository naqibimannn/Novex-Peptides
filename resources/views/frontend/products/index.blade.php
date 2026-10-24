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

.pc .ph{
  aspect-ratio:4/5;
  border-radius:20px;
  position:relative;
  background:#ffffff;
  border:1px solid rgba(210,226,239,.5);
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
.prod-slider{position:relative;width:100%;height:100%;overflow:hidden;border-radius:12px;background:#fff}
.prod-slides{position:relative;width:100%;height:100%;border-radius:inherit;overflow:hidden;background:#fff}
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
  background:#fff;
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('reta1.webp') }}" alt="Retatrutide 1" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('reta2.webp') }}" alt="Retatrutide 2" onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('reta3.webp') }}" alt="Retatrutide 3" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('reta4.webp') }}" alt="Retatrutide 4" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('reta5.webp') }}" alt="Retatrutide 5" onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 2)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 3)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 4)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('retaplus1.webp') }}" alt="Retatrutide Plus 1" onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('retaplus2.webp') }}" alt="Retatrutide Plus 2" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ghk1.webp') }}" alt="GHK-Cu 1" onerror="this.src='https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ghk2.webp') }}" alt="GHK-Cu 2" onerror="this.src='https://images.unsplash.com/photo-1512290903672-9b222956cf5a?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('nad1.webp') }}" alt="NAD+ 1" onerror="this.src='https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('nad2.webp') }}" alt="NAD+ 2" onerror="this.src='https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('glu1.webp') }}" alt="Glutathione 1" onerror="this.src='https://images.unsplash.com/photo-1556229010-6c3f2c9ca5f8?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('glu2.webp') }}" alt="Glutathione 2" onerror="this.src='https://images.unsplash.com/photo-1512290903672-9b222956cf5a?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('snap1.webp') }}" alt="SNAP-8 1" onerror="this.src='https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('snap2.webp') }}" alt="SNAP-8 2" onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('tesa1.webp') }}" alt="Tesamorelin 1" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('tesa2.webp') }}" alt="Tesamorelin 2" onerror="this.src='https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('aicar1.webp') }}" alt="AICAR 1" onerror="this.src='https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('aicar2.webp') }}" alt="AICAR 2" onerror="this.src='https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('mot1.webp') }}" alt="MOTS-C 1" onerror="this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('mot2.webp') }}" alt="MOTS-C 2" onerror="this.src='https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('gluta1.webp') }}" alt="GlutaGlow Serum 1" onerror="this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('gluta2.webp') }}" alt="GlutaGlow Serum 2" onerror="this.src='https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('gluta3.webp') }}" alt="GlutaGlow Serum 3" onerror="this.src='https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('gluta4.webp') }}" alt="GlutaGlow Serum 4" onerror="this.src='https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 2)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 3)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('ghks1.webp') }}" alt="GHK-Cu Serum 1" onerror="this.src='https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ghks2.webp') }}" alt="GHK-Cu Serum 2" onerror="this.src='https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ghks3.webp') }}" alt="GHK-Cu Serum 3" onerror="this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('ghks4.webp') }}" alt="GHK-Cu Serum 4" onerror="this.src='https://images.unsplash.com/photo-1512290903672-9b222956cf5a?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 2)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 3)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('glc1.webp') }}" alt="Glutathione Cream 1" onerror="this.src='https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('glc2.webp') }}" alt="Glutathione Cream 2" onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('glc3.webp') }}" alt="Glutathione Cream 3" onerror="this.src='https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('glc4.webp') }}" alt="Glutathione Cream 4" onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 2)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 3)"></span>
            </div>
          </div>
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
          <div class="prod-slider">
            <div class="prod-slides">
              <div class="prod-slide active"><img src="{{ asset('jry1.webp') }}" alt="Premium Athletic Jersey 1" onerror="this.src='https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=600'"></div>
              <div class="prod-slide"><img src="{{ asset('jry2.webp') }}" alt="Premium Athletic Jersey 2" onerror="this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600'"></div>
            </div>
            <div class="ps-dots">
              <span class="ps-dot active" onclick="setCardSlideCatalog(this, 0)"></span>
              <span class="ps-dot" onclick="setCardSlideCatalog(this, 1)"></span>
            </div>
          </div>
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
    </div>

    <div id="noMatchMsg" style="display:none;text-align:center;padding:48px 0;color:var(--mut)">
      <p style="font-size:16px">No products match your search or filter.</p>
    </div>

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