<?php
	use Models\Post;
	use Models\Entidade;
    use Models\UsuarioEntidade;
    use Models\RespostaOficial;
    require_once "Models/DAO/EntidadeDAO.php";
    require_once "Models/DAO/UsuarioEntidadeDAO.php";
	require_once "Models/DAO/PostDAO.php";
	require_once "Models/DAO/RespostaOficialDAO.php";
	require_once "AuthenticationController.php";

	class PostController{

		public function listAll($request, $response, $args){
			if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
				$email = $request->getHeaderLine('userId');
				$token = $request->getHeaderLine('tokenPortal');
				$auth = AuthenticationController::validateToken($token, $email);
				if($auth['logado']){
					$dadosRetorno['posts'] = PostDAO::read("TRUE order by dataCriacao desc");
					$dadosRetorno['tokenPortal'] = $token;
					$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	        		return $response->getBody()->write($body);
	        	}
	        }else{
	        	$dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
	        }
	        $dadosRetorno['tokenPortal'] = [];
	        $body = json_encode($return, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
		}

		public function createPost($request, $response, $args){
			if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
				$email = $request->getHeaderLine('userId');
				$token = $request->getHeaderLine('tokenPortal');
				$auth = AuthenticationController::validateToken($token, $email);
				if($auth['logado']){
					$data = $request->getParsedBody();
			        $data['mensagem'] = filter_var($data['mensagem'], FILTER_SANITIZE_STRING);
			        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_STRING);
			        if($data['anonimo'] === "Sim" || $data['anonimo'] === true || $data['anonimo'] === "true"){
			            $data['anonimo'] = true;
			        }
			        else{
			            $data['anonimo'] = false;
			        }
			        $post = new Post($data['mensagem'], $data['email'], $data['anonimo']);
			        if(isset($data['codigoEntidadeMarcada'])){
						$post->setCodigoEntidadeMarcada(filter_var($data['codigoEntidadeMarcada'], FILTER_SANITIZE_STRING));
			        }
			        if(isset($data['entidadeCriadora'])){
						$post->setEntidadeCriadora(filter_var($data['entidadeCriadora'], FILTER_SANITIZE_STRING));
			        }
			        if(PostDAO::create($post)){
			        	$dadosRetorno['criado'] = true;
			        	$dadosRetorno['tokenPortal'] = $token;
			        	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
				        $response->getBody()->write($body);
				        return $response;
			        }else{
			        	$dadosRetorno['criado'] = false;
			        	$dadosRetorno['erro'] = "Erro para criar post";
			        }
	        	}
	        }else{
	        	$dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
	        }
	        $dadosRetorno['tokenPortal'] = [];
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
		}
		
		public function updatePost($request, $response, $args){
			$codigoPost = explode(";", $args['codigoPost']);
	        $dataCriacao = $codigoPost[0];
	        $emailUsuarioCriador = str_replace("|", ".", $codigoPost[1]);

	        $data = $request->getParsedBody();
	        $data['mensagem'] = filter_var($data['mensagem'], FILTER_SANITIZE_STRING);
	        $data['isAnonimo'] = filter_var($data['isAnonimo'], FILTER_SANITIZE_STRING);
	        $data['dataDelecao'] = filter_var($data['dataDelecao'], FILTER_SANITIZE_STRING);
	        $data['codigoEntidadeMarcada'] = filter_var($data['codigoEntidadeMarcada'], FILTER_SANITIZE_STRING);

	        $post = new Post($data['mensagem'], $emailUsuarioCriador, $data['isAnonimo']);
	        $post->setDtDelecao($data['dataDelecao']);
	        $post->setCodigoEntidadeMarcada($data['codigoEntidadeMarcada']);

	        $result = PostDAO::update($post, "dataCriacao='" . $dataCriacao . "' && emailUsuarioCriador='" . $emailUsuarioCriador . "'");
	        $response->getBody()->write(var_dump($result));	
		}
		public function deletePost($request, $response, $args){
			$codigoPost = explode(";", $args['codigoPost']);
	        $emailUsuarioCriador = str_replace("|", ".", $codigoPost[1]);

	        $data = $request->getParsedBody();
	        $data['mensagem'] = filter_var($data['mensagem'], FILTER_SANITIZE_STRING);
	        $data['isAnonimo'] = filter_var($data['isAnonimo'], FILTER_SANITIZE_STRING);
	        $data['dataDelecao'] = filter_var($data['dataDelecao'], FILTER_SANITIZE_STRING);
	        $data['codigoEntidadeMarcada'] = filter_var($data['codigoEntidadeMarcada'], FILTER_SANITIZE_STRING);

	        $post = new Post($data['mensagem'], $emailUsuarioCriador, $data['isAnonimo']);
	        $now = new DateTime();
	        $post->setDtDelecao(date('Y-m-d h:i:s', time()));
	        echo $post->getDtDelecao();
	        $post->setCodigoEntidadeMarcada($data['codigoEntidadeMarcada']);

	        $result = PostDAO::update($post, "dataCriacao='" . $dataCriacao . "' && emailUsuarioCriador='" . $emailUsuarioCriador . "'");
	        $response->getBody()->write(var_dump($result));
		}

		public function createPostAsEntity($request, $response, $args){
			$data['usuarioID'] = $args['usuarioID'];
			if(!(is_null($data['usuarioID']) || trim($data['usuarioID']) === '')){	
				$data['entidade'] = $args['entidade'];		
				if(!(is_null($data['entidade']) || trim($data['entidade']) === '')){	
					$usuario = UsuarioEntidadeDAO::read("emailResponsavel='".$data['usuarioID']."'");
					if($usuario != []){
						$entidade = EntidadeDAO::read("codigoEntidade='".$usuario[0]['codigoEntidade']."'");
						$mensagem = $request->getParsedBody();						
						$post = new Post($mensagem['mensagem'], $usuario[0]['emailResponsavel'], false);
				        $post->setEntidadeCriadora($usuario[0]['codigoEntidade']);				        
				        $result = PostDAO::create($post);				        
				        return $response->getBody()->write(var_dump($result));
					}
					else{
						$dadosRetorno['logado'] = false;
					}
				}
				else{
					$dadosRetorno['logado'] = false;
				}
			}
			else{
				$dadosRetorno['logado'] = false;
	            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	            $response->getBody()->write(var_dump($body));
			}			
		}

		public function createResponseToPost($request, $response, $args){
			if(!(is_null($args['post']) || trim($args['post']) === '')){
				$data = explode(";", $args['post']);
				$email = $data[0];
				$dataCriacao = $data[1];
				$lista = PostDAO::read("emailUsuarioCriador='".$email."' and dataCriacao='".$dataCriacao."'");
				if($lista != []){
					if(!isset($lista[0]['codigoEntidadeMarcada'])){
						$dadosRetorno['erro'] = "Este post não possui uma entidade marcada";
					}else{
						$body = $request->getParsedBody();
						$usuarioEntidade = UsuarioEntidadeDAO::read("emailResponsavel='".$body['email']."' and codigoEntidade=".$lista[0]['codigoEntidadeMarcada']." and dataSaida is NULL");
						if($usuarioEntidade != []){
							$resposta = new RespostaOficial($lista[0]['codigoEntidadeMarcada'], $lista[0]['dataCriacao'], $email, $body['mensagem']);
							if(RespostaOficialDAO::create($resposta)){
								$dadosRetorno['criado'] = true;
								$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
								return $response->getBody()->write($body);
							}else{
								$dadosRetorno['erro'] = "Erro para criar resposta";
							}
						}else{
							$dadosRetorno['erro'] = "Este usuario não é responsável pela entidade marcada neste post";
						}
					}
				}else{
					$dadosRetorno['erro'] = "Não foi possível encontrar este post";
				}
			}else{
				$dadosRetorno['erro'] = "Post inválido";
			}
			$dadosRetorno['criado'] = false;
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);
		}
	}

?>