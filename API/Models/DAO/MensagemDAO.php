<?php

	require_once("Models/BD.php");
	require_once("Models/Mensagem.php");
	require_once("Models/DAO/CRUD.php");

	class MensagemDAO implements CRUD{
		public static function create($Mensagem){
			$sql = "insert into Mensagem (emailRemetente, emailDestinatario, texto, isAnonima, autor) values ('" . $Mensagem->getEmailRemetente() . "','" . $Mensagem->getEmailDestinatario() . "','" . $Mensagem->getTexto() ."',";
			if($Mensagem->getIsAnonima()){
				$sql .= "true,'";
			}else{
				$sql .= "false,'";
			}
			$sql .= $Mensagem->getAutor() . "');";
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Mensagem where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll();
		}

		public static function update($Mensagem, $sqlWhere){
			$sql = "update Mensagem set emailRemetente='" . $Mensagem->getEmailRemetente() . "', emailDestinatario='" . $Mensagem->getEmailDestinatario() . "', texto='" . $Mensagem->getTexto() . "' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Mensagem where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}

?>