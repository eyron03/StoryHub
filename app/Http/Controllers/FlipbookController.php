<?php

namespace App\Http\Controllers;

use App\Models\Flipbook;
use App\Models\Quiz;
use GifCreator\GifCreator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FlipbookController extends Controller
{
    public function index(Request $request)
{
    // Get the search input and book type from the request
    $search = $request->input('search');
    $bookType = $request->input('book_type'); // New filter for book type

    // Build the query to fetch flipbooks with search and filter functionality
    $query = Flipbook::query();

    // Apply search filter if present
    if ($search) {
        $query->where('book_name', 'LIKE', "%{$search}%");
    }

    // Apply book type filter if present
    if ($bookType) {
        $query->where('book_type', $bookType);
    }

    // Paginate the results, appending search and filter parameters
    $flipbooks = $query->paginate(12)->appends([
        'search' => $search,
        'book_type' => $bookType, // Persist the selected book type
    ]);

    // Get today's date
    $today = now()->toDateString();

    // Pass the data to the view
    return view('bookindex', [
        'flipbooks' => $flipbooks,
        'today' => $today,
        'search' => $search,      // Pass search term to the view
        'bookType' => $bookType,  // Pass book type filter to the view
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
    $images = [];
    $subtitles = [];

    // Check if images are uploaded
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $uploadedFile) {
            $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('storyhub/images/'), $filename);
            $path = 'storyhub/images/' . $filename;
            $images[] = $path; // Save each image path
        }
    }

    // Handle subtitles
    if ($request->has('subtitles')) {
        $subtitles = $request->input('subtitles'); // Get the subtitles input
    }

    // Store images and subtitles as a serialized string or in a related database table
    $input['images'] = implode(',', $images);
    $input['subtitles'] = implode(';', $subtitles);// Convert images array to a comma-separated string
   // Convert subtitles to a comma-separated string

    // Create the flipbook record
    $flipbook = Flipbook::create($input);

    Log::info('Book added successfully:', [
        'BookTitle' => $flipbook->book_name,
        'BookDescription' => $flipbook->desc,
    ]);

    return redirect()->route('admin.createQuiz', ['flipbook' => $flipbook->id]);
}

    public function createQuiz($flipbook_id)
    {
        // Retrieve the flipbook by ID
        $flipbook = Flipbook::findOrFail($flipbook_id);

        // Pass the flipbook to the view for context
        return view('admin.createQuiz', compact('flipbook'));
    }
    public function storeQuiz(Request $request, $flipbook_id)
    {
        $flipbook = Flipbook::findOrFail($flipbook_id);

        // Validate and save quiz data
        for ($i = 1; $i <= $request->counter; $i++) {
            $validatedQuizData = $request->validate([
                "quiz_question_$i" => 'required|string',
                "option_a_$i" => 'required|string',
                "option_b_$i" => 'required|string',
                "option_c_$i" => 'required|string',
                "option_d_$i" => 'required|string',
                "correct_answer_$i" => 'required|string',
                "images_$i" => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validate image
            ]);

            // Handle image upload if present
            $imagePath = null;
            if ($request->hasFile("images_$i")) {
                $uploadedFile = $request->file("images_$i");
                $filename = time() . '_' . $uploadedFile->getClientOriginalName(); // Generate a unique filename
                $uploadedFile->move(public_path('storyhub/quiz/'), $filename); // Move the file to the desired directory
                $imagePath = 'storyhub/quiz/' . $filename; // Store the relative path to the image
            }

            // Create the new Quiz
            $quiz = new Quiz([
                'quiz_question' => $validatedQuizData["quiz_question_$i"],
                'option_a' => $validatedQuizData["option_a_$i"],
                'option_b' => $validatedQuizData["option_b_$i"],
                'option_c' => $validatedQuizData["option_c_$i"],
                'option_d' => $validatedQuizData["option_d_$i"],
                'correct_answer' => $validatedQuizData["correct_answer_$i"],
                'images' => $imagePath, // Store the image path in the database
            ]);

            // Save the quiz data to the flipbook
            $flipbook->quizzes()->save($quiz);
        }

        return redirect()->route('flipbook.index')->with('success', 'Quiz created successfully!');
    }

