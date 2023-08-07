<?php
session_start();

//Database connect
$mysqli = require __DIR__."/DBconnect.php";


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new password and confirmation password from the form
    $username = $_POST['Name'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Password hashing
    $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);




    // Validate the new password and confirmation password
    if ($newPassword !== $confirmPassword) {
        
        $_SESSION['status'] = "New password and confirm password do not match.";
        $_SESSION['status_code']= "error";
        header("Location: Password_Reset.php");
        
        
        exit(0);
    }

    // Check if the username exists in the database
    $checkUser = "SELECT uname FROM user WHERE uname = '$username'";
    $checkUserResult = mysqli_query($mysqli, $checkUser);

    if (!$checkUserResult) {
        echo "Error checking username: " . mysqli_error($mysqli);
        $_SESSION['status'] = "Something went wrong";
        $_SESSION['status_code'] = "error";
        header("Location: passwordResetProcess.php");
        exit(0);
    }

    $numRows = mysqli_num_rows($checkUserResult);

    if ($numRows === 0) {
        // If the username does not exist in the database
        $_SESSION['status'] = "Username does not exist.";
        $_SESSION['status_code'] = "error";
        header("Location: Password_Reset.php");
        exit(0);
    }


    //Update password in the table 
    $sql = "UPDATE  user SET password_Hash = '$password_hash' WHERE uname = '$username' ";

    // Execute the SQL statement 
    $result = mysqli_query($mysqli, $sql);

    // Check if the update was successful
    if ($result) {
        $_SESSION['status'] = "Password Resetted!";
        $_SESSION['status_code']= "success";
        header("Location: Sign-in.php");
    } else {
        echo "Error updating password: " . mysqli_error($mysqli);
        $_SESSION['status'] = "Something went worng";
        $_SESSION['status_code']= "error";
        header("Location: passwordResetProcess.php");
    }
    
    
            

}
?>






