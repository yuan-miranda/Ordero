<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();


function function_alert($order_id)
{
    echo "<script>
        alert('Thank you. Your Order has been placed!');
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('qrcode-section').style.display = 'block';
            new QRCode(document.getElementById('qrcode'), {
                text: 'OrderID:$order_id',
                width: 200,
                height: 200
            });
            setTimeout(function () {
                window.location.href = 'your_orders.php';
            }, 60000); // Wait 5 seconds before redirecting
        });
    </script>";
}


if (!isset($_SESSION["user_id"])) {
    header('location:login.php');
} else {

    $user_id = $_SESSION["user_id"];

    // Fetch user information from the database
    $user_query = mysqli_query($db, "SELECT * FROM users WHERE u_id = '$user_id'");
    $user_data = mysqli_fetch_assoc($user_query);

    $item_total = 0;
    if (!empty($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $item_total += ($item["price"] * $item["quantity"]);
        }
    }

    if ($_POST['submit']) {
        foreach ($_SESSION["cart_item"] as $item) {
            $user_id = mysqli_real_escape_string($db, $_SESSION["user_id"]);
            $title = mysqli_real_escape_string($db, $item["title"]);
            $quantity = mysqli_real_escape_string($db, $item["quantity"]);
            $price = mysqli_real_escape_string($db, $item["price"]);

            $d_id = mysqli_real_escape_string($db, $item["d_id"]);
            $res_query = mysqli_query($db, "SELECT rs_id FROM dishes WHERE d_id='$d_id'");
            $res_row = mysqli_fetch_assoc($res_query);
            $res_id = $res_row['rs_id'];

            $SQL = "INSERT INTO users_orders(u_id, title, quantity, price, d_id, rs_id)
                VALUES('$user_id', '$title', '$quantity', '$price', '$d_id', '$res_id')";
            mysqli_query($db, $SQL);
        }

        // Clear cart session after order
        unset($_SESSION["cart_item"]);

        $order_id = mysqli_insert_id($db);

        echo "<script>
            alert('Thank you. Your Order has been placed!');
            window.location.href = 'your_orders.php';
        </script>";
        exit;
    }

    ?>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Checkout</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <div class="site-wrapper">
            <header id="header" class="header-scroll top-header headrom">
                <nav class="navbar navbar-dark" style="background-image: none; background-color: black;">
                    <div class="container">
                        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                            data-target="#mainNavbarCollapse">&#9776;</button>
                        <a class="navbar-brand" href="index.php">ORDERO</a>
                        <div class="collapse navbar-toggleable-md  float-lg-left" id="mainNavbarCollapse">
                            <ul class="nav navbar-nav">
                                <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                                            class="sr-only"></span></a> </li>

                                <?php
                                if (!isset($_SESSION["user_id"])) {
                                    echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                                } else {


                                    echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                                    echo '<li class="nav-item"><a href="logout.php" class="nav-link active" onclick="return confirmLogout();">Logout</a> </li>';
                                }

                                ?>

                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="page-wrapper">
                <!-- <div class="top-links">
                    <div class="container">
                        <ul class="row links">

                            <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose
                                    Restaurant</a></li>
                            <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a>
                            </li>
                            <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and
                                    Pay</a></li>
                        </ul>
                    </div>
                </div> -->

                <div class="container">

                    <span style="color:green;">
                        <?php echo $success; ?>
                    </span>

                </div>




                <div class="container m-t-30">
                    <form action="" method="post">
                        <div class="widget clearfix">

                            <div class="widget-body">
                                <form method="post" action="#">
                                    <div class="row">
                                        <div id="qrcode-section"
                                            style="display:none; text-align: center; margin-top: 20px;">
                                            <h4>Your Order QR Code</h4>
                                            <div style="display: flex; justify-content: center;">
                                                <div id="qrcode" style="display: inline-block;"></div>
                                            </div>
                                            <p>This QR will be used to scan your order at delivery.</p>
                                            <button id="save-qr-btn" class="btn btn-primary" style="margin-top: 10px;">Save
                                                QR Code</button>
                                        </div>

                                        <script>
                                            document.getElementById('save-qr-btn').addEventListener('click', function () {
                                                const qrCodeElement = document.querySelector('#qrcode img');
                                                if (qrCodeElement) {
                                                    const qrCodeUrl = qrCodeElement.src;
                                                    const link = document.createElement('a');
                                                    link.href = qrCodeUrl;
                                                    link.download = 'order_qr_code.png';
                                                    link.click();
                                                } else {
                                                    alert('QR Code not generated yet.');
                                                }
                                            });
                                        </script>

                                        <div class="col-sm-12">
                                            <div class="cart-totals margin-b-20">
                                                <?php if (!empty($_SESSION["cart_item"])): ?>
                                                    <div class="widget-body">
                                                        <h4>
                                                            <a data-toggle="collapse" href="#selectedProducts" role="button"
                                                                aria-expanded="false" aria-controls="selectedProducts">
                                                                Selected Products
                                                            </a>
                                                        </h4>
                                                        <div class="collapse" id="selectedProducts">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Dish Name</th>
                                                                        <th>Quantity</th>
                                                                        <th>Price</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($_SESSION["cart_item"] as $item): ?>
                                                                        <tr>
                                                                            <td><?php echo htmlspecialchars($item["title"]); ?></td>
                                                                            <td><?php echo (int) $item["quantity"]; ?></td>
                                                                            <td><?php echo "$" . number_format($item["price"], 2); ?>
                                                                            </td>
                                                                            <td><?php echo "$" . number_format($item["price"] * $item["quantity"], 2); ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="widget-body">
                                                    <h4>
                                                        <a data-toggle="collapse" href="#userInfo" role="button"
                                                            aria-expanded="false" aria-controls="userInfo">
                                                            User Information
                                                        </a>
                                                    </h4>
                                                    <div class="collapse" id="userInfo">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>Full Name</th>
                                                                <td><?php echo htmlspecialchars($user_data['f_name'] . ' ' . $user_data['l_name']); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td><?php echo htmlspecialchars($user_data['email']); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone</th>
                                                                <td><?php echo htmlspecialchars($user_data['phone']); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address</th>
                                                                <td><?php echo nl2br(htmlspecialchars($user_data['address'])); ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="widget-body">
                                                    <div class="cart-totals-title">
                                                        <h4>Cart Information</h4>
                                                    </div>
                                                    <div class="cart-totals-fields">

                                                        <table class="table">
                                                            <tbody>



                                                                <tr>
                                                                    <td>Cart Subtotal</td>
                                                                    <td> <?php echo "$" . $item_total; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-color"><strong>Total</strong></td>
                                                                    <td class="text-color"><strong>
                                                                            <?php echo "$" . $item_total; ?></strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="widget-body">
                                                    <div class="payment-option">
                                                        <ul class=" list-unstyled">
                                                            <li>
                                                                <label class="custom-control custom-radio  m-b-20">
                                                                    <input name="mod" id="radioStacked1" checked value="COD"
                                                                        type="radio" class="custom-control-input"> <span
                                                                        class="custom-control-indicator"></span> <span
                                                                        class="custom-control-description">Cash on
                                                                        Delivery</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        <p class="text-xs-center"> <input type="submit"
                                                                onclick="return confirm('Do you want to confirm the order?');"
                                                                name="submit" class="btn btn-success btn-block"
                                                                value="Order Now">
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>

        </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
        <script src="js/REPLACEDOLLAR.js"></script>
        <!-- QR Code Generator -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


        <script>
            function confirmLogout() {
                return confirm("Are you sure you want to log out?");
            }
        </script>

    </body>

    </html>

    <?php
}
?>