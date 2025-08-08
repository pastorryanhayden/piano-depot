<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PianoController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\MenuController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // Pages management
    Route::resource('pages', PageController::class);
    Route::post('pages/{page}/toggle-publish', [PageController::class, 'togglePublish'])->name('pages.toggle-publish');
    Route::post('pages/reorder', [PageController::class, 'reorder'])->name('pages.reorder');
    
    // Piano inventory management
    Route::resource('pianos', PianoController::class);
    Route::post('pianos/{piano}/toggle-featured', [PianoController::class, 'toggleFeatured'])->name('pianos.toggle-featured');
    Route::get('pianos-export', [PianoController::class, 'export'])->name('pianos.export');
    Route::get('pianos-import', [PianoController::class, 'showImportForm'])->name('pianos.import.form');
    Route::post('pianos-import', [PianoController::class, 'import'])->name('pianos.import');
    
    // Blog management
    Route::resource('blog-posts', BlogPostController::class);
    Route::post('blog-posts/{blogPost}/toggle-publish', [BlogPostController::class, 'togglePublish'])->name('blog-posts.toggle-publish');
    
    // Menu management
    Route::resource('menu', MenuController::class)->parameters(['menu' => 'menu']);
    Route::post('menu/reorder', [MenuController::class, 'reorder'])->name('menu.reorder');
    Route::patch('menu/{menu}/toggle', [MenuController::class, 'toggle'])->name('menu.toggle');
});