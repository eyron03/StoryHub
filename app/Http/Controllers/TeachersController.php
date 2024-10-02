<?php

namespace App\Http\Controllers;

use App\Models\Teachers;

use App\Http\Requests\StoreTeachersRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTeachersRequest;
use App\Models\Children;
use App\Models\Flipbook;
use App\Models\GradeLevel;
use App\Models\Parents;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $teacherId = $request->session()->get('logged_in_teacher_id');
        $teacherName = $request->session()->get('logged_in_teacher_name');
        
        
        $teacher = Teachers::where('TeacherFirstName', $teacherName)
            ->where('id', $teacherId)
            ->first();
            $teachers = $teacher ? [$teacher->TeacherFirstName] : [];
        
       
        if (!$teacher) {
            return redirect()->route('teachers.dashboard')->with('error', 'Teacher not found.');
        }
    
        $today = now()->toDateString();
    
        $gradeLevel = GradeLevel::where('teacher_id', $teacherId)->first();
        
        if ($gradeLevel) {
            $gradeLevelId = $gradeLevel->id;
    
          
            $assignedChildrenCount = Children::whereHas('gradeLevel', function ($query) use ($gradeLevelId) {
                $query->where('grade_levels.id', $gradeLevelId);
            })->count();
    
           
            $parentsCount = Parents::whereHas('children', function ($query) use ($gradeLevelId) {
                $query->whereHas('gradeLevel', function ($query) use ($gradeLevelId) {
                    $query->where('grade_levels.id', $gradeLevelId);
                });
            })->count();
        } else {
            $assignedChildrenCount = 0;
            $parentsCount = 0;
        }
        
     
        $booksCount = Flipbook::count();
        $teachersCount = Teachers::count();
 
        return view('teachers.dashboard', [
            'teachers' => $teachers,
            'today' => $today,
            'assignedChildrenCount' => $assignedChildrenCount,
            'parentsCount' => $parentsCount,
            'booksCount' => $booksCount,
            'teachersCount' => $teachersCount,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function parent(Request $request)
    {
        $teacherId = $request->session()->get('logged_in_teacher_id');
        $today = now()->toDateString();
        
      
        $teacher = Teachers::where('id', $teacherId)->first();
        
      
        $teachers = $teacher ? [$teacher->TeacherFirstName] : [];
       
        if (!$teacher) {
            return redirect()->route('teachers.parents')->with('error', 'Teacher not found.');
        }
        
       
        $gradeLevel = GradeLevel::where('teacher_id', $teacher->id)->first();
        
        if (!$gradeLevel) {
            return redirect()->route('teachers.parents')->with('error', 'No grade level assigned to the teacher.');
        }
        
        $gradeLevelId = $gradeLevel->id;
        
      
        $assignedChildren = Children::whereHas('gradeLevel', function($query) use ($gradeLevelId) {
            $query->where('grade_levels.id', $gradeLevelId);
        })->get();
        
       
        $assignedChildrenIds = $assignedChildren->pluck('id');
        
       
        $search = $request->input('search');
        
        $query = Parents::whereHas('children', function($query) use ($assignedChildrenIds) {
            $query->whereIn('id', $assignedChildrenIds);
        });
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('pFname', 'LIKE', "%{$search}%")
                  ->orWhere('pLname', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }
        
        $parents = $query->paginate(5)->appends(['search' => $search]);
        
       
        $parents->map(function ($parent) use ($assignedChildren) {
            $parent->childrenNames = $assignedChildren->where('parent_id', $parent->id)->pluck('childFirstName');
            return $parent;
        });
        
        return view('teachers.parents', [
            'teachers' => $teachers,
            'teacherId' => $teacherId,
            'parents' => $parents,
            'today' => $today,
            'search' => $search 
        ]);
    }
    
public function updateParent(Request $request, $id)
{
    // Fetch the parent record by ID
    $parent = Parents::findOrFail($id);

    // Validate the request input fields
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
    return redirect()->route('teachers.parent')->with('success', 'Parent details updated successfully');
}
    
public function pupils(Request $request)
{
    $teacher = Teachers::where('TeacherFirstName', $request->session()->get('logged_in_teacher_name'))
        ->where('id', $request->session()->get('logged_in_teacher_id'))
        ->first();
    
    $teachers = $teacher ? [$teacher->TeacherFirstName] : [];
    $today = now()->toDateString();

  
    if (!$teacher) {
        return redirect()->route('teachers_pupils')->with('error', 'Teacher not found.');
    }

  
    $gradeLevel = GradeLevel::where('teacher_id', $teacher->id)->first();

    if (!$gradeLevel) {
        return redirect()->route('teachers.pupils')->with('error', 'No grade level assigned to the teacher.');
    }

    $gradeLevelId = $gradeLevel->id;


    $children = Children::whereDoesntHave('gradeLevel')->get();
    
    
    $search = $request->input('search');

    $query = Children::whereHas('gradeLevel', function($query) use ($gradeLevelId) {
        $query->where('grade_levels.id', $gradeLevelId);
    });

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('custom_id', 'like', "%{$search}%")
              ->orWhere('childFirstName', 'like', "%{$search}%")
              ->orWhere('childLastName', 'like', "%{$search}%");
        });
    }

    $assignedChildren = $query->paginate(5)->appends(['search' => $search]);

    return view('teachers.pupils', [
        'teachers' => $teachers,
        'children' => $children,
        'gradeLevelId' => $gradeLevelId,
        'assignedChildren' => $assignedChildren,
        'today' => $today,
        'search' => $search
    ]);
}


