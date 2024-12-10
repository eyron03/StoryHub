<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Flipbook;
use App\Models\Parents;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class ParentsController extends Controller
{
    //



    // public function showRegistrationForm()
    // {
    //     return view('parents.kids');
    // }

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'pFname' => 'required|string|max:255',
            'pLname' => 'required|string|max:255',
            'pDob' => 'required|date',
            'pAddress' => 'required|string|max:255',
            'pGender' => 'required|string|in:male,female,other',
            'usertype' => 'required|string|in:parent',
            'email' => 'required|email|unique:parents|max:255',
            'password' => 'required|string|min:1|confirmed',
        ]);


        $dob = Carbon::parse($validatedData['pDob']);
        $age = $dob->age;


        $validatedData['password'] = bcrypt($validatedData['password']);


        $parent = Parents::create([
            'pFname' => $validatedData['pFname'],
            'pLname' => $validatedData['pLname'],
            'pDob' => $validatedData['pDob'],
            'pAddress' => $validatedData['pAddress'],
            'pGender' => $validatedData['pGender'],
            'usertype' => $validatedData['usertype'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'pAge' => $age,
        ]);


        Log::info('New parent added:', [
            'parent_id' => $parent->id,
            'parent' => [
                'ParentName' => $parent->pFname,
                'ParentLastName' => $parent->pLname,
                'ParentAge' => $parent->pAge,
                'ParentDOB' => $parent->pDob,
                'ParentAddress' => $parent->pAddress,
                'ParentGender' => $parent->pGender,
                'email' => $parent->email,
                'usertype' => $parent->usertype,
            ]
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Parent registered successfully!');
    }


    // public function login(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => 'required'
    //     ]);

    //     // Attempt to authenticate the user
    //     if (auth()->attempt($validated)) {
    //         // Authentication successful, regenerate session
    //         $request->session()->regenerate();
    //         return view('parents.dashboard');
    //     }


    //     // Authentication failed, redirect back with an error message
    //     return back()->withErrors([
    //         'pEmail' => 'The provided credentials do not match our records.'
    //     ]);
    // }



public function MyKids(Request $request)
{
    $parentId = $request->session()->get('logged_in_parent_id');
    $today = now()->toDateString();

    $parent = Parents::find($parentId);


    $children = Children::where('parent_id', $parentId)->get();

    $gradeLevels = DB::table('grade_levels')
        ->select('grade_levels.id as grade_level_id', 'GradeLvl', 'children_classes.child_id as pivot_child_id', 'children_classes.class_id as pivot_class_id')
        ->join('children_classes', 'grade_levels.id', '=', 'children_classes.class_id')
        ->whereIn('children_classes.child_id', $children->pluck('id')) // Pluck the child IDs
        ->get();

    $parents = $parent ? ['name' => $parent->pFname] : [];


    return view('parents.kids', compact('parents', 'children', 'gradeLevels','today'));
}

public function storytime(Request $request)
{
    $parentId = $request->session()->get('logged_in_parent_id');
    $today = now()->toDateString();

    $parent = Parents::with(['children.gradeLevel'])->find($parentId);

    if (!$parent) {

        return redirect()->back()->withErrors(['error' => 'Parent not found.']);
    }


    $parents = [$parent->pFname];

    $children = $parent->children->filter(function ($child) {
        return $child->gradeLevel->isNotEmpty();
    });

    // Retrieve grade levels associated with the children
    $gradeLevels = DB::table('grade_levels')
        ->select('grade_levels.id as grade_level_id', 'GradeLvl', 'children_classes.child_id as pivot_child_id', 'children_classes.class_id as pivot_class_id')
        ->join('children_classes', 'grade_levels.id', '=', 'children_classes.class_id')
        ->whereIn('children_classes.child_id', $children->pluck('id')) // Pluck the child IDs
        ->get();


    return view('parents.storytime', compact('parents', 'children', 'gradeLevels','today'));
}
public function storybook(Request $request, $childId)
{
    $parentId = $request->session()->get('logged_in_parent_id');
    $parent = Parents::find($parentId);
    $child = $parent ? $parent->children()->find($childId) : null;

    $search = $request->input('search');

    $flipbooks = FlipBook::when($search, function ($query, $search) {
            return $query->where('book_name', 'like', '%' . $search . '%');
        })
        ->paginate(12);

    $childrenProgress = DB::table('quiz_results')
        ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
        ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
        ->leftJoin('grade_levels', 'quiz_results.grade_level_id', '=', 'grade_levels.id')
        ->where('childrens.parent_id', $parentId)
        ->where('quiz_results.child_id', $childId)
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('childrens.childFirstName', 'like', '%' . $search . '%')
                    ->orWhere('grade_levels.GradeLvl', 'like', '%' . $search . '%')
                    ->orWhere('flipbooks.book_name', 'like', '%' . $search . '%');
            });
        })
        ->select(
            'childrens.childFirstName as child_name',
            'childrens.id as child_id',
            DB::raw('COALESCE(grade_levels.GradeLvl, "N/A") as grade_level'),
            'flipbooks.book_name',
            'flipbooks.id as flipbook_id',
            'quiz_results.total_score',
            DB::raw('MAX(quiz_results.date_taken) as date_taken')
        )
        ->groupBy(
            'childrens.id',
            'childrens.childFirstName',
            'grade_levels.GradeLvl',
            'flipbooks.id',
            'flipbooks.book_name',
            'quiz_results.total_score'
        )
        ->get()
        ->map(function ($result) {
            // Get the total score for the child and flipbook
            $totalScore = DB::table('quiz_results')
                ->where('flipbook_id', $result->flipbook_id)
                ->where('child_id', $result->child_id)  // Use child_id here
                ->sum('total_score');

            // Calculate the perfect score (total questions)
            $totalQuestions = DB::table('quizzes')
                ->where('flipbook_id', $result->flipbook_id)
                ->count();

            $perfectScore = $totalQuestions;  // Assuming 1 point per question

            // Check the score for setting background color
            if ($totalScore == 10) {
                // Perfect score
                $result->bgColorClass = 'bg-success';  // Green for perfect score
            } elseif ($totalScore > 0 ) {
                // If the score is 4 or greater but less than perfect, treat 4 as 3
                $result->bgColorClass = 'bg-warning';  // Yellow for in-progress (4 treated as 3)
            } else {
                // Low or no score
                $result->bgColorClass = 'bg-light';  // White for no score or low score
            }

            return $result;
        });

    return view('parents.storybook', compact('flipbooks', 'child', 'childId', 'childrenProgress', 'search'));
}




