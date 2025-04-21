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
                <!-- <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/ordero_icon.svg" alt=""> </a> -->
                <div class="collapse navbar-toggleable-md  float-lg-left" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                                    class="sr-only"></span></a> </li>


                        <?php
                        if (empty($_SESSION["user_id"])) // if user is not login
                        {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                        } else {


                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
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
                $query_res = mysqli_query($db, "select * from dishes LIMIT 6");
                while ($r = mysqli_fetch_array($query_res)) {

                    echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                <div class="food-item-wrap">
                                    <a href="admin/Res_img/dishes/' . $r['img'] . '" data-lightbox="dish-gallery" data-title="' . htmlspecialchars($r['title']) . '">
                                        <div class="figure-wrap" style="background-image: url(\'admin/Res_img/dishes/' . $r['img'] . '\'); height: 200px; background-size: cover; background-position: center; border-radius: 10px;"></div>
                                    </a>
                                    <div class="content">
                                        <h5><a href="dishes.php?res_id=' . $r['rs_id'] . '">' . $r['title'] . '</a></h5>
                                        <div class="product-name">' . $r['slogan'] . '</div>
                                        <div class="price-btn-block">
                                            <span class="price">$' . $r['price'] . '</span>
                                            <a href="dishes.php?res_id=' . $r['rs_id'] . '" class="btn theme-btn-dash pull-right">Order Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }

                ?>
            </div>
        </div>
    </section>

    <section class="featured-restaurants" style="padding: 0px 0px 20px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="title-block pull-left">
                        <h4>Featured Restaurants</h4>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="restaurants-filter pull-right">
                        <nav class="primary pull-left">
                            <ul>
                                <li><a href="#" class="selected" data-filter="*">all</a> </li>
                                <?php
                                $res = mysqli_query($db, "select * from res_category");
                                while ($row = mysqli_fetch_array($res)) {
                                    echo '<li><a href="#" data-filter=".' . $row['c_name'] . '"> ' . $row['c_name'] . '</a> </li>';
                                }
                                ?>

                            </ul>
                        </nav>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="restaurant-listing">


                    <?php
                    $ress = mysqli_query($db, "select * from restaurant");
                    while ($rows = mysqli_fetch_array($ress)) {

                        $query = mysqli_query($db, "select * from res_category where c_id='" . $rows['c_id'] . "' ");
                        $rowss = mysqli_fetch_array($query);

                        echo ' <div class="col-xs-12 col-sm-12 col-md-6 single-restaurant all ' . $rowss['c_name'] . '">
														<div class="restaurant-wrap">
															<div class="row">
																<div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 text-xs-center">
																	<a class="restaurant-logo" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo"> </a>
																</div>
													
																<div class="col-xs-12 col-sm-9 col-md-12 col-lg-9">
																	<h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5> <span>' . $rows['address'] . '</span>
																</div>
													
															</div>
												
														</div>
												
													</div>';
                    }


                    ?>




                </div>
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