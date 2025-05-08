<?php
include("../connection/connect.php");
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$user_id = 1;

if (!isset($data['items']) || !is_array($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
    exit();
}

foreach ($data['items'] as $item) {
    $title = mysqli_real_escape_string($db, $item['title']);
    $quantity = mysqli_real_escape_string($db, $item['quantity']);
    $price = mysqli_real_escape_string($db, $item['price']);
    $d_id = mysqli_real_escape_string($db, $item['d_id']);

    // Get rs_id using d_id
    $res_query = mysqli_query($db, "SELECT rs_id FROM dishes WHERE d_id='$d_id'");
    $res_row = mysqli_fetch_assoc($res_query);

    if (!$res_row) continue; // Skip if dish not found

    $rs_id = $res_row['rs_id'];

    // Insert into orders table
    $insert = mysqli_query($db, "INSERT INTO users_orders(u_id, title, quantity, price, d_id, rs_id)
                                 VALUES('$user_id', '$title', '$quantity', '$price', '$d_id', '$rs_id')");
}

echo json_encode(['success' => true]);
