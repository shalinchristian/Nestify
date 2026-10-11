<?php
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Single place for SMTP settings (previously copy-pasted in Signup, Agent_Signup,
 * resend_otp and forget_password, the last one with placeholder credentials).
 */
function nestify_mailer(string $fromName = 'Nestify OTP System'): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
    $mail->SMTPAuth = true;
    $mail->Username = env('EMAIL_USER');
    $mail->Password = env('EMAIL_PASS');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = (int) env('MAIL_PORT', 587);
    $mail->setFrom(env('EMAIL_USER', 'no-reply@nestify.local'), $fromName);
    return $mail;
}
