<html>
	<head>
		<meta charset="utf-8" />
		<title>Create Your Flip Book</title>

        <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
 <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstraps.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/starter-template.css') }}" rel="stylesheet">


    <link href="{{ asset('css/bootstraps.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	</head>
	<body>

 <div class="container">
 <div class="starter-template">
         <h1>Create quiz</h1>

       </div>

        <form method="POST" action="{{ route('quizzes.store') }}">
            @csrf

            <div>
                <label for="quiz_question">Quiz Question:</label>
                <input type="text" id="quiz_question" name="quiz_question" required>
            </div>

            <div>
                <label for="option_a">Option A:</label>
                <input type="text" id="option_a" name="option_a" required>
            </div>

            <div>
                <label for="option_b">Option B:</label>
                <input type="text" id="option_b" name="option_b" required>
            </div>

            <div>
                <label for="option_c">Option C:</label>
                <input type="text" id="option_c" name="option_c" required>
            </div>

            <div>
                <label for="option_d">Option D:</label>
                <input type="text" id="option_d" name="option_d" required>
            </div>

            <div>
                <label for="correct_answer">Correct Answer:</label>
                <input type="text" id="correct_answer" name="correct_answer" required>
            </div>

            <div>
                <input type="hidden" id="book_id" name="book_id" value="{{ $bookId }}">
            </div>




        <div class="row">
            <div class="col-lg-offset-3 pull-right">
                <button id="add_files"  class="btn btn-lg btn-primary" type="submit">Create Quiz</button>
            </div>
        </div>
    </form>

                                                                   </div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
                              <script src="{{ asset('js/bootstrap.min.js') }}"></script>
                              <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                              <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>

</body>

<script type="text/javascript">


</script>
</html>

