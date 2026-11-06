<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Admin\AdminLoginController;
use App\Http\Controllers\Backend\Admin\SettingsController;
use App\Http\Controllers\Backend\Admin\ProductsController;
use App\Http\Controllers\Backend\Admin\AuditController;
use App\Http\Controllers\Backend\Admin\AudienceController;
use App\Http\Controllers\Backend\Admin\OrganizationController;
use App\Http\Controllers\Backend\Admin\ResourcesController;
use App\Http\Controllers\Frontend\PageRouterController;
use App\Http\Controllers\SitemapController;

Route::any('/login', fn() => abort(404));
Route::any('/admin', fn() => abort(404));

Route::post('/admin/password/code/send', [AdminLoginController::class, 'sendResetCode'])->name('admin.password.code.send');
Route::post('/admin/password/code/verify', [AdminLoginController::class, 'verifyCodeAndReset'])->name('admin.password.code.verify');

Route::prefix('/')->group(function () {

    Route::get('/', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/about', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/products', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/products/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/show/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'show/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('products.direct_show');

    Route::get('/accessory', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/accessory/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/performance', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/performance/show', function (Request $request) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'performance/show',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.performance.show');
    })->name('performance.show');

    Route::get('/performance/show/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'performance/show/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('performance.show.detail');

    Route::get('/performance/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'performance/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->where('id', '^(?!show$).*')->name('performance.detail');

    Route::get('/premium', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/premium/show', function (Request $request) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'premium/show',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.premium.show');
    })->name('premium.show');

    Route::get('/premium/show/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'premium/show/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('premium.show.detail');

    Route::get('/premium/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'premium/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->where('id', '^(?!show$).*')->name('premium.detail');

    Route::get('/skin', function (Request $request) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'skin',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.skin.index');
    })->name('skin');

    Route::get('/skin/show', function (Request $request) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'skin/show',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.skin.show');
    })->name('skin.show');

    Route::get('/skin/show/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'skin/show/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('skin.show.detail');

    Route::get('/skin/{id}', function (Request $request, $id) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'skin/' . $id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->where('id', '^(?!show$).*')->name('skin.detail');

    Route::get('/resources', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/resources/{slug}', function (Request $request, $slug) {
        if (Schema::hasTable('page_views')) {
            DB::table('page_views')->insert([
                'page_url'   => 'resources/' . $slug,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $resource = DB::table('resources')->where('slug', $slug)->first();
        if (!$resource) {
            abort(404);
        }
        return view('frontend.resources.show', compact('resource'));
    })->name('resources.show');

    Route::get('/science', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

    Route::get('/contact', function (Request $request) {
        if (Schema::hasTable('page_views')) {
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

$adminSecret = config('admin.secret_key') ?: env('ADMIN_SECRET_KEY') ?: 'default_secret_key';

Route::prefix("admin/{$adminSecret}")->name('admin.')->group(function () use ($adminSecret) {

    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.login');
    });

    Route::middleware('guest')->group(function () use ($adminSecret) {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    Route::middleware('auth')->group(function () use ($adminSecret) {
        Route::get('/dashboard', fn() => view('backend.admin.dashboard.admin', [
            'section' => 'dashboard',
            'secret'  => $adminSecret,
        ]))->name('dashboard');

        Route::get('/products', [ProductsController::class, 'index'])->name('products');
        Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

        Route::get('/audience', [AudienceController::class, 'index'])->name('audience');
        Route::get('/audience/data', [AudienceController::class, 'data'])->name('audience.data');

        Route::get('/blogs', [ResourcesController::class, 'index'])->name('blogs');
        Route::get('/resources', [ResourcesController::class, 'index'])->name('resources');
        Route::post('/resources', [ResourcesController::class, 'store'])->name('resources.store');
        Route::put('/resources/{id}', [ResourcesController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{id}', [ResourcesController::class, 'destroy'])->name('resources.destroy');

        Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit-logs');

        Route::get('/info', [OrganizationController::class, 'index'])->name('info');
        Route::post('/info', [OrganizationController::class, 'update'])->name('info.update');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/otp/send', [SettingsController::class, 'sendOtp'])->name('settings.otp.send');
        Route::post('/settings/password/update', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        Route::post('/settings/email/update', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
        Route::post('/settings/password/request', [SettingsController::class, 'sendOtp'])->name('settings.password.request');

        Route::match(['get', 'post'], '/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});

Route::fallback([PageRouterController::class, 'handle']);

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::view('/privacy-policy', 'frontend.privacy-policy.index')->name('privacy');