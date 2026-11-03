@php
  $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY'));
  $secretPrefix = 'admin/' . $secretKey;

  $nowKl = \Carbon\Carbon::now('Asia/Kuala_Lumpur');
  $period = request('period', 'overview');
  $rawDate = request('date', $nowKl->format('Y-m-d'));

  try {
      $selectedDateObj = \Carbon\Carbon::parse($rawDate, 'Asia/Kuala_Lumpur');
  } catch (\Throwable $e) {
      $selectedDateObj = $nowKl->copy();
  }

  $selectedYear  = (int) request('year', $selectedDateObj->year);
  $selectedMonth = (int) request('month', $selectedDateObj->month);
  $selectedDay   = (int) $selectedDateObj->day;
  $formattedDate = $selectedDateObj->format('Y-m-d');

  if ($period === 'daily') {
      $computedStart = $selectedDateObj->copy()->startOfDay();
      $computedEnd   = $selectedDateObj->copy()->endOfDay();
  } elseif ($period === 'monthly') {
      $computedStart = \Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1, 'Asia/Kuala_Lumpur')->startOfMonth();
      $computedEnd   = $computedStart->copy()->endOfMonth();
  } else {
      $computedEnd   = $selectedDateObj->copy()->endOfDay();
      $computedStart = $selectedDateObj->copy()->subDays(6)->startOfDay();
  }

  $startDate = isset($startDate) ? \Carbon\Carbon::parse($startDate) : $computedStart;
  $endDate   = isset($endDate) ? \Carbon\Carbon::parse($endDate) : $computedEnd;

  if (\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
      $baseQuery = \Illuminate\Support\Facades\DB::table('audit_logs')
          ->whereBetween('audit_logs.created_at', [
              $startDate->format('Y-m-d H:i:s'),
              $endDate->format('Y-m-d H:i:s'),
          ]);

      $totalLogs           = (clone $baseQuery)->count();
      $loginSuccessCount   = (clone $baseQuery)->where('event', 'login_success')->count();
      $loginFailedCount    = (clone $baseQuery)->where('event', 'login_failed')->count();
      $securityAlertsCount = (clone $baseQuery)->whereIn('event', ['login_failed', 'password_changed'])->count();

      $listQuery = (clone $baseQuery)
          ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
          ->select('audit_logs.*', 'users.name as user_name', 'users.email as user_email')
          ->orderBy('audit_logs.id', 'desc');

      if (request()->filled('search')) {
          $search = trim(request('search'));
          $listQuery->where(function ($q) use ($search) {
              $q->where('audit_logs.event', 'like', "%{$search}%")
                ->orWhere('audit_logs.ip_address', 'like', "%{$search}%")
                ->orWhere('users.name', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('audit_logs.payload', 'like', "%{$search}%");
          });
      }

      if (request()->filled('event') && request('event') !== 'all') {
          $listQuery->where('audit_logs.event', request('event'));
      }

      $logs = $listQuery->paginate(10)->withQueryString();
  } else {
      $logs                = collect();
      $totalLogs           = 0;
      $loginSuccessCount   = 0;
      $loginFailedCount    = 0;
      $securityAlertsCount = 0;
  }

  $currentEvent = request('event', 'all');
  $eventOptions = [
      'all'              => 'All Event Types',
      'login_success'    => 'User Logged In',
      'login_failed'     => 'Failed Login Attempt',
      'password_changed' => 'Password Updated',
      'logout'           => 'Terminal Logout',
      'product_created'  => 'Product Created',
      'product_updated'  => 'Product Updated',
      'product_deleted'  => 'Product Deleted',
      'resource_created' => 'Article Published',
      'resource_updated' => 'Article Updated',
      'resource_deleted' => 'Article Deleted',
  ];
  $selectedEventLabel = $eventOptions[$currentEvent] ?? 'All Event Types';
@endphp

<div class="m-0 flex flex-col gap-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Audit &amp; Security Logs
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
        Monitor system activities, authentication sessions, and administrator transactions in real time.
      </p>
    </div>

    <div class="flex items-center gap-2.5 shrink-0">
      <a href="{{ url()->current() }}"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs shadow-2xs transition-all active:scale-[0.98] cursor-pointer">
        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Refresh Logs</span>
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Recorded Events</span>
      <span class="font-extrabold text-2xl text-slate-900 tracking-tight mt-1">{{ number_format($totalLogs) }}</span>
      <span class="text-[11px] text-slate-400 font-medium mt-1">
        {{ $period === 'daily' ? 'On ' . $startDate->format('d M Y') : $startDate->format('d M') . ' - ' . $endDate->format('d M Y') }}
      </span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Successful Logins</span>
      <span class="font-extrabold text-2xl text-emerald-600 tracking-tight mt-1">{{ number_format($loginSuccessCount) }}</span>
      <span class="text-[11px] text-emerald-600/70 font-medium mt-1">Authenticated entries</span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Failed Attempts (Blocked)</span>
      <span class="font-extrabold text-2xl text-rose-600 tracking-tight mt-1">{{ number_format($loginFailedCount) }}</span>
      <span class="text-[11px] text-rose-600/70 font-medium mt-1">Unauthorized access blocked</span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Security Alerts</span>
      <span class="font-extrabold text-2xl text-amber-600 tracking-tight mt-1">{{ number_format($securityAlertsCount) }}</span>
      <span class="text-[11px] text-amber-600/70 font-medium mt-1">Warnings &amp; password changes</span>
    </div>
  </div>

  <form method="GET" action="{{ url()->current() }}" id="auditFilterForm" class="relative z-30 bg-white border border-slate-200 rounded-2xl p-3 sm:p-4 shadow-2xs flex flex-col xl:flex-row xl:items-center justify-between gap-4 m-0">
    <input type="hidden" name="event" id="auditEventInput" value="{{ $currentEvent }}">
    <input type="hidden" name="period" id="auditPeriodInput" value="{{ $period }}">
    <input type="hidden" name="date" id="auditDateInput" value="{{ $formattedDate }}">
    <input type="hidden" name="month" id="auditMonthInput" value="{{ $selectedMonth }}">
    <input type="hidden" name="year" id="auditYearInput" value="{{ $selectedYear }}">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full xl:w-auto">
      <div class="relative w-full sm:w-56" id="customEventDropdownWrapper">
        <button type="button" onclick="toggleEventDropdown()" id="selectedEventBtn"
          class="w-full bg-slate-100/90 border border-slate-200 hover:border-brand/50 rounded-xl px-4 py-2 flex items-center justify-between gap-2 text-xs font-bold text-slate-800 shadow-2xs transition-all cursor-pointer">
          <span id="selectedEventText" class="truncate">{{ $selectedEventLabel }}</span>
          <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" id="eventDropdownArrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <div id="eventDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-2xl z-50 p-1.5 flex flex-col gap-1 max-h-72 overflow-y-auto">
          @foreach($eventOptions as $eventKey => $eventLabel)
            <button type="button" onclick="selectAuditEventFilter('{{ $eventKey }}', '{{ $eventLabel }}')"
              class="w-full text-left px-3.5 py-2 rounded-xl text-xs font-bold {{ $currentEvent === $eventKey ? 'bg-slate-100 text-brand' : 'text-slate-700 hover:bg-slate-100 hover:text-brand' }} flex items-center justify-between transition-colors cursor-pointer">
              <span class="truncate">{{ $eventLabel }}</span>
              @if($currentEvent === $eventKey)
                <svg class="w-3.5 h-3.5 text-brand shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
              @endif
            </button>
          @endforeach
        </div>
      </div>

      <div class="relative w-full sm:w-64">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search IP, user, or activity..."
          class="w-full bg-slate-50/70 focus:bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <button type="submit" class="px-4 py-2 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-2xs transition-all cursor-pointer shrink-0">
        Filter
      </button>

      @if(request()->filled('search') || (request()->filled('event') && request('event') !== 'all') || request()->filled('period'))
        <a href="{{ url()->current() }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-colors shrink-0 text-center">
          Reset
        </a>
      @endif
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full xl:w-auto">
      <div class="inline-flex items-center bg-slate-200/60 p-1 rounded-full text-xs font-medium shrink-0">
        <button type="button" onclick="setAuditSelectMode('overview')" id="audTabWeekly"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all cursor-pointer {{ $period === 'overview' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
          Overview
        </button>
        <button type="button" onclick="setAuditSelectMode('daily')" id="audTabDaily"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all cursor-pointer {{ $period === 'daily' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
          Daily
        </button>
        <button type="button" onclick="setAuditSelectMode('monthly')" id="audTabMonthly"
          class="aud-period-tab px-4 py-1.5 rounded-full transition-all cursor-pointer {{ $period === 'monthly' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
          Monthly
        </button>
      </div>

      <div class="relative inline-block" id="auditDatePickerWrapper">
        <div onclick="toggleAuditDatePicker()"
          class="inline-flex items-center justify-between gap-3 bg-white border border-slate-200/80 rounded-2xl px-4 py-2 text-xs font-semibold text-slate-700 shadow-xs cursor-pointer hover:bg-slate-50/80 transition-all shrink-0 w-full sm:w-auto">
          <span id="audDatePickerDisplayVal" class="text-slate-700 whitespace-nowrap">Loading Date...</span>
          <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
          </svg>
        </div>

        <div id="auditDatePickerPopover"
          class="hidden absolute right-0 top-full mt-2 w-[310px] bg-white border border-slate-200/90 rounded-3xl shadow-2xl p-4 z-50 transition-all">
          <div class="flex items-center justify-between px-1 mb-4">
            <div class="flex items-center gap-1 font-bold text-slate-900 text-sm">
              <span id="audCalMonthYearText">Date</span>
            </div>
            <div class="flex items-center gap-3">
              <button type="button" onclick="changeAuditCalYear(-1)" class="text-sky-600 hover:text-sky-700 p-1 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <button type="button" onclick="changeAuditCalYear(1)" class="text-sky-600 hover:text-sky-700 p-1 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>

          <div id="audCalendarHeaderDays" class="grid grid-cols-7 text-center mb-2">
            <span class="text-xs font-semibold text-slate-400">Sun</span>
            <span class="text-xs font-semibold text-slate-400">Mon</span>
            <span class="text-xs font-semibold text-slate-400">Tue</span>
            <span class="text-xs font-semibold text-slate-400">Wed</span>
            <span class="text-xs font-semibold text-slate-400">Thu</span>
            <span class="text-xs font-semibold text-slate-400">Fri</span>
            <span class="text-xs font-semibold text-slate-400">Sat</span>
          </div>

          <div id="audCalendarDaysGrid" class="grid grid-cols-7 gap-y-1"></div>
          <div id="audCalendarMonthsGrid" class="hidden grid grid-cols-3 gap-2"></div>
        </div>
      </div>
    </div>
  </form>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white">
      <div>
        <h2 class="font-bold text-sm sm:text-base text-slate-900 tracking-tight">System Audit Log Stream</h2>
        <p class="text-xs text-slate-500 font-medium mt-0.5">
          Filtered activity from <strong class="text-slate-800 font-semibold">{{ $startDate->format('d M Y') }}</strong> to <strong class="text-slate-800 font-semibold">{{ $endDate->format('d M Y') }}</strong>
        </p>
      </div>
      <span class="text-xs font-semibold text-slate-400 whitespace-nowrap">
        Showing {{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($logs->firstItem() ?? 0) : 0 }}&ndash;{{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($logs->lastItem() ?? 0) : 0 }} of {{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $logs->total() : (isset($logs) ? count($logs) : 0) }} records
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse min-w-[760px]">
        <thead>
          <tr class="bg-slate-50/80 border-b border-slate-200/80">
            <th class="py-3.5 px-5 sm:px-6 w-[38%] text-slate-700 font-bold text-xs border-r border-slate-200/60">
              Activity &amp; Description
            </th>
            <th class="py-3.5 px-4 sm:px-5 w-[24%] text-slate-700 font-bold text-xs border-r border-slate-200/60">
              User / Actor
            </th>
            <th class="py-3.5 px-4 sm:px-5 w-[14%] text-slate-700 font-bold text-xs text-center border-r border-slate-200/60">
              Status
            </th>
            <th class="py-3.5 px-4 sm:px-5 w-[12%] text-slate-700 font-bold text-xs text-center border-r border-slate-200/60">
              IP Address
            </th>
            <th class="py-3.5 px-5 sm:px-6 w-[12%] text-slate-700 font-bold text-xs text-right">
              Date &amp; Time
            </th>
          </tr>
        </thead>

        <tbody class="text-xs divide-y divide-slate-100">
          @if(isset($logs) && count($logs) > 0)
            @foreach($logs as $log)
              @php
                $payload = is_string($log->payload) ? json_decode($log->payload, true) : (array)$log->payload;
                $itemTitle = $payload['title'] ?? null;

                $eventTitle  = ucwords(str_replace('_', ' ', $log->event));
                $eventDesc   = $itemTitle ? "Target item: {$itemTitle}" : 'System action has been executed.';
                $statusLabel = 'Recorded';
                $statusPill  = 'bg-slate-100 text-slate-700 border-slate-200';

                if ($log->event === 'login_success') {
                  $eventTitle  = 'User Logged In';
                  $eventDesc   = 'Successful authentication session created.';
                  $statusLabel = 'Authenticated';
                  $statusPill  = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                } elseif ($log->event === 'login_failed') {
                  $eventTitle  = 'Failed Login Attempt';
                  $eventDesc   = 'Unauthorized access attempt blocked.';
                  $statusLabel = 'Blocked';
                  $statusPill  = 'bg-rose-50 text-rose-700 border-rose-200/80';
                } elseif ($log->event === 'password_changed') {
                  $eventTitle  = 'Password Updated';
                  $eventDesc   = 'Account security credentials changed.';
                  $statusLabel = 'Security Update';
                  $statusPill  = 'bg-amber-50 text-amber-700 border-amber-200/80';
                } elseif ($log->event === 'logout') {
                  $eventTitle  = 'Terminal Logout';
                  $eventDesc   = 'User session ended successfully.';
                  $statusLabel = 'Signed Out';
                  $statusPill  = 'bg-slate-100 text-slate-600 border-slate-200';
                } elseif ($log->event === 'product_created') {
                  $eventTitle  = 'Product Formulation Added';
                  $eventDesc   = $itemTitle ? "Published new formulation: {$itemTitle}" : 'New product added to catalog.';
                  $statusLabel = 'Created';
                  $statusPill  = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                } elseif ($log->event === 'product_updated') {
                  $eventTitle  = 'Product Formulation Updated';
                  $eventDesc   = $itemTitle ? "Modified formulation details: {$itemTitle}" : 'Product inventory details updated.';
                  $statusLabel = 'Modified';
                  $statusPill  = 'bg-blue-50 text-blue-700 border-blue-200/80';
                } elseif ($log->event === 'product_deleted') {
                  $eventTitle  = 'Product Formulation Removed';
                  $eventDesc   = $itemTitle ? "Deleted formulation: {$itemTitle}" : 'Product permanently removed.';
                  $statusLabel = 'Deleted';
                  $statusPill  = 'bg-rose-50 text-rose-700 border-rose-200/80';
                } elseif ($log->event === 'resource_created') {
                  $eventTitle  = 'Educational Article Published';
                  $eventDesc   = $itemTitle ? "Published new article: {$itemTitle}" : 'New educational monograph published.';
                  $statusLabel = 'Published';
                  $statusPill  = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                } elseif ($log->event === 'resource_updated') {
                  $eventTitle  = 'Educational Article Updated';
                  $eventDesc   = $itemTitle ? "Modified article content: {$itemTitle}" : 'Educational monograph updated.';
                  $statusLabel = 'Modified';
                  $statusPill  = 'bg-blue-50 text-blue-700 border-blue-200/80';
                } elseif ($log->event === 'resource_deleted') {
                  $eventTitle  = 'Educational Article Removed';
                  $eventDesc   = $itemTitle ? "Deleted article: {$itemTitle}" : 'Educational monograph removed.';
                  $statusLabel = 'Deleted';
                  $statusPill  = 'bg-rose-50 text-rose-700 border-rose-200/80';
                }

                $actor = $log->user_name ?? ($payload['attempted_email'] ?? $payload['email'] ?? 'System Administrator');
              @endphp

              <tr class="group hover:bg-slate-50/70 transition-colors duration-150">
                <td class="py-3.5 px-5 sm:px-6 border-r border-slate-200/60 align-middle">
                  <div class="min-w-0">
                    <p class="font-bold text-slate-900 text-xs sm:text-[13px] leading-snug">
                      {{ $eventTitle }}
                    </p>
                    <p class="text-slate-500 font-medium text-xs mt-0.5 line-clamp-1">
                      {{ $eventDesc }}
                    </p>
                  </div>
                </td>

                <td class="py-3.5 px-4 sm:px-5 border-r border-slate-200/60 align-middle">
                  <div class="min-w-0">
                    <span class="font-bold text-slate-800 text-xs block truncate">{{ $actor }}</span>
                    @if(!empty($log->user_email))
                      <span class="text-[11px] text-slate-400 font-medium block truncate mt-0.5">{{ $log->user_email }}</span>
                    @else
                      <span class="text-[11px] text-slate-400 font-medium block truncate mt-0.5">Internal session</span>
                    @endif
                  </div>
                </td>

                <td class="py-3.5 px-4 sm:px-5 text-center border-r border-slate-200/60 align-middle">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusPill }}">
                    {{ $statusLabel }}
                  </span>
                </td>

                <td class="py-3.5 px-4 sm:px-5 text-center border-r border-slate-200/60 align-middle">
                  <span class="text-xs font-semibold text-slate-700 font-mono">
                    {{ $log->ip_address ?? '127.0.0.1' }}
                  </span>
                </td>

                <td class="py-3.5 px-5 sm:px-6 text-right align-middle whitespace-nowrap">
                  <span class="font-bold text-slate-800 text-xs block">
                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
                  </span>
                  <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                    {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                  </span>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="p-12 text-center bg-white text-slate-400 text-xs font-medium">
                No audit log activity records found for this selected period.
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator && $logs->hasPages())
    @php
      $currentPage = $logs->currentPage();
      $lastPage = $logs->lastPage();
      $paginationElements = [];

      if ($lastPage <= 7) {
          $paginationElements = range(1, $lastPage);
      } else {
          if ($currentPage <= 4) {
              $paginationElements = array_merge(range(1, 5), ['...', $lastPage]);
          } elseif ($currentPage >= $lastPage - 3) {
              $paginationElements = array_merge([1, '...'], range($lastPage - 4, $lastPage));
          } else {
              $paginationElements = array_merge([1, '...'], range($currentPage - 1, $currentPage + 1), ['...', $lastPage]);
          }
      }
    @endphp

    <div class="flex items-center justify-between bg-white rounded-full px-5 sm:px-7 py-3 border border-slate-200 shadow-2xs">
      <div class="flex items-center gap-3 sm:gap-6">
        @if ($logs->onFirstPage())
          <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 cursor-not-allowed select-none">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Previous</span>
          </span>
        @else
          <a href="{{ $logs->previousPageUrl() }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Previous</span>
          </a>
        @endif

        <div class="flex items-center gap-1 sm:gap-2">
          @foreach ($paginationElements as $element)
            @if ($element === '...')
              <span class="w-7 h-7 flex items-center justify-center text-xs font-bold text-slate-400 select-none">...</span>
            @elseif ($element == $currentPage)
              <span class="w-8 h-8 rounded-full bg-brand text-white font-bold text-xs flex items-center justify-center ring-4 ring-brand/20 shadow-xs select-none">
                {{ $element }}
              </span>
            @else
              <a href="{{ $logs->url($element) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                {{ $element }}
              </a>
            @endif
          @endforeach
        </div>

        @if ($logs->hasMorePages())
          <a href="{{ $logs->nextPageUrl() }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors">
            <span>Next</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </a>
        @else
          <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 cursor-not-allowed select-none">
            <span>Next</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </span>
        @endif
      </div>

      <div class="text-xs font-medium text-slate-500 whitespace-nowrap hidden md:block">
        Showing {{ number_format($logs->lastItem() ?? 0) }} of {{ number_format($logs->total()) }} results
      </div>
    </div>
  @endif

</div>

<script>
  const displayMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  let auditPickerMode = "{{ $period }}";
  let auditCalYear = {{ $selectedYear }};
  let auditCalMonth = {{ $selectedMonth - 1 }};
  let auditSelectedDay = {{ $selectedDay }};

  function initAuditCalendar() {
    updateAuditDisplayVal();
    renderAuditCalendar();
  }

  function toggleAuditDatePicker() {
    const popover = document.getElementById('auditDatePickerPopover');
    if (popover) popover.classList.toggle('hidden');
  }

  function changeAuditCalYear(dir) {
    auditCalYear += dir;
    renderAuditCalendar();
  }

  function handleAuditDateClick(day) {
    auditSelectedDay = day;
    const mStr = auditCalMonth + 1;
    const formatted = `${auditCalYear}-${mStr < 10 ? '0' + mStr : mStr}-${auditSelectedDay < 10 ? '0' + auditSelectedDay : auditSelectedDay}`;

    document.getElementById('auditDateInput').value = formatted;
    document.getElementById('auditMonthInput').value = mStr;
    document.getElementById('auditYearInput').value = auditCalYear;
    document.getElementById('auditPeriodInput').value = auditPickerMode;

    const popover = document.getElementById('auditDatePickerPopover');
    if (popover) popover.classList.add('hidden');

    document.getElementById('auditFilterForm').submit();
  }

  function handleAuditMonthClick(mIdx) {
    auditCalMonth = mIdx;
    const mStr = auditCalMonth + 1;
    const formatted = `${auditCalYear}-${mStr < 10 ? '0' + mStr : mStr}-01`;

    document.getElementById('auditDateInput').value = formatted;
    document.getElementById('auditMonthInput').value = mStr;
    document.getElementById('auditYearInput').value = auditCalYear;
    document.getElementById('auditPeriodInput').value = 'monthly';

    const popover = document.getElementById('auditDatePickerPopover');
    if (popover) popover.classList.add('hidden');

    document.getElementById('auditFilterForm').submit();
  }

  function updateAuditDisplayVal() {
    const displayElem = document.getElementById('audDatePickerDisplayVal');
    if (!displayElem) return;

    const mStr = auditCalMonth + 1;

    if (auditPickerMode === 'monthly') {
      displayElem.innerText = `Month: ${displayMonthNames[auditCalMonth]} ${auditCalYear}`;
    } else if (auditPickerMode === 'daily') {
      displayElem.innerText = `${auditSelectedDay} / ${mStr} / ${auditCalYear}`;
    } else {
      const curDate = new Date(auditCalYear, auditCalMonth, auditSelectedDay);
      const startDateObj = new Date(curDate);
      startDateObj.setDate(curDate.getDate() - 6);

      const startD = startDateObj.getDate();
      const startM = startDateObj.getMonth() + 1;
      const startY = startDateObj.getFullYear();

      displayElem.innerText = `${startD}/${startM}/${startY} - ${auditSelectedDay}/${mStr}/${auditCalYear}`;
    }
  }

  function renderAuditCalendar() {
    const monthYearText = document.getElementById('audCalMonthYearText');
    const daysHeader = document.getElementById('audCalendarHeaderDays');
    const daysGrid = document.getElementById('audCalendarDaysGrid');
    const monthsGrid = document.getElementById('audCalendarMonthsGrid');

    if (!monthYearText || !daysGrid || !monthsGrid) return;

    monthYearText.innerText = `${displayMonthNames[auditCalMonth]} ${auditCalYear}`;

    if (auditPickerMode === 'monthly') {
      daysHeader.classList.add('hidden');
      daysGrid.classList.add('hidden');
      monthsGrid.classList.remove('hidden');

      let html = '';
      for (let m = 0; m < 12; m++) {
        const isSelected = (m === auditCalMonth);
        const activeClass = isSelected 
          ? 'bg-brand text-white font-bold shadow-xs' 
          : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-semibold';

        html += `
          <button type="button" onclick="handleAuditMonthClick(${m})" class="py-2.5 px-2 rounded-xl text-xs transition-all text-center truncate ${activeClass} cursor-pointer">
            ${displayMonthNames[m]}
          </button>
        `;
      }
      monthsGrid.innerHTML = html;
    } else {
      daysHeader.classList.remove('hidden');
      daysGrid.classList.remove('hidden');
      monthsGrid.classList.add('hidden');

      const firstDayIdx = new Date(auditCalYear, auditCalMonth, 1).getDay();
      const totalDaysInMonth = new Date(auditCalYear, auditCalMonth + 1, 0).getDate();
      const prevMonthDays = new Date(auditCalYear, auditCalMonth, 0).getDate();

      let html = '';

      for (let i = firstDayIdx - 1; i >= 0; i--) {
        const d = prevMonthDays - i;
        html += `<div class="h-9 flex items-center justify-center text-xs text-slate-300 font-medium">${d}</div>`;
      }

      const curDate = new Date(auditCalYear, auditCalMonth, auditSelectedDay);
      const startDateObj = new Date(curDate);
      startDateObj.setDate(curDate.getDate() - 6);

      for (let day = 1; day <= totalDaysInMonth; day++) {
        const thisDate = new Date(auditCalYear, auditCalMonth, day);

        let bgClass = '';
        let textClass = 'text-slate-800 font-semibold hover:bg-slate-100 rounded-full';

        if (auditPickerMode === 'daily') {
          if (day === auditSelectedDay) {
            bgClass = 'bg-brand text-white font-bold rounded-full shadow-xs';
            textClass = 'text-white';
          }
        } else {
          if (thisDate >= startDateObj && thisDate <= curDate) {
            if (day === auditSelectedDay) {
              bgClass = 'bg-brand text-white font-bold rounded-full shadow-xs';
              textClass = 'text-white';
            } else {
              bgClass = 'bg-brand/10 text-brand font-semibold rounded-full';
            }
          }
        }

        html += `
          <div onclick="handleAuditDateClick(${day})" class="h-9 flex items-center justify-center cursor-pointer">
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

  function setAuditSelectMode(mode) {
    if (auditPickerMode === mode) return;

    auditPickerMode = mode;
    document.getElementById('auditPeriodInput').value = mode;

    const realNow = new Date();
    auditCalYear = realNow.getFullYear();
    auditCalMonth = realNow.getMonth();
    auditSelectedDay = realNow.getDate();

    const mStr = auditCalMonth + 1;
    const formatted = `${auditCalYear}-${mStr < 10 ? '0' + mStr : mStr}-${auditSelectedDay < 10 ? '0' + auditSelectedDay : auditSelectedDay}`;
    document.getElementById('auditDateInput').value = formatted;
    document.getElementById('auditMonthInput').value = mStr;
    document.getElementById('auditYearInput').value = auditCalYear;

    document.getElementById('auditFilterForm').submit();
  }

  function toggleEventDropdown() {
    const menu = document.getElementById('eventDropdownMenu');
    const arrow = document.getElementById('eventDropdownArrow');
    if (!menu) return;
    menu.classList.toggle('hidden');
    if (arrow) arrow.classList.toggle('rotate-180');
  }

  function selectAuditEventFilter(eventValue, eventLabel) {
    const input = document.getElementById('auditEventInput');
    const label = document.getElementById('selectedEventText');
    const menu = document.getElementById('eventDropdownMenu');
    const arrow = document.getElementById('eventDropdownArrow');
    const form = document.getElementById('auditFilterForm');

    if (input) input.value = eventValue;
    if (label) label.innerText = eventLabel;
    if (menu) menu.classList.add('hidden');
    if (arrow) arrow.classList.remove('rotate-180');
    if (form) form.submit();
  }

  document.addEventListener('click', function(e) {
    const eventWrapper = document.getElementById('customEventDropdownWrapper');
    const eventMenu = document.getElementById('eventDropdownMenu');
    const eventArrow = document.getElementById('eventDropdownArrow');
    if (eventWrapper && !eventWrapper.contains(e.target) && eventMenu && !eventMenu.classList.contains('hidden')) {
      eventMenu.classList.add('hidden');
      if (eventArrow) eventArrow.classList.remove('rotate-180');
    }

    const dateWrapper = document.getElementById('auditDatePickerWrapper');
    const datePopover = document.getElementById('auditDatePickerPopover');
    if (dateWrapper && datePopover && !dateWrapper.contains(e.target)) {
      datePopover.classList.add('hidden');
    }
  });

  document.addEventListener('DOMContentLoaded', initAuditCalendar);
</script>