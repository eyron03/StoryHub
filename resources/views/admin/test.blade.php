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
        // Get the ID of the logged-in parent
        $parentId = $request->session()->get('logged_in_parent_id');

        // Retrieve the parent details
        $parent = Parents::find($parentId);

        // If parent is found, get their name, else set an empty array
        $parents = $parent ? [$parent->pFname] : [];

        // Retrieve children associated with the parent ID
        $children = Children::where('parent_id', $parentId)->get();

        $reports = DB::table('quiz_results')
        ->join('childrens', 'quiz_results.child_id', '=', 'childrens.id')
        ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
        ->whereIn('quiz_results.child_id', $children->pluck('id'))
        ->select('childFirstName', 'quiz_results.total_score', 'flipbooks.book_name', 'quiz_results.date_taken')
        ->orderBy('quiz_results.date_taken', 'asc') // Order by created_at column in descending order
        ->get();

        // Pass parent details, children, and reports to the view
        return view('parents.reports', compact('parents', 'reports', 'children'));
    }
    public function progress(Request $request)
{
    $parentId = $request->session()->get('logged_in_parent_id');

    // Retrieve the parent details
    $parent = Parents::find($parentId);

    // Initialize an empty array to store child progress
    $childrenProgress = [];

    // If parent found, proceed to fetch progress for each child
    if ($parent) {
        // Retrieve all children associated with the parent ID
        $children = $parent->children;

        // Iterate through each child
        foreach ($children as $child) {
            // Initialize arrays to store unique book names and progress
            $uniqueBookNames = [];
            $progresses = [];

            // Retrieve all quiz results associated with the child
            $quizResults = DB::table('quiz_results')
                ->join('flipbooks', 'quiz_results.flipbook_id', '=', 'flipbooks.id')
                ->where('quiz_results.child_id', $child->id)
                ->select(
                    'flipbooks.book_name',
                    DB::raw('(quiz_results.total_score * 10) as progress') // Corrected progress calculation
                )
                ->orderBy('quiz_results.date_taken', 'asc')
                ->get();

            // Iterate through each quiz result for the child
            foreach ($quizResults as $quizResult) {
                // If the book name is not already in the unique book names array, add it
                if (!in_array($quizResult->book_name, $uniqueBookNames)) {
                    $uniqueBookNames[] = $quizResult->book_name;
                    $progresses[] = $quizResult->progress;
                }
            }

            // Combine unique book names and progress arrays into a single array
            $childProgress = [];
            for ($i = 0; $i < count($uniqueBookNames); $i++) {
                $childProgress[] = [
                    'name' => $child->childFirstName,
                    'book_name' => $uniqueBookNames[$i],
                    'progress' => $progresses[$i],
                ];
            }

            // Add child progress to the main array
            $childrenProgress = array_merge($childrenProgress, $childProgress);
        }
    }

    // Return the view with parent details and children progress
    return view('parents.progress', compact('parent', 'childrenProgress'));
}

}
