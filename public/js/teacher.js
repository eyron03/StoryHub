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
        $('#editTeacherAge').val(teacher.TeacherAge);
        $('#editTeacherDob').val(teacher.TeacherDob);
        $('#editTeacherAddress').val(teacher.TeacherAddress);
        $('#editTeacherGender').val(teacher.TeacherGender);
        $('#editTeacherEmail').val(teacher.email);
        $('#editTeacherForm').attr('action', '/teacher/' + teacherId);
        $('#editTeacherModal').modal('show');
    }
}

var teachers = {!! json_encode($teachers->mapWithKeys(function($teacher) {
    return [
        $teacher->id => [
            'TeacherFirstName' => $teacher->TeacherFirstName,
            'TeacherLastName' => $teacher->TeacherLastName,
            'TeacherAge' => $teacher->TeacherAge,
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