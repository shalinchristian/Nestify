<?php
require_once CONFIG_PATH . '/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_id = intval($_POST['message_id']);
    $dealer_response = trim($_POST['dealer_response']);
    
    if (!empty($dealer_response)) {
        $update_query = "UPDATE message SET dealer_response = ?, updated_at = NOW() WHERE message_id = ?";
        if (db_query($conn, $update_query, "si", $dealer_response, $message_id)) {
            echo "<script>alert('Response sent successfully!'); window.location.href='Dashboard.php';</script>";
        } else {
            echo "<script>alert('Error sending response. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Response cannot be empty.'); window.history.back();</script>";
    }
}

mysqli_close($conn);
?>