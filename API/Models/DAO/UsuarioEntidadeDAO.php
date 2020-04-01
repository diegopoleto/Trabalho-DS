<?php

	require_once("Models/BD.php");
	require_once("Models/UsuarioEntidade.php");
	require_once("Models/DAO/CRUD.php");

	class UsuarioEntidadeDAO implements CRUD{
		public static function create($UsuarioEntidade){
			$sql = "insert into UsuarioEntidade (codigoEntidade, emailResponsavel) values (" . $UsuarioEntidade->getCodigoEntidade() . ",'" .$UsuarioEntidade->getEmailResponsavel(). "')";
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from UsuarioEntidade where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll();
		}

		public static function update($UsuarioEntidade, $sqlWhere){
			$sql = "update UsuarioEntidade set codigoEntidade=" . $UsuarioEntidade->getCodigoEntidade() . ", emailResponsavel='" .$UsuarioEntidade->getEmailResponsavel(). "', dataPosse= '".$UsuarioEntidade->getDataPosse(). "' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from UsuarioEntidade where " . $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function retire($sqlWhere){
			$sql = "update usuarioentidade set dataSaida=CURRENT_TIMESTAMP where ".$sqlWhere.";";
			return BD::query($sql);
		}
	}

?>
