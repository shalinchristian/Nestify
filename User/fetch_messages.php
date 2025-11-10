<?php
include 'db.php';
header('Content-Type: application/json');

if (!isset($_GET['property_id'])) {
    echo json_encode(["error" => "Property ID is required."]);
    exit();
}

$property_id = intval($_GET['property_id']);
$query = "SELECT c.*, u.username AS sender_name 
          FROM chats c
          JOIN users u ON c.sender_id = u.id
          WHERE c.property_id = $property_id
          ORDER BY c.timestamp ASC";

$result = mysqli_query($conn, $query);
$messages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = [
        "sender_name" => $row['sender_name'],
        "message" => $row['message'],
        "timestamp" => $row['timestamp']
    ];
}

echo json_encode($messages);
?>
