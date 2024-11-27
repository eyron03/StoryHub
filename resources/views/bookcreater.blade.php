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
        <h1>Create Books & Questions</h1>
    </div>

    <div id="gifLoader" class="text-center mb-3 d-none justify-content-center min-vh-100"></div>

    <form id="bookForm" class="register-form" method="POST" action="{{ route('flipbookstore') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <label><span class="required">*</span> Book Title</label>
            </div>
            <div class="col-lg-9">
                <input class="input-block-level" type="text" placeholder="* Book Title" name="book_name" required>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label><span class="required">*</span> Book Description</label>
            </div>
            <div class="col-lg-9">
                <input class="input-block-level" type="text" placeholder="* Book Desc" name="desc" required>
            </div>
        </div>

        <div id="browse_file">
            <div class="image-subtitle-pair">
                <div class="row">
                    <div class="col-lg-3">
                        <label><span class="required">*</span> Select Image</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="file" name="images[]" required multiple />
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label>Subtitle for Page 1</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" name="subtitles[]" placeholder="Enter subtitle for Page 1" />
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <button type="button" id="add-more-pages" class="btn btn-secondary">Add More Pages</button>
        <div class="row">
            <div class="col-lg-offset-3 pull-right">
                <button id="add_files" class="btn btn-lg btn-primary" type="submit">Next: Create Quiz</button>
            </div>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Counter for page numbering
    let pageCount = 1;

    document.getElementById('add-more-pages').addEventListener('click', function () {
        pageCount++;

        // New pair of image and subtitle fields
        const pair = `
            <div class="image-subtitle-pair">

                <div class="row">
                    <div class="col-lg-3">
                        <label>Subtitle for Page ${pageCount}</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" name="subtitles[]" placeholder="Enter subtitle for Page ${pageCount}" />
                    </div>
                </div>
                <hr>
            </div>
        `;

        // Append to the container
        document.getElementById('browse_file').insertAdjacentHTML('beforeend', pair);
    });
</script>
</body>
</html>
