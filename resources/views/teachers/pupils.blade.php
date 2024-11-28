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

    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/parents.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paginate.css') }}" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>



        .no-children-message {
            font-style: italic;
            color: #6c757d;
        }
        .datalist-wrapper {
            position: relative;
            width: 100%;
        }
        .datalist-options {
            border: 1px solid #ddd;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            position: absolute;
            top: calc(100% + 2px); /* Adjusted to ensure it appears below the input */
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: none; /* Hidden by default */
        }
        .datalist-options div {
            padding: 8px 12px;
            cursor: pointer;
        }
        .datalist-options div:hover {
            background-color: #f1f1f1;
        }
        .datalist-input {
            position: relative;
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
        <a href="#" style="text-decoration: none;"class="d-flex align-items-center">
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
        <a class="sidebarimage img-fluid" href="dashboard">
            <i class="fas fa-tachometer-alt icon-space"></i> Dashboard
        </a>
        <a class="sidebarimage img-fluid" href="books"  >
            <i class="fas fa-book icon-space"></i> Books
        </a>
        <a class="sidebarimage img-fluid" href="parent" >
            <i class="fas fa-user-friends icon-space"></i> Parents
        </a>
        <a class="sidebarimage img-fluid" href="pupils" style="background-color: #fcfbe8;">
            <i class="fas fa-users icon-space"></i> Pupils
        </a>
        <a class="sidebarimage img-fluid" href="reports">
            <i class="fas fa-file-alt icon-space"></i> Reports
        </a>
        <a class="sidebarimage img-fluid" href="progressReports" >
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


        <br>
                <h1 style="text-align: center;">My Pupils Information</h1>
                 <br>
                 <form action="{{ route('teachers.pupils') }}" method="GET">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 input-group">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search Pupil ID or Name...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>

<div class="d-flex ">
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addChildModal">
        Add Pupils
    </button>
<form id="removeAllForm" action="{{ route('children.removeAllFromGradeLevels') }}" method="POST">
    @csrf
    <button type="button" class="btn btn-danger btn-sm ms-2" id="removeAllButton">Remove All</button>
</form>
</div>


        <br>
        <div class="table-responsive">
            <table id="pupilsTable" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Address</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Grade Level</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($assignedChildren->isNotEmpty())
                        @foreach($assignedChildren as $child)
                            <tr>
                                 <td>{{ $child->custom_id }}</td>
                                <td>{{ $child->childFirstName }}</td>
                                <td>{{ $child->childLastName }}</td>
                                <td>{{ $child->childAge }}</td>
                                <td>{{ $child->childDob }}</td>
                                <td>{{ $child->childAddress }}</td>
                                <td>{{ $child->childGender }}</td>
                                <td>{{ $child->gradeLevel->first()->GradeLvl }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary me-1" onclick="editChild({{ $child->id }})">Edit</button>

                                       <form action="{{ route('teacher.removeFromGradeLevel', $child->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                           <button type="button" class="btn btn-danger btn-sm" onclick="removeChildFromGradeLevel({{ $child->id }})">Remove</button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                             <td colspan="9" class="text-center">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
         <div class="d-flex justify-content-center">
        {{ $assignedChildren->appends(['search' => $search])->links() }}
        </div>
                <!-- Edit Child Modal -->
       <div class="modal fade" id="editChildModal" tabindex="-1" aria-labelledby="editChildModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChildModalLabel">Edit Child</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Child information editing form -->
                        <form id="editChildForm" action="{{ route('teacher.updatePupil') }}" method="post">
                            @csrf
                            <input type="hidden" name="childId" id="editChildId">
                            <div class="mb-3">
                                <label for="editChildFirstName" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="editChildFirstName" name="childFirstName">
                            </div>
                            <div class="mb-3">
                                <label for="editChildLastName" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="editChildLastName" name="childLastName">
                            </div>

                                        <div class="mb-3">
                                    <label for="editChildDob" class="form-label">Date of Birth:</label>
                                    <input type="date" class="form-control" id="editChildDob" name="childDob">
                                </div>

                            <div class="mb-3">
                                <label for="editChildAddress" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="editChildAddress" name="childAddress">
                            </div>
                            <label for="editChildGender" class="form-label">Gender:</label>
                    <select class="form-select" id="editChildGender" name="childGender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <br>


                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addChildModalLabel">Add Pupil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('pupils.store') }}">
                        @csrf

                        <!-- Step 1: Child Details -->
                        <div id="childForm" class="p-4">
                            <div class="mb-3">
                                <label for="childFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="childFirstName" name="childFirstName" required>
                            </div>

                            <div class="mb-3">
                                <label for="childLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="childLastName" name="childLastName" required>
                            </div>


                            <div class="mb-3">
                                <label for="childDob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="childDob" name="childDob" required onchange="calculateAge()">
                            </div>

                            <div class="mb-3">
                                <label for="childAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="childAddress" name="childAddress" required>
                            </div>

                            <div class="mb-3">
                                <label for="childGender" class="form-label">Gender</label>
                                <select class="form-select" id="childGender" name="childGender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                        </div>

                        <!-- Step 2: Parent Details -->
                        <div id="parentForm" class="p-4" style="display: none;">
                            <div class="mb-3">
                                <label for="parentExist" class="form-label">Does the parent exist?</label>
                                <select class="form-select" id="parentExist" name="parentExist" onchange="toggleParentFields(this.value)" required>
                                    <option value="">Select...</option>
                                    <option value="existing">Select Existing Parent</option>
                                    <option value="new">Create New Parent</option>
                                </select>
                            </div>

                            <!-- Existing Parent Selection -->
                            <div id="existingParent" class="mb-3" style="display: none;">
                                <label for="parent_id" class="form-label">Parent</label>
                                <select class="form-select" id="selectParent" name="parent_id">
                                    <option value="">-- Select Parent --</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->pFname }} {{ $parent->pLname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- New Parent Form -->
                            <div id="newParent" class="mb-3" style="display: none;">
                                <div class="mb-3">
                                    <label for="parentFirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="parentFirstName" name="parentFirstName" required>
                                </div>

                                <div class="mb-3">
                                    <label for="parentLastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="parentLastName" name="parentLastName" required>
                                </div>

                                <div class="mb-3">
                                    <label for="parentEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="parentEmail" name="parentEmail" required>
                                </div>

                                <div class="mb-3">
                                    <label for="parentPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="parentPassword" name="parentPassword" required>
                                </div>

                                <div class="mb-3">
                                    <label for="parentDob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="parentDob" name="parentDob" required onchange="calculateParentAge()">
                                </div>
                                <div class="mb-3">
                                    <label for="parentAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="parentAddress" name="parentAddress" required>
                                </div>
                                <div class="mb-3">
                                    <label for="parentGender" class="form-label">Gender</label>
                                    <select class="form-select" id="parentGender" name="parentGender" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Save Pupil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
        </div>

    </div>

</div>


<script>
    document.getElementById('nextButton').addEventListener('click', function() {
        document.getElementById('childForm').style.display = 'none';
        document.getElementById('parentForm').style.display = 'block';
    });

    function toggleParentFields(value) {
    const existingParentFields = document.getElementById('existingParent');
    const newParentFields = document.getElementById('newParent');

    const newParentInputs = newParentFields.querySelectorAll('input, select');

    if (value === 'existing') {
        existingParentFields.style.display = 'block';
        newParentFields.style.display = 'none';

        newParentInputs.forEach((input) => {
            input.required = false; // Disable required attribute
        });
    } else if (value === 'new') {
        existingParentFields.style.display = 'none';
        newParentFields.style.display = 'block';

        newParentInputs.forEach((input) => {
            input.required = true; // Enable required attribute
        });
    } else {
        existingParentFields.style.display = 'none';
        newParentFields.style.display = 'none';

        newParentInputs.forEach((input) => {
            input.required = false; // Reset required attribute
        });
    }


    }

    // Calculate child's age based on date of birth
    function calculateAge() {
        var dob = document.getElementById('childDob').value;
        var age = new Date().getFullYear() - new Date(dob).getFullYear();
        document.getElementById('childAge').value = age;
    }

    // Calculate parent's age based on date of birth
    function calculateParentAge() {
        var dob = document.getElementById('parentDob').value;
        var age = new Date().getFullYear() - new Date(dob).getFullYear();
        // You can use the age in the controller when the parent is created
    }
</script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<script>
function removeChildFromGradeLevel(childId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/teacher/remove-from-gradelevel/' + childId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        // Reload the page after the success message disappears
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error || 'An error occurred while removing the child.',
                    });
                }
            });
        }
    });
}
</script>

