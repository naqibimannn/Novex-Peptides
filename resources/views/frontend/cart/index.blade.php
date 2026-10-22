@extends('frontend.home.index')

@section('content')
<section class="sec">
  <div class="wrap" style="max-width:800px">
    <div class="head">
      <div>
        <h1 style="font-size:38px">Your Research Cart</h1>
        <p>Review your selected compounds and items before proceeding to WhatsApp checkout.</p>
      </div>
    </div>
    <div style="background:#fff;border:1px solid var(--line);border-radius:24px;padding:32px;text-align:center">
      <p style="color:var(--mut);font-size:16px;margin-bottom:16px">Your items are synced directly with our WhatsApp ordering system.</p>
      <a class="btn" href="https://wa.me/601112085054?text=Hello%20Novex%20Peptides%20I%20want%20to%20order" target="_blank" style="background:#25D366;color:#fff;padding:14px 36px;font-weight:700">Proceed via WhatsApp Checkout</a>
    </div>
  </div>
</section>
@endsection