<?php

	require_once("Models/BD.php");
	require_once("Models/Curso.php");
	require_once("Models/DAO/CRUD.php");

	class CursoDAO implements CRUD{
		public static function create($Curso){
			$sql = "insert into Curso (codigoCurso, nome) values ('" . $Curso->getCodigoCurso() . "','" . $Curso->getNome() . "');";
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Curso where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function update($Curso, $sqlWhere){
			$sql = "update Curso set codigoCurso='" . $Curso->getCodigoCurso() . "', nome='" . $Curso->getNome() . "' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Curso where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}

?>
