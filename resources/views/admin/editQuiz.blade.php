q
<html>
<head>
    <meta charset="utf-8" />
    <title>Edit Flip Book</title>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/starter-template.css') }}" rel="stylesheet">

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('extras/modernizr.2.5.3.min.js') }}"></script>

    <style>
        #gifLoader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;

            padding: 10px;
            border-radius: 5px;
        }
        #gifLoader img {
            width: 250px; /* Adjust the width */
            height: 200px; /* Maintain aspect ratio */
            margin-top:200px;
        }

        .d-none { display: none; }
        .d-flex { display: flex; }
        .img-thumbnail {
    max-height: 150px;
    border: 2px solid #ddd;
    padding: 5px;
}
    </style>


</head>
<body>
    <div class="all">
    <div class="container">

    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('flipbook.index') }}" style="text-decoration: none;"class="d-flex align-items-center">

          <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                <span style="font-weight:bold;" class="name">Admin</span>

            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="/html/teacher/teacher_account.html" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>

                <li class="text-center">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
 <div id="gifLoader" class="mb-3 text-center d-none justify-content-center min-vh-100">
            <img src="{{ asset('book/bookloader.gif') }}" alt="Loading..." class="img-fluid">
        </div>

        <br><br><br><br>
        <div class="starter-template">
            <h1>Edit Book & Questions</h1>


        </div>

            <form class="register-form" method="POST" action="{{ route('admin.updateQuiz', $flipbooks->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="container">
                    <h2>Update Quiz</h2>
                    <hr>

                    <!-- Loop through existing quizzes -->
                    @foreach($flipbooks->quizzes as $index => $quiz)
                    <div class="card mb-4" id="quiz_{{ $index }}">
                        <div class="card-header">
                            <strong>Quiz {{ $index + 1 }}</strong>
                        </div>
                        <div class="card-body">
                            <!-- Quiz Question -->
                            <div class="form-group row">
                                <label for="quiz_question_{{ $index }}" class="col-lg-3 col-form-label"><span class="required">*</span> Quiz Question</label>
                                <div class="col-lg-9">
                                    <input type="text" name="quiz_question[]" id="quiz_question_{{ $index }}" class="form-control" value="{{ old('quiz_question.'.$index, $quiz->quiz_question) }}" required>
                                </div>
                            </div>

                            <!-- Quiz Options -->
                            @foreach(['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $label => $name)
                            <div class="form-group row">
                                <label for="{{ $name }}_{{ $index }}" class="col-lg-3 col-form-label"><span class="required">*</span> Option {{ $label }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="{{ $name }}[]" id="{{ $name }}_{{ $index }}" class="form-control" value="{{ old("$name.$index", $quiz->$name) }}" required>
                                </div>
                            </div>
                            @endforeach

                            <!-- Correct Answer -->
                            <div class="form-group row">
                                <label for="correct_answer_{{ $index }}" class="col-lg-3 col-form-label"><span class="required">*</span> Correct Answer</label>
                                <div class="col-lg-9">
                                    <input type="text" name="correct_answer[]" id="correct_answer_{{ $index }}" class="form-control" value="{{ old('correct_answer.'.$index, $quiz->correct_answer) }}" required>
                                </div>
                            </div>

                            <!-- Image Handling -->
                            <div class="form-group row">
                                <label for="images_{{ $index }}" class="col-lg-3 col-form-label">Quiz Image</label>
                                <div class="col-lg-9">
                                    @if(!empty($quiz->images))
                                    <div class="mb-2">
                                        <img src="{{ asset($quiz->images) }}" alt="Quiz Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                    @endif
                                    <input type="file" name="images[]" id="images_{{ $index }}" class="form-control-file" accept="image/*">
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                    <!-- Button to add more questions -->
                    <div class="form-group row">
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="button" id="add_question" class="btn btn-sm btn-primary">Add More Quiz</button>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="submit" class="btn btn-lg btn-primary" style="background-color: orange;">Update Quiz</button>
                        </div>
                    </div>
                </div>
            </form>




        <hr>

    </div> </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="text/javascript">
   $(document).ready(function() {
    let counter = {{ count($flipbooks->quizzes) }}; // Initialize counter to existing quiz count

    $("#add_question").on('click', function() {
        counter++; // Increment the counter for new quiz

        // Create a new quiz question form
        let newQuestionHtml = `
            <div class="card mb-4" id="quiz_${counter}">
                <div class="card-header">
                    <strong>Quiz ${counter }</strong>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="quiz_question_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Quiz Question</label>
                        <div class="col-lg-9">
                            <input type="text" name="quiz_question[]" id="quiz_question_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Option A -->
                    <div class="form-group row">
                        <label for="option_a_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Option A</label>
                        <div class="col-lg-9">
                            <input type="text" name="option_a[]" id="option_a_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Option B -->
                    <div class="form-group row">
                        <label for="option_b_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Option B</label>
                        <div class="col-lg-9">
                            <input type="text" name="option_b[]" id="option_b_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Option C -->
                    <div class="form-group row">
                        <label for="option_c_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Option C</label>
                        <div class="col-lg-9">
                            <input type="text" name="option_c[]" id="option_c_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Option D -->
                    <div class="form-group row">
                        <label for="option_d_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Option D</label>
                        <div class="col-lg-9">
                            <input type="text" name="option_d[]" id="option_d_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Correct Answer -->
                    <div class="form-group row">
                        <label for="correct_answer_${counter}" class="col-lg-3 col-form-label"><span class="required">*</span> Correct Answer</label>
                        <div class="col-lg-9">
                            <input type="text" name="correct_answer[]" id="correct_answer_${counter}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Image Input -->
                    <div class="form-group row">
                        <label for="images_${counter}" class="col-lg-3 col-form-label">Quiz Image</label>
                        <div class="col-lg-9">
                            <input type="file" name="images[]" id="images_${counter}" class="form-control-file" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append the new question to the form
        $(".register-form").append(newQuestionHtml);

        // Keep the Add More Quiz button at the bottom
        $("html, body").animate({ scrollTop: $(document).height() }, 100);
    });
});


</script>

</script>

</body>
</html>
