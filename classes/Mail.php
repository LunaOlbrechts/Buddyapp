<?php 
use PHPMailer\PHPMailer\PHPMailer;

include_once(__DIR__ . "/../PHPMailer/PHPMailer.php");
include_once(__DIR__ . "/../PHPMailer/SMTP.php");
include_once(__DIR__ . "/../PHPMailer/Exception.php");
include_once(__DIR__ . "/SettingsEmail.php");


class Mail{

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

    public static function sendEmail(){
       $result = UserManager::getUserFromDatabase();
    
       $email = $result[0]['email'];

       if($result){
            $subject = "Hallo! Iemand heeft jou een buddyverzoek verstuurd";
            $msg = "Ontdek snel wie jou een buddyverzoek gestuurd heeft <a href=\"http://localhost:8888/Buddyapp/profile.php" . "\">link</a> ";
            $msg = wordwrap($msg, 70);
    
            $mail = self::settings();
    
            $mail->addAddress($email); 
            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->isHTML(true);

            $result = $mail->send();

            return $result;
        }
       return false;
    }
}