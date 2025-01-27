<?php

use App\Http\Controllers;
use App\Http\Controllers\Admin\AnalyticsAdminController;
use App\Http\Controllers\Admin\DiagnosaAdminController;
use App\Http\Controllers\Admin\LinkAdminController;
use App\Http\Controllers\Admin\QrcodeAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrcodeController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/', [Controllers\HomeController::class, 'index'])->name('home.index');
// Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/I/{short_url}', [Controllers\WithpasswordController::class, 'index'])->name('confirm-password.index');
Route::post('/I/{short_url}', [Controllers\WithpasswordController::class, 'redirect'])->name('confirm-password.redirect');

require __DIR__ . '/auth.php';
// Route::get('/login/sso', [Controllers\SSOController::class, "index"])->name('sso.index');
// Route::post('/login/sso/auth', [Controllers\SSOController::class, "store"])->name('sso.store');




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Rute Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/reset', [ProfileController::class, 'showResetForm'])->name('showResetForm.update');
    Route::post('/profile/reset', [ProfileController::class, 'reset'])->name('profile.reset');
});


Route::middleware(['role:user', 'auth'])->group(function () {

    // Diagnosa
    Route::resource('/diagnosa', DiagnosaController::class);
    Route::post('/diagnosa/save-temp', [DiagnosaController::class, 'saveTemp'])->name('diagnosa.saveTemp');
    Route::get('/diagnosa/detail/{id}', [DiagnosaController::class, 'show'])->name('diagnosa.show');


    });


Route::middleware(['auth', 'role:administrator'])->group(function () {
    // Rute Gejala
    Route::resource('/gejala', GejalaController::class);

    // Rute Diagnosa Admin
    Route::resource('/diagnosa_admin', DiagnosaAdminController::class);

    //Rute News
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');


    // Rute Admin
    Route::get('/user_management', [UserAdminController::class, 'index'])->name('admin.user.index');
    Route::put('/user_management/{user}', [UserAdminController::class, 'update'])->name('admin.user.update');
});
