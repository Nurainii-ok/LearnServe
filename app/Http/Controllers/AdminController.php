<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get dashboard statistics
        $totalMembers = User::where('role', 'member')->count();
        $totalTutors = User::where('role', 'tutor')->count();
        $totalClasses = Classes::count();
        $totalBootcamps = Bootcamp::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        
        // Get enrollment statistics
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $classEnrollments = Enrollment::where('type', 'class')->count();
        $bootcampEnrollments = Enrollment::where('type', 'bootcamp')->count();
        
        // Get recent enrollments
        $recentEnrollments = Enrollment::with(['user', 'class', 'bootcamp'])
            ->latest()
            ->take(10)
            ->get();
        
        // Get recent members
        $recentMembers = User::where('role', 'member')
            ->latest()
            ->take(5)
            ->get();
            
        // Get recent tutors
        $recentTutors = User::where('role', 'tutor')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalMembers', 
            'totalTutors', 
            'totalClasses', 
            'totalBootcamps',
            'totalRevenue',
            'totalEnrollments',
            'activeEnrollments',
            'classEnrollments',
            'bootcampEnrollments',
            'recentEnrollments',
            'recentMembers', 
            'recentTutors'
        ));
    }

    // Members CRUD
    public function members()
    {
        $members = User::where('role', 'member')->latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function membersCreate()
    {
        return view('admin.members.create');
    }

    public function membersStore(Request $request)
    {
        // Debug logging
        Log::info('Member store method called', [
            'request_data' => $request->all(),
            'session_data' => [
                'user_id' => session('user_id'),
                'role' => session('role'),
                'username' => session('username')
            ]
        ]);
        
        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:4',
            ]);

            $member = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);
            
            Log::info('Member created successfully', ['member_id' => $member->id]);

            return redirect()->route('admin.members')->with('success', 'Member created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in membersStore', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception in membersStore', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'An error occurred while creating the member: ' . $e->getMessage());
        }
    }

    public function membersEdit($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    public function membersUpdate(Request $request, $id)
    {
        $member = User::where('role', 'member')->findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($member->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($member->id)],
            'password' => 'nullable|string|min:4',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.members')->with('success', 'Member updated successfully!');
    }

    public function membersDestroy($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);
        $member->delete();

        return redirect()->route('admin.members')->with('success', 'Member deleted successfully!');
    }

    // Tutors CRUD
    public function tutors()
    {
        $tutors = User::where('role', 'tutor')->latest()->paginate(10);
        return view('admin.tutors.index', compact('tutors'));
    }

    public function tutorsCreate()
    {
        return view('admin.tutors.create');
    }

    public function tutorsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tutor',
        ]);

        return redirect()->route('admin.tutors')->with('success', 'Tutor created successfully!');
    }

    public function tutorsEdit($id)
    {
        $tutor = User::where('role', 'tutor')->findOrFail($id);
        return view('admin.tutors.edit', compact('tutor'));
    }

    public function tutorsUpdate(Request $request, $id)
    {
        $tutor = User::where('role', 'tutor')->findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($tutor->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($tutor->id)],
            'password' => 'nullable|string|min:4',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $tutor->update($data);

        return redirect()->route('admin.tutors')->with('success', 'Tutor updated successfully!');
    }

    public function tutorsDestroy($id)
    {
        $tutor = User::where('role', 'tutor')->findOrFail($id);
        $tutor->delete();

        return redirect()->route('admin.tutors')->with('success', 'Tutor deleted successfully!');
    }

    // Classes CRUD
    public function classes()
    {
        $classes = Classes::with('tutor')->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function classesCreate()
    {
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.classes.create', compact('tutors'));
    }

    public function classesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tutor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/class_images'), $imageName);
            $data['image'] = 'storage/class_images/' . $imageName;
        }

        Classes::create($data);

        return redirect()->route('admin.classes')->with('success', 'Class created successfully!');
    }

    public function classesEdit($id)
    {
        $class = Classes::findOrFail($id);
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.classes.edit', compact('class', 'tutors'));
    }

    public function classesUpdate(Request $request, $id)
    {
        $class = Classes::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tutor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($class->image && file_exists(public_path($class->image))) {
                unlink(public_path($class->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/class_images'), $imageName);
            $data['image'] = 'storage/class_images/' . $imageName;
        }

        $class->update($data);

        return redirect()->route('admin.classes')->with('success', 'Class updated successfully!');
    }

    public function classesDestroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes')->with('success', 'Class deleted successfully!');
    }

    // Bootcamps CRUD
    public function bootcamps()
    {
        $bootcamps = Bootcamp::with('tutor')->latest()->paginate(10);
        return view('admin.bootcamps.index', compact('bootcamps'));
    }

    public function bootcampsCreate()
    {
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.bootcamps.create', compact('tutors'));
    }

    public function bootcampsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tutor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'category' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'requirements' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/bootcamp_images'), $imageName);
            $data['image'] = 'storage/bootcamp_images/' . $imageName;
        }

        Bootcamp::create($data);

        return redirect()->route('admin.bootcamps')->with('success', 'Bootcamp created successfully!');
    }

    public function bootcampsEdit($id)
    {
        $bootcamp = Bootcamp::findOrFail($id);
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.bootcamps.edit', compact('bootcamp', 'tutors'));
    }

    public function bootcampsUpdate(Request $request, $id)
    {
        $bootcamp = Bootcamp::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tutor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'category' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'requirements' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bootcamp->image && file_exists(public_path($bootcamp->image))) {
                unlink(public_path($bootcamp->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/bootcamp_images'), $imageName);
            $data['image'] = 'storage/bootcamp_images/' . $imageName;
        }

        $bootcamp->update($data);

        return redirect()->route('admin.bootcamps')->with('success', 'Bootcamp updated successfully!');
    }

    public function bootcampsDestroy($id)
    {
        $bootcamp = Bootcamp::findOrFail($id);
        $bootcamp->delete();

        return redirect()->route('admin.bootcamps')->with('success', 'Bootcamp deleted successfully!');
    }

    // Payments CRUD
    public function payments()
    {
        $payments = Payment::with(['user', 'class.tutor', 'bootcamp.tutor'])->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    // Payment creation is handled automatically by Midtrans webhook
    // No manual payment creation needed

    public function paymentsStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create(array_merge($request->all(), [
            'status' => 'completed',
            'payment_date' => now(),
        ]));

        return redirect()->route('admin.payments')->with('success', 'Payment created successfully!');
    }

    public function paymentsEdit($id)
    {
        $payment = Payment::findOrFail($id);
        $members = User::where('role', 'member')->get();
        $classes = Classes::active()->get();
        return view('admin.payments.edit', compact('payment', 'members', 'classes'));
    }

    public function paymentsUpdate(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $payment->update($request->except(['transaction_id']));

        return redirect()->route('admin.payments')->with('success', 'Payment updated successfully!');
    }

    public function paymentsDestroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments')->with('success', 'Payment deleted successfully!');
    }

    // Tasks CRUD
    public function tasks()
    {
        $tasks = Task::with(['class', 'assignedBy'])->latest()->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function tasksCreate()
    {
        $classes = Classes::active()->get();
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.tasks.create', compact('classes', 'tutors'));
    }

    public function tasksStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'assigned_by' => 'required|exists:users,id',
            'due_date' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high',
            'instructions' => 'nullable|string',
        ]);

        Task::create($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully!');
    }

    public function tasksEdit($id)
    {
        $task = Task::findOrFail($id);
        $classes = Classes::active()->get();
        $tutors = User::where('role', 'tutor')->get();
        return view('admin.tasks.edit', compact('task', 'classes', 'tutors'));
    }

    public function tasksUpdate(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'assigned_by' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,overdue',
            'instructions' => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task updated successfully!');
    }

    public function tasksDestroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully!');
    }

    public function account()
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            Log::error('AdminController@account: No user_id in session');
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get admin user from database
        $admin = User::find($userId);
        
        if (!$admin || $admin->role !== 'admin') {
            Log::error('AdminController@account: User not found or not admin', ['user_id' => $userId]);
            return redirect()->route('auth')->with('error', 'Access denied. Admin privileges required.');
        }
        
        return view('admin.account', compact('admin'));
    }

    public function accountEdit()
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get admin user from database
        $admin = User::find($userId);
        
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->route('auth')->with('error', 'Access denied. Admin privileges required.');
        }
        
        return view('admin.account-edit', compact('admin'));
    }

    public function accountUpdate(Request $request)
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        $admin = User::find($userId);
        
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->route('auth')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($admin->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($admin->id)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($admin->profile_photo && file_exists(public_path('storage/profile_photos/' . $admin->profile_photo))) {
                unlink(public_path('storage/profile_photos/' . $admin->profile_photo));
            }
            
            // Store new photo
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $admin->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/profile_photos'), $filename);
            $updateData['profile_photo'] = $filename;
        }

        $admin->update($updateData);
        
        // Update session data with new username
        session(['username' => $request->name]);

        return redirect()->route('admin.account')->with('success', 'Profile updated successfully!');
    }

    public function accountPasswordUpdate(Request $request)
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        $admin = User::find($userId);
        
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->route('auth')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.account')->with('success', 'Password updated successfully!');
    }

    public function createMember()
    {
        return view('admin.members-create'); // bisa juga bikin folder form tersendiri
    }
}