public function show($id)
{
    // Retrieve the flipbook with related quizzes
    $flipbooks = Flipbook::with('quizzes')->findOrFail($id);

    // Decode the subtitles JSON

    $subtitles = explode(";", $flipbooks->subtitles);
    // Split the images string into an array
    $images = explode(",", $flipbooks->images);

    // Pass the flipbooks, images, and subtitles to the view
    return view('showbook', compact('flipbooks', 'images', 'subtitles'));
}


    public function showquiz($id) {
        $quizQuestions = Quiz::where('flipbook_id', $id)->get();

        return view('showquiz', compact('quizQuestions'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('flipbooks')->findOrFail($id);
        $flipbook = Flipbook::with('quizzes')->findOrFail($id);
        $images = explode(",", $flipbook->images);
        $subtitles = explode(";", $flipbook->subtitles);
        return view('editbook', compact('flipbook', 'images','quiz','subtitles'));
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'book_name' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'subtitles' => 'nullable|array',
            'subtitles.*' => 'nullable|string',  // Validate each subtitle as a string
        ]);

        // Retrieve the Flipbook
        $flipbook = Flipbook::findOrFail($id);

        // Handle new image uploads
        $images = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('storyhub/images/'), $filename);
                $path = 'storyhub/images/' . $filename;
                $images[] = $path;
            }
        }

        // Handle subtitles as an array
        $subtitles = $request->input('subtitles', []); // Ensure we get an empty array if no subtitles are provided

        // Update flipbook fields
        $flipbook->book_name = $request->input('book_name');
        $flipbook->desc = $request->input('desc');
        $flipbook->subtitles = implode(';', $subtitles); // Store subtitles as a comma-separated string
        if (!empty($images)) {
            $existingImages = explode(',', $flipbook->images);
            $flipbook->images = implode(',', array_merge($existingImages, $images));
        }

        $flipbook->save();

        return redirect()->route('flipbook.index')->with('success', 'Flipbook updated successfully!');
    }

        // Method to show the edit form
        public function editQuiz($id)
        {
            // Fetch the quiz with the related flipbooks
            $flipbooks = Flipbook::with('quizzes')->findOrFail($id);

            // Pass the data to the view
            return view('admin.editQuiz', compact( 'flipbooks'));
        }

        public function updateQuiz(Request $request, $id)
        {
            $fb = Flipbook::findOrFail($id);

            // Retrieve form data
            $quizQuestions = $request->input('quiz_question', []);
            $optionA = $request->input('option_a', []);
            $optionB = $request->input('option_b', []);
            $optionC = $request->input('option_c', []);
            $optionD = $request->input('option_d', []);
            $correctAnswers = $request->input('correct_answer', []);

            // Handle file uploads
            $uploadedImages = $request->file('images', []);

            foreach ($quizQuestions as $key => $question) {
                if (!empty($question)) {
                    // Find existing quiz or create a new one
                    $quiz = $fb->quizzes[$key] ?? new Quiz();

                    $quiz->quiz_question = $question;
                    $quiz->option_a = $optionA[$key];
                    $quiz->option_b = $optionB[$key];
                    $quiz->option_c = $optionC[$key];
                    $quiz->option_d = $optionD[$key];
                    $quiz->correct_answer = $correctAnswers[$key];

                    // Handle new image upload if present
                    if (isset($uploadedImages[$key]) && $uploadedImages[$key]->isValid()) {
                        // Delete the old image if exists
                        if ($quiz->images) {
                            // Delete the old image from storage
                            $oldImagePath = public_path('storyhub/quiz/' . $quiz->images);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // Delete the old image
                            }
                        }

                        // Generate a new filename and store the image
                        $fileName = time() . '_' . $uploadedImages[$key]->getClientOriginalName();
                        $uploadedImages[$key]->move(public_path('storyhub/quiz/'), $fileName); // Move the new file

                        // Set the new image path
                        $quiz->images = 'storyhub/quiz/' . $fileName;
                    }

                    // Update or create quiz
                    $fb->quizzes()->save($quiz);
                }
            }

            // Log and redirect
            Log::info('Quiz updated successfully:', [
                'BookTitle' => $fb->book_name,
                'BookDescription' => $fb->desc,
            ]);

            return redirect()->route('flipbook.index')->with('success', 'Quiz updated successfully!');
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
