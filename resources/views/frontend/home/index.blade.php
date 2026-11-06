<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }

    function getConsent() {
      try { return localStorage.getItem('nvx_cookie_consent'); } catch (e) { return null; }
    }
    function setConsent(v) {
      try { localStorage.setItem('nvx_cookie_consent', v); } catch (e) { }
    }

    function loadGA4() {
      if (window.ga4Initialized) return;
      window.ga4Initialized = true;

      var script = document.createElement('script');
      script.async = true;
      script.src = 'https://www.googletagmanager.com/gtag/js?id=G-T50LPJRHD4';
      document.head.appendChild(script);

      gtag('js', new Date());
      gtag('config', 'G-T50LPJRHD4');
    }

    if (getConsent() === 'accepted') {
      loadGA4();
    }
  </script>

  @hasSection('seo')
    @yield('seo')
  @else
    <x-seo title="Novex Peptides | Precision in Every Molecule"
      description="Advanced peptide research. Science drives results, with premium quality made in USA. Certified purity and rigorous HPLC assay."
      region="MY-10" placename="Selangor, Malaysia" latitude="3.2384" longitude="101.4278" :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Novex Peptides',
        'url' => url('/'),
        'logo' => asset('logo.png'),
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
          'telephone' => '+601125490484',
          'contactType' => 'customer support',
          'areaServed' => ['MY', 'SG'],
          'availableLanguage' => ['en', 'ms']
        ]
      ]" />
  @endif

  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  @php
    $cssFile = 'frontend/home/home.css';
    $cssVer = file_exists(public_path($cssFile)) ? filemtime(public_path($cssFile)) : time();
  @endphp
  <link rel="stylesheet" href="{{ asset($cssFile) }}?v={{ $cssVer }}">

  <style>
    .cookie-banner {
      position: fixed;
      bottom: 24px;
      left: 20px;
      right: 20px;
      max-width: 440px;
      background-color: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 22px;
      padding: 24px;
      box-shadow: var(--shadow-md);
      z-index: 99999;
      display: none;
      flex-direction: column;
      gap: 12px;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    @media (min-width: 640px) {
      .cookie-banner {
        left: auto;
        right: 24px;
        bottom: 24px;
      }
    }

    .cookie-banner.show {
      display: flex;
    }

    .cookie-title {
      font-family: var(--font-serif);
      font-size: 20px;
      font-weight: 500;
      color: var(--text);
      margin: 0;
    }

    .cookie-desc {
      font-size: 13.5px;
      line-height: 1.6;
      color: var(--text-muted);
      margin: 0;
    }

    .cookie-desc a {
      color: var(--primary);
      text-decoration: underline;
    }

    .cookie-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 4px;
    }

    .cookie-btn-accept {
      flex: 1;
      background-color: var(--primary);
      color: #ffffff;
      border: none;
      padding: 10px 18px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .cookie-btn-accept:hover {
      background-color: var(--primary-hover);
    }

    .cookie-btn-reject {
      flex: 1;
      background-color: var(--bg-alt);
      color: var(--text);
      border: 1px solid var(--border);
      padding: 10px 18px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .cookie-btn-reject:hover {
      background-color: var(--border);
    }
  </style>

  <script>
    (function () {
      var t = 'light';
      try { if (localStorage.getItem('nvx_theme') === 'dark') t = 'dark'; } catch (e) { }
      document.documentElement.setAttribute('data-theme', t);
    })();
  </script>
</head>

<body>

  <div class="top">
    Made in USA. High Purity. Research Graded. Cold chain shipping worldwide.
  </div>

  @php
    $fromOrigin = request()->input('from');
    $isFromStore = in_array($fromOrigin, ['premium', 'performance', 'skin']);

    $isCatalogActive = !$isFromStore && (
      request()->routeIs('products.*') ||
      request()->routeIs('accessory*') ||
      request()->is('products*') ||
      request()->is('accessory*')
    );

    $isStoreActive = $isFromStore ||
      request()->is('performance*') ||
      request()->is('premium*') ||
      request()->is('skin*') ||
      request()->routeIs('performance*') ||
      request()->routeIs('premium*') ||
      request()->routeIs('skin*');

    $orgInfo = \Illuminate\Support\Facades\Schema::hasTable('organization_info')
      ? \Illuminate\Support\Facades\DB::table('organization_info')->first()
      : null;

    $orgPhone = $orgInfo->phone_number ?? '+60 11-2549 0484';
    $orgEmail = $orgInfo->email ?? 'support@novexsupps.com';
    $orgIg = $orgInfo->instagram_url ?? 'https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==';
    $orgTiktok = $orgInfo->tiktok_url ?? 'https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1';

    $cleanWaPhone = preg_replace('/[^0-9]/', '', $orgPhone);
  @endphp

  <header>
    <div class="bar">
      <nav class="dnav">
        <a href="{{ route('home') }}"
          class="{{ (request()->routeIs('home') && !request()->is('performance*') && !request()->is('premium*') && !request()->is('skin*') && !$isFromStore) ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>

        <div class="dd" id="ddCatalog">
          <button type="button" class="dd-trigger {{ $isCatalogActive ? 'active' : '' }}" aria-haspopup="true">
            Catalog <svg viewBox="0 0 24 24">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>
          <div class="dd-menu">
            <div class="dd-strip-wrap">
              <div class="dd-links">
                <a href="{{ route('products.index') }}"
                  class="dd-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                  Products Catalog
                </a>
                <span class="dd-sep"></span>
                <a href="{{ route('accessory') }}"
                  class="dd-link {{ request()->routeIs('accessory') ? 'active' : '' }}">
                  Accessory &amp; Kits
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="dd" id="ddStore">
          <button type="button" class="dd-trigger {{ $isStoreActive ? 'active' : '' }}" aria-haspopup="true">
            Novex Store <svg viewBox="0 0 24 24">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>
          <div class="dd-menu">
            <div class="dd-strip-wrap">
              <div class="dd-links">
                <a href="{{ route('performance') }}"
                  class="dd-link {{ (request()->routeIs('performance') || request()->is('performance')) && !request()->is('performance/show*') ? 'active' : '' }}">
                  Performance Division
                </a>
                <span class="dd-sep"></span>
                <a href="{{ route('premium') }}"
                  class="dd-link {{ (request()->routeIs('premium') || request()->is('premium')) && !request()->is('premium/show*') ? 'active' : '' }}">
                  Premium Supplements
                </a>
                <span class="dd-sep"></span>
                <a href="{{ route('skin') }}"
                  class="dd-link {{ (request()->routeIs('skin') || request()->is('skin')) && !request()->is('skin/show*') ? 'active' : '' }}">
                  Skin Lab
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <a href="{{ route('home') }}" class="logo">
        NOVEX
        <small>PEPTIDES</small>
      </a>

      <div class="rt">
        <nav class="dnav">
          <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'active' : '' }}">Resources</a>
          <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'active' : '' }}">Science</a>
          <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <div class="tools">
          <button type="button" class="theme-btn" id="themeToggleBtn" onclick="toggleTheme()"
            aria-label="Switch to dark theme" title="Switch to dark theme">
            <svg class="ico-moon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
            <svg class="ico-sun" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
          </button>

          <button type="button" class="cart-trigger-btn" id="headerCartBtn" onclick="openCartDrawer()"
            aria-label="Shopping Cart">
            <svg viewBox="0 0 24 24">
              <path d="M5.5 8h13l1.8 12.5a1.5 1.5 0 0 1-1.5 1.5H5.2a1.5 1.5 0 0 1-1.5-1.5L5.5 8z" />
              <path d="M8.8 11V6.2a3.2 3.2 0 0 1 6.4 0V11" />
            </svg>
            <span class="cart-badge" id="cartCount">0</span>
          </button>

          <button type="button" class="burger-btn" id="mobileBurgerBtn" onclick="toggleMobileNav(event)"
            aria-label="Toggle Menu">
            <svg class="icon-open" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2"
              fill="none">
              <line x1="4" y1="6" x2="20" y2="6"></line>
              <line x1="4" y1="12" x2="20" y2="12"></line>
              <line x1="4" y1="18" x2="20" y2="18"></line>
            </svg>
            <svg class="icon-close" viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2"
              fill="none">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <nav class="mnav" id="navM">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') && !$isFromStore ? 'active' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>

      <div class="m-group">
        <span class="m-group-title">Catalog</span>
        <a class="sub {{ $isCatalogActive && !request()->routeIs('accessory*') && !request()->is('accessory*') ? 'active' : '' }}"
          href="{{ route('products.index') }}">Products</a>
        <a class="sub {{ request()->routeIs('accessory') ? 'active' : '' }}"
          href="{{ route('accessory') }}">Accessory</a>
      </div>

      <div class="m-group">
        <span class="m-group-title">Novex Store</span>
        <a class="sub {{ (request()->routeIs('performance') || request()->is('performance')) && !request()->is('performance/show*') ? 'active' : '' }}"
          href="{{ route('performance') }}">Novex Performance Division</a>
        <a class="sub {{ (request()->routeIs('premium') || request()->is('premium')) && !request()->is('premium/show*') ? 'active' : '' }}"
          href="{{ route('premium') }}">Novex Premium Supplements</a>
        <a class="sub {{ (request()->routeIs('skin') || request()->is('skin')) && !request()->is('skin/show*') ? 'active' : '' }}"
          href="{{ route('skin') }}">Novex Skin Lab</a>
      </div>

      <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'active' : '' }}">Resources</a>
      <a href="{{ route('science') }}" class="{{ request()->routeIs('science') ? 'active' : '' }}">Science</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
    </nav>
  </header>

  <main id="app">
    @hasSection('content')
      @yield('content')
    @else
      <div class="nx-view" id="view-home">
        <section class="hero sl">
          <div class="slide on">
            <img id="heroSlide1" src="{{ asset('assets/website/home/hero1.webp') }}"
              alt="Novex Peptides Research Compounds"
              onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
            <div class="wrap">
              <div class="in">
                <h1>Precision in<br>Every Molecule</h1>
                <p>Advanced peptide research. Science drives results, with premium quality made in USA.</p>
                <div class="hero-btns">
                  <a class="hero-btn-primary" href="{{ route('products.index') }}">Shop Now</a>
                  <a class="hero-btn-outline" href="{{ route('science') }}">Our Science</a>
                </div>
              </div>
            </div>
          </div>

          <div class="slide">
            <img id="heroSlide2" src="{{ asset('assets/website/home/hero2.webp') }}" alt="Certified HPLC Assay Testing"
              onerror="this.src='https://images.unsplash.com/photo-1608068811588-3a67006b7489?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D'">
            <div class="wrap">
              <div class="in">
                <h2 class="slide-title-fix">Certified Purity &amp;<br>Rigorous Assay</h2>
                <p>Precision micro-pipetting, HPLC chromatographic testing, and batch-level verification.</p>
                <div class="hero-btns">
                  <a class="hero-btn-primary" href="{{ route('products.index') }}">Shop Now</a>
                  <a class="hero-btn-outline" href="{{ route('science') }}">Our Science</a>
                </div>
              </div>
            </div>
          </div>

          <div class="ctl">
            <div class="wrap ctl-wrap">
              <div class="dots2">
                <button class="dot on" onclick="go(0)" aria-label="Slide 1"></button>
                <button class="dot" onclick="go(1)" aria-label="Slide 2"></button>
              </div>
              <div class="arr">
                <button onclick="go(hi-1)" aria-label="Previous">&#8592;</button>
                <button onclick="go(hi+1)" aria-label="Next">&#8594;</button>
              </div>
            </div>
          </div>
        </section>

        <div class="mq">
          <div class="mq-inner">
            <span>Advanced peptide research</span>
            <span>Science drives results</span>
            <span>Third party tested</span>
            <span>Cold chain from vial to door</span>
            <span>Made in USA</span>
            <span>Research grade only</span>
            <span>Advanced peptide research</span>
            <span>Science drives results</span>
            <span>Third party tested</span>
            <span>Cold chain from vial to door</span>
            <span>Made in USA</span>
            <span>Research grade only</span>
          </div>
        </div>

        <section class="sec">
          <div class="wrap">
            <div class="head">
              <div style="max-width: 720px;">
                <h2 class="sec-title">Explore by Series</h2>
                <p class="sec-desc">Six specialized series engineered for weight management, cellular rejuvenation, performance, and daily care.</p>
              </div>
            </div>

            @php
              $resolveSeriesImg = function ($path) {
                $checkPaths = [
                  $path,
                  'assets/website/category/' . basename($path),
                  'uploads/category/' . basename($path),
                  'uploads/products/' . basename($path),
                ];

                foreach ($checkPaths as $p) {
                  $real = public_path($p);
                  if (file_exists($real)) {
                    return asset($p) . '?v=' . filemtime($real);
                  }
                }
                return asset($path) . '?v=' . time();
              };

              $seriesData = [
                [
                  'num'   => '01',
                  'title' => 'Retatrutide',
                  'desc'  => 'Weight Management',
                  'img'   => 'assets/website/category/c1.webp',
                  'url'   => route('products.show', 'retatrutide'),
                ],
                [
                  'num'   => '02',
                  'title' => 'Retatrutide Plus',
                  'desc'  => 'Dual Action Formulation',
                  'img'   => 'assets/website/category/c2.webp',
                  'url'   => route('products.show', 'reta-plus'),
                ],
                [
                  'num'   => '03',
                  'title' => 'Skincare Peptides',
                  'desc'  => 'Cellular Rejuvenation',
                  'img'   => 'assets/website/category/c3.webp',
                  'url'   => route('products.index'),
                ],
                [
                  'num'   => '04',
                  'title' => 'Performance',
                  'desc'  => 'Longevity & Power',
                  'img'   => 'assets/website/category/c4.webp',
                  'url'   => route('products.index'),
                ],
                [
                  'num'   => '05',
                  'title' => 'Novex Skincare',
                  'desc'  => 'Serums & Cream',
                  'img'   => 'assets/website/category/c5.webp',
                  'url'   => route('products.index'),
                ],
                [
                  'num'   => '06',
                  'title' => 'Athletic Apparel',
                  'desc'  => 'Performance Jersey',
                  'img'   => 'assets/website/category/c6.webp',
                  'url'   => route('products.show', 'jersey-01'),
                ],
              ];
            @endphp

            <div class="g6">
              @foreach($seriesData as $sItem)
                @php 
                  $sImgUrl = $resolveSeriesImg($sItem['img']);
                @endphp
                <a class="cat" href="{{ $sItem['url'] }}">
                  <img src="{{ $sImgUrl }}" alt="{{ $sItem['title'] }} Series" width="400" height="400" loading="lazy">
                  <div class="cat-info">
                    <h3>{{ $sItem['num'] }} | {{ $sItem['title'] }}</h3>
                    <p>{{ $sItem['desc'] }}</p>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </section>

        <section class="sec alt" id="lab-reports">
          <div class="wrap">
            <div class="head" style="justify-content: center; text-align: center; margin-bottom: 0;">
              <div style="max-width: 680px; margin: 0 auto; text-align: center;">
                <h2 class="sec-title">Third-Party Lab Testing &amp; COA Analysis</h2>
                <p class="sec-desc" style="margin: 10px 0 20px;">
                  Every batch is independently tested via HPLC and Mass Spectrometry to guarantee purity above 99% and
                  authentic molecular sequence.
                </p>
                <a class="btn-primary-pill" href="{{ route('science') }}">See Lab Reports &rarr;</a>
              </div>
            </div>
          </div>
        </section>

        <section class="sec" id="testimonies">
          <div class="wrap">
            <div class="t-single-grid">
              <div class="t-slider-wrap">
                <div class="t-slider" id="transformSlider">
                  <div class="t-slides">
                    @for ($i = 2; $i <= 8; $i++)
                      @php
                        $tFilename = 't' . $i . '.webp';
                        $tDiskPath = public_path($tFilename);
                        $tVersion = file_exists($tDiskPath) ? filemtime($tDiskPath) : time();
                        $tFullUrl = asset($tFilename) . '?v=' . $tVersion;
                      @endphp
                      <a href="{{ $tFullUrl }}"
                        onclick="openLightboxModal('{{ $tFullUrl }}', 'Client Transformation #{{ $i }} - Real Results'); return false;"
                        class="t-slide {{ $i === 2 ? 'active' : '' }}">
                        <img src="{{ $tFullUrl }}" alt="Client Transformation Journey {{ $i }}" width="500" height="500"
                          loading="lazy"
                          onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=700'">
                        <div class="t-badge-zoom">
                          <svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                          </svg>
                          <span>Enlarge</span>
                        </div>
                      </a>
                    @endfor
                  </div>
                </div>

                <div class="t-dots">
                  @for ($i = 0; $i < 7; $i++)
                    <span class="t-dot {{ $i === 0 ? 'active' : '' }}" onclick="setTransformSlide({{ $i }}, event)"></span>
                  @endfor
                </div>
              </div>

              <div class="t-single-content">
                <h2 class="sec-title">Real Transformations, Proven Results</h2>
                <p class="sec-desc" style="line-height: 1.65;">Explore real transformation journeys from our community.
                  Consistent protocol adherence with research-grade compounds supports sustained vitality, metabolic
                  balance, and body composition optimisation.</p>
                <div>
                  <a class="btn-primary-pill" style="padding: 14px 40px;" href="{{ route('products.index') }}">Shop
                    Now</a>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="sec alt">
          <div class="wrap">
            <div class="head">
              <div style="max-width: 720px;">
                <h2 class="sec-title">Featured Formulations</h2>
                <p class="sec-desc">High-purity research compounds and advanced formulations verified for laboratory
                  excellence.</p>
              </div>
              <a class="btn-outline-pill" href="{{ route('products.index') }}">View all</a>
            </div>

            <div class="g4">
              @php
                $resolveImageUrl = function ($path) {
                  if (empty($path))
                    return asset('reta1.webp');
                  if (filter_var($path, FILTER_VALIDATE_URL))
                    return $path;
                  if (file_exists(public_path($path)))
                    return asset($path);
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
                   WHERE (page_type NOT IN ('skin', 'accessory', 'premium', 'performance') OR page_type IS NULL OR page_type = '') 
                     AND (category NOT IN ('Skin Lab', 'Accessory', 'Injection Kit', 'Syringes', 'Premium Supplements', 'Supplements', 'Performance Apparel') OR category IS NULL) 
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

                <div class="card pc" data-category="{{ $item->category ?? 'Weight Management' }}"
                  data-keywords="{{ strtolower(($item->keywords ?? '') . ' ' . ($item->title ?? '') . ' ' . ($item->subtitle ?? '')) }}">
                  <div class="ph">
                    <div class="prod-slider">
                      <div class="prod-slides">
                        @foreach($slides as $sIdx => $imgSrc)
                          <div class="prod-slide {{ $sIdx === 0 ? 'active' : '' }}">
                            <img src="{{ $resolveImageUrl($imgSrc) }}" alt="{{ $item->title }}" width="300" height="300"
                              loading="lazy"
                              onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>

                  @if(count($slides) > 1)
                    <div class="ps-dots">
                      @foreach($slides as $sIdx => $imgSrc)
                        <span class="ps-dot {{ $sIdx === 0 ? 'active' : '' }}" onclick="setCardSlide(this, {{ $sIdx }})"></span>
                      @endforeach
                    </div>
                  @endif

                  <div class="b">
                    <h3>{{ $item->title }}</h3>
                    <p class="s">{{ $item->subtitle ?? '' }}</p>
                    <div class="price">{{ $item->price }}</div>
                    <div class="meta">
                      <span>{{ $item->dosage_spec ?? 'Standard' }}</span>
                      <span>{{ $item->badge_category ?? 'Research grade' }}</span>
                    </div>
                    <a class="btn-details" href="{{ $detailUrl }}">See Details</a>
                  </div>
                </div>
              @empty
                <div
                  style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted); font-size: 14px;">
                  Formulation catalog is currently being updated.
                </div>
              @endforelse
            </div>

            <div class="div2">
              <a class="camp" href="{{ route('products.index') }}" aria-label="Explore Performance Peptides">
                <img src="{{ asset('f1.webp') }}" alt="Performance Peptides Banner" width="600" height="400"
                  loading="lazy"
                  onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1000&q=85'">
              </a>
              <a class="camp" href="{{ route('products.index') }}" aria-label="Explore Peptide Skincare">
                <img src="{{ asset('r1.webp') }}" alt="Skincare Peptides Banner" width="600" height="400" loading="lazy"
                  onerror="this.src='https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=1000&q=85'">
              </a>
            </div>
          </div>
        </section>

        <section class="sec">
          <div class="wrap">
            <div class="head">
              <div style="max-width: 720px;">
                <h2 class="sec-title">From the bench to your door</h2>
                <p class="sec-desc">Four checkpoints every vial passes before it leaves us.</p>
              </div>
            </div>
            <div class="steps">
              <div class="step-card">
                <b>01</b>
                <h3>Synthesis</h3>
                <p>Produced under certified partner cGMP conditions in the USA.</p>
              </div>
              <div class="step-card">
                <b>02</b>
                <h3>Testing</h3>
                <p>Third-party testing verifies purity and compound identity via HPLC.</p>
              </div>
              <div class="step-card">
                <b>03</b>
                <h3>Cold Storage</h3>
                <p>Stored under continuous temperature-monitored environments.</p>
              </div>
              <div class="step-card">
                <b>04</b>
                <h3>Insulated Dispatch</h3>
                <p>Express courier cold-chain dispatch directly to your institution.</p>
              </div>
            </div>
          </div>
        </section>

        <section class="sec alt">
          <div class="wrap">
            <div class="head">
              <div style="max-width: 720px;">
                <h2 class="sec-title">Latest Science Articles</h2>
                <p class="sec-desc">Carefully curated scientific literature, compound mechanisms, and laboratory research
                  notes.</p>
              </div>
              <a class="btn-outline-pill" href="{{ route('resources') }}">All articles</a>
            </div>

            <div class="g4">
              @php
                $resolveArticleImg = function ($path) {
                  if (empty($path))
                    return asset('assets/website/science/s1.webp');
                  if (filter_var($path, FILTER_VALIDATE_URL))
                    return $path;
                  $clean = ltrim($path, '/');
                  if (file_exists(public_path($clean)))
                    return asset($clean) . '?v=' . filemtime(public_path($clean));
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
                <a class="article-card" href="{{ $artUrl }}">
                  <div class="ph">
                    <img src="{{ $artImg }}" alt="{{ $art->title }}" width="400" height="250" loading="lazy"
                      onerror="this.src='{{ asset('assets/website/science/s1.webp') }}'">
                  </div>
                  <div class="b">
                    <h3>{{ $art->title }}</h3>
                    @if(!empty($art->subtitle))
                      <p>{{ $art->subtitle }}</p>
                    @endif
                    <span>Read Article &rarr;</span>
                  </div>
                </a>
              @empty
                <div
                  style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--text-muted); font-size: 14px;">
                  Belum ada artikel riset yang dipublikasikan saat ini.
                </div>
              @endforelse
            </div>
          </div>
        </section>
      </div>
    @endif
  </main>

  <div class="t-lightbox" id="tLightbox" onclick="if(event.target===this)closeLightboxModal()">
    <div class="t-lightbox-inner">
      <button class="t-lightbox-close" onclick="closeLightboxModal()" aria-label="Close">&times;</button>
      <img id="tLightboxImg" src="" alt="Enlarged Document">
      <div id="tLightboxTitle" class="t-lightbox-title"></div>
    </div>
  </div>

  <div class="toast" id="toastMsg">✓ Added to cart</div>

  <div class="cart-overlay" id="cartOverlay" onclick="closeCartDrawer()"></div>
  <div class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
      <h3>Your Research Cart</h3>
      <button onclick="closeCartDrawer()">&times;</button>
    </div>
    <div class="cart-items" id="cartItemsList"></div>
    <div class="cart-footer">
      <div class="cart-total-row">
        <span style="font-weight: 600;">Total Order:</span>
        <span class="cart-total-price" id="cartTotal">RM 0.00</span>
      </div>
      <button class="btn-wa-proceed" onclick="proceedToWhatsApp()">
        <svg width="20" height="20" viewBox="0 0 32 32" fill="#ffffff" aria-hidden="true">
          <path
            d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z" />
        </svg>
        Click To Proceed
      </button>
    </div>
  </div>

  <footer>
    <div class="wrap">
      <div class="fg">
        <div>
          <h4>Novex Peptides</h4>
          <p>Advanced peptide research for performance, longevity and aesthetic health.</p>
        </div>
        <div>
          <h4>Quick Links</h4>
          <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('products.index') }}">Products Catalog</a></li>
            <li><a href="{{ route('accessory') }}">Accessory &amp; Kits</a></li>
            <li><a href="{{ route('performance') }}">Performance Division</a></li>
            <li><a href="{{ route('premium') }}">Premium Supplements</a></li>
            <li><a href="{{ route('skin') }}">Skin Lab</a></li>
            <li><a href="{{ route('resources') }}">Resources</a></li>
            <li><a href="{{ route('science') }}">Science</a></li>
            <li><a href="{{ route('contact') }}">Contact Desk</a></li>
          </ul>
        </div>
        <div>
          <h4>Follow Us</h4>
          <div class="social-links">
            <a href="{{ $orgIg }}" target="_blank" rel="noopener" class="social-link"
              aria-label="Follow us on Instagram">
              <svg viewBox="0 0 24 24">
                <path
                  d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
              <span>Instagram</span>
            </a>
            <a href="{{ $orgTiktok }}" target="_blank" rel="noopener" class="social-link"
              aria-label="Follow us on TikTok">
              <svg viewBox="0 0 24 24">
                <path
                  d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.86.12V9.37a6.34 6.34 0 0 0-.86-.06A6.33 6.33 0 0 0 3.1 15.64a6.34 6.34 0 0 0 10.82 4.48 6.27 6.27 0 0 0 1.89-4.48V8.78a8.28 8.28 0 0 0 4.78 1.5V6.82a4.84 4.84 0 0 1-1-.13z" />
              </svg>
              <span>TikTok</span>
            </a>
          </div>
        </div>
        <div>
          <h4>Contact Desk</h4>
          <p>Direct WhatsApp &amp; Inquiries:<br><b><a href="https://wa.me/{{ $cleanWaPhone }}" target="_blank"
                rel="noopener">{{ $orgPhone }}</a></b></p>
          <p style="margin-top: 8px;">Email Support:<br><b><a href="mailto:{{ $orgEmail }}">{{ $orgEmail }}</a></b></p>
        </div>
      </div>
      <div class="copy" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <span>© 2026 Novex Peptides. All rights reserved.</span>
        <div style="display: flex; align-items: center; gap: 16px;">
          <button type="button" onclick="openCookieSettings()" style="background: none; border: none; padding: 0; color: inherit; text-decoration: underline; font-size: inherit; cursor: pointer; font-family: inherit;">
            Cookie Settings
          </button>
          <a href="{{ route('privacy') }}" style="color: inherit; text-decoration: underline; font-size: inherit;">
            Privacy Policy
          </a>
        </div>
      </div>
    </div>
  </footer>

  <div class="cookie-banner" id="cookieConsentBanner" role="dialog" aria-live="polite">
    <h3 class="cookie-title">Cookie Preferences</h3>
    <p class="cookie-desc">
      We use cookies and Google Analytics 4 to analyze traffic and improve your experience. See our
      <a href="{{ route('privacy') }}">Privacy Policy</a>.
    </p>
    <div class="cookie-actions">
      <button type="button" class="cookie-btn-reject" onclick="handleCookieChoice('rejected')">Reject</button>
      <button type="button" class="cookie-btn-accept" onclick="handleCookieChoice('accepted')">Accept</button>
    </div>
  </div>

  <script>
    var GA_MEASUREMENT_ID = 'G-T50LPJRHD4';

    function clearGACookies() {
      var parts = location.hostname.split('.');
      var domains = [location.hostname];
      for (var i = 1; i < parts.length - 1; i++) {
        domains.push('.' + parts.slice(i).join('.'));
      }
      document.cookie.split(';').forEach(function (c) {
        var name = c.split('=')[0].trim();
        if (name === '_ga' || name.indexOf('_ga_') === 0) {
          var exp = '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
          document.cookie = name + exp;
          domains.forEach(function (d) {
            document.cookie = name + exp + '; domain=' + d;
          });
        }
      });
    }

    function checkCookieConsentStatus() {
      var consent = getConsent();
      var banner = document.getElementById('cookieConsentBanner');
      if (!consent && banner) {
        banner.classList.add('show');
      }
    }

    function handleCookieChoice(choice) {
      setConsent(choice);
      var banner = document.getElementById('cookieConsentBanner');
      if (banner) {
        banner.classList.remove('show');
      }

      if (choice === 'accepted') {
        window['ga-disable-' + GA_MEASUREMENT_ID] = false;
        loadGA4();
      } else {
        window['ga-disable-' + GA_MEASUREMENT_ID] = true;
        clearGACookies();
        if (window.ga4Initialized) {
          window.location.reload();
        }
      }
    }

    function openCookieSettings() {
      var banner = document.getElementById('cookieConsentBanner');
      if (banner) {
        banner.classList.add('show');
      }
    }

    document.addEventListener('DOMContentLoaded', checkCookieConsentStatus);
  </script>

  <script>
    window.NVX = {
      waPhone: '{{ $cleanWaPhone ?: "601125490484" }}',
      productsUrl: '{{ route("products.index") }}',
      assetBase: '{{ asset("") }}',
      defaultImg: '{{ asset("reta1.webp") }}',
      hero1Phone: '{{ asset("assets/website/home/hero1-phone.webp") }}',
      hero1Desktop: '{{ asset("assets/website/home/hero1.webp") }}',
      hero2Phone: '{{ asset("assets/website/home/hero2-phone.webp") }}',
      hero2Desktop: '{{ asset("assets/website/home/hero2.webp") }}'
    };
  </script>

  @php
    $jsFile = 'frontend/home/home.js';
    $jsVer = file_exists(public_path($jsFile)) ? filemtime(public_path($jsFile)) : time();
  @endphp
  <script src="{{ asset($jsFile) }}?v={{ $jsVer }}"></script>
</body>

</html>