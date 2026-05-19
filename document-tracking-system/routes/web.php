<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
Route::middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'index'])->name('citizen.dashboard');

    // Appointments / calendar
    Route::get('/citizen/appointments', [AppointmentController::class, 'calendar'])->name('citizen.appointments.calendar');
    Route::get('/citizen/appointments/month-data', [AppointmentController::class, 'monthData'])->name('citizen.appointments.month-data');
    Route::get('/citizen/appointments/slots', [AppointmentController::class, 'slots'])->name('citizen.appointments.slots');
    Route::post('/citizen/appointments', [AppointmentController::class, 'store'])->name('citizen.appointments.store');
    Route::patch('/citizen/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('citizen.appointments.cancel');

    // Vault
    Route::get('/citizen/vault', [VaultController::class, 'index'])->name('citizen.vault.index');
    Route::get('/citizen/vault/scan', [VaultController::class, 'scan'])->name('citizen.vault.scan');
    Route::post('/citizen/vault/store', [VaultController::class, 'store'])->name('citizen.vault.store');
    Route::get('/citizen/vault/{document}/pdf', [VaultController::class, 'generatePdf'])->name('citizen.vault.pdf');
    Route::delete('/citizen/vault/{document}', [VaultController::class, 'destroy'])->name('citizen.vault.destroy');
});

// Staff routes
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/calendar', [StaffController::class, 'calendar'])->name('staff.calendar');
    Route::get('/staff/appointments/day', [StaffController::class, 'dayAppointments'])->name('staff.appointments.day');
    Route::patch('/staff/appointments/{appointment}/status', [StaffController::class, 'updateStatus'])->name('staff.appointments.status');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/off-days', [AdminController::class, 'offDays'])->name('admin.offdays');
    Route::post('/admin/off-days', [AdminController::class, 'addOffDay'])->name('admin.offdays.store');
    Route::delete('/admin/off-days/{offDay}', [AdminController::class, 'removeOffDay'])->name('admin.offdays.destroy');
});

// Profile (all authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
