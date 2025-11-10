<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in");
}

$user_id = intval($_SESSION['user_id']); 
$property_id = intval($_POST['property_id']);

// Check if user exists in users table
$user_check_query = "SELECT id FROM users WHERE id = $user_id";
$user_check_result = mysqli_query($conn, $user_check_query);
if (mysqli_num_rows($user_check_result) == 0) {
    exit("Invalid user");
}

// Check if property exists in properties table
$property_check_query = "SELECT property_id FROM properties WHERE property_id = $property_id";
$property_check_result = mysqli_query($conn, $property_check_query);
if (mysqli_num_rows($property_check_result) == 0) {
    exit("Invalid property");
}

// Check if already in cart
$check_cart_query = "SELECT * FROM cart WHERE user_id = $user_id AND property_id = $property_id";
$check_cart_result = mysqli_query($conn, $check_cart_query);

if (mysqli_num_rows($check_cart_result) == 0) {
    $insert_query = "INSERT INTO cart (user_id, property_id) VALUES ($user_id, $property_id)";
    if (mysqli_query($conn, $insert_query)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Already in cart";
}

mysqli_close($conn);
?>
