<?php

use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
				require 'PHPMailer/Exception.php';
				require 'PHPMailer/PHPMailer.php';
				require 'PHPMailer/SMTP.php';



session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newspaper";

date_default_timezone_set("Asia/Bangkok");

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn,"utf8");

$act = $_REQUEST['act'];
switch ($act) {
	case 'sendmail':
	$types=$_REQUEST['types'];
	$detail_emails=$_REQUEST['detail_emails'];
	$title_emails=$_REQUEST['title_emails'];
	if($types=="all")
	{
		$sum=0;
			$sql="SELECT * FROM `tb_customer`";
			$result_numpage  = $conn->query($sql);
				$num_data        = $result_numpage->num_rows;
				if($num_data > 0){ 
					$num = 0;
					while($row = $result_numpage->fetch_assoc()) {

				$mail = new PHPMailer;
				$mail->CharSet = "utf-8";
						// $arr['data'][$num]['id']                = $row["id"];
						$mail->isSMTP();
						$mail->Host = 'smtp.gmail.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'wondergamesforkids098@gmail.com';
						$mail->Password = 'wonder098';
						$mail->SMTPSecure = 'tls';
						$mail->Port = 587;

						$mail->setFrom($row["email"], 'Admin');

						$mail->addAddress($row["email"]);
						$mail->Subject = $title_emails;

// Set email format to HTML
						$mail->isHTML(true);

// Email body content
						$mailContent = $detail_emails;
						$mail->Body = $mailContent;

// Send email
						if(!$mail->send()){
							$sum+=1;
							
						}else{
							$sum=0;
							
						}
						$num++;
					}

				}
				echo 'ทำรายการสำเร็จ';

		

	}else if($types=="customer")
	{
	$ids=$_REQUEST['ids'];

		$sql="SELECT * FROM `tb_customer` where id='$ids'";
			$result_numpage  = $conn->query($sql);
			list($id,$fullname,$lastname,$tell,$email,$line,$ip,$date_regis,$username,$pass,$status,$online)=mysqli_fetch_row($result_numpage);
				

// SMTP configuration
			
				$mail = new PHPMailer;
				$mail->CharSet = "utf-8";
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'wondergamesforkids098@gmail.com';
				$mail->Password = 'wonder098';
				$mail->SMTPSecure = 'tls';
				$mail->Port = 587;

				$mail->setFrom($email, 'Admin');
//$mail->addReplyTo('info@example.com', 'CodexWorld');

// Add a recipient
				$mail->addAddress($email);

// Add cc or bcc 
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

// Add attachments
				// $mail->addAttachment('files/codexworld.pdf');

// Email subject
				$mail->Subject = $title_emails;

// Set email format to HTML
				$mail->isHTML(true);

// Email body content
				$mailContent = $detail_emails;
				$mail->Body = $mailContent;

// Send email
				if(!$mail->send()){
					// echo 'Message could not be sent.';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
					echo "เกิดความผิดพลาด กรุณาลองใหม่อีกครั้ง !";
				}else{
					echo 'ทำรายการสำเร็จ';
				}
			

	}




	

	break;


}


