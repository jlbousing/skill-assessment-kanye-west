<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuoteController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get("quotes",[QuoteController::class,"index"]);
    Route::post("quotes",[QuoteController::class,"store"]);
    Route::get("quotes/refresh", [QuoteController::class,"refresh"]);
    Route::get("quotes/favorites",[QuoteController::class,"favorites"]);
    Route::delete("quotes/quote/{text}",[QuoteController::class,"destroy"]);

    Route::get('/dashboard', function () {
        return redirect("quotes");
    })->name('dashboard');
});
