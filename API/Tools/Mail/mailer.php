<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require_once('PHPMailer.php');
    require_once('Exception.php');
    require_once('SMTP.php');

    function cleanString($string){
        $string = strip_tags(trim($string));
        $string = str_replace(array("\r","\n"),array(" "," "), $string);
        return $string;
    }

    function smtpmailer($para, $assunto, $corpo) {
        $mail = new PHPMailer();
        $mail->IsSMTP();		// Ativar SMTP
        $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
        $mail->SMTPAuth = true;		// Autenticação ativada
        $mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
        $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
        $mail->Port = 465;  		// A porta 587 deverá estar aberta em seu servidor
        $mail->Username = "portalcomp.ufpel@gmail.com";
        $mail->Password = "portalcomp7p.grupo6";
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom("portalcomp.ufpel@gmail.com", "Portal Computação");
        $mail->Subject = $assunto;
        $mail->Body = $corpo;
        $mail->AddAddress($para);
        if(!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

?>
