<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\AdminResetPasswordMail;
use Carbon\Carbon;

class AdminLoginController extends Controller
{
    private function getActiveAdminEmail(): string
    {
        $email = DB::table('users')->orderBy('id', 'asc')->value('email');
        return !empty($email) ? $email : 'naqibimannn@gmail.com';
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('backend.admin.login.login');
    }

    public function login(Request $request)
    {
        if (!empty($request->input('website_verify'))) {
            abort(Response::HTTP_FORBIDDEN, 'Spam signature identified.');
        }

        $credentials = $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $email = trim($credentials['email']);
        $clientIp = $this->getClientIp($request);

        $users = DB::select(
            "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1",
            [$email]
        );

        $user = !empty($users) ? $users[0] : null;

        $isPasswordValid = false;
        try {
            $isPasswordValid = $user && Hash::check($credentials['password'], $user->password);
        } catch (\RuntimeException $e) {
            $isPasswordValid = false;
        }

        if (!$isPasswordValid) {
            $this->audit('login_failed', [
                'attempted_email' => $email,
                'status'          => 'rejected',
            ], $clientIp, null);

            throw ValidationException::withMessages([
                'email' => ['Access denied: Invalid credentials for this terminal.'],
            ]);
        }

        Auth::loginUsingId($user->id, $request->boolean('remember'));
        $request->session()->regenerate();

        $this->audit('login_success', [
            'email'  => $user->email,
            'status' => 'authorized',
        ], $clientIp, $user->id);

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Terminal security session initialized successfully.');
    }

    public function sendResetCode(Request $request)
    {
        $clientIp = $this->getClientIp($request);
        $targetEmail = $this->getActiveAdminEmail();
        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->where('email', $targetEmail)->delete();
        DB::table('password_reset_tokens')->insert([
            'email'      => $targetEmail,
            'token'      => Hash::make($code),
            'created_at' => Carbon::now(),
        ]);

        Mail::to($targetEmail)->send(
            new AdminResetPasswordMail($code, 'CentraDesk Password Reset Passcode')
        );

        $this->audit('password_reset_code_requested', [
            'email' => $targetEmail,
            'ip'    => $clientIp,
        ], $clientIp, Auth::id() ?? 1);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Verification code sent to ' . $targetEmail,
            ]);
        }

        return back()->with('success', 'Verification code sent to ' . $targetEmail);
    }

    public function verifyCodeAndReset(Request $request)
    {
        $request->validate([
            'code'     => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $clientIp = $this->getClientIp($request);
        $targetEmail = $this->getActiveAdminEmail();

        $resetEntry = DB::table('password_reset_tokens')
            ->where('email', $targetEmail)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$resetEntry) {
            return $this->handleResetFailure($request, 'No active verification code found. Please request a new one.');
        }

        if (Carbon::parse($resetEntry->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $targetEmail)->delete();
            return $this->handleResetFailure($request, 'Verification code has expired. Please request a new one.');
        }

        if (!Hash::check(trim($request->code), $resetEntry->token)) {
            return $this->handleResetFailure($request, 'Invalid 6-digit verification code.');
        }

        $hashedPassword = Hash::make($request->password);
        $primaryUser = DB::table('users')->orderBy('id', 'asc')->first();

        if ($primaryUser) {
            DB::table('users')->where('id', $primaryUser->id)->update([
                'email'      => $targetEmail,
                'password'   => $hashedPassword,
                'role'       => 'admin',
                'updated_at' => Carbon::now(),
            ]);
        } else {
            DB::table('users')->insert([
                'id'         => 1,
                'name'       => 'Admin Novex',
                'email'      => $targetEmail,
                'password'   => $hashedPassword,
                'role'       => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        DB::table('password_reset_tokens')->where('email', $targetEmail)->delete();

        try {
            Mail::to($targetEmail)->send(
                new AdminResetPasswordMail(null, 'CentraDesk Password Reset Confirmation')
            );
        } catch (\Throwable $e) {
        }

        $this->audit('password_changed', [
            'email'  => $targetEmail,
            'method' => 'otp_code_direct',
        ], $clientIp, $primaryUser->id ?? 1);

        $request->session()->flash('success', 'Password updated successfully. You can now sign in with ' . $targetEmail);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'   => 'success',
                'message'  => 'Password updated successfully. Please sign in.',
                'redirect' => route('admin.login'),
            ]);
        }

        return redirect()->route('admin.login');
    }

    private function handleResetFailure(Request $request, string $message)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => $message,
            ], 422);
        }

        return back()->withErrors(['code' => $message]);
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        $clientIp = $this->getClientIp($request);

        if ($userId) {
            $this->audit('logout', [
                'status' => 'session_terminated',
            ], $clientIp, $userId);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function getClientIp(Request $request): string
    {
        return $request->header('CF-Connecting-IP') 
            ?? $request->header('X-Forwarded-For') 
            ?? $request->ip() 
            ?? '127.0.0.1';
    }

    private function audit(string $event, array $payload, string $ip, ?int $userId): void
    {
        try {
            DB::insert(
                "INSERT INTO audit_logs (user_id, event, payload, ip_address, created_at, updated_at) 
                 VALUES (?, ?, ?, ?, NOW(), NOW())",
                [$userId, $event, json_encode($payload), $ip]
            );
        } catch (\Throwable) {
        }
    }
}