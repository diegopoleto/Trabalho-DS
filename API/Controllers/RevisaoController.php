<?php
    use Models\Revisao;
    use Models\Usuario;
    use Models\Conversa;
    use Models\Mensagem;
    require_once "Models/DAO/ConversaDAO.php";
    require_once "Models/DAO/MensagemDAO.php";
    require_once "Models/DAO/RevisaoDAO.php";
    require_once "Models/DAO/UsuarioDAO.php";
    require_once "Models/BD.php";

    class RevisaoController{
    	public function viewRevision($request, $response, $args){
    		
			$data = $args['coordenador'];
			if($data!= []){
				$coord = UsuarioDAO::read("email='".$data."'");
				if($coord!=[]){								
					if($coord[0]['isCoordenador']){						
						$revisao = RevisaoDAO::read("emailRevisor='".$data."'");				
						
						if($revisao!=[]){
							for($i = 0; $i < count($revisao); $i++){
								$Usuario[$i]['remetente'] = UsuarioDAO::read("email='".$revisao[$i]['emailRemetente']."'");
								$Usuario[$i]['destinatario'] = UsuarioDAO::read("email='".$revisao[$i]['emailDestinatario']."'");								
								
								$isAnonima = ConversaDAO::read("emailRemetente='".$Usuario[$i]["remetente"][0]['email']."' and emailDestinatario='".$Usuario[$i]['destinatario'][0]['email']."' and isAnonima='".$revisao[$i]['isAnonima']."'");
								
								//VERIFICAR COM FRONT QUEM VAI TRATAR OS ANONIMOS
								/*if($isAnonima[0]['isAnonima']){
									$conversas['conversas'][$i]['usuario1']['nome'] = "Anônimx";
									$conversas['conversas'][$i]['usuario1']['sobrenome'] = "---";
									$conversas['conversas'][$i]['usuario1']['id'] = "---";
								}
								else{*/
									$conversas['conversas'][$i]['usuario1']['nome'] = $Usuario[$i]['remetente'][0]['nome'];
									$conversas['conversas'][$i]['usuario1']['sobrenome'] = $Usuario[$i]['remetente'][0]['sobrenome'];
									$conversas['conversas'][$i]['usuario1']['id'] = $Usuario[$i]['remetente'][0]['email'];
								//}							
								$conversas['conversas'][$i]['usuario2']['nome'] = $Usuario[$i]['destinatario'][0]['nome'];
								$conversas['conversas'][$i]['usuario2']['sobrenome'] = $Usuario[$i]['destinatario'][0]['sobrenome'];
								$conversas['conversas'][$i]['usuario2']['id'] = $Usuario[$i]['destinatario'][0]['email'];					 		
							}
							$conversas['tokenPortal'] = $request->getHeaderLine('tokenPortal');
							$body = json_encode($conversas, JSON_UNESCAPED_UNICODE);
				        	$response->getBody()->write($body);
				        	return $response;
			        	}
		        	}
		        }		        				
			}
			$dadosRetorno['conversas'] = [];
			$dadosRetorno['tokenPortal'] = [];
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			$response->getBody()->write($body);	        			
    	}
    	public function seeConversationToRevision($request, $response, $args){
    		
    		$data['usuario1'] = $args['usuario1'];
    		$data['usuario2'] = $args['usuario2'];
    		if($data['usuario1']!=[] && $data['usuario2']!=[]){
    			$usuario1 = UsuarioDAO::read("email='".$data['usuario1']."'");
    			$usuario2 = UsuarioDAO::read("email='".$data['usuario2']."'");    						
    			if($usuario1!=[] && $usuario2!=[]){
    				$dadosBody = $request->getParsedBody();
    				if($dadosBody['isAnonima'] == 1 or $dadosBody['isAnonima'] == true){
    					$dadosBody['isAnonima'] = 1;
					}else{
						$dadosBody['isAnonima'] = 0;
					}    				
    				$conversas1 = RevisaoDAO::read("emailRemetente='".$usuario1[0]['email']."' and emailDestinatario='".$usuario2[0]['email']."' and isAnonima='".$dadosBody['isAnonima']."'");    				
    				if($conversas1!=[]){    					
    					if($dadosBody['ultimaMensagem'] == ''){    				    					
    						$mensagens = MensagemDAO::read("((emailRemetente='".$usuario1[0]['email']."' and emailDestinatario='".$usuario2[0]['email']."') or (emailRemetente='".$usuario2[0]['email']."' and emailDestinatario='".$usuario1[0]['email']."')) and isAnonima= '".$dadosBody['isAnonima']."'order by dataCriacao limit 2");     				
    					}
    					else{
    						$mensagens = MensagemDAO::read("(((emailRemetente='".$usuario1[0]['email']."' and emailDestinatario='".$usuario2[0]['email']."') or (emailRemetente='".$usuario2[0]['email']."' and emailDestinatario='".$usuario1[0]['email']."')) and isAnonima='".$dadosBody['isAnonima']."' ) and dataCriacao < '".$dadosBody['ultimaMensagem']."' order by dataCriacao limit 10");
    					}
    					for($i = 0; $i<count($mensagens); $i++){
							$usrRem = UsuarioDAO::read("email='".$mensagens[$i]['emailRemetente']."'");
							if($usrRem[0]['email'] === $usuario1[0]['email']){
								if($mensagens[$i]['isAnonima']){
									$dadosRetorno[$i]['usuarioId'] = "Anônimx";
								}
								else{
									$dadosRetorno[$i]['usuarioId'] = $usrRem[0]['nome'];
								}															
							}
							else{
								$dadosRetorno[$i]['usuarioId'] = $usrRem[0]['nome'];
							}
							$dadosRetorno[$i]['data'] = $mensagens[$i]['dataCriacao'];
							$dadosRetorno[$i]['mensagem'] = $mensagens[$i]['texto'];
						}
						$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
						return $response->getBody()->write($body);    					
    				}    				
    			}
    		}
    		$dadosRetorno['mensagens'] = [];
    		$$dadosRetorno['tokenPortal'] = [];
			$body = json_encode($dadosRetorno, JSON_UNESCAPED_UNICODE);
			$response->getBody()->write($body);	    			
    	} 

    	public function sendRevision($request, $response, $args){
    		
    		$data['coordenador'] = $args['coordenador'];
    		$data['usuario1'] = $args['usuario1'];
    		$data['usuario2'] = $args['usuario2'];

    		if($data['coordenador']!=[] && $data['usuario1']!=[] && $data['usuario2']!=[]){
    			$dadosBody = $request->getParsedBody();
    			if($dadosBody['isAnonima'] == 1 or $dadosBody['isAnonima'] == true){
    					$dadosBody['isAnonima'] = 1;
				}else{
					$dadosBody['isAnonima'] = 0;
				}				    			
    			$revisaoSelect = RevisaoDAO::read("((emailRemetente='".$data['usuario1']. "' and emailDestinatario='".$data['usuario2']."') or (emailRemetente='".$data['usuario2']. "' and emailDestinatario='".$data['usuario1']."')) and isAnonima=".$dadosBody['isAnonima']);
    			if($revisaoSelect!=[]){
    				$revisao = new Revisao($revisaoSelect[0]['emailRemetente'], $revisaoSelect[0]['emailDestinatario'], $revisaoSelect[0]['isAnonima'], $revisaoSelect[0]['emailSolicRevisao']);    				
    				$revisao->setEmailRevisor($data['coordenador']);
    				$revisao->setComentarioRevisao($dadosBody['motivo']);    				
    				$revisao->setDataRevisao(date('Y-m-d h:i:s', time()));
    				$revisao->setComentarioRevisao($dadosBody['motivo']);
    				$revisao->setGravidadeInfracao($dadosBody['gravidade']);
    				$dadosRetorno = RevisaoDAO::update($revisao,"emailRemetente='".$revisaoSelect[0]['emailRemetente']."'and emailDestinatario='".$revisaoSelect[0]['emailDestinatario']."'");
    				$token = $request->getHeaderLine('tokenPortal');
    				$body = json_encode($token, JSON_UNESCAPED_UNICODE);
					return $response->getBody()->write($body);
    			}    			
    		}
    		$token = [];
			$body = json_encode($token, JSON_UNESCAPED_UNICODE);
			$response->getBody()->write($body);
    	}   		
    	
    }

?>