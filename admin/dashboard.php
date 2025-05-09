<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
} else {
    ?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Manager Panel</title>
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body class="fix-header">

        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <div id="main-wrapper">

            <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="dashboard.php">
                        </a>
                    </div>

                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto mt-md-0">
                        </ul>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Logout</a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="left-sidebar">

                <div class="scroll-sidebar">

                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
                            </li>

                            <!-- <li> <a href="all_users.php"> <span><i
                                            class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li> -->
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i
                                        class="fa fa-archive f-s-20 color-warning"></i><span
                                        class="hide-menu">Restaurant</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_restaurant.php">All Restaurant</a></li>
                                    <li><a href="add_category.php">Add Category</a></li>
                                    <li><a href="add_restaurant.php">Add Restaurant</a></li>

                                </ul>
                            </li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                        aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_menu.php">All Menues</a></li>
                                    <li><a href="add_menu.php">Add Menu</a></li>


                                </ul>
                            </li>
                            <li> <a href="all_orders.php"><i class="fa fa-shopping-cart"
                                        aria-hidden="true"></i><span>Orders</span></a></li>
                            <hr class="line">
                            </hr>
                            <li> <a href="POS.php"><i class="fa fa-money" aria-hidden="true"></i><span
                                        style="font-size: larger;">POS</span></a></li>
                        </ul>
                    </nav>

                </div>

            </div>

            <div class="page-wrapper">



                <div class="container-fluid">
                    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header" <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left"
                                style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                onmouseover="this.style.transform=\'scale(1.05)\'; this.style.boxShadow=\'0px 6px 12px rgba(0, 0, 0, 0.2)\';"
                                onmouseout="this.style.transform=\'scale(1)\'; this.style.boxShadow=\'0px 4px 8px rgba(0, 0, 0, 0.1)\';">
                                >
                                <h4 class="m-b-0 text-white">Admin Dashboard</h4>
                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-home f-s-40 "></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "select * from restaurant WHERE adm_id = '$admin_id'";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <strong>
                                                    <p class="m-b-0" style="cursor: pointer;"
                                                        onmouseover="this.style.textDecoration='underline';"
                                                        onmouseout="this.style.textDecoration='none';"
                                                        onclick="window.location.href='all_restaurant.php';">
                                                        Restaurants</p>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-cutlery f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "SELECT * FROM dishes WHERE rs_id IN 
                                                        (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <strong>
                                                    <p class="m-b-0" style="cursor: pointer;"
                                                        onmouseover="this.style.textDecoration='underline';"
                                                        onmouseout="this.style.textDecoration='none';"
                                                        onclick="window.location.href='all_menu.php';">Dishes
                                                    </p>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-users f-s-40"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "select * from users";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <strong>
                                                    <p class="m-b-0" style="cursor: pointer;"
                                                        onmouseover="this.style.textDecoration='underline';"
                                                        onmouseout="this.style.textDecoration='none';"
                                                        onclick="window.location.href='all_users.php';">Users
                                                    </p>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "select * from users_orders WHERE rs_id IN 
                                                        (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <strong>
                                                    <p class="m-b-0" style="cursor: pointer;"
                                                        onmouseover="this.style.textDecoration='underline';"
                                                        onmouseout="this.style.textDecoration='none';"
                                                        onclick="window.location.href='all_orders.php';">Total
                                                        Orders</p>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-spinner f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "select * from users_orders WHERE status = 'in process' AND rs_id IN 
                                                        (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <p class="m-b-0">Processing Orders</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-check f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2><?php
                                                $admin_id = $_SESSION['adm_id'];
                                                $sql = "select * from users_orders WHERE status = 'closed' AND rs_id IN 
                                                        (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')";
                                                $result = mysqli_query($db, $sql);
                                                $rws = mysqli_num_rows($result);

                                                echo $rws; ?></h2>
                                                <p class="m-b-0">Delivered Orders</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card p-30"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='scale(1.025)'; this.style.boxShadow='0px 6px 12px rgba(0, 0, 0, 0.2)';"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 8px rgba(0, 0, 0, 0.1)';">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h2>₱ <?php
                                                $result = mysqli_query($db, "SELECT SUM(price * quantity) AS value_sum FROM users_orders WHERE status = 'closed' AND rs_id IN 
                                                (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')");

                                                $row = mysqli_fetch_assoc($result);
                                                $sum = $row['value_sum'];
                                                echo number_format($sum, 2);
                                                ?></h2>
                                                <p class="m-b-0">Total Earnings</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card p-30">
                                                    <h4 class="m-b-0 text-center">Sales Report (All Restaurants)</h4>
                                                    <canvas id="salesReportChart" height="500"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="js/lib/jquery/jquery.min.js"></script>
                <script src="js/lib/bootstrap/js/popper.min.js"></script>
                <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
                <script src="js/jquery.slimscroll.js"></script>
                <script src="js/sidebarmenu.js"></script>
                <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
                <script src="js/custom.min.js"></script>
                <script src="js/REPLACEDOLLAR.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('salesReportChart').getContext('2d');

                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Processing', 'Delivered', 'Earnings (₱)'],
                            datasets: [{
                                label: 'Sales Report',
                                data: [
                                    <?php
                                    $result = mysqli_query($db, "SELECT COUNT(*) AS total FROM users_orders WHERE status = 'in process' AND rs_id IN 
                                                     (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')");
                                    $processing = mysqli_fetch_assoc($result)['total'];

                                    $result = mysqli_query($db, "SELECT COUNT(*) AS total FROM users_orders WHERE status = 'closed' AND rs_id IN 
                                                     (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')");
                                    $delivered = mysqli_fetch_assoc($result)['total'];

                                    $result = mysqli_query($db, "SELECT SUM(price) AS value_sum FROM users_orders WHERE status = 'closed' AND rs_id IN 
                                                     (SELECT rs_id FROM restaurant WHERE adm_id = '$admin_id')");
                                    $earnings = mysqli_fetch_assoc($result)['value_sum'];

                                    echo "$processing, $delivered, $earnings";
                                    ?>
                                ],
                                backgroundColor: ['#ffc107', '#28a745', '#007bff']
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </body>

    </html>
    <?php
}
?>