@php
  $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia'));
  $secretPrefix = 'admin/' . $secretKey;

  if (!isset($logs)) {
      if (\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
          $query = \Illuminate\Support\Facades\DB::table('audit_logs')
              ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
              ->select('audit_logs.*', 'users.name as user_name', 'users.email as user_email')
              ->orderBy('audit_logs.created_at', 'desc');

          if (request()->filled('search')) {
              $search = trim(request('search'));
              $query->where(function ($q) use ($search) {
                  $q->where('audit_logs.event', 'like', "%{$search}%")
                    ->orWhere('audit_logs.ip_address', 'like', "%{$search}%")
                    ->orWhere('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
              });
          }

          if (request()->filled('event') && request('event') !== 'all') {
              $query->where('audit_logs.event', request('event'));
          }

          $logs = $query->paginate(15)->withQueryString();

          $totalLogs = \Illuminate\Support\Facades\DB::table('audit_logs')->count();
          $loginSuccessCount = \Illuminate\Support\Facades\DB::table('audit_logs')->where('event', 'login_success')->count();
          $loginFailedCount = \Illuminate\Support\Facades\DB::table('audit_logs')->where('event', 'login_failed')->count();
          $securityAlertsCount = \Illuminate\Support\Facades\DB::table('audit_logs')->whereIn('event', ['login_failed', 'password_changed'])->count();
      } else {
          $logs = collect();
          $totalLogs = 0;
          $loginSuccessCount = 0;
          $loginFailedCount = 0;
          $securityAlertsCount = 0;
      }
  }

  $totalLogs = $totalLogs ?? 0;
  $loginSuccessCount = $loginSuccessCount ?? 0;
  $loginFailedCount = $loginFailedCount ?? 0;
  $securityAlertsCount = $securityAlertsCount ?? 0;
  $logs = $logs ?? collect();

  $currentEvent = request('event', 'all');
  $eventOptions = [
      'all'              => 'All Event Types',
      'login_success'    => 'User Logged In',
      'login_failed'     => 'Failed Login Attempt',
      'password_changed' => 'Password Updated',
      'logout'           => 'Terminal Logout',
  ];
  $selectedEventLabel = $eventOptions[$currentEvent] ?? 'All Event Types';
@endphp

<div class="m-0 flex flex-col gap-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200">
    <div>
      <div class="flex items-center gap-2.5">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
          Audit &amp; Security Logs
        </h1>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-tight bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
          {{ number_format($totalLogs) }} Total {{ $totalLogs === 1 ? 'Event' : 'Events' }}
        </span>
      </div>
      <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
        Monitor system activities, authentication sessions, and administrator transactions in real time.
      </p>
    </div>

    <div class="flex items-center gap-2.5 shrink-0">
      <a href="{{ request()->url() }}"
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
      <span class="text-xs font-bold text-slate-500">Total Recorded Events</span>
      <span class="font-extrabold text-2xl text-slate-900 tracking-tight mt-1">{{ number_format($totalLogs) }}</span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Successful Logins</span>
      <span class="font-extrabold text-2xl text-emerald-600 tracking-tight mt-1">{{ number_format($loginSuccessCount) }}</span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Failed Attempts (Blocked)</span>
      <span class="font-extrabold text-2xl text-rose-600 tracking-tight mt-1">{{ number_format($loginFailedCount) }}</span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col justify-between min-h-[95px] shadow-2xs">
      <span class="text-xs font-bold text-slate-500">Security Alerts</span>
      <span class="font-extrabold text-2xl text-amber-600 tracking-tight mt-1">{{ number_format($securityAlertsCount) }}</span>
    </div>
  </div>

  <form method="GET" action="{{ url()->current() }}" id="auditFilterForm" class="relative z-30 bg-white border border-slate-200 rounded-xl p-3 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-3 m-0">
    <input type="hidden" name="event" id="auditEventInput" value="{{ $currentEvent }}">

    <div class="flex flex-wrap items-center gap-2.5 w-full lg:w-auto">
      <div class="relative w-full sm:w-60" id="customEventDropdownWrapper">
        <button type="button" onclick="toggleEventDropdown()" id="selectedEventBtn"
          class="w-full bg-slate-100/90 border border-slate-200 hover:border-brand/50 rounded-xl px-4 py-2 flex items-center justify-between gap-2 text-xs font-bold text-slate-800 shadow-2xs transition-all cursor-pointer">
          <span id="selectedEventText" class="truncate">{{ $selectedEventLabel }}</span>
          <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" id="eventDropdownArrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <div id="eventDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-2xl z-50 p-1.5 flex flex-col gap-1">
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
    </div>

    <div class="flex items-center gap-2.5 w-full lg:w-auto">
      <div class="relative flex-1 sm:w-72">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search IP address, user, or activity..."
          class="w-full bg-slate-50/70 focus:bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <button type="submit" class="px-4 py-2 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-2xs transition-all cursor-pointer shrink-0">
        Filter
      </button>

      @if(request()->filled('search') || (request()->filled('event') && request('event') !== 'all'))
        <a href="{{ url()->current() }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-colors shrink-0">
          Reset
        </a>
      @endif
    </div>
  </form>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white">
      <div>
        <h2 class="font-bold text-sm sm:text-base text-slate-900 tracking-tight">System Audit Log Stream</h2>
        <p class="text-xs text-slate-500 font-medium mt-0.5">Detailed security records tracked directly from the database.</p>
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
                $eventTitle  = 'Activity Logged';
                $eventDesc   = 'System action has been executed.';
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
                } else {
                  $eventTitle = ucwords(str_replace('_', ' ', $log->event));
                }

                $payload = is_string($log->payload) ? json_decode($log->payload, true) : (array)$log->payload;
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
                  <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200/80 text-[11px] font-semibold text-slate-700 font-mono inline-block">
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
                No audit log activity records found in the database.
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator && $logs->hasPages())
      <div class="px-5 py-4 bg-slate-50/50 border-t border-slate-200/80">
        {{ $logs->links() }}
      </div>
    @endif
  </div>

</div>

<script>
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
    const wrapper = document.getElementById('customEventDropdownWrapper');
    const menu = document.getElementById('eventDropdownMenu');
    const arrow = document.getElementById('eventDropdownArrow');
    if (wrapper && !wrapper.contains(e.target) && menu && !menu.classList.contains('hidden')) {
      menu.classList.add('hidden');
      if (arrow) arrow.classList.remove('rotate-180');
    }
  });
</script>