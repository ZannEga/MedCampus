<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

// 1. HALAMAN PUBLIK & AUTENTIKASI
Route::get('/', function () {
    return view('index'); 
});

Route::get('/welcome', function () {
    return view('welcome'); 
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [AuthController::class, 'registerProcess']);
Route::post('/login', [AuthController::class, 'loginProcess']);

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

Route::get('/service-guide', function () {
    return view('service-guide');
});


// 2. HALAMAN ADMIN
Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/inventory', [MedicineController::class, 'index'])->name('admin.inventory');

    Route::get('/admin/schedules', function () {
        return view('admin-schedules'); 
    });

    Route::get('/admin/schedules/add', function () {
        return view('admin-schedule-add'); 
    });

    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules');
    Route::get('/admin/schedules/add', [ScheduleController::class, 'create']);
    Route::post('/admin/schedules/store', [ScheduleController::class, 'store']);

    Route::get('/admin/schedules/edit/{id}', [ScheduleController::class, 'edit']);
    Route::post('/admin/schedules/update/{id}', [ScheduleController::class, 'update']);
    Route::get('/admin/schedules/delete/{id}', [ScheduleController::class, 'destroy']);

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/add', [UserController::class, 'create']);
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('user.store');

    Route::get('/admin/users/edit', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::get('/admin/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::get('/admin/settings', function () {
        return view('admin-settings'); 
    });

    Route::get('/admin/medicine/add', function () {
        return view('admin-medicine-add'); 
    });

    Route::post('/admin/medicine/store', [MedicineController::class, 'store'])->name('medicine.store');

    Route::get('/admin/medicine/edit', function () {
        return view('admin-medicine-edit'); 
    });

    Route::get('/admin/medicine/edit/{id}', [MedicineController::class, 'edit']);
    Route::post('/admin/medicine/update/{id}', [MedicineController::class, 'update']);
    Route::get('/admin/medicine/delete/{id}', [MedicineController::class, 'destroy']);

});

// 3. HALAMAN DOKTER 
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
    Route::get('/doctor/records', [DoctorController::class, 'records'])->name('doctor.records');
    Route::get('/doctor/new-entry', [DoctorController::class, 'newEntry'])->name('doctor.new-entry');
    Route::post('/doctor/store-entry', [DoctorController::class, 'storeEntry'])->name('doctor.store-entry');
    Route::get('/doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    Route::get('/doctor/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::post('/doctor/profile/update', [DoctorController::class, 'updateProfile']);
    Route::post('/doctor/profile/password', [DoctorController::class, 'updatePassword']);
});

// 4. HALAMAN PASIEN
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/booking', [PatientController::class, 'booking'])->name('patient.booking');
    Route::post('/patient/store-booking', [PatientController::class, 'storeBooking']);
    Route::post('/patient/cancel-appointment', [PatientController::class, 'cancelAppointment']);
    Route::get('/patient/checkout', [PatientController::class, 'checkout'])->name('patient.checkout');
    Route::get('/patient/success', [PatientController::class, 'success'])->name('patient.success');
    Route::get('/patient/ticket', [PatientController::class, 'ticket'])->name('patient.ticket');
    Route::get('/patient/queue-detail', [PatientController::class, 'queueDetail'])->name('patient.queue-detail');
    Route::get('/patient/history', [PatientController::class, 'history'])->name('patient.history');
    Route::get('/patient/visit-detail', [PatientController::class, 'visitDetail'])->name('patient.visit-detail');
    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::post('/patient/profile/update', [App\Http\Controllers\PatientController::class, 'updateProfile']);
});

Route::get('/admin/users/delete/{id}', [UserController::class, 'destroy']);
Route::get('/api/doctor-shifts', [App\Http\Controllers\PatientController::class, 'getDoctorShifts']);