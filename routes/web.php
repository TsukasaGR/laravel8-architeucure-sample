<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::name('article.')->prefix('article')->group(function () {
        Route::get('/index', [ArticleController::class, 'index'])->name('index');
        Route::get('/show/{article}', [ArticleController::class, 'show'])->name('show');
        Route::get('/create', [ArticleController::class, 'create'])->name('create');
        Route::post('/validate-url', [ArticleController::class, 'validateUrl'])->name('validateUrl');
        Route::get('/preview', [ArticleController::class, 'preview'])->name('preview');
        Route::post('/store', [ArticleController::class, 'store'])->name('store');
    });
    Route::name('comment.')->prefix('comment')->group(function () {
        Route::post('/store-or-update/{article}', [CommentController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });
    Route::name('user.')->prefix('user')->group(function () {
        Route::get('/show/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
    });
});

require __DIR__.'/auth.php';
