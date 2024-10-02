<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Flipbook;
use App\Models\Parents;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class QuizResultController extends Controller
{
    //
    public function reports(Request $request)
    {
        $parentId = $request->session()->get('logged_in_parent_id');
        $today = now()->toDateString();
        $parent = Parents::find($parentId);
        
        $parents = $parent ? [$parent->pFname] : [];
    
        // Get all children associated with the logged-in parent
        $children = Children::where('parent_id', $parentId)->pluck('id'); // Only get the IDs for the query
        
        $search = $request->input('search'); // Get the search query
        
        // Query to fetch quiz results using the quiz_results records
        $reports = DB::table('quiz_results')
            ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
            ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
            ->leftJoin('grade_levels', 'quiz_results.grade_level_id', '=', 'grade_levels.id') // Connect to the grade_levels table
            ->whereIn('quiz_results.child_id', $children) // Filter by the children IDs
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('childrens.childFirstName', 'like', '%' . $search . '%')
                      ->orWhere('flipbooks.book_name', 'like', '%' . $search . '%')
                      ->orWhere('grade_levels.GradeLvl', 'like', '%' . $search . '%'); // Search on grade levels
                });
            })
            ->select(
                'childrens.childFirstName',
                'flipbooks.book_name',
                'quiz_results.total_score',
                DB::raw('COALESCE(grade_levels.GradeLvl, "N/A") as old_grade_level'), // Fetch the old grade level name
                'quiz_results.date_taken'
            )
            ->orderBy('quiz_results.date_taken', 'desc') // Order by date taken
            ->paginate(5); // Pagination
    
        return view('parents.reports', compact('parents', 'reports', 'children', 'today', 'search'));
    }
    
    public function progress(Request $request)
    {
        $parentId = $request->session()->get('logged_in_parent_id');
        $today = now()->toDateString();
        $parent = Parents::find($parentId);
    
        if ($parent) {
            $search = $request->input('search'); // Get the search query
    
            // Query to fetch children's progress including their historical grade levels from quiz_results
            $childrenProgress = DB::table('quiz_results')
                ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
                ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
                ->leftJoin('grade_levels', 'quiz_results.grade_level_id', '=', 'grade_levels.id') // Fetch historical grade level from quiz_results
                ->where('childrens.parent_id', $parent->id)
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('childrens.childFirstName', 'like', '%' . $search . '%')
                          ->orWhere('grade_levels.GradeLvl', 'like', '%' . $search . '%')
                          ->orWhere('flipbooks.book_name', 'like', '%' . $search . '%');
                    });
                })
                ->select(
                    'childrens.childFirstName as child_name',
                    DB::raw('COALESCE(grade_levels.GradeLvl, "N/A") as grade_level'), // Fetch historical grade level
                    'flipbooks.book_name',
                    DB::raw('MAX(quiz_results.total_score * 10) as progress'), 
                    DB::raw('MAX(quiz_results.date_taken) as date_taken') 
                )
                ->groupBy('childrens.childFirstName', 'grade_levels.GradeLvl', 'flipbooks.book_name')
                ->orderBy('date_taken', 'desc') 
                ->paginate(5);
    
            return view('parents.progress', compact('parent', 'childrenProgress', 'today', 'search'));
        }
    
        return redirect()->back()->withErrors(['error' => 'Parent not found']);
    }
    
    
        

}