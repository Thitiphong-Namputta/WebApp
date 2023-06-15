<?php 

    session_start();
    include("server.php");
    if(!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must login in first";
        header('location: login.php');
    }

    $user_name = $_SESSION['username'];

    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
    }

    $sql = "SELECT * FROM product";
    $all_product = $conn->query($sql);

    if(isset($_POST['add_to_cart'])) {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $product_quantity = $_POST['product_quantity'];

        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$product_name' AND username = '$user_name'");

        if(mysqli_num_rows($select_cart) > 0) {
            $message[] = "product already added to cart!";
        }
        else {
            mysqli_query($conn, "INSERT INTO cart (username, product_name, price, image, quantity) VALUES('$user_name','$product_name','$price','$image','$product_quantity')") or die("query failed");
            $message[] = "product added to cart!";
        }
    }

    if(isset($_POST['update_cart'])) {
        $update_quantity = $_POST['cart_quantity'];
        $update_cart = $_POST['cart_name'];
        mysqli_query($conn,"UPDATE cart SET quantity = '$update_quantity' WHERE product_name = '$update_cart'") or die("query failed");
        $message[] = "cart quantity updated successfully !!";
    }

    if(isset($_GET['remove'])) {
        $remove_name = $_GET['remove'];
        mysqli_query($conn, "DELETE FROM cart WHERE product_name = '$remove_name'") or die("query failed");
        header('location: index.php');
    }

    if(isset($_GET['delete_all'])) {
        mysqli_query($conn, "DELETE FROM cart WHERE username = '$user_name'") or die("query failed");
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!--bootstrap 5 icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--google icon-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--CSS-->
    <link href="index.css" rel="stylesheet">

</head>
<body>
    <nav class="d-flex justify-content-between align-items-center shadow">
        <h4 class="mx-3">Simple Store</h4>
        <div class="px-2">
            <i class="bi bi-box-arrow-right"></i>
            <a href="index.php?logout='1'" class="logout_link">Logout</a>
        </div>
    </nav>
    <?php
        if(isset($message)){
        foreach($message as $message){
            echo '<div class="text-center text-danger" onclick="this.remove();">'.$message.'</div>';
        }
        }
    ?>
    <div class="container">
        <div class="card card-body my-3 shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Home Page</h1>
                    <!--notification message-->
                    <?php if(isset($_SESSION['success'])) : ?>
                        <div class="success">
                            <h3>
                                <?php 
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                ?>
                            </h3>
                        </div>
                    <?php endif ?>
                    <div>
                        <!--logged in user information-->
                        <?php if(isset($_SESSION['username'])) : ?>
                            <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="me-3">
                    <button class="bi bi-cart4 position-relative fs-3 btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCart" aria-expanded="false" aria-controls="collapseCart">
                        <?php 
                            $cart_qury = mysqli_query($conn, "SELECT * FROM cart WHERE username = '$user_name'") or die("query failed");
                            $total_cart = 0;
                            if(mysqli_num_rows($cart_qury) > 0) {
                                while($cart_item = mysqli_fetch_assoc($cart_qury)) { 
                                    $sub_cart = $cart_item['quantity'];
                                    $total_cart += $sub_cart;
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-danger fs-6">
                                <?php echo $total_cart; ?>
                            </span>
                        <?php 
                                }
                            }  
                        ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4 my-2">
        <?php while($row = mysqli_fetch_assoc($all_product)) { ?>
            <div class="col">
                <div class="card text-center rounded-2 shadow" id="cardproduct">
                    <form method="post" action=""> 
                    <img src="<?php echo $row['image'] ?>" alt="" class="card-img-top" id="imgproduct">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="card-title"><?php echo $row['product_name'] ?></div>
                            <div class=""><?php echo $row['price'] ?> $</div>
                        </div>
                        <input type="number" min="1" name="product_quantity" value="1" class="form-control">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    </div>
                    <button class="btn btn-primary" name="add_to_cart">Add to cart <i class="bi bi-basket"></i></button>
                    </form>
                </div>
            </div>
        <?php } ?>
        </div>

        <div class="shopping_cart">
            <h1>Your Cart</h1>
            <button class="btn btn-primary bi bi-cart4 position-relative fs-3 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCart" aria-expanded="false" aria-controls="collapseCart">
                <?php 
                    $cart_qury = mysqli_query($conn, "SELECT * FROM cart WHERE username = '$user_name'") or die("query failed");
                    $total_cart = 0;
                    if(mysqli_num_rows($cart_qury) > 0) {
                        while($cart_item = mysqli_fetch_assoc($cart_qury)) { 
                            $sub_cart = $cart_item['quantity'];
                            $total_cart += $sub_cart;
                ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-danger fs-6">
                        <?php echo $total_cart; ?>
                    </span>
                <?php 
                        }
                    }  
                ?>
            </button>
            <div class="collapse" id="collapseCart">
                <div class="card card-body mb-4">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="">
                            <th>image</th>
                            <th>name</th>
                            <th>price</th>
                            <th>quantity</th>
                            <th>total price</th>
                            <th>action</th>
                        </thead>
                        <tbody>
                        <?php 
                            $cart_qury = mysqli_query($conn, "SELECT * FROM cart WHERE username = '$user_name'") or die("query failed");
                            $total_amount = 0;
                            if(mysqli_num_rows($cart_qury) > 0) {
                                while($cart_item = mysqli_fetch_assoc($cart_qury)) { 
                        ?>
                            <tr>
                                <td class="imgcart"><img src="<?php echo $cart_item['image']; ?>" alt="" id="imgcart"></td>
                                <td><?php echo $cart_item['product_name']; ?></td>
                                <td><?php echo $cart_item['price']. "$"; ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="" method="post">
                                            <input type="number" min="1" name="cart_quantity" value="<?php echo $cart_item['quantity']; ?>" class="form-control" id="cart_quantity">
                                            <input type="hidden" name="cart_name" value="<?php echo $cart_item['product_name']; ?>" class="form-control">
                                            <input type="submit" name="update_cart" value="update" class="btn btn-warning my-2">
                                        </form>
                                    </div>
                                </td>
                                <td>$<?php echo $sub_total = number_format($cart_item['price'] * $cart_item['quantity']); ?></td>
                                <td><a href="index.php?remove=<?php echo $cart_item['product_name']; ?>" class="btn btn-danger" onclick="return confirm('remove item form cart?')" >remove</a></td>
                            </tr>
                        <?php 
                            $total_amount += $sub_total;
                                }
                            }  
                            else {
                                echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                            };
                        ?>
                        <tr>
                            <td colspan="4">total :</td>
                            <td>$<?php echo $total_amount; ?></td>
                            <td><a href="index.php?delete_all" onclick="return confirm('delete all item from cart');" class="btn btn-danger">delete all</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
