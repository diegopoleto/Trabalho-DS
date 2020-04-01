<?php

	namespace Models;

	require_once("Revisao.php");
	require_once("Mensagem.php");

	class Conversa{
		private $codConversa; //PK.
		private $emailRem; //FK.
		private $emailDest; //FK.
		private $isAnonima; //FK.
		private $revisao;
		private $mensagens;
		

		function __construct($emailRem, $emailDest, $anonima=False){
			$this->emailRem = $emailRem;
			$this->emailDest = $emailDest;
			$this->anonima = $anonima;
		}
	    

		public function getMensagens()
	    {
	        return $this->mensagens;
	    }

	    
	    public function setMensagens($mensagem)
	    {
	        $this->mensagens[] = $mensagem;
	    }

	    public function getCodConversa()
	    {
	        return $this->codConversa;
	    }

	    
	    public function setCodConversa($codConversa)
	    {
	        $this->codConversa = $codConversa;
	    }

	    
	    public function getDtCriacao()
	    {
	        return $this->dtCriacao;
	    }

	    
	    public function setDtCriacao($dtCriacao)
	    {
	        $this->dtCriacao = $dtCriacao;
	    }

	    
	    public function getEmailRem()
	    {
	        return $this->emailRem;
	    }

	    
	    public function setEmailRem($emailRem)
	    {
	        $this->emailRem = $emailRem;
	    }

	    
	    public function getEmailDest()
	    {
	        return $this->emailDest;
	    }

	    
	    public function setEmailDest($emailDest)
	    {
	        $this->emailDest = $emailDest;
	    }

	    
	    public function getAnonima()
	    {
	        return $this->anonima;
	    }

	    
	    public function setAnonima($anonima)
	    {
	        $this->anonima = $anonima;
	    }
	}
?>