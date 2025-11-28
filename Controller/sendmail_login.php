
<?php 
// Import PHPMailer classes into the global namespace // These must be at the top of your script, not inside a function 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php'; 
require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 


function sendOtp($adress, $otp)
{
	
	$mail = new PHPMailer(true); // Passing `true` enables exceptions 
	try { 
	//Server settings 
		$mail->SMTPDebug = 0; // Enable verbose debug output 
         $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nhthin366@gmail.com';
            $mail->Password = 'zhfk ynjf bhue xucf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';


		//Recipients 
		$mail->setFrom('FUJICARS@gmail.com', 'Admin STCC Recover Password'); //This is the email your form sends From 
		$mail->addAddress($adress, 'Mail to:'); // Add a recipient address 
		//Content 
		$mail->isHTML(true); // Set email format to HTML 
		$mail->Subject = 'From email:';
		$mail->Body = 'Mã xác thực của bạn là:'.$otp; 

		$mail->send(); echo 'Message has been sent'; 
	} catch (Exception $e) { 
		echo 'Message could not be sent.'; 
		echo 'Mailer Error: ' . $mail->ErrorInfo; 
	} 
}

?>