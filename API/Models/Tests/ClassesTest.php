<?php

	require "Usuario.php";
	require "Entidade.php";
	require "UsuarioEntidade.php";
	require "Post.php";
	require "Conversa.php";
	require "Curso.php";
	use Models\Usuario;
	use Models\Entidade;
	use Models\UsuarioEntidade;
	use Models\Post;
	use Models\RespostaOficial;
	use Models\Conversa;
	use Models\Mensagem;
	use Models\Revisao;
	use Models\Curso;
	
	$aluno = new Usuario("Matheus", "Garcia", "mgfagundes@inf.ufpel.edu.br", "mgf", "Aluno", "12101868");
	$professor = new Usuario("Lisane", "Brisolara", "lisane@inf.ufpel.edu.br", "S2Paulo", "Professor", "364987145");
	$coordenador = new Usuario("Paulo", "Ferreira", "paulo@inf.ufpel.edu.br", "S2Lisane", "Coordenador", "896415726");
	$funcionario = new Usuario("Claudioney", "Silva", "claudinho@bol.com.br", "v1d4l0k4", "Funcionario", "1259764835");
	$admin = new Usuario("DEUS", "PAI", "deus@pai.com", "jesusMeuFilhao", "Admin", "99999999999");
	var_dump($aluno);
	echo "<BR><BR>";
	var_dump($professor);
	echo "<BR><BR>";
	var_dump($coordenador);
	echo "<BR><BR>";
	var_dump($funcionario);
	echo "<BR><BR>";
	var_dump($admin);
	echo "<BR><BR><BR><BR>";

	$biblioteca = new Entidade("Biblioteca", "Campus Anglo", "Um lugar onde tem varios livros para ler");
	$secretaria = new Entidade("Secretaria Computação", "Campus Anglo", "Um lugar de conversa e cafe", "33589");
	$dablaisep = new Entidade("Diretório Academico Blaise Pascal", "Campus Anglo", "Sem mais informacoes", "33589");
	var_dump($biblioteca);
	echo "<BR><BR>";
	var_dump($secretaria);
	echo "<BR><BR>";
	var_dump($dablaisep);
	echo "<BR><BR><BR><BR>";

	$biblioteca->setCodigoEntidade(1);
	$funcionarioBiblioteca = new UsuarioEntidade($biblioteca->getCodigoEntidade(), $funcionario->getEmail(), date("Y-m-d H:i:s"));
	var_dump($funcionarioBiblioteca);
	echo "<BR><BR><BR><BR>";

	$post = new Post(date("Y-m-d H:i:s"), "Achei um pendrive escrito gremio", $aluno->getEmail());
	var_dump($post);
	echo "<BR><BR><BR><BR>";

	$respostaOficial = new RespostaOficial($biblioteca->getCodigoEntidade(), $post->getDataCriacao(), $post->getEmailUsuarioCriador(), "Obrigado Matheus! O pendrive ja foi entregado para o dono!!", date("Y-m-d H:i:s"));
	$post->setRespostaOficial($respostaOficial);
	echo "Post com RESPOSTA OFICIAL:<br>";
	var_dump($post);
	echo "<BR><BR><BR><BR>";
	

	$conversa = new Conversa($aluno->getEmail(), $professor->getEmail());
	$conversa->setCodConversa(1);
	$mensagem = new Mensagem(date("Y-m-d H:i:s"), "Olá professora, nós merecemos 10 neste trabalho!", $conversa->getEmailRem(), $conversa->getEmailDest(), $conversa->getCodConversa());
	$conversa->setMensagens($mensagem);
	$mensagem2 = new Mensagem(date("Y-m-d H:i:s"), "??????", $conversa->getEmailRem(), $conversa->getEmailDest(), $conversa->getCodConversa());
	$conversa->setMensagens($mensagem2);
	var_dump($conversa);
	echo "<BR><BR><BR><BR>";

	$arrayMensagens = $conversa->getMensagens();
	echo "Vai exibir a segunda mensagem do array:<BR>";
	var_dump($arrayMensagens[1]);
	echo "<BR><BR><BR><BR>";

	$revisao = new Revisao($conversa->getCodConversa(), $conversa->getEmailDest(), date("Y-m-d H:i:s"));
	var_dump($revisao);
	echo "<BR><BR><BR><BR>";

	$curso = new Curso("33589", "Ciência da Computação");
	var_dump($curso);
	echo "<BR><BR><BR><BR>";
?>