<?php 
include('conn.php');
if(isset($_POST["user_name"]) && isset($_POST["user_pass"])) {
    $user_name = $_POST["user_name"];
    $user_pass = md5($_POST["user_pass"]);

    $sql = "SELECT * FROM ts_users WHERE email = '$user_name'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $name = $row['fullname'];
        $email = $row['email'];
        $pass = $row['password'];

        if($user_pass == $pass){
            echo "login success," . $name . "," . $email;
        }else{
            echo "Wrong Password";
        }
    } else {
        echo "Username is not existing";
    }
} else {
    echo "Error: Required parameters missing";
}
?>
