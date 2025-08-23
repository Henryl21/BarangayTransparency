<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\ExpenditureController;
use App\Http\Controllers\Admin\OfficerApprovalController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AdminDashboardController;

// -----------------------------
// Welcome Page Route
// -----------------------------
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// -----------------------------
// Alternative redirect routes (commented out)
// -----------------------------
// Route::redirect('/', '/admin/login');
// Route::redirect('/', '/login');

// -----------------------------
// Public Admin Auth Routes
// -----------------------------
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'register']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// -----------------------------
// Redirect old route (optional)
// -----------------------------
Route::get('/admin/expenditure/{id}/upload-receipt', function ($id) {
    return redirect("/admin/expenditures/{$id}/upload-receipt");
});

// -----------------------------
// Admin Protected Routes
// -----------------------------
Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {

    // Admin Dashboard (NEW)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Budget Dashboard (still available)
    Route::get('/budget-dashboard', [BudgetController::class, 'dashboard'])->name('budget.dashboard');

    // Budget CRUD
    Route::resource('/budget', BudgetController::class);

    // Income CRUD
    Route::get('/incomes', [IncomeController::class, 'index'])->name('income.index');
    Route::get('/incomes/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('/incomes', [IncomeController::class, 'store'])->name('income.store');
    Route::get('/incomes/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
    Route::put('/incomes/{id}', [IncomeController::class, 'update'])->name('income.update');
    Route::delete('/incomes/{id}', [IncomeController::class, 'destroy'])->name('income.destroy');

    // Expenditure CRUD
    Route::get('/expenditures', [ExpenditureController::class, 'index'])->name('expenditure.index');
    Route::get('/expenditures/create', [ExpenditureController::class, 'create'])->name('expenditure.create');
    Route::post('/expenditures', [ExpenditureController::class, 'store'])->name('expenditure.store');
    Route::get('/expenditures/{id}/edit', [ExpenditureController::class, 'edit'])->name('expenditure.edit');
    Route::put('/expenditures/{id}', [ExpenditureController::class, 'update'])->name('expenditure.update');
    Route::delete('/expenditures/{id}', [ExpenditureController::class, 'destroy'])->name('expenditure.destroy');

    // Receipt Routes - UPDATED
    Route::get('/expenditures/{id}/receipt', [ExpenditureController::class, 'receipt'])->name('expenditure.receipt');
    Route::get('/expenditures/{id}/view-receipt', [ExpenditureController::class, 'showReceipt'])->name('expenditure.showReceipt'); // NEW: Separate receipt view
    Route::get('/expenditures/{id}/serve-receipt', [ExpenditureController::class, 'serveReceipt'])->name('expenditure.serveReceipt'); // NEW: Direct receipt serving
    Route::get('/expenditures/{id}/download-receipt', [ExpenditureController::class, 'downloadReceipt'])->name('expenditure.downloadReceipt'); // NEW: Download receipt
    Route::post('/expenditures/{id}/upload-receipt', [ExpenditureController::class, 'storeReceipt'])->name('expenditure.storeReceipt');

    // Officer Approvals
    Route::get('/officers/approval', [OfficerApprovalController::class, 'index'])->name('officers.approval');

    // Announcements CRUD
    Route::resource('announcements', AnnouncementController::class);

});