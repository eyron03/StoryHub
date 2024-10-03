<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storyhub</title>
    <link rel="icon" href="{{ asset('book\icon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="img/favicon.ico" rel="icon">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
  
</head>
<body>
<div class="all">
    <div class="header d-flex justify-content-between align-items-center fixed-top">
        <a href="{{ route('admin.parentDashboard') }}" style="text-decoration: none;" class="d-flex align-items-center">
            <h1 class="m-0 text-primary text-orange"><i class="fa fa-book-reader me-3"></i>StoryHub</h1>
        </a>
        <div class="dropdown-center">
            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span style="font-weight:bold;" class="name">Admin</span>
            </div>
            <ul class="dropdown-menu">
                <li class="text-center"><a class="dropdown-item" href="settings" style="text-decoration: none; color:black;">Account Settings</a></li>
                <li class="text-center"><hr class="dropdown-divider"></li>
                <li class="text-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            <i class="fas {{ Request::is('books') ? 'fa-book-open' : 'fa-book' }} icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="teacher" style="background-color: #fcfbe8;">
            <i class="fas {{ Request::is('teacher') ? 'fa-chalkboard-teacher-open' : 'fa-chalkboard-teacher' }} icon-space"></i> Teachers
        </a>
        <a class="sidebarimage img-fluid" href="parent" >
            <i class="fas {{ Request::is('parent') ? 'fa-user-friends-open' : 'fa-user-friends' }} icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="children" >
            <i class="fas fa-users icon-space"></i>  Childrens
        </a>
        <a class="sidebarimage img-fluid" href="reports" >
            <i class="fas {{ Request::is('reports') ? 'fa-file-alt-open' : 'fa-file-alt' }} icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progress" >
            <i class="fas {{ Request::is('progress') ? 'fa-chart-line-open' : 'fa-chart-line' }} icon-space"></i> Progress
        </a>
        <a class="sidebarimage img-fluid" href="logs">
            <i class="fas {{ Request::is('logs') ? 'fa-clipboard-list' : 'fa-clipboard' }} icon-space"></i> Logs
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


          <br>
                <h1 style="text-align: center;">All Teachers Information</h1>
                 <br>
        <button class="btn btn-primary btn-sm" onclick="openAddTeacherModal()">Add Teacher</button>
        <br> <br>
      <form action="{{ route('admin.teacherDashboard') }}" method="GET">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 input-group">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by Teacher name..." value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>


  
<div class="table-responsive">
    <table id="teacherTable" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Grade Level</th> <!-- Add this line -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($teachers) > 0)
                @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->id }}</td>
                    <td>{{ $teacher->TeacherFirstName }}</td>
                    <td>{{ $teacher->TeacherLastName }}</td>
                    <td>{{ $teacher->TeacherAge }}</td>
                    <td>{{ $teacher->TeacherDob }}</td>
                    <td>{{ $teacher->TeacherAddress }}</td>
                    <td>{{ $teacher->TeacherGender }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->gradeLevel->GradeLvl ?? 'N/A' }}</td> <!-- Display Grade Level -->
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary btn-sm me-1" onclick="viewTeacher({{ $teacher->id }})">View</button>
                            <button type="button" class="btn btn-primary btn-sm me-1" onclick="editTeacher({{ $teacher->id }})">Edit</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                            <tr>
                                <td colspan="10" class="text-center">No data found</td>
                            </tr>
            @endif
        </tbody>
        
    </div>
    </table>
