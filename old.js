$(document).ready(function() {
    $("#loginManual").click(function() {

        var formData = $("#loginForm").serialize();

        $.ajax({
            url: "backend/login.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                // Handle login response
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = "index.php";
                        }
                    });
                } else {
                    // Display error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Display error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error occurred: ' + error,
                });
            }
        });
    });

    $("#signupManual").click(function() {
        var formData = $("#SignUpForm").serialize();

        $.ajax({
            url: "backend/signup.php",
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
                            window.location.href = "index.php";
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
    // $("#loginGmail").click(function() {
    //     // Send AJAX request for login with Google
    //     $.ajax({
    //         url: "backend/login_google.php",
    //         type: "POST",
    //         dataType: "json",
    //         success: function(response) {
    //             // Handle login response
    //             console.log("Login with Google Response:", response);
    //             if (response.success) {
    //                 // Redirect to profile page
    //                 window.location.href = "index.php";
    //             } else {
    //                 // Display error message
    //                 alert(response.message);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             // Display error message
    //             console.log("Error:", error);
    //             alert("Error: " + error);
    //         }
    //     });
    // });

    // $("#signupGmail").click(function() {
    //     // Send AJAX request for login with Google
    //     $.ajax({
    //         url: "backend/signup_google.php",
    //         type: "POST",
    //         dataType: "json",
    //         success: function(response) {
    //             // Display response message
    //             console.log("Signup with Google Response:", response);
    //             alert(response.message);
    //         },
    //         error: function(xhr, status, error) {
    //             // Display error message
    //             console.log("Error:", error);
    //             alert("Error: " + error);
    //         }
    //     });
    // });

    document.getElementById('profilePicture').addEventListener('click', function() {
        var profileMenu = document.getElementById('profileMenu');
        if (profileMenu.style.display === 'none') {
            profileMenu.style.display = 'block';
        } else {
            profileMenu.style.display = 'none';
        }
    });
});
