<?php

	require_once("Models/BD.php");
	require_once("Models/Usuario.php");
	require_once("Models/DAO/CRUD.php");

	class UsuarioDAO implements CRUD{
		public static function create($Usuario){
			$sql = "insert into Usuario (nome, sobrenome, email, senha, dataNascimento, dataCadastro, dataBanimento,
					motivoBanimento, emailAdminBanidor, cpf, siape, matricula, codigoCurso, tipoDeUsuario, isCoordenador) VALUES('".
					$Usuario->getNome() . "','" . $Usuario->getSobrenome() . "','" . $Usuario->getEmail() . "','" . $Usuario->getSenha() . "',";
			if($Usuario->getDtNasc()){
				$sql .= "'" . $Usuario->getDtNasc() . "'";
			}else{
				$sql .= "null";
			}
			$sql .= ",'" . date("Y-m-d H:i:s") . "',";
			$sql .= "null,null,null,";
			if($Usuario->getCpf()){
				$sql .= "'" . $Usuario->getCpf() . "',";
			}else{
				$sql .= "''" . ",";
			}
			if($Usuario->getSiape()){
				$sql .= "'" . $Usuario->getSiape() . "',";
			}else{
				$sql .= "null" . ",";
			}
			if($Usuario->getMatricula()){
				$sql .= "'" . $Usuario->getMatricula() . "',";
			}else{
				$sql .= "null" . ",";
			}
			if($Usuario->getCodigoCurso()){
				$sql .= "'" . $Usuario->getCodigoCurso() . "'";
			}else{
				$sql .= "null";
			}
			$sql .= ",'" . $Usuario->getTpUser() . "',";
			if($Usuario->getIsCoordenador()){
				$sql .= "true)";
			}else{
				$sql .= "false)";
			}
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Usuario where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function update($Usuario, $sqlWhere){
			$sql = "update Usuario set nome='". $Usuario->getNome() ."', sobrenome='" . $Usuario->getSobrenome() . "', email='" . $Usuario->getEmail() . "', senha='" . $Usuario->getSenha() . "'";
			if($Usuario->getDtNasc()){
				$sql .= ", dataNascimento='" . $Usuario->getDtNasc() . "'";
			}
			if($Usuario->getDtBan()){
				$sql .= ", dataBanimento='" . $Usuario->getDtBan() . "'";
			}
			if($Usuario->getMotBan()){
				$sql .= ", motivoBanimento='" . $Usuario->getMotBan() . "'";
			}
			if($Usuario->getEmailAdminBan()){
				$sql .= ", emailAdminBanidor='" . $Usuario->getEmailAdminBan() . "'";
			}
			if($Usuario->getCpf()){
				$sql .= ", cpf='" . $Usuario->getCpf() . "'";
			}
			if($Usuario->getSiape()){
				$sql .= ", siape='" . $Usuario->getSiape() . "'";
			}
			if($Usuario->getMatricula()){
				$sql .= ", matricula='" . $Usuario->getMatricula() . "'";
			}
			if($Usuario->getCodigoCurso()){
				$sql .= ", codigoCurso='" . $Usuario->getCodigoCurso() . "'";
			}
			$sql .= ", tipoDeUsuario='" . $Usuario->getTpUser() . "'";
			if($Usuario->getIsCoordenador()){
				$sql .= ", isCoordenador=true";
			}else{
				$sql .= ", isCoordenador=false";
			}
			$sql .= " where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Usuario where " . $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function updateToken($token,$dataExpiracao, $sqlWhere){
			$sql = "update Usuario set token='". $token . "', dataExpiracaoToken ='". $dataExpiracao ."' where " . $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function updatePassword($email, $senha){
			$sql = "update Usuario set senha='".$senha."' where email='".$email."';";
			return BD::query($sql);
		}
	}

?>
