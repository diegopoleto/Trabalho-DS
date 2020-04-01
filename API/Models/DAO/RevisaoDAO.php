<?php

	require_once("Models/BD.php");
	require_once("Models/Revisao.php");
	require_once("Models/DAO/CRUD.php");

	class RevisaoDAO implements CRUD{
		public static function create($Revisao){
			$sql = "insert into Revisao (emailRemetente, emailDestinatario, isAnonima, emailSolicRevisao, emailRevisor) values ('" . $Revisao->getEmailRemetente() . "','" . $Revisao->getEmailDestinatario() . "','" . $Revisao->getIsAnonima() . "',";
			if(!is_null($Revisao->getEmailSolicRevisao())){
				$sql .= "'".$Revisao->getEmailSolicRevisao()."',";
			}else{
				$sql .= "null,";
			}
			if(!is_null($Revisao->getEmailRevisor())){
				$sql .= "'".$Revisao->getEmailRevisor()."');";
			}else{
				$sql .= "null);";
			}
			return BD::query($sql);
		}

		public static function read($sqlWhere){
			$sql = "select * from Revisao where " . $sqlWhere . ";";
			return BD::query($sql)->fetchAll();
		}

		public static function update($Revisao, $sqlWhere){
			$sql = "update Revisao set emailRemetente='" . $Revisao->getEmailRemetente() . "', emailDestinatario='" . $Revisao->getEmailDestinatario() . "', isAnonima='". $Revisao->getIsAnonima() ."', emailSolicRevisao='". $Revisao->getEmailSolicRevisao() ."', emailRevisor='". $Revisao->getEmailRevisor()."', dataSolicRevisao='". $Revisao->getDataSolicRevisao()."', dataRevisao='". $Revisao->getDataRevisao()."', comentarioRevisao='". $Revisao->getComentarioRevisao()."', gravidadeInfracao='". $Revisao->getGravidadeInfracao()."' where ". $sqlWhere . ";";
			return BD::query($sql);
		}

		public static function delete($sqlWhere){
			$sql = "delete from Revisao where " . $sqlWhere . ";";
			return BD::query($sql);
		}
	}
?>