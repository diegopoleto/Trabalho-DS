<?php
	require "DAO\CursoDAO.php";

	use Models\Curso;

	echo "Criando curso: 4303509, CC<BR>";
	$curso = new Curso("4303509", "Ciência da Computação");
	CursoDAO::create($curso);
	
	echo "Lendo cursos:<br>";
	$return = CursoDAO::read("codigoCurso='4303509'");
	foreach($return as $row){
		echo $row['codigoCurso'] . "<BR>";
		echo $row['nome'] . "<BR>";
	}
	
	echo "Alterando nome do curso para: Agronomia<br>";
	$curso->setNome("Agronomia");
	CursoDAO::update($curso, "codigoCurso='4303509'");

	$return = CursoDAO::read("codigoCurso='4303509'");
	foreach($return as $row){
		echo $row['codigoCurso'] . "<BR>";
		echo $row['nome'] . "<BR>";
	}
	
	echo "Apagando curso com codigoCurso=4303509<br>";
	CursoDAO::delete("codigoCurso='4303509'");
?>