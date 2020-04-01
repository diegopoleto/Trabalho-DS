<?php
	use Models\Curso;
	require_once "Models/DAO/CursoDAO.php";

	class CursoController{
		public function listAll($request, $response, $args){
			$return = CursoDAO::read("TRUE");
        	$body = json_encode($return, JSON_UNESCAPED_UNICODE);
        	$response->getBody()->write($body);
        	return $response;
		}

		public function createCurso($request, $response, $args){
			$data = $request->getParsedBody();
        	$data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);
        	$data['codigoCurso'] = filter_var($data['codigoCurso'], FILTER_SANITIZE_STRING);
        	$curso = new Curso($data['codigoCurso'], $data['nome']);
        	if(CursoDAO::create($curso)){
        		$dadosRetorno['criado'] = true;
        	}else{
        		$dadosRetorno['criado'] = false;
        		$dadosRetorno['erro'] = "Erro para criar curso";
        	}
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body); 
		}

		public function updateCurso($request, $response, $args){
			$codigoCurso = $args['codigoCurso'];

	        $data = $request->getParsedBody();
	        $data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);

	        $curso = new Curso("4303509", "Ciência da Computação");

	        $curso = new Curso($codigoCurso, $data['nome']);
	        if(CursoDAO::update($curso, "codigoCurso='" . $codigoCurso . "'")){
        		$dadosRetorno['atualizado'] = true;
        	}else{
        		$dadosRetorno['atualizado'] = false;
        		$dadosRetorno['erro'] = "Erro para atualizar informações do curso";
        	}
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body); 
		}

		public function deleteCurso($request, $response, $args){
			$codigoCurso = $args['codigoCurso'];
	        if(CursoDAO::delete("codigoCurso='" . $codigoCurso . "'")){
        		$dadosRetorno['deletado'] = true;
        	}else{
        		$dadosRetorno['deletado'] = false;
        		$dadosRetorno['erro'] = "Erro para deletar este curso";
        	}
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body); 
		}
		
	}

?>