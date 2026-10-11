<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $query = "SELECT Id FROM users WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;

        // Store OTP
        $update_query = "UPDATE users SET otp = ?, Created_at = NOW() WHERE Email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("is", $otp, $email);
        $update_stmt->execute();

        // Send OTP via email
        
        try {
            $mail = nestify_mailer('Nestify Support');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset OTP - Nestify";
            $mail->Body = "Your OTP for password reset is: $otp\nDo not share this OTP.";

            if ($mail->send()) {
                $_SESSION['message'] = "OTP sent to your email.";
                header("Location: verify_forgot_otp.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to send OTP.";
            }
        } catch (Exception $e) {
            $_SESSION['message'] = "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['message'] = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password | Nestify</title>
    <style>
        <?php include ROOT_PATH . '/public/assets/user/Style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Forgot Password</h2>
            <?php if (isset($_SESSION['message'])) echo "<p class='error'>{$_SESSION['message']}</p>"; ?>
            <form action="" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Send OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
