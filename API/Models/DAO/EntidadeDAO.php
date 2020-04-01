<?php

	require_once("Models/BD.php");
	require_once("Models/Entidade.php");
	require_once("Models/DAO/CRUD.php");

	class EntidadeDAO implements CRUD{
		public static function create($Entidade){
			$sql = "insert into Entidade (nome, descricao, endereco, codigoCurso) values ('" . $Entidade->getNome() . "','" . $Entidade->getDescricao() ."','". $Entidade->getEndereco() . "'," . $Entidade->getCodigoCurso().");";
			echo $sql;
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Entidade where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function update($Entidade, $sqlWhere){
			$sql = "update Entidade set nome='" . $Entidade->getNome() . "', descricao='" . $Entidade->getDescricao() . "', endereco='" . $Entidade->getEndereco() . "', codigoCurso=". $Entidade->getCodigoCurso();
			$sql .= " where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Entidade where " . $sqlWhere . ";";
			echo $sql;
			
			return BD::query($sql);
		}
	}


?>
