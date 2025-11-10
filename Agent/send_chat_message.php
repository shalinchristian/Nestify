<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_id = intval($_POST['sender_id']);
    $receiver_id = intval($_POST['receiver_id']);
    $property_id = intval($_POST['property_id']);
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $query = "INSERT INTO chats (sender_id, receiver_id, property_id, message) 
                    VALUES ($sender_id, $receiver_id, $property_id, ?)";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "s", $message);

        if (mysqli_stmt_execute($stmt)) {
            echo "success";
            $_SESSION['message_sent'] = "Message sent successfully!";
        } else {
            echo "error";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "empty";
    }
}
mysqli_close($conn);
