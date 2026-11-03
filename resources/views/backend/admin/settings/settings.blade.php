@php
    $secretKey = $secret ?? config('admin.secret_key') ?? env('ADMIN_SECRET_KEY') ?? 'default_secret_key';
    $secretPrefix = 'admin/' . $secretKey;
    $currentAdminEmail = auth()->user()->email ?? \Illuminate\Support\Facades\DB::table('users')->orderBy('id', 'asc')->value('email') ?? 'naqibimannn@gmail.com';
    $activeTab = session('settings_tab', 'password');
@endphp

<div class="flex flex-col gap-8">
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Security &amp; Account Vault
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Security &middot; Real-time credential management, administrator email configuration, and two-step OTP protection.
      </p>
    </div>
  </div>

  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
      <label class="text-xs font-bold text-slate-500 uppercase tracking-wider shrink-0">Select Action:</label>
      <div class="inline-flex items-center bg-slate-200/60 p-1 rounded-full text-xs font-medium overflow-x-auto max-w-full">
        <button type="button" onclick="switchSettingsTab('password', this)" id="tabBtnPassword"
          class="settings-mode-tab px-5 py-1.5 rounded-full transition-all cursor-pointer {{ $activeTab === 'password' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
          Change Password
        </button>
        <button type="button" onclick="switchSettingsTab('email', this)" id="tabBtnEmail"
          class="settings-mode-tab px-5 py-1.5 rounded-full transition-all cursor-pointer {{ $activeTab === 'email' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
          Change Email Address
        </button>
      </div>
    </div>
  </div>

  <div id="panelChangePassword" class="{{ $activeTab === 'password' ? '' : 'hidden' }} relative z-20 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Update Administrator Password
      </span>
    </div>

    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="space-y-4">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Step 1 &middot; Fill Password Details</h3>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Password *</label>
            <div class="relative flex items-center">
              <input type="password" name="current_password" id="pwd_current_password" required placeholder="••••••••••••"
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-4 pr-11 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
              <button type="button" onclick="toggleFieldVis('pwd_current_password', 'eyePwdCurrentOpen', 'eyePwdCurrentClosed')" class="absolute right-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg id="eyePwdCurrentOpen" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg id="eyePwdCurrentClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
              </button>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">New Password *</label>
              <div class="relative flex items-center">
                <input type="password" name="password" id="pwd_new_password" required minlength="8" placeholder="••••••••••••"
                  class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-4 pr-11 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
                <button type="button" onclick="toggleFieldVis('pwd_new_password', 'eyePwdNewOpen', 'eyePwdNewClosed')" class="absolute right-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                  <svg id="eyePwdNewOpen" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <svg id="eyePwdNewClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                  </svg>
                </button>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm New Password *</label>
              <div class="relative flex items-center">
                <input type="password" name="password_confirmation" id="pwd_conf_password" required minlength="8" placeholder="••••••••••••"
                  class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-4 pr-11 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
                <button type="button" onclick="toggleFieldVis('pwd_conf_password', 'eyePwdConfOpen', 'eyePwdConfClosed')" class="absolute right-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                  <svg id="eyePwdConfOpen" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <svg id="eyePwdConfClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Step 2 &middot; Request &amp; Verify 6-Digit OTP</h3>

          <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
            <div class="sm:col-span-8">
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">6-Digit Passcode *</label>
              <input type="text" name="code" id="pwd_otp_code" maxlength="6" required placeholder="000000"
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-center font-mono text-base tracking-[6px] font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            </div>

            <div class="sm:col-span-4 sm:pt-6">
              <button type="button" id="btnOtpPassword" onclick="requestOtpCode('password')"
                class="w-full py-2.5 px-4 rounded-xl bg-white border border-slate-200/80 hover:border-brand/50 hover:text-brand text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2">
                <span id="textOtpPassword">Send OTP Code</span>
                <svg id="spinOtpPassword" class="animate-spin h-3.5 w-3.5 text-brand hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </button>
            </div>
          </div>

          <div id="noticeOtpPassword" class="hidden p-3 rounded-xl text-xs font-semibold"></div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Update Password
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="panelChangeEmail" class="{{ $activeTab === 'email' ? '' : 'hidden' }} relative z-20 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <div class="p-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
        Update Administrator Email Address
      </span>
    </div>

    <div class="p-5 sm:p-6 bg-white/50">
      <form action="{{ route('admin.settings.email.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="space-y-4">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Step 1 &middot; Fill Email &amp; Current Password</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">New Administrator Email (Gmail) *</label>
              <input type="email" name="email" id="email_new_address" value="{{ old('email', $currentAdminEmail) }}" required
                placeholder="example@gmail.com"
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Verify Current Password *</label>
              <div class="relative flex items-center">
                <input type="password" name="current_password" id="email_current_password" required placeholder="••••••••••••"
                  class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl pl-4 pr-11 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
                <button type="button" onclick="toggleFieldVis('email_current_password', 'eyeEmailPwdOpen', 'eyeEmailPwdClosed')" class="absolute right-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                  <svg id="eyeEmailPwdOpen" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <svg id="eyeEmailPwdClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
          <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Step 2 &middot; Request &amp; Verify 6-Digit OTP</h3>

          <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
            <div class="sm:col-span-8">
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">6-Digit Passcode *</label>
              <input type="text" name="code" id="email_otp_code" maxlength="6" required placeholder="000000"
                class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl px-4 py-2.5 text-center font-mono text-base tracking-[6px] font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
            </div>

            <div class="sm:col-span-4 sm:pt-6">
              <button type="button" id="btnOtpEmail" onclick="requestOtpCode('email')"
                class="w-full py-2.5 px-4 rounded-xl bg-white border border-slate-200/80 hover:border-brand/50 hover:text-brand text-slate-700 font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2">
                <span id="textOtpEmail">Send OTP Code</span>
                <svg id="spinOtpEmail" class="animate-spin h-3.5 w-3.5 text-brand hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </button>
            </div>
          </div>

          <div id="noticeOtpEmail" class="hidden p-3 rounded-xl text-xs font-semibold"></div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
            Update Email Address
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function switchSettingsTab(mode, btnEl) {
    document.querySelectorAll('.settings-mode-tab').forEach(b => {
      b.className = 'settings-mode-tab px-5 py-1.5 rounded-full transition-all text-slate-500 hover:text-slate-800 cursor-pointer';
    });
    btnEl.className = 'settings-mode-tab px-5 py-1.5 rounded-full transition-all bg-white text-slate-900 font-semibold shadow-xs cursor-pointer';

    const pwdPanel = document.getElementById('panelChangePassword');
    const emailPanel = document.getElementById('panelChangeEmail');

    if (mode === 'email') {
      pwdPanel.classList.add('hidden');
      emailPanel.classList.remove('hidden');
    } else {
      emailPanel.classList.add('hidden');
      pwdPanel.classList.remove('hidden');
    }
  }

  function toggleFieldVis(fieldId, openId, closedId) {
    const el = document.getElementById(fieldId);
    const openIcon = document.getElementById(openId);
    const closedIcon = document.getElementById(closedId);
    if (!el) return;

    if (el.type === 'password') {
      el.type = 'text';
      if (openIcon) openIcon.classList.add('hidden');
      if (closedIcon) closedIcon.classList.remove('hidden');
    } else {
      el.type = 'password';
      if (openIcon) openIcon.classList.remove('hidden');
      if (closedIcon) closedIcon.classList.add('hidden');
    }
  }

  function requestOtpCode(mode) {
    const isEmailMode = (mode === 'email');
    const btn = document.getElementById(isEmailMode ? 'btnOtpEmail' : 'btnOtpPassword');
    const text = document.getElementById(isEmailMode ? 'textOtpEmail' : 'textOtpPassword');
    const spinner = document.getElementById(isEmailMode ? 'spinOtpEmail' : 'spinOtpPassword');
    const notice = document.getElementById(isEmailMode ? 'noticeOtpEmail' : 'noticeOtpPassword');
    const otpInput = document.getElementById(isEmailMode ? 'email_otp_code' : 'pwd_otp_code');

    let targetEmail = '{{ $currentAdminEmail }}';
    if (isEmailMode) {
      const emailField = document.getElementById('email_new_address');
      if (emailField && emailField.value.trim()) {
        targetEmail = emailField.value.trim();
      }
    }

    btn.disabled = true;
    text.innerText = 'Dispatching...';
    spinner.classList.remove('hidden');

    notice.classList.add('hidden');
    notice.className = 'hidden p-3 rounded-xl text-xs font-semibold';

    fetch('{{ route("admin.settings.otp.send") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        email: targetEmail,
        mode: mode
      })
    })
    .then(res => res.json())
    .then(data => {
      btn.disabled = false;
      text.innerText = 'Resend OTP Code';
      spinner.classList.add('hidden');

      notice.classList.remove('hidden');
      if (data.status === 'success') {
        notice.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
        notice.innerText = data.message;
        if (otpInput) otpInput.focus();
      } else {
        notice.classList.add('bg-rose-50', 'text-rose-800', 'border', 'border-rose-200');
        notice.innerText = data.message || 'Failed to dispatch verification code.';
      }
    })
    .catch(() => {
      btn.disabled = false;
      text.innerText = 'Send OTP Code';
      spinner.classList.add('hidden');

      notice.classList.remove('hidden');
      notice.classList.add('bg-rose-50', 'text-rose-800', 'border', 'border-rose-200');
      notice.innerText = 'Server transmission error. Please try again.';
    });
  }
</script>