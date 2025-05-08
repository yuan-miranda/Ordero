<?php
include("../connection/connect.php");
session_start();

$admin_id = $_SESSION['adm_id'];
$filter = $_POST['restaurant_filter'];

if (!empty($filter)) {
    $sql = "SELECT * FROM dishes WHERE adm_id='$admin_id' AND rs_id='$filter' ORDER BY d_id DESC";
} else {
    $sql = "SELECT * FROM dishes WHERE adm_id='$admin_id' ORDER BY d_id DESC";
}

$query = mysqli_query($db, $sql);

if (!mysqli_num_rows($query) > 0) {
    echo '<td colspan="5"><center>No Menu</center></td>';
} else {
    while ($rows = mysqli_fetch_array($query)) {
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
            </td>
        </tr>';
    }
}
?>
