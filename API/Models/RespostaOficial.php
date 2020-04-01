<?php

	namespace Models;
	
	class RespostaOficial{
		
		private $codigoEntidade; //F.K. Entidade
		private $dataCriacaoPost; //F.K. Post
		private $emailUsuarioCriadorPost; //F.K. Post
		private $resposta;
		private $dataCriacaoResposta;


		function __construct($codigoEntidade, $dataCriacaoPost, $emailUsuarioCriadorPost, $resposta)
		{
			$this->codigoEntidade = $codigoEntidade;
			$this->dataCriacaoPost = $dataCriacaoPost;
			$this->emailUsuarioCriadorPost = $emailUsuarioCriadorPost;
			$this->resposta = $resposta;
		}
		
	    public function getCodigoEntidade()
	    {
	        return $this->codigoEntidade;
	    }

	    
	    public function setCodigoEntidade($codigoEntidade)
	    {
	        $this->codigoEntidade = $codigoEntidade;
	    }

	    public function getDataCriacaoPost()
	    {
	        return $this->dataCriacaoPost;
	    }

	    
	    public function setDataCriacaoPost($dataCriacaoPost)
	    {
	        $this->dataCriacaoPost = $dataCriacaoPost;
	    }

	    public function getEmailUsuarioCriadorPost()
	    {
	        return $this->emailUsuarioCriadorPost;
	    }

	    
	    public function setEmailUsuarioCriadorPost($emailUsuarioCriadorPost)
	    {
	        $this->emailUsuarioCriadorPost = $emailUsuarioCriadorPost;
	    }

	    
	    public function getResposta()
	    {
	        return $this->resposta;
	    }

	    
	    public function setResposta($resposta)
	    {
	        $this->resposta = $resposta;
	    }

	    
	    public function getDataCriacaoResposta()
	    {
	        return $this->dataCriacaoResposta;
	    }

	    
	    public function setDataCriacaoResposta($dataCriacaoResposta)
	    {
	        $this->dataCriacaoResposta = $dataCriacaoResposta;
	    }
	}
?>