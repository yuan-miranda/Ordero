<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>All Orders</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>

<body class="fix-header fix-sidebar">

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

                        <!-- <span><img src="images/ordero_icon.svg" alt="homepage" class="dark-logo" /></span> -->
                    </a>
                </div>
                <div class="navbar-collapse">

                    <ul class="navbar-nav mr-auto mt-md-0">




                    </ul>

                    <ul class="navbar-nav my-lg-0">



                        <li class="nav-item dropdown">

                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>

                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                                notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

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
                        <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>

                        <!-- <li> <a href="all_users.php"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li> -->
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i
                                    class="fa fa-archive f-s-20 color-warning"></i><span
                                    class="hide-menu">Restaurant</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_restaurant.php">All Restaurants</a></li>
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

                <div class="row">
                    <div class="col-12">


                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header" style="background: #424549;">
                                    <h4 class="m-b-0 text-white">All Orders</h4>
                                    <select id="orderFilter" class="form-control"
                                        style="width: 200px; display: inline-block;">
                                        <option value="">All Restaurants</option>
                                        <?php
                                        $res_query = mysqli_query($db, "SELECT * FROM restaurant WHERE adm_id = '{$_SESSION['adm_id']}'");
                                        while ($res_row = mysqli_fetch_array($res_query)) {
                                            echo '<option value="' . $res_row['rs_id'] . '">' . $res_row['title'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                </div>


                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Restaurant</th>
                                                <th>User</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Note</th>
                                                <th>Date Ordered</th>
                                                <th>Arrive</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
                                            $admin_id = $_SESSION['adm_id'];
                                            $restaurant_filter = isset($_GET['order_restaurant_filter']) ? $_GET['order_restaurant_filter'] : '';

                                            $sql = "SELECT users.*, users_orders.*, remark.remark, restaurant.title AS restaurant_name 
                                                    FROM users 
                                                    INNER JOIN users_orders ON users.u_id = users_orders.u_id 
                                                    LEFT JOIN remark ON users_orders.o_id = remark.frm_id
                                                    INNER JOIN restaurant ON users_orders.rs_id = restaurant.rs_id
                                                    WHERE restaurant.adm_id = '$admin_id'";

                                            if (!empty($restaurant_filter)) {
                                                $sql .= " AND restaurant.rs_id = '$restaurant_filter'";
                                            }

                                            $sql .= " ORDER BY users_orders.o_id DESC";


                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="11"><center>No Orders</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {

                                                    ?>

                                                    <?php
                                                    $dish_id = $rows['d_id'];
                                                    $qty_ordered = $rows['quantity'];
                                                    $status = strtolower(trim($rows['status']));

                                                    $dish_stock_query = mysqli_query($db, "SELECT quantity FROM dishes WHERE d_id = '$dish_id'");
                                                    $dish = mysqli_fetch_assoc($dish_stock_query);
                                                    $dish_stock = $dish['quantity'];

                                                    // Determine if the cell should be highlighted and annotated
                                                    $is_pending = ($status == "" || $status == "null");
                                                    $show_stock_warning = $dish_stock < $qty_ordered && $is_pending;

                                                    $qty_style = $show_stock_warning ? 'style="background-color: #ffcccc; font-weight: bold;"' : '';
                                                    $qty_display = $show_stock_warning ? $qty_ordered . ' (' . $dish_stock . ' left)' : $qty_ordered;
                                                    ?>
                                                    <?php
                                                    echo ' <tr>
                                                    <td>' . $rows['o_id'] . '</td>
                                                    <td>' . $rows['restaurant_name'] . '</td>
                                                    <td>' . $rows['username'] . '</td>
                                                    <td>' . $rows['title'] . '</td>
                                                    <td ' . $qty_style . '>' . $qty_display . '</td>
                                                    <td data-column="Price">$' . ($rows['price'] * $rows['quantity']) . ' ($' . $rows['price'] . ')</td>
                                                    <td>' . $rows['address'] . '</td>';

                                                    ?>

                                                    <td><?php echo $rows['remark']; ?></td>

                                                    <?php
                                                    echo '	<td>' . date("F j, Y", strtotime($rows['date'])) . '</td>';
                                                    ?>
                                                    <?php
                                                    if ($rows['arrive'] == "" || $rows['arrive'] == "NULL") {
                                                        echo '<td>No ETA</td>';
                                                    } else {
                                                        echo '<td>' . date("F j, Y", strtotime($rows['arrive'])) . '</td>';
                                                    }
                                                    ?>
                                                    <?php
                                                    $status = $rows['status'];
                                                    if ($status == "" or $status == "NULL") {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-secondary"><span
                                                                    aria-hidden="true"></span> Processing</button>
                                                        </td>
                                                        <?php
                                                    }
                                                    if ($status == "in process") { ?>
                                                        <td> <button type="button" class="btn btn-info"><span
                                                                    aria-hidden="true"></span>Accepted</button></td>
                                                        <?php
                                                    }
                                                    if ($status == "closed") {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-primary"><span
                                                                    aria-hidden="true"></span>
                                                                Delivered</button></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($status == "rejected") {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-danger"> <i></i>
                                                                Cancelled</button></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td>
                                                        <?php
                                                        echo '<a href="view_order.php?user_upd=' . $rows['o_id'] . '" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
																									</td>
																									</tr>';

                                                }
                                            }


                                            ?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!-- <footer class="footer"> © 2022 - Online Food Ordering System</footer> -->

    </div>

    </div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/REPLACEDOLLAR.js"></script>
    <script>
        $(document).ready(function () {
            $('#orderFilter').change(function () {
                const selectedValue = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: 'get_orders_ajax.php',
                    data: { filter: selectedValue },
                    success: function (response) {
                        $('#myTable tbody').html(response);
                    },
                    error: function () {
                        alert('Failed to fetch data');
                    }
                });
            });
        });
    </script>


</body>

</html>