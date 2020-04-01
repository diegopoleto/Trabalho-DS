<?php
	use Models\Usuario;
    use Models\Entidade;
    use Models\UsuarioEntidade;
    require_once "Models/DAO/UsuarioDAO.php";
    require_once "Models/DAO/EntidadeDAO.php";
    require_once "Models/DAO/UsuarioEntidadeDAO.php";

    class AuthenticationController{
    	public function validateTokenByURL($request, $response, $args){
    		if ($request->hasHeader('tokenPortal')) {
    			$token = $request->getHeaderLine('tokenPortal');
    			if(!(is_null($token) || trim($token) === '')){
    				$usuario = UsuarioDAO::read("token='".$token."' and email='".$args['userId']."'"); //select usuario
                    $listaEntidades = null;
    				if($usuario != []){
    					$isFuncionario = UsuarioEntidadeDAO::read("emailResponsavel='".$usuario[0]['email']."'");
    					if($isFuncionario != []){
    						$codigosDasEntidades = "codigoEntidade= '".$isFuncionario[0]['codigoEntidade']."'";
    						if(count($isFuncionario)>1){
	    						for($i = 1; $i<count($isFuncionario); $i++){
	    							$codigosDasEntidades .= ' OR codigoEntidade='.$isFuncionario[$i]['codigoEntidade'];    		
	    						}
	    					}
    						$listaEntidades = EntidadeDAO::read($codigosDasEntidades);
    					}    					
    					$dadosRetorno["logado"] = true;
                        $dadosRetorno["tokenPortal"] = $token;
    					$dadosRetorno["nome"] = $usuario[0]['nome'];
    					$dadosRetorno["sobrenome"] = $usuario[0]['sobrenome'];
    					$dadosRetorno["email"] = $usuario[0]['email'];
    					$dadosRetorno["tipo"] = $usuario[0]['tipoDeUsuario'];
    					if(!is_null($listaEntidades)){
	    					for($i = 0; $i<count($listaEntidades); $i++){
								$entidades[$i]['codigoEntidade'] =$listaEntidades[$i]['codigoEntidade'];
								$entidades[$i]['nome'] =$listaEntidades[$i]['nome'];
							}
							$dadosRetorno['entidade'] = $entidades;
						}
    					$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
    					return $response->getBody()->write($body);	        		
    				}else{
                        $dadosRetorno['erro'] = "Não encontrado usuário com este e-mail e token";
                    }
    			}else{
                    $dadosRetorno['erro'] = "Token inválido";
                }
			}else{
                $dadosRetorno['erro'] = "Token não informado";
            }
            $dadosRetorno['logado'] = false;
            $dadosRetorno['tokenPortal'] = [];
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            return $response->getBody()->write($body);
    	}

        public static function validateToken($token, $email){
            if(!(is_null($email) || trim($email) === '')){
                if(!(is_null($token) || trim($token) === '')){
                    $usuario = UsuarioDAO::read("token='".$token."' and email='".$email."'"); //select usuario
                    $listaEntidades = null;
                    if($usuario != []){
                        $isFuncionario = UsuarioEntidadeDAO::read("emailResponsavel='".$usuario[0]['email']."'");
                        if($isFuncionario != []){
                            $codigosDasEntidades = "codigoEntidade= '".$isFuncionario[0]['codigoEntidade']."'";
                            if(count($isFuncionario)>1){
                                for($i = 1; $i<count($isFuncionario); $i++){
                                    $codigosDasEntidades .= ' OR codigoEntidade='.$isFuncionario[$i]['codigoEntidade'];         
                                }
                            }
                            $listaEntidades = EntidadeDAO::read($codigosDasEntidades);
                        }                       
                        $dadosRetorno["logado"] = true;
                        $dadosRetorno["tokenPortal"] = $token;
                        $dadosRetorno["nome"] = $usuario[0]['nome'];
                        $dadosRetorno["sobrenome"] = $usuario[0]['sobrenome'];
                        $dadosRetorno["email"] = $usuario[0]['email'];
                        $dadosRetorno["tipo"] = $usuario[0]['tipoDeUsuario'];
                        if(!is_null($listaEntidades)){
                            for($i = 0; $i<count($listaEntidades); $i++){
                                $entidades[$i]['codigoEntidade'] =$listaEntidades[$i]['codigoEntidade'];
                                $entidades[$i]['nome'] =$listaEntidades[$i]['nome'];
                            }
                            $dadosRetorno['entidade'] = $entidades;
                        }
                        return $dadosRetorno;                  
                    }else{
                        $dadosRetorno['erro'] = "Não encontrado usuário com este e-mail e token";
                    }
                }else{
                    $dadosRetorno['erro'] = "Token inválido";
                }
            }else{
                $dadosRetorno['erro'] = "Email inválido";
            }
            $dadosRetorno['logado'] = false;
            $dadosRetorno['tokenPortal'] = [];
            return $dadosRetorno;
        }

    	public static function login($request, $response, $args){
    		$data = $request->getParsedBody();
    		if(isset($data['email']) && isset($data['senha'])){
    			if(trim($data['email']) !== '' && trim($data['senha']) !== ''){
    				$data['senha'] = hash('sha256', $data['senha']);
    				$usuario = UsuarioDAO::read("email='".$data['email']."'");
    				if($usuario != []){
    					if($usuario[0]['senha'] === $data['senha']){
    						$date = strtotime("+7 days", strtotime(date("Y/m/d H:i:s")));
							$string = $data['email'] . date("Y/m/d H:i:s", $date);
    						$token = sha1($string);

    						if(UsuarioDAO::updateToken($token, date("Y/m/d",$date), "email='".$data['email']."'")){
									$isFuncionario = UsuarioEntidadeDAO::read("emailResponsavel='".$usuario[0]['email']."'");
                                    $listaEntidades = null;
									if($isFuncionario != []){
										$codigosDasEntidades = "codigoEntidade= '".$isFuncionario[0]['codigoEntidade']."'";
										if(count($isFuncionario)>1){
											for($i = 1; $i<count($isFuncionario); $i++){
												$codigosDasEntidades .= ' OR codigoEntidade='.$isFuncionario[$i]['codigoEntidade'];    		
											}
										}
										$listaEntidades = EntidadeDAO::read($codigosDasEntidades);
									}
                                    $dadosRetorno["tokenPortal"] = $token;				
									$dadosRetorno["logado"] = true;
									$dadosRetorno["nome"] = $usuario[0]['nome'];
									$dadosRetorno["sobrenome"] = $usuario[0]['sobrenome'];
									$dadosRetorno["email"] = $usuario[0]['email'];
									$dadosRetorno["tipo"] = $usuario[0]['tipoDeUsuario'];
									if(!is_null($listaEntidades)){
										for($i = 0; $i<count($listaEntidades); $i++){
											$entidades[$i]['codigoEntidade'] =$listaEntidades[$i]['codigoEntidade'];
											$entidades[$i]['nome'] =$listaEntidades[$i]['nome'];
										}
										$dadosRetorno['entidades'] = $entidades;
									}	
									$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
									$response->getBody()->write($body);
					    			return $response;		        		
							
    						}else{
    							$dadosRetorno['erro'] = "Falha na autenticacao do login";
    						}
    					}else{
							$dadosRetorno['erro'] = "Senha incorreta";
    					}
    				}else{
						$dadosRetorno['erro'] = "Usuario nao cadastrado";
    				}
    			}else{
                    $dadosRetorno['erro'] = "Email ou Senha informado em branco";
                }
    		}else{
                $dadosRetorno['erro'] = "Email ou Senha não informado";
            }
            $dadosRetorno['logado'] = false;
            $dadosRetorno['tokenPortal'] = [];
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
    	}
    }
?>