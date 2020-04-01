<?php

	use Models\UsuarioEntidade;
	require_once('Models/DAO/UsuarioEntidadeDAO.php');
	require_once('Models/DAO/EntidadeDAO.php');
	require_once('Models/DAO/UsuarioDAO.php');

	class UsuarioEntidadeController{
		public function listAll($request, $response, $args){
			$return = UsuarioEntidadeDAO::read("TRUE");
	        $body = json_encode($return, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
		}

		public function createNewResponsible($request, $response, $args){
			$data = $request->getParsedBody();
			if(isset($data['email']) && isset($data['codigoEntidade'])){
				$usuario = UsuarioDAO::read("email='".$data['email']."'");
				if($usuario != []){
					$entidade = EntidadeDAO::read("codigoEntidade=".$data['codigoEntidade']);
					if($entidade != []){
						$usuarioEntidade = new UsuarioEntidade($data['codigoEntidade'], $data['email']);
						if(UsuarioEntidadeDAO::create($usuarioEntidade)){
							$dadosRetorno['criado'] = true;
							$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
							return $response->getBody()->write($body);
						}else{
							$dadosRetorno['erro'] = "Erro para criar responsavel por entidade";
						}
					}else{
						$dadosRetorno['erro'] = "Não foi encontrada Entidade com o código informado";
					}
				}else{
					$dadosRetorno['erro'] = "Não existe usuario com o email informado";
				}
			}else{
				$dadosRetorno['erro'] = "É necessário o e-mail do futuro responsável e o código da entidade";
			}
			$dadosRetorno['criado'] = false;
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);
		}

		public function updateResponsible($request, $response, $args){
			$data = $request->getParsedBody();
			if(isset($data['email']) && isset($data['codigoEntidade'])){
				$usuario = UsuarioDAO::read("email='".$data['email']."'");
				if($usuario != []){
					$entidade = EntidadeDAO::read("codigoEntidade=".$data['codigoEntidade']);
					if($entidade != []){
						$existeUserEntidade = UsuarioEntidadeDAO::read("codigoEntidade=".$data['codigoEntidade']." and dataSaida is NULL");
						if($existeUserEntidade != []){
							UsuarioEntidadeDAO::retire("emailResponsavel='".$existeUserEntidade[0]['emailResponsavel']."' and codigoEntidade=".$data['codigoEntidade']." and dataSaida is NULL");
						}
						$usuarioEntidade = new UsuarioEntidade($data['codigoEntidade'], $data['email']);
						if(UsuarioEntidadeDAO::create($usuarioEntidade)){
							$dadosRetorno['criado'] = true;
							$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
							return $response->getBody()->write($body);
						}else{
							$dadosRetorno['erro'] = "Erro para criar responsavel por entidade";
						}
					}else{
						$dadosRetorno['erro'] = "Não foi encontrada Entidade com o código informado";
					}
				}else{
					$dadosRetorno['erro'] = "Não existe usuario com o email informado";
				}
			}else{
				$dadosRetorno['erro'] = "É necessário o e-mail do responsável e o código da entidade";
			}
			$dadosRetorno['criado'] = false;
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);
		}
	}

?>