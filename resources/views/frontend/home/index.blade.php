<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Novex Peptides | Precision in Every Molecule</title>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  darkMode: ['selector', '[data-theme="dark"]'],
  theme: {
    extend: {
      fontFamily: {
        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      keyframes: {
        mq: {
          to: { transform: 'translateX(-50%)' }
        },
        cartPop: {
          '0%': { transform: 'scale(1)' },
          '50%': { transform: 'scale(1.3)' },
          '100%': { transform: 'scale(1)' }
        }
      },
      animation: {
        mq: 'mq 34s linear infinite',
        cartPop: 'cartPop 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
      }
    }
  }
}
</script>

<script>
(function() {
  var t = 'light';
  try { if (localStorage.getItem('nvx_theme') === 'dark') t = 'dark'; } catch (e) {}
  document.documentElement.setAttribute('data-theme', t);
})();
</script>
</head>
<body class="bg-white dark:bg-[#0A111A] text-[#1E2D3B] dark:text-[#F0F6FC] font-sans text-[15px] leading-[1.65] overflow-x-hidden transition-colors duration-200">

<div class="top bg-[#2F6F9F] text-[#E3EFF8] dark:bg-[#071018] dark:border-b dark:border-[#1C2D3E] dark:text-[#9FB9D0] text-xs text-center py-[7px] px-3 tracking-[0.03em] transition-colors duration-200">
  Made in USA. High Purity. Research Graded. Cold chain shipping worldwide.
</div>

@php
    $fromOrigin = request()->input('from');
    $isFromStore = in_array($fromOrigin, ['premium', 'performance']);

    $isCatalogActive = !$isFromStore && (
        request()->routeIs('products.*') || 
        request()->routeIs('accessory*') || 
        request()->is('products*') || 
        request()->is('accessory*')
    );

    $isStoreActive = $isFromStore || 
        request()->is('performance*') || 
        request()->is('premium*') || 
        request()->routeIs('performance*') || 
        request()->routeIs('premium*');
@endphp

<header class="sticky top-0 z-[100] bg-white/[0.98] dark:bg-[#0A111A]/[0.97] border-b border-[#D2E2EF] dark:border-[#1C2D3E] shadow-[0_2px_8px_rgba(0,0,0,0.03)] m-0 transition-colors duration-200">
  <div class="bar max-w-[1200px] mx-auto px-4 sm:px-6 relative flex min-[1081px]:grid min-[1081px]:grid-cols-[1fr_auto_1fr] justify-between items-center h-[68px] min-[1081px]:h-[78px] gap-5">
    
    <nav class="dnav hidden min-[1081px]:flex items-center gap-6 text-[13px] font-medium">
      <a href="{{ route('home') }}" class="py-1.5 border-b transition-colors duration-200 {{ (request()->routeIs('home') && !request()->is('performance*') && !request()->is('premium*') && !$isFromStore) ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Home</a>
      <a href="{{ route('about') }}" class="py-1.5 border-b transition-colors duration-200 {{ request()->routeIs('about') ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">About</a>

      <div class="dd relative group" id="ddCatalog">
        <button type="button" class="dd-trigger py-1.5 border-b inline-flex items-center gap-[5px] cursor-pointer transition-colors duration-200 {{ $isCatalogActive ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent text-inherit hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }} group-hover:border-[#3F84B5] dark:group-hover:border-[#5CA5DA] group-hover:text-[#2F6F9F] dark:group-hover:text-[#327BB3]" onclick="toggleDD(event,'ddCatalog')" aria-haspopup="true">
          Catalog <svg class="w-3 h-3 stroke-current fill-none stroke-[2.4] stroke-round transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="dd-menu hidden group-hover:block group-focus-within:block absolute top-full left-0 pt-3 z-[120]">
          <div class="dd-box min-w-[260px] bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[16px] p-1.5 shadow-[0_14px_34px_rgba(0,0,0,0.16)] flex flex-col gap-0.5">
            <a href="{{ route('products.index') }}" class="block py-[11px] px-3.5 rounded-[10px] text-xs font-semibold tracking-[0.04em] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-150 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]">Products</a>
            <a href="{{ route('accessory') }}" class="block py-[11px] px-3.5 rounded-[10px] text-xs font-semibold tracking-[0.04em] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-150 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]">Accessory</a>
          </div>
        </div>
      </div>

      <div class="dd relative group" id="ddStore">
        <button type="button" class="dd-trigger py-1.5 border-b inline-flex items-center gap-[5px] cursor-pointer transition-colors duration-200 {{ $isStoreActive ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent text-inherit hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }} group-hover:border-[#3F84B5] dark:group-hover:border-[#5CA5DA] group-hover:text-[#2F6F9F] dark:group-hover:text-[#327BB3]" onclick="toggleDD(event,'ddStore')" aria-haspopup="true">
          Novex Store <svg class="w-3 h-3 stroke-current fill-none stroke-[2.4] stroke-round transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="dd-menu hidden group-hover:block group-focus-within:block absolute top-full left-0 pt-3 z-[120]">
          <div class="dd-box min-w-[260px] bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[16px] p-1.5 shadow-[0_14px_34px_rgba(0,0,0,0.16)] flex flex-col gap-0.5">
            <a href="{{ url('/performance') }}" class="block py-[11px] px-3.5 rounded-[10px] text-xs font-semibold tracking-[0.04em] transition-colors duration-150 {{ request()->is('performance*') || $fromOrigin === 'performance' ? 'bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3]' : 'text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Novex Performance Division</a>
            <a href="{{ url('/premium') }}" class="block py-[11px] px-3.5 rounded-[10px] text-xs font-semibold tracking-[0.04em] transition-colors duration-150 {{ request()->is('premium*') || $fromOrigin === 'premium' ? 'bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3]' : 'text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Novex Premium Supplements</a>
          </div>
        </div>
      </div>
    </nav>
    
    <a href="{{ route('home') }}" class="logo font-serif text-[24px] min-[1081px]:text-[32px] font-semibold leading-none tracking-[0.06em] text-[#1E2D3B] dark:text-white dark:[text-shadow:0_0_20px_rgba(92,165,218,0.3)] transition-all duration-200 text-left min-[1081px]:text-center select-none">
      NOVEX
      <small class="block font-sans font-medium text-[9px] tracking-[0.26em] min-[1081px]:tracking-[0.38em] mt-[5px] text-[#3F84B5] dark:text-[#5CA5DA] transition-colors duration-200">PEPTIDES</small>
    </a>
    
    <div class="rt flex items-center justify-end gap-2.5 min-[1081px]:gap-5">
      <nav class="dnav hidden min-[1081px]:flex items-center gap-6 text-[13px] font-medium">
        <a href="{{ route('resources') }}" class="py-1.5 border-b transition-colors duration-200 {{ request()->routeIs('resources') ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Resources</a>
        <a href="{{ route('science') }}" class="py-1.5 border-b transition-colors duration-200 {{ request()->routeIs('science') ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Science</a>
        <a href="{{ route('contact') }}" class="py-1.5 border-b transition-colors duration-200 {{ request()->routeIs('contact') ? 'border-[#3F84B5] dark:border-[#5CA5DA] text-[#2F6F9F] dark:text-[#327BB3]' : 'border-transparent hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] hover:text-[#2F6F9F] dark:hover:text-[#327BB3]' }}">Contact</a>
      </nav>

      <div class="tools flex items-center gap-3">
        <button type="button" class="theme-btn w-[38px] h-[38px] rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E] text-[#1E2D3B] dark:text-[#F0F6FC] inline-flex items-center justify-center cursor-pointer transition-all duration-200 shrink-0 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA]" id="themeToggleBtn" onclick="toggleTheme()" aria-label="Switch to dark theme" title="Switch to dark theme">
          <svg class="ico-moon w-[18px] h-[18px] stroke-current fill-none block dark:hidden" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
          <svg class="ico-sun w-[18px] h-[18px] stroke-current fill-none hidden dark:block" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
        </button>

        <button type="button" class="cart-trigger-btn relative bg-transparent border-0 text-[#2F6F9F] dark:text-[#327BB3] p-1.5 inline-flex items-center justify-center cursor-pointer transition-transform duration-200 hover:scale-110" id="headerCartBtn" onclick="openCartDrawer()" aria-label="Shopping Cart">
          <svg class="w-[25px] h-[25px] stroke-[#2F6F9F] dark:stroke-[#327BB3] stroke-2 fill-none stroke-round" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <span class="cart-badge absolute -top-0.5 -right-1.5 bg-[#e11d48] dark:bg-[#f43f5e] text-white rounded-full text-[10px] min-w-[18px] h-[18px] leading-[18px] text-center font-bold px-1 border-2 border-white dark:border-[#132232]" id="cartCount">0</span>
        </button>

        <button type="button" class="burger-btn hidden max-[1080px]:inline-flex items-center justify-center bg-transparent border border-[#D2E2EF] dark:border-[#1C2D3E] p-[7px] rounded-[10px] cursor-pointer text-[#1E2D3B] dark:text-[#F0F6FC] transition-all duration-200 relative z-[105] shrink-0 hover:bg-[#E9F2FA] dark:hover:bg-[#101B27] hover:border-[#3F84B5] dark:hover:border-[#5CA5DA] [&.open_.icon-open]:hidden [&.open_.icon-close]:!block" id="mobileBurgerBtn" onclick="toggleMobileNav(event)" aria-label="Toggle Menu">
          <svg class="icon-open pointer-events-none" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
          <svg class="icon-close pointer-events-none hidden" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="mnav hidden [&.open]:!flex absolute top-full inset-x-0 bg-white/[0.98] dark:bg-[#0A111A]/[0.97] backdrop-blur-[12px] flex-col p-3 px-6 pb-6 border-b border-[#D2E2EF] dark:border-[#1C2D3E] shadow-[0_16px_32px_rgba(14,40,66,0.12)] z-[104] max-h-[calc(100vh-78px)] overflow-y-auto" id="navM">
    <a href="{{ route('home') }}" class="py-3.5 border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[15px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] hover:font-semibold {{ request()->routeIs('home') && !$isFromStore ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}">Home</a>
    <a href="{{ route('about') }}" class="py-3.5 border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[15px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] hover:font-semibold {{ request()->routeIs('about') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}">About</a>

    <div class="m-group flex flex-col pt-1.5">
      <span class="m-group-title block text-[11px] font-bold uppercase tracking-[0.08em] text-[#5A6F82] dark:text-[#8EA4B8] pt-3.5 pb-1">Catalog</span>
      <a class="sub block py-3 pl-3.5 text-sm border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] {{ $isCatalogActive && !request()->routeIs('accessory*') && !request()->is('accessory*') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}" href="{{ route('products.index') }}">Products</a>
      <a class="sub block py-3 pl-3.5 text-sm border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] {{ request()->routeIs('accessory') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}" href="{{ route('accessory') }}">Accessory</a>
    </div>

    <div class="m-group flex flex-col pt-1.5">
      <span class="m-group-title block text-[11px] font-bold uppercase tracking-[0.08em] text-[#5A6F82] dark:text-[#8EA4B8] pt-3.5 pb-1">Novex Store</span>
      <a class="sub block py-3 pl-3.5 text-sm border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] {{ request()->is('performance*') || $fromOrigin === 'performance' ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}" href="{{ url('/performance') }}">Novex Performance Division</a>
      <a class="sub block py-3 pl-3.5 text-sm border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] {{ request()->is('premium*') || $fromOrigin === 'premium' ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}" href="{{ url('/premium') }}">Novex Premium Supplements</a>
    </div>

    <a href="{{ route('resources') }}" class="py-3.5 border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[15px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] hover:font-semibold {{ request()->routeIs('resources') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}">Resources</a>
    <a href="{{ route('science') }}" class="py-3.5 border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[15px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] hover:font-semibold {{ request()->routeIs('science') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}">Science</a>
    <a href="{{ route('contact') }}" class="py-3.5 border-b border-[#D2E2EF] dark:border-[#1C2D3E] text-[15px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC] transition-colors duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3] hover:font-semibold {{ request()->routeIs('contact') ? 'text-[#2F6F9F] dark:text-[#327BB3] font-semibold' : '' }}">Contact</a>
  </nav>
