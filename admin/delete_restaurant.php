<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

$res_id = $_GET['res_del'];

// Delete dishes associated with the restaurant
mysqli_query($db, "DELETE FROM dishes WHERE rs_id = '" . $res_id . "'");

// Delete the restaurant
mysqli_query($db, "DELETE FROM restaurant WHERE rs_id = '" . $res_id . "'");
header("location:all_restaurant.php");

?>