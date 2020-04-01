<?php
	require "DAO\EntidadeDAO.php";
	require "DAO\CursoDAO.php";
	use Models\Entidade;
	use Models\Curso;

	echo "Criando curso: 4303509, CC<BR>";
	$curso = new Curso("4303509", "Ciência da Computação");
	CursoDAO::create($curso);


	$Entidade = new Entidade("Secretaria Computação", "Campus Anglo", "Um lugar de conversa e cafe", $curso->getCodigoCurso());
	EntidadeDAO::create($Entidade);
	echo "Entidade criada!<br>";
	
	echo "Lendo Entidades:<br>";
	$return = EntidadeDAO::read("codigoCurso=4303509");
	foreach($return as $row){
		echo $row['codigoEntidade'] . "<BR>";
		echo $row['nome'] . "<BR>";
		echo $row['descricao'] . "<BR>";
	}

	$Entidade->setNome("Secretação da Computaria");
	EntidadeDAO::update($Entidade, "codigoCurso=4303509");

	echo "<br>Entidade Atualizada:<br>";
	$return = EntidadeDAO::read("codigoCurso=4303509");
	foreach($return as $row){
		echo $row['codigoEntidade'] . "<BR>";
		echo $row['nome'] . "<BR>";
		echo $row['descricao'] . "<BR>";
	}

	EntidadeDAO::delete("codigoCurso=4303509");
?>