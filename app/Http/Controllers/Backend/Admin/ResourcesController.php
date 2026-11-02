<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ResourcesController extends Controller
{
    public function index()
    {
        $resources = DB::select("SELECT * FROM resources ORDER BY id DESC");
        $adminSecret = config('admin.secret_key') ?: env('ADMIN_SECRET_KEY') ?: 'default_secret_key';

        return view('backend.admin.dashboard.admin', [
            'section'   => 'blogs',
            'secret'    => $adminSecret,
            'resources' => $resources,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'author'    => 'nullable|string|max:255',
            'read_time' => 'nullable|string|max:150',
            'content'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $slug = Str::slug($request->input('title'));
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('resources')->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/resources'), $filename);
            $imagePath = 'uploads/resources/' . $filename;
        }

        DB::table('resources')->insert([
            'title'      => $request->input('title'),
            'slug'       => $slug,
            'subtitle'   => $request->input('subtitle'),
            'author'     => $request->input('author') ?? 'Dr. Aris Thorne, Ph.D.',
            'read_time'  => $request->input('read_time') ?? '4 min read • Monograph Review',
            'image'      => $imagePath,
            'content'    => $request->input('content'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget('frontend_resources_list');

        return back()->with('success', 'Article published successfully to Educational Resources.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'author'    => 'nullable|string|max:255',
            'read_time' => 'nullable|string|max:150',
            'content'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $existing = DB::table('resources')->where('id', $id)->first();
        if (!$existing) {
            return back()->withErrors(['Article not found.']);
        }

        $imagePath = $existing->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/resources'), $filename);
            $imagePath = 'uploads/resources/' . $filename;
        }

        DB::table('resources')->where('id', $id)->update([
            'title'      => $request->input('title'),
            'subtitle'   => $request->input('subtitle'),
            'author'     => $request->input('author'),
            'read_time'  => $request->input('read_time'),
            'image'      => $imagePath,
            'content'    => $request->input('content'),
            'updated_at' => now(),
        ]);

        Cache::forget('frontend_resources_list');

        return back()->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $existing = DB::table('resources')->where('id', $id)->first();
        if ($existing) {
            if (!empty($existing->image) && file_exists(public_path($existing->image))) {
                @unlink(public_path($existing->image));
            }
            DB::table('resources')->where('id', $id)->delete();
        }

        Cache::forget('frontend_resources_list');

        return back()->with('success', 'Article removed permanently.');
    }
}