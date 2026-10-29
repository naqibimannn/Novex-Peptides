<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AudienceController extends Controller
{
    public function index(Request $request, $secret = null)
    {
        $today = Carbon::today()->toDateString();

        $totalViews = DB::table('page_views')->count();
        $todayViews = DB::table('page_views')
            ->whereDate('created_at', $today)
            ->count();
        $uniqueVisitors = DB::table('page_views')
            ->distinct('ip_address')
            ->count('ip_address');

        $section = 'audience';

        if (view()->exists('backend.admin.admin')) {
            return view('backend.admin.admin', compact(
                'section',
                'secret',
                'totalViews',
                'todayViews',
                'uniqueVisitors'
            ));
        }

        return view('backend.admin.audience.audience', compact(
            'section',
            'secret',
            'totalViews',
            'todayViews',
            'uniqueVisitors'
        ));
    }

    public function data(Request $request)
    {
        $period = $request->query('period', 'overview');
        $page = $request->query('page', 'all');
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        $month = (int) $request->query('month', Carbon::parse($selectedDate)->month);
        $year = (int) $request->query('year', Carbon::parse($selectedDate)->year);

        $dateCarbon = Carbon::parse($selectedDate);

        $filterPage = function ($query) use ($page) {
            if (!$page || $page === 'all') {
                return;
            }
            if ($page === 'blog-all') {
                $query->where(function ($q) {
                    $q->where('page_url', 'LIKE', '%blog%')
                      ->orWhere('page_url', 'LIKE', '%insight%');
                });
            } else {
                $query->where('page_url', 'LIKE', '%' . trim($page, '/') . '%');
            }
        };

        $labels = [];
        $data = [];

        if ($period === 'daily') {
            $startDate = $dateCarbon->copy()->startOfDay();
            $endDate = $dateCarbon->copy()->endOfDay();

            for ($h = 0; $h < 24; $h++) {
                $labels[] = sprintf('%02d:00', $h);
                $data[] = 0;
            }

            $results = DB::table('page_views')
                ->select(DB::raw('HOUR(created_at) as hour_idx, COUNT(*) as aggregate'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where($filterPage)
                ->groupBy('hour_idx')
                ->pluck('aggregate', 'hour_idx');

            foreach ($results as $hourIdx => $count) {
                if (isset($data[$hourIdx])) {
                    $data[$hourIdx] = (int) $count;
                }
            }
        } elseif ($period === 'monthly') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = $startDate->copy()->endOfMonth()->endOfDay();
            $daysInMonth = $startDate->daysInMonth;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = (string) $d;
                $data[] = 0;
            }

            $results = DB::table('page_views')
                ->select(DB::raw('DAY(created_at) as day_idx, COUNT(*) as aggregate'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where($filterPage)
                ->groupBy('day_idx')
                ->pluck('aggregate', 'day_idx');

            foreach ($results as $dayIdx => $count) {
                $idx = $dayIdx - 1;
                if (isset($data[$idx])) {
                    $data[$idx] = (int) $count;
                }
            }
        } else {
            $endDate = $dateCarbon->copy()->endOfDay();
            $startDate = $dateCarbon->copy()->subDays(6)->startOfDay();

            $dateCursor = $startDate->copy();
            $dateMap = [];
            $i = 0;

            while ($dateCursor <= $endDate) {
                $dStr = $dateCursor->format('Y-m-d');
                $labels[] = $dateCursor->format('d M');
                $data[] = 0;
                $dateMap[$dStr] = $i++;
                $dateCursor->addDay();
            }

            $results = DB::table('page_views')
                ->select(DB::raw('DATE(created_at) as date_val, COUNT(*) as aggregate'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where($filterPage)
                ->groupBy('date_val')
                ->pluck('aggregate', 'date_val');

            foreach ($results as $dateVal => $count) {
                if (isset($dateMap[$dateVal])) {
                    $data[$dateMap[$dateVal]] = (int) $count;
                }
            }
        }

        $totalViews = DB::table('page_views')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where($filterPage)
            ->count();

        $todayViews = DB::table('page_views')
            ->whereDate('created_at', $selectedDate)
            ->where($filterPage)
            ->count();

        $uniqueVisitors = DB::table('page_views')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where($filterPage)
            ->distinct('ip_address')
            ->count('ip_address');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => $totalViews,
            'todayViews' => $todayViews,
            'uniqueVisitors' => $uniqueVisitors,
        ]);
    }
}