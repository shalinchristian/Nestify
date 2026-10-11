<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php'; // Include database connection

// Check if the user is logged in and has a session email
if (!isset($_SESSION['email'])) {
    $_SESSION['message'] = 'Session expired. Please register again.';
    header('Location: AuthenticationPage.php?show=signup');
    exit();
}

$email = $_SESSION['email'];
$otp_entered = isset($_POST['otp']) ? trim($_POST['otp']) : '';

// Validate OTP input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($otp_entered)) {
        $_SESSION['message'] = 'OTP is required.';
        header('Location: AuthenticationPage.php?show=signup');
        exit();
    }

    // Prepare and execute SQL statement to fetch user details
    $stmt = $conn->prepare("SELECT Id, Name, Otp, Created_at, Verified FROM Users WHERE Email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $user_name, $otp_stored, $otp_created_at, $is_verified);
        $stmt->fetch();
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Database error: Unable to prepare statement.';
        header('Location:OtpPage.php');
        exit();
    }

    // If the user is already verified, redirect to home
    if ($is_verified == 1) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['message'] = 'OTP verified successfully. Your account is now activated.';
        header('Location: Home.php');
        exit();
    }

    // Set the timezone
    date_default_timezone_set('Europe/Berlin');
    $current_time = date("Y-m-d H:i:s");

    // Check if OTP is expired (10-minute validity)
    if (!$otp_created_at || strtotime($current_time) > strtotime($otp_created_at) + 600) {
        $_SESSION['message'] = 'OTP has expired. Please request a new OTP.';
        header('Location:OtpPage.php');
        exit();
    }

    // Check if OTP is correct
    if ($otp_stored != (int) $otp_entered) {
        $_SESSION['message'] = 'Incorrect OTP entered. Please try again.';
        header('Location:OtpPage.php');
        exit();
    }

    // If OTP is correct, update user verification status
    $stmt = $conn->prepare("UPDATE Users SET Verified = 1 WHERE Email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['message'] = 'OTP verified successfully. Your account is now activated.';
            header('Location:Home.php');
        } else {
            $_SESSION['message'] = 'Database error: Unable to update verification.';
            header('Location:OtpPage.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Database error: Unable to prepare update statement.';
        header('Location:OtpPage.php');
    }
}

$conn->close();
?>