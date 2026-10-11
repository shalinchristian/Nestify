<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

$response = ["loggedIn" => false];

if (isset($_SESSION['user_id'])) {
    $response["loggedIn"] = true;
    $response["userName"] = $_SESSION['user_name']; // Return the user's name
}

echo json_encode($response);
?>
