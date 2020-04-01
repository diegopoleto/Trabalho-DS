<?php

	class BD{

		public static function query($query){
			try{
				$PDO = new PDO('mysql:host=localhost;dbname=DS', 'root', '1234');
				$result = $PDO->query("SET CHARACTER SET utf8;");
				if($result == FALSE){
					//die(var_export($PDO->errorinfo(), TRUE));
					//echo (var_export($PDO->errorinfo(), TRUE));
				}
				return $PDO->query($query);
			}catch (PDOException $e)
			{
			    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
			}
		}

		public function dropAndInitializeBD(){
			$this->dropDatabase();
			$this->initializeBD();
		}

		public function initializeBD(){
			$this->createBDIfNotExists();
    		$this->createTables();
		}

		public function createTables(){
			$this->createTableCurso();
			$this->createTableUsuario();
			$this->createTableEntidade();
			$this->createTableUsuarioEntidade();
			$this->createTablePost();
			$this->createTableRespostaOficial();
			$this->createTableConversa();
			$this->createTableMensagem();
			$this->createTableRevisao();
			$this->createTableRecoveryPassword();
		}

		public function createTableCurso(){
			$sql = "create table if not exists Curso(
						codigoCurso  					INT 				NOT NULL,
						nome  							VARCHAR(127)		NOT NULL UNIQUE,
							PRIMARY KEY (codigoCurso)
					);";
			$this->query($sql);
		}
		public function createTableUsuario(){
			$sql = "create table if not exists Usuario (
						email  							VARCHAR(127) 		NOT NULL,
						senha 							VARCHAR(255) 		NOT NULL,
						nome  							VARCHAR(127) 		NOT NULL,
						sobrenome  						VARCHAR(127) 		NOT NULL,
						dataNascimento  				DATE 				NOT NULL,
						dataCadastro  					DATETIME 			DEFAULT CURRENT_TIMESTAMP,
						token 							VARCHAR(41)			DEFAULT NULL UNIQUE,
						dataExpiracaoToken				DATETIME  			,
						dataBanimento  					DATE 				,
						motivoBanimento  				TEXT 				,
						emailAdminBanidor  				VARCHAR(127) 		,
						cpf  							VARCHAR(11)			,
						siape  							VARCHAR(9)			,
						codigoCurso  					INT					,
						matricula  						VARCHAR(8)			,
						tipoDeUsuario  					ENUM('ALUNO', 'PROFESSOR', 'FUNCIONARIO', 'COORDENADOR', 'ADMIN'),
						isCoordenador  					BOOL 				NOT NULL DEFAULT FALSE,

							FOREIGN KEY (emailAdminBanidor) REFERENCES Usuario(email)ON UPDATE CASCADE,
							FOREIGN KEY (codigoCurso) REFERENCES Curso(codigoCurso) ON UPDATE CASCADE,	
							PRIMARY KEY  (email)
					);";
			$this->query($sql);
		}

		public function createTableEntidade(){
			$sql = "create table if not exists Entidade(
						codigoEntidade 				 	INT 				AUTO_INCREMENT,
						endereco  						VARCHAR(255) 		NOT NULL,
						descricao  						TEXT 				NOT NULL,
						nome  							VARCHAR(127) 		NOT NULL,
						codigoCurso  					INT 				,

							FOREIGN KEY (codigoCurso) REFERENCES Curso(codigoCurso) ON UPDATE CASCADE,
							PRIMARY KEY (codigoEntidade)
					);";
			$this->query($sql);
		}

		public function createTableUsuarioEntidade(){
			$sql = "create table if not exists UsuarioEntidade (
						codigoEntidade  				INT 				NOT NULL,
						emailResponsavel  				VARCHAR(127) 		NOT NULL,
						dataPosse  						DATETIME 			DEFAULT CURRENT_TIMESTAMP,
						dataSaida						DATETIME 			DEFAULT NULL,

							FOREIGN KEY (codigoEntidade) REFERENCES Entidade(codigoEntidade) ON UPDATE CASCADE,
							FOREIGN KEY (emailResponsavel) REFERENCES Usuario(email) ON UPDATE CASCADE,
							PRIMARY KEY (codigoEntidade,emailResponsavel, dataPosse)
					);";
			$this->query($sql);
		}

		public function createTablePost(){
			$sql = "create table if not exists Post (
						dataCriacao  					DATETIME 			DEFAULT CURRENT_TIMESTAMP,
						mensagem  						TEXT 				NOT NULL,
						emailUsuarioCriador  			VARCHAR(127) 		NOT NULL,
						anonimo  						BOOL 				DEFAULT FALSE,
						dataDelecao  					DATE 				DEFAULT NULL,
						codigoEntidadeMarcada  			INT 				DEFAULT NULL,
						entidadeCriadora				INT 				DEFAULT NULL,
							FOREIGN KEY (entidadeCriadora) REFERENCES Entidade(codigoEntidade) ON UPDATE CASCADE,
							FOREIGN KEY (emailUsuarioCriador) REFERENCES Usuario(email) ON UPDATE CASCADE,
							FOREIGN KEY (codigoEntidadeMarcada) REFERENCES Entidade(codigoEntidade) ON UPDATE CASCADE,
							PRIMARY KEY (dataCriacao,emailUsuarioCriador)
					);";
			$this->query($sql);
		}

		public function createTableRespostaOficial(){
			$sql = "create table if not exists RespostaOficial (
						codigoEntidade  				INT 				NOT NULL,
						dataCriacaoPost  				DATETIME 			NOT NULL,
						emailUsuarioCriadorPost  		VARCHAR(127) 		NOT NULL,
						resposta  						TEXT 				NOT NULL,
						dataCriacaoResposta  			DATETIME 			DEFAULT CURRENT_TIMESTAMP,

							FOREIGN KEY (codigoEntidade) REFERENCES Entidade(codigoEntidade) ON UPDATE CASCADE,
							FOREIGN KEY (dataCriacaoPost) REFERENCES Post(dataCriacao) ON UPDATE CASCADE,
							FOREIGN KEY (emailUsuarioCriadorPost) REFERENCES Post(emailUsuarioCriador) ON UPDATE CASCADE,
							PRIMARY KEY (codigoEntidade, dataCriacaoPost, emailUsuarioCriadorPost)
					);";
			$this->query($sql);
		}

		public function createTableConversa(){
			$sql = "create table if not exists Conversa (
						emailRemetente  				VARCHAR(127) 		NOT NULL,
						emailDestinatario  				VARCHAR(127)		NOT NULL,
						isAnonima  						BOOLEAN				NOT NULL,
						dataCriacao  					DATETIME 			DEFAULT CURRENT_TIMESTAMP,

							FOREIGN KEY (emailRemetente) REFERENCES Usuario(email) ON UPDATE CASCADE,
							FOREIGN KEY (emailDestinatario) REFERENCES Usuario(email) ON UPDATE CASCADE,
							PRIMARY KEY (emailRemetente, emailDestinatario, isAnonima)
					);
					ALTER TABLE Conversa ADD INDEX isAnonima_index (isAnonima);";
			$this->query($sql);
		}

		public function createTableMensagem(){
			$sql = "create table if not exists Mensagem (
						emailRemetente  				VARCHAR(127)		NOT NULL,
						emailDestinatario 				VARCHAR(127)		NOT NULL,
						isAnonima 						BOOLEAN				NOT NULL,
						dataCriacao 					DATETIME 			DEFAULT CURRENT_TIMESTAMP,
						texto  							TEXT 				NOT NULL,
						autor 							VARCHAR(127)		NOT NULL,

							FOREIGN KEY (emailRemetente) REFERENCES Usuario(email) ON UPDATE CASCADE,
							FOREIGN KEY (emailDestinatario) REFERENCES Usuario(email) ON UPDATE CASCADE,
							FOREIGN KEY (isAnonima) REFERENCES Conversa(isAnonima) ON UPDATE CASCADE,
							PRIMARY KEY (emailRemetente, emailDestinatario, isAnonima, dataCriacao)
					);";
			$this->query($sql);
		}

		public function createTableRevisao(){
			$sql = "create table if not exists Revisao (
						emailRemetente 					VARCHAR(127)  		NOT NULL,
						emailDestinatario 				VARCHAR(127)  		NOT NULL,
						isAnonima						BOOL  				NOT NULL,
						emailSolicRevisao 				VARCHAR(127)  		NOT NULL,
						emailRevisor 					VARCHAR(127)  		DEFAULT NULL,
						dataSolicRevisao 				DATETIME 			DEFAULT CURRENT_TIMESTAMP,
						dataRevisao 					DATETIME 			,
						comentarioRevisao  				TEXT  				,
						gravidadeInfracao  				ENUM('LEVE', 'MEDIA', 'GRAVE'),

							FOREIGN KEY (emailRemetente) REFERENCES Conversa(emailRemetente) ON UPDATE CASCADE,
							FOREIGN KEY (emailDestinatario) REFERENCES Conversa(emailDestinatario) ON UPDATE CASCADE,
							FOREIGN KEY (isAnonima) REFERENCES Conversa(isAnonima) ON UPDATE CASCADE,
							PRIMARY KEY (emailRemetente, emailDestinatario, dataSolicRevisao, isAnonima)
					);";
			$this->query($sql);
		}

		public function createTableRecoveryPassword(){
			$sql = "create table if not exists RecoveryPassword (
						token 							VARCHAR(64)			UNIQUE NOT NULL,
						email 							VARCHAR(127)  		UNIQUE NOT NULL,
							FOREIGN KEY (email) REFERENCES Usuario(email) ON UPDATE CASCADE,
							PRIMARY KEY (token)
					);";
			$this->query($sql);
		}

		public function createBDIfNotExists(){
			try{
				$PDO = new PDO('mysql:host=localhost', 'root', '1234');
				return $PDO->exec("CREATE DATABASE IF NOT EXISTS DS DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;");
			}catch (PDOException $e)
			{
			    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
			}
		}

		public function dropDatabase(){
			$this->query("DROP DATABASE DS;");
		}
	}

?>
