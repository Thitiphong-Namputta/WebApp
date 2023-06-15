<?php 
    session_start();
    include("server.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!--bootstrap 5 icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--google icon-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="login.css">

</head>
<body>
    <div class="container">
        <div class="card card-body shadow m-3" id="card-form">
            <h1 class="text-center text-white">Sign In</h1>
            <form action="login_db.php" method="post">
                <div class="form-floating my-3">
                    <input type="text" name="username" class="form-control rounded-pill" id="floatlabel-username" placeholder="Username">
                    <label for="floatlabel-username"><i class="bi bi-person-fill"></i> Username</label>
                    <?php if(isset($_SESSION['username_error'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['username_error'];
                                unset($_SESSION['username_error']);
                            ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control rounded-pill" id="floatlabel-password" placeholder="Password">
                    <label for="floatlabel-password"><i class="bi bi-shield-lock"></i> Password</label>
                    <?php if(isset($_SESSION['password_error'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['password_error'];
                                unset($_SESSION['password_error']);
                            ?>
                        </div>
                    <?php endif ?>
                </div>
                <button type="submit" name="login_user" class="btn btn-danger my-2 rounded-pill">Login</button>
                <p>Not yet a member? <a href="register.php" class="signup-link">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