</header>

<main id="app">
@hasSection('content')
    @yield('content')
@else
  <div class="nx-view" id="view-home">
    <section class="hero sl relative h-[calc(100vh-var(--off,110px))] min-h-[480px] sm:min-h-[520px] overflow-hidden text-white flex items-center">
      <div class="slide on absolute inset-0 z-0 opacity-0 transition-opacity duration-1000 ease-in-out flex items-center overflow-hidden [&.on]:opacity-100 [&.on]:z-[1] before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:via-[#0A111A]/[0.4] before:to-[#0A111A]/[0.20]">
        <img id="heroSlide1" src="{{ asset('assets/website/home/hero1.webp') }}" href="{{ asset('assets/website/home/hero1.webp') }}" alt="Hero Banner 1" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05]">
        <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
          <div class="in max-w-[580px]">
            <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Precision in<br>Every Molecule</h1>
            <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Advanced peptide research. Science drives results, with premium quality made in USA.</p>
            <div class="flex items-center flex-wrap gap-2.5">
              <a class="inline-block bg-white text-[#2F6F9F] py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:bg-[#E9F2FA] hover:text-[#245a82]" href="{{ route('products.index') }}">Shop Now</a>
              <a class="inline-block bg-transparent text-white border border-white/85 py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:bg-white/15 hover:border-white" href="{{ route('science') }}">Our Science</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="slide absolute inset-0 z-0 opacity-0 transition-opacity duration-1000 ease-in-out flex items-center overflow-hidden [&.on]:opacity-100 [&.on]:z-[1] before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-r before:from-[#0A111A]/[0.82] before:via-[#0A111A]/[0.4] before:to-[#0A111A]/[0.20]">
        <img id="heroSlide2" src="{{ asset('assets/website/home/hero2.webp') }}" href="{{ asset('assets/website/home/hero2.webp') }}" alt="Hero Banner 2" onerror="this.src='https://images.unsplash.com/photo-1608068811588-3a67006b7489?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D'" class="absolute inset-0 w-full h-full object-cover object-center filter saturate-[1.08] brightness-[1.05]">
        <div class="wrap relative z-[2] w-full max-w-[1200px] mx-auto px-4 sm:px-6">
          <div class="in max-w-[580px]">
            <h1 class="font-serif text-[clamp(34px,5.5vw,72px)] font-medium leading-[1.15] text-white">Certified Purity &<br>Rigorous Assay</h1>
            <p class="max-w-[480px] my-[18px] mb-7 text-base leading-[1.6] text-white opacity-95">Precision micro-pipetting, HPLC chromatographic testing, and batch-level verification.</p>
            <div class="flex items-center flex-wrap gap-2.5">
              <a class="inline-block bg-white text-[#2F6F9F] py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:bg-[#E9F2FA] hover:text-[#245a82]" href="{{ route('products.index') }}">Shop Now</a>
              <a class="inline-block bg-transparent text-white border border-white/85 py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:bg-white/15 hover:border-white" href="{{ route('science') }}">Our Science</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="ctl absolute z-[3] bottom-4 sm:bottom-7 inset-x-0">
        <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6 flex justify-between items-center">
          <div class="dots2 flex gap-2.5">
            <button class="dot w-[26px] sm:w-[34px] h-[3px] sm:h-1 bg-white/40 rounded-full cursor-pointer transition-all duration-300 p-0 border-0 on [&.on]:bg-white [&.on]:w-[36px] sm:[&.on]:w-[44px]" onclick="go(0)" aria-label="Slide 1"></button>
            <button class="dot w-[26px] sm:w-[34px] h-[3px] sm:h-1 bg-white/40 rounded-full cursor-pointer transition-all duration-300 p-0 border-0 [&.on]:bg-white [&.on]:w-[36px] sm:[&.on]:w-[44px]" onclick="go(1)" aria-label="Slide 2"></button>
          </div>
          <div class="arr flex gap-2.5">
            <button class="w-9 sm:w-[42px] h-9 sm:h-[42px] rounded-full bg-[#0A111A]/45 border border-white/60 text-white text-[15px] sm:text-lg flex items-center justify-center cursor-pointer backdrop-blur-[4px] transition-all duration-200 hover:bg-white hover:text-[#2F6F9F]" onclick="go(hi-1)" aria-label="Previous">&#8592;</button>
            <button class="w-9 sm:w-[42px] h-9 sm:h-[42px] rounded-full bg-[#0A111A]/45 border border-white/60 text-white text-[15px] sm:text-lg flex items-center justify-center cursor-pointer backdrop-blur-[4px] transition-all duration-200 hover:bg-white hover:text-[#2F6F9F]" onclick="go(hi+1)" aria-label="Next">&#8594;</button>
          </div>
        </div>
      </div>
    </section>

    <div class="mq overflow-hidden border-b border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824] whitespace-nowrap m-0 transition-colors duration-200">
      <div class="inline-flex gap-11 py-[17px] animate-mq font-serif italic font-medium text-[22px] text-[#1E2D3B] dark:text-[#F0F6FC]">
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Advanced peptide research</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Science drives results</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Third party tested</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Cold chain from vial to door</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Made in USA</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Research grade only</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Advanced peptide research</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Science drives results</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Third party tested</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Cold chain from vial to door</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Made in USA</span>
        <span class="after:content-['✦'] after:not-italic after:text-[11px] after:text-[#3F84B5] dark:after:text-[#5CA5DA] after:ml-11">Research grade only</span>
      </div>
    </div>

    <section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
          <div class="flex flex-col gap-2 max-w-[720px]">
            <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Explore by Series</h2>
            <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px]">Six specialized series engineered for weight management, cellular rejuvenation, performance, and daily care.</p>
          </div>
        </div>
        <div class="g6 grid grid-cols-2 min-[901px]:grid-cols-3 min-[1180px]:grid-cols-6 gap-3 min-[901px]:gap-[18px]">
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.show', 'retatrutide') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c1.webp') }}" alt="Retatrutide">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">01 | Retatrutide</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Weight Management</p>
            </div>
          </a>
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.show', 'reta-plus') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c2.webp') }}" alt="Retatrutide Plus">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">02 | Retatrutide Plus</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Dual Action Formulation</p>
            </div>
          </a>
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.index') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c3.webp') }}" alt="Skincare Peptides">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">03 | Skincare Peptides</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Cellular Rejuvenation</p>
            </div>
          </a>
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.index') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c4.webp') }}" alt="Performance">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">04 | Performance</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Longevity & Power</p>
            </div>
          </a>
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.index') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c5.webp') }}" alt="Novex Skincare">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">05 | Novex Skincare</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Serums & Cream</p>
            </div>
          </a>
          <a class="cat group relative aspect-[3/4] overflow-hidden text-white flex items-end rounded-[26px] bg-slate-900 before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-gradient-to-t before:from-[#0A111A]/85 before:to-transparent before:via-[#0A111A]/40" href="{{ route('products.show', 'jersey-01') }}">
            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('assets/website/category/c6.webp') }}" alt="Athletic Apparel">
            <div class="relative z-[2] p-5">
              <h3 class="font-serif text-lg sm:text-[20px] font-medium leading-[1.15] text-white">06 | Athletic Apparel</h3>
              <p class="text-xs opacity-90 mt-1 text-white">Performance Jersey</p>
            </div>
          </a>
        </div>
      </div>
    </section>

    <section class="sec alt relative py-[52px] bg-cover bg-center bg-no-repeat bg-[linear-gradient(rgba(233,242,250,0.92),rgba(233,242,250,0.95)),url('https://images.unsplash.com/photo-1758685848543-5c8ba81bc822?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D')] dark:bg-[linear-gradient(rgba(10,17,26,0.90),rgba(16,27,39,0.94)),url('https://images.unsplash.com/photo-1758685848543-5c8ba81bc822?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D')] transition-colors duration-300" id="lab-reports">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="head flex justify-center text-center mb-0">
          <div class="flex flex-col items-center text-center max-w-[680px] mx-auto">
            <h2 class="font-serif text-[clamp(28px,4vw,42px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Third-Party Lab Testing &amp; COA Analysis</h2>
            <p class="my-2.5 mb-5 text-[15px] leading-[1.6] text-[#5A6F82] dark:text-[#8EA4B8]">
              Every batch is independently tested via HPLC and Mass Spectrometry to guarantee purity above 99% and authentic molecular sequence.
            </p>
            <a class="inline-block bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#266391] dark:hover:bg-[#286391] text-white py-3 px-8 text-[13px] font-semibold tracking-[0.04em] rounded-full text-center transition-all duration-200" href="{{ route('science') }}">See Lab Reports →</a>
          </div>
        </div>
      </div>
    </section>

    <section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200" id="testimonies">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="t-single-grid grid grid-cols-1 min-[961px]:grid-cols-[1.24fr_1fr] gap-8 min-[961px]:gap-11 items-center">
          <div class="t-slider-wrap relative w-full max-w-[540px] mx-auto">
            <div class="t-slider relative w-full rounded-[24px] overflow-hidden border border-[#D2E2EF] dark:border-[#1C2D3E] bg-transparent shadow-[0_12px_32px_rgba(14,40,66,0.07)]" id="transformSlider">
              <div class="t-slides grid grid-cols-1 w-full">
                @for ($i = 2; $i <= 8; $i++)
                  @php
                    $tFilename = 't' . $i . '.webp';
                    $tDiskPath = public_path($tFilename);
                    $tVersion = file_exists($tDiskPath) ? filemtime($tDiskPath) : time();
                    $tFullUrl = asset($tFilename) . '?v=' . $tVersion;
                  @endphp
                  <a href="{{ $tFullUrl }}" onclick="openLightboxModal('{{ $tFullUrl }}', 'Client Transformation #{{ $i }} - Real Results'); return false;" class="t-slide group [grid-column:1] [grid-row:1] w-full opacity-0 pointer-events-none transition-opacity duration-500 ease-in-out block cursor-pointer rounded-[inherit] relative {{ $i === 2 ? 'active !opacity-100 !pointer-events-auto !z-[2]' : '' }}">
                    <img src="{{ $tFullUrl }}" alt="Client Transformation {{ $i }}" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700'" class="w-full h-auto block rounded-[inherit] transition-transform duration-400 ease-out group-hover:scale-[1.015]">
                    <div class="t-badge-zoom absolute top-3 right-3 bg-[#142332]/[0.78] backdrop-blur-[6px] text-white text-[11px] font-semibold py-[5px] px-3 rounded-full flex items-center gap-[5px] z-[3] pointer-events-none">
                      <svg class="w-[13px] h-[13px] stroke-white fill-none stroke-[2.2]" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                      <span>Enlarge</span>
                    </div>
                  </a>
                @endfor
              </div>
            </div>

            <div class="t-dots flex justify-center gap-2 mt-3.5">
              @for ($i = 0; $i < 7; $i++)
                <span class="t-dot w-2 h-2 rounded-full bg-[#D2E2EF] dark:bg-[#1C2D3E] cursor-pointer transition-all duration-250 {{ $i === 0 ? 'active !bg-[#2F6F9F] dark:!bg-[#327BB3] !w-[22px]' : '' }}" onclick="setTransformSlide({{ $i }}, event)"></span>
              @endfor
            </div>
          </div>

          <div class="t-single-content flex flex-col gap-4">
            <h2 class="font-serif text-[clamp(28px,4vw,42px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Real Transformations, Proven Results</h2>
            <p class="text-[15px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.65]">Explore real transformation journeys from our community. Consistent protocol adherence with research-grade compounds supports sustained vitality, metabolic balance, and body composition optimisation.</p>
            <div>
              <a class="inline-block bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#266391] dark:hover:bg-[#286391] text-white py-3.5 px-10 text-sm font-semibold rounded-full text-center transition-all duration-200" href="{{ route('products.index') }}">Shop Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="sec alt py-[54px] min-[901px]:py-20 bg-[#E9F2FA] dark:bg-[#101B27] transition-colors duration-200">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
          <div class="flex flex-col gap-2 max-w-[720px]">
            <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Featured Formulations</h2>
            <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px]">High-purity research compounds and advanced formulations verified for laboratory excellence.</p>
          </div>
          <a class="inline-block bg-transparent text-inherit border border-current py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3]" href="{{ route('products.index') }}">View all</a>
        </div>
        
        <div class="g4 grid grid-cols-1 sm:grid-cols-2 min-[901px]:grid-cols-4 gap-6">
          @php
              $resolveImageUrl = function($path) {
                  if (empty($path)) return asset('reta1.webp');
                  if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
                  if (file_exists(public_path($path))) return asset($path);
                  if (file_exists(public_path('uploads/products/' . basename($path)))) {
                      return asset('uploads/products/' . basename($path));
                  }
                  if (file_exists(public_path('storage/' . ltrim($path, '/')))) {
                      return asset('storage/' . ltrim($path, '/'));
                  }
                  return asset($path);
              };

              $items = $featuredProducts ?? \Illuminate\Support\Facades\DB::select(
                  "SELECT * FROM products 
                   WHERE (page_type != 'accessory' OR page_type IS NULL OR page_type = '') 
                     AND (category NOT IN ('Accessory', 'Injection Kit', 'Syringes') OR category IS NULL) 
                   ORDER BY id DESC LIMIT 4"
              );
          @endphp

          @forelse($items as $item)
            @php
                $slides = [];
                if (!empty($item->image)) {
                    $decoded = json_decode($item->image, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $slides = array_values(array_filter($decoded, fn($p) => !empty($p)));
                    } else {
                        $slides = [$item->image];
                    }
                }
                if (empty($slides)) {
                    $slides = ['reta1.webp'];
                }

                $itemSlug = (property_exists($item, 'slug') && !empty($item->slug))
                    ? $item->slug
                    : \Illuminate\Support\Str::slug($item->title ?? ('product-' . $item->id));

                $isItemAcc = (isset($item->page_type) && strtolower($item->page_type) === 'accessory')
                    || in_array($item->category ?? '', ['Accessory', 'Injection Kit', 'Syringes']);

                $detailUrl = $isItemAcc
                    ? (\Illuminate\Support\Facades\Route::has('accessory.show') ? route('accessory.show', $itemSlug) : url('/accessory/' . $itemSlug))
                    : (\Illuminate\Support\Facades\Route::has('products.show') ? route('products.show', $itemSlug) : url('/products/' . $itemSlug));
            @endphp

            <div class="card pc p-3.5 bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[26px] transition-all duration-300 flex flex-col hover:-translate-y-1.5 hover:shadow-[0_24px_44px_-24px_rgba(47,111,159,0.5)]" data-category="{{ $item->category ?? 'Weight Management' }}" data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
              <div class="ph aspect-square rounded-[20px] relative bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] overflow-hidden flex items-center justify-center p-0">
                <div class="prod-slider relative w-full h-full overflow-hidden rounded-[inherit] bg-white dark:bg-[#132232]">
                  <div class="prod-slides relative w-full h-full rounded-[inherit] overflow-hidden bg-white dark:bg-[#132232]">
                    @foreach($slides as $sIdx => $imgSrc)
                      <div class="prod-slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-700 ease-in-out p-3 m-0 overflow-hidden rounded-[inherit] bg-white dark:bg-[#132232] flex items-center justify-center pointer-events-none {{ $sIdx === 0 ? 'active !opacity-100 !pointer-events-auto' : '' }}">
                        <img class="w-auto h-auto max-w-full max-h-full object-contain object-center rounded-[14px] block bg-transparent" src="{{ $resolveImageUrl($imgSrc) }}" alt="{{ $item->title }} {{ $sIdx + 1 }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              @if(count($slides) > 1)
                <div class="ps-dots relative flex justify-center items-center gap-1.5 mt-2.5 mb-0.5 z-[5]">
                  @foreach($slides as $sIdx => $imgSrc)
                    <span class="ps-dot w-[7px] h-[7px] rounded-full bg-[#D2E2EF] dark:bg-[#1C2D3E] cursor-pointer transition-all duration-250 hover:bg-[#5A6F82] {{ $sIdx === 0 ? 'active !bg-[#2F6F9F] dark:!bg-[#327BB3] !w-[18px]' : '' }}" onclick="setCardSlide(this, {{ $sIdx }})"></span>
                  @endforeach
                </div>
              @endif

              <div class="b text-left items-stretch pt-3.5 px-2 pb-2 gap-2 flex flex-col flex-1">
                <h3 class="font-serif text-[20px] leading-[1.2] text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $item->title }}</h3>
                <p class="s text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.4] min-h-[36px]">{{ $item->subtitle ?? '' }}</p>
                <div class="text-[17px] font-bold text-[#2F6F9F] dark:text-[#327BB3] mt-1">{{ $item->price }}</div>
                <div class="meta flex gap-1.5 flex-wrap mt-auto">
                  <span class="text-[11px] font-semibold bg-[#E9F2FA] dark:bg-[#101B27] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $item->dosage_spec ?? 'Standard' }}</span>
                  <span class="text-[11px] bg-[#E9F2FA] dark:bg-[#101B27] text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-2.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $item->badge_category ?? 'Research grade' }}</span>
                </div>
                <a class="btn-details block w-full bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#266391] dark:hover:bg-[#286391] text-white py-3 rounded-full text-[13px] font-semibold text-center mt-2.5 transition-colors duration-200" href="{{ $detailUrl }}">See Details</a>
              </div>
            </div>
          @empty
            <div class="col-span-full text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8] text-sm">
              Formulation catalog is currently being updated.
            </div>
          @endforelse
        </div>

        <div class="div2 grid grid-cols-1 min-[901px]:grid-cols-2 gap-6 mt-12">
          <a class="camp group relative aspect-video text-white flex items-center rounded-[26px] overflow-hidden cursor-pointer border border-[#D2E2EF] dark:border-[#1C2D3E] before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-[#0A111A]/20" href="{{ route('products.index') }}" aria-label="Explore Performance Peptides">
            <img class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-[1.03]" src="{{ asset('f1.webp') }}" alt="Performance Peptides Banner" onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1000&q=85'">
          </a>
          <a class="camp group relative aspect-video text-white flex items-center rounded-[26px] overflow-hidden cursor-pointer border border-[#D2E2EF] dark:border-[#1C2D3E] before:content-[''] before:absolute before:inset-0 before:z-[1] before:bg-[#0A111A]/20" href="{{ route('products.index') }}" aria-label="Explore Peptide Skincare">
            <img class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-[1.03]" src="{{ asset('r1.webp') }}" alt="Skincare Peptides Banner" onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1000&q=85'">
          </a>
        </div>
      </div>
    </section>

    <section class="sec py-[54px] min-[901px]:py-20 bg-white dark:bg-[#0A111A] transition-colors duration-200">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
          <div class="flex flex-col gap-2 max-w-[720px]">
            <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">From the bench to your door</h2>
            <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px]">Four checkpoints every vial passes before it leaves us.</p>
          </div>
        </div>
        <div class="steps grid grid-cols-1 sm:grid-cols-2 min-[901px]:grid-cols-4 gap-[18px]">
          <div class="bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] p-6 transition-colors duration-200">
            <b class="font-serif italic font-medium text-[46px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">01</b>
            <h3 class="my-2.5 mb-2 font-serif text-[23px] text-[#1E2D3B] dark:text-[#F0F6FC]">Synthesis</h3>
            <p class="text-sm text-[#5A6F82] dark:text-[#8EA4B8]">Produced under certified partner cGMP conditions in the USA.</p>
          </div>
          <div class="bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] p-6 transition-colors duration-200">
            <b class="font-serif italic font-medium text-[46px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">02</b>
            <h3 class="my-2.5 mb-2 font-serif text-[23px] text-[#1E2D3B] dark:text-[#F0F6FC]">Testing</h3>
            <p class="text-sm text-[#5A6F82] dark:text-[#8EA4B8]">Third-party testing verifies purity and compound identity via HPLC.</p>
          </div>
          <div class="bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] p-6 transition-colors duration-200">
            <b class="font-serif italic font-medium text-[46px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">03</b>
            <h3 class="my-2.5 mb-2 font-serif text-[23px] text-[#1E2D3B] dark:text-[#F0F6FC]">Cold Storage</h3>
            <p class="text-sm text-[#5A6F82] dark:text-[#8EA4B8]">Stored under continuous temperature-monitored environments.</p>
          </div>
          <div class="bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] p-6 transition-colors duration-200">
            <b class="font-serif italic font-medium text-[46px] leading-none text-[#3F84B5] dark:text-[#5CA5DA]">04</b>
            <h3 class="my-2.5 mb-2 font-serif text-[23px] text-[#1E2D3B] dark:text-[#F0F6FC]">Insulated Dispatch</h3>
            <p class="text-sm text-[#5A6F82] dark:text-[#8EA4B8]">Express courier cold-chain dispatch directly to your institution.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="sec alt py-[54px] min-[901px]:py-20 bg-[#E9F2FA] dark:bg-[#101B27] transition-colors duration-200">
      <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
        <div class="head flex justify-between items-end mb-9 gap-5 flex-wrap">
          <div class="flex flex-col gap-2 max-w-[720px]">
            <h2 class="font-serif text-[clamp(26px,3.8vw,44px)] font-medium leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC]">Latest Science Articles</h2>
            <p class="text-[#5A6F82] dark:text-[#8EA4B8] text-[15px]">Carefully curated scientific literature, compound mechanisms, and laboratory research notes.</p>
          </div>
          <a class="inline-block bg-transparent text-inherit border border-current py-3 px-[26px] text-[13px] font-medium tracking-[0.04em] rounded-full text-center transition-all duration-200 hover:text-[#2F6F9F] dark:hover:text-[#327BB3]" href="{{ route('resources') }}">All articles</a>
        </div>
        
        <div class="g4 grid grid-cols-1 sm:grid-cols-2 min-[901px]:grid-cols-4 gap-6">
          @php
              $resolveArticleImg = function($path) {
                  if (empty($path)) return asset('assets/website/science/s1.webp');
                  if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
                  $clean = ltrim($path, '/');
                  if (file_exists(public_path($clean))) return asset($clean) . '?v=' . filemtime(public_path($clean));
                  if (file_exists(public_path('uploads/resources/' . basename($clean)))) {
                      return asset('uploads/resources/' . basename($clean)) . '?v=' . time();
                  }
                  return asset($clean);
              };

              $homeArticles = \Illuminate\Support\Facades\Schema::hasTable('resources')
                  ? \Illuminate\Support\Facades\DB::select("SELECT * FROM resources ORDER BY id DESC LIMIT 4")
                  : [];
          @endphp

          @forelse($homeArticles as $art)
            @php
                $artSlug = !empty($art->slug) ? $art->slug : \Illuminate\Support\Str::slug($art->title ?? ('article-' . $art->id));
                $artImg = $resolveArticleImg($art->image);
                $artUrl = \Illuminate\Support\Facades\Route::has('resources.show')
                    ? route('resources.show', $artSlug)
                    : url('/resources/' . $artSlug);
            @endphp
            <a class="card group bg-white dark:bg-[#132232] border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-[24px] overflow-hidden flex flex-col no-underline transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" href="{{ $artUrl }}">
              <div class="ph aspect-[16/10] overflow-hidden bg-white dark:bg-[#132232]">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $artImg }}" alt="{{ $art->title }}" loading="lazy" onerror="this.src='{{ asset('assets/website/science/s1.webp') }}'">
              </div>
              <div class="b p-[18px] flex flex-col flex-1">
                <h3 class="font-serif text-[20px] leading-[1.25] text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $art->title }}</h3>
                @if(!empty($art->subtitle))
                  <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mt-1.5 leading-[1.55] line-clamp-2">
                    {{ $art->subtitle }}
                  </p>
                @endif
                <span class="text-xs font-semibold text-[#2F6F9F] dark:text-[#327BB3] mt-auto pt-2.5 flex items-center gap-1">Read Article &rarr;</span>
              </div>
            </a>
          @empty
            <div class="col-span-full text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8] text-sm">
              Belum ada artikel riset yang dipublikasikan saat ini.
            </div>
          @endforelse
        </div>
      </div>
    </section>
  </div>