public function storePupil(Request $request)
{
    
    $validated = $request->validate([
        'childCustomId' => 'required|exists:childrens,custom_id',
    ]);

  
    $child = Children::where('custom_id', $validated['childCustomId'])->first();

    $teacherId = $request->session()->get('logged_in_teacher_id');

    $gradeLevel = GradeLevel::where('teacher_id', $teacherId)->first();
    $gradeLevelName = $gradeLevel ? $gradeLevel->GradeLvl : 'Unknown';

    
    $teacher = Teachers::find($teacherId);
    $teacherName = $teacher ? $teacher->TeacherFirstName . ' ' . $teacher->TeacherLastName : 'Unknown';

    
    DB::table('children_classes')->insert([
        'child_id' => $child->id,
        'class_id' => $gradeLevel ? $gradeLevel->id : null,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    
    Log::info('Pupil added to class:', [
        'child_custom_id' => $child->custom_id,
        'grade_level' => $gradeLevelName,
        'teacher_name' => $teacherName,
        'timestamp' => now()->toDateTimeString()
    ]);

    return redirect()->route('teachers.pupils')->with('success', 'Child added successfully.');
}

    
    public function editPupil($id)
    {
        $child = Children::findOrFail($id);
        return response()->json($child);
    }
    public function updatePupil(Request $request)
    {
        $validatedData = $request->validate([
            'childId' => 'required|integer|exists:childrens,id',
            'childFirstName' => 'required|string|max:255',
            'childLastName' => 'required|string|max:255',
            'childDob' => 'required|date',
            'childAddress' => 'required|string|max:255',
            'childGender' => 'required|string|in:male,female',
        ]);
    
        // Calculate the age based on the child's date of birth
        $dob = new \DateTime($validatedData['childDob']);
        $today = new \DateTime('today');
        $age = $dob->diff($today)->y; // Calculate age in years
    
        // Find the child by ID
        $child = Children::findOrFail($validatedData['childId']);
        $child->childFirstName = $validatedData['childFirstName'];
        $child->childLastName = $validatedData['childLastName'];
        $child->childAge = $age; // Set the computed age
        $child->childDob = $validatedData['childDob'];
        $child->childAddress = $validatedData['childAddress'];
        $child->childGender = $validatedData['childGender'];
        $child->save();
    
        return response()->json(['success' => true]);
    }
    
    // public function destroy($id)
    // {
    //     // Find the parent by its ID and delete it
    //     Parent::findOrFail($id)->delete();

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Parent deleted successfully!');
    // }
    public function books(Request $request)
{
    $today = now()->toDateString();
    $teacher = Teachers::where('TeacherFirstName', $request->session()->get('logged_in_teacher_name'))
        ->where('id', $request->session()->get('logged_in_teacher_id'))
        ->first();
    
    $teachers = $teacher ? [$teacher->TeacherFirstName] : [];
    
    
    $search = $request->input('search');

    
    $query = Flipbook::query();

    if ($search) {
        $query->where('book_name', 'LIKE', "%{$search}%");
    }

    $flipbooks = $query->paginate(12)->appends(['search' => $search]);

    return view('teachers.books', [
        'flipbooks' => $flipbooks,
        'teachers' => $teachers,
        'today' => $today,
        'search' => $search
    ]);
}

    
public function reports(Request $request)
{
    $logged_in_teacher_id = $request->session()->get('logged_in_teacher_id');
    $logged_in_teacher_name = $request->session()->get('logged_in_teacher_name');
    $today = now()->toDateString();

    $teacher = Teachers::where('TeacherFirstName', $logged_in_teacher_name)
                        ->where('id', $logged_in_teacher_id)
                        ->first();

    $teachers = $teacher ? [$teacher->TeacherFirstName] : [];

    $children = Children::all();

    $search = $request->input('search');

    // Query the historical data from quiz_results
    $query = DB::table('quiz_results')
        ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
        ->join('parents', 'childrens.parent_id', '=', 'parents.id')
        ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
        ->leftJoin('grade_levels', 'quiz_results.grade_level_id', '=', 'grade_levels.id') // Use stored grade_level_id
        ->leftJoin('teachers', 'quiz_results.teacher_id', '=', 'teachers.id') // Use stored teacher_id
        ->select(
            'parents.pFname as parentName',
            'childrens.childFirstName',
            'flipbooks.book_name',
            'quiz_results.total_score',
            DB::raw('COALESCE(grade_levels.GradeLvl, "N/A") as gradeLevel'), // Historical grade level, if available
            DB::raw('COALESCE(teachers.TeacherFirstName, "N/A") as teacherName'), // Historical teacher, if available
            DB::raw('COALESCE(teachers.TeacherLastName, "N/A") as teacherLastName'),
            'quiz_results.date_taken'
        )
        ->where(function($query) use ($logged_in_teacher_id) {
            // Filter reports by logged-in teacher, including cases where the student might have been removed from the class
            $query->where('teachers.id', $logged_in_teacher_id)
                  ->orWhereNull('teachers.id'); // This ensures we capture results even if a student is no longer associated with a class
        })
        ->orderBy('quiz_results.date_taken', 'desc');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('childrens.childFirstName', 'LIKE', "%{$search}%")
              ->orWhere('parents.pFname', 'LIKE', "%{$search}%")
              ->orWhere('flipbooks.book_name', 'LIKE', "%{$search}%")
              ->orWhere('grade_levels.GradeLvl', 'LIKE', "%{$search}%");
        });
    }

    $reports = $query->paginate(5)->appends(['search' => $search]);

    return view('teachers.reports', compact('reports', 'children', 'teachers', 'today', 'search'));
}

    
public function showProgress(Request $request)
{
    $teacher = Teachers::where('TeacherFirstName', $request->session()->get('logged_in_teacher_name'))
        ->where('id', $request->session()->get('logged_in_teacher_id'))
        ->first();
    
    if (!$teacher) {
        return redirect()->route('teachers.progress')->with('error', 'Teacher not found.');
    }

    $today = now()->toDateString();
    $gradeLevels = GradeLevel::where('teacher_id', $teacher->id)->pluck('id');

    $search = $request->input('search');

    // Query to fetch children's progress without filtering out removed children
    $childrenProgressQuery = DB::table('quiz_results')
        ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
        ->join('parents', 'childrens.parent_id', '=', 'parents.id')
        ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
        ->leftJoin('grade_levels', 'quiz_results.grade_level_id', '=', 'grade_levels.id') // Use stored grade_level_id
        ->leftJoin('teachers', 'quiz_results.teacher_id', '=', 'teachers.id') // Use stored teacher_id
        ->select(
            'childrens.childFirstName as child_name',
            'grade_levels.GradeLvl as grade_level',
            'flipbooks.book_name',
            DB::raw('MAX(quiz_results.total_score * 10) as progress'),
            DB::raw('MAX(quiz_results.date_taken) as date_taken')
        )
        ->whereIn('quiz_results.teacher_id', [$teacher->id]) // Ensure we only get records for this teacher
        ->groupBy('childrens.childFirstName', 'grade_levels.GradeLvl', 'flipbooks.book_name')
        ->orderBy('date_taken', 'desc');

    // Search functionality
    if ($search) {
        $childrenProgressQuery->where(function($q) use ($search) {
            $q->where('childrens.childFirstName', 'LIKE', "%{$search}%")
              ->orWhere('grade_levels.GradeLvl', 'LIKE', "%{$search}%")
              ->orWhere('flipbooks.book_name', 'LIKE', "%{$search}%");
        });
    }

    $childrenProgress = $childrenProgressQuery->paginate(5)->appends(['search' => $search]);

    return view('teachers.progress', [
        'teachers' => [$teacher->TeacherFirstName],
        'assignedChildren' => $childrenProgress, // This remains if you need it for other purposes
        'childrenProgress' => $childrenProgress,
        'today' => $today,
        'search' => $search,
    ]);
}



