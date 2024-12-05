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

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
        <a href="" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>

        @if(isset($childId))
        <div>
          <b>Hello {{ $childId->childFirstName }}</b>
        </div>
        @endif
    </div>


    <div class="quiz-container">
        <!-- Show the total score -->
        <div class="alert alert-success">
            <strong>Score:</strong> {{ $quizResult->total_score }} / 100
        </div>

        <!-- Show the questions and answers -->
        <h4>Questions and Answers:</h4>
        <ul>
            @foreach($shuffledQuizQuestions as $question)
                <li>
                    <strong>{{ $question->quiz_question }}</strong>
                    <ul>
                        <li><strong>Option A:</strong> {{ $question->option_a }}</li>
                        <li><strong>Option B:</strong> {{ $question->option_b }}</li>
                        <li><strong>Option C:</strong> {{ $question->option_c }}</li>
                        <li><strong>Option D:</strong> {{ $question->option_d }}</li>
                    </ul>

                    <!-- Display the answer selected by the child -->
                    <strong>Answer:</strong>
                    @php
                        // Find the answer for this shuffled question
                        $answer = $quizAnswers->firstWhere('quiz_id', $question->id);
                    @endphp
                    @if($answer)
                        {{ $answer->selected_answer }}
                    @else
                        <span class="text-danger">No answer selected</span>
                    @endif
                </li>
            @endforeach
        </ul>

        <a href="{{ route('parent.quizshow', ['id' => $quizResult->flipbook_id, 'childId' => $quizResult->child_id]) }}" class="btn btn-primary">Back to Quiz</a>
    </div>




<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
</body>
</html>
