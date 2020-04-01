<?php

	require_once("Models/BD.php");
	require_once("Models/RecoveryPassword.php");
	require_once("Models/DAO/CRUD.php");

	class RecoveryPasswordDAO implements CRUD{
		public static function create($RecoveryPassword){
			$sql = "insert into RecoveryPassword (token, email) values ('" . $RecoveryPassword->getToken() . "','" . $RecoveryPassword->getEmail() . "');";
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from RecoveryPassword where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll();
		}

		public static function update($RecoveryPassword, $sqlWhere){
			$sql = "update RecoveryPassword set token='" . $RecoveryPassword->getToken() . "', email='" . $RecoveryPassword->getEmail() . "' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from RecoveryPassword where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}
?>