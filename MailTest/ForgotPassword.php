<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';

//******************** Forget password mail ********************//
//$from='gesatest1@gmail.com';
$fromNameForget = 'Oncefyxd Helpdesk';
$fromMailForget = 'help@oncefyxd.com';
$fromPasswordForget = 'ofadmin@123';
$subjectForget = 'Oncefyxd Help';

$url = "https://eazypurchaseproducts.com/Home/Epp";

//**************** Common Mail Settings ***********************//
$mail = new PHPMailer();  // create a new object
$mail->IsSMTP(); 
$mail->SMTPAuth = true;  // authentication enabled
$mail->SMTPSecure = 'tls';
//$mail->SMTPDebug = 3;							//Sets connection prefix. Options are "", "ssl" or "tls"
$mail->Host = 'smtpout.asia.secureserver.net';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
$mail->Port = 3535;


$data = json_decode(file_get_contents("php://input"));
echo("test");
print_r($data);

$firstname = $data->firstname;

$lastname = $data->lastname;
$cc = $data->emailid;
$phoneNumber= $data->phoneNumber;
$query= $data->query;
$message= $data->message;

 $to='help@oncefyxd.com';


$body="

  <head>  <title>Untitled Document</title></head>
  <body>

<div style='width:100%;' align='center'>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center' valign='top' style='background-color: #f5f5f5;' bgcolor='#f5f5f5;'>  <br><br>
      <table width='583' border='0' cellspacing='0' cellpadding='0'>
  <tr>

    <td align='left' valign='top' bgcolor='#FFFFFF' style='background-color:#FFFFFF;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='35' align='left' valign='top'>&nbsp;</td>
    <td align='left' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='center' valign='top' color:#f36b1b;'>
      <div style='color:#245da5; font-family:Times New Roman, Times, serif; font-size:16px;'><h2>Oncefyxd Helpdesk</h2></div>
    </td>
  </tr><br>

  <tr>
<td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;'>
  <div style='color:#3482ad; font-size:12px;'><h3>Hi,<h3></div>  <br>
<b> <h3><b>Name:&nbsp;</b>".$firstname." ".$lastname."</h3> </b>
<div style='color:#3482ad; font-size:12px;'></div>  <br>
</td>
</tr>

<tr>
  <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;'>
  <div style='color:#3482ad; font-size:12px;'></div>  <br>	
<b> <h3><b>Email:&nbsp;</b>".$cc."</h3> </b>
<div style='color:#3482ad; font-size:12px;'></div>  <br>	
</td>
</tr>  

<tr>
<td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;'>
  <div style='color:#3482ad; font-size:12px;'></div>  <br>	
<b> <h3><b>PhoneNumber:&nbsp;</b>".$phoneNumber."</h3> </b>
<div style='color:#3482ad; font-size:12px;'></div>  <br>	
</td>
</tr>

<tr>
<td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;'>
  <div style='color:#3482ad; font-size:12px;'></div>  <br>	
<b> <h3><b>Query:&nbsp;</b>".$query."</h3> </b>
<div style='color:#3482ad; font-size:12px;'></div>  <br>	
</td>
</tr>

<tr>
<td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;'>
  <div style='color:#3482ad; font-size:12px;'></div>  <br>	
<b> <h3><b>Message:&nbsp;</b>".$message."</h3> </b>
<div style='color:#3482ad; font-size:12px;'></div>  <br>	
</td>
</tr>


      <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#f36b1b;'>&nbsp;</td>
    </tr>
  </table></td>
    <td width='35' align='left' valign='top'>&nbsp;</td>
      </tr>
    </table></td></tr>
    <tr>
    <td align='left' valign='top' bgcolor='#3d90bd' style='background-color:#f36b1b;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
    <td width='35'>&nbsp;</td>
    <td width='35'>&nbsp;</td>
      </tr></table></td>
        </tr></table><br><br></td>
      </tr>
      </table>
        </div>
      </body>
      ";
    // function smtpmailer($to, $from, $from_name, $subject, $body) {
             global $error;

             $from = $mail->Username = $fromMailForget;
             $mail->Password = $fromPasswordForget;
             $mail->SetFrom($from, $fromNameForget);
             $mail->Subject = $subjectForget;
     	     $mail->IsHTML(true);
             $mail->Body = $body;
             $mail->addCC($cc);
             $mail->AddAddress($to);
             if(!$mail->Send()) {
                echo $error = 'Mail error: '.$mail->ErrorInfo;
                 echo "false";
                 //echo $to;
             } else {
                 echo $error = 'Message sent to $to';
                 echo "true";
                 //echo $to;
             }
        //}
        
        
?>
