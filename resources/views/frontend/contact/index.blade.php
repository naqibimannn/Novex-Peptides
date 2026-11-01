@extends('frontend.home.index')

@section('content')
@php
    $orgInfo = \Illuminate\Support\Facades\Schema::hasTable('organization_info')
        ? \Illuminate\Support\Facades\DB::table('organization_info')->first()
        : null;

    $orgPhone = $orgInfo->phone_number ?? '+60 11-2549 0484';
    $companyName = $orgInfo->company_name ?? 'Novex Peptides';
    $cleanWaPhone = preg_replace('/[^0-9]/', '', $orgPhone);
    $waText = rawurlencode("Hi {$companyName}, I have an inquiry.");
@endphp

<style>
.c-grid{
  display:grid;
  grid-template-columns:1.05fr 1fr;
  gap:48px;
  align-items:stretch;
}
.c-left-col{
  display:flex;
  flex-direction:column;
  height:100%;
}
.c-wa-box{
  background:linear-gradient(145deg, #162638, #0E1A27);
  border:1px solid var(--line);
  color:#fff;
  padding:36px 32px;
  position:relative;
  overflow:hidden;
  border-radius:26px;
  box-shadow:0 12px 30px rgba(0,0,0,.15);
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  flex:1;
  gap:22px;
}
.c-wa-box h3{
  font-size:28px;
  color:#fff;
  margin-bottom:6px;
}
.c-phone-card{
  background:rgba(255,255,255,.05);
  border:1px solid rgba(255,255,255,.12);
  border-radius:20px;
  padding:20px 22px;
  display:flex;
  flex-direction:column;
  gap:8px;
  backdrop-filter:blur(8px);
}
.c-phone-meta{
  display:flex;
  align-items:center;
  font-size:11px;
  font-weight:600;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#8CC2E8;
}
.c-phone-val{
  font-size:24px;
  font-weight:700;
  color:#FFFFFF;
  letter-spacing:.02em;
  font-family:var(--sans);
}
.c-phone-sub{
  font-size:12px;
  color:#8EA4B8;
}
.c-wa-desc{
  font-size:14px;
  color:#C8DCEF;
  line-height:1.65;
  margin:0;
}
.c-wa-btn{
  background:#25D366;
  color:#fff;
  display:inline-flex;
  align-items:center;
  gap:10px;
  width:fit-content;
  padding:14px 28px;
  border-radius:999px;
  font-size:13px;
  font-weight:700;
  letter-spacing:.02em;
  transition:all .2s ease;
  box-shadow:0 6px 18px rgba(37,211,102,.25);
}
.c-wa-btn:hover{
  background:#20ba59;
  transform:translateY(-1px);
}
.c-form-wrap{
  background:var(--card-surface);
  border:1px solid var(--line);
  padding:40px;
  position:relative;
  border-radius:26px;
  box-shadow:0 10px 30px rgba(14,40,66,.05);
  transition:background-color .25s ease, border-color .25s ease;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}
.c-form-wrap h3{
  color:var(--ink);
}
.form{
  display:grid;
  gap:18px;
  flex:1;
}
.f-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.f-grp{display:flex;flex-direction:column;gap:6px}
.f-grp label{
  font-size:11px;
  font-weight:600;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:var(--ink);
}
.form input,
.form select,
.form textarea{
  width:100%;
  padding:13px 14px;
  border:1px solid var(--line);
  background:var(--card);
  font:inherit;
  color:var(--ink);
  border-radius:14px;
  box-sizing:border-box;
  outline:none;
  transition:border-color .2s ease, background-color .25s ease, color .25s ease;
}
.form input::placeholder,
.form textarea::placeholder{
  color:var(--mut);
}
.form input:focus,
.form select:focus,
.form textarea:focus{
  border-color:var(--green);
}

@media(max-width:900px){
  .c-grid{grid-template-columns:1fr;gap:36px}
}
@media(max-width:640px){
  .f-row{grid-template-columns:1fr}
  .c-form-wrap{padding:26px 20px}
  .c-wa-box{padding:26px 20px}
}
</style>

<section class="hero">
  <img id="heroImage" src="{{ asset('assets/website/contact/hero.webp') }}" href="{{ asset('assets/website/contact/hero.webp') }}" alt="Contact Desk" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">Contact Desk</span>
      <h1>Talk to the people who pack the box</h1>
      <p>Questions on a lot number, a delivery window or merchandise sizing? We answer them directly.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="c-grid">
      <div class="c-left-col">
        <h1 style="font-size:clamp(32px,4vw,42px);margin-bottom:12px">Direct Contact Desk</h1>
        <p style="color:var(--mut);margin-bottom:24px;line-height:1.6">
          For real-time stock inquiries, bulk orders, or custom batch certificates, contact our desk directly.
        </p>

        <div class="c-wa-box">
          <div>
            <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#8CC2E8;display:block;margin-bottom:6px">Priority Channel</span>
            <h3>WhatsApp Direct Line</h3>
          </div>

          <div class="c-phone-card">
            <div class="c-phone-meta">
              <span>Available Online &bull; Direct Desk</span>
            </div>
            <div class="c-phone-val">{{ $orgPhone }}</div>
            <div class="c-phone-sub">Fast response for verification &amp; order support</div>
          </div>

          <p class="c-wa-desc">
            For immediate product availability, jersey sizing, wholesale enquiries, or real-time tracking, speak directly with our team.
          </p>

          <a class="c-wa-btn" href="https://wa.me/{{ $cleanWaPhone }}?text={{ $waText }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 32 32" width="18" height="18" fill="#fff" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
            <span>Chat on WhatsApp</span>
          </a>
        </div>
      </div>

      <div class="c-form-wrap">
        <div>
          <h3 style="font-size:28px;margin-bottom:8px">Send an Enquiry</h3>
          <p style="color:var(--mut);font-size:14px;margin-bottom:22px">Complete the form below and our team will respond shortly.</p>
        </div>
        
        <form class="form" id="contactForm" onsubmit="event.preventDefault();handleEnquirySubmit(this);">
          <div class="f-row">
            <div class="f-grp">
              <label>Full Name</label>
              <input type="text" placeholder="Your Name" required>
            </div>
            <div class="f-grp">
              <label>Email Address</label>
              <input type="email" placeholder="Your Email" required>
            </div>
          </div>
          <div class="f-grp">
            <label>Message</label>
            <textarea rows="4" placeholder="How can we assist your research or order today?" required></textarea>
          </div>
          <button class="btn" type="submit" style="width:100%;padding:14px;font-size:14px;font-weight:600;margin-top:auto">Submit Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
function handleEnquirySubmit(formEl){
  formEl.innerHTML = `
    <div style="padding:36px 20px;text-align:center;background:var(--bg2);border:1px solid var(--line);border-radius:18px">
      <h3 style="margin-bottom:8px;color:var(--green);font-size:22px">Enquiry Received</h3>
      <p style="color:var(--mut);font-size:14px;line-height:1.6">Thank you for contacting {{ $companyName }}. We will respond within one business day.</p>
    </div>
  `;
}

function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/contact/hero-phone.webp') }}"
    : "{{ asset('assets/website/contact/hero.webp') }}";

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