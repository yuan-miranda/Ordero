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

    <section class="popular">
        <div class="container" style="padding-top: 20px;">
            <div class="row">
                <?php
                $query_res = mysqli_query($db, "SELECT d.*, r.title AS restaurant_name FROM dishes d JOIN restaurant r ON d.rs_id = r.rs_id");
                while ($r = mysqli_fetch_array($query_res)) {
                    echo '  
                        <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <a href="admin/Res_img/dishes/' . $r['img'] . '" data-lightbox="dish-gallery" data-title="' . htmlspecialchars($r['title']) . '">
                                    <div class="" style="background-image: url(\'admin/Res_img/dishes/' . $r['img'] . '\'); height: 200px; background-size: contain; background-position: center center; background-repeat: no-repeat;"></div>
                                </a>
                                <div class="content">
                                    <h5><a href="dish-detail.php?dish_id=' . $r['d_id'] . '">' . htmlspecialchars($r['title']) . '</a></h5>
                                    <div class="product-name">' . htmlspecialchars($r['slogan']) . '</div>
                                    <div class="restaurant-name">From: ' . htmlspecialchars($r['restaurant_name']) . '</div>
                                    <div class="price-btn-block">
                                        <span class="price">$' . $r['price'] . '</span>
                                        <a href="dishes.php?res_id=' . $r['rs_id'] . '" class="btn theme-btn pull-right">View Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                ?>

            </div>
        </div>
    </section>

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