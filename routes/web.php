<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentListController;
use App\Http\Controllers\ParentInfoController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginStatusController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FeePaymentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//dashboard 
Route::get('/admin/students', [StudentListController::class, 'adminStudentList'])->name('students.admin_index');

Route::resource('studentLists', StudentListController::class);
Route::resource('tutors', TutorController::class);
Route::get('/tutors/{tutor}/edit', [TutorController::class, 'edit'])->name('tutors.edit');


Route::middleware('auth')->group(function () {
    Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');
    Route::get('/timetables/create', [TimetableController::class, 'create'])->name('timetables.create');
    Route::post('/timetables', [TimetableController::class, 'store'])->name('timetables.store');
    Route::get('/timetables/{timetable}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
    Route::put('/timetables/{timetable}', [TimetableController::class, 'update'])->name('timetables.update');
    Route::delete('/timetables/{timetable}', [TimetableController::class, 'destroy'])->name('timetables.destroy');
});

// Route::resource('timetables', TimetableController::class);
// Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');
// Route::get('/timetables/{timetable}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
// Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
//     // This will create routes for index, create, store, show, edit, update, destroy
//     Route::resource('subjects', SubjectController::class);
// });

Route::get('/timetable', [TimetableController::class, 'display'])->name('timetables.display');

Route::get('/timetables/export', [TimetableController::class, 'export'])->name('timetables.export');
Route::get('/timetables/report', [TimetableController::class, 'report'])->name('timetables.report');
Route::get('/timetables/download-pdf', [TimetableController::class, 'downloadPdf'])->name('timetables.download.pdf');

Route::get('/subjects/cleanup', [SubjectController::class, 'cleanupOrphans'])->name('subjects.cleanup');

Route::resource('materials', MaterialController::class);
Route::resource('certificates', CertificateController::class);

// Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendances.index');
// Route::post('/attendance/create', [AttendanceController::class, 'create'])->name('attendances.create');
// Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendances.store');
Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendances.create');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendances.store');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendances.index');


//parent
Route::get('/parents/create', [ParentInfoController::class, 'create'])->name('parents.create');

//register student for parent
Route::get('/enrollments/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');



//student
Route::middleware(['auth'])->group(function () {
    Route::get('/student-lists', [StudentListController::class, 'index'])->name('student_lists.index');
    Route::get('/student-lists/create', [StudentListController::class, 'create'])->name('student_lists.create');
    Route::post('/student-lists', [StudentListController::class, 'store'])->name('student_lists.store');
});


//admin student list
Route::get('/admin/students', [StudentListController::class, 'adminStudentList'])->name('studentLists.admin_index');

//parent material view
// Route::get('/materials/parent', [MaterialController::class, 'materialsForParent'])->name('materials.parent_view');

Route::get('/get-subjects/{level}', [App\Http\Controllers\SubjectController::class, 'getByLevel']);


//tutor certificate create
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/certificates/create', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return view('certificates.create');
    })->name('certificates.create');
});

//login status
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/login-status', [AdminLoginStatusController::class, 'index'])->name('admin.login-status');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/login-status', [AdminLoginStatusController::class, 'index'])->name('admin.login-status');
});


//about page
Route::get('/about', function () {
    return view('about');
});

//fee payment
Route::middleware(['auth'])->group(function () {
    Route::get('/fees', [FeePaymentController::class, 'index'])->name('fee_payments.index');
    Route::post('/fees/pay', [FeePaymentController::class, 'pay'])->name('fee_payments.pay');
    Route::get('/fees/success', [FeePaymentController::class, 'success'])->name('fee_payments.success');
});
Route::get('/fee-payments/admin-view', [FeePaymentController::class, 'adminView'])->name('fee_payments.admin_view');
Route::post('/fee-payments/{student}/reminder', [FeePaymentController::class, 'sendReminder'])->name('fee_payments.reminder');

//send reminder email regarding fee payment
Route::post('/fee-payments/remind/{student}', [FeePaymentController::class, 'sendReminder'])
    ->name('fee_payments.remind');

Route::get('/admin/fee-payments/export-pdf', [FeePaymentController::class, 'exportPdf'])->name('fee-payments.export-pdf');


//fee for admin 
// routes/web.php
// Route::get('/admin/fee-payments', [FeePaymentController::class, 'adminView'])->name('fee_payments.admin-index');
// Route::post('/fee-payments/{student}/reminder', [FeePaymentController::class, 'sendReminder'])->name('fee_payments.reminder');


//timetable
Route::middleware(['auth'])->group(function () {
    // Show timetable report page with filters and pagination
    Route::get('/timetable/report', [TimetableController::class, 'report'])
        ->name('timetable.report');

    // Export timetable report as CSV (passing filters via query params)
    Route::get('/timetable/report/export', [TimetableController::class, 'exportCsv'])
        ->name('timetable.report.export');
});


//blockchain certificate upload
Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
Route::post('/certificates/upload-ipfs', [CertificateController::class, 'uploadToIPFS'])->name('certificates.upload-ipfs');
Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');

// Route::post('/timetables', [TimetableController::class, 'store'])->name('timetables.store');
require __DIR__.'/auth.php';
