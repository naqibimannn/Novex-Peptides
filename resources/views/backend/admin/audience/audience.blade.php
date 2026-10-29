<div class="flex flex-col gap-8">
  
  <!-- HEADER SECTION -->
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Audience Analytics
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Insights &middot; Real-time portal visitor metrics and traffic impressions.
      </p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
      <a href="https://search.google.com/search-console/welcome" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98]">
        <img src="{{ asset('gsc.png') }}" alt="Google Search Console" class="w-4 h-4 object-contain shrink-0">
        <span>Google Search Console</span>
      </a>

      <a href="https://analytics.google.com/analytics/web" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98]">
        <img src="{{ asset('ga.png') }}" alt="Google Analytics" class="w-4 h-4 object-contain shrink-0">
        <span>Google Analytics</span>
      </a>

      <button type="button" onclick="refreshAudienceData()"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
        <svg id="audienceRefreshSpinner" class="w-4 h-4 text-slate-500 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Refresh Metrics</span>
      </button>
    </div>
  </div>

  <!-- TOOLBAR: PAGE SELECTOR DROPDOWN & DATE/PERIOD SELECTOR -->
  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <!-- FILTER PAGE DROPDOWN -->
    <div class="flex items-center gap-3 w-full md:w-auto">
      <label class="text-xs font-bold text-slate-500 uppercase tracking-wider shrink-0">Filter Page:</label>
      
      <div class="relative w-full sm:w-72" id="audiencePageDropdownWrapper">
        <button type="button" onclick="toggleAudiencePageDropdown()" id="selectedAudiencePageBtn"
          class="w-full bg-slate-100/90 border border-slate-200 hover:border-brand/50 rounded-xl px-4 py-2.5 flex items-center justify-between gap-2 text-xs font-bold text-slate-800 shadow-2xs transition-all cursor-pointer">
          <span id="selectedAudiencePageText">All Pages</span>
          <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" id="audienceDropdownArrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <div id="audiencePageDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-2 bg-white border border-slate-200/90 rounded-2xl shadow-2xl z-50 p-1.5 flex flex-col gap-1 max-h-80 overflow-y-auto">
          <button type="button" onclick="filterAudienceByPage('all', 'All Pages')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>All Pages</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('home', 'Home Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>Home Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('about', 'About Us Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>About Us Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('services/health-screening', 'Health Screening Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>Health Screening Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('services/wellness-program', 'Wellness Program Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>Wellness Program Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('services/clinic', 'Vealthme Clinic Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>Vealthme Clinic Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('contact', 'Contact Us Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>Contact Us Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('app-and-portal', 'App & Employer Portal Page')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>App & Employer Portal Page</span>
          </button>

          <button type="button" onclick="filterAudienceByPage('blog-all', 'All Blog & Insight Pages')"
            class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>All Blog & Insight Pages</span>
          </button>
        </div>
      </div>
    </div>

    <!-- DATE & PERIOD FILTER SYSTEM -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
      
      <!-- MODE TABS -->
      <div class="inline-flex items-center bg-slate-200/60 p-1 rounded-full text-xs font-medium">
        <button type="button" onclick="setAudienceSelectMode('overview')" id="audTabWeekly"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs">
          Overview
        </button>
        <button type="button" onclick="setAudienceSelectMode('daily')" id="audTabDaily"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800">
          Daily
        </button>
        <button type="button" onclick="setAudienceSelectMode('monthly')" id="audTabMonthly"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800">
          Monthly
        </button>
      </div>

      <!-- DATE/MONTH PICKER POPOVER -->
      <div class="relative inline-block" id="audienceDatePickerWrapper">
        <div onclick="toggleAudienceDatePicker()"
          class="inline-flex items-center justify-between gap-3 bg-white border border-slate-200/80 rounded-2xl px-4 py-2 text-xs font-semibold text-slate-700 shadow-xs cursor-pointer hover:bg-slate-50/80 transition-all shrink-0">
          <span id="audDatePickerDisplayVal" class="text-slate-700 whitespace-nowrap">Loading Date...</span>
          <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
          </svg>
        </div>

        <div id="audienceDatePickerPopover"
          class="hidden absolute right-0 top-full mt-2 w-[310px] bg-white border border-slate-200/90 rounded-3xl shadow-2xl p-4 z-50 transition-all">
          <div class="flex items-center justify-between px-1 mb-4">
            <div class="flex items-center gap-1 font-bold text-slate-900 text-sm">
              <span id="audCalMonthYearText">October 2026</span>
            </div>
            <div class="flex items-center gap-3">
              <button type="button" onclick="changeAudCalYear(-1)" class="text-sky-600 hover:text-sky-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <button type="button" onclick="changeAudCalYear(1)" class="text-sky-600 hover:text-sky-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>

          <!-- TAMPILAN HARI (SUN-SAT) -->
          <div id="audCalendarHeaderDays" class="grid grid-cols-7 text-center mb-2">
            <span class="text-xs font-semibold text-slate-400">Sun</span>
            <span class="text-xs font-semibold text-slate-400">Mon</span>
            <span class="text-xs font-semibold text-slate-400">Tue</span>
            <span class="text-xs font-semibold text-slate-400">Wed</span>
            <span class="text-xs font-semibold text-slate-400">Thu</span>
            <span class="text-xs font-semibold text-slate-400">Fri</span>
            <span class="text-xs font-semibold text-slate-400">Sat</span>
          </div>

          <!-- GRID HARI & MONTH SELECTOR -->
          <div id="audCalendarDaysGrid" class="grid grid-cols-7 gap-y-1"></div>
          <div id="audCalendarMonthsGrid" class="hidden grid grid-cols-3 gap-2"></div>
        </div>
      </div>

    </div>

  </div>

  <!-- STATS CARDS -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-5 shadow-xs border border-slate-200/80 flex flex-col justify-between">
      <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Views</span>
      <div class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight" id="statTotalViews">
        {{ number_format($totalViews ?? 0) }}
      </div>
      <p class="text-[11px] text-slate-400 font-medium mt-1">
        Page views recorded in selected range for <strong class="text-slate-600 font-bold" id="pageLabelTotal">All Pages</strong>
      </p>
    </div>

    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-5 shadow-xs border border-slate-200/80 flex flex-col justify-between">
      <span class="text-xs font-extrabold text-brand uppercase tracking-wider" id="cardTodayTitle">Selected Date Views</span>
      <div class="mt-2 text-3xl font-extrabold text-brand tracking-tight" id="statTodayViews">
        {{ number_format($todayViews ?? 0) }}
      </div>
      <p class="text-[11px] text-slate-400 font-medium mt-1" id="cardTodaySubText">
        Impressions recorded for <strong class="text-slate-600 font-bold" id="pageLabelToday">All Pages</strong>
      </p>
    </div>

    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-5 shadow-xs border border-slate-200/80 flex flex-col justify-between">
      <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Unique Visitors</span>
      <div class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight" id="statUniqueVisitors">
        {{ number_format($uniqueVisitors ?? 0) }}
      </div>
      <p class="text-[11px] text-slate-400 font-medium mt-1">
        Distinct IP addresses in selected range for <strong class="text-slate-600 font-bold" id="pageLabelUnique">All Pages</strong>
      </p>
    </div>
  </div>

  <!-- AUDIENCE CHART CONTAINER -->
  <div class="bg-white/80 backdrop-blur-md border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
      <div>
        <h2 class="font-extrabold text-base sm:text-lg text-slate-800 tracking-tight">
          Visitor Engagement Overview
        </h2>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Real-time breakdown of traffic trends over time.</p>
      </div>
    </div>

    <div class="w-full h-80 relative">
      <canvas id="audienceDetailedChart"></canvas>
    </div>
  </div>

