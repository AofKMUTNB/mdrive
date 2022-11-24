
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
include("../conf.php");
$username=$_POST['username'];
$sqli=$conn->query("SELECT `password`,`email` FROM `tbl_employee` WHERE `username`='$username'");
list($password,$email)=mysqli_fetch_row($sqli);
$mail = new PHPMailer;
$mail->CharSet = "utf-8";
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;


$mail->Username = "mainemailforyou@gmail.com";
$mail->Password = "saiumm1736";
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom("mainemailforyou@gmail.com", 'Forgot Password');
$mail->addReplyTo("mainemailforyou@gmail.com", 'Forgot Password');

// Add a recipient
$mail->addAddress($email);

$mail->Subject = "Forgot Password";

// Set email format to HTML
$mail->isHTML(true);


$txt="";
$txt.="คำขอรับรหัสผ่าน
<br>
<p>รหัสผ่านของท่านคือ : ".$password."</p>
";

$mail->Body = $txt;
$arr=array();
// Send email
if(!$mail->send()){
					// echo 'Message could not be sent.';
	$arr['tus']="error";
					// echo "เกิดความผิดพลาด กรุณาลองใหม่อีกครั้ง !";
}else{
	$arr['tus']=$email;
}

echo json_encode($arr);






