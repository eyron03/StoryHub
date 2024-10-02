
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#addParentModal form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Perform client-side validation
        const inputs = form.querySelectorAll('input, select');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // Check if passwords match
        const password = form.querySelector('#password').value;
        const confirmPassword = form.querySelector('#password_confirmation').value;
        if (password !== confirmPassword) {
            isValid = false;
            const confirmPasswordInput = form.querySelector('#password_confirmation');
            confirmPasswordInput.classList.add('is-invalid');
            Swal.fire({
                icon: 'error',
                title: 'Passwords Do Not Match',
                text: 'Please make sure the passwords match.'
            });
        }

        if (!isValid) {
            return;
        }

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Added!',
                    text: 'You have successfully added parent account.',
                    showConfirmButton: true, // Show the OK button
                   
                   
                    allowOutsideClick: false // Prevent closing by clicking outside the modal
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        // Reload the page
                        location.reload();
                    }
                });
                form.reset(); // Optionally reset the form after successful submission
            } else {
                throw new Error('Registration failed');
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: error.message || 'An error occurred during registration.'
            });
        });
    });
});


(function () {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
})();


function viewParent(parentId) {
    $.ajax({
        url: '/admin/parent/' + parentId,
        type: 'GET',
        success: function(response) {
            // Update the modal content with the received parent information
            $('#viewParentFname').text(response.pFname);
            $('#viewParentLname').text(response.pLname);
            $('#viewParentAge').text(response.pAge);
            $('#viewParentDob').text(response.pDob);
            $('#viewParentAddress').text(response.pAddress);
            $('#viewParentGender').text(response.pGender);
            $('#viewParentEmail').text(response.email);
            $('#viewChildrenName').text(response.childName);

   // Update children names
   let childrenNamesHtml = '';
   response.childrenNames.forEach(function(childName) {
       childrenNamesHtml += '<p>' + childName + '</p>';
   });
   $('#viewChildrenName').html('<p>' + childrenNamesHtml + '</p>');

            // Show the modal
            $('#viewParentModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function editParent(parentId) {
    $.ajax({
        url: '/admin/parent/' + parentId + '/edit',
        type: 'GET',
        success: function(response) {
            // Update modal content with parent data
            $('#editParentContent').html(response);
            // Populate form fields with parent data
            $('#editParentId').val(response.id);
            $('#pFname').val(response.pFname);
            $('#pLname').val(response.pLname);
            $('#pAge').val(response.pAge);
            $('#pDob').val(response.pDob);
            $('#pAddress').val(response.pAddress);
            $('#pGender').val(response.pGender);
            $('#email').val(response.email);

            // Show the modal
            $('#editParentModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching edit parent modal:', error);
        }
    });
}
