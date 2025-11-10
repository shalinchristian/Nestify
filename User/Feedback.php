<?php
session_start();
include 'fdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Retrieve user ID from session
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($user_id) || empty($subject) || empty($message)) {
        $_SESSION["message"] = "All fields are required!";
        header("Location: Contact.php");
    }

    $stmt = $conn->prepare("INSERT INTO feedback (user_id, subject, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $subject, $message);

    if ($stmt->execute()) {
        $_SESSION["message"] = "Feedback submitted successfully!";
        header("Location: Contact.php");
    } else {
        $_SESSION["message"] = "Error: " . $stmt->error;
        header("Location: Contact.php");
    }

    $stmt->close();
    $conn->close();
}
?>