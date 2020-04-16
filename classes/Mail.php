<?php 
use PHPMailer\PHPMailer\PHPMailer;

include_once(__DIR__ . "/../PHPMailer/PHPMailer.php");
include_once(__DIR__ . "/../PHPMailer/SMTP.php");
include_once(__DIR__ . "/../PHPMailer/Exception.php");
include_once(__DIR__ . "/SettingsEmail.php");
include_once(__DIR__ . "/Db.php");



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

    public static function sendEmailBuddyRequest(){

       $idReciever = $_SESSION['reciever_id'];
       $result = UserManager::getUserFromDatabaseById($idReciever);

       $emailReciever = $result[0]['email'];

       if($result){
            $subject = "Hallo! Iemand heeft jou een buddyverzoek verstuurd";
            $msg = "Ontdek snel wie jou een buddyverzoek gestuurd heeft <a href=\"http://localhost:8888/Buddyapp/profile.php" . "\">link</a> ";
            $msg = wordwrap($msg, 70);
    
            $mail = self::settings();
    
            $mail->addAddress($emailReciever); 
            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->isHTML(true);

            $result = $mail->send();

            return $result;
        }

       return false;

    }

    public static function sendEmailSignup(){

        $id = $_SESSION['user_id'];

        $user = UserManager::getUserFromDatabaseById($id);
 
        $email = $user[0]['email'];
        $token = bin2hex(random_bytes(50));
        
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_signup_email (email, token) VALUES (:email, :token)");

        $token = bin2hex(random_bytes(50));

        $statement->bindValue(':email', $email);
        $statement->bindValue(':token', $token);
 
        $result = $statement->execute();
        
        if($result){
             $subject = "Hallo! Welkom bij Buddy.";
             $msg = "Bevestig jouw email door op deze link te klikken <a href=\"http://localhost:8888/Buddyapp/complete.profile.php?token=" . $token . "\" ></a> ";
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