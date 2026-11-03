@php
    $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY'));
    $secretPrefix = 'admin/' . $secretKey;

    if (!isset($org) || $org instanceof \__PHP_Incomplete_Class) {
        $org = (object) [];
    }
@endphp

<div class="flex flex-col gap-8">

  {{-- Header --}}
  <div class="pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Organization Profile &amp; Contact Desk
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Directory &middot; Real-time synchronization for customer contact desks, email support, and social networks.
      </p>
    </div>
  </div>

  {{-- Tab Selector --}}
  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
      <label class="text-xs font-bold text-slate-500 uppercase tracking-wider shrink-0">Select Category:</label>
      <div class="inline-flex items-center bg-slate-200/60 p-1 rounded-full text-xs font-medium overflow-x-auto max-w-full">
        <button type="button" onclick="switchOrgTab('company', this)" id="tabBtnCompany"
          class="org-mode-tab px-5 py-1.5 rounded-full transition-all cursor-pointer bg-white text-slate-900 font-semibold shadow-xs">
          Company Name
        </button>
        <button type="button" onclick="switchOrgTab('contact', this)" id="tabBtnContact"
          class="org-mode-tab px-5 py-1.5 rounded-full transition-all cursor-pointer text-slate-500 hover:text-slate-800">
          Phone &amp; Email
        </button>
        <button type="button" onclick="switchOrgTab('social', this)" id="tabBtnSocial"
          class="org-mode-tab px-5 py-1.5 rounded-full transition-all cursor-pointer text-slate-500 hover:text-slate-800">
          Social Media
        </button>
      </div>
    </div>
  </div>

  {{-- Panel 1: Company Name --}}
  <div id="panelCompany" class="relative z-20 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Brand &amp; Corporate Identity
      </span>
    </div>

    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ url($secretPrefix . '/info') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="phone_number" value="{{ $org->phone_number ?? '+60 11-2549 0484' }}">
        <input type="hidden" name="email" value="{{ $org->email ?? 'support@novexsupps.com' }}">
        <input type="hidden" name="instagram_url" value="{{ $org->instagram_url ?? '' }}">
        <input type="hidden" name="tiktok_url" value="{{ $org->tiktok_url ?? '' }}">

        <div class="space-y-3">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Company / Entity Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name', $org->company_name ?? 'Novex Peptides') }}" required
              class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            <span class="block text-[11px] text-slate-400 mt-1 font-medium">Official trade name displayed across the system branding, footer, and metadata.</span>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Save Company Name
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Panel 2: Phone & Email --}}
  <div id="panelContact" class="hidden relative z-20 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Contact Desk &amp; Inquiry Channels
      </span>
    </div>

    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ url($secretPrefix . '/info') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="company_name" value="{{ $org->company_name ?? 'Novex Peptides' }}">
        <input type="hidden" name="instagram_url" value="{{ $org->instagram_url ?? '' }}">
        <input type="hidden" name="tiktok_url" value="{{ $org->tiktok_url ?? '' }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Direct WhatsApp &amp; Inquiries Phone *</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $org->phone_number ?? '+60 11-2549 0484') }}" required
              class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            <span class="block text-[11px] text-slate-400 mt-1 font-medium">Directly linked to WhatsApp on the main page (`https://wa.me/...`).</span>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Support Email Address *</label>
            <input type="email" name="email" value="{{ old('email', $org->email ?? 'support@novexsupps.com') }}" required
              class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            <span class="block text-[11px] text-slate-400 mt-1 font-medium">Official email address for customer support inquiries (`mailto:...`).</span>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Save Contact Details
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Panel 3: Social Media --}}
  <div id="panelSocial" class="hidden relative z-20 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Official Social Media Channels
      </span>
    </div>

    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ url($secretPrefix . '/info') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="company_name" value="{{ $org->company_name ?? 'Novex Peptides' }}">
        <input type="hidden" name="phone_number" value="{{ $org->phone_number ?? '+60 11-2549 0484' }}">
        <input type="hidden" name="email" value="{{ $org->email ?? 'support@novexsupps.com' }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Instagram Profile URL</label>
            <div class="relative flex items-center">
              <span class="absolute left-3.5 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </span>
              <input type="url" name="instagram_url" value="{{ old('instagram_url', $org->instagram_url ?? '') }}" placeholder="https://www.instagram.com/..."
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">TikTok Profile URL</label>
            <div class="relative flex items-center">
              <span class="absolute left-3.5 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.86.12V9.37a6.34 6.34 0 0 0-.86-.06A6.33 6.33 0 0 0 3.1 15.64a6.34 6.34 0 0 0 10.82 4.48 6.27 6.27 0 0 0 1.89-4.48V8.78a8.28 8.28 0 0 0 4.78 1.5V6.82a4.84 4.84 0 0 1-1-.13z"/>
                </svg>
              </span>
              <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $org->tiktok_url ?? '') }}" placeholder="https://www.tiktok.com/@..."
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Save Social Media Links
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
  function switchOrgTab(tab, btnEl) {
    document.querySelectorAll('.org-mode-tab').forEach(b => {
      b.className = 'org-mode-tab px-5 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800 cursor-pointer';
    });
    btnEl.className = 'org-mode-tab px-5 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs cursor-pointer';

    const companyPanel = document.getElementById('panelCompany');
    const contactPanel = document.getElementById('panelContact');
    const socialPanel = document.getElementById('panelSocial');

    companyPanel.classList.add('hidden');
    contactPanel.classList.add('hidden');
    socialPanel.classList.add('hidden');

    if (tab === 'company') {
      companyPanel.classList.remove('hidden');
    } else if (tab === 'contact') {
      contactPanel.classList.remove('hidden');
    } else if (tab === 'social') {
      socialPanel.classList.remove('hidden');
    }
  }
</script>