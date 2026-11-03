<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\AdminResetPasswordMail;
use Carbon\Carbon;

class SettingsController extends Controller
{
    private function getActiveAdminEmail(): string
    {
        if (Auth::check() && !empty(Auth::user()->email)) {
            return Auth::user()->email;
        }

        $email = DB::table('users')->orderBy('id', 'asc')->value('email');
        return !empty($email) ? $email : 'naqibimannn@gmail.com';
    }

    public function index()
    {
        $adminSecret = config('admin.secret_key') ?: env('ADMIN_SECRET_KEY') ?: 'default_secret_key';

        return view('backend.admin.dashboard.admin', [
            'section' => 'settings',
            'secret'  => $adminSecret,
        ]);
    }

    public function sendOtp(Request $request)
    {
        $requestedEmail = trim((string) $request->input('email'));
        $activeEmail = $this->getActiveAdminEmail();
        $targetEmail = filter_var($requestedEmail, FILTER_VALIDATE_EMAIL) ? $requestedEmail : $activeEmail;

        $code = (string) random_int(100000, 999999);
        $hashedCode = Hash::make($code);

        DB::table('password_reset_tokens')->whereIn('email', [$targetEmail, $activeEmail])->delete();
        DB::table('password_reset_tokens')->insert([
            'email'      => $targetEmail,
            'token'      => $hashedCode,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($targetEmail)->send(
            new AdminResetPasswordMail($code, 'CentraDesk Security Verification Passcode')
        );

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->insert([
                'user_id'    => Auth::id() ?? 1,
                'event'      => 'security_otp_requested',
                'payload'    => json_encode(['email' => $targetEmail, 'mode' => $request->input('mode', 'password'), 'ip' => $request->ip()]),
                'ip_address' => $request->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => '6-digit verification code sent to ' . $targetEmail,
            ]);
        }

        return back()->with('success', '6-digit verification code sent to ' . $targetEmail);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'code'             => ['required', 'string', 'size:6'],
        ]);

        $currentEmail = $this->getActiveAdminEmail();

        $resetEntry = DB::table('password_reset_tokens')
            ->where('email', $currentEmail)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$resetEntry) {
            return back()->with('settings_tab', 'password')->withErrors(['code' => 'No active verification code found. Please click Send OTP Code first.']);
        }

        if (Carbon::parse($resetEntry->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $currentEmail)->delete();
            return back()->with('settings_tab', 'password')->withErrors(['code' => 'Verification code has expired. Please request a new one.']);
        }

        if (!Hash::check(trim($request->code), $resetEntry->token)) {
            return back()->with('settings_tab', 'password')->withErrors(['code' => 'Invalid 6-digit verification code.']);
        }

        $adminUser = Auth::user() ?? DB::table('users')->orderBy('id', 'asc')->first();

        if (!$adminUser || !Hash::check($request->current_password, $adminUser->password)) {
            return back()->with('settings_tab', 'password')->withErrors(['current_password' => 'Current password does not match our records.']);
        }

        DB::table('users')->where('id', $adminUser->id)->update([
            'password'   => Hash::make($request->password),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('password_reset_tokens')->where('email', $currentEmail)->delete();

        try {
            Mail::to($currentEmail)->send(
                new AdminResetPasswordMail(null, 'CentraDesk Password Updated Confirmation')
            );
        } catch (\Throwable $e) {
        }

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->insert([
                'user_id'    => $adminUser->id,
                'event'      => 'password_changed',
                'payload'    => json_encode(['email' => $currentEmail, 'status' => 'success']),
                'ip_address' => $request->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return back()->with('settings_tab', 'password')->with('success', 'Administrator password updated successfully.');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email'            => ['required', 'email', 'max:255'],
            'current_password' => ['required', 'string'],
            'code'             => ['required', 'string', 'size:6'],
        ]);

        $newEmail = trim($request->email);
        $currentEmail = $this->getActiveAdminEmail();

        $resetEntry = DB::table('password_reset_tokens')
            ->whereIn('email', [$newEmail, $currentEmail])
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$resetEntry) {
            return back()->with('settings_tab', 'email')->withErrors(['code' => 'No active verification code found. Please click Send OTP Code first.'])->withInput();
        }

        if (Carbon::parse($resetEntry->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->whereIn('email', [$newEmail, $currentEmail])->delete();
            return back()->with('settings_tab', 'email')->withErrors(['code' => 'Verification code has expired. Please request a new one.'])->withInput();
        }

        if (!Hash::check(trim($request->code), $resetEntry->token)) {
            return back()->with('settings_tab', 'email')->withErrors(['code' => 'Invalid 6-digit verification code.'])->withInput();
        }

        $adminUser = Auth::user() ?? DB::table('users')->orderBy('id', 'asc')->first();

        if (!$adminUser || !Hash::check($request->current_password, $adminUser->password)) {
            return back()->with('settings_tab', 'email')->withErrors(['current_password' => 'Current password does not match our records.'])->withInput();
        }

        DB::table('users')->where('id', '!=', $adminUser->id)->where('email', $newEmail)->delete();
        DB::table('users')->where('id', $adminUser->id)->update([
            'email'      => $newEmail,
            'role'       => 'admin',
            'updated_at' => Carbon::now(),
        ]);

        DB::table('password_reset_tokens')->whereIn('email', [$newEmail, $currentEmail])->delete();

        try {
            Mail::to($newEmail)->send(
                new AdminResetPasswordMail(null, 'CentraDesk Administrator Email Updated')
            );
        } catch (\Throwable $e) {
        }

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->insert([
                'user_id'    => $adminUser->id,
                'event'      => 'email_changed',
                'payload'    => json_encode(['old_email' => $currentEmail, 'new_email' => $newEmail, 'status' => 'success']),
                'ip_address' => $request->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return back()->with('settings_tab', 'email')->with('success', 'Administrator email successfully updated to ' . $newEmail);
    }
}