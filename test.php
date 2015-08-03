<?php
ini_set('display_errors', 1);
require('mysql.php');
//$mysql = new MySQL();

//echo '<pre>';
//print_r($mysql->getProducts());
//echo '</pre>';

//require './email/mail.php';
//$mail = new Mail;
//$mail->setFrom('tdkhanhvu@gmail.com');
//$mail->setHtml('<b>hello</b>');
//$mail->setSender('tdkhanhvu@gmail.com');
//$mail->setText('cool');
//$mail->setTo('ilht1@yahoo.com,tdkhanhvu@gmail.com');
//$mail->username = 'tdkhanhvu@gmail.com';
//$mail->password = 'Knight1990';
//$mail->hostname = 'smtp.gmail.com';
//$mail->setSubject('Wow');
//$mail->port = 587;
//$mail->send();

$homepage = file_get_contents('./email/orderplaced.html');
echo $homepage;
?>
	