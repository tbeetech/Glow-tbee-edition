<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Api\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Api\Admin\ShowsController as AdminShowsController;
use App\Http\Controllers\Api\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PodcastController;
use App\Http\Controllers\Api\ShowController;

Route::get('/home', [HomeController::class, 'show']);

Route::get('/shows', [ShowController::class, 'index']);
Route::get('/shows/{slug}', [ShowController::class, 'show']);
Route::get('/schedule', [ShowController::class, 'schedule']);

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);

Route::get('/podcasts', [PodcastController::class, 'index']);
Route::get('/podcasts/{slug}', [PodcastController::class, 'show']);
Route::get('/podcasts/{showSlug}/{episodeSlug}', [PodcastController::class, 'episode']);

Route::get('/about', [AboutController::class, 'show']);
Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'store']);

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['api_token'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['api_token', 'api_admin_or_staff'])->prefix('/admin')->group(function () {
    Route::get('/overview', [AdminDashboardController::class, 'overview']);
    Route::get('/news', [AdminNewsController::class, 'index']);
    Route::get('/blog', [AdminBlogController::class, 'index']);
    Route::get('/shows', [AdminShowsController::class, 'index']);
    Route::get('/team/oaps', [AdminTeamController::class, 'oaps']);
    Route::get('/team/staff', [AdminTeamController::class, 'staff']);
});
