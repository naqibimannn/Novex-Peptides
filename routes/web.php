<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Sekatan Keselamatan Laluan Terbuka
|--------------------------------------------------------------------------
*/
Route::any('/login', fn () => abort(404));
Route::any('/admin', fn () => abort(404));

/*
|--------------------------------------------------------------------------
| Laluan Frontend
|--------------------------------------------------------------------------
*/
Route::prefix('/')->group(function () {
    Route::get('/', fn () => view('frontend.home.index'))->name('home');
    Route::get('/about', fn () => view('frontend.about.index'))->name('about');
    Route::get('/products', fn () => view('frontend.products.index'))->name('products.index');
    Route::get('/products/{id}', fn ($id) => view('frontend.products.show', ['id' => $id, 'productId' => $id]))->name('products.show');
    Route::get('/science', fn () => view('frontend.science.index'))->name('science');
    Route::get('/resources', fn () => view('frontend.resources.index'))->name('resources');
    Route::get('/contact', fn () => view('frontend.contact.index'))->name('contact');
    Route::get('/accessory', fn () => view('frontend.accessory.index'))->name('accessory');
    Route::get('/accessory/{id}', fn ($id) => view('frontend.products.show', ['id' => $id, 'productId' => $id]))->name('accessory.show');
    Route::get('/cart', fn () => view('frontend.cart.index'))->name('cart');
});

/*
|--------------------------------------------------------------------------
| Laluan Khas Admin
|--------------------------------------------------------------------------
*/
$adminSecret = env('ADMIN_SECRET_KEY');

Route::prefix("admin/{$adminSecret}")->name('admin.')->group(function () use ($adminSecret) {

    // Akses Pelawat Pentadbir (Guest)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    Route::middleware('auth')->group(function () use ($adminSecret) {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));

        Route::get('/dashboard', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'dashboard',
            'secret' => $adminSecret,
        ]))->name('dashboard');

        Route::get('/products', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'products',
            'secret' => $adminSecret,
        ]))->name('products');

        Route::get('/audience', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'audience',
            'secret' => $adminSecret,
        ]))->name('audience');

        Route::get('/blogs', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'blogs',
            'secret' => $adminSecret,
        ]))->name('blogs');

        Route::get('/audit-logs', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'audit-logs',
            'secret' => $adminSecret,
        ]))->name('audit-logs');

        Route::get('/info', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'info',
            'secret' => $adminSecret,
        ]))->name('info');

        Route::get('/settings', fn () => view('backend.admin.dashboard.admin', [
            'section' => 'settings',
            'secret' => $adminSecret,
        ]))->name('settings');

        Route::get('/audience/data', function () {
            return response()->json([
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [140, 210, 320, 510, 260, 340, 430],
                'total' => 2210,
                'todayViews' => 510,
            ]);
        })->name('audience.data');

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});