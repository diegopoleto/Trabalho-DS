<?php
    use Models\Usuario;  
    use Models\Post;
    require_once "Models/DAO/UsuarioDAO.php";
    require_once "Models/DAO/PostDAO.php";
    require_once "RecoveryPasswordController.php";
    require_once "AuthenticationController.php";
    require_once "Models/BD.php";

    class UsuarioController{
    	public function listAll($request, $response, $args){
    		$return = UsuarioDAO::read("TRUE");
	        $body = json_encode($return, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
    	}

    	public function createUsuario($request,$response,$args){
    		$data = $request->getParsedBody();
	        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_STRING);

	        $existe = UsuarioDAO::read("email='".$data['email']."'");
	        if($existe == []){
		        $data['senha'] = filter_var($data['senha'], FILTER_SANITIZE_STRING);
		        $data['senha'] = hash('sha256', $data['senha']);
		        
		        $date = strtotime("+7 days", strtotime(date("Y/m/d H:i:s")));
				$string = $data['email'] . date("Y/m/d H:i:s", $date);
    			$data['tokenPortal'] = sha1($string);

		        $data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);
		        $data['sobrenome'] = filter_var($data['sobrenome'], FILTER_SANITIZE_STRING);
		        $data['tipoDeUsuario'] = filter_var($data['tipoDeUsuario'], FILTER_SANITIZE_STRING);
		        $data['dataNascimento'] = filter_var($data['dataNascimento'], FILTER_SANITIZE_STRING);
		        $usuario = new Usuario($data['nome'], $data['sobrenome'], $data['email'], $data['senha'], $data['tipoDeUsuario'], NULL);
		      
		        if(isset($data['curso'])){
		        	$usuario->setCodigoCurso(filter_var($data['curso'], FILTER_SANITIZE_STRING));
		        }
		        if(isset($data['dataNascimento'])){
		        	$usuario->setDtNasc($data['dataNascimento']);
		        }
		        if(isset($data['cpf'])){
		        	$usuario->setCpf(filter_var($data['cpf'], FILTER_SANITIZE_STRING));
		        }
		        if(isset($data['matricula'])){
		        	$usuario->setMatricula(filter_var($data['matricula'], FILTER_SANITIZE_STRING));
		        }
		        if(isset($data['siape'])){
		        	$usuario->setSiape(filter_var($data['siape'], FILTER_SANITIZE_STRING));
		        }
		        if(UsuarioDAO::create($usuario)){
		        	UsuarioDAO::updateToken($data['tokenPortal'], date("Y/m/d",$date), "email='".$data['email']."'");
		        	$dadosRetorno['tokenPortal'] = $data['tokenPortal'];
					$dadosRetorno['logado'] = true;
					$dadosRetorno['nome'] = $data['nome'];
					$dadosRetorno['sobrenome'] = $data['sobrenome'];
					$dadosRetorno['email'] = $data['email'];
					$dadosRetorno['tipoDeUsuario'] = $data['tipoDeUsuario'];
		        	$dadosRetorno['criado'] = true;
		        	$dadosRetorno['entidade'] = [];
		        	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
					return $response->getBody()->write($body);
		        }else{
			        $dadosRetorno['erro'] = "Erro ao realizar cadastro";
				}
			}else{
				$dadosRetorno['erro'] = "Usuario já cadastrado";
			}
			$dadosRetorno['criado'] = false;
			$dadosRetorno['logado'] = false;
            $dadosRetorno['tokenPortal'] = [];
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);
    	}

    	public function updateUsuario($request,$response,$args){
    		// Verificar se não falta testar Email passado e se token válido
    		$email = str_replace(";", ".", $args['email']);
    		$usuario = UsuarioDAO::read("email='".$email."'");
   			
   			$data = $request->getParsedBody();

   			if(isset($data['nome'])){
   				$data['nome'] = filter_var($data['nome'], FILTER_SANITIZE_STRING);
   			}else{
   				$data['nome'] = $usuario[0]['nome'];
   			}

   			if(isset($data['sobrenome'])){
	        	$data['sobrenome'] = filter_var($data['sobrenome'], FILTER_SANITIZE_STRING);
   			}else{
   				$data['sobrenome'] = $usuario[0]['sobrenome'];
   			}

   			if(isset($data['tipoDeUsuario'])){
	        	$data['tipoDeUsuario'] = filter_var($data['tipoDeUsuario'], FILTER_SANITIZE_STRING);
   			}else{
   				$data['tipoDeUsuario'] = $usuario[0]['tipoDeUsuario'];
   			}

   			if(isset($data['senha'])){
   				$data['senha'] = hash('sha256', $data['senha']);
   			}else{
   				$data['senha'] = $usuario[0]['senha'];
   			}
	        
	        $usuarioUpdate = new Usuario($data['nome'], $data['sobrenome'], $email, $data['senha'], $data['tipoDeUsuario'], null);

	        if(!isset($data['codigoCurso'])){
	        	$data['codigoCurso'] = $usuario[0]['codigoCurso'];
	        }
	        $usuarioUpdate->setCodigoCurso($data['codigoCurso']);

	        if(!isset($data['dataNascimento'])){
	        	$data['dataNascimento'] = $usuario[0]['dataNascimento'];
	        }
	        $usuarioUpdate->setDtNasc($data['dataNascimento']);

	        if(!isset($data['dataBanimento'])){
	        	$data['dataBanimento'] = $usuario[0]['dataBanimento'];
	        }
	        $usuarioUpdate->setDtBan($data['dataBanimento']);

	        if(isset($data['motivoBanimento'])){
	        	$data['motivoBanimento'] = filter_var($data['motivoBanimento'], FILTER_SANITIZE_STRING);
	        }else{
	        	$data['motivoBanimento'] = $usuario[0]['motivoBanimento'];
	        }
	        $usuarioUpdate->setMotBan($data['motivoBanimento']);

	        if(isset($data['emailAdminBanidor'])){
	        	$admin = UsuarioDAO::read("email='".$data['emailAdminBanidor']."'");
	        	if($admin[0]['tipoDeUsuario'] == "ADMIN"){
		        	$data['emailAdminBanidor'] = filter_var($data['emailAdminBanidor'], FILTER_SANITIZE_STRING);
	        	}
		        else{
		        	$dadosRetorno['erro'] = "Erro email de admin não é válido";
		      		$dadosRetorno['update'] = false;
		      		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
					return $response->getBody()->write($body);
		        }
	        }else{
	        	$data['emailAdminBanidor'] = $usuario[0]['emailAdminBanidor'];
	        }
	        $usuarioUpdate->setEmailAdminBan($data['emailAdminBanidor']);

	        if(isset($data['cpf'])){
	        	$data['cpf'] = filter_var($data['cpf'], FILTER_SANITIZE_STRING);
	        }else{
	        	$data['cpf'] = $usuario[0]['cpf'];
	        }
	        $usuarioUpdate->setCpf($data['cpf']);

	        if(isset($data['siape'])){
	        	$data['siape'] = filter_var($data['siape'], FILTER_SANITIZE_STRING);
	        }else{
	        	$data['siape'] = $usuario[0]['siape'];
	        }
	        $usuarioUpdate->setSiape($data['siape']);

	        if(isset($data['matricula'])){
	        	$data['matricula'] = filter_var($data['matricula'], FILTER_SANITIZE_STRING);
	        }else{
	        	$data['matricula'] = $usuario[0]['matricula'];
	        }
	        $usuarioUpdate->setMatricula($data['matricula']);

	        if(!isset($data['isCoordenador'])){
	        	$data['isCoordenador'] = $usuario[0]['isCoordenador'];
	        }
	        $usuarioUpdate->setIsCoordenador($data['isCoordenador']);

	        $usuarioUpdate->setToken($usuario[0]['token']);
	        $usuarioUpdate->setDtExpToken($usuario[0]['dataExpiracaoToken']);

	        if(UsuarioDAO::update($usuarioUpdate, "email='" . $email . "'")){
		        $dadosRetorno['update'] = true;	        
		    }else{
		      	$dadosRetorno['erro'] = "Erro ao atualizar usuario";
		      	$dadosRetorno['update'] = false;
		    }
		    $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);    
    	}

    	public function banUsuario($request, $response, $args){
    		// Verificar se não falta testar Email passado e se token válido

    		$email = str_replace(";", ".", $args['email']);
	        $data = $request->getParsedBody();
	        $data['motivoBanimento'] = filter_var($data['motivoBanimento'], FILTER_SANITIZE_STRING);
	        $data['emailAdminBanidor'] = filter_var($data['emailAdminBanidor'], FILTER_SANITIZE_STRING);

	        $admin = UsuarioDAO::read("email='".$data['emailAdminBanidor']."'");
	        if($admin[0]['tipoDeUsuario'] == "ADMIN"){
	        	$usuario = UsuarioDAO::read("email='".$email."'");	        

		        $usuarioBanido = new Usuario($usuario[0]['nome'], $usuario[0]['sobrenome'], $email, $usuario[0]['senha'], $usuario[0]['tipoDeUsuario'], null);
		        $usuarioBanido->setCpf($usuario[0]['cpf']);
		        $usuarioBanido->setSiape($usuario[0]['siape']);
		        $usuarioBanido->setMatricula($usuario[0]['matricula']);
		        $usuarioBanido->setToken($usuario[0]['token']);
		        $usuarioBanido->setCodigoCurso($usuario[0]['codigoCurso']);
		        $usuarioBanido->setDtExpToken($usuario[0]['dataExpiracaoToken']);    
		        $usuarioBanido->setDtNasc($usuario[0]['dataNascimento']);
		        $usuarioBanido->setDtCad($usuario[0]['dataCadastro']);
		        $usuarioBanido->setDtBan(date('Y-m-d h:i:s', time()));
		        $usuarioBanido->setMotBan($data['motivoBanimento']);
		        $usuarioBanido->setEmailAdminBan($data['emailAdminBanidor']);

		        if(UsuarioDAO::update($usuarioBanido, "email='" . $email . "'")){
		        	$dadosRetorno['banido'] = true;
		        	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			        return $response->getBody()->write($body);	
		        }else{
		        	$dadosRetorno['erro'] = "Erro ao atualizar usuario";
		        }   
	        }else{
	        	$dadosRetorno['erro'] = "Apenas admin pode banir usuario";
	        }
	        $dadosRetorno['banido'] = false;
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			return $response->getBody()->write($body);  
    	}

    	public function getPerfilInfos($request, $response, $args){
    		if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
		    		$data = $args['email'];   //patrick, adiciona uma validação para ver se veio este campo em args pfvr.
		    		$dadosRetorno['tokenPortal'] = $token;
					$usuario = UsuarioDAO::read("email='".$data."'");	    		
					if($usuario != []){
					 	$dadosRetorno['nome'] = $usuario[0]['nome'];
					 	$dadosRetorno['sobrenome'] = $usuario[0]['sobrenome'];
					 	$dadosRetorno['dataNascimento'] = $usuario[0]['dataNascimento'];
					 	$dadosRetorno['cpf'] = $usuario[0]['cpf'];
					 	$dadosRetorno['email'] = $usuario[0]['email'];
					 	$dadosRetorno['tipoUsuario'] = $usuario[0]['tipoDeUsuario'];
					 	if($usuario[0]['tipoDeUsuario'] === "ALUNO"){
					 		$dadosRetorno['matricula'] = $usuario[0]['matricula'];
					 	}else{
					 		$dadosRetorno['siape'] = $usuario[0]['siape'];
					 	}
					 	
					 	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
						return $response->getBody()->write($body);
					}
					else{
					 	//nao existe usuario com o email passado
					 	$dadosRetorno['erro'] = "Usuario nao cadastrado";
					 	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
						return $response->getBody()->write($body);
					}
                	$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
                	return $response->getBody()->write($body);
				}
                
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
            $dadosRetorno['mensagens'] = [];
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);    	
    	}

    	public function requestNewPassword($request, $response, $args){
    		$data = $request->getParsedBody();
    		if(isset($data['email'])){
    			if(trim($data['email']) !== ''){
    				$usuario = UsuarioDAO::read("email='".$data['email']."'");	    		
					if($usuario != []){
						if(!RecoveryPasswordController::existTokenToThisUser($usuario[0]['email'], $usuario[0]['nome'])){
							if(RecoveryPasswordController::createNewRequest($usuario[0]['email'], $usuario[0]['nome'])){
								$dadosRetorno['asked'] = true;
							}else{
								$dadosRetorno['asked'] = false;
	    					}
    					}else{
    						$dadosRetorno['asked'] = true;
    					}
    					$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	    				return $response->getBody()->write($body);
					}else{
						$dadosRetorno['erro'] = "Usuario nao cadastrado";
					}
    			}else{
    				$dadosRetorno['erro'] = "Usuario inválido";
    			}
    		}else{
    			$dadosRetorno['erro'] = "Usuario nao informado";
    		}
    		$dadosRetorno['asked'] = false;
    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
    		$response->getBody()->write($body);
    	}

    	public function timeline($request, $response, $args){
    		if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
				$email = $request->getHeaderLine('userId');
				$token = $request->getHeaderLine('tokenPortal');
				$auth = AuthenticationController::validateToken($token, $email);
				if($auth['logado']){
		    		if($request->hasHeader('tokenPortal')){
					    $usuario = UsuarioDAO::read("token='".$token."'");
				    	if($usuario!=[]){
				    		$data = $request->getParsedBody();
				    		$sql = "select Post.mensagem, Post.dataCriacao, Post.anonimo, Post.codigoEntidadeMarcada, Post.emailUsuarioCriador,	Post.entidadeCriadora, Usuario.nome, Usuario.sobrenome from Post join Usuario on Usuario.email=Post.emailUsuarioCriador order by Post.dataCriacao desc";
				    			$posts = BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
				    			for($i = 0; $i<count($posts); $i++){
					    			if(!is_null($posts[$i]['codigoEntidadeMarcada'])){
					    				$sql = "select Entidade.nome from Entidade where codigoEntidade=".$posts[$i]['codigoEntidadeMarcada'];
					    				$entidade = BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
					    				$posts[$i]['nomeEntidadeMarcada'] = $entidade[0]['nome'];
					    			}
					    			if(!is_null($posts[$i]['entidadeCriadora'])){
					    				$sql = "select Entidade.nome from Entidade where codigoEntidade=".$posts[$i]['codigoEntidadeMarcada'];
					    				$entidade = BD::query($sql)->fetchAll(PDO::FETCH_ASSOC);
					    				$posts[$i]['nomeEntidadeAutora'] = $entidade[0]['nome'];
					    			}
					    		}
					    		$dadosRetorno['posts'] = $posts;
					    		$dadosRetorno['tokenPortal'] = $token;
					   			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
					    		return $response->getBody()->write($body);
				    	}		    			    
		    		}
    			}
	        }else{
	        	$dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
	        }
	        $dadosRetorno['tokenPortal'] = [];
	        $body = json_encode($return, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
    	}

    	public function resetPassword($request, $response, $args){
    		if(!is_null($args['hash'])){
    			$data = $request->getParsedBody();
    			if(!(is_null($data['senha']))){
    				if(!(trim($data['senha'] === ''))){
    					$usuario['email'] = RecoveryPasswordController::getEmailByToken($args['hash']);
    					$data['senha'] = hash('sha256', $data['senha']);
    					if(UsuarioDAO::updatePassword($usuario['email'], $data['senha'])){
    						RecoveryPasswordController::deleteRequest($args['hash']);
    						$dadosRetorno['reseted'] = true;
    						$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
				    		return $response->getBody()->write($body);
    					}else{
    						$dadosRetorno['erro'] = "Erro ao alterar senha";
    					}
    				}else{
    					$dadosRetorno['erro'] = "Senha deve ser diferente de vazio";
    				}
    			}else{
    				$dadosRetorno['erro'] = "Deve ser informada uma senha";
    			}
    		}else{
    			$dadosRetorno['erro'] = "Token inválido";
    		}
    		$dadosRetorno['reseted'] = false;
    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			$response->getBody()->write($body);
    	}
    }
?>