@endif
</main>

<div class="t-lightbox fixed inset-0 bg-[#0A111A]/88 backdrop-blur-[8px] z-[9999] hidden [&.open]:flex items-center justify-center p-5" id="tLightbox" onclick="if(event.target===this)closeLightboxModal()">
  <div class="t-lightbox-inner relative max-w-[960px] w-full bg-white dark:bg-[#132232] rounded-[24px] p-4 shadow-[0_25px_60px_rgba(0,0,0,0.5)] flex flex-col gap-2.5 border border-[#D2E2EF] dark:border-[#1C2D3E]">
    <button class="t-lightbox-close absolute -top-3.5 -right-3.5 w-[38px] h-[38px] rounded-full bg-white dark:bg-[#132232] text-[#1E2D3B] dark:text-[#F0F6FC] text-[22px] font-semibold shadow-[0_6px_16px_rgba(0,0,0,0.25)] flex items-center justify-center cursor-pointer border border-[#D2E2EF] dark:border-[#1C2D3E] hover:scale-105 transition-transform" onclick="closeLightboxModal()" aria-label="Close">&times;</button>
    <img id="tLightboxImg" src="" alt="Enlarged Document" class="w-full h-auto max-h-[80vh] object-contain rounded-[16px] bg-white dark:bg-[#132232]">
    <div id="tLightboxTitle" class="t-lightbox-title text-sm font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] py-1 px-1.5 text-center"></div>
  </div>
