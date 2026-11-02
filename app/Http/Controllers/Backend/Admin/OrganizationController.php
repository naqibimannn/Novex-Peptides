<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

class OrganizationController extends Controller
{
    public function index(Request $request, $secret = null)
    {
        $secret = $secret ?? (config('admin.secret_key') ?: env('ADMIN_SECRET_KEY'));

        $org = Cache::remember('site_organization_info', 86400, function () {
            if (Schema::hasTable('organization_info')) {
                $data = DB::table('organization_info')->first();
                if (!$data) {
                    DB::table('organization_info')->insert([
                        'id'            => 1,
                        'company_name'  => 'Novex Peptides',
                        'phone_number'  => '+60 11-2549 0484',
                        'email'         => 'support@novexsupps.com',
                        'instagram_url' => 'https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==',
                        'tiktok_url'    => 'https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                    $data = DB::table('organization_info')->first();
                }
                return $data;
            }

            return (object)[
                'company_name'  => 'Novex Peptides',
                'phone_number'  => '+60 11-2549 0484',
                'email'         => 'support@novexsupps.com',
                'instagram_url' => 'https://www.instagram.com/novexperfomancedivision?rpxt=MWhrc2tlYjFkdXNjaA==',
                'tiktok_url'    => 'https://www.tiktok.com/@fthulaimn?_r=1&_t=ZS-9AigtDpLBg1',
            ];
        });

        $section = 'info';

        return view('backend.admin.dashboard.admin', compact('section', 'secret', 'org'));
    }

    public function update(Request $request, $secret = null)
    {
        $request->validate([
            'phone_number'  => 'required|string|max:50',
            'email'         => 'required|email|max:150',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url'    => 'nullable|url|max:255',
        ]);

        if (Schema::hasTable('organization_info')) {
            DB::table('organization_info')->updateOrInsert(
                ['id' => 1],
                [
                    'company_name'  => $request->input('company_name', 'Novex Peptides'),
                    'phone_number'  => $request->input('phone_number'),
                    'email'         => $request->input('email'),
                    'instagram_url' => $request->input('instagram_url'),
                    'tiktok_url'    => $request->input('tiktok_url'),
                    'updated_at'    => now(),
                ]
            );

            Cache::forget('site_organization_info');
        }

        return redirect()->back()->with('success', 'Organization profile & social links updated successfully!');
    }
}