<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\RegionController;

Route::get('/', [FeedbackController::class, 'create'])->name('home');
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/dashboard/export', [FeedbackController::class, 'export'])->name('feedback.export');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [FeedbackController::class, 'index'])->name('dashboard');
    Route::post('/ai/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');
});

Route::resource('regions', RegionController::class);