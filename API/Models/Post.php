<?php

	namespace Models;

	require_once("RespostaOficial.php");

	class Post{
		
		private $dataCriacao; //P.K.
		private $mensagem;
		private $emailUsuarioCriador; //F.K.
		private $isAnonimo;
		private $codigoEntidadeMarcada;
		private $dtDelecao;
		private $respostaOficial;
		private $entidadeCriadora;


		function __construct($mensagem, $emailUsuarioCriador, $isAnonimo = False)
		{
			$this->mensagem = $mensagem;
			$this->emailUsuarioCriador = $emailUsuarioCriador;
			$this->isAnonimo = $isAnonimo;
		}
		
		public function getEntidadeCriadora()
	    {
	        return $this->entidadeCriadora;
	    }

	    
	    public function setEntidadeCriadora($entidadeCriadora)
	    {
	        $this->entidadeCriadora = $entidadeCriadora;
	    }

		public function getRespostaOficial()
	    {
	        return $this->respostaOficial;
	    }

	    
	    public function setRespostaOficial($respostaOficial)
	    {
	        $this->respostaOficial = $respostaOficial;
	    }
     
	    public function getDataCriacao()
	    {
	        return $this->dataCriacao;
	    }

	    
	    public function setDataCriacao($dataCriacao)
	    {
	        $this->dataCriacao = $dataCriacao;
	    }

	    
	    public function getMensagem()
	    {
	        return $this->mensagem;
	    }

	    
	    public function setMensagem($mensagem)
	    {
	        $this->mensagem = $mensagem;
	    }

	    
	    public function getEmailUsuarioCriador()
	    {
	        return $this->emailUsuarioCriador;
	    }

	    
	    public function setEmailUsuarioCriador($emailUsuarioCriador)
	    {
	        $this->emailUsuarioCriador = $emailUsuarioCriador;
	    }


	    public function getDtDelecao()
	    {
	        return $this->dtDelecao;
	    }

	    
	    public function setDtDelecao($dtDelecao)
	    {
	        $this->dtDelecao = $dtDelecao;
	    }

	    public function getIsAnonimo()
	    {
	        return $this->isAnonimo;
	    }

	    
	    public function setIsAnonimo($isAnonimo)
	    {
	        $this->isAnonimo = $isAnonimo;
	    }

	    public function getCodigoEntidadeMarcada()
	    {
	        return $this->codigoEntidadeMarcada;
	    }

	    
	    public function setCodigoEntidadeMarcada($codigoEntidadeMarcada)
	    {
	        $this->codigoEntidadeMarcada = $codigoEntidadeMarcada;
	    }
	}

?>