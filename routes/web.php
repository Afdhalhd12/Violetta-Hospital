<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpecializationController;
use App\Models\Specialization;
use Illuminate\Support\Facades\Route;

route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/filter-doctor', [UserController::class, 'filterDoctor'])->name('filter.doctor');



Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/complaints', function () {
    return view('complaints');
})->name('complain');

route::post('/signup', [UserController::class, 'store'])->name('signup.store');
route::post('/login', [UserController::class, 'login'])->name('login.auth');
route::get('/logout', [UserController::class, 'logout'])->name('logout');

route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    route::prefix('/doctor')->name('doctor.')->group(function () {
        route::get('/appointments/chart', [AppointmentController::class, 'chartData'])->name('tickets.chart');
        Route::get('/appointments/chart-specialization', [AppointmentController::class, 'chartBySpecialization'])
            ->name('specialization.chart');
    route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
        route::get('/', [UserController::class, 'index'])->name('index');
        route::get('/create', [UserController::class, 'create'])->name('create');
        route::post('/store', [UserController::class, 'storeDoctor'])->name('store');

        route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');

         route::get('/trash', [UserController::class, 'trash'])->name('trash');
        route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
        route::get('/export', [UserController::class, 'export'])->name('export');
        route::get('/datatables', [UserController::class, 'dataForDatatables'])->name('datatables');
    });

     route::prefix('/specialization')->name('specialization.')->group(function () {
         route::get('/', [SpecializationController::class, 'index'])->name('index');
         route::get('/create', [SpecializationController::class, 'create'])->name('create');
         route::post('/store', [SpecializationController::class, 'store'])->name('store');

        route::get('/edit/{id}', [SpecializationController::class, 'edit'])->name('edit');
        route::put('/update/{id}', [SpecializationController::class, 'update'])->name('update');
        route::delete('/delete/{id}', [SpecializationController::class, 'destroy'])->name('delete');

        route::get('/trash', [SpecializationController::class, 'trash'])->name('trash');
        route::patch('/restore/{id}', [SpecializationController::class, 'restore'])->name('restore');
        route::delete('/delete-permanent/{id}', [SpecializationController::class, 'deletePermanent'])->name('delete_permanent');
        route::get('/export', [SpecializationController::class, 'export'])->name('export');
        route::get('/datatables', [SpecializationController::class, 'dataForDatatables'])->name('datatables');
     });
});

Route::middleware('auth')->prefix('appointment')->name('appointment.')->group(function() {
    Route::get('/create', [AppointmentController::class, 'create'])->name('create');
    Route::post('/store', [AppointmentController::class, 'store'])->name('store');
    route::get('/detail', [AppointmentController::class, 'show'])->name('detail');
    route::get('/payment', [AppointmentController::class, 'payment'])->name('payment');
    route::get('/paymentdetail', [AppointmentController::class, 'paymentDetail'])->name('payment.detail');
    route::get('/export', [AppointmentController::class, 'export_patient'])->name('export_patient');
    Route::post('/{appointment}/generate-qr', [AppointmentController::class, 'generateQr'])->name('generateQr');
    Route::get('/{appointment}/qr', [AppointmentController::class, 'showQr'])->name('qr');
    Route::post('/{appointment}/confirm', [AppointmentController::class, 'confirmPayment'])->name('confirm');
    route::get('/{appointment}/export/pdf', [AppointmentController::class,'exportPdf'])->name('export.pdf');
});

Route::middleware('isDoctor')->prefix('dokter')->name('dokter.')->group(function() {
     route::prefix('/dashboard')->name('dashboard.')->group(function () {
         route::get('/', [AppointmentController::class, 'index'])->name('index');
         route::patch('/update/{id}', [AppointmentController::class, 'update'])->name('update');
         route::get('/export', [AppointmentController::class, 'export'])->name('export');
     });
});


