<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

if (!isset($_POST['property_id']) || empty($_POST['property_id'])) {
    echo "Invalid request.";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$property_id = intval($_POST['property_id']);

// Delete the favorite property
$query = "DELETE FROM favorites WHERE user_id = ? AND property_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $property_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