</div>

<script>
  let detailChart = null;
  let currentAudiencePage = 'all';

  const audNow = new Date();
  let audPickerMode = 'overview';
  let audCalYear = audNow.getFullYear();
  let audCalMonth = audNow.getMonth();
  let audSelectedDay = audNow.getDate();

  function initDetailChart() {
    const ctx = document.getElementById('audienceDetailedChart');
    if (!ctx) return;

    detailChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          label: 'Real Traffic',
          data: [],
          backgroundColor: '#0071E3',
          borderRadius: 6,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#0F172A',
            padding: 10,
            cornerRadius: 8,
            callbacks: {
              label: function (context) {
                return ` Views: ${context.raw.toLocaleString()}`;
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { family: 'Inter', size: 11, weight: '500' }, color: '#64748B' }
          },
          y: {
            grid: { color: '#F1F5F9' },
            ticks: { font: { family: 'Inter', size: 11 }, color: '#94A3B8' },
            beginAtZero: true
          }
        }
      }
    });

    updateAudDisplayVal();
    renderAudCalendar();
    fetchAudienceChartData();
  }

  function toggleAudienceDatePicker() {
    const popover = document.getElementById('audienceDatePickerPopover');
    if (popover) popover.classList.toggle('hidden');
  }

  function changeAudCalYear(dir) {
    audCalYear += dir;
    renderAudCalendar();
  }

  function handleAudDateClick(day) {
    audSelectedDay = day;
    updateAudDisplayVal();
    renderAudCalendar();
    fetchAudienceChartData();
  }

  function handleAudMonthClick(mIdx) {
    audCalMonth = mIdx;
    updateAudDisplayVal();
    renderAudCalendar();
    fetchAudienceChartData();
  }

  function updateAudDisplayVal() {
    const displayElem = document.getElementById('audDatePickerDisplayVal');
    if (!displayElem) return;

    const mStr = audCalMonth + 1;
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    if (audPickerMode === 'monthly') {
      displayElem.innerText = `Month: ${monthNames[audCalMonth]} ${audCalYear}`;
    } else if (audPickerMode === 'daily') {
      displayElem.innerText = `${audSelectedDay} / ${mStr} / ${audCalYear}`;
    } else {
      const curDate = new Date(audCalYear, audCalMonth, audSelectedDay);
      const startDateObj = new Date(curDate);
      startDateObj.setDate(curDate.getDate() - 6);

      const startD = startDateObj.getDate();
      const startM = startDateObj.getMonth() + 1;
      const startY = startDateObj.getFullYear();

      displayElem.innerText = `${startD}/${startM}/${startY} - ${audSelectedDay}/${mStr}/${audCalYear}`;
    }
  }

  function renderAudCalendar() {
    const monthYearText = document.getElementById('audCalMonthYearText');
    const daysHeader = document.getElementById('audCalendarHeaderDays');
    const daysGrid = document.getElementById('audCalendarDaysGrid');
    const monthsGrid = document.getElementById('audCalendarMonthsGrid');

    if (!monthYearText || !daysGrid || !monthsGrid) return;

    const displayMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    monthYearText.innerText = `${displayMonthNames[audCalMonth]} ${audCalYear}`;

    if (audPickerMode === 'monthly') {
      daysHeader.classList.add('hidden');
      daysGrid.classList.add('hidden');
      monthsGrid.classList.remove('hidden');

      let html = '';
      for (let m = 0; m < 12; m++) {
        const isSelected = (m === audCalMonth);
        const activeClass = isSelected 
          ? 'bg-[#006FEE] text-white font-bold shadow-sm' 
          : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-semibold';

        html += `
          <button type="button" onclick="handleAudMonthClick(${m})" class="py-2.5 rounded-xl text-xs transition-all ${activeClass}">
            ${displayMonthNames[m].substring(0, 3)} (${m + 1})
          </button>
        `;
      }
      monthsGrid.innerHTML = html;
    } else {
      daysHeader.classList.remove('hidden');
      daysGrid.classList.remove('hidden');
      monthsGrid.classList.add('hidden');

      const firstDayIdx = new Date(audCalYear, audCalMonth, 1).getDay();
      const totalDaysInMonth = new Date(audCalYear, audCalMonth + 1, 0).getDate();
      const prevMonthDays = new Date(audCalYear, audCalMonth, 0).getDate();

      let html = '';

      for (let i = firstDayIdx - 1; i >= 0; i--) {
        const d = prevMonthDays - i;
        html += `<div class="h-9 flex items-center justify-center text-xs text-slate-300 font-medium">${d}</div>`;
      }

      const curDate = new Date(audCalYear, audCalMonth, audSelectedDay);
      const startDateObj = new Date(curDate);
      startDateObj.setDate(curDate.getDate() - 6);

      for (let day = 1; day <= totalDaysInMonth; day++) {
        const thisDate = new Date(audCalYear, audCalMonth, day);

        let bgClass = '';
        let textClass = 'text-slate-800 font-semibold hover:bg-slate-100 rounded-full';

        if (audPickerMode === 'daily') {
          if (day === audSelectedDay) {
            bgClass = 'bg-[#006FEE] text-white font-bold rounded-full shadow-sm';
            textClass = 'text-white';
          }
        } else {
          if (thisDate >= startDateObj && thisDate <= curDate) {
            if (day === audSelectedDay) {
              bgClass = 'bg-[#006FEE] text-white font-bold rounded-full shadow-sm';
              textClass = 'text-white';
            } else {
              bgClass = 'bg-[#E6F1FE] text-slate-900 font-semibold rounded-full';
            }
          }
        }

        html += `
          <div onclick="handleAudDateClick(${day})" class="h-9 flex items-center justify-center cursor-pointer">
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

  function setAudienceSelectMode(mode) {
    audPickerMode = mode;

    ['weekly', 'daily', 'monthly'].forEach(m => {
      const tabBtn = document.getElementById('audTab' + m.charAt(0).toUpperCase() + m.slice(1));
      if (!tabBtn) return;
      if ((mode === 'overview' && m === 'weekly') || m === mode) {
        tabBtn.className = 'aud-period-tab px-4 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs';
      } else {
        tabBtn.className = 'aud-period-tab px-4 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800';
      }
    });

    const cardTitle = document.getElementById('cardTodayTitle');
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    if (cardTitle) {
      if (mode === 'daily') {
        cardTitle.innerText = "Selected Date Views";
      } else if (mode === 'monthly') {
        cardTitle.innerText = `${monthNames[audCalMonth]} Total Views`;
      } else {
        cardTitle.innerText = "7-Day Overview Views";
      }
    }

    updateAudDisplayVal();
    renderAudCalendar();
    fetchAudienceChartData();
  }

  function toggleAudiencePageDropdown() {
    const menu = document.getElementById('audiencePageDropdownMenu');
    const arrow = document.getElementById('audienceDropdownArrow');
    if (menu && arrow) {
      menu.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
    }
  }

  function filterAudienceByPage(pageSlug, pageLabel) {
    currentAudiencePage = pageSlug;
    
    const textEl = document.getElementById('selectedAudiencePageText');
    if (textEl) textEl.innerText = pageLabel;

    ['pageLabelTotal', 'pageLabelToday', 'pageLabelUnique'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.innerText = pageLabel;
    });

    toggleAudiencePageDropdown();
    fetchAudienceChartData();
  }

  function fetchAudienceChartData() {
    const mStr = audCalMonth + 1;
    const formattedDate = `${audCalYear}-${mStr < 10 ? '0' + mStr : mStr}-${audSelectedDay < 10 ? '0' + audSelectedDay : audSelectedDay}`;

    let url = `{{ route('admin.audience.data') }}?period=${audPickerMode}&page=${encodeURIComponent(currentAudiencePage)}&date=${formattedDate}&month=${audCalMonth + 1}&year=${audCalYear}`;

    fetch(url)
      .then(res => res.json())
      .then(data => {
        if (detailChart) {
          detailChart.data.labels = data.labels || [];
          detailChart.data.datasets[0].data = data.data || [];
          detailChart.update();
        }

        const chartSum = (data.data && data.data.length > 0) ? data.data.reduce((a, b) => a + Number(b), 0) : 0;

        if (data.total !== undefined) {
          const totalEl = document.getElementById('statTotalViews');
          if (totalEl) totalEl.innerText = Number(data.total).toLocaleString();
        }

        if (data.todayViews !== undefined) {
          const todayEl = document.getElementById('statTodayViews');
          if (todayEl) {
            if (audPickerMode === 'daily') {
              todayEl.innerText = Number(data.todayViews).toLocaleString();
            } else {
              todayEl.innerText = Number(chartSum).toLocaleString();
            }
          }
        }

        if (data.uniqueVisitors !== undefined) {
          const uniqueEl = document.getElementById('statUniqueVisitors');
          if (uniqueEl) uniqueEl.innerText = Number(data.uniqueVisitors).toLocaleString();
        }
      })
      .catch(err => console.error("Error fetching audience data:", err));
  }

  function refreshAudienceData() {
    const spinner = document.getElementById('audienceRefreshSpinner');
    if (spinner) spinner.classList.add('rotate-180');

    setTimeout(() => {
      if (spinner) spinner.classList.remove('rotate-180');
      location.reload();
    }, 400);
  }

  document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('audienceDatePickerWrapper');
    const popover = document.getElementById('audienceDatePickerPopover');
    if (wrapper && popover && !wrapper.contains(e.target)) {
      popover.classList.add('hidden');
    }

    const pageWrapper = document.getElementById('audiencePageDropdownWrapper');
    const pageMenu = document.getElementById('audiencePageDropdownMenu');
    const pageArrow = document.getElementById('audienceDropdownArrow');
    if (pageWrapper && !pageWrapper.contains(e.target) && pageMenu && !pageMenu.classList.contains('hidden')) {
      pageMenu.classList.add('hidden');
      if (pageArrow) pageArrow.classList.remove('rotate-180');
    }
  });

  document.addEventListener('DOMContentLoaded', initDetailChart);
</script>