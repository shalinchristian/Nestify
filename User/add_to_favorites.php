<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}

$user_id = intval($_SESSION['user_id']); 
$property_id = intval($_POST['property_id']);

// Check if the property is already in favorites
$check_sql = "SELECT * FROM favorites WHERE user_id = $user_id AND property_id = $property_id";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // If exists, remove from favorites
    $delete_sql = "DELETE FROM favorites WHERE user_id = $user_id AND property_id = $property_id";
    mysqli_query($conn, $delete_sql);
    
    echo "removed"; // Return status to AJAX
} else {
    // If not exists, add to favorites
    $insert_sql = "INSERT INTO favorites (user_id, property_id) VALUES ($user_id, $property_id)";
    mysqli_query($conn, $insert_sql);
    
    echo "added"; // Return status to AJAX
}

mysqli_close($conn);
?>
