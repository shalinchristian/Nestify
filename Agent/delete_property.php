<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['property_id'])) {
    $property_id = intval($_POST['property_id']); // Ensure it's a valid integer

    $stmt = $conn->prepare("DELETE FROM Properties WHERE property_id = ?");
    $stmt->bind_param("i", $property_id);

    if ($stmt->execute()) {
        echo 'success'; // This response will be used in JavaScript
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