public function showbook(Request $request,$id)
{
    $teacher = Teachers::where('TeacherFirstName', $request->session()->get('logged_in_teacher_name'))
    ->where('id', $request->session()->get('logged_in_teacher_id'))
    ->first();

$teachers = $teacher ? [$teacher->TeacherFirstName] : [];
    $flipbooks = Flipbook::with('quizzes')->findOrFail($id);
    $images = explode(",", $flipbooks->images);

    
    return view('teachers.showbook', compact('flipbooks', 'images','teachers'));
}
public function showquiz($id) {
    $quizQuestions = Quiz::where('flipbook_id', $id)->get();

    return view('teachers.showquiz', compact('quizQuestions'));
}

public function settings(Request $request)
{
    $teacherId = $request->session()->get('logged_in_teacher_id');
    $today = now()->toDateString();
 
    $teacher = Teachers::find($teacherId);
    
  
    $teachers = $teacher ? [$teacher->TeacherFirstName] : [];
    
    return view('teachers.settings', ['teachers' => $teachers, 'teacher' => $teacher],['today'=>$today]);
}
public function updateInfo(Request $request)
{

    $validatedData = $request->validate([
        'TeacherFirstName' => 'required|string|max:255',
        'TeacherLastName' => 'required|string|max:255',
        'TeacherAge' => 'required|integer|min:0',
        'TeacherDob' => 'required|date',
        'TeacherAddress' => 'required|string|max:255',
        'TeacherGender' => 'required|string|in:Male,Female,Other',
        'email' => 'required|string|email|max:255|unique:teachers,email,' . $request->session()->get('logged_in_teacher_id'),
    ]);
    
    $teacherId = $request->session()->get('logged_in_teacher_id');


    $teacher = Teachers::find($teacherId);

    if (!$teacher) {
        return redirect()->route('teacher.settings')->with('error', 'Teacher not found.');
    }
    

    $oldValues = $teacher->getAttributes();
    

    $teacher->TeacherFirstName = $validatedData['TeacherFirstName'];
    $teacher->TeacherLastName = $validatedData['TeacherLastName'];
    $teacher->TeacherAge = $validatedData['TeacherAge'];
    $teacher->TeacherDob = $validatedData['TeacherDob'];
    $teacher->TeacherAddress = $validatedData['TeacherAddress'];
    $teacher->TeacherGender = $validatedData['TeacherGender'];
    $teacher->email = $validatedData['email'];
    $teacher->save();
    

    Log::info('Teacher information updated:', [
        'teacher_id' => $teacher->id,
        'old_values' => $oldValues,
        'updated_values' => $validatedData,
    ]);
   
    $request->session()->put('logged_in_teacher_name', $teacher->TeacherFirstName);
    
    
    return redirect()->route('teacher.settings')->with('success', 'Personal information updated successfully.');
}


