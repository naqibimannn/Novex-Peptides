<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
        return view('frontend.products.show', ['productId' => $id]);
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

    Route::get('/cart', function () {
        return view('frontend.cart.index');
    })->name('cart');
});
