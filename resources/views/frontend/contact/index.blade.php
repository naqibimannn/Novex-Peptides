@extends('frontend.home.index')

@section('content')
<section class="sec">
  <div class="wrap g2">
    <div>
      <h1 style="font-size:42px;margin-bottom:12px">Direct Contact Desk</h1>
      <p style="color:var(--mut);margin-bottom:24px">For real-time stock inquiries, bulk orders, or custom batch certificates, contact our desk directly.</p>
      <div style="background:var(--ink);color:#fff;padding:28px;border-radius:22px">
        <h3 style="margin-bottom:8px">WhatsApp Direct Line</h3>
        <p style="font-size:14px;color:#C8DCEF;margin-bottom:18px">+60 11-1208 5054</p>
        <a class="btn" style="background:#25D366;color:#fff" href="https://wa.me/601112085054" target="_blank">Chat on WhatsApp</a>
      </div>
    </div>
    <div style="background:var(--card);padding:32px;border-radius:24px;border:1px solid var(--line)">
      <h3 style="margin-bottom:16px">Send an Enquiry</h3>
      <form style="display:grid;gap:14px" onsubmit="event.preventDefault();alert('Enquiry submitted.');">
        <input type="text" placeholder="Your Name" required style="padding:12px;border-radius:10px;border:1px solid var(--line)">
        <input type="email" placeholder="Your Email" required style="padding:12px;border-radius:10px;border:1px solid var(--line)">
        <textarea placeholder="Message" rows="4" required style="padding:12px;border-radius:10px;border:1px solid var(--line)"></textarea>
        <button class="btn" type="submit">Submit Message</button>
      </form>
    </div>
  </div>
</section>
@endsection