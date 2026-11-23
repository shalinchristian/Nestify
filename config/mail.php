<?php
use PHPMailer\PHPMailer\PHPMailer;

/*
 * smtp settings in one place so signup, agent signup, resend otp and
 * forgot password all use the same ones
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
