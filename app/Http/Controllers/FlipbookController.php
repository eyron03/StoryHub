<?php

namespace App\Http\Controllers;

use App\Models\Flipbook;
use App\Models\Quiz;
use GifCreator\GifCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FlipbookController extends Controller
{
    public function index(Request $request)
{
    // Get the search input from the request
    $search = $request->input('search');
    
    // Build the query to fetch flipbooks with search functionality
    $query = Flipbook::query();

    if ($search) {
        $query->where('book_name', 'LIKE', "%{$search}%");
    }
    
    $flipbooks = $query->paginate(12)->appends(['search' => $search]);
    $today = now()->toDateString();
    
    // Pass the data to the view
    return view('bookindex', [
        'flipbooks' => $flipbooks,
        'today' => $today,
        'search' => $search, // Pass search term to the view
    ]);
}


    public function create()
    {
        $bookId = session('flipbook_id');
        return view('bookcreater', ['bookId' => $bookId]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $images = "";

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedFile) {
               
                $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
             
                $uploadedFile->move(public_path('storyhub/images/'), $filename);
                
                $path = 'storyhub/images/' . $filename;
             
                $images .= $path . ",";
            }
            // Remove the trailing comma
            $images = rtrim($images, ",");
        }
    
        // Assign concatenated image paths to the 'images' attribute
        $input['images'] = $images;
        $input['name'] = $input['book_name'];
        // Create the flipbook
        $flipbook = Flipbook::create($input);
    
        // Validate quiz data
        $counter = $request->counter;
    
        // Validate and save quiz data
        for ($i = 1; $i <= $request->counter; $i++) {
            // Validate each quiz question
            $validatedQuizData = $request->validate([
                "quiz_question_$i" => 'required|string',
                "option_a_$i" => 'required|string',
                "option_b_$i" => 'required|string',
                "option_c_$i" => 'required|string',
                "option_d_$i" => 'required|string',
                "correct_answer_$i" => 'required|string',
            ]);
    
            // Create a new quiz associated with the flipbook
            $quiz = new Quiz([
                'quiz_question' => $validatedQuizData["quiz_question_$i"],
                'option_a' => $validatedQuizData["option_a_$i"],
                'option_b' => $validatedQuizData["option_b_$i"],
                'option_c' => $validatedQuizData["option_c_$i"],
                'option_d' => $validatedQuizData["option_d_$i"],
                'correct_answer' => $validatedQuizData["correct_answer_$i"],
            ]);
    
            // Save the quiz associated with the flipbook
            $flipbook->quizzes()->save($quiz);
        }
    
        // Log the successful addition of the flipbook
        Log::info('Book added successfully:', [
            
            'BookTitle' => $flipbook->book_name, 
            'BookDescription' => $flipbook->desc,// Assuming there's a title field
            
        ]);
    
        // Redirect back to the index page
        return redirect()->route('flipbook.index');
    }
        public function show($id)
    {
        $flipbooks = Flipbook::with('quizzes')->findOrFail($id);
        $images = explode(",", $flipbooks->images);

        return view('showbook', compact('flipbooks', 'images'));
    }
    public function showquiz($id) {
        $quizQuestions = Quiz::where('flipbook_id', $id)->get();
    
        return view('showquiz', compact('quizQuestions'));
    }
    
    public function edit($id)
    {
        $flipbooks = Flipbook::with('quizzes')->findOrFail($id);
        $images = explode(",", $flipbooks->images);
        return view('editbook', compact('flipbooks', 'images'));
    }

    public function update(Request $request, $id)
    {
        $fb = Flipbook::find($id);
    
        if (!$fb) {
            // Log error if flipbook is not found
            Log::error('Flipbook not found for update', ['flipbook_id' => $id]);
            return redirect()->route('flipbook.index')->with('error', 'Flipbook not found.');
        }
    
        $input = $request->all();
        $fb->images .= ",";
        $i = 1;
    
        // Handle file uploads
        foreach ($request->file('files', []) as $uploadedFile) {
            $filename = time() . '_' . $i . '.' . $uploadedFile->getClientOriginalExtension();
            $i++;
            $uploadedFile->move(public_path('storyhub/images/'), $filename);
            $path = 'storyhub/images/' . $filename;
            $fb->images .= $path . ",";
        }
    
        $fb->images = rtrim($fb->images, ",");
        $fb->book_name = $input['book_name'];
        $fb->desc = $input['desc'];
        $fb->save();
    
        // Handle quiz updates
        $quizQuestions = $request->input('quiz_question', []);
        $optionA = $request->input('option_a', []);
        $optionB = $request->input('option_b', []);
        $optionC = $request->input('option_c', []);
        $optionD = $request->input('option_d', []);
        $correctAnswers = $request->input('correct_answer', []);
    
        foreach ($quizQuestions as $key => $question) {
            if (!empty($question)) {
                $quiz = isset($fb->quizzes[$key]) ? $fb->quizzes[$key] : new Quiz();
                $quiz->quiz_question = $question;
                $quiz->option_a = $optionA[$key];
                $quiz->option_b = $optionB[$key];
                $quiz->option_c = $optionC[$key];
                $quiz->option_d = $optionD[$key];
                $quiz->correct_answer = $correctAnswers[$key];
                $fb->quizzes()->save($quiz);
            }
        }
    
        // Log the successful update
        Log::info('Book updated successfully:', [
       
            'BookTitle' => $fb->book_name,
            'BookDescription' => $fb->desc,
        ]);
    
        return redirect()->route('flipbook.index')->with('success', 'Book updated successfully!');;
    }
    
    public function destroy($id)
    {
        $fb = Flipbook::find($id);
    
        if (!$fb) {
            // Log error if flipbook is not found
            Log::error('Attempted to delete non-existent flipbook', ['flipbook_id' => $id]);
            return redirect()->route('flipbook.index')->with('error', 'Flipbook not found.');
        }
    
        $imgArr = explode(",", $fb->images);
    
        // Log the images to be deleted
        Log::info('Deleting Book:', [
            'flipbook_id' => $id,
            'images' => $imgArr
        ]);
    
        foreach ($imgArr as $img) {
            $image = public_path($img);
            if (file_exists($image)) {
                unlink($image);
            }
        }
    
        // Delete the flipbook
        $fb->delete();
    
        // Log the successful deletion
        Log::info('Flipbook deleted successfully', ['flipbook_id' => $id]);
    
        return Redirect::route('flipbook.index')->with('success', 'Book deleted successfully!');;
    }
    
    public function destroyQuiz(Request $request)
    {
        $quizIds = $request->input('delete_quiz');

        if ($quizIds) {
            foreach ($quizIds as $quizId) {
                $quiz = Quiz::find($quizId);
                if ($quiz) {
                    $quiz->delete();
                }
            }

            return redirect()->back()->with('success', 'Quizzes deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'No quizzes selected for deletion.');
        }
    }
}
