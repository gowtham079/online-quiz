<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if (!function_exists('sendResultEmail')) {
    function sendResultEmail($toEmail, $toName, $score, $total)
    {
        $mail = new PHPMailer(true);

        // Keep previous direct Gmail SMTP configuration
        $smtpHost = 'smtp.gmail.com';
        $smtpPort = 465;
        $smtpUser = 'gowthamgg4248@gmail.com';
        $smtpPass = 'briraciuqucnlvih';
        $fromEmail = 'gowthamgg4248@gmail.com';
        $fromName  = 'Quiz System';

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = $smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtpUser;
            $mail->Password   = $smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $smtpPort;

            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName);
            $mail->addReplyTo($fromEmail, $fromName);

            $mail->isHTML(true);
            $mail->Subject = 'Your Quiz Results';
            $bodyName = htmlspecialchars((string)$toName, ENT_QUOTES, 'UTF-8');
            $bodyEmail = htmlspecialchars((string)$toEmail, ENT_QUOTES, 'UTF-8');
            $mail->Body = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:14px">'
                . '<p>Name: ' . $bodyName . '</p>'
                . '<p>Marks: ' . (int)$score . ' / ' . (int)$total . '</p>'
                . '<p>Email: ' . $bodyEmail . '</p>'
                . '</div>';
            $mail->AltBody = 'Name: ' . $toName . "\n" . 'Marks: ' . $score . ' / ' . $total . "\n" . 'Email: ' . $toEmail;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}