@extends('frontend.home.index')

@php
    $orgData = \Illuminate\Support\Facades\Cache::remember('site_organization_info', 86400, function () {
        if (\Illuminate\Support\Facades\Schema::hasTable('organization_info')) {
            $data = \Illuminate\Support\Facades\DB::table('organization_info')->first();
            return $data ? (array) $data : [];
        }
        return [];
    });

    $orgInfo = !empty($orgData) ? (object) $orgData : null;

    $companyName = $orgInfo->company_name ?? 'Novex Peptides';
    $orgPhone = $orgInfo->phone_number ?? '+60 11-2549 0484';
    $orgEmail = $orgInfo->email ?? 'support@novexsupps.com';
    $orgIg = $orgInfo->instagram_url ?? 'https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==';
    $orgTiktok = $orgInfo->tiktok_url ?? 'https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1';

    $cleanWaPhone = preg_replace('/[^0-9]/', '', $orgPhone);
    $waText = rawurlencode("Hi {$companyName}, I have an inquiry.");

    $contactUrl = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/contact');

    $socialLinks = array_values(array_filter([$orgIg, $orgTiktok]));

    $contactCssPath = 'frontend/contact/contact.css';
    $contactCssVer = file_exists(public_path($contactCssPath)) ? filemtime(public_path($contactCssPath)) : time();

    $contactJsPath = 'frontend/contact/contact.js';
    $contactJsVer = file_exists(public_path($contactJsPath)) ? filemtime(public_path($contactJsPath)) : time();
@endphp

@section('seo')
<x-seo 
    :title="'Contact Desk & Direct Support | ' . $companyName"
    :description="'Contact ' . $companyName . ' desk for order tracking, custom batch certificates, wholesale pricing, and technical support. Direct desk: ' . $orgPhone . ' or email: ' . $orgEmail . '.'"
    :canonical="$contactUrl"
    region="MY-10"
    placename="Selangor, Malaysia"
    latitude="3.2384"
    longitude="101.4278"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => $companyName . ' Contact Desk',
        'url' => $contactUrl,
        'description' => 'Get in touch with ' . $companyName . ' for order tracking, certificates of analysis, wholesale, and support.',
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => $companyName,
            'url' => url('/'),
            'logo' => asset('logo.png'),
            'telephone' => $orgPhone,
            'email' => $orgEmail,
            'sameAs' => $socialLinks,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Puncak Alam',
                'addressRegion' => 'Selangor',
                'addressCountry' => 'MY'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 3.2384,
                'longitude' => 101.4278
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $orgPhone,
                'email' => $orgEmail,
                'contactType' => 'customer support',
                'availableLanguage' => ['English', 'Malay']
            ]
        ],
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/')
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Contact Desk',
                    'item' => $contactUrl
                ]
            ]
        ]
    ]"
/>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset($contactCssPath) }}?v={{ $contactCssVer }}">

<section class="contact-hero">
  <img id="heroImage" 
       src="{{ asset('assets/website/contact/hero.webp') }}" 
       data-desktop="{{ asset('assets/website/contact/hero.webp') }}" 
       data-phone="{{ asset('assets/website/contact/hero-phone.webp') }}" 
       alt="Contact Desk Support" 
       width="1800"
       height="700"
       onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span class="eyebrow">Contact Desk</span>
      <h1>Talk to the people who pack the box</h1>
      <p>Questions on a lot number, a delivery window or merchandise sizing? We answer them directly.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="c-grid">
      <div class="c-left-col">
        <h2 class="c-title">Direct Contact Desk</h2>
        <p class="c-subtitle">
          For real-time stock inquiries, bulk orders, or custom batch certificates, contact our desk directly.
        </p>

        <div class="c-wa-box">
          <div>
            <span class="c-wa-tag">Priority Channel</span>
            <h3 class="c-wa-title">WhatsApp Direct Line</h3>
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
          <h3 class="form-title">Send an Enquiry</h3>
          <p class="form-subtitle">Complete the form below and our team will respond shortly.</p>
        </div>
        
        <form class="contact-form" id="contactForm" onsubmit="event.preventDefault();handleEnquirySubmit(this);">
          <div class="form-row-2">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" placeholder="Your Name" required class="form-input">
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" placeholder="Your Email" required class="form-input">
            </div>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea rows="4" placeholder="How can we assist your research or order today?" required class="form-textarea"></textarea>
          </div>
          <button class="btn-submit-enquiry" type="submit">Submit Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
window.NVX_CONTACT = {
  companyName: @json($companyName),
  heroPhone: '{{ asset("assets/website/contact/hero-phone.webp") }}',
  heroDesktop: '{{ asset("assets/website/contact/hero.webp") }}'
};
</script>
<script src="{{ asset($contactJsPath) }}?v={{ $contactJsVer }}"></script>
@endsection