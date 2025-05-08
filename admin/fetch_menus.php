<?php
include("../connection/connect.php");
session_start();

$admin_id = $_SESSION['adm_id'];
$restaurant_id = isset($_POST['restaurant_filter']) ? $_POST['restaurant_filter'] : '';

if (!empty($restaurant_id)) {
    $sql = "SELECT * FROM dishes WHERE adm_id=? AND rs_id=? ORDER BY d_id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $admin_id, $restaurant_id);
} else {
    $sql = "SELECT * FROM dishes WHERE adm_id=? ORDER BY d_id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $admin_id);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<tr><td colspan="7"><center>No Menu</center></td></tr>';
} else {
    while ($rows = $result->fetch_assoc()) {
        $res_stmt = $db->prepare("SELECT title FROM restaurant WHERE rs_id=?");
        $res_stmt->bind_param("s", $rows['rs_id']);
        $res_stmt->execute();
        $res = $res_stmt->get_result()->fetch_assoc();

        echo '<tr>
            <td><center><img src="Res_img/dishes/' . $rows['img'] . '" class="img-responsive radius" style="width:32px;height:32px;" /></center></td>
            <td>' . htmlspecialchars($res['title']) . '</td>
            <td>' . htmlspecialchars($rows['title']) . '</td>
            <td>' . htmlspecialchars($rows['slogan']) . '</td>
            <td>$' . htmlspecialchars($rows['price']) . '</td>
            <td>' . htmlspecialchars($rows['quantity']) . '</td>
            <td>
                <a href="delete_menu.php?menu_del=' . $rows['d_id'] . '" onclick="return confirm(\'Are you sure you want to delete this menu item?\');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o"></i></a>
                <a href="update_menu.php?menu_upd=' . $rows['d_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
            </td>
        </tr>';
    }
}
?>
