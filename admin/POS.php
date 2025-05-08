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
    <title>All Menu</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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

        <!-- make a box on the bottom left it will be an  -->

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <!-- first table -->
                    <div class="col-lg-6 col-md-12">
                        <div class="d-flex flex-column h-100">
                            <div class="card card-outline-primary flex-grow-1">
                                <div class="card-header" style="background: #424549;">
                                    <form method="GET" action="" style="margin-top: 0px;">
                                        <select id="restaurantFilter" class="form-control"
                                            style="width: 200px; display: inline-block;">
                                            <option value="">All Restaurants</option>
                                            <?php
                                            $res_query = mysqli_query($db, "SELECT * FROM restaurant");
                                            while ($res_row = mysqli_fetch_array($res_query)) {
                                                echo '<option value="' . $res_row['rs_id'] . '">' . $res_row['title'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table id="allMenuTable"
                                        class="display nowrap table table-hover table-striped table-bordered">
                                        <thead style="color: white;">
                                            <tr>
                                                <th>Image</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Stocks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $admin_id = $_SESSION['adm_id'];
                                            $filter = isset($_GET['restaurant_filter']) ? $_GET['restaurant_filter'] : '';

                                            if (!empty($filter)) {
                                                $sql = "SELECT * FROM dishes WHERE adm_id='$admin_id' AND rs_id='$filter' ORDER BY d_id DESC";
                                            } else {
                                                $sql = "SELECT * FROM dishes WHERE adm_id='$admin_id' ORDER BY d_id DESC";
                                            }

                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="11"><center>No Menu</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    $mql = "select * from restaurant where rs_id='" . $rows['rs_id'] . "'";
                                                    $newquery = mysqli_query($db, $mql);
                                                    $fetch = mysqli_fetch_array($newquery);
                                                    echo '<tr>
														<td>
                                                        <div class="col-md-3 col-lg-8 m-b-10">
                                                        <center><img src="Res_img/dishes/' . $rows['img'] . '" class="img-responsive  radius" style="width:32px;height:32px;" /></center>
                                                        </div>
                                                        </td>
                                                        <td>' . $rows['title'] . '</td>
														<td>$' . $rows['price'] . '</td>
                                                        <td>' . $rows['quantity'] . '</td>
                                                        <td>
                                                        <button class="btn btn-danger btn-flat btn-addon btn-xs m-b-10" onclick="removeItemFromCart(' . $rows['d_id'] . ')"><i class="fa fa-minus" style="font-size:16px"></i></button>
                                                        <button class="btn btn-success btn-flat btn-addon btn-xs m-b-10" onclick="addItemToCart(' . $rows['d_id'] . ', ' . $rows['quantity'] . ')"><i class="fa fa-plus" style="font-size:16px"></i></button>
                                                        </td></tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="position-fixed"
                            style="bottom: 0; right: 0; width: 40%; height: 90%; margin: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); overflow-y: auto; padding: 20px; display: flex; justify-content: center; border: 1px solid #ccc; z-index: 1030;">

                            <div class="card card-outline-primary"
                                style="flex-grow: 1; display: flex; flex-direction: column; margin: 0; padding: 0; height: 100%;">

                                <!-- Top Half -->
                                <div class="card-body" style="flex: 1; border-bottom: 1px solid #ccc;">
                                    <h5>Cart Items</h5>
                                    <ul id="cartItems" class="list-group"></ul>
                                </div>

                                <!-- Bottom Half -->
                                <div class="card-body" style="flex: 1;">
                                    <!-- Example content -->
                                    <h2 style="margin-top: 10px; margin-bottom: 10px;">Total: ₱0.00</h2>
                                    <button class="btn btn-success btn-block" onclick="placeOrder()">Place
                                        Order</button>
                                </div>

                            </div>



                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- <footer class="footer"> © 2022 - Online Food Ordering System </footer> -->

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
    <script src="js/lib/datatables/datatables-init.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#restaurantFilter').on('change', function () {
                const restaurantId = $(this).val();

                $.ajax({
                    url: 'fetch_menu.php',
                    method: 'POST',
                    data: { restaurant_filter: restaurantId },
                    success: function (response) {
                        $('#allMenuTable tbody').html(response);
                    }
                });
            });
        });
    </script>

    <script>
        const cart = {};

        function addItemToCart(dishId, stock) {
            if (stock === 0) {
                const addButton = document.querySelector(`button[onclick^="addItemToCart(${dishId},"]`);
                addButton.disabled = true;
                return;
            }
            const row = document.querySelector(`button[onclick^="addItemToCart(${dishId},"]`).closest('tr');
            const name = row.cells[1].innerText;
            const price = row.cells[2].innerText;

            if (!cart[dishId]) {
                cart[dishId] = {
                    name: name,
                    price: price,
                    quantity: 1
                };
            } else {
                if (cart[dishId].quantity < stock) {
                    cart[dishId].quantity++;
                } else {
                    alert("Cannot add more than available stock!");
                }
            }

            renderCart();
        }

        function removeItemFromCart(dishId) {
            if (cart[dishId]) {
                cart[dishId].quantity--;
                if (cart[dishId].quantity <= 0) {
                    delete cart[dishId];
                }
                renderCart();
            }
        }

        function renderCart() {
            const cartList = document.getElementById('cartItems');
            cartList.innerHTML = ''; // clear previous

            let total = 0;

            Object.keys(cart).forEach(id => {
                const item = cart[id];
                const priceNumber = parseFloat(item.price.replace(/[^0-9.-]+/g, "")); // Remove $ or other symbols
                const itemTotal = priceNumber * item.quantity;
                total += itemTotal;

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
            <span style="flex-grow: 1;">${item.name}</span>
            <span style="flex-grow: 1; text-align: center;">${item.price}</span>
            <span><strong>${item.quantity}</strong></span>
        `;
                cartList.appendChild(li);
            });

            const totalDisplay = document.querySelector('.card-body:nth-child(2) h2'); // Target the Total <h2>
            totalDisplay.textContent = `Total: ₱${total.toFixed(2)}`;
        }

    </script>
    <script>
        function placeOrder() {
            if (Object.keys(cart).length === 0) {
                alert("Cart is empty!");
                return;
            }

            // Prepare the data for each item in the cart as separate orders
            const cartData = [];
            for (const id in cart) {
                cartData.push({
                    u_id: 1, // Assuming user ID is 1 for now
                    rs_id: cart[id].rs_id, // Assuming each item in cart has a `rs_id` (restaurant ID)
                    d_id: id,
                    title: cart[id].name,
                    price: cart[id].price.replace(/[^0-9.-]+/g, ""),
                    quantity: cart[id].quantity
                });
            }

            // Send each item as a separate order
            fetch('place_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ items: cartData })
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        alert("Order placed successfully!");
                        Object.keys(cart).forEach(k => delete cart[k]);
                        renderCart();
                    } else {
                        alert("Failed to place order.");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("An error occurred.");
                });
        }

    </script>



    <script>
        $(document).ready(function () {

            $('#allMenuTable').DataTable({
                "pageLength": 9,
                "lengthChange": false,

            });
        });
    </script>
    <script src="js/REPLACEDOLLAR.js"></script>



</body>

</html>