<?php
	use Models\Entidade;
	require_once "Models/DAO/EntidadeDAO.php";
	require_once "AuthenticationController.php";

	class EntidadeController{
		public function listAll($request, $response, $args){
			if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
				$email = $request->getHeaderLine('userId');
				$token = $request->getHeaderLine('tokenPortal');
				$auth = AuthenticationController::validateToken($token, $email);
    			if($auth['logado']){
					$dadosRetorno['entidades'] = EntidadeDAO::read("TRUE");
					$dadosRetorno['tokenPortal'] = $request->getHeaderLine('tokenPortal');
					$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	        		return $response->getBody()->write($body);
				}
			}else{
				$dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
			}
			$dadosRetorno['tokenPortal'] = [];
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	        return $response->getBody()->write($body);
		}

		public function createEntidade($request, $response, $args){
			$data = $request->getParsedBody();
	        $data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);
	        $data['endereco'] = filter_var($data['endereco'], FILTER_SANITIZE_STRING);
	        $data['codigoCurso'] = filter_var($data['codigoCurso'], FILTER_SANITIZE_STRING);
	        if($data['codigoCurso'] == ""){
	            $data['codigoCurso'] = "NULL";
	        }
	        $data['descricao'] = filter_var($data['descricao'], FILTER_SANITIZE_STRING);	        
	        $entidade = new Entidade($data['nome'], $data['endereco'], $data['descricao'], $data['codigoCurso']);
	        if(EntidadeDAO::create($entidade)){
	        	$dadosRetorno['criado'] = true;
	        }else{
	        	$dadosRetorno['criado'] = false;
	        	$dadosRetorno['erro'] = "Erro para criar entidade";
	        }
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
		}
		
		public function updateEntidade($request, $response, $args){
			$codigoEntidade = $args['codigoEntidade'];
	        $data = $request->getParsedBody();
	        $data['endereco'] = filter_var($data['endereco'], FILTER_SANITIZE_STRING);
	        $data['descricao'] = filter_var($data['descricao'], FILTER_SANITIZE_STRING);
	        $data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);
	        $data['codigoCurso'] = filter_var($data['codigoCurso'], FILTER_SANITIZE_STRING);
	        $entidade = new Entidade($data['nome'], $data['endereco'], $data['descricao'], $data['codigoCurso']);
	        if(EntidadeDAO::update($entidade, "codigoEntidade='" . $codigoEntidade . "'")){
	        	$dadosRetorno['atualizado'] = true;
	        }else{
	        	$dadosRetorno['atualizado'] = false;
	        	$dadosRetorno['erro'] = "Erro para atualizar informações da entidade";
	        }
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
		}
		public function deleteEntidade($request, $response, $args){
			$codigoEntidade = $args['codigoEntidade'];
	        if(EntidadeDAO::delete("codigoEntidade='" . $codigoEntidade . "'")){
	        	$dadosRetorno['deletado'] = true;
	        }else{
	        	$dadosRetorno['deletado'] = false;
	        	$dadosRetorno['erro'] = "Erro para atualizar informações da entidade";
	        }
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
		}

	}

?>