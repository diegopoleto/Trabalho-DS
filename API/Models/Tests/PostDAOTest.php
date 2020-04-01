<?php

	require_once "DAO\EntidadeDAO.php";
	require_once "DAO\PostDAO.php";
	require_once "DAO\CursoDAO.php";
	require_once "BD.php";
	use Models\Entidade;
	use Models\Post;
	use Models\Curso;


	$curso = new Curso("4303509", "Ciência da Computação");
	CursoDAO::create($curso);

	$Entidade = new Entidade("Secretaria Computação", "Campus Anglo", "Um lugar de conversa e cafe", $curso->getCodigoCurso());
	EntidadeDAO::create($Entidade);

	$post = new Post(date("Y-m-d H:i:s"), "Achei um pendrive escrito pilla", "tzin.gf@hotmail.com");
	PostDAO::create($post);

?>