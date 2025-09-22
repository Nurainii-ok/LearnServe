<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\VideoContentController;
use App\Http\Controllers\ELearningController;

// Halaman Auth (Login & Register dalam 1 file)
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

Route::get('/enroll/free', function () {
    return 'Halaman enroll gratis (dummy)';
})->name('enroll.free');

// Login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::post('/register',[AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Umum
Route::prefix('/')->middleware(['prevent-back'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/learning', [PagesController::class, 'learning'])->name('learning');
    Route::get('/bootcamp', [PagesController::class, 'bootcamp'])->name('bootcamp');
    Route::get('/webinar', [PagesController::class, 'webinar'])->name('webinar');
    Route::get('/deskripsi_bootcamp/{id?}', [PagesController::class, 'deskripsibootcamp'])->name('deskripsi_bootcamp');
    Route::get('/detail_kursus/{id}', [PagesController::class, 'detailKursus'])->name('detail_kursus');
    Route::get('/form_payments', [PagesController::class, 'formPayments'])->name('form_payments');
    Route::get('/beli_sekarang', [PagesController::class, 'beliSekarang'])->name('beli_sekarang');
    Route::post('/checkout/process', [PagesController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [PagesController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/form_pendaftaran', [PagesController::class, 'formPendaftaran'])->name('form_pendaftaran');
    Route::get('/kelas', [PagesController::class, 'kelas'])->name('kelas');
    Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
    Route::get('/checkout-test', function() { return view('pages.checkout_test'); })->name('checkout.test');
});

// Payment Routes (Midtrans)
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/create-transaction', [PaymentController::class, 'createTransaction'])->name('create');
    Route::post('/notification', [PaymentController::class, 'handleNotification'])->name('notification');
    Route::get('/finish', [PaymentController::class, 'paymentFinish'])->name('finish');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('success');
    Route::get('/failed', [PaymentController::class, 'paymentFailed'])->name('failed');
    Route::get('/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('status');
    Route::get('/test', [PaymentController::class, 'testMidtrans'])->name('test');
});

// Member
Route::middleware(['role:member','prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Enrollment Routes
Route::middleware(['role:member','prevent-back'])->group(function () {
    Route::post('/enrollment/class/{classId}', [EnrollmentController::class, 'enrollClass'])->name('enrollment.class');
    Route::post('/enrollment/bootcamp/{bootcampId}', [EnrollmentController::class, 'enrollBootcamp'])->name('enrollment.bootcamp');
    Route::delete('/enrollment/{enrollmentId}', [EnrollmentController::class, 'unenroll'])->name('enrollment.unenroll');
    Route::patch('/enrollment/{enrollmentId}/progress', [EnrollmentController::class, 'updateProgress'])->name('enrollment.progress');
});

// Member Dashboard
Route::prefix('member')->middleware(['role:member','prevent-back'])->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/enrollments', [MemberController::class, 'enrollments'])->name('enrollments');
    Route::get('/grades', [MemberController::class, 'grades'])->name('grades');
    Route::get('/tasks', [MemberController::class, 'tasks'])->name('tasks');
});

// E-Learning Routes for Members
Route::prefix('elearning')->middleware(['role:member','prevent-back'])->name('elearning.')->group(function () {
    Route::get('/', [ELearningController::class, 'index'])->name('index');
    Route::get('/class/{classId}', [ELearningController::class, 'showClass'])->name('class');
    Route::get('/bootcamp/{bootcampId}', [ELearningController::class, 'showBootcamp'])->name('bootcamp');
    Route::get('/watch/{videoId}', [ELearningController::class, 'watchVideo'])->name('watch');
});

// Admin
Route::prefix('admin')->middleware(['role:admin','prevent-back'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Members CRUD
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/create', [AdminController::class, 'membersCreate'])->name('members.create');
    Route::post('/members', [AdminController::class, 'membersStore'])->name('members.store');
    Route::get('/members/{id}/edit', [AdminController::class, 'membersEdit'])->name('members.edit');
    Route::put('/members/{id}', [AdminController::class, 'membersUpdate'])->name('members.update');
    Route::delete('/members/{id}', [AdminController::class, 'membersDestroy'])->name('members.destroy');
    
    // Tutors CRUD
    Route::get('/tutors', [AdminController::class, 'tutors'])->name('tutors');
    Route::get('/tutors/create', [AdminController::class, 'tutorsCreate'])->name('tutors.create');
    Route::post('/tutors', [AdminController::class, 'tutorsStore'])->name('tutors.store');
    Route::get('/tutors/{id}/edit', [AdminController::class, 'tutorsEdit'])->name('tutors.edit');
    Route::put('/tutors/{id}', [AdminController::class, 'tutorsUpdate'])->name('tutors.update');
    Route::delete('/tutors/{id}', [AdminController::class, 'tutorsDestroy'])->name('tutors.destroy');
    
    // Classes CRUD
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [AdminController::class, 'classesCreate'])->name('classes.create');
    Route::post('/classes', [AdminController::class, 'classesStore'])->name('classes.store');
    Route::get('/classes/{id}/edit', [AdminController::class, 'classesEdit'])->name('classes.edit');
    Route::put('/classes/{id}', [AdminController::class, 'classesUpdate'])->name('classes.update');
    Route::delete('/classes/{id}', [AdminController::class, 'classesDestroy'])->name('classes.destroy');
    
    
    // Bootcamps CRUD
    Route::get('/bootcamps', [AdminController::class, 'bootcamps'])->name('bootcamps');
    Route::get('/bootcamps/create', [AdminController::class, 'bootcampsCreate'])->name('bootcamps.create');
    Route::post('/bootcamps', [AdminController::class, 'bootcampsStore'])->name('bootcamps.store');
    Route::get('/bootcamps/{id}/edit', [AdminController::class, 'bootcampsEdit'])->name('bootcamps.edit');
    Route::put('/bootcamps/{id}', [AdminController::class, 'bootcampsUpdate'])->name('bootcamps.update');
    Route::delete('/bootcamps/{id}', [AdminController::class, 'bootcampsDestroy'])->name('bootcamps.destroy');
    
    // Payments CRUD
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/payments/create', [AdminController::class, 'paymentsCreate'])->name('payments.create');
    Route::post('/payments', [AdminController::class, 'paymentsStore'])->name('payments.store');
    Route::get('/payments/{id}/edit', [AdminController::class, 'paymentsEdit'])->name('payments.edit');
    Route::put('/payments/{id}', [AdminController::class, 'paymentsUpdate'])->name('payments.update');
    Route::delete('/payments/{id}', [AdminController::class, 'paymentsDestroy'])->name('payments.destroy');
    
    // Tasks CRUD
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/create', [AdminController::class, 'tasksCreate'])->name('tasks.create');
    Route::post('/tasks', [AdminController::class, 'tasksStore'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [AdminController::class, 'tasksEdit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [AdminController::class, 'tasksUpdate'])->name('tasks.update');
    Route::delete('/tasks/{id}', [AdminController::class, 'tasksDestroy'])->name('tasks.destroy');
    
    // Enrollments Management
    Route::get('/enrollments', [EnrollmentController::class, 'adminIndex'])->name('enrollments');
    Route::delete('/enrollments/{id}', [EnrollmentController::class, 'adminDestroy'])->name('enrollments.destroy');
    
    // Video Contents CRUD
    Route::get('/video-contents', [VideoContentController::class, 'index'])->name('video-contents.index');
    Route::get('/video-contents/create', [VideoContentController::class, 'create'])->name('video-contents.create');
    Route::post('/video-contents', [VideoContentController::class, 'store'])->name('video-contents.store');
    Route::get('/video-contents/{videoContent}', [VideoContentController::class, 'show'])->name('video-contents.show');
    Route::get('/video-contents/{videoContent}/edit', [VideoContentController::class, 'edit'])->name('video-contents.edit');
    Route::put('/video-contents/{videoContent}', [VideoContentController::class, 'update'])->name('video-contents.update');
    Route::delete('/video-contents/{videoContent}', [VideoContentController::class, 'destroy'])->name('video-contents.destroy');
    
    // Account Management
    Route::get('/account', [AdminController::class, 'account'])->name('account');
    Route::get('/account/edit', [AdminController::class, 'accountEdit'])->name('account.edit');
    Route::put('/account', [AdminController::class, 'accountUpdate'])->name('account.update');
    Route::put('/account/password', [AdminController::class, 'accountPasswordUpdate'])->name('account.password.update');
});

// Tutor
Route::prefix('tutor')->middleware(['role:tutor','prevent-back'])->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    
    // Classes CRUD
    Route::get('/classes', [TutorController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [TutorController::class, 'classesCreate'])->name('classes.create');
    Route::post('/classes', [TutorController::class, 'classesStore'])->name('classes.store');
    Route::get('/classes/{id}/edit', [TutorController::class, 'classesEdit'])->name('classes.edit');
    Route::put('/classes/{id}', [TutorController::class, 'classesUpdate'])->name('classes.update');
    Route::delete('/classes/{id}', [TutorController::class, 'classesDestroy'])->name('classes.destroy');
    
    // Tasks CRUD
    Route::get('/tasks', [TutorController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/create', [TutorController::class, 'tasksCreate'])->name('tasks.create');
    Route::post('/tasks', [TutorController::class, 'tasksStore'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TutorController::class, 'tasksEdit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TutorController::class, 'tasksUpdate'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TutorController::class, 'tasksDestroy'])->name('tasks.destroy');
    
    // Grades CRUD 6
    Route::get('/grades', [TutorController::class, 'grades'])->name('grades');
    Route::get('/grades/create', [TutorController::class, 'gradesCreate'])->name('grades.create');
    Route::post('/grades', [TutorController::class, 'gradesStore'])->name('grades.store');
    Route::get('/grades/{id}/edit', [TutorController::class, 'gradesEdit'])->name('grades.edit');
    Route::put('/grades/{id}', [TutorController::class, 'gradesUpdate'])->name('grades.update');
    Route::delete('/grades/{id}', [TutorController::class, 'gradesDestroy'])->name('grades.destroy');

    // Video Contents CRUD
    Route::get('/video-contents', [VideoContentController::class, 'index'])->name('video-contents.index');
    Route::get('/video-contents/create', [VideoContentController::class, 'create'])->name('video-contents.create');
    Route::post('/video-contents', [VideoContentController::class, 'store'])->name('video-contents.store');
    Route::get('/video-contents/{videoContent}', [VideoContentController::class, 'show'])->name('video-contents.show');
    Route::get('/video-contents/{videoContent}/edit', [VideoContentController::class, 'edit'])->name('video-contents.edit');
    Route::put('/video-contents/{videoContent}', [VideoContentController::class, 'update'])->name('video-contents.update');
    Route::delete('/video-contents/{videoContent}', [VideoContentController::class, 'destroy'])->name('video-contents.destroy');
    
    // Account Management
    Route::get('/account', [TutorController::class, 'account'])->name('account');
    Route::get('/account/edit', [TutorController::class, 'accountEdit'])->name('account.edit');
    Route::put('/account', [TutorController::class, 'accountUpdate'])->name('account.update');
    Route::put('/account/password', [TutorController::class, 'accountPasswordUpdate'])->name('account.password.update');


});