public function changePassword(Request $request)
{
   
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);
    
   
    $teacher = Teachers::find($request->session()->get('logged_in_teacher_id'));
    if ($teacher && Hash::check($request->current_password, $teacher->password)) {
    
        $teacher->password = Hash::make($request->new_password);
        $teacher->save();
        
        return redirect()->route('teacher.settings')->with('success', 'Password updated successfully!');
    }
    
    return redirect()->route('teacher.settings')->with('error', 'Current password is incorrect!');
}
public function removeFromGradeLevel($id)
{
    try {
      
        $child = Children::findOrFail($id);
        
    
        $gradeLevels = $child->gradeLevel->pluck('GradeLvl')->toArray();
        
       
        $child->gradeLevel()->detach();

        
        Log::info('Child removed from grade level:', [
            'ID' => $child->custom_id,
            'Pupil Name' => $child->childFirstName . ' ' . $child->childLastName,
            'Grade' => $gradeLevels,
        ]);

        
        return response()->json(['message' => 'Child removed from grade level successfully.']);
    } catch (\Exception $e) {
       
        Log::error('Error removing child from grade level:', [
            'child_id' => $id,
            'error' => $e->getMessage(),
        ]);

       
        return response()->json(['error' => 'An error occurred while removing the child from the grade level.'], 500);
    }
}

public function removeAllFromGradeLevels()
{
    try {
        // Get all children
        $children = Children::with('gradeLevel')->get(); // Load children with their associated grade levels
        
        foreach ($children as $child) {
            $gradeLevels = $child->gradeLevel->pluck('GradeLvl')->toArray();
            
            // Detach the child from their grade levels
            $child->gradeLevel()->detach();

            // Log the action for each child
            Log::info('Child removed from grade level:', [
                'ID' => $child->id, // Use the appropriate ID field here
                'Pupil Name' => $child->childFirstName . ' ' . $child->childLastName,
                'Grade' => $gradeLevels,
            ]);
        }

        return redirect()->back()->with('success', 'All children have been removed from their grade levels successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while removing children from their grade levels.');
    }
}

    public function logout()
{
    Auth::guard('teacher')->logout();  


    session()->flush();

    return redirect('index');  
}

}
