<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CentraDesk &middot; Enterprise Management Console</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/admin/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/admin/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'brand': {
              DEFAULT: '#0071E3',
              'hover': '#0062C4',
              'dark': '#004DA0',
              'tint': '#F0F6FE',
              'tint-2': '#E1EDFD',
              'border': '#CBE0FB',
            },
            'hero-blue': {
              DEFAULT: '#006FEE',
              'light': '#E6F1FE',
              'hover': '#005BC4'
            }
          },
          fontFamily: {
            sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    @keyframes simpleScan {
      0% {
        transform: translateX(-100%);
      }

      100% {
        transform: translateX(250%);
      }
    }

    .animate-simple-scan {
      animation: simpleScan 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    .custom-scroll::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
      background: transparent;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
      background: #CBD5E1;
      border-radius: 9999px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
      background: #94A3B8;
    }
  </style>
</head>

<body
  class="bg-[#EEF2F6] font-sans text-slate-700 antialiased h-screen flex overflow-hidden text-sm select-none relative">

  @php
  $currentSection = $section ?? 'dashboard';
  $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia'));
  $secretPrefix = 'admin/' . $secretKey;

    $randomHeroes = [
      [
        'title' => 'Empower your digital management console today.',
        'desc' => 'Monitor analytics, publish content and manage operations seamlessly.'
      ],
      [
        'title' => 'Streamline your enterprise workflows effortlessly.',
        'desc' => 'Access all administrative modules and track performance in real time.'
      ],
      [
        'title' => 'Welcome back to your central control hub.',
        'desc' => 'Here is a quick overview of your system activity and performance metrics.'
      ],
      [
        'title' => 'Manage, publish and scale your content.',
        'desc' => 'Keep your site updated with the latest articles, media and services.'
      ],
      [
        'title' => 'System status is optimal and fully active.',
        'desc' => 'Review audience engagement and security logs from your console.'
      ]
    ];

    $selectedHero = $randomHeroes[array_rand($randomHeroes)];
  @endphp

  <div id="pageLoaderOverlay"
    class="hidden fixed inset-0 z-[100] bg-white flex-col items-center justify-center transition-all duration-500 ease-out opacity-100">
    <div class="relative z-10 flex flex-col items-center max-w-xs w-full px-6 text-center">
      <div class="flex items-center justify-center mb-6 animate-pulse select-none">
        <img src="{{ asset('assets/admin/logo-cms.png') }}" onerror="this.src='{{ asset('logo-cms.png') }}'" alt="CentraDesk Logo" class="h-9 w-auto object-contain">
      </div>
      <div class="w-44 h-1 bg-slate-100 rounded-full overflow-hidden relative mb-3">
        <div class="w-1/2 h-full bg-brand rounded-full animate-simple-scan"></div>
      </div>
      <div class="h-4 flex items-center justify-center">
        <span id="loaderStatusText"
          class="text-xs text-slate-400 font-medium tracking-tight transition-opacity duration-200">
          Initializing environment...
        </span>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div id="toastSuccess"
      class="fixed top-5 right-5 z-50 flex items-center gap-2.5 px-4 py-2.5 bg-slate-900 text-white rounded-xl transition-all duration-300 translate-y-0 opacity-100 text-xs shadow-md">
      <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
      <span class="font-medium tracking-tight">{{ session('success') }}</span>
      <button type="button" onclick="closeToast()" class="ml-1 text-slate-400 hover:text-white cursor-pointer">✕</button>
    </div>
  @endif

  @if($errors->any())
    <div id="toastError"
      class="fixed top-5 right-5 z-50 flex items-center gap-2.5 px-4 py-2.5 bg-rose-600 text-white rounded-xl transition-all duration-300 translate-y-0 opacity-100 text-xs shadow-md">
      <span class="w-2 h-2 rounded-full bg-white shrink-0"></span>
      <span class="font-medium tracking-tight">{{ $errors->first() }}</span>
      <button type="button" onclick="this.parentElement.remove()"
        class="ml-1 text-white/80 hover:text-white cursor-pointer">✕</button>
    </div>
  @endif

  <aside id="mainSidebar"
    class="w-64 flex flex-col justify-between shrink-0 h-screen p-5 border-r border-slate-300 bg-[#EEF2F6] hidden md:flex z-30 transition-all duration-300 ease-in-out">
    <div class="flex flex-col gap-6 overflow-y-auto pr-1">

      <div class="px-2 pt-1 flex items-center">
        <a href="{{ url($secretPrefix) }}"
          class="flex items-center gap-2 w-full group select-none transition-opacity hover:opacity-90">
          <img src="{{ asset('assets/admin/logo-cms.png') }}" onerror="this.src='{{ asset('logo-cms.png') }}'" alt="CentraDesk" class="h-9 w-auto object-contain">
        </a>
      </div>

      @php
        $menuGeneral = [
          'dashboard' => ['label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
          'audience' => ['label' => 'Audience Views', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />'],
          'products' => ['label' => 'Product Manage', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />'],
          'blogs' => ['label' => 'Articles & News', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />'],
        ];

        $menuSecurity = [
          'audit-logs' => ['label' => 'Audit Logs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />'],
          'info' => ['label' => 'Organization Info', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'],
        ];

        $menuConfiguration = [
          'settings' => ['label' => 'Settings', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />'],
        ];

        $allMenuItems = array_merge($menuGeneral, $menuSecurity, $menuConfiguration);
      @endphp

      <nav class="flex flex-col gap-1.5">
        @foreach ($allMenuItems as $key => $item)
          @php $isActive = ($currentSection === $key); @endphp
          <a href="{{ route('admin.' . ($key === 'dashboard' ? 'dashboard' : $key)) }}"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ $isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/50' }}">
            <div class="flex items-center gap-3">
              <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-slate-900' : 'text-slate-400' }}" fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                {!! $item['icon'] !!}
              </svg>
              <span class="tracking-tight">{{ $item['label'] }}</span>
            </div>
          </a>
        @endforeach
      </nav>
    </div>

    <!-- SEKSYEN BAWAH SIDEBAR: LOG KELUAR -->
    <div class="flex flex-col gap-1 pt-4 border-t border-slate-300">
      <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit"
          class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-all cursor-pointer text-left">
          <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-600" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="tracking-tight">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- SECTION: MAIN CANVAS CONTAINER -->
  <div class="flex-1 flex flex-col min-w-0 bg-[#EEF2F6] overflow-y-auto relative h-screen transition-all duration-300">

    <!-- TOP HEADER -->
    <header
      class="w-full px-5 sm:px-7 py-4 flex items-center justify-between gap-4 sticky top-0 z-50 bg-[#EEF2F6]/90 backdrop-blur-md border-b border-slate-300">
      <div class="flex items-center gap-3">
        <button type="button" onclick="toggleSidebar()" id="toggleSidebarBtn"
          class="w-9 h-9 rounded-xl bg-white border-0 flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-slate-900 shadow-sm transition-all cursor-pointer shrink-0">
          <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2" />
            <path d="M9 3v18" stroke-width="2" />
          </svg>
        </button>
      </div>

      <div class="flex items-center gap-3 ml-auto">
        <div class="relative hidden sm:block w-48 lg:w-64" id="globalSearchWrapper">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input type="text" id="globalSearchInput" placeholder="Search..." autocomplete="off"
              class="w-full bg-white border-0 rounded-full py-1.5 pl-8 pr-3 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 shadow-sm transition-all">
          </div>

          <div id="searchResultsPanel"
            class="hidden absolute left-0 right-0 top-full mt-2 bg-white border-0 rounded-2xl shadow-xl overflow-hidden z-50 max-h-[380px] flex flex-col">
            <div
              class="p-2.5 bg-slate-50 border-b border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-500">
              <span id="searchResultMeta">Type to find matches...</span>
              <span class="text-[10px] uppercase font-bold text-brand tracking-wider">Finder</span>
            </div>
            <div id="searchResultsContent" class="overflow-y-auto divide-y divide-slate-100 p-2 text-xs"></div>
          </div>
        </div>

        <button type="button"
          class="w-8 h-8 rounded-full bg-white border-0 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors relative shadow-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>

        <div class="flex items-center gap-2.5 shrink-0 pl-1">
          <div class="h-8 w-8 rounded-lg bg-brand text-white font-bold flex items-center justify-center text-xs shadow-xs">
            NP
          </div>
          <div class="flex flex-col text-left">
            <span class="font-bold text-xs text-slate-900 leading-tight">Admin Novex</span>
            <span class="text-[11px] text-slate-400 font-medium leading-tight">admin@novexsupps.com</span>
          </div>
        </div>
      </div>
    </header>

    <!-- MAIN CONTENT BODY -->
    <main class="px-5 sm:px-7 pt-3 pb-7 flex-1 flex flex-col gap-6">

      @if($currentSection === 'dashboard')

        <div class="flex flex-col items-center justify-center text-center my-6 gap-2">
          <div
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-300 shadow-xs text-xs font-semibold text-slate-700">
            <img src="{{ asset('assets/admin/logo.png') }}" onerror="this.src='{{ asset('logo.png') }}'" alt="CentraDesk Logo" class="h-4 w-auto object-contain">
            <span>CentraDesk v1.0 Enterprise</span>
          </div>

          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
            {{ $selectedHero['title'] }}
          </h1>

          <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-lg">
            {{ $selectedHero['desc'] }}
          </p>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-1">
          <div class="inline-flex items-center bg-slate-200/60 p-1 rounded-full text-xs font-medium">
            <button type="button" onclick="setSelectMode('overview')" id="tabWeekly"
              class="period-tab px-4 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs">
              Overview
            </button>
            <button type="button" onclick="setSelectMode('daily')" id="tabDaily"
              class="period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800">
              Daily
            </button>
            <button type="button" onclick="setSelectMode('monthly')" id="tabMonthly"
              class="period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800">
              Monthly
            </button>
          </div>

          <div class="flex items-center gap-2">
            <button type="button" onclick="triggerRefreshAnimation(this)"
              class="p-2 rounded-2xl border-0 bg-white text-slate-600 hover:bg-slate-50 shadow-sm flex items-center justify-center transition-all cursor-pointer">
              <svg id="refreshIcon" class="w-4 h-4 transition-transform duration-500" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
            </button>

            <!-- DATE / MONTH PICKER POPOVER -->
            <div class="relative inline-block" id="heroDatePickerWrapper">
              <div onclick="toggleHeroDatePicker()"
                class="inline-flex items-center justify-between gap-3 bg-white border-0 rounded-2xl px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm cursor-pointer hover:bg-slate-50/80 transition-all shrink-0">
                <span id="datePickerDisplayVal" class="text-slate-700 whitespace-nowrap">Loading Date...</span>
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                  <line x1="16" y1="2" x2="16" y2="6"></line>
                  <line x1="8" y1="2" x2="8" y2="6"></line>
                  <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
              </div>

              <div id="heroDatePickerPopover"
                class="hidden absolute right-0 top-full mt-2 w-[310px] bg-white border-0 rounded-3xl shadow-2xl p-4 z-50 transition-all">
                <div class="flex items-center justify-between px-1 mb-4">
                  <div class="flex items-center gap-1 font-bold text-slate-900 text-sm">
                    <span id="calMonthYearText">October 2026</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <button type="button" onclick="changeCalYear(-1)" class="text-sky-600 hover:text-sky-700 p-1">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                      </svg>
                    </button>
                    <button type="button" onclick="changeCalYear(1)" class="text-sky-600 hover:text-sky-700 p-1">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>

                <!-- TAMPILAN BULAN (1-12) / HARI (GRID KALENDAR) -->
                <div id="calendarHeaderDays" class="grid grid-cols-7 text-center mb-2">
                  <span class="text-xs font-semibold text-slate-400">Sun</span>
                  <span class="text-xs font-semibold text-slate-400">Mon</span>
                  <span class="text-xs font-semibold text-slate-400">Tue</span>
                  <span class="text-xs font-semibold text-slate-400">Wed</span>
                  <span class="text-xs font-semibold text-slate-400">Thu</span>
                  <span class="text-xs font-semibold text-slate-400">Fri</span>
                  <span class="text-xs font-semibold text-slate-400">Sat</span>
                </div>

                <div id="calendarDaysGrid" class="grid grid-cols-7 gap-y-1"></div>
                <div id="calendarMonthsGrid" class="hidden grid grid-cols-3 gap-2"></div>
              </div>
            </div>

          </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

          <!-- CARD 1: Published Articles -->
          <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[100px] shadow-sm">
            <div>
              <span class="text-xs font-semibold text-slate-500">Published Articles</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
              <span class="font-extrabold text-2xl text-slate-900 tracking-tight">{{ $articlesCount ?? 0 }}</span>
            </div>
          </div>

          <!-- CARD 2: Security Events -->
          <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[100px] shadow-sm">
            <div>
              <span class="text-xs font-semibold text-slate-500">Security Events</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
              @php
                $sqlSecCount = \Illuminate\Support\Facades\Schema::hasTable('audit_logs') ? DB::table('audit_logs')->count() : 0;
              @endphp
              <span class="font-extrabold text-2xl text-slate-900 tracking-tight">{{ $sqlSecCount }}</span>
            </div>
          </div>

          <!-- CARD 3: Audience Views -->
          <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[100px] shadow-sm">
            <div>
              <span class="text-xs font-semibold text-slate-500" id="cardAudienceLabel">Audience Views</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
              @php
                $sqlAudienceCount = \Illuminate\Support\Facades\Schema::hasTable('page_views') ? DB::table('page_views')->count() : 0;
              @endphp
              <span id="metricAudienceViews"
                class="font-extrabold text-2xl text-slate-900 tracking-tight">{{ number_format($audienceViewsCount ?? $sqlAudienceCount) }}</span>
            </div>
          </div>

          <!-- CARD 4: Total Pages -->
          <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[100px] shadow-sm">
            <div>
              <span class="text-xs font-semibold text-slate-500">Total Pages</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
              <span class="font-extrabold text-2xl text-slate-900 tracking-tight">{{ $pagesCount ?? 6 }}</span>
            </div>
          </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-stretch">

          <div class="xl:col-span-8 flex flex-col gap-6 justify-between h-full">

            <div class="bg-white border-0 rounded-2xl p-5 flex flex-col gap-4 shadow-sm">
              <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                  <h3 class="font-bold text-sm text-slate-900">Audience Views &amp; Performance</h3>
                  <p class="text-xs text-slate-400 mt-0.5">Real-time audience impressions and page view breakdown.</p>
                </div>
              </div>

              <div class="w-full relative h-64">
                <canvas id="audienceViewsChart"></canvas>
              </div>

              <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Total page impressions: <strong id="totalImpressionsText" class="text-slate-800 font-bold">0
                    sessions</strong></span>
              </div>
            </div>

            <div class="bg-white border-0 rounded-2xl p-5 flex flex-col justify-between flex-1 shadow-sm">
              <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                  <div>
                    <h3 class="font-bold text-sm text-slate-900">Latest Articles</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Most recently published content on your portal.</p>
                  </div>
                  <a href="{{ url($secretPrefix . '/blogs') }}" class="text-xs font-bold text-brand hover:underline">+
                    Manage Article</a>
                </div>

                @php
                  if (isset($recentArticles) && $recentArticles->isNotEmpty()) {
                    $latestTwoPosts = $recentArticles->take(2);
                  } else {
                    $latestTwoPosts = \Illuminate\Support\Facades\Schema::hasTable('blog_posts')
                      ? DB::table('blog_posts')->latest('created_at')->take(2)->get()
                      : collect();
                  }
                @endphp

                @if($latestTwoPosts->isNotEmpty())
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($latestTwoPosts as $dp)
                      <a href="{{ url('/blog/' . $dp->slug) }}" target="_blank"
                        class="flex items-center gap-3 group p-3.5 rounded-xl bg-slate-50/80 hover:bg-brand-tint border-0 transition-all">
                        <div class="w-12 h-12 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                          <img src="{{ $dp->cover_image ?: asset('assets/admin/logo-cms.png') }}" onerror="this.src='{{ asset('logo-cms.png') }}'" alt="{{ $dp->title }}"
                            class="w-full h-full object-cover">
                        </div>
                        <div class="truncate flex-1 min-w-0">
                          <h4 class="truncate text-sm font-semibold text-slate-800 group-hover:text-brand transition-colors">
                            {{ $dp->title }}
                          </h4>
                          <span class="block text-xs text-slate-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($dp->created_at ?? $dp->published_at)->format('d M Y') }}
                          </span>
                        </div>
                        <span class="text-slate-300 group-hover:text-brand font-bold text-xs">&rsaquo;</span>
                      </a>
                    @endforeach
                  </div>
                @else
                  <div class="py-8 text-center text-slate-400 text-xs">
                    No articles recorded yet.
                  </div>
                @endif
              </div>

              <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 mt-3">
                <span>Showing latest articles</span>
              </div>
            </div>

          </div>

          <div class="xl:col-span-4 flex flex-col gap-6 justify-between h-full">

            <!-- QUICK ACTIONS -->
            <div class="bg-white border-0 rounded-2xl p-5 shadow-sm">
              <div class="pb-3 border-b border-slate-100 mb-4 flex items-center justify-between">
                <div>
                  <h3 class="font-bold text-sm text-slate-900">Quick Actions</h3>
                  <p class="text-xs text-slate-400">Shortcuts to console features</p>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-3">
                <a href="{{ url($secretPrefix . '/products/create') }}"
                  class="group p-3.5 rounded-xl bg-slate-50/80 border-0 hover:bg-brand-tint transition-all flex flex-col justify-between min-h-[85px]">
                  <div class="flex items-center justify-between">
                    <div
                      class="w-7 h-7 rounded-lg bg-white text-brand flex items-center justify-center shadow-xs group-hover:bg-brand group-hover:text-white transition-colors">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                      </svg>
                    </div>
                    <svg
                      class="w-3.5 h-3.5 text-slate-300 group-hover:text-brand group-hover:translate-x-0.5 transition-all"
                      fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                  </div>
                  <div>
                    <span
                      class="block truncate text-xs font-bold text-slate-800 group-hover:text-brand transition-colors mt-2">New Product</span>
                    <span class="block text-[11px] text-slate-400 mt-0.5">Add new product</span>
                  </div>
                </a>

                <a href="{{ url('/') }}" target="_blank"
                  class="group p-3.5 rounded-xl bg-slate-50/80 border-0 hover:bg-brand-tint transition-all flex flex-col justify-between min-h-[85px]">
                  <div class="flex items-center justify-between">
                    <div
                      class="w-7 h-7 rounded-lg bg-white text-brand flex items-center justify-center shadow-xs group-hover:bg-brand group-hover:text-white transition-colors">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                      </svg>
                    </div>
                    <svg
                      class="w-3.5 h-3.5 text-slate-300 group-hover:text-brand group-hover:translate-x-0.5 transition-all"
                      fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                  </div>
                  <div>
                    <span
                      class="block truncate text-xs font-bold text-slate-800 group-hover:text-brand transition-colors mt-2">View
                      Live Site</span>
                    <span class="block text-[11px] text-slate-400 mt-0.5">Open portal</span>
                  </div>
                </a>
              </div>
            </div>

            <!-- Recent Activity Log -->
            <div class="bg-white border-0 rounded-2xl p-5 flex flex-col justify-between flex-1 shadow-sm">
              <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                  <div>
                    <h3 class="font-bold text-sm text-slate-900">Recent Activity Log</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Real-time SQL audit stream</p>
                  </div>
                  <a href="{{ url($secretPrefix . '/audit-logs') }}"
                    class="text-xs font-bold text-brand hover:underline flex items-center gap-1">
                    <span>View all</span>
                    <span>&rsaquo;</span>
                  </a>
                </div>

                @php
                  $recentLogs = \Illuminate\Support\Facades\Schema::hasTable('audit_logs')
                    ? DB::table('audit_logs')
                      ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
                      ->select('audit_logs.*', 'users.name as user_name', 'users.email as user_email')
                      ->orderBy('audit_logs.created_at', 'desc')
                      ->take(4)
                      ->get()
                    : collect();
                @endphp

                <div class="divide-y divide-slate-100 text-xs">
                  @if($recentLogs->isNotEmpty())
                    @foreach($recentLogs as $log)
                      @php
                        $eventTitle = 'Activity Logged';
                        $eventDesc = 'System action performed.';
                        $badgeColor = 'text-slate-600';

                        if ($log->event === 'login_success') {
                          $eventTitle = 'User Logged In';
                          $eventDesc = 'Successful authentication session created.';
                          $badgeColor = 'text-emerald-600 font-semibold';
                        } elseif ($log->event === 'login_failed') {
                          $eventTitle = 'Failed Login Attempt';
                          $eventDesc = 'Unauthorized access attempt blocked.';
                          $badgeColor = 'text-rose-600 font-semibold';
                        } elseif ($log->event === 'password_changed') {
                          $eventTitle = 'Password Updated';
                          $eventDesc = 'User account security credentials changed.';
                          $badgeColor = 'text-amber-600 font-semibold';
                        } elseif ($log->event === 'logout') {
                          $eventTitle = 'Terminal Logout';
                          $eventDesc = 'User session ended successfully.';
                          $badgeColor = 'text-slate-500';
                        } else {
                          $eventTitle = ucwords(str_replace('_', ' ', $log->event));
                        }

                        $payload = json_decode($log->payload, true);
                        $actor = $log->user_name ?? ($payload['attempted_email'] ?? $payload['email'] ?? 'Admin Novex');
                      @endphp

                      <div class="py-2.5 group hover:bg-slate-50 -mx-2 px-2 rounded-lg transition-colors">
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center justify-between gap-2">
                            <h4 class="truncate font-semibold text-slate-800 group-hover:text-brand transition-colors">
                              {{ $eventTitle }}
                            </h4>
                            <span class="text-[11px] text-slate-400 shrink-0">
                              {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                            </span>
                          </div>
                          <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                            {{ $eventDesc }}
                          </p>
                          <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-400">
                            <span>By <strong class="{{ $badgeColor }}">{{ $actor }}</strong></span>
                            <span>&bull;</span>
                            <span class="font-mono text-[10px]">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="py-6 text-center text-slate-400 text-xs">
                      No recent security activity logged in database.
                    </div>
                  @endif
                </div>
              </div>
            </div>

          </div>

        </div>

      @elseif($currentSection === 'audience')
        @if(view()->exists('backend.admin.audience'))
          @include('backend.admin.audience')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Audience module loaded.</div>
        @endif

      @elseif($currentSection === 'products')
        @if(view()->exists('backend.admin.products.products'))
          @include('backend.admin.products.products')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Product Manage module loaded.</div>
        @endif

      @elseif($currentSection === 'blogs')
        @if(view()->exists('backend.admin.blogs'))
          @include('backend.admin.blogs')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Articles module loaded.</div>
        @endif

      @elseif($currentSection === 'audit-logs')
        @if(view()->exists('backend.admin.audit-logs'))
          @include('backend.admin.audit-logs')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Audit logs module loaded.</div>
        @endif

      @elseif($currentSection === 'info')
        @if(view()->exists('backend.admin.info'))
          @include('backend.admin.info')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Organization Info module loaded.</div>
        @endif

      @elseif($currentSection === 'settings')
        @if(view()->exists('backend.admin.settings'))
          @include('backend.admin.settings')
        @else
          <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">Settings module loaded.</div>
        @endif

      @endif

    </main>
  </div>

  @php
    $searchArticles = \Illuminate\Support\Facades\Schema::hasTable('blog_posts')
      ? DB::table('blog_posts')->select('id', 'title', 'slug', 'published_at')->latest('published_at')->take(40)->get()
      : collect();
  @endphp

  <script>
    /* =========================================================================
     * SECTION: CORE DASHBOARD & REAL-TIME DYNAMIC DATE SYSTEM
     * ========================================================================= */
    function triggerRefreshAnimation(btn) {
      const icon = document.getElementById('refreshIcon');
      if (icon) {
        icon.classList.add('rotate-[360deg]');
        setTimeout(() => {
          icon.classList.remove('rotate-[360deg]');
          location.reload();
        }, 500);
      } else {
        location.reload();
      }
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('mainSidebar');
      if (!sidebar) return;

      if (sidebar.classList.contains('hidden')) {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('md:flex');
        localStorage.setItem('sidebar_collapsed', 'false');
      } else {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('md:flex');
        localStorage.setItem('sidebar_collapsed', 'true');
      }
    }

    function initSidebarState() {
      const sidebar = document.getElementById('mainSidebar');
      if (!sidebar) return;

      const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
      if (isCollapsed) {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('md:flex');
      } else {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('md:flex');
      }
    }

    const now = new Date();
    let pickerMode = 'overview';
    let calYear = now.getFullYear();
    let calMonth = now.getMonth();
    let selectedDay = now.getDate();

    function toggleHeroDatePicker() {
      const popover = document.getElementById('heroDatePickerPopover');
      if (popover) popover.classList.toggle('hidden');
    }

    function changeCalYear(dir) {
      calYear += dir;
      renderHeroCalendar();
    }

    function handleDateClick(day) {
      selectedDay = day;
      updateDisplayVal();
      renderHeroCalendar();
      fetchDatabaseMetrics();
    }

    function handleMonthClick(mIdx) {
      calMonth = mIdx;
      updateDisplayVal();
      renderHeroCalendar();
      fetchDatabaseMetrics();
    }

    function updateDisplayVal() {
      const displayElem = document.getElementById('datePickerDisplayVal');
      if (!displayElem) return;

      const mStr = calMonth + 1;
      const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

      if (pickerMode === 'monthly') {
        displayElem.innerText = `Month: ${monthNames[calMonth]} ${calYear}`;
      } else if (pickerMode === 'daily') {
        displayElem.innerText = `${selectedDay} / ${mStr} / ${calYear}`;
      } else {
        const curDate = new Date(calYear, calMonth, selectedDay);
        const startDateObj = new Date(curDate);
        startDateObj.setDate(curDate.getDate() - 6);

        const startD = startDateObj.getDate();
        const startM = startDateObj.getMonth() + 1;
        const startY = startDateObj.getFullYear();

        displayElem.innerText = `${startD}/${startM}/${startY} - ${selectedDay}/${mStr}/${calYear}`;
      }
    }

    function renderHeroCalendar() {
      const monthYearText = document.getElementById('calMonthYearText');
      const daysHeader = document.getElementById('calendarHeaderDays');
      const daysGrid = document.getElementById('calendarDaysGrid');
      const monthsGrid = document.getElementById('calendarMonthsGrid');

      if (!monthYearText || !daysGrid || !monthsGrid) return;

      const displayMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      monthYearText.innerText = `${displayMonthNames[calMonth]} ${calYear}`;

      if (pickerMode === 'monthly') {
        daysHeader.classList.add('hidden');
        daysGrid.classList.add('hidden');
        monthsGrid.classList.remove('hidden');

        let html = '';
        for (let m = 0; m < 12; m++) {
          const isSelected = (m === calMonth);
          const activeClass = isSelected 
            ? 'bg-[#006FEE] text-white font-bold shadow-sm' 
            : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-semibold';

          html += `
            <button type="button" onclick="handleMonthClick(${m})" class="py-2.5 rounded-xl text-xs transition-all ${activeClass}">
              ${displayMonthNames[m].substring(0, 3)} (${m + 1})
            </button>
          `;
        }
        monthsGrid.innerHTML = html;
      } else {
        daysHeader.classList.remove('hidden');
        daysGrid.classList.remove('hidden');
        monthsGrid.classList.add('hidden');

        const firstDayIdx = new Date(calYear, calMonth, 1).getDay();
        const totalDaysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
        const prevMonthDays = new Date(calYear, calMonth, 0).getDate();

        let html = '';

        for (let i = firstDayIdx - 1; i >= 0; i--) {
          const d = prevMonthDays - i;
          html += `<div class="h-9 flex items-center justify-center text-xs text-slate-300 font-medium">${d}</div>`;
        }

        const curDate = new Date(calYear, calMonth, selectedDay);
        const startDateObj = new Date(curDate);
        startDateObj.setDate(curDate.getDate() - 6);

        for (let day = 1; day <= totalDaysInMonth; day++) {
          const thisDate = new Date(calYear, calMonth, day);

          let bgClass = '';
          let textClass = 'text-slate-800 font-semibold hover:bg-slate-100 rounded-full';

          if (pickerMode === 'daily') {
            if (day === selectedDay) {
              bgClass = 'bg-[#006FEE] text-white font-bold rounded-full shadow-sm';
              textClass = 'text-white';
            }
          } else {
            if (thisDate >= startDateObj && thisDate <= curDate) {
              if (day === selectedDay) {
                bgClass = 'bg-[#006FEE] text-white font-bold rounded-full shadow-sm';
                textClass = 'text-white';
              } else {
                bgClass = 'bg-[#E6F1FE] text-slate-900 font-semibold rounded-full';
              }
            }
          }

          html += `
            <div onclick="handleDateClick(${day})" class="h-9 flex items-center justify-center cursor-pointer">
              <span class="w-8 h-8 flex items-center justify-center text-xs ${bgClass} ${textClass}">${day}</span>
            </div>
          `;
        }

        const totalCells = firstDayIdx + totalDaysInMonth;
        const nextMonthPadding = (7 - (totalCells % 7)) % 7;
        for (let i = 1; i <= nextMonthPadding; i++) {
          html += `<div class="h-9 flex items-center justify-center text-xs text-slate-300 font-medium">${i}</div>`;
        }

        daysGrid.innerHTML = html;
      }
    }

    let audienceChart = null;

    function initAudienceChart() {
      const ctx = document.getElementById('audienceViewsChart');
      if (!ctx) return;

      audienceChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [{
            label: 'Total Views',
            data: [],
            backgroundColor: '#0071E3',
            borderRadius: 6,
            borderSkipped: false,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1E293B',
              padding: 10,
              cornerRadius: 8,
              callbacks: {
                label: function (context) {
                  return ` Total Views: ${context.raw.toLocaleString()}`;
                }
              }
            }
          },
          scales: {
            x: {
              grid: { display: false },
              ticks: { font: { family: 'Inter', size: 11 }, color: '#94A3B8' }
            },
            y: {
              grid: { color: '#F1F5F9' },
              ticks: { font: { family: 'Inter', size: 11 }, color: '#94A3B8' },
              beginAtZero: true
            }
          }
        }
      });

      setSelectMode('overview');
    }

    function setSelectMode(mode) {
      pickerMode = mode;

      ['weekly', 'daily', 'monthly'].forEach(m => {
        const tabBtn = document.getElementById('tab' + m.charAt(0).toUpperCase() + m.slice(1));
        if (!tabBtn) return;
        if ((mode === 'overview' && m === 'weekly') || m === mode) {
          tabBtn.className = 'period-tab px-4 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs';
        } else {
          tabBtn.className = 'period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800';
        }
      });

      const cardAudienceLabel = document.getElementById('cardAudienceLabel');
      const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

      if (cardAudienceLabel) {
        if (mode === 'daily') {
          cardAudienceLabel.innerText = "Daily Audience Views";
        } else if (mode === 'monthly') {
          cardAudienceLabel.innerText = `${monthNames[calMonth]} Audience Views`;
        } else {
          cardAudienceLabel.innerText = "7-Day Audience Views";
        }
      }

      updateDisplayVal();
      renderHeroCalendar();
      fetchDatabaseMetrics();
    }

    function fetchDatabaseMetrics() {
      const mStr = calMonth + 1;
      const formattedDate = `${calYear}-${mStr < 10 ? '0' + mStr : mStr}-${selectedDay < 10 ? '0' + selectedDay : selectedDay}`;

      const endpoint = `{{ route('admin.audience.data', [], false) }}?period=${pickerMode}&date=${formattedDate}&month=${calMonth + 1}&year=${calYear}`;

      fetch(endpoint)
        .then(res => res.json())
        .then(resData => {
          if (audienceChart && resData.labels && resData.data) {
            audienceChart.data.labels = resData.labels;
            audienceChart.data.datasets[0].data = resData.data;
            audienceChart.update();
          }

          const chartSum = (resData.data && resData.data.length > 0) ? resData.data.reduce((a, b) => a + Number(b), 0) : 0;
          const metricVal = document.getElementById('metricAudienceViews');
          const impresstionsText = document.getElementById('totalImpressionsText');

          let displayedCount = 0;
          if (pickerMode === 'daily') {
            displayedCount = resData.todayViews !== undefined ? resData.todayViews : chartSum;
          } else {
            displayedCount = chartSum > 0 ? chartSum : (resData.total || 0);
          }

          if (metricVal) metricVal.innerText = Number(displayedCount).toLocaleString();
          if (impresstionsText) impresstionsText.innerText = `${Number(displayedCount).toLocaleString()} sessions`;
        })
        .catch(err => {
          console.error("Error fetching database metrics:", err);
        });
    }

    const globalSearchData = {
      prefix: "{{ url($secretPrefix) }}",
      articles: {!! json_encode($searchArticles) !!},
      menus: [
        { title: 'Dashboard Analytics', section: 'Overview & Metrics', url: '{{ url($secretPrefix) }}' },
        { title: 'Audience Views', section: 'Realtime Visitor Traffic', url: '{{ url($secretPrefix . "/audience") }}' },
        { title: 'Product Manage', section: 'Catalog & Inventory', url: '{{ url($secretPrefix . "/products") }}' },
        { title: 'Articles & News', section: 'Content Studio & SEO', url: '{{ url($secretPrefix . "/blogs") }}' },
        { title: 'Activity Logs', section: 'System Events & Security', url: '{{ url($secretPrefix . "/audit-logs") }}' },
        { title: 'General Settings', section: 'Configuration & Security Keys', url: '{{ url($secretPrefix . "/settings") }}' },
        { title: 'Company Information', section: 'Profile & Contact Details', url: '{{ url($secretPrefix . "/info") }}' }
      ]
    };

    function initGlobalSearch() {
      const input = document.getElementById('globalSearchInput');
      const panel = document.getElementById('searchResultsPanel');
      const content = document.getElementById('searchResultsContent');
      const meta = document.getElementById('searchResultMeta');

      if (!input || !panel || !content) return;

      input.addEventListener('input', (e) => {
        const query = e.target.value.trim().toLowerCase();

        if (query.length < 2) {
          panel.classList.add('hidden');
          content.innerHTML = '';
          return;
        }

        const matchedArticles = (globalSearchData.articles || []).filter(item => {
          return (item.title && item.title.toLowerCase().includes(query)) ||
            (item.slug && item.slug.toLowerCase().includes(query));
        });

        const matchedMenus = (globalSearchData.menus || []).filter(item => {
          return (item.title && item.title.toLowerCase().includes(query)) ||
            (item.section && item.section.toLowerCase().includes(query));
        });

        const totalFound = matchedArticles.length + matchedMenus.length;
        meta.innerText = `${totalFound} result${totalFound === 1 ? '' : 's'} matching "${e.target.value.trim()}"`;

        if (totalFound === 0) {
          content.innerHTML = `
            <div class="py-6 px-4 text-center">
              <p class="font-semibold text-xs text-slate-700">No matches found</p>
              <p class="text-xs text-slate-400 mt-0.5">Try searching with another keyword.</p>
            </div>
          `;
          panel.classList.remove('hidden');
          return;
        }

        let html = '';

        if (matchedArticles.length > 0) {
          html += `
            <div class="p-1.5">
              <div class="flex items-center justify-between px-2.5 py-1 mb-1 text-xs font-bold text-brand uppercase tracking-wider bg-brand-tint rounded-lg">
                <span>Articles (${matchedArticles.length})</span>
              </div>
              <div class="flex flex-col gap-0.5">
          `;
          matchedArticles.forEach(art => {
            html += `
              <a href="${globalSearchData.prefix}/blogs" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                <div class="truncate">
                  <p class="truncate text-sm font-semibold text-slate-800 group-hover:text-brand transition-colors">${escapeHtml(art.title)}</p>
                  <p class="text-xs text-slate-400 font-mono truncate">/blog/${escapeHtml(art.slug)}</p>
                </div>
                <span class="shrink-0 text-xs font-medium text-slate-400 group-hover:text-brand ml-2">Edit &rarr;</span>
              </a>
            `;
          });
          html += `</div></div>`;
        }

        if (matchedMenus.length > 0) {
          html += `
            <div class="p-1.5">
              <div class="flex items-center justify-between px-2.5 py-1 mb-1 text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 rounded-lg">
                <span>Shortcuts (${matchedMenus.length})</span>
              </div>
              <div class="flex flex-col gap-0.5">
          `;
          matchedMenus.forEach(menu => {
            html += `
              <a href="${menu.url}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                <div>
                  <p class="truncate text-sm font-semibold text-slate-800 group-hover:text-brand transition-colors">${escapeHtml(menu.title)}</p>
                  <p class="text-xs text-slate-400">${escapeHtml(menu.section)}</p>
                </div>
                <span class="text-xs font-medium text-slate-400 group-hover:text-brand">Jump &rarr;</span>
              </a>
            `;
          });
          html += `</div></div>`;
        }

        content.innerHTML = html;
        panel.classList.remove('hidden');
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') panel.classList.add('hidden');
      });
    }

    function closeToast() {
      const toast = document.getElementById('toastSuccess');
      if (toast) {
        toast.classList.add('opacity-0', '-translate-y-1');
        setTimeout(() => toast.remove(), 250);
      }
    }

    function escapeHtml(str) {
      if (!str) return '';
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    document.addEventListener('DOMContentLoaded', () => {
      initSidebarState();
      updateDisplayVal();
      renderHeroCalendar();
      initAudienceChart();
      initGlobalSearch();

      document.addEventListener('click', (e) => {
        const wrapper = document.getElementById('heroDatePickerWrapper');
        const popover = document.getElementById('heroDatePickerPopover');
        if (wrapper && popover && !wrapper.contains(e.target)) {
          popover.classList.add('hidden');
        }
      });

      const overlay = document.getElementById('pageLoaderOverlay');
      const statusText = document.getElementById('loaderStatusText');

      if (!overlay) return;

      let isReload = false;
      if (window.performance) {
        const navEntries = performance.getEntriesByType('navigation');
        if (navEntries.length > 0 && navEntries[0].type === 'reload') {
          isReload = true;
        }
      }

      const hasSeenSplash = sessionStorage.getItem('centradesk_splash_shown');

      if (!hasSeenSplash || isReload) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        sessionStorage.setItem('centradesk_splash_shown', 'true');

        setTimeout(() => {
          if (statusText) statusText.innerText = "CentraDesk Ready.";
        }, 1200);

        setTimeout(() => {
          overlay.classList.add('opacity-0', 'pointer-events-none');
          setTimeout(() => overlay.remove(), 500);
        }, 2000);
      } else {
        overlay.remove();
      }

      const toast = document.getElementById('toastSuccess');
      if (toast) {
        setTimeout(() => closeToast(), 3200);
      }
    });
  </script>
</body>

</html>