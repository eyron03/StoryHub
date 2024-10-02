<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Children;
use App\Models\Flipbook;
use App\Models\Parents;
use App\Models\Teachers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
    
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            Session::put('showLoginAlert', true);
            Session::put('admin', true);
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        } elseif (Auth::guard('parent')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = auth()->guard('parent')->user();
            $request->session()->put('logged_in_parent_name', $user->pFname);
            $request->session()->put('logged_in_parent_id', $user->id);
            $request->session()->regenerate();
            Session::put('showLoginAlert', true);
            return redirect()->route('parents.dashboard')->with('success', 'Login successfully!');
        } elseif (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = auth()->guard('teacher')->user();
            $request->session()->put('logged_in_teacher_name', $user->TeacherFirstName);
            $request->session()->put('logged_in_teacher_id', $user->id);
            $request->session()->regenerate();
            Session::put('showLoginAlert', true);
            return redirect()->route('teachers.dashboard')->with('success', 'Login successfully!');
        }
    
        session()->flash('loginError', 'These credentials do not match our records.');
    
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }
    
    public function Adashboard()
    {
        $today = now()->toDateString();
        $teachersCount = Teachers::count();
        $parentsCount = Parents::count();
        $childrenCount = Children::count();
        $booksCount = Flipbook::count();

        return view('admin.dashboard', compact('today', 'teachersCount', 'parentsCount', 'childrenCount', 'booksCount'));
        


    }
    public function Pdashboard(Request $request)
{
    $parentId = $request->session()->get('logged_in_parent_id');
    $today = now()->toDateString();
    // Retrieve the parent's information
    $parent = Parents::find($parentId);
    
    // Prepare the parent data
    $parents = $parent ? ['name' => $parent->pFname] : [];

    // Get the IDs of children belonging to this parent
    $childrenIds = Children::where('parent_id', $parentId)
        ->pluck('id');
    
    // Get the grade levels of these children
    $gradeLevels = DB::table('children_classes')
        ->join('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
        ->whereIn('children_classes.child_id', $childrenIds)
        ->pluck('grade_levels.id')
        ->unique();

    // Get the unique teacher IDs associated with these grade levels
    $teacherIds = DB::table('grade_levels')
        ->whereIn('id', $gradeLevels)
        ->pluck('teacher_id')
        ->unique();
    
    // Count the number of unique teachers
    $teachersCount = $teacherIds->count();
 
    // Count the number of children with grade levels
    $childrenCount = DB::table('children_classes')
        ->whereIn('child_id', $childrenIds)
        ->distinct('child_id')
        ->count('child_id');

    // Count the number of books
    $booksCount = Flipbook::count();
    $parentsCount = Parents::count();

    return view('parents.dashboard', compact('parents', 'parent', 'childrenCount', 'teachersCount', 'booksCount','today','parentsCount'));
}
public function logout(Request $request, $userType)
{
    switch ($userType) {
        case 'admin':
            Auth::guard('admin')->logout();
            break;

        case 'parent':
            Auth::guard('parent')->logout();
            break;

        case 'teacher':
            Auth::guard('teacher')->logout();
            break;

        default:
            return redirect('index')->withErrors('Invalid user type.');
    }

    // Invalidate the session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect to the login page or home
    return redirect('index')->with('success', 'Logged out successfully.');
}


    
    // public function MyKids(){
    //     return view('parents.kids');
    // }

}
