<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffScanController;
use App\Http\Controllers\SubRoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/chatbot/public', [ChatbotController::class, 'publicChat'])
    ->middleware('throttle:20,1')
    ->name('chatbot.public');

// Public application tracking (no auth required)
Route::get('/track', function () {
    return view('track', ['application' => null]);
})->name('track');

Route::get('/track/{code}', function ($code) {
    $application = \App\Models\Application::with(['appointment', 'statusLogs', 'user'])
        ->where('tracking_code', $code)
        ->first();
    return view('track', ['application' => $application]);
})->name('track.code');

Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'citizen';
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'staff') {
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('citizen.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Citizen routes
Route::middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'index'])->name('citizen.dashboard');

    // Appointments / calendar
    Route::get('/citizen/appointments', [AppointmentController::class, 'calendar'])->name('citizen.appointments.calendar');
    Route::get('/citizen/appointments/month-data', [AppointmentController::class, 'monthData'])->name('citizen.appointments.month-data');
    Route::get('/citizen/appointments/slots', [AppointmentController::class, 'slots'])->name('citizen.appointments.slots');
    Route::get('/citizen/appointments/vault-docs', [AppointmentController::class, 'vaultDocs'])->name('citizen.appointments.vault-docs');
    Route::post('/citizen/appointments', [AppointmentController::class, 'store'])->name('citizen.appointments.store');
    Route::patch('/citizen/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('citizen.appointments.cancel');

    // Applications
    Route::get('/citizen/track', [CitizenController::class, 'myApplications'])->name('citizen.applications.index');
    Route::get('/citizen/applications/{application}/receipt', [CitizenController::class, 'qrReceipt'])->name('citizen.applications.qr-receipt');
    Route::get('/citizen/applications/{application}/receipt/download', [CitizenController::class, 'downloadReceipt'])->name('citizen.applications.qr-receipt.download');

    // Vault
    Route::get('/citizen/vault', [VaultController::class, 'index'])->name('citizen.vault.index');
    Route::get('/citizen/vault/scan', [VaultController::class, 'scan'])->name('citizen.vault.scan');
    Route::post('/citizen/vault/store', [VaultController::class, 'store'])->name('citizen.vault.store');
    Route::get('/citizen/vault/{document}/view/{format}', [VaultController::class, 'viewFile'])->name('citizen.vault.file');
    Route::delete('/citizen/vault/{document}', [VaultController::class, 'destroy'])->name('citizen.vault.destroy');
});

// Staff routes
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');

    // Queue — requires view_queue permission
    Route::get('/staff/queue', [StaffController::class, 'queue'])
        ->middleware('permission:view_queue')
        ->name('staff.queue');

    // Calendar month data (used by the merged queue/calendar page)
    Route::get('/staff/calendar/month-data', [StaffController::class, 'calendarMonthData'])->name('staff.calendar.month-data');

    // Appointments day panel + status update
    Route::get('/staff/appointments/day', [StaffController::class, 'dayAppointments'])->name('staff.appointments.day');
    Route::patch('/staff/appointments/{appointment}/status', [StaffController::class, 'updateStatus'])
        ->middleware('permission:confirm_appointments')
        ->name('staff.appointments.status');

    // Application detail + status update
    Route::get('/staff/applications/{application}', [StaffController::class, 'showApplication'])
        ->middleware('permission:view_queue')
        ->name('staff.applications.show');
    Route::patch('/staff/applications/{application}/status', [StaffController::class, 'updateApplicationStatus'])
        ->middleware('permission:update_application_status')
        ->name('staff.applications.update-status');

    // Documents
    Route::get('/staff/documents/{id}/view', [StaffController::class, 'viewDocument'])
        ->middleware('permission:view_documents')
        ->name('staff.documents.view');

    // QR Check-in Scanner
    Route::get('/staff/scan', [StaffScanController::class, 'index'])
        ->middleware('permission:scan_qr_checkin')
        ->name('staff.scan');
    Route::post('/staff/scan/checkin', [StaffScanController::class, 'checkin'])
        ->middleware('permission:scan_qr_checkin')
        ->name('staff.scan.checkin');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.update-role');
    Route::get('/admin/off-days', [AdminController::class, 'offDays'])->name('admin.off-days');
    Route::post('/admin/off-days', [AdminController::class, 'addOffDay'])->name('admin.offdays.store');
    Route::delete('/admin/off-days/{offDay}', [AdminController::class, 'removeOffDay'])->name('admin.offdays.destroy');

    // Sub-role management
    Route::prefix('admin/sub-roles')->group(function () {
        Route::get('/', [SubRoleController::class, 'index'])->name('admin.sub-roles.index');
        Route::get('/create', [SubRoleController::class, 'create'])->name('admin.sub-roles.create');
        Route::post('/', [SubRoleController::class, 'store'])->name('admin.sub-roles.store');
        Route::get('/{id}/edit', [SubRoleController::class, 'edit'])->name('admin.sub-roles.edit');
        Route::patch('/{id}', [SubRoleController::class, 'update'])->name('admin.sub-roles.update');
        Route::delete('/{id}', [SubRoleController::class, 'destroy'])->name('admin.sub-roles.destroy');
        Route::post('/assign/{userId}', [SubRoleController::class, 'assign'])->name('admin.sub-roles.assign');
        Route::delete('/unassign/{userId}/{subRoleId}', [SubRoleController::class, 'unassign'])->name('admin.sub-roles.unassign');
    });
});

// Profile (all authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chatbot endpoints
    Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
    Route::post('/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat.legacy');

    // Notifications endpoints
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';
