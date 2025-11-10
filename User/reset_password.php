<?php
session_start();
include 'db.php';

if (!isset($_SESSION['verified_reset'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['verified_reset'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Update password and clear OTP
    $query = "UPDATE users SET Password = ?, otp = NULL WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $new_password, $email);
    
    if ($stmt->execute()) {
        session_destroy();
        echo "Password reset successful. <a href='AuthenticationPage.php'>Login Now</a>";
    } else {
        echo "Error resetting password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password | Nestify</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Reset Password</h2>
            <?php if (isset($_SESSION['message'])) echo "<p class='error'>{$_SESSION['message']}</p>"; ?>
            <form action="" method="POST">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
