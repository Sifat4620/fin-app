<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Backup\BackupController;
use App\Http\Controllers\Support\TicketController;
use App\Http\Controllers\Billing\BillingCycleController;
use App\Http\Controllers\Clients\UserController;
use App\Http\Controllers\Invoices\InvoiceController;
use App\Http\Controllers\Banks\BankController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Payment\MyPaymentController;
use App\Http\Controllers\Admin\PaymentApprovalController;







Route::middleware(['auth'])->group(function () {

    // =====================
    // Dashboard
    // =====================
    Route::get('/', fn () => view('dashboard'))->name('dashboard');

    // =====================
    // Profile Routes
    // =====================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // =====================
    // User Routes (Client Users)
    // =====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/settings', [UserController::class, 'settings'])->name('settings');
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // =====================
    // My DPS Payments
    // =====================
    Route::prefix('my-payments')->middleware(['auth'])->group(function () {
        Route::get('/', [MyPaymentController::class, 'index'])->name('my.payments.index');
        Route::get('/create', [MyPaymentController::class, 'create'])->name('my.payments.create');
        Route::post('/', [MyPaymentController::class, 'store'])->name('my.payments.store');
    });

    Route::prefix('admin/payments')->name('admin.payments.')->group(function () {
        Route::get('/pending', [PaymentApprovalController::class, 'index'])->name('pending');
        Route::post('/approve/{id}', [PaymentApprovalController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [PaymentApprovalController::class, 'reject'])->name('reject');
    });
    

    // =====================
    // Branch Management
    // =====================
    Route::prefix('branches')->name('branches.')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('index');
        Route::get('/create', [BranchController::class, 'create'])->name('create');
        Route::post('/', [BranchController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BranchController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BranchController::class, 'update'])->name('update');
        Route::delete('/{id}', [BranchController::class, 'destroy'])->name('destroy');
    });

    // =====================
    // Reports
    // =====================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/clients', [ReportController::class, 'clients'])->name('clients');
        Route::get('/invoices', [ReportController::class, 'invoices'])->name('invoices');
        Route::get('/user-payments/yearly', [ReportController::class, 'yearlyUserPayments'])->name('user.payments.yearly');
        Route::get('/user-payments/monthly', [ReportController::class, 'monthlyUserPayments'])->name('user.payments.monthly');
    });

    // =====================
    // Admin Panel
    // =====================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/settings', [AdminPanelController::class, 'settings'])->name('settings');
        Route::get('/permissions', [AdminPanelController::class, 'permissions'])->name('permissions');
        Route::get('/roles', [AdminPanelController::class, 'roles'])->name('roles');
       
        
    });




    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');         
        Route::get('/create', [InvoiceController::class, 'create'])->name('create'); 
        Route::post('/', [InvoiceController::class, 'store'])->name('store');       
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');  
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit'); 
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update'); 
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
    });



    
    // =====================
    // Backup System
    // =====================
    // Route::prefix('backup')->name('backup.')->group(function () {
    //     Route::get('/', [BackupController::class, 'index'])->name('index');
    //     Route::post('/create', [BackupController::class, 'createBackup'])->name('create');
    //     Route::get('/download/{filename}', [BackupController::class, 'downloadBackup'])->name('download');
    //     Route::delete('/delete/{filename}', [BackupController::class, 'deleteBackup'])->name('delete');
    //     Route::post('/now', [BackupController::class, 'backupNow'])->name('now');
    // });

    // =====================
    // Roles Management
    // =====================
    // Route::prefix('roles')->name('roles.')->controller(RoleController::class)->group(function () {
    //     Route::get('/users', 'users')->name('users');
    //     Route::get('/admins', 'admins')->name('admins');
    //     Route::get('/user/{user}/edit', 'edit_user')->name('user.edit');
    //     Route::patch('/assign_role_to_user/{user}', 'assign_role_to_user')->name('assign_role_to_user');
    //     Route::patch('/sync_permissions_to_role/{role}', 'sync_permissions_to_role')->name('sync_permissions_to_role');
    // });
});

// =====================
// Authentication Routes
// =====================
require __DIR__ . '/auth.php';
