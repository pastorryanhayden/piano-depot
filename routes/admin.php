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
    
    // Blog management
    Route::resource('blog-posts', BlogPostController::class);
    Route::post('blog-posts/{blogPost}/toggle-publish', [BlogPostController::class, 'togglePublish'])->name('blog-posts.toggle-publish');
    
    // Menu management
    Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('menus/{menuItem}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('menus/{menuItem}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
});