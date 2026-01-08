<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BootcampTaskController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\VideoContentController;
use App\Http\Controllers\ELearningController;
use Illuminate\Support\Facades\Schema;

// Halaman Auth (Login & Register dalam 1 file)
Route::get('/auth', function () {
    return view('auth');
})->name('login');

// Alias untuk backward compatibility
Route::get('/login', function () {
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
    Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [PagesController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [PagesController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/form_pendaftaran', [PagesController::class, 'formPendaftaran'])->name('form_pendaftaran');
    Route::get('/kelas', [PagesController::class, 'kelas'])->name('kelas');
    Route::get('/checkout/{id?}', [PagesController::class, 'checkout'])->name('checkout');
    Route::get('/checkout-test', function() { return view('pages.checkout_test'); })->name('checkout.test');
    
    // Public Certificate Verification
    Route::get('/certificate/verify/{code}', [CertificateController::class, 'verify'])->name('certificate.verify');
});

// Payment Routes (Midtrans)
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/create-transaction', [PaymentController::class, 'createTransaction'])->name('create');
    Route::post('/notification', [PaymentController::class, 'handleNotification'])->name('notification');
    Route::get('/finish', [PaymentController::class, 'paymentFinish'])->name('finish');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('success');
    Route::get('/failed', [PaymentController::class, 'paymentFailed'])->name('failed');
    Route::get('/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('status');
    Route::post('/sync/{orderId}', [PaymentController::class, 'syncStatus'])->name('sync');
    Route::post('/test-webhook', [PaymentController::class, 'testWebhook'])->name('test-webhook');
    Route::get('/test', [PaymentController::class, 'testMidtrans'])->name('test');
});

// Test routes (remove in production)
Route::get('/test-payment', function() {
    return view('test-payment');
});

Route::get('/test-midtrans', [PaymentController::class, 'testMidtrans']);
Route::post('/payment/test-webhook', [PaymentController::class, 'testWebhook']);

// Debug route for class update
Route::get('/debug-class-update/{id}', function($id) {
    $class = App\Models\Classes::findOrFail($id);
    $tutors = App\Models\User::where('role', 'tutor')->get();
    
    return response()->json([
        'class' => $class,
        'tutors_count' => $tutors->count(),
        'upload_dir_exists' => is_dir(public_path('storage/class_images')),
        'upload_dir_writable' => is_writable(public_path('storage/class_images')),
        'php_settings' => [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
        ]
    ]);
});

// Test route for class update without middleware
Route::post('/test-class-update/{id}', function(Illuminate\Http\Request $request, $id) {
    try {
        $class = App\Models\Classes::findOrFail($id);
        
        // Test update without image
        $updateData = [
            'title' => $request->title ?? 'Test Title',
            'description' => $request->description ?? 'Test Description',
            'tutor_id' => $request->tutor_id ?? 1,
            'price' => $request->price ?? 100000,
            'status' => $request->status ?? 'active',
            'category' => $request->category ?? 'Test Category',
        ];
        
        $class->update($updateData);
        
        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully',
            'updated_data' => $updateData,
            'class' => $class->fresh()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Test form route without CSRF
Route::any('/test-form-update/{id}', function(Illuminate\Http\Request $request, $id) {
    if ($request->isMethod('get')) {
        return view('test-form-update', ['id' => $id]);
    }
    
    // Handle POST/PUT
    try {
        $class = App\Models\Classes::findOrFail($id);
        
        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'tutor_id' => $request->tutor_id,
            'price' => $request->price,
            'status' => $request->status,
            'category' => $request->category,
        ];
        
        // Handle image if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $uploadPath = public_path('storage/class_images');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $filename = 'test_' . time() . '.' . $image->getClientOriginalExtension();
            
            if ($image->move($uploadPath, $filename)) {
                $updateData['image'] = 'storage/class_images/' . $filename;
            }
        }
        
        $class->update($updateData);
        
        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully via test route',
            'data' => $updateData
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
})->withoutMiddleware(['web', 'csrf']);

// Test routes for model debugging
Route::post('/test-model-fillable', function() {
    try {
        $class = new App\Models\Classes();
        $fillable = $class->getFillable();
        
        // Get database columns
        $columns = Schema::getColumnListing('classes');
        
        return response()->json([
            'success' => true,
            'fillable' => $fillable,
            'columns' => $columns,
            'match' => array_intersect($fillable, $columns)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
})->withoutMiddleware(['web', 'csrf']);

Route::post('/test-create-class', function(Illuminate\Http\Request $request) {
    try {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'tutor_id' => $request->tutor_id,
            'price' => $request->price,
            'status' => $request->status,
            'category' => $request->category,
            'enrolled' => 0
        ];
        
        $class = App\Models\Classes::create($data);
        
        return response()->json([
            'success' => true,
            'class' => $class,
            'data_sent' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
})->withoutMiddleware(['web', 'csrf']);

Route::post('/test-update-class/{id}', function(Illuminate\Http\Request $request, $id) {
    try {
        $class = App\Models\Classes::findOrFail($id);
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'tutor_id' => $request->tutor_id,
            'price' => $request->price,
            'status' => $request->status,
            'category' => $request->category
        ];
        
        $class->update($data);
        
        return response()->json([
            'success' => true,
            'class' => $class->fresh(),
            'data_sent' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
})->withoutMiddleware(['web', 'csrf']);

Route::get('/test-database-structure', function() {
    try {
        $columns = Schema::getColumnListing('classes');
        $sampleClass = App\Models\Classes::first();
        
        return response()->json([
            'columns' => $columns,
            'sample_class' => $sampleClass,
            'table_exists' => Schema::hasTable('classes')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
})->withoutMiddleware(['web', 'csrf']);

// Duplicate routes removed - using payment prefix group above

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
Route::prefix('member')->middleware(['auth', 'role:member','prevent-back'])->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/enrollments', [MemberController::class, 'enrollments'])->name('enrollments');
    Route::get('/grades', [MemberController::class, 'grades'])->name('grades');
    Route::get('/tasks', [TaskController::class, 'memberIndex'])->name('tasks.index');
    // Alias for backward compatibility
    Route::get('/tasks-alias', [TaskController::class, 'memberIndex'])->name('tasks');
    Route::get('/tasks/{task}', [TaskController::class, 'memberShow'])->name('tasks.show');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'memberSubmit'])->name('tasks.submit');
    
    // Bootcamp Tasks
    Route::get('/bootcamp-tasks', [BootcampTaskController::class, 'memberIndex'])->name('bootcamp-tasks');
    Route::get('/bootcamp-tasks/{bootcamp}', [BootcampTaskController::class, 'memberBootcampTasks'])->name('bootcamp-tasks.tasks');
    Route::get('/bootcamp-tasks/{bootcamp}/task/{task}', [BootcampTaskController::class, 'memberTaskDetail'])->name('bootcamp-tasks.task-detail');
    Route::post('/bootcamp-tasks/{bootcamp}/task/{task}/submit', [BootcampTaskController::class, 'memberSubmitTask'])->name('bootcamp-tasks.submit');
    
    // Certificates
    Route::get('/certificates', [CertificateController::class, 'memberIndex'])->name('certificates');
});

// E-Learning Routes for Members
Route::prefix('elearning')->middleware(['auth', 'role:member','prevent-back'])->name('elearning.')->group(function () {
    Route::get('/', [ELearningController::class, 'index'])->name('index');
    Route::get('/class/{classId}', [ELearningController::class, 'showClass'])->name('class');
    Route::get('/bootcamp/{bootcampId}', [ELearningController::class, 'showBootcamp'])->name('bootcamp');
    Route::get('/watch/{videoId}', [ELearningController::class, 'watchVideo'])->name('watch');
});

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin','prevent-back'])->name('admin.')->group(function () {
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
    
    // Tasks Management (Admin can view all tasks)
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    
    // Bootcamp Tasks Overview
    Route::get('/bootcamp-tasks', [BootcampTaskController::class, 'adminIndex'])->name('bootcamp-tasks');
    
    // Certificates Management
    Route::get('/certificates', [CertificateController::class, 'adminIndex'])->name('certificates');
    
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
    Route::get('/account', [AdminController:: class, 'account'])->name('account');
    Route::get('/account/edit', [AdminController::class, 'accountEdit'])->name('account.edit');
    Route::put('/account', [AdminController::class, 'accountUpdate'])->name('account.update');
    Route::put('/account/password', [AdminController::class, 'accountPasswordUpdate'])->name('account.password.update');
});

// Tutor
Route::prefix('tutor')->middleware(['auth', 'role:tutor','prevent-back'])->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    
    // Classes CRUD
    Route::get('/classes', [TutorController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [TutorController::class, 'classesCreate'])->name('classes.create');
    Route::post('/classes', [TutorController::class, 'classesStore'])->name('classes.store');
    Route::get('/classes/{id}/edit', [TutorController::class, 'classesEdit'])->name('classes.edit');
    Route::put('/classes/{id}', [TutorController::class, 'classesUpdate'])->name('classes.update');
    Route::delete('/classes/{id}', [TutorController::class, 'classesDestroy'])->name('classes.destroy');
    
    // Bootcamps CRUD
    Route::get('/bootcamps', [TutorController::class, 'bootcamps'])->name('bootcamps');
    Route::get('/bootcamps/create', [TutorController::class, 'bootcampsCreate'])->name('bootcamps.create');
    Route::post('/bootcamps', [TutorController::class, 'bootcampsStore'])->name('bootcamps.store');
    Route::get('/bootcamps/{id}/edit', [TutorController::class, 'bootcampsEdit'])->name('bootcamps.edit');
    Route::put('/bootcamps/{id}', [TutorController::class, 'bootcampsUpdate'])->name('bootcamps.update');
    Route::delete('/bootcamps/{id}', [TutorController::class, 'bootcampsDestroy'])->name('bootcamps.destroy');
    
    // Tasks Management (Tutor can manage own tasks)
    Route::get('/tasks', [TaskController::class, 'tutorIndex'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'tutorCreate'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'tutorStore'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'tutorShow'])->name('tasks.show');
    Route::get('/tasks/{task}/submissions', [TaskController::class, 'tutorSubmissions'])->name('tasks.submissions');
    Route::get('/tasks/submission/{submission}/review', [TaskController::class, 'tutorReviewSubmission'])->name('tasks.submission.review');
    Route::post('/tasks/submission/{submission}/review', [TaskController::class, 'tutorSubmitReview'])->name('tasks.submission.submit-review');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'tutorEdit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'tutorUpdate'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'tutorDestroy'])->name('tasks.destroy');
    Route::post('/submissions/{submission}/grade', [TaskController::class, 'tutorGrade'])->name('submissions.grade');
    Route::post('/submissions/{submission}/certificate', [CertificateController::class, 'issueTaskCertificate'])->name('submissions.certificate');
    
    // Bootcamp Task Reviews
    Route::get('/bootcamp-tasks', [BootcampTaskController::class, 'tutorIndex'])->name('bootcamp-tasks');
    Route::get('/bootcamp-tasks/{bootcamp}/submissions', [BootcampTaskController::class, 'tutorBootcampTasks'])->name('bootcamp-tasks.submissions');
    Route::get('/bootcamp-tasks/review/{submission}', [BootcampTaskController::class, 'tutorReviewSubmission'])->name('bootcamp-tasks.review');
    Route::post('/bootcamp-tasks/review/{submission}', [BootcampTaskController::class, 'tutorSubmitReview'])->name('bootcamp-tasks.submit-review');
    
    // Certificates Management
    Route::get('/certificates', [CertificateController::class, 'adminIndex'])->name('certificates');
    
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

// E-Learning Routes (Member Access)
Route::prefix('elearning')->name('elearning.')->group(function () {
    Route::get('/', [ELearningController::class, 'index'])->name('index');
    Route::get('/class/{classId}', [ELearningController::class, 'showClass'])->name('class');
    Route::get('/bootcamp/{bootcampId}', [ELearningController::class, 'showBootcamp'])->name('bootcamp');
    Route::get('/video/{videoId}', [ELearningController::class, 'watchVideo'])->name('video');
    
    // AJAX Routes for Progress Tracking
    Route::post('/progress/update', [ELearningController::class, 'updateProgress'])->name('progress.update');
    Route::post('/progress/complete', [ELearningController::class, 'markCompleted'])->name('progress.complete');
});