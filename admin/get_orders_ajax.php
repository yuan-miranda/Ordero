<?php
include("../connection/connect.php");
session_start();

$admin_id = $_SESSION['adm_id'];
$restaurant_filter = isset($_POST['filter']) ? $_POST['filter'] : '';

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

if (!mysqli_num_rows($query)) {
    echo '<tr><td colspan="12" class="text-center">No Orders</td></tr>';
    exit;
}

while ($rows = mysqli_fetch_array($query)) {
    $dish_id = $rows['d_id'];
    $qty_ordered = $rows['quantity'];
    $status = strtolower(trim($rows['status']));

    $dish_stock_query = mysqli_query($db, "SELECT quantity FROM dishes WHERE d_id = '$dish_id'");
    $dish = mysqli_fetch_assoc($dish_stock_query);
    $dish_stock = ($dish && isset($dish['quantity'])) ? $dish['quantity'] : 0;

    $is_pending = ($status == "" || $status == "null");
    $show_stock_warning = $dish_stock < $qty_ordered && $is_pending;

    $qty_style = $show_stock_warning ? 'style="background-color: #ffcccc; font-weight: bold;"' : '';
    $qty_display = $show_stock_warning ? $qty_ordered . ' (' . $dish_stock . ' left)' : $qty_ordered;

    echo '<tr>
        <td>' . $rows['o_id'] . '</td>
        <td>' . $rows['restaurant_name'] . '</td>
        <td>' . $rows['username'] . '</td>
        <td>' . $rows['title'] . '</td>
        <td ' . $qty_style . '>' . $qty_display . '</td>
        <td>$' . ($rows['price'] * $rows['quantity']) . ' ($' . $rows['price'] . ')</td>
        <td>' . $rows['address'] . '</td>';

    if ($status == "" || $status == "NULL") {
        echo '<td><button type="button" class="btn btn-info"><span class="fa fa-bars"></span> Pending</button></td>';
    } elseif ($status == "in process") {
        echo '<td><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"></span>Accepted</button></td>';
    } elseif ($status == "closed") {
        echo '<td><button type="button" class="btn btn-primary"><span class="fa fa-check-circle"></span> Delivered</button></td>';
    } elseif ($status == "rejected") {
        echo '<td><button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button></td>';
    }

    echo '<td>' . $rows['remark'] . '</td>';
    echo '<td>' . date("F j, Y", strtotime($rows['date'])) . '</td>';

    if ($rows['arrive'] == "" || $rows['arrive'] == "NULL") {
        echo '<td>No ETA</td>';
    } else {
        echo '<td>' . date("F j, Y", strtotime($rows['arrive'])) . '</td>';
    }

    echo '<td><a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a></td>';
    echo '</tr>';
}
?>