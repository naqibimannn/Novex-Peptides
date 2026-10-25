<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    /**
     * Paparkan konsol pengurusan utama atau seksyen modular.
     */
    public function index(Request $request, string $section = 'dashboard')
    {
        $secret = env('ADMIN_SECRET_KEY', 'khas-admin-novex-99');

        // Pengambilan kiraan statistik pangkalan data secara dinamik
        $articlesCount = Schema::hasTable('blog_posts') 
            ? DB::table('blog_posts')->count() 
            : 0;

        $pagesCount = 6;

        $audienceViewsCount = Schema::hasTable('page_views') 
            ? DB::table('page_views')->count() 
            : 0;

        $recentArticles = Schema::hasTable('blog_posts')
            ? DB::table('blog_posts')->latest('created_at')->take(2)->get()
            : collect();

        return view('backend.admin.dashboard.admin', compact(
            'section',
            'secret',
            'articlesCount',
            'pagesCount',
            'audienceViewsCount',
            'recentArticles'
        ));
    }

    /**
     * Endpoint API membekalkan data metrik untuk carta Chart.js.
     */
    public function getAudienceData(Request $request): JsonResponse
    {
        $period = $request->query('period', 'overview');

        // Data lalai berasaskan mod paparan kalendar
        if ($period === 'daily') {
            $labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'];
            $data = [15, 30, 85, 160, 120, 100];
            $todayViews = array_sum($data);
        } elseif ($period === 'monthly') {
            $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            $data = [420, 680, 510, 590];
            $todayViews = 590;
        } else {
            $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $data = [140, 210, 320, 510, 260, 340, 430];
            $todayViews = 510;
        }

        return response()->json([
            'labels'     => $labels,
            'data'       => $data,
            'total'      => array_sum($data),
            'todayViews' => $todayViews,
        ]);
    }
}