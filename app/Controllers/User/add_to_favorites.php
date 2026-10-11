<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}

$user_id = intval($_SESSION['user_id']); 
$property_id = intval($_POST['property_id']);

// Check if the property is already in favorites
$check_sql = "SELECT * FROM favorites WHERE user_id = ? AND property_id = ?";
$check_result = db_query($conn, $check_sql, "ii", $user_id, $property_id);

if (mysqli_num_rows($check_result) > 0) {
    // If exists, remove from favorites
    $delete_sql = "DELETE FROM favorites WHERE user_id = ? AND property_id = ?";
    db_query($conn, $delete_sql, "ii", $user_id, $property_id);
    
    echo "removed"; // Return status to AJAX
} else {
    // If not exists, add to favorites
    $insert_sql = "INSERT INTO favorites (user_id, property_id) VALUES (?, ?)";
    db_query($conn, $insert_sql, "ii", $user_id, $property_id);
    
    echo "added"; // Return status to AJAX
}

mysqli_close($conn);
?>
