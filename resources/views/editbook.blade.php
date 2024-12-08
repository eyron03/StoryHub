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
        <form class="register-form" method="POST" action="{{ route('flipbook.update', $flipbook->id) }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="put" />

            <div class="row">
                <div class="col-lg-3">
                    <label><span class="required">*</span> Book Title</label>
                </div>
                <div class="col-lg-3">
                    <input class="input-block-level" type="text" name="book_name" value="{{ $flipbook->book_name }}">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <label><span class="required">*</span> Book Description</label>
                </div>
                <div class="col-lg-3">
                    <input class="input-block-level" type="text" name="desc" value="{{ $flipbook->desc }}">
                </div>
            </div>

            <div class="row">
                @foreach($images as $page)
                <div class="col-md-1">
                    <img src="{{ asset($page) }}" width="100" height="100" />
                </div>
                @endforeach
            </div>
            <br><br>
            <div id="browse_file">
                <div class="row">
                    <div class="col-lg-3">
                        <label><span class="required">*</span> Add More Image </label>
                    </div>
                    <div class="col-lg-9">
                        <input type="file" name="files[]" multiple />
                    </div>
                </div>
            </div>

            <!-- Subtitles Section -->
            <div class="row">
                <div class="col-lg-3">
                    <label><span class="required">*</span> Subtitles</label>
                </div>
                <div class="col-lg-9">
                    <div class="subtitles-container">
                        @foreach (explode(',', $flipbook->subtitles) as $index => $subtitle)
                        <div class="subtitle-group">
                            <label for="subtitles[{{ $index }}]">Subtitle {{ $index + 1 }}</label>
                            <input class="input-block-level" type="text" name="subtitles[{{ $index }}]" value="{{ old('subtitles.' . $index, $subtitle) }}" placeholder="Subtitle {{ $index + 1 }}">
                            @if ($index > 0)
                            <button type="button" class="remove-subtitle-btn">Remove</button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-lg-offset-3 pull-right">
                    <button type="button" id="add-subtitle-btn" class="btn btn-lg btn-primary">Add Subtitle</button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-offset-3 pull-right">
                    <button id="add_files" style="background-color: orange;" class="btn btn-lg btn-primary" type="submit">Update Book</button>
                </div>
            </div>
        </form>

        <div class="col-lg-offset-3 pull-right">
            <a href="{{ route('admin.editQuiz', $quiz->id) }}" style="text-decoration: none;">
                <button style="background-color: green;" class="btn btn-lg btn-primary">Edit Quiz</button>
            </a>
        </div>

        <hr>
        <form class="delete-form" method="POST" action="{{ route('flipbook.destroy',$flipbook->id) }}" >
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="delete" />
            <button class="btn btn-lg btn-danger" type="submit">Delete Book</button>
        </form>
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
        // Handle form submission with SweetAlert confirmation
        $('form.register-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = this; // Reference to the form element

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save the changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                willOpen: () => {
                    // Add an ID to the confirm button
                    $('.swal2-confirm').attr('id', 'swalSaveButton');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Optionally, you can handle the click event here
                    $('#swalSaveButton').on('click', function() {
                        console.log('Save button clicked');
                    });

                    // Show the loader
                    $('#gifLoader').removeClass('d-none');

                    // Submit the form via AJAX or normal submission
                    // For AJAX submission, use the following code
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Hide loader after AJAX call
                            $('#gifLoader').addClass('d-none');

                            // Show SweetAlert success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Book updated successfully!',
                                text: 'Your changes have been saved.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '{{ route('flipbook.index') }}'; // Redirect after success
                            });

                            // Reset the form
                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            // Hide loader in case of error
                            $('#gifLoader').addClass('d-none');

                            // Show SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an issue updating the book. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });




        var counter = 0;
        $("#add_question").on('click', function() {
            counter++;
            $("#counter").val(counter);

            // HTML for a new quiz question
            var newQuestion = '<div class="quiz_question">' +
                '<label for="quiz_question_' + counter + '">Quiz Question ' + counter + ':</label>' +
                '<input type="text" id="quiz_question_' + counter + '" name="quiz_question[]" >' +

                '<div>' +
                '<label for="option_a_' + counter + '">Option A:</label>' +
                '<input type="text" id="option_a_' + counter + '" name="option_a[]" >' +
                '</div>' +

                '<div>' +
                '<label for="option_b_' + counter + '">Option B:</label>' +
                '<input type="text" id="option_b_' + counter + '" name="option_b[]" >' +
                '</div>' +

                '<div>' +
                '<label for="option_c_' + counter + '">Option C:</label>' +
                '<input type="text" id="option_c_' + counter + '" name="option_c[]" >' +
                '</div>' +

                '<div>' +
                '<label for="option_d_' + counter + '">Option D:</label>' +
                '<input type="text" id="option_d_' + counter + '" name="option_d[]" >' +
                '</div>' +

                '<div>' +
                '<label for="correct_answer_' + counter + '">Correct Answer:</label>' +
                '<input type="text" id="correct_answer_' + counter + '" name="correct_answer[]" >' +
                '</div>' +
                '</div>';

            // Append the new quiz question to the container
            $("#quiz_questions").append(newQuestion);
            if (counter === 1) {
                $("#quiz_questions").show();
            }
        });

        // Handle delete button with SweetAlert confirmation
        $('form.delete-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const deleteForm = this; // Reference to the form element

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                willOpen: () => {
                    // Add an ID to the confirm button
                    $('.swal2-confirm').attr('id', 'swalDeleteButton');
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Optionally, you can handle the click event here
                    $('#swalDeleteButton').on('click', function() {
                        console.log('Delete button clicked');
                    });

                    // Submit the delete form
                    $(deleteForm).off('submit').submit();
                }
            });
        });
    });
</script>
<script>
 document.getElementById('add-subtitle-btn').addEventListener('click', function () {
    var subtitleGroup = document.createElement('div');
    subtitleGroup.classList.add('subtitle-group');
    var subtitleIndex = document.querySelectorAll('.subtitle-group').length; // Find the new index

    subtitleGroup.innerHTML = `
        <label for="subtitles[${subtitleIndex}]">Subtitle ${subtitleIndex + 1}</label>
        <input class="input-block-level" type="text" name="subtitles[${subtitleIndex}]" placeholder="Subtitle ${subtitleIndex + 1}">
        <button type="button" class="remove-subtitle-btn">Remove</button>
    `;

    // Append to the subtitles container
    document.querySelector('.subtitles-container').appendChild(subtitleGroup);
});

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-subtitle-btn')) {
        e.target.parentElement.remove();
    }
});


</script>

</body>
</html>
