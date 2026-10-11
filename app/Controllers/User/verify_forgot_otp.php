<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['reset_email'];
    $otp_entered = intval($_POST['otp']);

    // Validate OTP
    $query = "SELECT Id, otp, Created_at FROM users WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $otp_stored, $otp_created_at);
    $stmt->fetch();
    
    if (!$otp_stored || strtotime($otp_created_at) + 600 < time()) {
        $_SESSION['message'] = "OTP expired. Request a new OTP.";
        header("Location: forgot_password.php");
        exit();
    }

    if ($otp_stored == $otp_entered) {
        $_SESSION['verified_reset'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $_SESSION['message'] = "Incorrect OTP!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP | Nestify</title>
    <style>
        <?php include ROOT_PATH . '/public/assets/user/Style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>OTP Verification</h2>
            <?php if (isset($_SESSION['message'])) echo "<p class='error'>{$_SESSION['message']}</p>"; ?>
            <form action="" method="POST">
                <div class="otp-inputs">
                    <input type="text" name="otp1" maxlength="1" required>
                    <input type="text" name="otp2" maxlength="1" required>
                    <input type="text" name="otp3" maxlength="1" required>
                    <input type="text" name="otp4" maxlength="1" required>
                </div>
                <input type="hidden" name="otp" id="otp">
                <button type="submit">Verify OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