</div>

@php
    $orgInfo = \Illuminate\Support\Facades\Schema::hasTable('organization_info')
        ? \Illuminate\Support\Facades\DB::table('organization_info')->first()
        : null;

    $orgPhone = $orgInfo->phone_number ?? '+60 11-2549 0484';
    $orgEmail = $orgInfo->email ?? 'support@novexsupps.com';
    $orgIg = $orgInfo->instagram_url ?? 'https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==';
    $orgTiktok = $orgInfo->tiktok_url ?? 'https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1';
    
    $cleanWaPhone = preg_replace('/[^0-9]/', '', $orgPhone);
@endphp

<div class="toast fixed bottom-6 left-1/2 -translate-x-1/2 translate-y-[100px] bg-[#1E2D3B] dark:bg-[#F0F6FC] text-white dark:text-[#0A111A] py-3 px-6 rounded-full text-[13px] font-medium shadow-[0_10px_25px_rgba(0,0,0,0.2)] z-[9999] opacity-0 transition-all duration-300 pointer-events-none [&.show]:translate-y-0 [&.show]:opacity-100" id="toastMsg">✓ Added to cart</div>

<div class="cart-overlay fixed inset-0 bg-black/50 z-[999] hidden [&.open]:block backdrop-blur-[3px]" id="cartOverlay" onclick="closeCartDrawer()"></div>
<div class="cart-drawer fixed right-0 top-0 bottom-0 w-full max-w-[460px] max-sm:max-w-full bg-white dark:bg-[#132232] text-[#1E2D3B] dark:text-[#F0F6FC] z-[1000] translate-x-full transition-transform duration-300 ease-in-out flex flex-col shadow-[-10px_0_30px_rgba(0,0,0,0.15)] dark:shadow-[-10px_0_30px_rgba(0,0,0,0.5)] [&.open]:translate-x-0" id="cartDrawer">
  <div class="cart-header py-5 px-[22px] border-b border-[#D2E2EF] dark:border-[#1C2D3E] flex justify-between items-center">
    <h3 class="font-serif text-[22px] font-medium text-[#1E2D3B] dark:text-[#F0F6FC]">Your Research Cart</h3>
    <button onclick="closeCartDrawer()" class="bg-transparent border-0 text-2xl text-[#5A6F82] dark:text-[#8EA4B8] cursor-pointer hover:text-red-500">&times;</button>
  </div>
  <div class="cart-items p-[18px_22px] overflow-y-auto flex-1 flex flex-col gap-3.5" id="cartItemsList"></div>
  <div class="cart-footer py-5 px-[22px] border-t border-[#D2E2EF] dark:border-[#1C2D3E] bg-[#F6FAFD] dark:bg-[#0E1824]">
    <div class="cart-total-row flex justify-between items-center mb-4 text-base text-[#1E2D3B] dark:text-[#F0F6FC]">
      <span class="font-semibold">Total Order:</span>
      <span class="cart-total-price font-serif text-2xl font-bold text-[#2F6F9F] dark:text-[#327BB3]" id="cartTotal">RM 0.00</span>
    </div>
    <button class="btn-wa-proceed w-full bg-[#25D366] hover:bg-[#1ebe5a] text-white py-[15px] px-4 rounded-full font-bold text-sm flex items-center justify-center gap-2.5 transition-colors border-0 cursor-pointer shadow-md" onclick="proceedToWhatsApp()">
      <svg class="w-5 h-5 fill-white" viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
      Click To Proceed
    </button>
  </div>
