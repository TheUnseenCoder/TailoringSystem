$(document).ready(function() {
    $("#loginManual").click(function() {
        var formData = $("#loginForm").serialize();

        $.ajax({
            url: "../backend/login.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            if (response.user_type === '0') {
                                window.location.href = "../admin/index.php";
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error occurred: ' + error,
                });
            }
        });
    });  

    // Event listener for form submission
    $("#submitBtn").click(function() {
        // Serialize form data
        var formData = $("#inquiryForm").serialize();

        // AJAX request to submit the form data
        $.ajax({
            url: "backend/submit_inquiry.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                // Handle the response from the server
                if (response.success) {
                    // If inquiry is submitted successfully, show a success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            // Clear form fields
                            $("#inquiryForm")[0].reset();
                        }
                    });
                } else {
                    // If there's an error, show an error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // If there's an error in the AJAX request, show an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error occurred: ' + error,
                });
            }
        });
    });
});

