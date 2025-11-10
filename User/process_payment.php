<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$user_id = intval($_SESSION['user_id']);
$property_id = intval($_POST['property_id']);
$method = $_POST['method']; // QR or UPI

// Fetch property price
$get_amount = "SELECT price, category FROM properties WHERE property_id = $property_id";
$amount_result = mysqli_query($conn, $get_amount);

if (!$amount_result || mysqli_num_rows($amount_result) == 0) {
    echo json_encode(["status" => "error", "message" => "Property not found."]);
    exit();
}

$row = mysqli_fetch_assoc($amount_result);
$amount = $row['price'];
$category = $row['category']; // Get category name

// Insert or update the payment record
$insert_query = "INSERT INTO payments (user_id, property_id, amount, method, status) 
                VALUES ($user_id, $property_id, $amount, '$method', 'Completed')";


if (mysqli_query($conn, $insert_query)) {
    echo json_encode(["status" => "success", "message" => "Payment Completed Successfully!", "category" => $category]);
} else {
    echo json_encode(["status" => "error", "message" => "Payment failed."]);
}

mysqli_close($conn);
?>