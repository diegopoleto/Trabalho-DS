<?php
	use Models\RecoveryPassword;
	require_once "Models/DAO/RecoveryPasswordDAO.php";
	require_once "Tools/Mail/EmailSender.php";

	class RecoveryPasswordController{

		public static function createNewRequest($email, $nome){
			$token = hash('sha256', 'back'.$email.'end'.date("Y/m/d H:i:s"));
			$request = new RecoveryPassword($email, $token);
			if(RecoveryPasswordDAO::create($request)){
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url = str_replace("ask/", "reset/", $url);
				$corpo = "Para resetar sua senha acesse:\n". $url . $token;
				EmailSender::sendMail($nome, $email, "Recuperação de Senha - Portal Computação", $corpo);
				return true;
			}else{
				return false;
			}

		}

		public static function existTokenToThisUser($email, $nome){
			$recovery = RecoveryPasswordDAO::read("email='".$email."'");	    		
			if($recovery != []){
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url = str_replace("ask/", "reset/", $url);
				$corpo = "Para resetar sua senha acesse:\n". $url . $recovery[0]['token'];
				EmailSender::sendMail($nome, $email, "Recuperação de Senha - Portal Computação", $corpo);
				return true;
			}else{
				return false;
			}
		}

		public static function getEmailByToken($token){
			$recovery = RecoveryPasswordDAO::read("token='".$token."'");	    		
			if($recovery != []){
				return $recovery[0]['email'];
			}
			return "";
		}

		public static function deleteRequest($token){
			RecoveryPasswordDAO::delete("token='".$token."'");
		}

		public static function expiredToken(){

		}

	}

?>