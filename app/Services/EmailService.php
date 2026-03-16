<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send a welcome email to the newly registered user.
     *
     * @param string $email
     * @param string $name
     * @return bool
     */
    public static function sendWelcomeEmail($email, $name)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION'); // ssl or tls
            $mail->Port       = env('MAIL_PORT');

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $subject = 'Welcome to ' . env('APP_NAME');
            $mail->Subject = $subject;

            $loginUrl = env('APP_URL') . '/auth/login';
            $appName = env('APP_NAME');

            $mail->Body = "
                <p>Hello {$name},</p>
                <p>Your account has been successfully created.</p>
                <p>You can now log in and start using the platform.</p>
                <p>Login URL: <a href='{$loginUrl}'>{$loginUrl}</a></p>
                <p>Regards,<br>{$appName} Team</p>
            ";

            $mail->AltBody = "Hello {$name},\n\n" .
                            "Your account has been successfully created.\n" .
                            "You can now log in and start using the platform.\n\n" .
                            "Login URL: {$loginUrl}\n\n" .
                            "Regards,\n" .
                            "{$appName} Team";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error("Email sending failed for {$email}: " . $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * Send OTP email for registration verification
     */
    public static function sendOtpEmail($email, $name, $otp)
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port       = env('MAIL_PORT');

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Your OTP for Registration - " . env('APP_NAME');
            
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px;'>
                    <h2 style='color: #4f46e5; text-align: center;'>Email Verification</h2>
                    <p>Hello <strong>$name</strong>,</p>
                    <p>Thank you for signing up. Please use the following One-Time Password (OTP) to verify your email address:</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; background-color: #f3f4f6; padding: 10px 20px; border-radius: 5px; border: 1px dashed #4f46e5;'>$otp</span>
                    </div>
                    <p>This code is valid for 10 minutes. If you did not request this, please ignore this email.</p>
                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #6b7280; text-align: center;'>Best regards,<br>The " . env('APP_NAME') . " Team</p>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error("OTP Email sending failed for {$email}: " . $mail->ErrorInfo);
            return false;
        }
    }
}