</div>
 <div class="mt-4 pagination-wrapper d-flex justify-content-center">
           {{ $teachers->appends(['search' => $search])->links() }}
        </div>

    

        <!-- View Teacher Modal -->
        <div class="modal fade" id="viewTeacherModal" tabindex="-1" aria-labelledby="viewTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewTeacherModalLabel">View Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Teacher information will be loaded here -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6>First Name:</h6>
                                <p id="viewTeacherFname"></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Last Name:</h6>
                                <p id="viewTeacherLname"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Age:</h6>
                                <p id="viewTeacherAge"></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Date of Birth:</h6>
                                <p id="viewTeacherDob"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Address:</h6>
                                <p id="viewTeacherAddress"></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Gender:</h6>
                                <p id="viewTeacherGender"></p>
                            </div>
                             <div class="col-md-6">
                                <h6>GradeLevel:</h6>
                                <p id="viewTeacherGradeLevel"></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Email:</h6>
                                <p id="viewTeacherEmail"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeacherModalLabel">Add Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.addTeacher') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="usertype" value="teacher">
                    
                            <div class="form-group">
                    <label for="TeacherFirstName">First Name</label>
                    <input type="text" class="form-control" id="TeacherFirstName" name="TeacherFirstName" placeholder="Enter First Name" required>
                    <div class="invalid-feedback">Please enter the first name.</div>
                </div>

                <div class="form-group">
                    <label for="TeacherLastName">Last Name</label>
                    <input type="text" class="form-control" id="TeacherLastName" name="TeacherLastName" placeholder="Enter Last Name" required>
                    <div class="invalid-feedback">Please enter the last name.</div>
                </div>

                <div class="form-group">
                    <label for="TeacherDob">Date of Birth</label>
                    <input type="date" class="form-control" id="TeacherDob" name="TeacherDob" required>
                    <div class="invalid-feedback">Please enter the date of birth.</div>
                </div>

                <div class="form-group">
                    <label for="TeacherAddress">Address</label>
                    <input type="text" class="form-control" id="TeacherAddress" name="TeacherAddress" placeholder="Enter Address" required>
                    <div class="invalid-feedback">Please enter the address.</div>
                </div>

                <div class="form-group">
                    <label for="TeacherGender">Gender</label>
                    <select class="form-select" id="TeacherGender" name="TeacherGender" required>
                        <option value="" disabled selected>Select Gender...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="invalid-feedback">Please select a gender.</div>
                </div>

                <div class="form-group">
                    <label for="grade_level" class="form-label">Grade Level:</label>
                    <select class="form-select" id="grade_level" name="GradeLvl" required>
                        <option value="" disabled selected>Select Grade Level...</option>
                        <option value="Grade 1-A">Grade 1-A</option>
                        <option value="Grade 1-B">Grade 1-B</option>
                        <option value="Grade 2-A">Grade 2-A</option>
                        <option value="Grade 2-B">Grade 2-B</option>
                        <option value="Grade 3-A">Grade 3-A</option>
                        <option value="Grade 3-B">Grade 3-B</option>
                        <option value="Grade 4-A">Grade 4-A</option>
                        <option value="Grade 4-B">Grade 4-B</option>
                    </select>
                    <div class="invalid-feedback">Please select a grade level.</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="cursor: pointer;">📗</button>
                    </div>
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmNewPassword" style="cursor: pointer;">📗</button>
                    </div>
                    <div class="invalid-feedback" id="password-match-error">Passwords do not match.</div>
                </div>


                    
                    <br>
                    <button type="submit" class="btn btn-primary">Add Teacher</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Edit Teacher Modal -->
        <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeacherModalLabel">Edit Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTeacherForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="editTeacherFirstName">First Name</label>
                                <input type="text" class="form-control" id="editTeacherFirstName" name="TeacherFirstName" required>
                            </div>
                            <div class="form-group">
                                <label for="editTeacherLastName">Last Name</label>
                                <input type="text" class="form-control" id="editTeacherLastName" name="TeacherLastName" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="editTeacherDob">Date of Birth</label>
                                <input type="date" class="form-control" id="editTeacherDob" name="TeacherDob" required>
                            </div>
                            <div class="form-group">
                                <label for="editTeacherAddress">Address</label>
                                <input type="text" class="form-control" id="editTeacherAddress" name="TeacherAddress" required>
                            </div>
                            <div class="form-group">
                                <label for="editTeacherGender">Gender</label>
                                <select class="form-select" id="editTeacherGender" name="TeacherGender" required>
                                  
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                  
                                </select>
                            </div>
                                    <div class="form-group">
                                <label for="editGradeLevel">Grade Level</label>
                                <select class="form-select" id="editGradeLevel" name="GradeLvl" required>
                                    <option value="" >Select Grade Level...</option>
                                    <option value="Grade 1-A">Grade 1-A</option>
                                    <option value="Grade 1-B">Grade 1-B</option>
                                    <option value="Grade 2-A">Grade 2-A</option>
                                    <option value="Grade 2-B">Grade 2-B</option>
                                    <option value="Grade 3-A">Grade 3-A</option>
                                    <option value="Grade 3-B">Grade 3-B</option>
                                    <option value="Grade 4-A">Grade 4-A</option>
                                    <option value="Grade 4-B">Grade 4-B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editTeacherEmail">Email</label>
                                <input type="email" class="form-control" id="editTeacherEmail" name="email" required>
                            </div>
                              <br>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
 <script src="{{ asset('js/showPassword.js') }}"></script>
        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
      
     
