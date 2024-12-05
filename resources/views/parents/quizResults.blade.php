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
<br><br><br><br>
<div class="quiz-container container mt-4">
    <!-- Show the total score -->
    <div class="alert alert-success d-flex justify-content-between align-items-center mb-3">
        <strong>Score:</strong> <span class="fs-4">{{ $quizResult->total_score }} / {{ $totalQuestions }}</span>
    </div>

    <!-- Show the questions and answers -->
    <h4 class="mb-3">Questions and Answers:</h4>
    <div class="list-group">
        @foreach($shuffledQuizQuestions as $key => $question)
            <div class="list-group-item p-3">
                <div class="question-box mb-2">
                    <p><strong>Question {{ $key + 1 }}:</strong> {{ $question['quiz_question'] }}</p>
                </div>

                <ul class="list-unstyled mb-2">
                    <li><strong>A:</strong> {{ $question->option_a }}</li>
                    <li><strong>B:</strong> {{ $question->option_b }}</li>
                    <li><strong>C:</strong> {{ $question->option_c }}</li>
                    <li><strong>D:</strong> {{ $question->option_d }}</li>
                </ul>

                <!-- Display the answer selected by the child -->
                <div>
                    <strong>Answer:</strong>
                    @php
                        // Find the answer for this shuffled question
                        $answer = $quizAnswers->firstWhere('quiz_id', $question->id);
                    @endphp
                    @if($answer)
                        <p class="mb-1">
                            <strong>Selected Answer:</strong> {{ $answer->selected_answer }}
                        </p>
                        @if($answer->is_correct)
                            <span class="badge bg-success">✔ Correct</span> <!-- Correct answer -->
                        @else
                            <span class="badge bg-danger">✘ Incorrect</span> <!-- Wrong answer -->
                        @endif
                    @else
                        <span class="badge bg-warning">No answer selected</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        <a href="{{ route('parent.quizshow', ['id' => $quizResult->flipbook_id, 'childId' => $quizResult->child_id]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Back to Quiz
        </a>
    </div>
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
