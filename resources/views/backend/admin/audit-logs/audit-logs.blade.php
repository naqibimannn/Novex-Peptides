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
@endphp

<div class="space-y-5">
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-2">
    <div>
      <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Audit &amp; Security Logs</h2>
      <p class="text-xs text-slate-400 mt-0.5">Monitor all system activities, login attempts, and administrator transactions in real time.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ request()->url() }}" 
         class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white text-slate-600 hover:text-slate-900 shadow-sm text-xs font-semibold transition-all">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Refresh</span>
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[95px] shadow-sm">
      <span class="text-xs font-semibold text-slate-500">Total Recorded Events</span>
      <span class="font-extrabold text-2xl text-slate-900 tracking-tight mt-1">{{ number_format($totalLogs ?? 0) }}</span>
    </div>

    <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[95px] shadow-sm">
      <span class="text-xs font-semibold text-slate-500">Successful Logins</span>
      <span class="font-extrabold text-2xl text-emerald-600 tracking-tight mt-1">{{ number_format($loginSuccessCount ?? 0) }}</span>
    </div>

    <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[95px] shadow-sm">
      <span class="text-xs font-semibold text-slate-500">Failed Attempts (Blocked)</span>
      <span class="font-extrabold text-2xl text-rose-600 tracking-tight mt-1">{{ number_format($loginFailedCount ?? 0) }}</span>
    </div>

    <div class="bg-white border-0 rounded-2xl p-4 flex flex-col justify-between min-h-[95px] shadow-sm">
      <span class="text-xs font-semibold text-slate-500">Security Alerts</span>
      <span class="font-extrabold text-2xl text-amber-500 tracking-tight mt-1">{{ number_format($securityAlertsCount ?? 0) }}</span>
    </div>
  </div>

  <div class="bg-white border-0 rounded-2xl p-4 shadow-sm">
    <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row items-center justify-between gap-3 m-0">
      <div class="relative w-full md:w-80">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search IP, username, or event..."
          class="w-full bg-slate-50 border-0 rounded-xl py-2 pl-9 pr-3 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-blue/20 transition-all">
      </div>

      <div class="flex items-center gap-2 w-full md:w-auto">
        <select name="event" onchange="this.form.submit()"
          class="bg-slate-50 border-0 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-blue/20 transition-all cursor-pointer">
          <option value="all" {{ request('event') == 'all' ? 'selected' : '' }}>All Event Types</option>
          <option value="login_success" {{ request('event') == 'login_success' ? 'selected' : '' }}>User Logged In</option>
          <option value="login_failed" {{ request('event') == 'login_failed' ? 'selected' : '' }}>Failed Login Attempt</option>
          <option value="password_changed" {{ request('event') == 'password_changed' ? 'selected' : '' }}>Password Updated</option>
          <option value="logout" {{ request('event') == 'logout' ? 'selected' : '' }}>Terminal Logout</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-brand-blue hover:bg-brand-deep text-white rounded-xl text-xs font-semibold shadow-xs transition-colors cursor-pointer">
          Filter
        </button>

        @if(request()->filled('search') || (request()->filled('event') && request('event') !== 'all'))
          <a href="{{ url()->current() }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition-colors">
            Reset
          </a>
        @endif
      </div>
    </form>
  </div>

  <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-[0_8px_30px_-4px_rgba(9,54,76,0.06)] overflow-hidden">
    <div class="p-5 border-b border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-white">
      <div>
        <h3 class="font-head font-extrabold text-sm sm:text-base text-brand-deep tracking-tight">System Audit Log Stream</h3>
        <p class="text-xs text-slate-400 mt-0.5">Detailed records tracked directly from the database.</p>
      </div>
      <span class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200/60">
        Showing {{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($logs->firstItem() ?? 0) : 0 }} - {{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($logs->lastItem() ?? 0) : 0 }} of {{ ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $logs->total() : (isset($logs) ? count($logs) : 0) }}
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse min-w-[880px]">
        <thead>
          <tr class="bg-slate-50/90 border-b border-slate-200/90 text-left font-head">
            <th class="py-4 px-5 sm:px-6 w-[32%] text-brand-deep uppercase tracking-wider font-extrabold text-[11px] sm:text-xs border-r border-slate-200/80">
              Event &amp; Activity
            </th>
            <th class="py-4 px-4 sm:px-5 w-[22%] text-brand-deep uppercase tracking-wider font-extrabold text-[11px] sm:text-xs border-r border-slate-200/80">
              User / Actor
            </th>
            <th class="py-4 px-4 sm:px-5 w-[14%] text-brand-deep uppercase tracking-wider font-extrabold text-[11px] sm:text-xs text-center border-r border-slate-200/80">
              IP Address
            </th>
            <th class="py-4 px-4 sm:px-5 w-[18%] text-brand-deep uppercase tracking-wider font-extrabold text-[11px] sm:text-xs border-r border-slate-200/80">
              Payload Data
            </th>
            <th class="py-4 px-4 sm:px-5 w-[14%] text-brand-deep uppercase tracking-wider font-extrabold text-[11px] sm:text-xs text-right">
              Timestamp
            </th>
          </tr>
        </thead>

        <tbody class="text-xs divide-y divide-slate-100">
          @if(isset($logs) && count($logs) > 0)
            @foreach($logs as $log)
              @php
                $eventTitle = 'Activity Logged';
                $eventDesc  = 'System action has been executed.';
                $badgeColor = 'text-slate-600 font-semibold';
                $iconBg     = 'bg-slate-100 text-slate-600';

                if ($log->event === 'login_success') {
                  $eventTitle = 'User Logged In';
                  $eventDesc  = 'Successful authentication session created.';
                  $badgeColor = 'text-emerald-600 font-semibold';
                  $iconBg     = 'bg-emerald-50 text-emerald-600';
                } elseif ($log->event === 'login_failed') {
                  $eventTitle = 'Failed Login Attempt';
                  $eventDesc  = 'Unauthorized access attempt blocked.';
                  $badgeColor = 'text-rose-600 font-semibold';
                  $iconBg     = 'bg-rose-50 text-rose-600';
                } elseif ($log->event === 'password_changed') {
                  $eventTitle = 'Password Updated';
                  $eventDesc  = 'User account security credentials changed.';
                  $badgeColor = 'text-amber-600 font-semibold';
                  $iconBg     = 'bg-amber-50 text-amber-600';
                } elseif ($log->event === 'logout') {
                  $eventTitle = 'Terminal Logout';
                  $eventDesc  = 'User session ended successfully.';
                  $badgeColor = 'text-slate-500 font-semibold';
                  $iconBg     = 'bg-slate-100 text-slate-500';
                } else {
                  $eventTitle = ucwords(str_replace('_', ' ', $log->event));
                }

                $payload = is_string($log->payload) ? json_decode($log->payload, true) : (array)$log->payload;
                $actor = $log->user_name ?? ($payload['attempted_email'] ?? $payload['email'] ?? 'System Administrator');
              @endphp

              <tr class="group hover:bg-[#EAF7FA]/30 transition-colors duration-150">
                <td class="py-3.5 px-5 sm:px-6 border-r border-slate-200/70 align-top">
                  <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $iconBg }} flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      </svg>
                    </div>
                    <div class="min-w-0">
                      <div class="flex flex-wrap items-center gap-2">
                        <span class="font-bold text-slate-800 group-hover:text-brand-blue transition-colors text-xs">
                          {{ $eventTitle }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 font-mono">
                          {{ $log->event }}
                        </span>
                      </div>
                      <p class="text-slate-500 mt-1 line-clamp-2 text-xs font-normal">
                        {{ $eventDesc }}
                      </p>
                    </div>
                  </div>
                </td>

                <td class="py-3.5 px-4 sm:px-5 border-r border-slate-200/70 align-top">
                  <div class="text-xs">
                    <span class="{{ $badgeColor }} block truncate">{{ $actor }}</span>
                    @if(!empty($log->user_email))
                      <span class="text-[11px] text-slate-400 block truncate mt-0.5 font-normal">{{ $log->user_email }}</span>
                    @endif
                  </div>
                </td>

                <td class="py-3.5 px-4 sm:px-5 text-center border-r border-slate-200/70 align-top">
                  <span class="font-mono bg-slate-100 px-2 py-1 rounded-md text-[11px] text-slate-600 font-medium inline-block">
                    {{ $log->ip_address ?? '127.0.0.1' }}
                  </span>
                </td>

                <td class="py-3.5 px-4 sm:px-5 border-r border-slate-200/70 align-top">
                  @if(!empty($payload) && count($payload) > 0)
                    <details class="group/details">
                      <summary class="cursor-pointer text-[11px] font-semibold text-brand-blue hover:underline select-none inline-flex items-center gap-1">
                        <span>View Raw Payload</span>
                        <svg class="w-3 h-3 group-open/details:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                      </summary>
                      <pre class="mt-1.5 p-2.5 rounded-lg bg-slate-900 text-slate-100 font-mono text-[10px] overflow-x-auto max-h-36 max-w-xs custom-scroll">{{ json_encode($payload, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                  @else
                    <span class="text-slate-300 font-normal text-xs select-none">—</span>
                  @endif
                </td>

                <td class="py-3.5 px-4 sm:px-5 text-right align-top">
                  <span class="font-medium text-slate-700 text-xs block whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
                  </span>
                  <span class="text-[11px] text-slate-400 block mt-0.5 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                  </span>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="py-12 text-center text-slate-400 text-xs font-medium">
                <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                No audit log activity records found in the database.
              </td>
            </tr>
          @endif

          @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator && $logs->hasPages())
            <tr class="bg-slate-50/90 border-t border-slate-200/90">
              <td colspan="5" class="py-4 px-5 sm:px-8">
                {{ $logs->links() }}
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>