<?php
session_start();
//include DB

$mysqli = require __DIR__. "/DBconnect.php";


    $name = mysqli_real_escape_string($mysqli,$_POST['Name']);
    $emal = mysqli_real_escape_string($mysqli,$_POST['Email']);
    $pass = mysqli_real_escape_string($mysqli,$_POST['password']);
    $cpass = mysqli_real_escape_string($mysqli,$_POST['password2']);
        //password hashing
    $password_hash =  password_hash($pass,PASSWORD_DEFAULT);
    $auth_role = 1;
   
   

 
    
    
    if ($pass === $cpass){

        

        //check email
        if ( filter_var($emal, FILTER_VALIDATE_EMAIL)){
            
       
         
        $checkEmail = "SELECT email FROM user WHERE email='$emal'";
        $checkEmail_run = mysqli_query($mysqli,$checkEmail);

        if (mysqli_num_rows($checkEmail_run) > 0){
            //Already Email exist
            $_SESSION['message'] = "Already Email Exist";
            header("Location:AdminSignup.php");
            exit(0);
        }
        else{
                //Adding placeholders

                $sql = "INSERT INTO user (uname, email, password_Hash, auth_role) VALUES (?, ?, ?, ?)";

            $stmt = $mysqli->stmt_init();

            if( ! $stmt->prepare($sql)){
                die("SQL error: ". $mysqli->error);
            }
            //binding the parameters
        
            $stmt->bind_param("sssi", $name, $emal, $password_hash, $auth_role);

            if($stmt->execute()){
                $_SESSION['status'] = "Signup Succesfully";
                $_SESSION['status_code']= "success";
                header("Location: Admin.php");
                exit(0);
                
             
                } else {
                    $_SESSION['status'] = "Signup failed";
                    $_SESSION['status_code'] = "error";
                    header("Location:AdminSignup.php");
                    exit(0);
                }
            }
        }else{
            $_SESSION['message'] = "E-mail required";
            header("Location:AdminSignup.php");
            exit(0);

        }
        
    }else{
        $_SESSION['message'] = "Password and confirm password does not match";
        header("Location:AdminSignup.php");
        exit(0);
    }

?>