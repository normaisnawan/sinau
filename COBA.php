<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
require 'assets/vendor/PHPMailer/PHPMailerAutoload.php';
require 'assets/vendor/PHPMailer/class.phpmailer.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;
      //Tell PHPMailer to use SMTP
      $mail->isSMTP();
      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      $mail->SMTPDebug = 2;
      //Ask for HTML-friendly debug output
      $mail->Debugoutput = 'html';
      //Set the hostname of the mail server
      //$mail->Host = 'smtp.gmail.com';
      // use
      $mail->Host = 'tls://smtp.gmail.com:587';
      $mail->SMTPAuth = true;
      //Username to use for SMTP authentication - use full email address for gmail
      $mail->Username = "elearning.phapros@gmail.com";
      //Password to use for SMTP authentication
      $mail->Password = "Phapros Ceria";
      //Set who the message is to be sent from
      $mail->setFrom('elearning.phapros@gmail.com', 'Admin E-PED');
      //Set an alternative reply-to address
      $mail->addReplyTo('elearning.phapros@gmail.com', 'Admin E-PED');
      //Set who the message is to be sent to
      $mail->addAddress('feriagusetiawan@yahoo.co.uk', 'Feri Agusetiawan');
      //Set the subject line
      $mail->Subject = 'PHPMailer GMail SMTP test';
      //Read an HTML message body from an external file, convert referenced images to embedded,
      //convert HTML into a basic plain-text alternative body
      $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      //Attach an image file
      //send the message, check for errors
      if (!$mail->send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
          echo "Message sent!";
      }