</div>

<footer class="bg-[#2F6F9F] dark:bg-[#070D14] text-[#E3EFF8] dark:text-[#C8DCEE] pt-[60px] pb-6 text-[13px] dark:border-t dark:border-[#1C2D3E] transition-colors duration-200">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="fg grid grid-cols-1 min-[901px]:grid-cols-[1.5fr_1fr_1.3fr_1.2fr] gap-8">
      <div>
        <h4 class="font-serif text-[20px] font-medium mb-3 text-white">Novex Peptides</h4>
        <p>Advanced peptide research for performance, longevity and aesthetic health.</p>
      </div>
      <div>
        <h4 class="font-serif text-[20px] font-medium mb-3 text-white">Support</h4>
        <ul class="space-y-1.5 list-none">
          <li><a class="hover:underline" href="{{ route('contact') }}">FAQ</a></li>
          <li><a class="hover:underline" href="{{ route('contact') }}">Shipping &amp; Delivery</a></li>
          <li><a class="hover:underline" href="{{ route('contact') }}">Order Tracking</a></li>
          <li><a class="hover:underline" href="{{ route('contact') }}">Return Policy</a></li>
          <li><a class="hover:underline" href="{{ route('contact') }}">Terms &amp; Conditions</a></li>
          <li><a class="hover:underline" href="{{ route('contact') }}">Privacy Policy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-serif text-[20px] font-medium mb-3 text-white">Follow Us</h4>
        <div class="social-links flex flex-col gap-2.5 mt-2">
          <a href="{{ $orgIg }}" target="_blank" rel="noopener" class="social-link inline-flex items-center gap-2.5 text-[#E3EFF8] text-[13px] font-medium transition-all duration-200 py-[7px] px-3.5 bg-white/[0.09] dark:bg-white/[0.06] dark:border dark:border-[#1C2D3E] rounded-[12px] w-fit hover:bg-white/20 hover:text-white hover:-translate-y-0.5" aria-label="Follow us on Instagram">
            <svg class="shrink-0 w-5 h-5 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <span>Instagram</span>
          </a>
          <a href="{{ $orgTiktok }}" target="_blank" rel="noopener" class="social-link inline-flex items-center gap-2.5 text-[#E3EFF8] text-[13px] font-medium transition-all duration-200 py-[7px] px-3.5 bg-white/[0.09] dark:bg-white/[0.06] dark:border dark:border-[#1C2D3E] rounded-[12px] w-fit hover:bg-white/20 hover:text-white hover:-translate-y-0.5" aria-label="Follow us on TikTok">
            <svg class="shrink-0 w-5 h-5 fill-current" viewBox="0 0 24 24">
              <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.86.12V9.37a6.34 6.34 0 0 0-.86-.06A6.33 6.33 0 0 0 3.1 15.64a6.34 6.34 0 0 0 10.82 4.48 6.27 6.27 0 0 0 1.89-4.48V8.78a8.28 8.28 0 0 0 4.78 1.5V6.82a4.84 4.84 0 0 1-1-.13z"/>
            </svg>
            <span>TikTok</span>
          </a>
        </div>
      </div>
      <div>
        <h4 class="font-serif text-[20px] font-medium mb-3 text-white">Contact Desk</h4>
        <p>Direct WhatsApp &amp; Inquiries:<br><b><a class="hover:underline" href="https://wa.me/{{ $cleanWaPhone }}" target="_blank" rel="noopener">{{ $orgPhone }}</a></b></p>
        <p class="mt-2">Email Support:<br><b><a class="hover:underline" href="mailto:{{ $orgEmail }}">{{ $orgEmail }}</a></b></p>
      </div>
    </div>
    <div class="copy border-t border-white/20 dark:border-[#1C2D3E] mt-10 pt-[18px] flex justify-between flex-wrap gap-2 opacity-85 dark:text-[#8EA4B8]">
      <span>© 2026 Novex Peptides. All rights reserved.</span>
    </div>
  </div>
