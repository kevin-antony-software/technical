<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\CommonIssueController;
use App\Http\Controllers\ComponentCategoryController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ComponentPurchaseController;
use App\Http\Controllers\ComponentStockController;
use App\Http\Controllers\CourierWeightPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MachineModelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairJobController;
use App\Http\Controllers\UserController;
use App\Models\CourierWeightPrice;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;
use Pest\Plugins\Only;

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
    Route::get('/user/{id}', [UserController::class, 'changePassword'])->name('user.changePassword')->middleware('can:admin-only');
    Route::post('/user/changePasswordSave', [UserController::class, 'changePasswordSave'])->name('user.changePasswordSave')->middleware('can:admin-only');
    Route::resource('user', UserController::class)->middleware('can:admin-only');
    Route::resource('customer', CustomerController::class);
    Route::resource('component', ComponentController::class);
    Route::resource('component_category', ComponentCategoryController::class);
    Route::resource('machine_model', MachineModelController::class);
    Route::resource('component_stock', ComponentStockController::class);
    Route::resource('component_purchase', ComponentPurchaseController::class);
    Route::resource('courier_weight_charge', CourierWeightPriceController::class);
    Route::resource('common_issue', CommonIssueController::class);

    Route::get('repair_job/printDetail/{id}', [RepairJobController::class, 'printDetail'])->name('repair_job.printDetail');
    Route::get('repair_job/print/{id}', [RepairJobController::class, 'print'])->name('repair_job.print');
    Route::get('repair_job/start/{id}', [RepairJobController::class, 'start'])->name('repair_job.start');
    Route::get('repair_job/close/{id}', [RepairJobController::class, 'close'])->name('repair_job.close');
    Route::post('repair_job/closeSave/{job}', [RepairJobController::class, 'closeSave'])->name('repair_job.closeSave');
    Route::get('repair_job/estimate/{id}', [RepairJobController::class, 'estimate'])->name('repair_job.estimate');
    Route::post('repair_job/estimateSave/{job}', [RepairJobController::class, 'estimateSave'])->name('repair_job.estimateSave');
    Route::get('repair_job/deliverPage/{id}', [RepairJobController::class, 'deliverPage'])->name('repair_job.deliverPage');
    Route::post('repair_job/deliverSave/{job}', [RepairJobController::class, 'deliverSave'])->name('repair_job.deliverSave');
    Route::post('repair_job/changeWarranty/{job}', [RepairJobController::class, 'changeWarranty'])->name('repair_job.changeWarranty');
    Route::post('repair_job/uploadImagepage/{job}', [RepairJobController::class, 'uploadImagepage'])->name('repair_job.uploadImagepage');
    Route::post('repair_job/uploadImageSave/{job}', [RepairJobController::class, 'uploadImageSave'])->name('repair_job.uploadImageSave');
    Route::resource('repair_job', RepairJobController::class);

    Route::resource('bank', BankController::class);
    Route::resource('bank_detail', BankDetailController::class);
    Route::resource('cash', CashController::class);

    Route::get('cheque/returnCheque/{cheque}', [ChequeController::class, 'returnCheque'])->name('cheque.returnCheque')->middleware('can:director-only');
    Route::post('cheque/passCheque/{cheque}', [ChequeController::class, 'passCheque'])->name('cheque.passCheque')->middleware('can:director-only');
    Route::resource('cheque', ChequeController::class);
    
    Route::resource('expense', ExpenseController::class);
});

require __DIR__ . '/auth.php';
