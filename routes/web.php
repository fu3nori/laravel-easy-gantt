<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\Authenticate;

Route::get('/', [UserDataController::class, 'index'])->name('home');
Route::post('/login', [UserDataController::class, 'login'])->name('login');
Route::post('/register', [UserDataController::class, 'register'])->name('register');
Route::post('/logout', [UserDataController::class, 'logout'])->name('logout');

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard/create-project', [DashboardController::class, 'create_project'])->name('dashboard.create_project');
    Route::delete('/dashboard/delete-project/{id}', [DashboardController::class, 'delete_project'])->name('dashboard.delete_project');
    Route::post('/project', [ProjectController::class, 'index'])->name('project.index');
});
