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

    <link rel="stylesheet" href="register.css">

</head>
<body>
    <div class="container">
        <div class="card card-body m-3">
            <h1 class="text-center">Sign Up</h1>
            <form action="register_db.php" method="post">
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
                    <?php if(isset($_SESSION['username_check'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['username_check'];
                                unset($_SESSION['username_check']);
                            ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control rounded-pill" id="floatlabel-email" placeholder="Email">
                    <label for="floatlabel-email"><i class="bi bi-envelope"></i> Email</label>
                    <?php if(isset($_SESSION['email_error'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['email_error'];
                                unset($_SESSION['email_error']);
                            ?>
                        </div>
                    <?php endif ?>
                    <?php if(isset($_SESSION['email_check'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['email_check'];
                                unset($_SESSION['email_check']);
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
                <div class="form-floating mb-3">
                    <input type="password" name="password2" class="form-control rounded-pill" id="floatlabel-password2" placeholder="Comfirm Password">
                    <label for="floatlabel-password2"><i class="bi bi-shield-lock"></i> Confirm Password</label>
                    <?php if(isset($_SESSION['password2_error'])) : ?>
                        <div class="text-danger">
                            <?php 
                                echo $_SESSION['password2_error'];
                                unset($_SESSION['password2_error']);
                            ?>
                        </div>
                    <?php endif ?>
                </div>
                <button type="submit" name="reg_user" class="btn btn-danger my-2 rounded-pill">Register</button>
                <p>Already a member? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
