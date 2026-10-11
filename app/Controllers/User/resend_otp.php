<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php'; // Database connection

// Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['email'])) {
    die("Session expired! Please sign up again.");
}

$email = $_SESSION['email'];

// Generate new OTP
$new_otp = rand(1000, 9999);
$hashed_otp = password_hash($new_otp, PASSWORD_DEFAULT);

// Update OTP in the database
$stmt = $conn->prepare("UPDATE users SET otp = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_otp, $email);

if ($stmt->execute()) {
    // Send OTP via email
    

    try {
        $mail = nestify_mailer('Nestify OTP System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Your OTP Code";
        $mail->Body = RegenerateOtpEmailBody($new_otp); // Fixed variable name

        if ($mail->send()) {
            $_SESSION['message'] = 'OTP sent successfully. Please check your email.';
        } else {
            $_SESSION['message'] = 'OTP Email could not be sent. Try again later.';
        }

        // Close the database connection before redirecting
        $conn->close();
        header('Location: OtpPage.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['message'] = 'OTP Email could not be sent. Error: ' . $e->getMessage();
        $conn->close();
        header('Location: OtpPage.php');
        exit();
    }
} else {
    die("Error: Could not update OTP in database.");
}

$conn->close();

function RegenerateOtpEmailBody($otp) {
    return "<html>
  <head>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap' rel='stylesheet'/>
  </head>
  <body style='font-family: Poppins, sans-serif; background: #ffffff;'>
    <div style='max-width: 680px; margin: 0 auto; padding: 45px 30px 60px; background: #f4f7ff;'>
      <header>
        <table style='width: 100%;'>
          <tr>
            <td>
              <img alt='Nestify Logo' src='images/Nestify-Logo.png' height='30px'/>
            </td>
            <td style='text-align: right;'>
              <span style='color: #ffffff;'>".date('d M, Y')."</span>
            </td>
          </tr>
        </table>
      </header>

      <main>
        <div style='padding: 92px 30px 115px; background: #ffffff; border-radius: 30px; text-align: center;'>
          <h1>Your OTP Code</h1>
          <p>Hey User,</p>
          <p>Thank you for choosing <strong>Nestify</strong>. Use the following OTP to complete your email verification. The OTP is valid for <strong>5 minutes</strong>. Please do not share this code with anyone.</p>
          <p style='font-size: 40px; font-weight: 600; color: #ba3d4f;'>$otp</p>
        </div>
      </main>

      <footer style='text-align: center; border-top: 1px solid #e6ebf1; padding-top: 20px;'>
        <p>Nestify House Rentals</p>
        <p>114-Prince Hostel, opp.Charusat, Changa-388421</p>
        <p><a href='mailto:Nestifymail@gmail.com'>Nestifymail@gmail.com</a></p>
      </footer>
    </div>
  </body>
</html>";
}
?>
