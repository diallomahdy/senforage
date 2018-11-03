<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Wendu PC7
 */
class XMail {
    //put your code here
    
    //*************************** send a mail html message ***********************

    function sendMail2($message, $objet, $destinataire, $expediteur, $from) {
        // $from de type moi@domaine.com
        $headers = "From: \"$expediteur \"<$from>\n";
        $headers .= "Reply-To: $from\n";
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
        if (mail($destinataire, $objet, $message, $headers))
            return true;
        else
            die('error WM10');
    }

    function sendMail($to, $subject, $message, $sender) {
        // $from de type moi@domaine.com
        $headers = "From: \"$from \"\n";
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
        if (mail($to, $subjet, $message, $headers))
            return true;
        else
            die('error WM10');
    }

    //*************************** send a formated html mail message ***********************
    // GitHub PHPMailer https://github.com/Synchro/PHPMailer

    function sendFMail($to, $subject, $msg, $from, $fromPwd, $fromName, $to_img, $reply = NULL) {
        require_once(__DIR__ . '/../lib/PHPMailer/PHPMailerAutoload.php');

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'factor.weendu.com';  			// Specify main and backup SMTP servers
        $mail->Host = 'weendu.com';
        $mail->SMTPAuth = false;                               // Enable SMTP authentication
        $mail->Username = $from;                    // SMTP username
        $mail->Password = $fromPwd;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                    // TCP port to connect to

        $mail->From = $from;
        $mail->FromName = $fromName . ' <' . $from . '>';
        $mail->addAddress($to);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        // Format message
        $formatedMsg = '<div style="max-width:620px; margin:auto; padding:3%; background:#E9E9E9">
                                    <div style="width:93%">
                                            <img src="https://weendu.com/src/images/tbn/weendu.png"/>
                                            <span style="float:right">' . $to_img . '</span>
                                    </div>
                                    <div style="width:93%; margin:3% 0; padding:3%; border:1px solid #D2D2D2; background:white; font-size:14px; line-height:150%">
                                            ' . $msg . '
                                    </div>
                                    <div style="width:93%; color:#999999; font-size:11px">
                                            <p>Ce courrier &eacute;lectronique est destin&eacute; &agrave; <a href="mailto:' . $to . '">' . $to . '</a></p>
                                            <p>Weendu &copy; 2014</p>
                                    </div>
                            </div>';

        $mail->Subject = $subject;
        $mail->Body = $formatedMsg;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } /* else {
          echo 'Message has been sent';
          } */

        //return $mail->send();
    }

    function sendDefaultMail($login, $fname) {
        // Send a welcome mail
        $subject = 'Bienvenue sur Weendu';
        $from = 'noreply@weendu.com';
        $fromPwd = 'wdu@admin';
        $fromName = 'Weendu';
        $name = strtok($fname, " ");
        $to = $login . '@weendu.com';
        $img_src = '/src/images/wdu/profile/2x' . sd720($login) . '.jpg';
        $ROOT_DIR = '/htdocs/weendu/www';
        if (!(file_exists($ROOT_DIR . $img_src)))
            $img_src = '/src/images/tbn/logo_ico.png';
        $to_img = '<img src="https://weendu.com' . $img_src . '" />';
        $msg = '<p><h3>Bienvenue sur Weendu ' . $name . '</h3></p><br/><br/>
                            <p>
                            Votre compte vient d\'être créé. <br/>
                            Vous pouvez désormais rester en contact avec vos proches, discuter et partager avec eux. <br/>
                            Pour les professionels, vous avez aussi accès gratuitement à un ensemble de services vous permettant de développer votre activité plus rapidement et plus efficacement.
                            </p><br/><br/>
                            <p>L\'équipe Weendu</p>';
        sendFMail($to, $subject, utf8_decode($msg), $from, $fromPwd, $fromName, $to_img);
    }
    
}
