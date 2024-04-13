<?php

use App\Http\Controllers\ComponentCategoryController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ComponentPurchaseController;
use App\Http\Controllers\ComponentStockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MachineModelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('note.index');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
    // return redirect()->intended(route('/'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('note', NoteController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('component', ComponentController::class);
    Route::resource('component_category', ComponentCategoryController::class);
    Route::resource('machine_model', MachineModelController::class);
    Route::resource('component_stock', ComponentStockController::class);
    Route::resource('component_purchase', ComponentPurchaseController::class);


});



require __DIR__ . '/auth.php';
