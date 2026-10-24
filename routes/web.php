<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Frontend
|--------------------------------------------------------------------------
*/
Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('frontend.home.index');
    })->name('home');

    Route::get('/about', function () {
        return view('frontend.about.index');
    })->name('about');

    Route::get('/products', function () {
        return view('frontend.products.index');
    })->name('products.index');

    Route::get('/products/{id}', function ($id) {
        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('products.show');

    Route::get('/science', function () {
        return view('frontend.science.index');
    })->name('science');

    Route::get('/resources', function () {
        return view('frontend.resources.index');
    })->name('resources');

    Route::get('/contact', function () {
        return view('frontend.contact.index');
    })->name('contact');

    Route::get('/accessory', function () {
        return view('frontend.accessory.index');
    })->name('accessory');

    Route::get('/accessory/{id}', function ($id) {
        return view('frontend.products.show', ['id' => $id, 'productId' => $id]);
    })->name('accessory.show');

    Route::get('/cart', function () {
        return view('frontend.cart.index');
    })->name('cart');
});

/*
|--------------------------------------------------------------------------
| Web Routes - Backend / Admin Mockup
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'dashboard',
            'secret' => 'admin'
        ]);
    })->name('admin.dashboard');

    Route::get('/audience', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'audience',
            'secret' => 'admin'
        ]);
    })->name('admin.audience');

    Route::get('/blogs', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'blogs',
            'secret' => 'admin'
        ]);
    })->name('admin.blogs');

    Route::get('/audit-logs', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'audit-logs',
            'secret' => 'admin'
        ]);
    })->name('admin.audit-logs');

    Route::get('/info', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'info',
            'secret' => 'admin'
        ]);
    })->name('admin.info');

    Route::get('/settings', function () {
        return view('backend.admin.dashboard.admin', [
            'section' => 'settings',
            'secret' => 'admin'
        ]);
    })->name('admin.settings');

    Route::get('/audience/data', function () {
        return response()->json([
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => [140, 210, 320, 510, 260, 340, 430],
            'total' => 2210,
            'todayViews' => 510,
        ]);
    })->name('admin.audience.data');

    Route::post('/logout', function () {
        return redirect()->route('home');
    })->name('admin.logout');
});