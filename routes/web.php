<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Admin\AdminLoginController;
use App\Http\Controllers\Backend\Admin\ProductsController;
use App\Http\Controllers\Backend\Admin\AuditController;
use App\Http\Controllers\Backend\Admin\AudienceController;

Route::any('/login', fn() => abort(404));
Route::any('/admin', fn() => abort(404));

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/')->group(function () {

    // Homepage
    Route::get('/', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'home',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $featuredProducts = DB::select("SELECT * FROM products ORDER BY id DESC LIMIT 4");
        return view('frontend.home.index', compact('featuredProducts'));
    })->name('home');

    // About Page
    Route::get('/about', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'about',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.about.index');
    })->name('about');

    // Products Catalog
    Route::get('/products', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'products',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $catalogProducts = DB::select("SELECT * FROM products ORDER BY id DESC");
        return view('frontend.products.index', compact('catalogProducts'));
    })->name('products.index');

    // Products Detail
    Route::get('/products/{id}', function (Request $request, $id) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'products/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('products.show');

    // Accessory Catalog
    Route::get('/accessory', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'accessory',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.accessory.index');
    })->name('accessory');

    // Accessory Detail
    Route::get('/accessory/{id}', function (Request $request, $id) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'accessory/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('accessory.show');

    // Performance Page
    Route::get('/performance', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'performance',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.performance.index');
    })->name('performance');

    // Premium Supplements Page
    Route::get('/premium', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'premium',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.premium.index');
    })->name('premium');

    // Resources Page
    Route::get('/resources', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'resources',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.resources.index');
    })->name('resources');

    // Science Page
    Route::get('/science', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'science',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.science.index');
    })->name('science');

    // Contact Page (Auto-rekod pelawat)
    Route::get('/contact', function (Request $request) {
        if (\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'contact',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.contact.index');
    })->name('contact');

    Route::get('/cart', fn() => view('frontend.cart.index'))->name('cart');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/
$adminSecret = config('admin.secret_key') ?: env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia');

Route::prefix("admin/{$adminSecret}")->name('admin.')->group(function () use ($adminSecret) {

    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.login');
    });

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    Route::middleware('auth')->group(function () use ($adminSecret) {
        Route::get('/dashboard', fn() => view('backend.admin.dashboard.admin', [
            'section' => 'dashboard',
            'secret' => $adminSecret,
        ]))->name('dashboard');

        Route::get('/products', [ProductsController::class, 'index'])->name('products');
        Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

        Route::get('/audience', [AudienceController::class, 'index'])->name('audience');
        Route::get('/audience/data', [AudienceController::class, 'data'])->name('audience.data');

        Route::get('/blogs', fn() => view('backend.admin.dashboard.admin', [
            'section' => 'blogs',
            'secret' => $adminSecret,
        ]))->name('blogs');

        Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit-logs');

        Route::get('/info', fn() => view('backend.admin.dashboard.admin', [
            'section' => 'info',
            'secret' => $adminSecret,
        ]))->name('info');

        Route::get('/settings', fn() => view('backend.admin.dashboard.admin', [
            'section' => 'settings',
            'secret' => $adminSecret,
        ]))->name('settings');

        Route::match(['get', 'post'], '/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});