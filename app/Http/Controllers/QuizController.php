<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\Flipbook;
use App\Models\Parents;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function quizshow(Request $request, $id, $childId)
    {
        $parentId = $request->session()->get('logged_in_parent_id');
        $parent = Parents::find($parentId);
        $child = Children::find($childId); // Directly find child by ID

        if ($parent) {
            $child = $parent->children()->find($childId);
        }

        $flipbookId = $id;
        $allQuizQuestions = Quiz::where('flipbook_id', $flipbookId)->get();

        // Shuffle and select 10 random questions
        $quizQuestions = $allQuizQuestions->shuffle()->take(10);

        // Store the shuffled order of question IDs in the session
        $shuffledQuestionOrder = $quizQuestions->pluck('id')->toArray();
        $request->session()->put('shuffled_question_order', $shuffledQuestionOrder);

        $flipbook = Flipbook::find($flipbookId);
        $dateTime = Carbon::now()->format('Y-m-d H:i:s');
        $correctAnswers = $quizQuestions->map(function ($question) {
            return $question->correct_answer;
        });
        $quizResultId= QuizResult::where('child_id', $childId)
        ->where('flipbook_id', $flipbookId)
        ->orderBy('id', 'desc') // Order by ID in descending order
        ->first(); // Get the latest record

    $newQuizResultId = $quizResultId ? $quizResultId->id + 1 : 1;  // Get the latest (most recent) result


        return view('parents.quizshow', compact('childId', 'flipbookId', 'quizQuestions', 'flipbook', 'child', 'dateTime', 'correctAnswers','quizResultId'));
    }
    public function submitQuiz(Request $request, $id, $childId)
    {
        try {
            // Get the logged-in parent ID from session
            $parentId = $request->session()->get('logged_in_parent_id');
            $parent = Parents::find($parentId);
            $child = $parent->children()->find($childId);

            if (!$child) {
                throw new \Exception("Child not found for the parent.");
            }

            // Validate the request inputs
            $validated = $request->validate([
                'total_score' => 'required|integer|min:0',
                'flipbook_id' => 'nullable|exists:flipbooks,id',
                'selected_answer' => 'required|array', // Validate as an array
                'selected_answer.*' => 'in:A,B,C,D', // Validate each selected answer
            ]);

            $selectedAnswers = $validated['selected_answer']; // Get the array
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

            // Get the current date and time in Manila time
            $phTime = Carbon::now('Asia/Manila');

            // Start a transaction
            DB::beginTransaction();

            // Create a new QuizResult entry
            $quizResult = new QuizResult([
                'total_score' => 0, // We will update this later after calculating
                'child_id' => $childId,
                'flipbook_id' => $flipbookId,
                'grade_level_id' => $classInfo->grade_level_id,
                'teacher_id' => $classInfo->teacher_id,
                'date_taken' => $phTime,
            ]);

            $quizResult->save(); // Save the quiz result to the database
            $totalScore = 0;

            // Retrieve the shuffled question order from the session
            $shuffledQuestionOrder = $request->session()->get('shuffled_question_order', []);

            if (count($selectedAnswers) !== count($shuffledQuestionOrder)) {
                throw new \Exception("Selected answers do not match the number of questions.");
            }

            foreach ($selectedAnswers as $index => $selectedAnswer) {
                // Retrieve the shuffled question ID from the stored array
                $shuffledQuestionId = $shuffledQuestionOrder[$index]; // Example array storing shuffled IDs

                // Find the correct question based on the shuffled question ID
                $quiz = Quiz::find($shuffledQuestionId); // Find the quiz question by ID

                if ($quiz) {
                    // Compare selected answer with the correct answer from the quiz
                    $isCorrect = ($quiz->correct_answer === $selectedAnswer);

                    // If the answer is correct, increment the total score
                    if ($isCorrect) {
                        $totalScore++;
                    }

                    // Create a new entry in the quiz_answers table with whether the answer is correct
                    QuizAnswer::create([
                        'quiz_id' => $quiz->id,              // Quiz ID (which question was answered)
                        'quiz_result_id' => $quizResult->id,  // Quiz result ID
                        'child_id' => $childId,               // Child's ID
                        'selected_answer' => $selectedAnswer, // Selected answer
                        'is_correct' => $isCorrect,           // Whether the answer is correct
                    ]);
                }
            }

            // After looping through all selected answers, update the total score
            $quizResult->total_score = $totalScore;
            $quizResult->save(); // Save the updated score

            // Commit the transaction
            DB::commit();
            return redirect()->route('parent.quizResult', ['id' => $flipbookId, 'childId' => $childId, 'quizResultId' => $quizResult->id])->with('success', 'Quiz submitted successfully!'); 
        //return redirect()->back()->with('success', 'Quiz created successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            return response()->json(['error' => 'Failed to save quiz result. Please try again. ' . $e->getMessage()], 500);
        }
    }

}
