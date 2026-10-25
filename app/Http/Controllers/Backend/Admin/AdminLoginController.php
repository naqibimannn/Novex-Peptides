<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
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
        $clientIp = $request->header('CF-Connecting-IP') ?? $request->ip();

        $user = collect(DB::select(
            "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1",
            [$email]
        ))->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            $this->audit('login_failed', ['email' => $email], $clientIp, null);

            throw ValidationException::withMessages([
                'email' => ['Akses ditolak: Kredensial tidak sah untuk terminal ini.'],
            ]);
        }

        Auth::loginUsingId($user->id, $request->boolean('remember'));
        $request->session()->regenerate();

        $this->audit('login_success', ['email' => $user->email], $clientIp, $user->id);

        $secret = env('ADMIN_SECRET_KEY');
        return redirect()->intended(url("admin/{$secret}"))
            ->with('success', 'Terminal security session initialized successfully.');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        $clientIp = $request->header('CF-Connecting-IP') ?? $request->ip();

        $this->audit('logout', ['status' => 'session_terminated'], $clientIp, $userId);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $secret = env('ADMIN_SECRET_KEY');
        return redirect("admin/{$secret}/login");
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