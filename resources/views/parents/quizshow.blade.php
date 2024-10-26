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
        
    </style>
</head>
<body>
    <div id="spinner" class=" show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <button id="audio-toggle" aria-label="Toggle audio" onclick="toggleAudio()" style="z-index: 1000;"> <!-- Added z-index -->
        <i class="fa fa-volume-off" aria-hidden="true" id="audio-icon"></i>
    </button>
    
    <audio id="background-audio" loop>
        <source src="{{ asset('audio/backgroundMusic.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    

<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('parent.bookshow', ['id' => $flipbookId, 'childId' => $childId]) }}" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        
        @if(isset($childId))
        <div>
          <b>Hello {{ $childId->childFirstName }}</b>
        </div>
        @endif
    </div>
<br><br>
    <div class="quiz-container">
        <h1>Quiz</h1>

        <form id="quizForm" method="POST">
            @csrf
            <input type="hidden" id="child_id" name="child_id" value="{{ $childId }}">
            {{--  <input type="hidden" id="gradeLevelId" name="gradeLevelId" value="{{ $gradeLevelId }}">
            <input type="hidden" id="teacherId" name="teacherId" value="{{ $teacherId }}">  --}}
            <input type="hidden" id="flipbook_id" name="flipbook_id" value="{{ $flipbookId }}">
            <input type="hidden" id="date_taken" name="date_taken" value="{{ \Carbon\Carbon::now()->toDateTimeString() }}">

            @foreach($quizQuestions as $key => $question)
                <div class="quiz-question" id="question-{{ $key }}" style="display: {{ $key === 0 ? 'block' : 'none' }};">
                    <div class="question-box">
                        <p><strong>Question {{ $key + 1 }}:</strong> {{ $question['quiz_question'] }}</p>
                    </div>
                    <div class="options">
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                        <div class="option" data-question="{{ $key }}" data-answer="{{ $option }}">
                            {{ $question['option_' . strtolower($option)] }}
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="answer{{ $key }}" id="answer{{ $key }}">
                </div>
            @endforeach
            <button type="submit" id="submitQuiz" class="btn btn-primary" style="display: none;">Submit Quiz</button>
        </form>
    </div>
</div>



<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
 
    // Quiz functionality
    $(document).ready(function() {
        var currentQuestion = 0;
        var totalQuestions = $('.quiz-question').length;

        function showQuestion(index) {
            $('.quiz-question').hide();
            $('#question-' + index).show();
        }

        $('.option').click(function() {
            var questionId = $(this).data('question');
            var selectedAnswer = $(this).data('answer');
            
            $('#answer' + questionId).val(selectedAnswer);

            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');

            currentQuestion++;
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion);
            } else {
                $('#submitQuiz').show();
            }
        });

        $('#quizForm').submit(function(event) {
            event.preventDefault();

            var answers = [];
            $("input[type=hidden][name^=answer]").each(function() {
                answers.push($(this).val());
            });

            var correctAnswers = [];
            @foreach($quizQuestions as $question)
                correctAnswers.push('{{ $question['correct_answer'] }}');
            @endforeach

            var score = 0;
            for (var i = 0; i < answers.length; i++) {
                if (answers[i] === correctAnswers[i]) {
                    score++;
                }
            }

            console.log("Score: " + score);

            var childId = $("input[name='child_id']").val();
            var flipbookId = $("input[name='flipbook_id']").val();
            var dateTaken = $("input[name='date_taken']").val();

            $.ajax({
                url: '{{ route("quiz.submit", ["id" => $flipbookId, "childId" => $childId]) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    total_score: score,
                    child_id: childId,
                    flipbook_id: flipbookId,
                    date_taken: dateTaken
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Quiz Result',
                        text: 'You scored ' + score + ' out of ' + correctAnswers.length,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('parent.reports') }}';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    function toggleAudio() {
        var audio = document.getElementById('background-audio');
        var icon = document.getElementById('audio-icon');
    
        if (audio.paused) {
            audio.play().then(() => {
                icon.classList.remove('fa-volume-off');
                icon.classList.add('fa-volume-up');
                console.log("Audio is playing."); // Debugging log
            }).catch(error => {
                console.error("Audio play failed:", error);
            });
        } else {
            audio.pause();
            icon.classList.remove('fa-volume-up');
            icon.classList.add('fa-volume-off');
            console.log("Audio is paused."); // Debugging log
        }
    }
    
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
</body>
</html>
