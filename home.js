$(document).ready(function() {
    $("#loginManual").click(function() {
        var formData = $("#loginForm").serialize();

        $.ajax({
            url: "backend/login.php",
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
                                window.location.href = "admin/index.php";
                            } else {
                                window.location.href = "index.php";
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

    $("#signupManual").click(function() {
        var formData = $("#SignUpForm").serialize() + "&signupAction=true";

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
                        title: 'Oops... ',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops... 1',
                    text: 'Error occurred: ' + error,
                });
            }
        });
    });

    // Event delegation for dynamically generated #submitOTP button
    $(document).on("click", "#submitOTP", function() {
        var formData = $("#SignUpForm").serialize() + "&otpAction=true";

        $.ajax({
            url: "backend/signup.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    var successToast = Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false // Hide the confirm button
                    });

                    // Automatically close the success message after 3 seconds
                    setTimeout(function() {
                        successToast.close();
                    }, 3000);
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

    document.getElementById('profilePicture').addEventListener('click', function() {
        var profileMenu = document.getElementById('profileMenu');
        if (profileMenu.style.display === 'none') {
            profileMenu.style.display = 'block';
        } else {
            profileMenu.style.display = 'none';
        }
    });
});
