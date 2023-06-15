<?php 

    session_start();
    include("server.php");

    $errors = array();

    if(isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

        if(empty($username)) {
            array_push($errors, "Username is required");
            $_SESSION['username_error'] = "Username is required";
        }
        if(empty($email)) {
            array_push($errors, "Email is required");
            $_SESSION['email_error'] = "Email is required";
        }
        if(empty($password)) {
            array_push($errors, "Password is required");
            $_SESSION['password_error'] = "Password is required";
        }
        if($password != $password2) {
            array_push($errors, "Passwords do not match");
            $_SESSION['password2_error'] = "Passwords do not match";
        }

        $user_check_query = "SELECT * FROM  user WHERE username = '$username' OR email = '$email'";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if($result) {
            if($result['username'] === $username) {
                array_push($errors, "Username already exists");
                $_SESSION['username_check'] = "Username already exists";
            }
            if($result['email'] === $email) {
                array_push($errors, "Email already exists");
                $_SESSION['email_check'] = "Email already exists";
            }
        }

        if(count($errors) == 0) {
            $password = md5(($password));

            $sql = "INSERT INTO user (username, email, password) VALUE ('$username','$email','$password')";
            mysqli_query($conn, $sql);

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
        else {
            array_push($errors, "Username or Email already exists");
            // $_SESSION['error'] = "Username or Email already exists";
            header('location: register.php');
        }

    }

?>