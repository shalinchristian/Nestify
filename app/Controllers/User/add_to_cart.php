<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in");
}

$user_id = intval($_SESSION['user_id']); 
$property_id = intval($_POST['property_id']);

// Check if user exists in users table
$user_check_query = "SELECT id FROM users WHERE id = ?";
$user_check_result = db_query($conn, $user_check_query, "i", $user_id);
if (mysqli_num_rows($user_check_result) == 0) {
    exit("Invalid user");
}

// Check if property exists in properties table
$property_check_query = "SELECT property_id FROM properties WHERE property_id = ?";
$property_check_result = db_query($conn, $property_check_query, "i", $property_id);
if (mysqli_num_rows($property_check_result) == 0) {
    exit("Invalid property");
}

// Check if already in cart
$check_cart_query = "SELECT * FROM cart WHERE user_id = ? AND property_id = ?";
$check_cart_result = db_query($conn, $check_cart_query, "ii", $user_id, $property_id);

if (mysqli_num_rows($check_cart_result) == 0) {
    $insert_query = "INSERT INTO cart (user_id, property_id) VALUES (?, ?)";
    if (db_query($conn, $insert_query, "ii", $user_id, $property_id)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Already in cart";
}

mysqli_close($conn);
?>
