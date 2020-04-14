<?php 
use PHPMailer\PHPMailer\PHPMailer;

include_once(__DIR__ . "/../PHPMailer/PHPMailer.php");
include_once(__DIR__ . "/../PHPMailer/SMTP.php");
include_once(__DIR__ . "/../PHPMailer/Exception.php");
include_once(__DIR__ . "/SettingsEmail.php");


class Email{

    public static function settings()
    {
        $password = SettingsEmail::PASSWORD;
        $fromEmail = SettingsEmail::EMAIL;
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = $fromEmail;
        $mail->Password = $password;
        $mail->setFrom($fromEmail, "IMD buddy");
        $mail->Port = "465"; 
        $mail->SMTPSecure = "ssl";

        return $mail;
    }
}