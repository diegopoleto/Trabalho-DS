<?php

	require_once('mailer.php');

	class EmailSender{
		public static function sendMail($destNome, $destMail, $assunto, $mensagem){
            if (empty($destNome) OR empty($destMail) OR empty($assunto) OR empty($mensagem) OR !filter_var($destMail, FILTER_VALIDATE_EMAIL)) {
                // Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "<script>console.log('Opa, os dados foram preenchidos de forma incorreta, tente modificá-los ou mande um email para portalcomp.ufpel@gmail.com');</script>";
                exit;
            }

            $corpo = "Olá ".$destNome.",\n\n".$mensagem;

            if (smtpmailer($destMail, $assunto, $corpo)) {
                http_response_code(200);
                echo "<script>console.log('Mensagem enviada :-)');</script>";
            }
            else{
                http_response_code(500);
                echo "<script>console.log('Opa, ocorreu algum problema no servidor, por favor entre em contato pelo email: portalcomp.ufpel@gmail.com');</script>";
            }
    	}

        public static function registerMessage(){
            $message = "";
            return $message;
        }

        public static function notificationMessage(){
            $message = "";
            return $message;
        }
    }
?>