public function bookshow(Request $request, $id,$child)
{

    // Retrieve the flipbook with the given ID and its associated quizzes
    $flipbook = Flipbook::with('quizzes')->find($id);
    $today = now()->toDateString();
    // Retrieve the parent ID from the session
    $parentId = $request->session()->get('logged_in_parent_id');

    // Retrieve the child associated with the parent and flipbook
    $childId=Children::find($child);
    $subtitles = explode(",", $flipbook->subtitles);
    // Extract images from the flipbook
    $images = explode(",", optional($flipbook)->images);
    $readingProgress = $request->session()->get('readingProgress');

    // Return the view with the flipbook, images, and child ID
    return view('parents.bookshow', compact('flipbook', 'images', 'childId','readingProgress','today','subtitles'));
}
public function bookshowAudio(Request $request, $id,$child)
{

    // Retrieve the flipbook with the given ID and its associated quizzes
    $flipbook = Flipbook::with('quizzes')->find($id);
    $today = now()->toDateString();
    // Retrieve the parent ID from the session
    $parentId = $request->session()->get('logged_in_parent_id');

    // Retrieve the child associated with the parent and flipbook
    $childId=Children::find($child);

    // Extract images from the flipbook
    $images = explode(",", optional($flipbook)->images);
    $readingProgress = $request->session()->get('readingProgress');

    // Return the view with the flipbook, images, and child ID
    return view('parents.bookshowAudio', compact('flipbook', 'images', 'childId','readingProgress','today'));
}
public function editChild($id)
{
    // Find the child by ID or fail if not found
    $child = Children::findOrFail($id);

    // Return the child data as JSON response
    return response()->json($child);
}


public function settings(Request $request)
{
    $parentId = $request->session()->get('logged_in_parent_id');
    $today = now()->toDateString();
        // Retrieve the parent's information
        $parent = Parents::find($parentId);
        $parents = $parent ? ['name' => $parent->pFname] : [];
    return view('parents.settings', [
        'parents' => $parents,
        'parent' => $parent,'today'=>$today,
    ]);
}
public function update(Request $request)
{
    // Validate the request data
    $request->validate([
        'pFname' => 'required|string|max:255',
        'pLname' => 'required|string|max:255',
        'pDob' => 'required|date',
        'pAddress' => 'required|string|max:255',
        'pGender' => 'required|in:male,female,other',
        'email' => 'required|string|email|max:255|unique:parents,email,' . $request->session()->get('logged_in_parent_id'),
    ]);

    $parentId = $request->session()->get('logged_in_parent_id');

    // Retrieve the parent
    $parent = Parents::find($parentId);

    if (!$parent) {
        return redirect()->route('parent.settings')->with('error', 'Parent not found.');
    }


    $oldValues = $parent->getAttributes();


    $pAge = Carbon::parse($request->pDob)->age;

    // Update parent information
    $parent->pFname = $request->pFname;
    $parent->pLname = $request->pLname;
    $parent->pAge = $pAge;
    $parent->pDob = $request->pDob;
    $parent->pAddress = $request->pAddress;
    $parent->pGender = $request->pGender;
    $parent->email = $request->email;
    $parent->save();


    Log::info('Parent information updated:', [
        'parent_id' => $parent->id,
        'old_values' => $oldValues,
        'updated_values' => [
            'ParentName' => $parent->pFname,
            'ParentLastName' => $parent->pLname,
            'ParentAge' => $parent->pAge,
            'ParentDOB' => $parent->pDob,
            'ParentAddress' => $parent->pAddress,
            'ParentGender' => $parent->pGender,
            'email' => $parent->email,
        ],
    ]);


    $request->session()->put('logged_in_parent_name', $parent->pFname);


    return redirect()->route('parent.settings')->with('success', 'Personal information updated successfully.');
}





public function changePassword(Request $request)
{
    // Validate the request
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Check if current password matches
    $parent = Parents::find($request->session()->get('logged_in_parent_id'));
    if ($parent && Hash::check($request->current_password, $parent->password)) {
        // Update the password
        $parent->password = Hash::make($request->new_password);
        $parent->save();

        return redirect()->route('parent.settings')->with('success', 'Password updated successfully!');
    }

    return redirect()->route('parent.settings')->with('error', 'Current password is incorrect!');
}


public function logout()
{
    Auth::guard('parent')->logout();  // Log out the admin user

    // Clear all session data related to the admin
    session()->flush();

    return redirect('/');  // Redirect to a desired route or page
}



}
