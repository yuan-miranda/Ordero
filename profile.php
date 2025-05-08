<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css" rel="stylesheet">

</head>

<body class="home">

    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark" style="background-image: none; background-color: black;">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                    data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php">ORDERO</a>
                <div class="collapse navbar-toggleable-md  float-lg-left" id="mainNavbarCollapse"">
                    <ul class=" nav navbar-nav">
                    <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                                class="sr-only"></span></a> </li>

                    <?php
                    if (!isset($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                    } else {


                        echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active pull-right">My Orders</a> </li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active" onclick="return confirmLogout();">Logout</a> </li>';
                    }

                    ?>

                    </ul>

                </div>
            </div>
        </nav>

    </header>


    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script src="js/REPLACEDOLLAR.js"></script>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>

    <script>
        window.addEventListener('load', function () {
            const productNames = document.querySelectorAll('.product-name');
            let maxHeight = 0;

            productNames.forEach(el => {
                const height = el.offsetHeight;
                if (height > maxHeight) maxHeight = height;
            });

            productNames.forEach(el => {
                el.style.minHeight = maxHeight + 'px';
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js"></script>
</body>

</html>