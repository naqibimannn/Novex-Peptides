@php
    $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia'));
    $secretPrefix = 'admin/' . $secretKey;
@endphp

<div class="flex flex-col gap-8">

  <!-- HEADER SECTION -->
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Organization Profile &amp; Contact Desk
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Directory &middot; Real-time synchronization for customer contact desks, email support, and social networks.
      </p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
      <a href="{{ url('/') }}" target="_blank"
        class="inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98]">
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
        </svg>
        <span>View Live Site</span>
      </a>

      <button type="button" onclick="location.reload()"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
        <svg id="orgRefreshSpinner" class="w-4 h-4 text-slate-500 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Refresh Info</span>
      </button>
    </div>
  </div>

  <!-- MAIN CARD CONTAINER (TERUS DIBUKA TANPA DROPDOWN) -->
  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    
    <!-- CARD TITLE BAR -->
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Organization Directory &amp; Contact Desk Settings
      </span>
    </div>

    <!-- FORM BODY -->
    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ url($secretPrefix . '/info') }}" method="POST" class="space-y-5">
        @csrf

        <!-- SEKSYEN 1: BRAND IDENTITY -->
        <div class="space-y-3">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Brand &amp; Identity</h3>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Company / Entity Name</label>
            <input type="text" name="company_name" value="{{ old('company_name', $org->company_name ?? 'Novex Peptides') }}" required
              class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
          </div>
        </div>

        <!-- SEKSYEN 2: CONTACT DETAILS -->
        <div class="space-y-3 pt-4 border-t border-slate-100">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Contact Desk Inquiries</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Direct WhatsApp &amp; Inquiries Phone *</label>
              <input type="text" name="phone_number" value="{{ old('phone_number', $org->phone_number ?? '+60 11-2549 0484') }}" required
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
              <span class="block text-[11px] text-slate-400 mt-1 font-medium">Dipautkan terus ke WhatsApp di halaman utama (`https://wa.me/...`).</span>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Support Email Address *</label>
              <input type="email" name="email" value="{{ old('email', $org->email ?? 'support@novexsupps.com') }}" required
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
              <span class="block text-[11px] text-slate-400 mt-1 font-medium">Alamat emel rasmi bagi sokongan pelanggan (`mailto:...`).</span>
            </div>
          </div>
        </div>

        <!-- SEKSYEN 3: SOCIAL MEDIA -->
        <div class="space-y-3 pt-4 border-t border-slate-100">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Official Social Media Channels</h3>

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
        </div>

        <!-- ACTION BUTTON -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Save Profile Changes
          </button>
        </div>

      </form>
    </div>

  </div>

</div>