</footer>

<script>
const WA = "{{ $cleanWaPhone ?: '601112085054' }}";

function applyTheme(mode) {
  const theme = (mode === 'dark') ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', theme);
  const btn = document.getElementById('themeToggleBtn');
  if (btn) {
    const label = 'Switch to ' + (theme === 'dark' ? 'light' : 'dark') + ' theme';
    btn.setAttribute('aria-label', label);
    btn.setAttribute('title', label);
  }
}

function toggleTheme() {
  const cur = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  const next = cur === 'dark' ? 'light' : 'dark';
  try { localStorage.setItem('nvx_theme', next); } catch (e) {}
  applyTheme(next);
}

function toggleDD(e, id) {
  if (e) { e.preventDefault(); e.stopPropagation(); }
  if (window.matchMedia('(hover:hover)').matches) return;
  const el = document.getElementById(id);
  document.querySelectorAll('.dd.open').forEach(d => { if (d !== el) d.classList.remove('open'); });
  if (el) el.classList.toggle('open');
}

function closeDD() {
  document.querySelectorAll('.dd.open').forEach(d => d.classList.remove('open'));
}

function toggleMobileNav(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) {
    const isOpen = navM.classList.toggle('open');
    if (btn) btn.classList.toggle('open', isOpen);
  }
}

