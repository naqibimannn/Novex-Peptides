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

<section class="hero relative min-h-[480px] sm:min-h-[520px] h-[calc(100vh-var(--off,110px))] overflow-hidden text-white flex items-center before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:to-[#0A111A]/[0.25]">
  <img id="heroImage" src="{{ asset('assets/website/contact/hero.webp') }}" href="{{ asset('assets/website/contact/hero.webp') }}" alt="Contact Desk" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05] block">
  <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="in max-w-[580px]">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block text-white">Contact Desk</span>
      <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Talk to the people who pack the box</h1>
      <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Questions on a lot number, a delivery window or merchandise sizing? We answer them directly.</p>
    </div>
  </div>
</section>

<section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="c-grid grid grid-cols-1 min-[901px]:grid-cols-[1.05fr_1fr] gap-9 min-[901px]:gap-12 items-stretch">
      <div class="c-left-col flex flex-col h-full">
        <h1 class="font-serif text-[clamp(32px,4vw,42px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC] mb-3">Direct Contact Desk</h1>
        <p class="text-[#5A6F82] dark:text-[#8EA4B8] mb-6 leading-[1.6] text-[15px]">
          For real-time stock inquiries, bulk orders, or custom batch certificates, contact our desk directly.
        </p>

        <div class="c-wa-box bg-[linear-gradient(145deg,#162638,#0E1A27)] border border-[#D2E2EF] dark:border-[#1C2D3E] text-white p-[26px_20px] sm:p-8 min-[901px]:p-[36px_32px] relative overflow-hidden rounded-[26px] shadow-[0_12px_30px_rgba(0,0,0,0.15)] flex flex-col justify-between flex-1 gap-[22px]">
          <div>
            <span class="text-[11px] font-semibold tracking-[0.2em] uppercase text-[#8CC2E8] block mb-1.5">Priority Channel</span>
            <h3 class="font-serif text-[28px] font-medium text-white mb-1.5 leading-[1.15]">WhatsApp Direct Line</h3>
          </div>

          <div class="c-phone-card bg-white/[0.05] border border-white/[0.12] rounded-[20px] p-[20px_22px] flex flex-col gap-2 backdrop-blur-[8px]">
            <div class="c-phone-meta flex items-center text-[11px] font-semibold tracking-[0.08em] uppercase text-[#8CC2E8]">
              <span>Available Online &bull; Direct Desk</span>
            </div>
            <div class="c-phone-val text-2xl font-bold text-white tracking-[0.02em] font-sans">{{ $orgPhone }}</div>
            <div class="c-phone-sub text-xs text-[#8EA4B8]">Fast response for verification &amp; order support</div>
          </div>

          <p class="c-wa-desc text-sm text-[#C8DCEF] leading-[1.65] m-0">
            For immediate product availability, jersey sizing, wholesale enquiries, or real-time tracking, speak directly with our team.
          </p>

          <a class="c-wa-btn bg-[#25D366] hover:bg-[#20ba59] text-white inline-flex items-center gap-2.5 w-fit py-3.5 px-7 rounded-full text-[13px] font-bold tracking-[0.02em] transition-all duration-200 shadow-[0_6px_18px_rgba(37,211,102,0.25)] hover:-translate-y-0.5 no-underline" href="https://wa.me/{{ $cleanWaPhone }}?text={{ $waText }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 32 32" width="18" height="18" fill="#fff" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
            <span>Chat on WhatsApp</span>
          </a>
        </div>
      </div>

      <div class="c-form-wrap bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] p-[26px_20px] sm:p-8 min-[901px]:p-10 relative rounded-[26px] shadow-[0_10px_30px_rgba(14,40,66,0.05)] transition-colors duration-200 flex flex-col justify-between">
        <div>
          <h3 class="font-serif text-[28px] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC] mb-2">Send an Enquiry</h3>
          <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-sm mb-[22px]">Complete the form below and our team will respond shortly.</p>
        </div>
        
        <form class="form grid gap-[18px] flex-1" id="contactForm" onsubmit="event.preventDefault();handleEnquirySubmit(this);">
          <div class="f-row grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="f-grp flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold tracking-[0.12em] uppercase text-[#1E2D3B] dark:text-[#F0F6FC]">Full Name</label>
              <input type="text" placeholder="Your Name" required class="w-full py-3.5 px-3.5 border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] text-[#1E2D3B] dark:text-[#F0F6FC] rounded-[14px] outline-none transition-colors duration-200 placeholder-[#5A6F82] dark:placeholder-[#8EA4B8] focus:border-[#2F6F9F] dark:focus:border-[#327BB3]">
            </div>
            <div class="f-grp flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold tracking-[0.12em] uppercase text-[#1E2D3B] dark:text-[#F0F6FC]">Email Address</label>
              <input type="email" placeholder="Your Email" required class="w-full py-3.5 px-3.5 border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] text-[#1E2D3B] dark:text-[#F0F6FC] rounded-[14px] outline-none transition-colors duration-200 placeholder-[#5A6F82] dark:placeholder-[#8EA4B8] focus:border-[#2F6F9F] dark:focus:border-[#327BB3]">
            </div>
          </div>
          <div class="f-grp flex flex-col gap-1.5">
            <label class="text-[11px] font-semibold tracking-[0.12em] uppercase text-[#1E2D3B] dark:text-[#F0F6FC]">Message</label>
            <textarea rows="4" placeholder="How can we assist your research or order today?" required class="w-full py-3.5 px-3.5 border border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] text-[#1E2D3B] dark:text-[#F0F6FC] rounded-[14px] outline-none transition-colors duration-200 placeholder-[#5A6F82] dark:placeholder-[#8EA4B8] focus:border-[#2F6F9F] dark:focus:border-[#327BB3]"></textarea>
          </div>
          <button class="btn w-full bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#266391] dark:hover:bg-[#286391] text-white p-3.5 text-sm font-semibold rounded-full mt-auto transition-colors duration-200 cursor-pointer border-0" type="submit">Submit Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
function handleEnquirySubmit(formEl){
  formEl.innerHTML = `
    <div class="p-[36px_20px] text-center bg-[#E9F2FA] dark:bg-[#101B27] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[18px]">
      <h3 class="mb-2 text-[#2F6F9F] dark:text-[#327BB3] text-[22px] font-serif font-medium">Enquiry Received</h3>
      <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-sm leading-[1.6]">Thank you for contacting {{ $companyName }}. We will respond within one business day.</p>
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