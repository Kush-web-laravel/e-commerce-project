<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com'); // Set the SMTP server to send through
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME', 'kushchhatbar19@gmail.com');
            $mail->Password   = env('MAIL_PASSWORD', 'xrcamhvsunocdlmh');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = env('MAIL_PORT', 465);
    

            //Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'hello@example.com'), env('MAIL_FROM_NAME', 'Example'));
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
