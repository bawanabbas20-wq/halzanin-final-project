<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\CitizenController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;

Route::get('/track/{code?}', function ($code = null) {
    if (!$code) {
        return view('track', ['application' => null]);
    }

    $application = \App\Models\Application::with(['statusLogs' => function($q) {
        $q->orderBy('created_at', 'asc');
    }])->where('tracking_code', $code)->firstOrFail();
    
    return view('track', compact('application'));
})->name('track');

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $role = auth()->user()->role ?? 'citizen';
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'staff') {
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('citizen.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'index'])->name('citizen.dashboard');
    
    Route::get('/citizen/appointment/create', [\App\Http\Controllers\AppointmentController::class, 'create'])->name('citizen.appointment.create');
    Route::post('/citizen/appointment/save-draft', [\App\Http\Controllers\AppointmentController::class, 'saveDraft'])->name('citizen.appointment.save-draft');
    Route::post('/citizen/appointment', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('citizen.appointment.store');
    Route::get('/citizen/applications/{id}/qr-receipt', [\App\Http\Controllers\ApplicationController::class, 'showQrReceipt'])->name('citizen.applications.qr-receipt');
    Route::get('/citizen/applications/{id}/qr-pdf', [\App\Http\Controllers\ApplicationController::class, 'downloadPdf'])->name('citizen.applications.qr-pdf');
    Route::get('/citizen/applications/{id}/upload', [\App\Http\Controllers\DocumentController::class, 'create'])->name('citizen.documents.create');
    Route::post('/citizen/applications/{id}/upload', [\App\Http\Controllers\DocumentController::class, 'store'])->name('citizen.documents.store');

    Route::get('/citizen/vault', [\App\Http\Controllers\VaultController::class, 'index'])->name('citizen.vault.index');
    Route::get('/citizen/vault/scan', [\App\Http\Controllers\VaultController::class, 'scan'])->name('citizen.vault.scan');
    Route::post('/citizen/vault', [\App\Http\Controllers\VaultController::class, 'store'])->name('citizen.vault.store');
    Route::get('/citizen/vault/file/{id}/{format?}', [\App\Http\Controllers\VaultController::class, 'viewFile'])->name('citizen.vault.file');
    Route::delete('/citizen/vault/{id}', [\App\Http\Controllers\VaultController::class, 'destroy'])->name('citizen.vault.destroy');
});

Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/queue', [StaffController::class, 'index'])->name('staff.queue');
    Route::get('/staff/calendar', [StaffController::class, 'calendar'])->name('staff.calendar');
    Route::get('/staff/applications/{id}', [StaffController::class, 'show'])->name('staff.applications.show');
    Route::patch('/staff/applications/{id}/status', [StaffController::class, 'updateStatus'])->name('staff.applications.update-status');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.update-role');
});

use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');

    Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read',  [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all',    [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';
