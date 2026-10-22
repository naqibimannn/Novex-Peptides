@extends('frontend.home.index')

@section('content')
<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Shop Catalog</h1>
        <p>Select any product to view its batch specifications, dosage options, stock availability, and full profile.</p>
      </div>
    </div>
    
    <div class="g4">
      <div class="card pc">
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

      <div class="card pc">
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
    </div>
  </div>
</section>
@endsection