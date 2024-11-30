<html>
	<head>
		<meta charset="utf-8" />
		<title>Create Your Flip Book</title>


 <!-- Bootstrap core CSS -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/starter-template.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


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



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
    </style>
	</head>
	<body>
        <div class="all">
 <div class="container">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('flipbook.index') }}" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>


        </div>

    <br><br><br><br>
 <div class="starter-template table-responsive">


         <h1>Create Questions</h1>

       </div>
       <div id="gifLoader" class="text-center mb-3 d-none justify-content-center min-vh-100">
        <img src="{{ asset('book/bookloader.gif') }}" alt="Loading..." class="img-fluid">
    </div>
    <h1>Create Quiz for "{{ $flipbook->book_name }}"</h1>
       <form id="bookForm" class="register-form" method="POST"  action="{{ route('admin.storeQuiz', $flipbook->id) }}"  enctype="multipart/form-data">
        @csrf


        <div id="quiz_questions" class="table-responsive">
            <input type="hidden" id="counter" name="counter" value="1"> <!-- Initialize counter with 1 for the first question -->

            <!-- Quiz Question 1 -->
            <div class="quiz_question">
                <label for="quiz_question_1">Quiz Question:</label>
                <input type="text" id="quiz_question_1" name="quiz_question_1" required>

                <!-- Options -->
                <div>
                    <label for="option_a_1">Option A:</label>
                    <input type="text" id="option_a_1" name="option_a_1" required>
                </div>
                <div>
                    <label for="option_b_1">Option B:</label>
                    <input type="text" id="option_b_1" name="option_b_1" required>
                </div>
                <div>
                    <label for="option_c_1">Option C:</label>
                    <input type="text" id="option_c_1" name="option_c_1" required>
                </div>
                <div>
                    <label for="option_d_1">Option D:</label>
                    <input type="text" id="option_d_1" name="option_d_1" required>
                </div>
                <div>
                    <label for="correct_answer_1">Correct Answer:</label>
                    <input type="text" id="correct_answer_1" name="correct_answer_1" required>
                </div>
            </div>
            <div class="form-group">
                <label for="images_1">Upload Image (Optional):</label>
                <input type="file" class="form-control" id="images_1" name="images_1">
            </div>
        </div>

<br>
        <div class="row">
            <div class="col-lg-offset-6">
                <button id="add_question" class="btn btn-medium btn-primary" type="button">Add More Quiz</button>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-offset-3 pull-right">
                <button id="add_files"  class="btn btn-lg btn-primary" type="submit"> Create Book</button>
            </div>
        </div>
    </form>

               </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="{{ asset('js/jquery.min.js') }}"></script>
              <script src="{{ asset('js/bootstrap.min.js') }}"></script>

             <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>

             <script type="text/javascript">
                $(document).ready(function() {
                    var counter = 1; // Initialize counter with 1 for the first question
                    var imageCounter = 1; // Initialize image counter with 1 for the first image

                    // Add a new quiz question
                    $("#add_question").on('click', function() {
                        counter++; // Increment the question counter
                        $("#counter").val(counter); // Update the counter value in the hidden input

                        // HTML for a new quiz question
                        var newQuestion = '<div class="quiz_question">' +
                            '<label for="quiz_question_' + counter + '">Quiz Question ' + counter + ':</label>' +
                            '<input type="text" id="quiz_question_' + counter + '" name="quiz_question_' + counter + '" required>' +

                            '<div>' +
                            '<label for="option_a_' + counter + '">Option A:</label>' +
                            '<input type="text" id="option_a_' + counter + '" name="option_a_' + counter + '" required>' +
                            '</div>' +

                            '<div>' +
                            '<label for="option_b_' + counter + '">Option B:</label>' +
                            '<input type="text" id="option_b_' + counter + '" name="option_b_' + counter + '" required>' +
                            '</div>' +

                            '<div>' +
                            '<label for="option_c_' + counter + '">Option C:</label>' +
                            '<input type="text" id="option_c_' + counter + '" name="option_c_' + counter + '" required>' +
                            '</div>' +

                            '<div>' +
                            '<label for="option_d_' + counter + '">Option D:</label>' +
                            '<input type="text" id="option_d_' + counter + '" name="option_d_' + counter + '" required>' +
                            '</div>' +

                            '<div>' +
                            '<label for="correct_answer_' + counter + '">Correct Answer:</label>' +
                            '<input type="text" id="correct_answer_' + counter + '" name="correct_answer_' + counter + '" required>' +
                            '</div>' +

                            // New Image Upload Section
                            '<div>' +
                            '<label for="images_' + counter + '">Upload Image for Question ' + counter + ':</label>' +
                            '<input type="file" id="images_' + counter + '" name="images_' + counter + '" accept="image/*">' +
                            '</div>' +
                            '</div>';

                        // Append the new quiz question and image upload to the container
                        $("#quiz_questions").append(newQuestion);

                        // Increment the image counter for the next image
                        imageCounter++;
                    });
                });
            </script>

                            <script>
                                $(document).ready(function() {
                                    // Show loader and handle form submission
                                    $('#bookForm').on('submit', function(e) {
                                        e.preventDefault(); // Prevent actual form submission
                                        var form = $(this);
                                        var loader = document.getElementById('gifLoader');

                                        // Show the loader
                                        loader.classList.remove('d-none');
                                        // Show loader

                                        // Send form data via AJAX
                                        $.ajax({
                                            url: form.attr('action'),
                                            method: form.attr('method'),
                                            data: new FormData(this),
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                // Hide loader
                                                $('#gifLoader').hide();

                                                // Show SweetAlert success message
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Book created successfully!',
                                                    text: 'Your book has been added.',
                                                    confirmButtonText: 'OK'
                                                }).then(() => {
                                                    window.location.href = '{{ route('flipbook.index') }}';
                                                });

                                                // Reset the form
                                                form[0].reset();
                                            },
                                            error: function(xhr, status, error) {
                                                // Hide loader
                                                $('#gifLoader').hide();

                                                // Show SweetAlert error message
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'There was an issue creating the book. Please try again.',
                                                    confirmButtonText: 'OK'
                                                });
                                            }
                                        });
                                    });
                                });
                            </script>

</body>

</html>