<!-- Bootstrap JS and dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function openAddTeacherModal() {
        console.log("Opening Add Teacher Modal"); // Check if the function is called
        $('#addTeacherModal').modal('show');
    }

    function search() {
        var input = document.getElementById("searchInput").value.toUpperCase();
        var table = document.getElementById("teacherTable");
        var rows = table.getElementsByTagName("tr");
        var found = false;

        for (var i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            var cells = rows[i].getElementsByTagName("td");
            var idCell = cells[0]; // Assuming ID is in the first column
            var firstNameCell = cells[1]; // Assuming First Name is in the second column
            var lastNameCell = cells[2]; // Assuming Last Name is in the third column
            var match = false;

            if (idCell && idCell.innerHTML.toUpperCase().indexOf(input) > -1) {
                match = true;
            }
            if (firstNameCell && firstNameCell.innerHTML.toUpperCase().indexOf(input) > -1) {
                match = true;
            }
            if (lastNameCell && lastNameCell.innerHTML.toUpperCase().indexOf(input) > -1) {
                match = true;
            }

            if (match) {
                rows[i].style.display = "";
                found = true;
            } else {
                rows[i].style.display = "none";
            }
        }

        document.getElementById("notFoundMessage").style.display = found ? "none" : "block";
    }

    function viewTeacher(teacherId) {
        var teacher = {!! json_encode($teachers->keyBy('id')) !!}[teacherId];
        
        if (teacher) {
            $('#viewTeacherFname').text(teacher.TeacherFirstName);
            $('#viewTeacherLname').text(teacher.TeacherLastName);
            $('#viewTeacherAge').text(teacher.TeacherAge);
            $('#viewTeacherDob').text(teacher.TeacherDob);
            $('#viewTeacherAddress').text(teacher.TeacherAddress);
            $('#viewTeacherGender').text(teacher.TeacherGender);
            $('#viewTeacherEmail').
            text(teacher.email);
            $('#viewTeacherModal').modal('show');
        }
    }

    function editTeacher(teacherId) {
        var teacher = {!! json_encode($teachers->keyBy('id')) !!}[teacherId];
        
        if (teacher) {
            $('#editTeacherFirstName').val(teacher.TeacherFirstName);
            $('#editTeacherLastName').val(teacher.TeacherLastName);
         
            $('#editTeacherDob').val(teacher.TeacherDob);
            $('#editTeacherAddress').val(teacher.TeacherAddress);
            $('#editTeacherGender').val(teacher.TeacherGender);
            $('#editTeacherEmail').val(teacher.email);
            $('#editTeacherForm').attr('action', '/teacher/' + teacherId);
            $('#editTeacherModal').modal('show');
        }
    }

  
</script>

<script>
    var teachers = {!! json_encode($teachers->mapWithKeys(function($teacher) {
        return [
            $teacher->id => [
                'TeacherFirstName' => $teacher->TeacherFirstName,
                'TeacherLastName' => $teacher->TeacherLastName,
               
                'TeacherDob' => $teacher->TeacherDob,
                'TeacherAddress' => $teacher->TeacherAddress,
                'TeacherGender' => $teacher->TeacherGender,
                'TeacherGradeLevel' => $teacher->gradeLevel ? $teacher->gradeLevel->GradeLvl : 'N/A',
                'TeacherGradeLevelId' => $teacher->gradeLevel ? $teacher->gradeLevel->id : null,
                'email' => $teacher->email
            ]
        ];
    })) !!};

    function viewTeacher(teacherId) {
        var teacher = teachers[teacherId];
        
        if (teacher) {
            $('#viewTeacherFname').text(teacher.TeacherFirstName);
            $('#viewTeacherLname').text(teacher.TeacherLastName);
            $('#viewTeacherAge').text(teacher.TeacherAge);
            $('#viewTeacherDob').text(teacher.TeacherDob);
            $('#viewTeacherAddress').text(teacher.TeacherAddress);
            $('#viewTeacherGender').text(teacher.TeacherGender);
            $('#viewTeacherGradeLevel').text(teacher.TeacherGradeLevel);
            $('#viewTeacherEmail').text(teacher.email);

            // Access the gradeLevel_id
            console.log('Grade Level ID:', teacher.TeacherGradeLevelId);

            $('#viewTeacherModal').modal('show');
        }
    }
</script>
@if(session('success'))
    <script>
        // Display the success message using SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}'
        });
    </script>
@endif
<script>
   
    (function () {
        'use strict'

       
        var forms = document.querySelectorAll('.needs-validation')

      
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
       
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function (event) {
         
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordMatchError = document.getElementById('password-match-error');
            
           
            if (password.value !== passwordConfirmation.value) {
                
                event.preventDefault();
                event.stopPropagation();
                
                
                passwordConfirmation.classList.add('is-invalid');
                passwordMatchError.style.display = 'block';
            } else {
            
                passwordConfirmation.classList.remove('is-invalid');
                passwordMatchError.style.display = 'none';
            }
            
          
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
</script>

</body>
</html>

