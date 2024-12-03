<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub Quiz</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <!-- Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f7f1e3;
            color: #2c3e50;
            font-family: 'Heebo', sans-serif;
        }
        .quiz-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 20px;
            border: 2px solid #ffdd59;
            border-radius: 10px;
            background-color: #ffffff;
        }
        .question-box {
            border: 2px solid #f7b731;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #ffda79;
        }
        .options {
            display: flex;
            flex-direction: column;
        }
        .option {
            margin: 10px 0;
            padding: 10px;
            border: 2px solid #f7b731;
            border-radius: 10px;
            background-color: #f1c40f;
            cursor: pointer;
            color: #2c3e50;
            text-align: left;
        }
        .option:hover {
            background-color: #f39c12;
        }
        .option.selected {
            background-color: #e67e22;
        }
        .back-button {
            position: fixed;
            top: 90px;
            left: 20px;
        }
        .falling-books {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        .falling-book {
            position: absolute;
            width: 30px;
            height: 40px;
            background-image: url('path/to/book-image.png'); /* Replace with the path to your book image */
            background-size: cover;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
        #audio-toggle {
            position: fixed; /* Fix position to top right */
            top: 80px; /* 20px from the top */
            right: 20px; /* 20px from the right */
            background-color: #4CAF50; /* Green background */
            color: white; /* White text color */
            border: none; /* No border */
            border-radius: 50%; /* Circular button */
            width: 50px; /* Width of the button */
            height: 50px; /* Height of the button */
            display: flex; /* Use flexbox */
            justify-content: center; /* Center icon */
            align-items: center; /* Center icon */
            cursor: pointer; /* Pointer cursor */
            font-size: 24px; /* Font size for icon */
            transition: background-color 0.3s; /* Smooth transition */
            pointer-events: auto; /* Add pointer-events to make the button clickable */
            z-index: 1000; /* Ensure it's above other elements */
        }
        .cloud-box {
            display: inline-block;
            padding: 20px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 10px;
            width: 250px;
            height: 250px;
            display: flex;
            top: 50%;
            align-items: center;
            justify-content: center;
            background-color: #e2f1ff; /* Light blue background */
        }
        .quiz-image {
            object-fit: cover; /* Ensures the image covers the entire box */
            width: 100%; /* Make the image fill the width of the box */
            height: 100%; /* Make the image fill the height of the box */
            object-position: center; /* Center the image */
            border-radius: 50%;
            width: 240px;
            height: 250px;
        }
    </style>
</head>
<body>
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="all">
        <div class="header d-flex justify-content-between align-items-center fixed-top">
            <a href="{{ route('parent.bookshow', ['id' => $flipbookId, 'childId' => $childId]) }}" style="text-decoration: none;" class="d-flex align-items-center">
                <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
            </a>

            @if(isset($child))
            <div>
                <b>Hello {{ $child->childFirstName }}</b>
            </div>
            @endif
        </div>

        <div class="quiz-container">
            <h1>Quiz</h1>

            <form id="quizForm" method="POST" action="{{ route('quiz.submit', ['id' => $flipbookId, 'childId' => $childId]) }}">
                @csrf
                <input type="hidden" id="child_id" name="child_id" value="{{ $childId }}">
                <input type="hidden" id="flipbook_id" name="flipbook_id" value="{{ $flipbookId }}">
                <input type="hidden" id="date_taken" name="date_taken" value="{{ \Carbon\Carbon::now()->toDateTimeString() }}">
 <!-- Add total_score hidden input -->
 <input type="hidden" id="total_score" name="total_score" value="0">

                @foreach($quizQuestions as $key => $question)
                <div class="quiz-question" id="question-{{ $key }}" style="display: {{ $key === 0 ? 'block' : 'none' }};">
                    @if($question['images']) <!-- Check if image exists -->
                        <div class="cloud-box float-end" style="background-image: url('{{ asset($question['images']) }}');"></div>
                    @endif

                    <div class="question-box">
                        <p><strong>Question {{ $key + 1 }}:</strong> {{ $question['quiz_question'] }}</p>
                    </div>

                    <div class="options">
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selected_answer[{{$key}}]" id="option{{ $key }}{{ $option }}" value="{{ $option }}">

                                <label class="form-check-label" for="option{{ $key }}{{ $option }}">
                                    {{ $question['option_' . strtolower($option)] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

                <!-- Navigation Buttons -->
                <button type="button" id="prevButton" class="btn btn-secondary">Previous</button>
                <button type="button" id="nextButton" class="btn btn-primary">Next</button>

                <!-- Submit Button (hidden until the last question) -->
                <button type="submit" id="submitQuiz" class="btn btn-success" style="display: none;">Submit Quiz</button>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fkrVo15cV5ckdA3trn8J7fmp96eof7Ylh50Asfq" crossorigin="anonymous"></script>

    <script>


    // Initialize the first question
    document.addEventListener('DOMContentLoaded', function () {
    let currentQuestion = 0;
    const totalQuestions = {{ count($quizQuestions) }};
    const nextButton = document.getElementById('nextButton');
    const prevButton = document.getElementById('prevButton');
    const submitButton = document.getElementById('submitQuiz');
    const totalScoreInput = document.getElementById('total_score');

    // Correct answers passed from the controller
    const correctAnswers = @json($correctAnswers);

    function showQuestion(index) {
        const questions = document.querySelectorAll('.quiz-question');
        questions.forEach((question, i) => {
            question.style.display = i === index ? 'block' : 'none';
        });

        // Hide the Next button if on the last question
        if (index === totalQuestions - 1) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }

        // Hide the Previous button if on the first question
        if (index === 0) {
            prevButton.style.display = 'none';
        } else {
            prevButton.style.display = 'block';
        }
    }

    function getSelectedAnswer(index) {
        const selectedOption = document.querySelector(`input[name="selected_answer[${index}]"]:checked`);
        return selectedOption ? selectedOption.value : null;
    }

    function calculateTotalScore() {
        let score = 0;
        let answers = [];
        for (let i = 0; i < totalQuestions; i++) {
            const selectedAnswer = getSelectedAnswer(i);
            answers.push(selectedAnswer); // Store the answer
            if (selectedAnswer && selectedAnswer === correctAnswers[i]) {
                score++;
            }
        }

        totalScoreInput.value = score;  // Update total score hidden field
        return answers;
    }

    nextButton.addEventListener('click', function () {
        const selectedAnswer = getSelectedAnswer(currentQuestion);
        if (selectedAnswer) {
            currentQuestion++;
            showQuestion(currentQuestion);
        } else {
            Swal.fire('Error', 'Please select an answer before proceeding.', 'error');
        }
    });

    prevButton.addEventListener('click', function () {
        currentQuestion--;
        showQuestion(currentQuestion);
    });

    // Add the answers to the form when submitting
    submitButton.addEventListener('click', function () {
        const answers = [];
        for (let i = 0; i < totalQuestions; i++) {
            const selectedAnswer = getSelectedAnswer(i);
            answers.push(selectedAnswer || null); // Add null if no answer is selected
        }

        // Remove existing hidden inputs for answers (if any)
        const existingInputs = document.querySelectorAll('input[name^="selected_answer"]');
        existingInputs.forEach(input => input.remove());

        // Create hidden inputs for each answer
        answers.forEach((answer, index) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `selected_answer[${index}]`;
            input.value = answer || ''; // Handle null values
            document.getElementById('quizForm').appendChild(input);
        });

        // Submit the form
        document.getElementById('quizForm').submit();
    });

    // Initialize the first question
    showQuestion(currentQuestion);
});

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var spinner = document.getElementById("spinner");
            spinner.classList.add("d-none");
          });
    </script>
</body>
</html>