<script>
 function editChild(childId) {
    $.ajax({
        url: '/teacher/pupils/' + childId,
        type: 'GET',
        success: function(data) {
            $('#editChildId').val(data.id);
            $('#editChildFirstName').val(data.childFirstName);
            $('#editChildLastName').val(data.childLastName);
            $('#editChildAge').val(data.childAge);
            $('#editChildDob').val(data.childDob);
            $('#editChildAddress').val(data.childAddress);

            // Set the selected value for the gender dropdown manually
            $('#editChildGender option').each(function() {
                if ($(this).val().toLowerCase() == data.childGender.toLowerCase()) {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });

            $('#editChildModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error);
            console.log('Response Text: ', xhr.responseText);
        }
    });
}
$(document).ready(function () {
    $('#editChildForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = $(this).serialize(); // Serialize the form data

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Child information has been updated.',
                    icon: 'success',
                    showConfirmButton: false, // Hide the OK button
                    timer: 1500 // Automatically close the alert after 1.5 seconds
                });

                // Close the modal and reload the page after the alert
                setTimeout(function () {
                    $('#editChildModal').modal('hide');
                    window.location.reload();
                }, 1500);
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was a problem updating the child\'s information.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});



</script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
<script>
    document.getElementById('removeAllButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will remove all children from their grade levels!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove them!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('removeAllForm').submit();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var spinner = document.getElementById("spinner");
        spinner.classList.add("d-none");
      });
</script>
</body>
</html>
