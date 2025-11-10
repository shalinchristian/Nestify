<?php
session_start();
include 'db.php'; // Include database connection

// Check if the agent has a session email
if (!isset($_SESSION['email'])) {
    $_SESSION['message'] = 'Session expired. Please register again.';
    header('Location: Agent_Signup.php');
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

    // Prepare and execute SQL statement to fetch agent details
    $stmt = $conn->prepare("SELECT dealer_id, fullname, otp, created_at, verified FROM Dealers WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($dealer_id, $fullname, $otp_stored, $otp_created_at, $is_verified);
        $stmt->fetch();
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Database error: Unable to prepare statement.';
        header('Location: OtpPage.php');
        exit();
    }

    // If the agent is already verified, redirect to home
    if ($is_verified === 'Verified') {
        $_SESSION['dealer_id'] = $dealer_id;
        $_SESSION['dealer_name'] = $fullname;
        $_SESSION['message'] = 'OTP verified successfully. Your account is now activated.';
        header('Location: AgentDashboard.php');
        exit();
    }

    // Set the timezone
    date_default_timezone_set('Europe/Berlin');
    $current_time = date("Y-m-d H:i:s");

    // Check if OTP is expired (10-minute validity)
    if (!$otp_created_at || strtotime($current_time) > strtotime($otp_created_at) + 600) {
        $_SESSION['message'] = 'OTP has expired. Please request a new OTP.';
        header('Location: OtpPage.php');
        exit();
    }

    // Check if OTP is correct
    if ($otp_stored != (int) $otp_entered) {
        $_SESSION['message'] = 'Incorrect OTP entered. Please try again.';
        header('Location: OtpPage.php');
        exit();
    }

    // If OTP is correct, update agent verification status
    $stmt = $conn->prepare("UPDATE Dealers SET verified = 'Verified' WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $_SESSION['dealer_id'] = $dealer_id;
            $_SESSION['dealer_name'] = $fullname;
            $_SESSION['message'] = 'OTP verified successfully. Your account is now activated.';
            header('Location: AgentDashboard.php');
        } else {
            $_SESSION['message'] = 'Database error: Unable to update verification.';
            header('Location: OtpPage.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Database error: Unable to prepare update statement.';
        header('Location: OtpPage.php');
    }
}

$conn->close();
?>