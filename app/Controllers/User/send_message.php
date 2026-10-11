<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message_sent'] = "You must be logged in to send a message.";
    header("Location: property_detail.php?property_id=" . intval($_POST['property_id']));
    exit();
}

$user_id = intval($_SESSION['user_id']);
$property_id = intval($_POST['property_id']);
$dealer_id = intval($_POST['dealer_id']);
$message = trim($_POST['message']);

// Check for empty message
if (empty($message)) {
    $_SESSION['message_sent'] = "Message cannot be empty.";
    header("Location: property_detail.php?property_id=" . $property_id);
    exit();
}

// Check if the user already sent a message for this property
$check_query = "SELECT message_id FROM message WHERE user_id = ? AND property_id = ?";
$check_result = db_query($conn, $check_query, "ii", $user_id, $property_id);

if (mysqli_num_rows($check_result) > 0) {
    // Message exists, so do not allow sending another
    $_SESSION['message_sent'] = "You have already sent a message for this property.";
    header("Location: property_detail.php?property_id=" . $property_id);
    exit();
}

// Insert the new message
$insert_query = "INSERT INTO message (user_id, dealer_id, property_id, message) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "iiis", $user_id, $dealer_id, $property_id, $message);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['message_sent'] = "Message sent successfully!";
} else {
    $_SESSION['message_sent'] = "Failed to send message.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect back to the property details page
header("Location: property_detail.php?property_id=" . $property_id);
exit();
?>
