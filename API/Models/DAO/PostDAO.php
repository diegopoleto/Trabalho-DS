<?php

	require_once("Models/BD.php");
	require_once("Models/Post.php");
	require_once("Models/DAO/CRUD.php");

	class PostDAO implements CRUD{
		public static function create($Post){
			$sql = "insert into Post (mensagem, emailUsuarioCriador, anonimo, codigoEntidadeMarcada, entidadeCriadora) values ('" . $Post->getMensagem() . "','" . $Post->getEmailUsuarioCriador() ."',";
			if($Post->getIsAnonimo()){
				$sql .= "true,";
			}else{
				$sql .= "false,";
			}
			if(!is_null($Post->getCodigoEntidadeMarcada())){
				$sql .= $Post->getCodigoEntidadeMarcada().",";
			}else{
				$sql .= "null,";
			}
			if(!is_null($Post->getEntidadeCriadora())){
				$sql .= $Post->getEntidadeCriadora(). ");";
			}else{
				$sql .= "null);";
			}
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Post where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function update($Post, $sqlWhere){
			$sql = "update Post set mensagem='". $Post->getMensagem() . "', emailUsuarioCriador='" . $Post->getEmailUsuarioCriador() ."', anonimo=";
			if($Post->getIsAnonimo()){
				$sql .= "true,";
			}else{
				$sql .= "false,";
			}
			if($Post->getCodigoEntidadeMarcada()){
				$sql .= "codigoEntidadeMarcada=" . $Post->getCodigoEntidadeMarcada() . ",";
			}else{
				$sql .= "codigoEntidadeMarcada=null,";
			}
			if($Post->getDtDelecao()){
				$sql .= "dataDelecao='" . $Post->getDtDelecao() . "'";
			}else{
				$sql .= "dataDelecao=null";
			}
			$sql .= " where ". $sqlWhere . ";";
			echo $sql;
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Post where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}

?>
