<?php

	require_once "DAO\UsuarioDAO.php";
	use Models\Usuario;
	
	$aluno = new Usuario("Matheus", "Garcia", "mgfagundes@inf.ufpel.edu.br", "mgf", "Aluno", "12101868");
	$professor = new Usuario("Lisane", "Brisolara", "lisane@inf.ufpel.edu.br", "S2Paulo", "Professor", "364987145");
	$coordenador = new Usuario("Paulo", "Ferreira", "paulo@inf.ufpel.edu.br", "S2Lisane", "Coordenador", "896415726");
	$funcionario = new Usuario("Claudioney", "Silva", "claudinho@bol.com.br", "v1d4l0k4", "Funcionario", "1259764835");
	$admin = new Usuario("DEUS", "PAI", "deus@pai.com", "jesusMeuFilhao", "Admin", "99999999999");
	$aluno->setCodigoCurso("4303509");
	$professor->setCodigoCurso("4303509");
	$coordenador->setCodigoCurso("4303509");
	$funcionario->setCodigoCurso("4303509");
	$admin->setCodigoCurso("4303509");
	UsuarioDAO::create($aluno);
	UsuarioDAO::create($professor);
	UsuarioDAO::create($coordenador);
	UsuarioDAO::create($funcionario);
	UsuarioDAO::create($admin);
	$aluno->setNome("Math");
	UsuarioDAO::update($aluno, "nome='Matheus'");
	UsuarioDAO::delete("nome='DEUS'");
?>
