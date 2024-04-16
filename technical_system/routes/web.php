<?php

use App\Http\Controllers\CommonIssueController;
use App\Http\Controllers\ComponentCategoryController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ComponentPurchaseController;
use App\Http\Controllers\ComponentStockController;
use App\Http\Controllers\CourierWeightPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MachineModelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Models\CourierWeightPrice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('admin.customer.index');
    return to_route('customer.index');
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
    Route::resource('courier_weight_charge', CourierWeightPriceController::class);
    Route::resource('common_issue', CommonIssueController::class);

});



require __DIR__ . '/auth.php';
