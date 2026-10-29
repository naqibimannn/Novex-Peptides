<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AuditController extends Controller
{
    public function index(Request $request, $secret = null)
    {
        $hasAuditTable = Schema::hasTable('audit_logs');

        // Statistik kad ringkas
        $totalLogs = $hasAuditTable ? DB::table('audit_logs')->count() : 0;
        $loginSuccessCount = $hasAuditTable ? DB::table('audit_logs')->where('event', 'login_success')->count() : 0;
        $loginFailedCount = $hasAuditTable ? DB::table('audit_logs')->where('event', 'login_failed')->count() : 0;
        $securityAlertsCount = $hasAuditTable ? DB::table('audit_logs')->whereIn('event', ['login_failed', 'password_changed'])->count() : 0;

        if (!$hasAuditTable) {
            $logs = collect();
        } else {
            $query = DB::table('audit_logs')
                ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
                ->select(
                    'audit_logs.*',
                    'users.name as user_name',
                    'users.email as user_email'
                );

            if ($request->filled('search')) {
                $search = trim($request->get('search'));
                $query->where(function ($q) use ($search) {
                    $q->where('audit_logs.event', 'like', "%{$search}%")
                      ->orWhere('audit_logs.ip_address', 'like', "%{$search}%")
                      ->orWhere('users.name', 'like', "%{$search}%")
                      ->orWhere('users.email', 'like', "%{$search}%")
                      ->orWhere('audit_logs.payload', 'like', "%{$search}%");
                });
            }

            if ($request->filled('event') && $request->get('event') !== 'all') {
                $query->where('audit_logs.event', $request->get('event'));
            }

            $logs = $query->orderBy('audit_logs.created_at', 'desc')
                          ->paginate(15)
                          ->withQueryString();
        }

        return view('backend.admin.dashboard.admin', [
        'section'             => 'audit-logs',
        'secret'              => $secret,
        'logs'                => $logs,
        'totalLogs'           => $totalLogs,
        'loginSuccessCount'   => $loginSuccessCount,
        'loginFailedCount'    => $loginFailedCount,
        'securityAlertsCount' => $securityAlertsCount,
    ]);
}

    public function destroy($secret, $id)
    {
        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->where('id', $id)->delete();
            return back()->with('success', 'Rekod log audit berjaya dipadam.');
        }

        return back()->withErrors(['Ralat: Jadual audit_logs tidak wujud.']);
    }
}