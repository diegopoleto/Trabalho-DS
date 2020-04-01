<?php
    use Models\Conversa;
    use Models\Mensagem;
    use Models\Revisao;
    require_once "Models/DAO/ConversaDAO.php";
    require_once "Models/DAO/RevisaoDAO.php";
    require_once "Models/DAO/UsuarioDAO.php";
    require_once "Models/DAO/MensagemDAO.php";
    require_once "Models/BD.php";

    class ConversaController{
    	public function listAll($request,$response,$args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
    		      $dadosRetorno['conversas'] = ConversaDAO::read("TRUE");
                  $dadosRetorno['tokenPortal'] = $token;
                }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
                $dadosRetorno['tokenPortal'] = [];
            }
            
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
	        $response->getBody()->write($body);
	        return $response;
    	}

    	public function createConversa($request,$response,$args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
            		$data = $request->getParsedBody();
        	        $data['emailResponsavel'] = filter_var($data['emailRemetente'], FILTER_SANITIZE_STRING);
        	        $data['emailDestinatario'] = filter_var($data['emailDestinatario'], FILTER_SANITIZE_STRING);
        	        $data['isAnonima'] = filter_var($data['isAnonima'], FILTER_SANITIZE_STRING);
        	        if($data['isAnonima'] == "Sim"){
        	            $data['isAnonima'] = 1;
        	        }
        	        else{
        	            $data['isAnonima'] = 0;
        	        }

        	        $usuario = new Conversa($data['emailResponsavel'], $data['emailDestinatario'], $data['isAnonima']);
        	        if(ConversaDAO::create($usuario)){
                        $dadosRetorno['criado'] = true;
                    }else{
                        $dadosRetorno['criado'] = false;
                        $dadosRetorno['erro'] = "Erro para criar esta conversa";
                    }
                    $dadosRetorno['tokenPortal'] = $token;
                }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
                $dadosRetorno['tokenPortal'] = [];
                }
            }else{
                $dadosRetorno['tokenPortal'] = [];
            }
            
	        $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            return $response->getBody()->write($body);
    	}

    	public function recentConversations($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
            		if(!is_null($args['usuarioId'])){
            			if(!(trim($args['usuarioId'] === ''))){
            				$lista = ConversaDAO::read("emailRemetente='".$args['usuarioId']."' OR emailDestinatario='".$args['usuarioId']."'");
            				if($lista != []){
            					for($i = 0; $i<count($lista); $i++){
            						if($args['usuarioId'] === $lista[$i]['emailRemetente']){
            							$outroUsuario = UsuarioDAO::read("email='".$lista[$i]['emailDestinatario']."'");
            							//if($lista[$i]['isAnonima']){
        	    						//	$listaUsuariosRetorno[$i]['nome'] = "Anônimx";
            							//	$listaUsuariosRetorno[$i]['usuarioId'] = "---";
            							//}else{
            								$listaUsuariosRetorno[$i]['nome'] = $outroUsuario[0]['nome']." ".$outroUsuario[0]['sobrenome'];
            								$listaUsuariosRetorno[$i]['usuarioId'] = $outroUsuario[0]['email'];
            							//}
            							$listaUsuariosRetorno[$i]['tipoDeUsuario'] = $outroUsuario[0]['tipoDeUsuario'];
        	    					}else{
        	    						$outroUsuario = UsuarioDAO::read("email='".$lista[$i]['emailRemetente']."'");
            							//if($lista[$i]['isAnonima']){
        	    						//	$listaUsuariosRetorno[$i]['nome'] = "Anônimx";
            							//	$listaUsuariosRetorno[$i]['usuarioId'] = "---";
            							//}else{
            								$listaUsuariosRetorno[$i]['nome'] = $outroUsuario[0]['nome']." ".$outroUsuario[0]['sobrenome'];
            								$listaUsuariosRetorno[$i]['usuarioId'] = $outroUsuario[0]['email'];
            							//}
            							$listaUsuariosRetorno[$i]['tipoDeUsuario'] = $outroUsuario[0]['tipoDeUsuario'];
        	    					}
            					}
            					$dadosRetorno['usuarios'] = $listaUsuariosRetorno;
                                $dadosRetorno['tokenPortal'] = $token;	 
            				}else{
                                $dadosRetorno['tokenPortal'] = $token;
                                $dadosRetorno['usuarios'] = [];
                            }
                            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
                            return $response->getBody()->write($body);
            			}
            		}
                }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
    		$dadosRetorno['usuarios'] = [];
    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
    		return $response->getBody()->write($body);	 
    	}

    	public function createConversation($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
            		if((!is_null($args['usuario1']))&&(!is_null($args['usuario2']))){
            			if((!(trim($args['usuario1'] === '')))&&(!(trim($args['usuario2'] === '')))){
            				$data = $request->getParsedBody();
            				if($data['anonima'] == 1 or $data['anonima'] == true){
            					$data['anonima'] = 1;
            				}else{
            					$data['anonima'] = 0;
            				}
            				$lista = ConversaDAO::read("(emailRemetente='".$args['usuario1']."' OR emailDestinatario='".$args['usuario1']."') AND (emailRemetente='".$args['usuario2']."' OR emailDestinatario='".$args['usuario2']."') AND isAnonima=".$data['anonima']);
            				if($lista == []){
        		    			$conversa =	new Conversa($args['usuario1'], $args['usuario2'], $data['anonima']);
        				        if(ConversaDAO::create($conversa)){
        				        	$dadosRetorno['criado'] = true;
                                    $dadosRetorno['tokenPortal'] = $token;
        	    					$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
        	    					return $response->getBody()->write($body);
        				        }else{
                                    $dadosRetorno['erro'] = "Erro para criar conversa";
                                }
        			    	}else{
                                $dadosRetorno['erro'] = "Ja existe uma conversa entre estes usuarios";
                            }
            			}else{
                            $dadosRetorno['erro'] = "Pelo menos um dos usuários informados é inválido";
                        }
            		}else{
                        $dadosRetorno['erro'] = "Devem ser informados dois usuarios para criar uma conversa";
                    }
                    }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
    		$dadosRetorno['criado'] = false;
    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
    		$response->getBody()->write($body);
    	}

    	public function sendMenssageInConversation($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
            		if((!is_null($args['usuario1']))&&(!is_null($args['usuario2']))){
            			if((!(trim($args['usuario1'] === '')))&&(!(trim($args['usuario2'] === '')))){
            				$data = $request->getParsedBody();
            				if($data['mensagem'] !== ""){
            					if($data['anonima'] == 1 or $data['anonima'] == true){
        			    			$data['anonima'] = 1;
        				    	}else{
        				    		$data['anonima'] = 0;
        				    	}
            					$lista = ConversaDAO::read("(emailRemetente='".$args['usuario1']."' OR emailDestinatario='".$args['usuario1']."') AND (emailRemetente='".$args['usuario2']."' OR emailDestinatario='".$args['usuario2']."') AND isAnonima=".$data['anonima']);
            					if($lista != []){
            						if($args['usuario1'] === $lista[0]['emailRemetente']){
            							$outroUsuario = UsuarioDAO::read("email='".$lista[0]['emailDestinatario']."'");
            							$emitente = $lista[0]['emailRemetente'];
            						}else{
            							$outroUsuario = UsuarioDAO::read("email='".$lista[0]['emailRemetente']."'");
            							$emitente = $lista[0]['emailDestinatario'];
            						}
            						if($outroUsuario[0]['tipoDeUsuario'] === "ALUNO"){
            							$data['anonima'] = 0;
            						}
            						$mensagem = new Mensagem(null, $data['mensagem'], $lista[0]['emailRemetente'], $lista[0]['emailDestinatario'], $data['anonima'], $args['usuario1']);
            						if(MensagemDAO::create($mensagem)){
            							$dadosRetorno['criado'] = true;
                                        $dadosRetorno['tokenPortal'] = $token;
        					    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
        					    		return $response->getBody()->write($body);
            						}else{
            							$dadosRetorno['erro'] = "Erro para criar a mensagem";
            						}
            					}else{
            						$dadosRetorno['erro'] = "Não foi possivel encontrar conversa com estes usuario e identificador de anonimo";
            					}
            				}else{
            					$dadosRetorno['erro'] = "Mensagem não pode estar em branco";
            				}
            			}else{
            				$dadosRetorno['erro'] = "Deve ser informado dois usuarios validos";
            			}
            		}else{
            			$dadosRetorno['erro'] = "Deve ser informado dois usuarios para criar mensagem";
            		}
                }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
    		$dadosRetorno['criado'] = false;
    		$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
    		$response->getBody()->write($body);
    	}

        public function sendConversationToRevision($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
                    if((!is_null($args['usuario1']))&&(!is_null($args['usuario2']))){
                        if((!(trim($args['usuario1'] === '')))&&(!(trim($args['usuario2'] === '')))){
                            $data = $request->getParsedBody();
                            if($data['anonima'] == 1 or $data['anonima'] == true){
                                $data['anonima'] = 1;
                            }else{
                                $data['anonima'] = 0;
                            }
                            $lista = ConversaDAO::read("(emailRemetente='".$args['usuario1']."' OR emailDestinatario='".$args['usuario1']."') AND (emailRemetente='".$args['usuario2']."' OR emailDestinatario='".$args['usuario2']."') AND isAnonima=".$data['anonima']);
                            if($lista != []){
                                if($lista[0]['emailRemetente'] === $args['usuario1']){
                                    $remetente = $args['usuario1'];
                                    $dest = $args['usuario2'];
                                }else{
                                    $remetente = $args['usuario2'];
                                    $dest = $args['usuario1'];
                                }
                                $revisao = new Revisao($remetente, $dest, $data['anonima'], $args['usuario1']);
                                if(RevisaoDAO::create($revisao)){
                                    $dadosRetorno['criado'] = true;
                                    $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
                                    return $response->getBody()->write($body);
                                }else{
                                    $dadosRetorno['erro'] = "Erro para solicitar revisao";
                                }
                                $dadosRetorno['tokenPortal'] = $token;
                            }else{
                                $dadosRetorno['erro'] = "Não foi encontrada conversa entre estes dois usuários";
                            }

                        }else{
                            $dadosRetorno['erro'] = "Deve ser informado dois usuarios validos";
                        }
                    }else{
                        $dadosRetorno['erro'] = "Deve ser informado dois usuarios para criar revisao";
                    }
                }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
            $dadosRetorno['criado'] = false;
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
        }

        public function findConversationWithUser($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
                    $usuarios = UsuarioDAO::read("email!='".$email."'");
                    $dadosRetorno['usuarios'] = $usuarios;
                    $dadosRetorno['tokenPortal'] = $token;
                    $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
                    return $response->getBody()->write($body);
                }
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
            $dadosRetorno['usuarios'] = [];
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
        }

        public function viewConversation($request, $response, $args){
            if ($request->hasHeader('tokenPortal') && $request->hasHeader('userId')) {
                $email = $request->getHeaderLine('userId');
                $token = $request->getHeaderLine('tokenPortal');
                $auth = AuthenticationController::validateToken($token, $email);
                if($auth['logado']){
                    if((!is_null($args['usuario1']))&&(!is_null($args['usuario2']))){
                        if((!(trim($args['usuario1'] === '')))&&(!(trim($args['usuario2'] === '')))){
                            $conversa = ConversaDAO::read("(emailRemetente='".$args['usuario1']."' OR emailDestinatario='".$args['usuario1']."') AND (emailRemetente='".$args['usuario2']."' OR emailDestinatario='".$args['usuario2']."') AND isAnonima=0");
                            $mensagens = MensagemDAO::read("emailRemetente='".$conversa[0]['emailRemetente']."' and emailDestinatario='".$conversa[0]['emailDestinatario']."' and isAnonima=0");
                            $dadosRetorno['mensagens'] = $mensagens;
                        }else{
                            $dadosRetorno['erro'] = "Deve ser informado dois usuarios validos";
                        }
                    }else{
                        $dadosRetorno['erro'] = "Deve ser informado dois usuarios para criar conversa";
                    }
                }
                $dadosRetorno['tokenPortal'] = $token;
                $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
                return $response->getBody()->write($body);
            }else{
                $dadosRetorno['erro'] = "É necessário o token de acesso e o userId";
            }
            $dadosRetorno['tokenPortal'] = [];
            $dadosRetorno['mensagens'] = [];
            $body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
            $response->getBody()->write($body);
        }
    }