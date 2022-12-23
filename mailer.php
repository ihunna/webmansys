
<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP; 
  use PHPMailer\PHPMailer\Exception;
    
  require 'vendor/autoload.php';
    
  
  function sendMail($email,$subject,$msg){
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'utf-8';
        $mail->SMTPDebug = 0;                                       
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com;';                    
        $mail->SMTPAuth   = true;                             
        $mail->Username   = smtp_email;                 
        $mail->Password   = smtp_pass;                        
        $mail->SMTPSecure = 'ssl';                              
        $mail->Port       = 465;  

        $site_link = (str_contains($_SERVER['SERVER_NAME'],'.com'))?$_SERVER['SERVER_NAME']:$_SERVER['SERVER_NAME'].'.com';
      
        $mail->setFrom('noreply@'.$site_link.'', ''.site_name.' Support');           
        $mail->addAddress($email);
        $mail->isHTML(true);                                  
        $mail->Body = $msg;
        
        $mail->Subject = $subject;
        $mail->send();
       return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
  }
  ?>