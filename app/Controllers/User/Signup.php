<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php'; // Database connection

// Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["fullname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);

    if (empty($name) || empty($email) || empty($password)) {
        exit("All fields are required!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format!");
    }

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT Id FROM Users WHERE Email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        exit("Email already registered!");
    }
    $check_stmt->close();

    if (strlen($password) < 8) {
        exit("Password must be at least 8 characters long!");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $otp = rand(1000, 9999);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO Users (Name, Email, Password, Otp, Verified) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $otp);

    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        
        // Send OTP Email
        

        try {
            $mail = nestify_mailer('Nestify OTP System');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Your OTP Code";
            $mail->Body = generateOtpEmailBody($otp);

            if ($mail->send()) {
                $_SESSION['message'] = 'OTP sent successfully. Please check your email.';
                header('Location: OtpPage.php');
                exit();
            } else {
                $_SESSION['message'] = 'OTP Email could not be sent. Try again later.';
                header('Location: AuthenticationPage.php#signup-form');
                exit();
            }
        } catch (Exception $e) {
            exit("<script>alert('OTP Email could not be sent. Error: " . $e->getMessage() . "'); window.location.href = 'OtpPage.php';</script>");
        }
    } else {
        exit("Error: " . $stmt->error);
    }
}

function generateOtpEmailBody($otp) {
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

$conn->close();
?>