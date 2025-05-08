<?php
include("../connection/connect.php");
session_start();

$admin_id = $_SESSION['adm_id'];
$category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';

$sql = "SELECT * FROM restaurant WHERE adm_id = ?";
$params = [$admin_id];

if (!empty($category_filter)) {
    $sql .= " AND c_id = ?";
    $params[] = $category_filter;
}
$sql .= " ORDER BY rs_id DESC";

$stmt = $db->prepare($sql);
$stmt->bind_param(str_repeat("s", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<td colspan="11"><center>No Restaurants</center></td>';
} else {
    while ($rows = $result->fetch_assoc()) {
        $cat_stmt = $db->prepare("SELECT c_name FROM res_category WHERE c_id = ?");
        $cat_stmt->bind_param("s", $rows['c_id']);
        $cat_stmt->execute();
        $cat_result = $cat_stmt->get_result()->fetch_assoc();

        echo '<tr>
            <td><center><img src="Res_img/' . $rows['image'] . '" class="img-responsive radius" style="width:32px;height:32px;"/></center></td>
            <td>' . $cat_result['c_name'] . '</td>
            <td>' . $rows['title'] . '</td>
            <td>' . $rows['email'] . '</td>
            <td>' . $rows['phone'] . '</td>
            <td>' . $rows['url'] . '</td>
            <td>' . $rows['o_hr'] . '</td>
            <td>' . $rows['c_hr'] . '</td>
            <td>' . $rows['o_days'] . '</td>
            <td>' . $rows['address'] . '</td>
            <td>' . $rows['date'] . '</td>
            <td>
                <a href="delete_restaurant.php?res_del=' . $rows['rs_id'] . '" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10" onclick="return confirm(\'Are you sure you want to delete this restaurant?\')"><i class="fa fa-trash-o"></i></a> 
                <a href="update_restaurant.php?res_upd=' . $rows['rs_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
            </td>
        </tr>';
    }
}
?>
