<?php

	require_once("Models/BD.php");
	require_once("Models/Conversa.php");
	require_once("Models/DAO/CRUD.php");

	class ConversaDAO implements CRUD{
		public static function create($Conversa){
			$sql = "insert into Conversa (emailRemetente, emailDestinatario, isAnonima) values ('" . $Conversa->getEmailRem() . "','" . $Conversa->getEmailDest() . "',";
			if($Conversa->getAnonima()){
				$sql .= "1);";
			}else{
				$sql .= "0);";
			}
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Conversa where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function update($Conversa, $sqlWhere){
			$sql = "update Conversa set emailRemetente='" . $Conversa->getEmailRem() . "', emailDestinatario='" . $Conversa->getEmailDest() . "', ";
			if($Conversa->getAnonima()){
				$sql .= "isAnonima=true";
			}else{
				$sql .= "isAnonima=false";
			}
			" where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Conversa where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}

?>
