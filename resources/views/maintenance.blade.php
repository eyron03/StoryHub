<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryHub | Under Maintenance</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <!-- Google Web Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
   
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
 <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    
  
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /*header*/
.header{
    background: #fcfbe8;
    box-shadow: 0px 0px 3px black;
    color:black;
    padding: 10px;
    padding-left: 30px;
    padding-right: 30px;
}

.title{
    font-family: "Madimi One", sans-serif;
    font-size:28px;
    margin-left: 10px;
    text-decoration: none;
    color:black;

}
        body {
            font-family: "Hammersmith One", sans-serif;
            background-color: #fcfbe8 !important;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
           
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #ff6f61;
        }
        p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
        }
        .logo {
            margin-bottom: -40px;
        }
        .logo img {
            max-width: 150px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ff6f61;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .footer {
            font-size: 0.9rem;
            color: #999;
            margin-top: 20px;
        }
        .footer a {
            color: #ff6f61;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="dashboard" style="text-decoration: none;"class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>

        </a>
    </div>
  
    <div class="container">
        <div class="logo">
            <img src="{{ asset('book/bookloader.gif') }}" alt="StoryHub Logo">
        </div>
        <h1>StoryHub is Under Maintenance</h1>
        <p>We are currently working on improving your experience. Please bear with us, and we'll be back online soon!</p>
        <div class="spinner"></div>
<p class="footer">Need assistance? <a href="https://mail.google.com/mail/?view=cm&fs=1&to=storyhubcalasiao8@gmail.com" target="_blank">Contact Support</a></p>

    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
