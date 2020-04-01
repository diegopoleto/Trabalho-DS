<?php

	require_once("Models/BD.php");
	require_once("Models/RespostaOficial.php");
	require_once("Models/DAO/CRUD.php");

	class RespostaOficialDAO implements CRUD{
		public static function create($RespostaOficial){
			$sql = "insert into RespostaOficial (codigoEntidade, emailUsuarioCriadorPost, dataCriacaoPost, resposta) values (" . $RespostaOficial->getCodigoEntidade() . ",'" . $RespostaOficial->getEmailUsuarioCriadorPost() . "', '". $RespostaOficial->getDataCriacaoPost() . "', '". $RespostaOficial->getResposta() ."');";
			echo $sql;
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from RespostaOficial where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll();
		}

		public static function update($RespostaOficial, $sqlWhere){
			$sql = "update RespostaOficial set codigoEntidade=" . $RespostaOficial->getCodigoEntidade() . ", emailUsuarioCriadorPost='" . $RespostaOficial->getEmailUsuarioCriadorPost() . "', resposta='" . $RespostaOficial->getResposta() . "' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from RespostaOficial where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}

?>