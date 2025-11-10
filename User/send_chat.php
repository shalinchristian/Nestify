    <?php
    session_start();
    include 'db.php';

    // header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in."]);
        exit();
    }

    if (!isset($_POST['property_id'], $_POST['message'], $_POST['receiver_id'])) {
        echo json_encode(["error" => "Invalid request."]);
        exit();
    }

    $user_id = intval($_SESSION['user_id']);
    $property_id = intval($_POST['property_id']);
    $receiver_id = intval($_POST['receiver_id']);
    $message = trim($_POST['message']);

    if (empty($message)) {
        echo json_encode(["error" => "Message cannot be empty."]);
        exit();
    }

    // Insert into database
    $query = "INSERT INTO chats (sender_id, receiver_id, property_id, message, status) VALUES (?, ?, ?, ?, 'sent')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iiis", $user_id, $receiver_id, $property_id, $message);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message_sent'] = "Message sent successfully!";
        header("Location: property_chat.php?property_id=$property_id");
        // echo "<script>window.history.back();</script>";
    } else {
        $_SESSION['message_sent'] = "Failed to send message.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
