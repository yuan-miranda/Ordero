<?php
session_start();
include("connection/connect.php");

$upload_dir = __DIR__ . "/uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['imageData'])) {
    // Handle base64 image from camera capture
    $imgData = $_POST['imageData'];

    $imgData = preg_replace('#^data:image/\w+;base64,#i', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);

    $decoded = base64_decode($imgData);
    if ($decoded === false) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Base64 decode failed']);
        exit;
    }

    $filename = uniqid('selfie_') . '.png';
    $filepath = $upload_dir . $filename;

    if (file_put_contents($filepath, $decoded)) {
        echo json_encode(['status' => 'success', 'path' => $filepath]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to save base64 file']);
    }

} elseif (isset($_FILES['selfie'])) {
    // Handle direct file upload
    $file = $_FILES['selfie'];
    if ($file['error'] !== 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'File upload error: ' . $file['error']]);
        exit;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        exit;
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('selfie_') . '.' . $ext;
    $filepath = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        echo json_encode(['status' => 'success', 'path' => $filepath]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
    }

} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No image data received']);
}
?>