function closeMobileNav() {
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) navM.classList.remove('open');
  if (btn) btn.classList.remove('open');
}

document.addEventListener('keydown', (e) => { 
  if (e.key === 'Escape') {
    closeDD();
    closeCartDrawer();
  }
});

document.addEventListener('click', (e) => {
  if (!e.target.closest('.dd')) closeDD();
  const navM = document.getElementById('navM');
  const burgerBtn = document.getElementById('mobileBurgerBtn');
  if (navM && navM.classList.contains('open')) {
    if (!navM.contains(e.target) && burgerBtn && !burgerBtn.contains(e.target)) {
      closeMobileNav();
    }
  }
});

let hi = 0, ht;
function go(n){
  const slides = document.querySelectorAll('.hero.sl .slide');
  const dots = document.querySelectorAll('.hero.sl .dot');
  if(!slides.length) return;
  hi = (n + slides.length) % slides.length;
  slides.forEach((x, i) => x.classList.toggle('on', i === hi));
  dots.forEach((d, i) => d.classList.toggle('on', i === hi));
}

function updateHomeHeroBanners(){
  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const s1 = document.getElementById('heroSlide1');
  const s2 = document.getElementById('heroSlide2');

  if (s1) {
    const url1 = isPortraitOrSmall
      ? "{{ asset('assets/website/home/hero1-phone.webp') }}"
      : "{{ asset('assets/website/home/hero1.webp') }}";
    if (s1.getAttribute('src') !== url1) s1.setAttribute('src', url1);
    if (s1.getAttribute('href') !== url1) s1.setAttribute('href', url1);
  }

  if (s2) {
    const url2 = isPortraitOrSmall
      ? "{{ asset('assets/website/home/hero2-phone.webp') }}"
      : "{{ asset('assets/website/home/hero2.webp') }}";
    if (s2.getAttribute('src') !== url2) s2.setAttribute('src', url2);
    if (s2.getAttribute('href') !== url2) s2.setAttribute('href', url2);
  }
}

const homeHeroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (homeHeroMediaQuery.addEventListener) {
  homeHeroMediaQuery.addEventListener('change', updateHomeHeroBanners);
} else if (homeHeroMediaQuery.addListener) {
  homeHeroMediaQuery.addListener(updateHomeHeroBanners);
}
window.addEventListener('resize', updateHomeHeroBanners);

