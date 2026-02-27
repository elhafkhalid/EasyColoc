<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocation.create');
    Route::get('/colocation', [ColocationController::class, 'index'])->name('colocation.index');
    Route::post('/colocation', [ColocationController::class, 'store'])->name('colocation.store');
    Route::get('/colocation/{colocation}', [ColocationController::class, 'show'])->name('colocation.show');
    Route::post('/colocation/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocation.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/colocation/{colocation}/depenses/create', [DepenseController::class, 'create'])->name('depenses.create');
    Route::post('/colocation/{colocation}/depenses', [DepenseController::class, 'store'])->name('depenses.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/colocation/{colocation}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/colocation/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/colocation/{colocation}/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/colocation/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/refuse', [InvitationController::class, 'refuse'])->name('invitations.refuse');
});

require __DIR__ . '/auth.php';
