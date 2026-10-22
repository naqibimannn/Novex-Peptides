@extends('frontend.home.index')

@section('content')
<section class="sec">
  <div class="wrap">
    <div style="margin-bottom:24px">
      <a href="{{ route('products.index') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Catalog</a>
    </div>
    <div class="g2" style="align-items:start">
      <div style="aspect-ratio:1;border-radius:24px;border:1px solid var(--line);padding:24px;display:flex;align-items:center;justify-content:center;background:#fff">
        <img src="{{ asset('reta1.webp') }}" alt="Product Image" style="max-height:100%;object-fit:contain;border-radius:18px" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800'">
      </div>
      <div>
        <span style="font-size:12px;font-weight:600;background:var(--bg2);color:var(--green);padding:4px 12px;border-radius:999px">Research Grade</span>
        <h1 style="font-size:36px;margin:12px 0 6px">Product Details</h1>
        <p style="color:var(--mut);margin-bottom:16px">Batch verification and full chemical documentation available upon order.</p>
        <div style="font-size:32px;font-weight:700;color:var(--green);margin-bottom:20px">RM280.00</div>
        <a class="btn" href="https://wa.me/601112085054?text=Hello%20Novex%20Peptides%20I%20want%20to%20order" target="_blank" style="width:100%;padding:14px;font-size:15px">Order via WhatsApp</a>
      </div>
    </div>
  </div>
</section>
@endsection