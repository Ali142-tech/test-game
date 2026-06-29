<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TicketOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorldCupMatchController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', HomeController::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/buy/{worldCupMatch}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/buy/{worldCupMatch}', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/matches', [WorldCupMatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/create', [WorldCupMatchController::class, 'create'])->name('matches.create');
    Route::post('/matches', [WorldCupMatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{worldCupMatch}/edit', [WorldCupMatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{worldCupMatch}', [WorldCupMatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{worldCupMatch}', [WorldCupMatchController::class, 'destroy'])->name('matches.destroy');
    Route::get('/tickets', [TicketOrderController::class, 'index'])->name('tickets.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
