<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Mail\AdminResetPasswordMail;
use Carbon\Carbon;

class AdminPasswordController extends Controller
{
    private string $targetEmail = 'naqibimannn@gmail.com';

    public function sendResetEmail(Request $request)
    {
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->targetEmail],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/admin/password/reset/' . $token . '?email=' . urlencode($this->targetEmail));

        Mail::to($this->targetEmail)->send(
            new AdminResetPasswordMail($resetLink, 'Permintaan Reset Kata Laluan CentraDesk')
        );

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->insert([
                'user_id' => auth()->id() ?? 1,
                'event' => 'password_reset_requested',
                'payload' => json_encode(['email' => $this->targetEmail, 'ip' => $request->ip()]),
                'ip_address' => $request->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return back()->with('success', 'Pautan reset kata laluan keselamatan telah dihantar ke naqibimannn@gmail.com');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $adminUser = auth()->user() ?? DB::table('users')->where('email', $this->targetEmail)->first();

        if (!$adminUser || !Hash::check($request->current_password, $adminUser->password)) {
            return back()->withErrors(['current_password' => 'Kata laluan semasa tidak sah.']);
        }

        DB::table('users')
            ->where('id', $adminUser->id)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now()
            ]);

        Mail::to($this->targetEmail)->send(
            new AdminResetPasswordMail(null, 'Pemberitahuan: Kata Laluan Akaun Pentadbir Dikemaskini')
        );

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->insert([
                'user_id' => $adminUser->id,
                'event' => 'password_changed',
                'payload' => json_encode(['email' => $this->targetEmail, 'status' => 'success']),
                'ip_address' => $request->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return back()->with('success', 'Kata laluan berjaya dikemaskini dan emel pengesahan dihantar ke naqibimannn@gmail.com');
    }
}