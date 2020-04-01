<?php

	namespace Models;

	class Usuario{
		private $nome;
		private $sobrenome;
		private $email; //PK.
		private $senha;
		private $dtNasc;
		private $dtCad;
		private $dtBan;
		private $motBan;
		private $emailAdmBan; //FK.
		private $cpf;
		private $siape;
		private $matricula;
		private $codigoCurso;
		private $tpUser;
		private $isCoordenador = false;
		private $token;
		private $dtExpToken;

		function __construct($nome, $sobrenome, $email, $senha, $tpUser, $identificacao){
			$this->nome = $nome;
			$this->sobrenome = $sobrenome;
			$this->email = $email;
			$this->senha = $senha;
			$this->tpUser = $tpUser;
			switch(strtoupper($tpUser)){
				case "ALUNO":
					$this->matricula = $identificacao;
					break;
				case "COORDENADOR":
					$this->isCoordenador = true;
				case "PROFESSOR":
					$this->siape = $identificacao;
					break;
				case "FUNCIONARIO":
					$this->siape = $identificacao;
					break;
				case "ADMIN":
					$this->cpf = $identificacao;
					break;
			}

		}

	    public function getNome()
	    {
	        return $this->nome;
	    }

	    public function setNome($nome)
	    {
	        $this->nome = $nome;
	    }

	    

	    public function getSobrenome()
	    {
	        return $this->sobrenome;
	    }

	    public function setSobrenome($sobrenome)
	    {
	        $this->sobrenome = $sobrenome;
	    }

	    

	    public function getEmail()
	    {
	        return $this->email;
	    }

	    public function setEmail($email)
	    {
	        $this->email = $email;
	    }

	    

	    public function getSenha()
	    {
	        return $this->senha;
	    }

	    public function setSenha($senha)
	    {
	        $this->senha = $senha;
	    }

	    

	    public function getDtNasc()
	    {
	        return $this->dtNasc;
	    }

	    public function setDtNasc($dtNasc)
	    {
	        $this->dtNasc = $dtNasc;
	    }

	    

	    public function getDtCad()
	    {
	        return $this->dtCad;
	    }


	    public function setDtCad($dtCad)
	    {
	        $this->dtCad = $dtCad;
	    }

	    

	    public function getDtBan()
	    {
	        return $this->dtBan;
	    }

	    public function setDtBan($dtBan)
	    {
	        $this->dtBan = $dtBan;
	    }

	    

	    public function getMotBan()
	    {
	        return $this->motBan;
	    }

	    public function setMotBan($motBan)
	    {
	        $this->motBan = $motBan;
	    }

	    

	    public function getEmailAdminBan()
	    {
	        return $this->emailAdmBan;
	    }

	    public function setEmailAdminBan($emailAdmBan)
	    {
	        $this->emailAdmBan = $emailAdmBan;
	    }

	    

	    public function getCpf()
	    {
	        return $this->cpf;
	    }

	    public function setCpf($cpf)
	    {
	        $this->cpf = $cpf;
	    }

	    

	    public function getSiape()
	    {
	        return $this->siape;
	    }

	    public function setSiape($siape)
	    {
	        $this->siape = $siape;
	    }

	    

	    public function getMatricula()
	    {
	        return $this->matricula;
	    }

	    public function setMatricula($matricula)
	    {
	        $this->matricula = $matricula;
	    }

	    

	    public function getCodigoCurso()
	    {
	        return $this->codigoCurso;
	    }

	    public function setCodigoCurso($codigoCurso)
	    {
	        $this->codigoCurso = $codigoCurso;
	    }



	    public function getTpUser()
	    {
	        return $this->tpUser;
	    }

	    public function setTpUser($tpUser)
	    {
	        $this->tpUser = $tpUser;
	    }

	    

	    public function getIsCoordenador()
	    {
	        return $this->isCoordenador;
	    }

	    public function setIsCoordenador($isCoordenador)
	    {
	        $this->isCoordenador = $isCoordenador;
	    }

	    public function getToken()
	    {
	    	return $this->token;
	    }

	    public function setToken($token){
	    	$this->token = $token;
	    }



	    public function getDtExpToken(){
	    	return $this->dtExpToken;
	    }

	    public function setDtExpToken($dtExpToken){
	    	$this->dtExpToken = $dtExpToken;
	    }
	}

?>