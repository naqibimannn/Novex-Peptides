<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CentraDesk &middot; Enterprise Management Console</title>
  
  {{-- Favicon Tab Browser --}}
  <link rel="icon" type="image/png" href="{{ asset('assets/admin/logo.png') }}">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'brand-blue': '#0479F8',
            'brand-deep': '#09364C',
            'surface-dark': '#06202E',
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'monospace'],
          }
        }
      }
    }
  </script>
  <style>
    /* Honeypot Trap - Tersembunyi sepenuhnya dari pandangan manusia */
    .hp-trap-input {
      position: absolute !important;
      left: -9999px !important;
      top: -9999px !important;
      opacity: 0 !important;
      height: 0 !important;
      width: 0 !important;
      z-index: -1 !important;
      pointer-events: none !important;
    }

    /* Animasi Bar Garisan Loading */
    @keyframes simpleScan {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(250%); }
    }
    .animate-simple-scan {
      animation: simpleScan 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
  </style>
</head>

<body class="bg-white font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between relative overflow-x-hidden">

  <!-- =========================================================================
       1. LAPISAN ANIMASI PEMBUKAAN (PRELOADER)
       ========================================================================= -->
  <div id="pageLoaderOverlay" 
    class="fixed inset-0 z-50 bg-white flex flex-col items-center justify-center transition-opacity duration-500 ease-out opacity-100">
    
    <div class="relative z-10 flex flex-col items-center max-w-xs w-full px-6 text-center">
      
      <!-- LOGO PEMBUKAAN -->
      <div class="flex items-center justify-center mb-6 animate-pulse select-none">
        <img src="{{ asset('assets/admin/logo-cms.png') }}" alt="CentraDesk Logo" class="h-9 w-auto object-contain">
      </div>

      <!-- GARISAN PEMUAT -->
      <div class="w-44 h-1 bg-slate-100 rounded-full overflow-hidden relative mb-3">
        <div class="w-1/2 h-full bg-brand-blue rounded-full animate-simple-scan"></div>
      </div>

      <!-- TEKS STATUS RINGKAS -->
      <div class="h-4 flex items-center justify-center">
        <span id="loaderStatusText" class="text-xs text-slate-400 font-medium tracking-tight transition-opacity duration-200">
          Initializing environment...
        </span>
      </div>

    </div>
  </div>

  <!-- =========================================================================
       2. KANDUNGAN UTAMA HALAMAN LOG MASUK
       ========================================================================= -->
  <div class="w-full min-h-screen flex flex-col md:flex-row relative">

    <!-- SEKSYEN KIRI: BORANG LOGIN MODEN -->
    <div class="w-full md:w-1/2 flex flex-col justify-between p-8 sm:p-12 lg:p-16 bg-slate-50/50 min-h-screen z-10">
      
      <!-- LOGO CENTRADESK DI ATAS BORANG -->
      <div>
        <a href="javascript:void(0)" class="inline-block group select-none transition-transform hover:scale-[1.02]">
          <img src="{{ asset('assets/admin/logo-cms.png') }}" alt="CentraDesk" class="h-10 w-auto max-w-[190px] object-contain">
        </a>
      </div>

      <!-- BORANG LOGIN DENGAN DESIGN MODERN -->
      <div class="max-w-md w-full mx-auto my-auto py-8">
        
        <!-- TAJUK BORANG -->
        <div class="mb-10">
          <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Sign In</h1>
          <p class="text-xs sm:text-sm text-slate-500 mt-2 font-medium">Enter your verified credentials to access the admin portal.</p>
        </div>

        @if ($errors->any())
          <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs flex items-center gap-2.5 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0 animate-ping"></span>
            <div class="font-medium">
              @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
              @endforeach
            </div>
          </div>
        @endif

        <form id="loginForm" action="{{ route('admin.login.submit', ['secret' => config('admin.secret_key')]) }}" method="POST" class="space-y-6" onsubmit="handleFormSubmit()">
          @csrf

          <!-- HONEYPOT TRAP (BOT TRAP) -->
          <div class="hp-trap-input" aria-hidden="true">
            <label for="website_verify">Leave this field empty</label>
            <input type="text" name="website_verify" id="website_verify" tabindex="-1" autocomplete="off">
          </div>

          <!-- INPUT EMEL MODEN -->
          <div class="space-y-2">
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Email Address</label>
            <div class="relative group">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-brand-blue transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
              </div>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="admin@novexsupps.com"
                class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-11 pr-4 text-xs font-semibold text-slate-900 placeholder:text-slate-400 shadow-sm focus:outline-none focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 transition-all">
            </div>
          </div>

          <!-- INPUT PASSWORD MODEN -->
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Password</label>
              <a href="#" class="text-xs font-semibold text-brand-blue hover:text-brand-deep hover:underline transition-colors" onclick="event.preventDefault(); alert('Modul reset password keselamatan tinggi hanya melalui terminal SSH.');">
                Forgot password?
              </a>
            </div>
            <div class="relative group">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-brand-blue transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </div>
              
              <input type="password" name="password" id="password" required placeholder="••••••••••••"
                class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-11 pr-11 text-xs font-semibold text-slate-900 placeholder:text-slate-400 shadow-sm focus:outline-none focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 transition-all">
              
              <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer focus:outline-none" aria-label="Toggle password visibility">
                <svg id="eyeOpenIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <svg id="eyeClosedIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- REMEMBER CHECKBOX -->
          <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2.5 cursor-pointer select-none group">
              <input type="checkbox" name="remember" class="w-4 h-4 rounded-md border-slate-300 text-brand-deep focus:ring-brand-blue transition-colors">
              <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">Remember session</span>
            </label>
          </div>

          <!-- BUTANG AUTHORIZE ACCESS MODEN -->
          <button type="submit" id="submitBtn"
            class="w-full mt-3 py-4 px-6 rounded-2xl bg-brand-deep hover:bg-slate-900 active:scale-[0.99] text-white font-bold text-xs tracking-wider uppercase transition-all shadow-xl shadow-brand-deep/20 hover:shadow-slate-900/30 cursor-pointer flex items-center justify-center gap-2.5 group">
            
            <span id="btnText">Authorize Access</span>
            <svg id="btnArrow" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
            </svg>

            <svg id="btnSpinner" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span id="btnLoadingText" class="hidden">Authenticating Terminal...</span>
          </button>
        </form>
      </div>

      <!-- FOOTER BAWAH KANAN: POWERED BY LARAVEL -->
      <div class="relative z-10 pt-4 border-t border-slate-200/60 text-xs text-slate-400 font-medium flex items-center justify-center text-center">
        <div class="inline-flex items-center gap-1.5 select-none text-[11px] text-slate-400">
          <span>Powered by</span>
          <img src="{{ asset('assets/admin/login/laravel.webp') }}" alt="Laravel" class="h-3.5 w-auto object-contain opacity-80">
        </div>
      </div>

    </div>

    <!-- SEKSYEN KANAN: PREVIEW SECTION -->
    <div id="heroSection" class="fixed inset-0 z-20 bg-cover bg-center bg-no-repeat p-8 sm:p-12 lg:p-16 text-white flex flex-col justify-between overflow-hidden transition-all duration-1000 ease-in-out" 
         style="left: 0; background-image: url('{{ asset('assets/admin/login/preview.webp') }}');">
      
      <!-- LAPISAN GELAP OVERLAY SUPAYA TEKS KEKAL JELAS DIBACA -->
      <div class="absolute inset-0 bg-brand-deep/80 backdrop-blur-[2px] pointer-events-none"></div>

      <!-- SPACE KOSONG ATAS -->
      <div class="hidden md:block"></div>

      <!-- TAJUK UTAMA -->
      <div class="relative z-10 max-w-lg my-auto">
        <div class="text-xs uppercase tracking-widest font-bold text-brand-blue mb-3">Your CentraDesk</div>
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] text-white">
          Next–Gen <br>Infrastructure. <br>
          <span class="bg-gradient-to-r from-white via-slate-200 to-brand-blue/80 bg-clip-text text-transparent">Total Operational <span class="text-brand-blue">Control.</span></span>
        </h2>
      </div>

      <!-- FOOTER BAWAH KIRI -->
      <div class="relative z-10 pt-4 border-t border-white/10 text-xs text-slate-400 font-medium flex items-center justify-center text-center">
        <span>Development by NI Studio Tech</span>
      </div>
    </div>

  </div>

  <!-- JAVASCRIPT ANIMASI -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const overlay = document.getElementById('pageLoaderOverlay');
      const statusText = document.getElementById('loaderStatusText');
      const heroSection = document.getElementById('heroSection');

      if (!overlay || !heroSection) return;

      setTimeout(() => {
        if (statusText) statusText.innerText = "CentraDesk Ready.";
      }, 1200);

      setTimeout(() => {
        overlay.classList.add('opacity-0', 'pointer-events-none');
        
        setTimeout(() => {
          if (window.innerWidth >= 768) {
            heroSection.style.left = '50%';
          } else {
            heroSection.style.left = '0';
            heroSection.style.top = '50%';
          }
        }, 100);

        setTimeout(() => {
          overlay.remove();
        }, 500);
      }, 2000);
    });

    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const eyeOpen = document.getElementById('eyeOpenIcon');
      const eyeClosed = document.getElementById('eyeClosedIcon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
      } else {
        passwordField.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
      }
    }

    function handleFormSubmit() {
      const btn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');
      const btnArrow = document.getElementById('btnArrow');
      const btnSpinner = document.getElementById('btnSpinner');
      const btnLoadingText = document.getElementById('btnLoadingText');

      btnText.classList.add('hidden');
      btnArrow.classList.add('hidden');
      btnSpinner.classList.remove('hidden');
      btnLoadingText.classList.remove('hidden');

      btn.disabled = true;
      btn.classList.add('opacity-80', 'cursor-not-allowed');
    }
  </script>

</body>
</html>