<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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

    private function recordAuditLog(Request $request, string $event, array $payload = []): void
    {
        if (!Schema::hasTable('audit_logs')) {
            return;
        }

        try {
            DB::statement("ALTER TABLE `audit_logs` MODIFY COLUMN `event` VARCHAR(100) NOT NULL");
        } catch (\Throwable $e) {
        }

        $columns = Schema::getColumnListing('audit_logs');
        $userId = auth()->id() ?? DB::table('users')->orderBy('id', 'asc')->value('id') ?? 1;
        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        $logData = [];

        if (in_array('user_id', $columns, true)) {
            $logData['user_id'] = $userId;
        }
        if (in_array('event', $columns, true)) {
            $logData['event'] = $event;
        }
        if (in_array('ip_address', $columns, true)) {
            $logData['ip_address'] = $request->ip() ?? '127.0.0.1';
        }
        if (in_array('user_agent', $columns, true)) {
            $logData['user_agent'] = substr((string) $request->userAgent(), 0, 255);
        }
        if (in_array('payload', $columns, true)) {
            $logData['payload'] = json_encode($payload);
        }
        if (in_array('created_at', $columns, true)) {
            $logData['created_at'] = $nowKl;
        }
        if (in_array('updated_at', $columns, true)) {
            $logData['updated_at'] = $nowKl;
        }

        DB::table('audit_logs')->insert($logData);
    }

    private function handleUpload(Request $request, ?string $currentPath = null): ?string
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return $currentPath;
        }

        $file = $request->file('image');

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExts  = ['jpg', 'jpeg', 'png', 'webp'];

        $realMime   = $file->getMimeType();
        $clientExt  = strtolower($file->getClientOriginalExtension());
        $guessedExt = strtolower($file->guessExtension() ?? '');

        if (
            $clientExt === 'svg' ||
            str_contains(strtolower($realMime), 'svg') ||
            str_contains(strtolower($realMime), 'xml') ||
            !in_array($realMime, $allowedMimes, true) ||
            !in_array($clientExt, $allowedExts, true) ||
            !in_array($guessedExt, $allowedExts, true)
        ) {
            throw ValidationException::withMessages([
                'image' => 'Format imej tidak sah. Hanya JPG, JPEG, PNG, dan WEBP dibenarkan (SVG disekat).',
            ]);
        }

        $targetDir = public_path('uploads/resources');
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true, true);
        }

        $ext = ($guessedExt === 'jpeg') ? 'jpg' : $guessedExt;
        $filename = 'art_' . time() . '_' . Str::random(24) . '.' . $ext;

        $file->move($targetDir, $filename);

        if ($currentPath && File::exists(public_path($currentPath)) && !str_contains($currentPath, 'assets/website/')) {
            File::delete(public_path($currentPath));
        }

        return 'uploads/resources/' . $filename;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'author'         => 'nullable|string|max:255',
            'read_time'      => 'nullable|string|max:150',
            'classification' => 'nullable|string|max:150',
            'content'        => 'required|string',
            'image'          => 'nullable|file|max:5120|mimes:jpeg,png,jpg,webp|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $imagePath = $this->handleUpload($request);

        $slug = Str::slug($request->input('title'));
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('resources')->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        $insertData = [
            'title'      => $request->input('title'),
            'slug'       => $slug,
            'subtitle'   => $request->input('subtitle'),
            'author'     => $request->input('author'),
            'read_time'  => $request->input('read_time'),
            'image'      => $imagePath,
            'content'    => $request->input('content'),
            'created_at' => $nowKl,
            'updated_at' => $nowKl,
        ];

        if (Schema::hasColumn('resources', 'classification')) {
            $insertData['classification'] = $request->input('classification');
        }

        $resourceId = DB::table('resources')->insertGetId($insertData);

        Cache::forget('frontend_resources_list');

        $this->recordAuditLog($request, 'resource_created', [
            'resource_id'    => $resourceId,
            'title'          => $request->input('title'),
            'author'         => $request->input('author'),
            'classification' => $request->input('classification'),
        ]);

        return back()->with('success', 'Article published successfully to Educational Resources.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'author'         => 'nullable|string|max:255',
            'read_time'      => 'nullable|string|max:150',
            'classification' => 'nullable|string|max:150',
            'content'        => 'required|string',
            'image'          => 'nullable|file|max:5120|mimes:jpeg,png,jpg,webp|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $existing = DB::table('resources')->where('id', $id)->first();
        if (!$existing) {
            return back()->withErrors(['Article not found.']);
        }

        $imagePath = $this->handleUpload($request, $existing->image);
        $nowKl = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');

        $updateData = [
            'title'      => $request->input('title'),
            'subtitle'   => $request->input('subtitle'),
            'author'     => $request->input('author'),
            'read_time'  => $request->input('read_time'),
            'image'      => $imagePath,
            'content'    => $request->input('content'),
            'updated_at' => $nowKl,
        ];

        if (Schema::hasColumn('resources', 'classification')) {
            $updateData['classification'] = $request->input('classification');
        }

        DB::table('resources')->where('id', $id)->update($updateData);

        Cache::forget('frontend_resources_list');

        $this->recordAuditLog($request, 'resource_updated', [
            'resource_id'   => $id,
            'title'         => $request->input('title'),
            'author'        => $request->input('author'),
            'has_new_image' => $request->hasFile('image'),
        ]);

        return back()->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $existing = DB::table('resources')->where('id', $id)->first();
        if ($existing) {
            if (!empty($existing->image) && File::exists(public_path($existing->image))) {
                File::delete(public_path($existing->image));
            }
            DB::table('resources')->where('id', $id)->delete();

            $this->recordAuditLog(request(), 'resource_deleted', [
                'resource_id' => $id,
                'title'       => $existing->title ?? 'Educational Article',
            ]);
        }

        Cache::forget('frontend_resources_list');

        return back()->with('success', 'Article removed permanently.');
    }
}