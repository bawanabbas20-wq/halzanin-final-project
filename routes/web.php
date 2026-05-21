<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SubRoleController;
use App\Http\Controllers\StaffScanController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $activeServices = \App\Models\Service::where('is_active', true)->pluck('slug')->all();
    $portalStats = [
        'ministries'   => \App\Models\Ministry::count() ?: 5,
        'services'     => \App\Models\Service::count() ?: 15,
        'applications' => \App\Models\Application::count(),
        'citizens'     => \App\Models\User::where('role', 'citizen')->count(),
    ];
    return view('welcome', compact('activeServices', 'portalStats'));
});

// Public service detail pages (no auth required)
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Service apply form + submit (auth + citizen role required)
Route::middleware(['auth', 'verified.otp', 'role:citizen', 'throttle:authenticated'])->group(function () {
    Route::get('/apply/{slug}', [ServiceController::class, 'applyForm'])->name('services.apply');
    Route::post('/apply/{slug}', [ServiceController::class, 'store'])->name('services.store');
});

// SECURITY (OWASP A07): public track endpoints capped at 10 req/min per IP.
Route::middleware('throttle:public')->group(function () {
    Route::get('/track', [TrackController::class, 'show'])->name('track');
    Route::get('/track/{code}', [TrackController::class, 'show'])->name('track.show');
});

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
Route::middleware(['auth', 'verified.otp', 'role:citizen', 'throttle:authenticated'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'index'])->name('citizen.dashboard');
    Route::get('/citizen/applications', [ApplicationController::class, 'index'])->name('citizen.applications.index');

    // Appointments / calendar
    Route::get('/citizen/appointments', [AppointmentController::class, 'calendar'])->name('citizen.appointments.calendar');
    Route::get('/citizen/appointments/month-data', [AppointmentController::class, 'monthData'])->name('citizen.appointments.month-data');
    Route::get('/citizen/appointments/slots', [AppointmentController::class, 'slots'])->name('citizen.appointments.slots');
    Route::get('/citizen/appointments/vault-docs', [AppointmentController::class, 'vaultDocs'])->name('citizen.appointments.vault-docs');
    Route::post('/citizen/appointments', [AppointmentController::class, 'store'])->name('citizen.appointments.store');
    Route::patch('/citizen/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('citizen.appointments.cancel');
    Route::get('/citizen/applications/{application}/receipt', [ApplicationController::class, 'showQrReceipt'])->name('citizen.applications.receipt');
    Route::get('/citizen/applications/{application}/receipt.pdf', [ApplicationController::class, 'downloadPdf'])->name('citizen.applications.receipt.pdf');

    // Vault
    Route::get('/citizen/vault', [VaultController::class, 'index'])->name('citizen.vault.index');
    Route::get('/citizen/vault/scan', [VaultController::class, 'scan'])->name('citizen.vault.scan');
    Route::post('/citizen/vault/store', [VaultController::class, 'store'])->name('citizen.vault.store');
    Route::get('/citizen/vault/{document}/view/{format}', [VaultController::class, 'viewFile'])->name('citizen.vault.file');
    Route::delete('/citizen/vault/{document}', [VaultController::class, 'destroy'])->name('citizen.vault.destroy');
});

// Staff routes
Route::middleware(['auth', 'verified.otp', 'role:staff,admin', 'throttle:authenticated'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/queue', [ApplicationController::class, 'queue'])->middleware('permission:view_queue')->name('staff.queue');
    Route::get('/staff/applications/{application}', [ApplicationController::class, 'show'])->middleware('permission:view_documents')->name('staff.applications.show');
    Route::patch('/staff/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->middleware('permission:update_application_status')->name('staff.applications.update-status');
    Route::get('/staff/calendar', [StaffController::class, 'calendar'])->name('staff.calendar');
    Route::get('/staff/appointments/day', [StaffController::class, 'dayAppointments'])->middleware('permission:confirm_appointments')->name('staff.appointments.day');
    Route::patch('/staff/appointments/{appointment}/status', [StaffController::class, 'updateStatus'])->middleware('permission:confirm_appointments')->name('staff.appointments.status');
    Route::get('/staff/documents/{document}/file', [StaffController::class, 'viewDocument'])->middleware('permission:view_documents')->name('staff.documents.view');
    Route::get('/staff/scan', [StaffScanController::class, 'index'])->middleware('permission:scan_qr_checkin')->name('staff.scan');
    Route::post('/staff/scan/checkin', [StaffScanController::class, 'checkin'])->middleware('permission:scan_qr_checkin')->name('staff.scan.checkin');
});

// Admin routes
Route::middleware(['auth', 'verified.otp', 'role:admin', 'throttle:authenticated'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
    Route::patch('/admin/users/{user}/ministry', [AdminController::class, 'updateUserMinistry'])->name('admin.users.update-ministry');
    Route::patch('/admin/users/{user}/task-types', [AdminController::class, 'updateStaffTaskTypes'])->name('admin.users.update-task-types');
    Route::get('/admin/off-days', [AdminController::class, 'offDays'])->name('admin.offdays');
    Route::post('/admin/off-days', [AdminController::class, 'addOffDay'])->name('admin.offdays.store');
    Route::delete('/admin/off-days/{offDay}', [AdminController::class, 'removeOffDay'])->name('admin.offdays.destroy');
    Route::get('/admin/task-types', [AdminController::class, 'taskTypes'])->name('admin.task-types');
    Route::post('/admin/task-types', [AdminController::class, 'storeTaskType'])->name('admin.task-types.store');
    Route::delete('/admin/task-types/{taskType}', [AdminController::class, 'destroyTaskType'])->name('admin.task-types.destroy');
    Route::patch('/admin/applications/{application}/assign', [AdminController::class, 'assignApplication'])->name('admin.applications.assign');

    // Services management
    Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');
    Route::patch('/admin/services/{service}/toggle', [AdminController::class, 'toggleService'])->name('admin.services.toggle');

    // Sub-roles
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
Route::middleware(['auth', 'verified.otp', 'throttle:authenticated'])->group(function () {
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
