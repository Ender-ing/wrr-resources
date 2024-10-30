<?php

session_start();

require 'VARS/ENV.email.secret.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; // Add this if you want detailed error messages

require 'libraries/PHPMailer/src/Exception.php';
require 'libraries/PHPMailer/src/PHPMailer.php';
require 'libraries/PHPMailer/src/SMTP.php';

// Send SYSTEM mail to an email address
// $to_address            - <string> (email address)
// $to_name               - <string> (name of the addressed)
// $subject               - <string> (email subject)
// $HTMLBody              - <string> (email content - in HTML)
function __SYSTEM_send_mail__($to_address, $to_name, $subject, $HTMLBody = ""){

    global $__SYSTEM_MAIL__;
    global $__SMTP_SYSTEM_SERVER__, $__SMTP_SYSTEM_APP_PASSWORD__, $__SMTP_SYSTEM_ADDRESS__, $__SMTP_SYSTEM_NAME__;

    global $__SMTP_HTML_START__, $__SMTP_HTML_END__;

    try {
        $__SYSTEM_MAIL__ = new PHPMailer(true); // true enables exceptions

        $__SYSTEM_MAIL__->isSMTP();
        $__SYSTEM_MAIL__->Host       = $__SMTP_SYSTEM_SERVER__;
        $__SYSTEM_MAIL__->SMTPAuth   = true;
        $__SYSTEM_MAIL__->Username   = $__SMTP_SYSTEM_ADDRESS__; // ONLY USE THE "SYSTEM" USER TO SEND AUTOMATED MESSAGES!
        $__SYSTEM_MAIL__->Password   = $__SMTP_SYSTEM_APP_PASSWORD__; // Use an App Password (See below)
        $__SYSTEM_MAIL__->SMTPSecure = 'tls'; // or 'ssl'
        $__SYSTEM_MAIL__->Port       = 587; // or 465
    
        // Account
        $__SYSTEM_MAIL__->setFrom($__SMTP_SYSTEM_ADDRESS__, $__SMTP_SYSTEM_NAME__);
        $__SYSTEM_MAIL__->addReplyTo($__SMTP_SYSTEM_ADDRESS__, $__SMTP_SYSTEM_NAME__);
        // ^ NEED TO FIX THE "DO-NOT-REPLY@" ADDRESS NOT BEING USED!

        //Recipients
        $__SYSTEM_MAIL__->addAddress($to_address, $to_name);
    
        // Content
        $__SYSTEM_MAIL__->isHTML(true);
        $__SYSTEM_MAIL__->Subject = $subject;
        $__SYSTEM_MAIL__->Body = $__SMTP_HTML_START__.$HTMLBody.$__SMTP_HTML_END__;
        // Make a SolidJS library made just for generating plain HTML content usable within emails
        // Note: also generate a plain text version of emails!

        // Add headers
        $__SYSTEM_MAIL__->addCustomHeader('Language', 'en'); // Email language (support English, Hebrew, and Arabic!)
        $__SYSTEM_MAIL__->addCustomHeader('MT-Priority', '1'); // Set this email as urgent (only urgent emails will be delivered!)
        $__SYSTEM_MAIL__->addCustomHeader('Organization', 'Ender (ender.ing)');
        $__SYSTEM_MAIL__->addCustomHeader('X-Ender-Mail-Client', '0'); // Always include this header to indicate the version of the web client
        $__SYSTEM_MAIL__->addCustomHeader('X-Ender-Mail-Signature', '0'); // Use this header to show trusted services as verified in the mail client! (only allow signature of certificates signed by Ender CA)
        $__SYSTEM_MAIL__->addCustomHeader('X-Ender-Mail-Anti-Abuse', 'Please contact us at abuse@ender.ing if you suspect ongoing suspicious activity!'); // Use this header to track ALL mail sent from the web mail client
        $__SYSTEM_MAIL__->addCustomHeader('X-Ender-Mail-Anti-Abuse', '0'); // Use this header to track ALL mail sent from the web mail client
    
        $__SYSTEM_MAIL__->send();

        $__SYSTEM_MAIL__ = null;
        return true;
    } catch (Exception $e) {
        echo $__SYSTEM_MAIL__->ErrorInfo;

        $__SYSTEM_MAIL__ = null;
        return false;
    }
}


// Limit emails!
if (!isset($_SESSION['LAST_SENT'])) {
    $_SESSION['LAST_SENT'] = 0; // Initialize if not set
}
if (isset($_POST['user_input']) && isset($_SESSION['LAST_SENT'])) {
    $delta = (time() - (Int)($_SESSION['LAST_SENT']));
    $limit = 3*60; // 3 minutes per email sent!
    if($delta >= $limit){
        $success = __SYSTEM_send_mail__($_POST['user_input'], "You! (an Ender.ing subscriber)", "Hello!",
        '<p class="title">Hello there!!</p><p class="text">We are <b>only</b> checking our new mailing system! No need to panick :)</p>');
        if($success){
            $_SESSION['LAST_SENT'] = time();
            echo "Message sent!";
        }else{
            echo "Could NOT send message!";
        }
    }
    $delta = (time() - (Int)($_SESSION['LAST_SENT']));
    $t = (($limit - $delta)/(60));
    $m = floor($t);
    $s = floor(($t - $m)*60);
    echo "</br>(Cannot send any messages for the next <b>$m minutes, $s seconds!</b>!)";
} else {
    echo "No input received!";
}

?>