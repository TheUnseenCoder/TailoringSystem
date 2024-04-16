$(document).ready(function() {
    $("#updateProfile").click(function() {
        var formData = new FormData($("#editProfileForm")[0]); // Create FormData object

        // Append additional data
        formData.append('signupAction', true);

        $.ajax({
            url: "functions/submitotp.php",
            type: "POST",
            data: formData, // Use FormData object
            contentType: false, // Set content type to false
            processData: false, // Disable processData
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        // Redirect to profile page only if update was successful
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = "profile.php";
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

    $(document).on("click", "#submitOTP", function() {
        var formData = $("#editProfileForm").serialize();

        $.ajax({
            url: "functions/submitotp.php",
            type: "POST",
            data: formData + "&otpAction=true",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    var successToast = Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false
                    });

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
});
