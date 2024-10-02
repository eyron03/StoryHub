<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Flipbook;
use App\Models\Parents;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function create()
    {
        return view('quizcreater');
    }

    public function quizStore(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|string',
            'book_id' => 'nullable|exists:flipbooks,id'
        ]);

      
        $bookId = $request->input('book_id');

      
        $quiz = new Quiz([
            'quiz_question' => $validatedData['quiz_question'],
            'option_a' => $validatedData['option_a'],
            'option_b' => $validatedData['option_b'],
            'option_c' => $validatedData['option_c'],
            'option_d' => $validatedData['option_d'],
            'correct_answer' => $validatedData['correct_answer'],
            'book_id' => $bookId
        ]);
        $quiz->save();

        
        return redirect()->back()->with('success', 'Quiz created successfully!');
    }

public function quizshow(Request $request, $id,$childId)
{
  
    $parentId = $request->session()->get('logged_in_parent_id');
 
    $parent = Parents::find($parentId);

   
    $child = null;
$childId=Children::find($childId);
   
    if ($parent) {
        $child = $parent->children()->find($childId);
    }
    
    $flipbookId = $id;

    $allQuizQuestions = Quiz::where('flipbook_id', $flipbookId)->get();
    
    // Shuffle and select 10 random questions
    $quizQuestions = $allQuizQuestions->shuffle()->take(10);
   
    $flipbook = Flipbook::find($flipbookId);
    $dateTime = Carbon::now()->format('Y-m-d H:i:s');
   
    return view('parents.quizshow', compact('childId', 'flipbookId', 'quizQuestions', 'flipbook','child','dateTime'));
}
public function submitQuiz(Request $request, $id, $childId)
{
    try {
        $parentId = $request->session()->get('logged_in_parent_id');

        $parent = Parents::find($parentId);
        $child = $parent->children()->find($childId);
        if (!$child) {
            throw new \Exception("Child not found for the parent.");
        }

        $request->validate([
            'total_score' => 'required|integer|min:0',
            'flipbook_id' => 'nullable|exists:flipbooks,id',
        ]);

        $flipbookId = $id;

        // Fetch the child’s class and grade level
        $classInfo = DB::table('children_classes')
            ->where('child_id', $childId)
            ->join('grade_levels', 'children_classes.class_id', '=', 'grade_levels.id')
            ->join('teachers', 'grade_levels.teacher_id', '=', 'teachers.id')
            ->select('grade_levels.id as grade_level_id', 'teachers.id as teacher_id')
            ->first();

        if (!$classInfo) {
            throw new \Exception("Class or Grade Level not found for the child.");
        }

        $phTime = Carbon::now('Asia/Manila');

        $quizResult = new QuizResult([
            'total_score' => $request->input('total_score'),
            'child_id' => $childId,
            'flipbook_id' => $flipbookId,
            'grade_level_id' => $classInfo->grade_level_id,
            'teacher_id' => $classInfo->teacher_id,
            'date_taken' => $phTime,
        ]);

        $quizResult->save();

        return response()->json(['message' => 'Quiz result saved successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to save quiz result. Please try again.'], 500);
    }
}


}
