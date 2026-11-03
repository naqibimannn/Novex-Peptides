<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function index(Request $request, $secret = null)
    {
        $hasAuditTable = Schema::hasTable('audit_logs');
        $nowKl = Carbon::now('Asia/Kuala_Lumpur');

        if (!$hasAuditTable) {
            return view('backend.admin.dashboard.admin', [
                'section'             => 'audit-logs',
                'secret'              => $secret,
                'logs'                => collect(),
                'totalLogs'           => 0,
                'loginSuccessCount'   => 0,
                'loginFailedCount'    => 0,
                'securityAlertsCount' => 0,
                'startDate'           => $nowKl,
                'endDate'             => $nowKl,
            ]);
        }

        $period = $request->input('period', 'overview');
        $rawDate = $request->input('date', $nowKl->format('Y-m-d'));

        try {
            $selectedDate = Carbon::parse($rawDate, 'Asia/Kuala_Lumpur');
        } catch (\Throwable $e) {
            $selectedDate = $nowKl->copy();
        }

        $year  = (int) $request->input('year', $selectedDate->year);
        $month = (int) $request->input('month', $selectedDate->month);

        if ($period === 'daily') {
            $startDate = $selectedDate->copy()->startOfDay();
            $endDate   = $selectedDate->copy()->endOfDay();
        } elseif ($period === 'monthly') {
            $startDate = Carbon::createFromDate($year, $month, 1, 'Asia/Kuala_Lumpur')->startOfMonth();
            $endDate   = $startDate->copy()->endOfMonth();
        } else {
            $endDate   = $selectedDate->copy()->endOfDay();
            $startDate = $selectedDate->copy()->subDays(6)->startOfDay();
        }

        $baseDateQuery = DB::table('audit_logs')
            ->whereBetween('audit_logs.created_at', [
                $startDate->format('Y-m-d H:i:s'),
                $endDate->format('Y-m-d H:i:s'),
            ]);

        $totalLogs           = (clone $baseDateQuery)->count();
        $loginSuccessCount   = (clone $baseDateQuery)->where('event', 'login_success')->count();
        $loginFailedCount    = (clone $baseDateQuery)->where('event', 'login_failed')->count();
        $securityAlertsCount = (clone $baseDateQuery)->whereIn('event', ['login_failed', 'password_changed'])->count();

        $listQuery = (clone $baseDateQuery)
            ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
            ->select(
                'audit_logs.*',
                'users.name as user_name',
                'users.email as user_email'
            );

        if ($request->filled('search')) {
            $search = trim($request->get('search'));
            $listQuery->where(function ($q) use ($search) {
                $q->where('audit_logs.event', 'like', "%{$search}%")
                  ->orWhere('audit_logs.ip_address', 'like', "%{$search}%")
                  ->orWhere('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('audit_logs.payload', 'like', "%{$search}%");
            });
        }

        if ($request->filled('event') && $request->get('event') !== 'all') {
            $listQuery->where('audit_logs.event', $request->get('event'));
        }

        $logs = $listQuery->orderBy('audit_logs.id', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('backend.admin.dashboard.admin', [
            'section'             => 'audit-logs',
            'secret'              => $secret,
            'logs'                => $logs,
            'totalLogs'           => $totalLogs,
            'loginSuccessCount'   => $loginSuccessCount,
            'loginFailedCount'    => $loginFailedCount,
            'securityAlertsCount' => $securityAlertsCount,
            'startDate'           => $startDate,
            'endDate'             => $endDate,
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