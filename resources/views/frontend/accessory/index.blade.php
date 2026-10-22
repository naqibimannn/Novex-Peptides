@extends('frontend.home.index')

@section('content')
<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Research Accessories</h1>
        <p>Laboratory-grade reconstitution kits, administration sets, and precision needles formulated for accurate laboratory measurement.</p>
      </div>
    </div>

    <div class="g4">
      <div class="card pc">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600" alt="Injection Kit" style="object-fit:contain;padding:12px">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Injection Kit</h3>
          <p class="s">Complete Reconstitution &amp; Administration Set</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM35.00</div>
          <div class="meta" style="margin-top:auto">
            <span style="font-weight:600">Standard Set</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('products.show', 'injection-kit') }}">See Details</a>
        </div>
      </div>

      <div class="card pc">
        <div class="ph">
          <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=600" alt="Insulin Needle 1 ml" style="object-fit:contain;padding:12px">
          <span class="chip">Accessory</span>
        </div>
        <div class="b">
          <h3>Insulin Needle 1 ml</h3>
          <p class="s">Ultra-Fine Precision Micro-Syringe (31G)</p>
          <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">RM25.00</div>
          <div class="meta" style="margin-top:auto">
            <span style="font-weight:600">Box of 10 pcs</span>
            <span>Laboratory Item</span>
          </div>
          <a class="btn-details" href="{{ route('products.show', 'insulin-needle-1ml') }}">See Details</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection