function editChild(childId) {
    $.ajax({
        url: '/children/' + childId + '/edit',
        type: 'GET',
        success: function(response) {
            // Update modal content with child data
            $('#editChildId').val(response.id);
            $('#editChildFirstName').val(response.childFirstName);
            $('#editChildLastName').val(response.childLastName);
            $('#editChildAge').val(response.childAge);
            $('#editChildDob').val(response.childDob);
            $('#editChildAddress').val(response.childAddress);
            $('#editChildGender').val(response.childGender);

            // Show the modal
            $('#editChildModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching edit child modal:', error);
        }
    });
}

$(document).ready(function() {
    $('#editChildForm').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Serialize form data
        var formData = $(this).serialize();

        // Submit the form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function(response) {
                // Close the modal
                $('#editChildModal').modal('hide');

                // Show success message with "OK" button
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Child information has been updated successfully.',
                    showConfirmButton: true, // Show the "OK" button
                    confirmButtonText: 'OK', // Change the "OK" button text
                }).then((result) => {
                    // Reload the page after clicking "OK"
                    if (result.isConfirmed) {
                        window.location.reload(); // Reload the page
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error updating child:', error);
            }
        });
    });
});
