<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">

    <!--Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Dosis&family=Gajraj+One&family=Madimi+One&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Hammersmith+One&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .settings-options {
            display: flex;
            flex-direction: column;
        }
        .option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .option i {
            font-size: 24px;
            margin-right: 10px;
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
        <a href="dashboard" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @foreach ($teachers as $teacherName)
                    {{ $teacherName }}
                @endforeach
            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>
                <li class="text-center">
                    <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('teacher.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

 
    <div class="sidebar">
        <a class="sidebarimage img-fluid" href="dashboard" >
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books">
            <i class="fas fa-book icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="parent">
            <i class="fas fa-user-friends icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="pupils">
            <i class="fas fa-users icon-space"></i> Pupils
        </a>
        <a class="sidebarimage img-fluid" href="reports">
            <i class="fas fa-file-alt icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progressReports">
            <i class="fas fa-chart-line icon-space"></i> Progress
        </a>
    </div>
    

    <div class="content">
              
<div class="container mt-4">
    <div class="row">
        <div class="col d-flex justify-content-end align-items-center">
            <div class="d-flex flex-column align-items-end">
                <p style="font-size: 14px; color: rgb(119, 119, 119); margin-bottom: 0; font-weight: bold;">Today's Date</p>
                <p class="heading-sub12 bold-text" style="margin-bottom: 0;">{{ $today }}</p>
            </div>
            <i class="fa fa-calendar" style="font-size: 24px; margin-left: 10px;"></i>
        </div>
    </div>
</div>


        <h1>Teacher Settings</h1>
        <br>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="settings-options">
            <div class="option" data-toggle="modal" data-target="#personalInfoModal">
                <i class="fas fa-user-edit"></i>
                <span>Personal Information</span>
            </div>
            <div class="option" data-toggle="modal" data-target="#changePasswordModal">
                <i class="fas fa-key"></i>
                <span>Change Password</span>
            </div>
        </div>
    </div>

    {{-- Personal Information Modal --}}
    <div class="modal fade" id="personalInfoModal" tabindex="-1" role="dialog" aria-labelledby="personalInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personalInfoModalLabel">Edit Personal Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($teacher)
                    <form action="{{ route('teacher.updateInfo') }}" method="POST">
                        @csrf
                       

                        <div class="form-group">
                            <label for="TeacherFirstName">First Name</label>
                            <input type="text" class="form-control" id="TeacherFirstName" name="TeacherFirstName" value="{{ old('TeacherFirstName', $teacher->TeacherFirstName) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="TeacherLastName">Last Name</label>
                            <input type="text" class="form-control" id="TeacherLastName" name="TeacherLastName" value="{{ old('TeacherLastName', $teacher->TeacherLastName) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="TeacherAge">Age</label>
                            <input type="number" class="form-control" id="TeacherAge" name="TeacherAge" value="{{ old('TeacherAge', $teacher->TeacherAge) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="TeacherDob">Date of Birth</label>
                            <input type="date" class="form-control" id="TeacherDob" name="TeacherDob" value="{{ old('TeacherDob', $teacher->TeacherDob) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="TeacherAddress">Address</label>
                            <input type="text" class="form-control" id="TeacherAddress" name="TeacherAddress" value="{{ old('TeacherAddress', $teacher->TeacherAddress) }}" required>
                        </div>

                       
    <div class="form-group">
        <label for="TeacherGender">Gender</label>
        <select class="form-control" id="TeacherGender" name="TeacherGender" required>
            <option value="Male" {{ old('TeacherGender', $teacher->TeacherGender) == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('TeacherGender', $teacher->TeacherGender) == 'Female' ? 'selected' : '' }}>Female</option>
          
        </select>
    </div>
                       
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $teacher->email) }}" required>
                        </div>
        
                        <br>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                    @else
                    <p>Teacher information not available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Modal --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('teacher.changePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current Password" required>
                                <button type="button" class="btn btn-outline-secondary" id="toggleCurrentPassword" style="cursor: pointer;">📗</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password" required>
                                <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword" style="cursor: pointer;">📗</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm Password" required>
                                <button type="button" class="btn btn-outline-secondary" id="toggleConfirmNewPassword" style="cursor: pointer;">📗</button>
                            </div>
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/settingsShowPassword.js') }}"></script>
<!-- Bootstrap JS and dependencies -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>