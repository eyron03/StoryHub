<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Children;
use App\Models\Flipbook;
use App\Models\GradeLevel;
use App\Models\Parents;
use App\Models\Quiz;
use App\Models\Teachers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        $today = now()->toDateString();
        $teachersCount = Teachers::count();
        $parentsCount = Parents::count();
        $childrenCount = Children::count();
        $booksCount = Flipbook::count();

        return view('dashboard', compact('today', 'teachersCount', 'parentsCount', 'childrenCount', 'booksCount'));
    }
    public function showRegister()
    {
        return view('admin.register');
    }
    public function test()
    {
        return view('admin.test');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:admins|max:255',
            'usertype' => 'required',
            'password' => 'required|string|min:1|confirmed',


        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $Admin =  Admin::create($validatedData);

        return redirect()->back()->with('success', 'Admin registered successfully!');
    }
    public function parentDashboard(Request $request, $id = null) // Optional ID parameter
    {
        $today = now()->toDateString();
        $search = $request->input('search'); // Get the search term

        // Build the query to fetch parents with search functionality
        $query = Parents::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pFname', 'LIKE', "%{$search}%")
                    ->orWhere('pLname', 'LIKE', "%{$search}%");
            });
        }

        $parents = $query->paginate(5)->appends(['search' => $search]); // Preserve search term in pagination

        // If an ID is provided, fetch the specific parent
        $parent = $id ? Parents::find($id) : null;

        return view('admin.parentDashboard', [
            'parents' => $parents,
            'parent' => $parent, // Pass the specific parent if found
            'today' => $today,
            'search' => $search // Pass search term to the view
        ]);
    }
    public function viewParent($id)
    {
        // Fetch the parent by ID and include the related children
        $parent = Parents::with('children')->findOrFail($id);
        // Prepare the response data
        $response = [
            'pFname' => $parent->pFname,
            'pLname' => $parent->pLname,
            'pAge' => $parent->pAge,
            'pDob' => $parent->pDob,
            'pAddress' => $parent->pAddress,
            'pGender' => $parent->pGender,
            'email' => $parent->email,
            'childrenNames' => $parent->children->pluck('childFirstName')->toArray() // Collect children names
        ];
        return response()->json($response);
    }

    public function editParent($id)
    {
        $parent = Parents::findOrFail($id);
        return response()->json($parent);
    }

    public function updateParent(Request $request, $id)
    {
        // Fetch the parent record by ID
        $parent = Parents::findOrFail($id);

        $request->validate([
            'pFname' => 'required|string|max:255',
            'pLname' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $parent->id, // Allow the current user to keep their existing email
            'pDob' => 'required|date', // Ensure date of birth is valid
            'pGender' => 'required|string|in:Male,Female', // Gender validation
        ]);

        // Calculate the age based on the provided date of birth (pDob)
        $dob = new \DateTime($request->input('pDob'));
        $today = new \DateTime('today');
        $age = $dob->diff($today)->y; // Get the difference in years

        // Update the parent record with the computed age
        $parent->update([
            'pFname' => $request->input('pFname'),
            'pLname' => $request->input('pLname'),
            'email' => $request->input('email'),
            'pDob' => $request->input('pDob'),
            'pGender' => $request->input('pGender'),
            'pAge' => $age, // Store the computed age in the database if needed
        ]);

        // Redirect back to the parent's list or dashboard with a success message
        return redirect()->route('admin.parentDashboard', compact('parent'))->with('success', 'Parent details updated successfully');
    }


    public function destroyParent($id)
    {
        $parent = Parents::findOrFail($id);
        $parent->delete();
        return response()->json(['message' => 'Parent deleted successfully']);
    }
    public function childrenDashboard(Request $request)
    {
        $today = now()->toDateString();
        $search = $request->input('search'); // Get the search term

        // Build the query to fetch children with search functionality
        $query = DB::table('childrens')
            ->select(
                'childrens.id',
                'childrens.custom_id',
                'childrens.childFirstName',
                'childrens.childLastName',
                'childrens.childAge',
                'childrens.childDob',
                'childrens.childAddress',
                'childrens.childGender',
                'parents.pFname as parent_fname',
                'grade_levels.GradeLvl as grade_level',
                'teachers.TeacherFirstName as teacher_first_name',
                'teachers.TeacherLastName as teacher_last_name'
            )
            ->leftJoin('parents', 'childrens.parent_id', '=', 'parents.id')
            ->leftJoin('children_classes', 'childrens.id', '=', 'children_classes.child_id')
            ->leftJoin('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->leftJoin('teachers', 'grade_levels.teacher_id', '=', 'teachers.id')
            ->whereNotNull('grade_levels.GradeLvl');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('custom_id', 'like', "%{$search}%")
                    ->orWhere('childFirstName', 'like', "%{$search}%")
                    ->orWhere('childLastName', 'like', "%{$search}%");
            });
        }

        $childrens = $query->paginate(5)->appends(['search' => $search]);

        return view('admin.childrenDashboard', compact('childrens', 'today', 'search'));
    }


    public function viewChild($id)
    {
        $children = Children::findOrFail($id);

        return response()->json($children);
    }
    public function editChild($id)
    {
        $children = Children::findOrFail($id);
        return response()->json($children);
    }

    public function updateChild(Request $request)
    {
        // Find the child by ID or fail if not found
        $child = Children::findOrFail($request->id);

        // Store the old values before updating
        $oldValues = $child->getAttributes();


        if ($request->has('childDob')) {

            $dob = Carbon::parse($request->input('childDob'));

            $age = $dob->diffInYears(Carbon::now());

            $age = round($age);

            $request->merge(['childAge' => $age]);
        }


        $child->update($request->except('id'));


        $updatedValues = $request->except('id');
        if (isset($updatedValues['childAge'])) {
            $updatedValues['childAge'] = intval(round($updatedValues['childAge']));
        }

        // Log the update operation
        Log::info('Child updated:', [
            'child_id' => $child->id,
            'old_values' => $oldValues,
            'updated_values' => $updatedValues,
        ]);


        return redirect()->back()->with('success', 'Updated successfully!');
    }
    public function destroyChildren($id)
    {
        $children = Children::findOrFail($id);
        $children->delete();
        return response()->json(['message' => 'Children deleted successfully']);
    }

    public function reports(Request $request)
    {
        $today = now()->toDateString();

        // Get the search input from the request
        $search = $request->input('search');

        // Build the query to fetch reports with search functionality
        $query = DB::table('quiz_results')
            ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
            ->join('parents', 'childrens.parent_id', '=', 'parents.id')
            ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
            ->leftJoin('children_classes', 'childrens.id', '=', 'children_classes.child_id')
            ->leftJoin('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->leftJoin('teachers', 'grade_levels.teacher_id', '=', 'teachers.id')
            ->select(
                'parents.pFname as parentName',
                'childrens.childFirstName',
                'flipbooks.book_name',
                'quiz_results.total_score',
                'grade_levels.GradeLvl as gradeLevel',
                'teachers.TeacherFirstName as teacherName',
                'teachers.TeacherLastName as teacherLastName',
                'quiz_results.date_taken'
            )
            ->orderBy('quiz_results.date_taken', 'desc');

        // Apply search filters if search term is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('childrens.childFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('parents.pFname', 'LIKE', "%{$search}%")
                    ->orWhere('flipbooks.book_name', 'LIKE', "%{$search}%")
                    ->orWhere('teachers.TeacherFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('teachers.TeacherLastName', 'LIKE', "%{$search}%");
            });
        }

        $reports = $query->paginate(5); // Paginate the results with 5 items per page

        // Retrieve all children
        $children = Children::all();

        // Pass children and reports to the view
        return view('admin.reportsAdmin', [
            'reports' => $reports,
            'children' => $children,
            'today' => $today,
            'search' => $search // Pass search term to the view
        ]);
    }
    public function progress(Request $request)
    {
        $today = now()->toDateString();
        $search = $request->input('search'); // Get the search term

        // Build the query to fetch child progress with search functionality
        $query = DB::table('quiz_results')
            ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
            ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
            ->join('parents', 'childrens.parent_id', '=', 'parents.id')
            ->leftJoin('children_classes', 'childrens.id', '=', 'children_classes.child_id')
            ->leftJoin('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->leftJoin('teachers', 'grade_levels.teacher_id', '=', 'teachers.id')
            ->select(
                'parents.pFname as parent_name',
                'childrens.childFirstName as child_name',
                'flipbooks.book_name',
                DB::raw('MAX(quiz_results.total_score * 10) as progress'), // highest score
                DB::raw('MAX(quiz_results.date_taken) as date_taken'),
                'grade_levels.GradeLvl as grade_level',
                'teachers.TeacherFirstName',
                'teachers.TeacherLastName'
            )
            ->groupBy('parents.pFname', 'childrens.childFirstName', 'flipbooks.book_name', 'grade_levels.GradeLvl', 'teachers.TeacherFirstName', 'teachers.TeacherLastName')
            ->orderBy('date_taken', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('parents.pFname', 'LIKE', "%{$search}%")
                    ->orWhere('childrens.childFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('flipbooks.book_name', 'LIKE', "%{$search}%")
                    ->orWhere('grade_levels.GradeLvl', 'LIKE', "%{$search}%")
                    ->orWhere('teachers.TeacherFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('teachers.TeacherLastName', 'LIKE', "%{$search}%");
            });
        }

        $allChildrenProgress = $query->paginate(5); // Preserve search term in pagination

        return view('admin.progressAdmin', [
            'allChildrenProgress' => $allChildrenProgress,
            'today' => $today,
            'search' => $search // Pass search term to the view
        ]);
    }

    public function teachersDashboard(Request $request)
    {

        $search = $request->input('search');


        $query = Teachers::with('gradeLevel');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('TeacherFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('TeacherLastName', 'LIKE', "%{$search}%");
            });
        }

        $teachers = $query->paginate(5);
        $today = now()->toDateString();

        // Pass the data to the view
        return view('admin.teachersDashboard', [
            'teachers' => $teachers,
            'today' => $today,
            'search' => $search, // Pass search term to the view
        ]);
    }



    public function storeTeacher(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'TeacherFirstName' => 'required|string|max:255',
            'TeacherLastName' => 'required|string|max:255',
            'TeacherDob' => 'required|date',
            'TeacherAddress' => 'required|string|max:255',
            'TeacherGender' => 'required|string|in:Male,Female,Other',
            'usertype' => 'required|string|in:teacher',
            'email' => 'required|string|email|max:255|unique:teachers',
            'password' => 'required|string|min:1|confirmed',
            'GradeLvl' => 'required|string|max:255'
        ]);


        $dob = Carbon::parse($validatedData['TeacherDob']);
        $age = $dob->age;

        // Create a new teacher instance
        $teacher = new Teachers([
            'TeacherFirstName' => $validatedData['TeacherFirstName'],
            'TeacherLastName' => $validatedData['TeacherLastName'],
            'TeacherAge' => $age, // Save the calculated age
            'TeacherDob' => $validatedData['TeacherDob'],
            'TeacherGender' => $validatedData['TeacherGender'],
            'usertype' => $validatedData['usertype'],
            'TeacherAddress' => $validatedData['TeacherAddress'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);

        // Save the teacher record
        $teacher->save();

        // Create and save the grade level record
        $gradeLevel = new GradeLevel([
            'teacher_id' => $teacher->id,
            'GradeLvl' => $validatedData['GradeLvl']
        ]);
        $gradeLevel->save();

        // Log the creation of the teacher and grade level
        Log::info('New teacher added:', [
            'teacher_id' => $teacher->id,
            'teacher' => [
                'TeacherFirstName' => $teacher->TeacherFirstName,
                'TeacherLastName' => $teacher->TeacherLastName,
                'TeacherAge' => $teacher->TeacherAge,
                'TeacherDob' => $teacher->TeacherDob,
                'TeacherAddress' => $teacher->TeacherAddress,
                'TeacherGender' => $teacher->TeacherGender,
                'email' => $teacher->email,
                'usertype' => $teacher->usertype
            ],
            'grade_level' => [
                'GradeLvl' => $gradeLevel->GradeLvl
            ]
        ]);

        // Flash success message and redirect
        session()->flash('success', 'Teacher added successfully!');
        return redirect()->route('admin.teacherDashboard')->with('success', 'Teacher added successfully.');
    }










    public function showTeacher($id)
    {
        // Fetch a single teacher record by ID including grade level
        $teacher = Teachers::with('gradeLevel')->findOrFail($id);
        return response()->json([
            'TeacherFirstName' => $teacher->TeacherFirstName,
            'TeacherLastName' => $teacher->TeacherLastName,
            'TeacherAge' => $teacher->TeacherAge,
            'TeacherDob' => $teacher->TeacherDob,
            'TeacherAddress' => $teacher->TeacherAddress,
            'TeacherGender' => $teacher->TeacherGender,
            'TeacherGradeLevel' => $teacher->gradeLevel ? $teacher->gradeLevel->GradeLvl : 'N/A',
            'TeacherGradeLevelId' => $teacher->gradeLevel ? $teacher->gradeLevel->id : null,
            'email' => $teacher->email
        ]);
    }

    public function updateTeacher(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'TeacherFirstName' => 'required|string|max:255',
            'TeacherLastName' => 'required|string|max:255',
            'TeacherDob' => 'required|date',
            'TeacherAddress' => 'required|string|max:255',
            'TeacherGender' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers,email,' . $id,
            'GradeLvl' => 'required|string|max:255', // Add validation for Grade Level
        ]);

        // Auto compute age from date of birth
        $teacherAge = Carbon::parse($request->TeacherDob)->age;

        // Find the teacher record by ID and update it
        $teacher = Teachers::findOrFail($id);
        $teacher->TeacherFirstName = $request->TeacherFirstName;
        $teacher->TeacherLastName = $request->TeacherLastName;
        $teacher->TeacherAge = $teacherAge; // Set computed age
        $teacher->TeacherDob = $request->TeacherDob;
        $teacher->TeacherAddress = $request->TeacherAddress;
        $teacher->TeacherGender = $request->TeacherGender;
        $teacher->email = $request->email;

        // Save the teacher record
        $teacher->save();

        // Update the grade level in the related table
        $teacher->gradeLevel()->updateOrCreate(
            ['teacher_id' => $teacher->id], // Assuming there's a `teacher_id` foreign key in the grade level table
            ['GradeLvl' => $request->GradeLvl] // Update the column name here
        );

        // Set success message
        session()->flash('success', 'Teacher updated successfully!');

        return redirect()->route('admin.teacherDashboard')->with('success', 'Teacher updated successfully.');
    }
    public function destroyTeacher($id)
    {
        // Find the teacher record by ID and delete it
        $teacher = Teachers::findOrFail($id);
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully']);
    }
    public function settings()
    {
        $admin = Auth::guard('admin')->user();
        $today = now()->toDateString();

        // If admin is not found, abort with unauthorized status
        if (!$admin) {
            abort(401, 'Unauthorized');
        }

        // Pass the current admin data to the view
        return view('admin.settings', ['admin' => $admin], ['today' => $today]);
    }

    public function changeEmail(Request $request)
    {
        $adminId = 1; // Replace with actual admin ID or fetch from session/request

        $admin = Admin::find($adminId);

        // If admin is not found, abort with unauthorized status
        if (!$admin) {
            abort(401, 'Unauthorized');
        }

        // Validate the new email
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . $adminId,
        ]);

        $admin->email = $request->input('email');
        $admin->save();

        return back()->with('success', 'Email updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $adminId = 1; // Replace with actual admin ID or fetch from session/request

        $admin = Admin::find($adminId);

        // If admin is not found, abort with unauthorized status
        if (!$admin) {
            abort(401, 'Unauthorized');
        }

        // Validate the new password
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:1|confirmed',
        ]);

        // Check if the current password matches
        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update the password
        $admin->password = bcrypt($request->input('new_password'));
        $admin->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function logReports()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];
        $today = now()->toDateString();

        if (File::exists($logFile)) {
            $logEntries = File::lines($logFile);

            foreach ($logEntries as $line) {
                // Match only logs with the specified levels
                if (preg_match('/^\[(.*?)\]\s(.*?)\.(INFO|WARNING|DEBUG|NOTICE|ALERT|CRITICAL|EMERGENCY):\s(.*)/', $line, $matches)) {
                    $logs[] = [
                        'timestamp' => $matches[1],
                        'environment' => $matches[2],
                        'level' => $matches[3],
                        'message' => $matches[4],
                    ];
                }
            }

            // Sort logs by timestamp in descending order
            usort($logs, function ($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });

            // Paginate the logs (e.g., 15 per page)
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 5;
            $currentLogs = array_slice($logs, ($currentPage - 1) * $perPage, $perPage);
            $logs = new LengthAwarePaginator($currentLogs, count($logs), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);
        }

        return view('admin.logsAdmin', ['logs' => $logs, 'today' => $today]);
    }




    public function Analytics(Request $request)
    {
        // Get data for each chart
        $quizTakenData = $this->getQuizTakenData($request->input('period', 'today'));
        $reportsData = $this->getReportsData($request->input('period', 'today'));
        $progressData = $this->getProgressData();

        if ($request->ajax()) {
            return response()->json([
                'quizTakenData' => $quizTakenData,
                'reportsData' => $reportsData,
                'progressData' => $progressData,
            ]);
        }

        return view('admin.analyticsAdmin', [
            'initialQuizTakenData' => $quizTakenData,
            'initialReportsData' => $reportsData,
            'initialProgressData' => $progressData,
        ]);
    }

    private function getQuizTakenData($period)
    {
        $query = DB::table('quiz_results')
            ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
            ->join('children_classes', 'childrens.id', '=', 'children_classes.child_id')
            ->join('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->select(
                'grade_levels.GradeLvl as gradeLevel',
                DB::raw('DATE(date_taken) as date'),
                DB::raw('COUNT(DISTINCT quiz_results.child_id) as childrenCount') // Count distinct children
            )
            ->groupBy('gradeLevel', DB::raw('DATE(date_taken)'))
            ->orderBy('date', 'asc');
    
        switch ($period) {
            case 'week':
                $query->whereBetween('date_taken', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('date_taken', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            default:
                $query->whereDate('date_taken', Carbon::now()->toDateString());
        }
    
        return $query->get();
    }
    
    private function getReportsData($period)
    {
        $query = DB::table('quiz_results')
            ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
            ->join('children_classes', 'childrens.id', '=', 'children_classes.child_id')
            ->join('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->select(
                'grade_levels.GradeLvl as gradeLevel',
                DB::raw('DATE(date_taken) as date'),
                DB::raw('SUM(quiz_results.total_score) as totalScore') // Sum the scores instead of counting
            )
            ->groupBy('gradeLevel', DB::raw('DATE(date_taken)'))
            ->orderBy('date', 'asc');
    
        switch ($period) {
            case 'week':
                $query->whereBetween('date_taken', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('date_taken', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            default:
                $query->whereDate('date_taken', Carbon::now()->toDateString());
        }
    
        return $query->get();
    }
    private function getProgressData()
{
    return DB::table('grade_levels')
        ->join('children_classes', 'grade_levels.id', '=', 'children_classes.class_id')
        ->join('childrens', 'children_classes.child_id', '=', 'childrens.id')
        ->join('quiz_results', 'childrens.id', '=', 'quiz_results.child_id')
        ->select('grade_levels.GradeLvl as gradeLevel', DB::raw('SUM(quiz_results.total_score) as totalScore')) // Assuming 'score' is the column for individual scores
        ->groupBy('grade_levels.GradeLvl')
        ->get();
}


    public function logout()
    {
        // Log out the admin user from the 'admin' guard
        session::flush();
        // Redirect to a desired route or page
        return redirect('/');
    }
}