function setCardSlide(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const card = dot.closest('.card') || dot.closest('.pc');
  if(!card) return;
  const slider = card.querySelector('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

var prodSlideTimer = null;
function startProdAutoSlide(){
  clearInterval(prodSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  prodSlideTimer = setInterval(() => {
    document.querySelectorAll('.card.pc').forEach(box => {
      const slides = box.querySelectorAll('.prod-slide');
      const dots = box.querySelectorAll('.ps-dot');
      if(slides.length < 2) return;
      let cur = 0;
      slides.forEach((s, idx) => { if(s.classList.contains('active')) cur = idx; });
      let next = (cur + 1) % slides.length;
      slides.forEach((s, idx) => s.classList.toggle('active', idx === next));
      dots.forEach((d, idx) => d.classList.toggle('active', idx === next));
    });
  }, 4500);
}

let tSlideIndex = 0;
const totalTSlides = 7;
let tSlideTimer = null;

function setTransformSlide(idx, e){
  if(e){
    e.preventDefault();
    e.stopPropagation();
  }
  tSlideIndex = (idx + totalTSlides) % totalTSlides;
  document.querySelectorAll('.t-slide').forEach((s, i) => {
    s.classList.toggle('active', i === tSlideIndex);
  });
  document.querySelectorAll('.t-dot').forEach((d, i) => {
    d.classList.toggle('active', i === tSlideIndex);
  });
}

function startTransformTimer(){
  clearInterval(tSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  tSlideTimer = setInterval(() => {
    setTransformSlide(tSlideIndex + 1);
  }, 4500);
}

function openLightboxModal(src, title=''){
  const m = document.getElementById('tLightbox');
  const im = document.getElementById('tLightboxImg');
  const t = document.getElementById('tLightboxTitle');
  if(m && im){
    im.src = src;
    if(t) t.innerText = title;
    m.classList.add('open');
  }
}

function closeLightboxModal(){
  const m = document.getElementById('tLightbox');
  if(m) m.classList.remove('open');
}

window.CART = [];
try {
  window.CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
} catch(e) {
  window.CART = [];
}

function syncCartFromStorage(){
  try {
    window.CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
  } catch(e) {
    window.CART = [];
  }
}

function saveCart(){
  localStorage.setItem('nvx_cart', JSON.stringify(window.CART));
  updateCartBadge();
}

function updateCartBadge(){
  syncCartFromStorage();
  const count = window.CART.reduce((acc,item)=>acc + (parseInt(item.qty, 10) || 1), 0);
  const badge = document.getElementById('cartCount');
  if(badge) badge.innerText = count;
}

function openCartDrawer(){
  syncCartFromStorage();
  renderCart();
  document.getElementById('cartOverlay').classList.add('open');
  document.getElementById('cartDrawer').classList.add('open');
}

function closeCartDrawer(){
  document.getElementById('cartOverlay').classList.remove('open');
  document.getElementById('cartDrawer').classList.remove('open');
}

function changeCartQty(index, delta){
  syncCartFromStorage();
  if(!window.CART[index]) return;
  window.CART[index].qty += delta;
  if(window.CART[index].qty <= 0){
    window.CART.splice(index, 1);
  }
  saveCart();
  renderCart();
}

function removeCartItem(index){
  syncCartFromStorage();
  if(!window.CART[index]) return;
  window.CART.splice(index, 1);
  saveCart();
  renderCart();
  showToast('Item removed from cart');
}

function resolveCartImg(src) {
  if (!src) return "{{ asset('reta1.webp') }}";
  if (src.startsWith('http://') || src.startsWith('https://')) return src;
  if (src.startsWith('/')) return src;
  return "{{ asset('') }}" + src.replace(/^\/+/, '');
}

function renderCart(){
  const listEl = document.getElementById('cartItemsList');
  const totalEl = document.getElementById('cartTotal');
  if(!listEl) return;

  if(window.CART.length === 0){
    listEl.innerHTML = `<div class="text-center py-12 text-[#5A6F82] dark:text-[#8EA4B8]"><p class="text-base mb-2">Your cart is empty.</p><a href="{{ route('products.index') }}" onclick="closeCartDrawer()" class="inline-block bg-[#2F6F9F] text-white py-2 px-5 text-xs rounded-full">Explore Products</a></div>`;
    totalEl.innerText = 'RM 0.00';
    return;
  }

  let total = 0;
  listEl.innerHTML = window.CART.map((item, idx)=>{
    const itemVal = parseFloat(item.val || item.price || 0);
    const itemQty = parseInt(item.qty, 10) || 1;
    const subtotal = itemVal * itemQty;
    total += subtotal;
    const detailLabel = item.size ? item.size : (item.s || '');
    const name = item.n || item.name || 'Product';
    const imgSrc = resolveCartImg(item.i || item.img || '');

    return `
      <div class="cart-item grid grid-cols-[52px_1fr_auto_auto] sm:grid-cols-[60px_1fr_auto_auto] gap-2 sm:gap-3 items-center border-b border-[#D2E2EF] dark:border-[#1C2D3E] pb-3.5">
        <div class="cart-item-img aspect-square rounded-[12px] overflow-hidden bg-white border border-[#D2E2EF] dark:border-[#1C2D3E] flex items-center justify-center p-1">
          <img class="w-full h-full object-contain" src="${imgSrc}" alt="${name}" onerror="this.src='{{ asset('reta1.webp') }}'">
        </div>
        <div>
          <h4 class="font-serif text-sm font-semibold text-[#1E2D3B] dark:text-[#F0F6FC] leading-tight mb-1">${name}</h4>
          <span class="text-xs text-[#5A6F82] dark:text-[#8EA4B8]">${detailLabel ? detailLabel + ' • ' : ''}RM ${itemVal.toFixed(2)}</span>
          <div class="text-[13px] font-bold text-[#2F6F9F] dark:text-[#327BB3] mt-1">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box inline-flex items-center border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-full bg-[#F6FAFD] dark:bg-[#0E1824] overflow-hidden scale-[0.85] origin-center">
            <button class="w-10 h-10 bg-transparent text-[17px] font-semibold flex items-center justify-center cursor-pointer border-0 text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27]" onclick="changeCartQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input class="w-[46px] text-center border-0 bg-transparent font-semibold text-sm text-[#1E2D3B] dark:text-[#F0F6FC] focus:outline-none" type="text" readonly value="${itemQty}">
            <button class="w-10 h-10 bg-transparent text-[17px] font-semibold flex items-center justify-center cursor-pointer border-0 text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27]" onclick="changeCartQty(${idx}, 1)" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div>
          <button type="button" class="cart-del-btn bg-transparent border-0 text-[#e11d48] dark:text-[#f43f5e] p-2 cursor-pointer rounded-lg inline-flex items-center justify-center transition-colors hover:bg-rose-100 dark:hover:bg-rose-950/40 hover:text-rose-700" onclick="removeCartItem(${idx})" aria-label="Delete ${name}" title="Delete item">
            <svg class="w-[18px] h-[18px] stroke-current fill-none stroke-2 stroke-round" viewBox="0 0 24 24">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              <line x1="10" y1="11" x2="10" y2="17"></line>
              <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
          </button>
        </div>
      </div>
    `;
  }).join('');

  totalEl.innerText = `RM ${total.toFixed(2)}`;
}

function proceedToWhatsApp(){
  if(window.CART.length === 0){
    alert('Please add products to your cart first.');
    return;
  }

  let total = 0;
  let itemsText = '';
  window.CART.forEach((item, index)=>{
    const itemVal = parseFloat(item.val || item.price || 0);
    const itemQty = parseInt(item.qty, 10) || 1;
    const subtotal = itemVal * itemQty;
    total += subtotal;
    const detail = item.size ? `(${item.size})` : (item.s ? `(${item.s})` : '');
    const name = item.n || item.name || 'Product';
    itemsText += `${index + 1}. *${name}* ${detail}\n   • Quantity: ${itemQty} unit/vial\n   • Price: RM${itemVal.toFixed(2)} x ${itemQty} = RM${subtotal.toFixed(2)}\n\n`;
  });

  const message = 
`Hello Novex Peptides, I would like to place an order for the following items:

${itemsText}*Total Order: RM ${total.toFixed(2)}*

Please confirm stock availability and payment / shipping details. Thank you!`;

  const url = `https://wa.me/${WA}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
}

function showToast(msg){
  const t = document.getElementById('toastMsg');
  if(!t) return;
  t.innerText = msg;
  t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'), 2200);
}

const setOff = () => {
  const topEl = document.querySelector('.top');
  const hdrEl = document.querySelector('header');
  const h = (topEl ? topEl.offsetHeight : 0) + (hdrEl ? hdrEl.offsetHeight : 0);
  document.documentElement.style.setProperty('--off', h + 'px');
};

window.addEventListener('resize', setOff);
document.addEventListener('DOMContentLoaded', () => {
  setOff();
  applyTheme(document.documentElement.getAttribute('data-theme'));
  updateCartBadge();
  updateHomeHeroBanners();

  if(document.querySelector('.hero.sl .slide')){
    ht = setInterval(() => go(hi + 1), 7000);
  }
  startProdAutoSlide();
  startTransformTimer();

  const transformBox = document.getElementById('transformSlider');
  if(transformBox){
    transformBox.addEventListener('mouseenter', () => clearInterval(tSlideTimer));
    transformBox.addEventListener('mouseleave', () => startTransformTimer());
  }
});
</script>
</body>
</html>